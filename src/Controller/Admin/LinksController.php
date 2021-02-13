<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\Admin\AppController;
use App\Utils\CsvUtils;
use App\Form\ExcelImportForm;
use App\Form\SearchForm;
use App\Utils\ExcelUtils;
use Cake\Http\CallbackStream;
use Cake\Core\Exception\CakeException;
use Cake\I18n\FrozenDate;
use Cake\I18n\FrozenTime;
use Cake\Utility\Hash;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as XlsxWriter;
use DateTime;
use DateTimeZone;

/**
 * Links Controller
 *
 * @property \App\Model\Table\LinksTable $Links
 *
 * @method \App\Model\Entity\Link[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LinksController extends AppController
{
    /**
     * Paging setting.
     */
    public $paginate = [
        'limit' => 20,
    ];

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $request = $this->getRequest()->getQueryParams();
        $query = $this->Links->getSearchQuery($request);
        $links = $this->paginate($query);
        $search_form = new SearchForm();
        $search_form->setData($request);

        $this->set(compact('links', 'search_form'));
    }

    /**
     * View method
     *
     * @param string|null $id Link id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $link = $this->Links->get($id);

        $this->set('link', $link);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null
     */
    public function add()
    {
        return $this->_form();
    }

    /**
     * Edit method
     *
     * @param string|null $id リンク集ID
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        return $this->_form($id);
    }

    /**
     * Add and Edit Common method
     *
     * @param string|null $id リンク集ID
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    private function _form($id = null)
    {
        if ($this->getRequest()->getParam('action') == 'edit') {
            $link = $this->Links->get($id);
            $this->Links->touch($link);
        } else {
            $link = $this->Links->newEmptyEntity();
        }
        if ($this->getRequest()->is(['patch', 'post', 'put'])) {
            $link = $this->Links->patchEntity($link, $this->getRequest()->getData());
            if ($link->hasErrors()) {
                $this->Flash->set(implode('<br />', $link->getErrorMessages()), [
                    'escape' => false,
                    'element' => 'validation_error',
                ]);
            } else {
                $conn = $this->Links->getConnection();
                $conn->begin();
                if ($this->Links->save($link, ['atomic' => false])) {
                    $conn->commit();
                    $this->Flash->success('リンク集の登録が完了しました。');

                    return $this->redirect(['action' => 'index', '?' => _code('InitialOrders.Links')]);
                }
                $conn->rollback();
            }
        }
        $this->set(compact('link'));
        $this->render('edit');
    }

    /**
     * Delete method
     *
     * @param string|null $id リンク集ID
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->getRequest()->allowMethod(['post', 'delete']);
        $entity = $this->Links->get($id);
        if ($this->Links->delete($entity)) {
            $this->Flash->success('リンク集の削除が完了しました。');
        } else {
            $this->Flash->error('エラーが発生しました。');
        }

        return $this->redirect(['action' => 'index', '?' => _code('InitialOrders.Links')]);
    }

    /**
     * csv export method
     * @return void
     */
    public function csvExport()
    {
        $request = $this->getRequest()->getQueryParams();
        $links = $this->Links->getSearchQuery($request)->toArray();
        $_extract = [
            // ID
            'id',
            // リンクカテゴリ
            function ($row) {
                if (!empty($row['category'])) {
                    return _code('Codes.Links.category.' . $row['category']);
                }

                return "";
            },
            // リンクタイトル
            'title',
            // リンクURL
            'url',
            // リンク説明
            'description',
            // 作成日時
            function ($row) {
                if ($row['created'] instanceof FrozenTime) {
                    return @$row['created']->i18nFormat('yyyy-MM-dd HH:mm:ss');
                }

                return "";
            },
            // 更新日時
            function ($row) {
                if ($row['modified'] instanceof FrozenTime) {
                    return @$row['modified']->i18nFormat('yyyy-MM-dd HH:mm:ss');
                }

                return "";
            },
        ];

        $datetime = (new DateTime('now', new DateTimeZone('Asia/Tokyo')))->format('YmdHis');
        $this->response = $this->response->withDownload("links-{$datetime}.csv");
        $this->viewBuilder()->setClassName('CsvView.Csv');
        $this->viewBuilder()->setOptions([
            'serialize' => 'links',
            'header' => $this->Links->getCsvHeaders(),
            'extract' => $_extract,
            'csvEncoding' => 'UTF-8'
        ]);
        $this->set(compact('links'));
    }

    /**
     * csv import method
     * @return \Cake\Http\Response|NULL
     */
    public function csvImport()
    {
        $csv_import_file = $this->getRequest()->getUploadedFile('csv_import_file');
        if (!is_null($csv_import_file)) {
            $conn = $this->Links->getConnection();
            $conn->begin();
            try {
                $csv_data = CsvUtils::parseUtf8Csv($csv_import_file->getStream()->getMetadata('uri'));
                $insert_count = 0;
                $update_count = 0;
                foreach ($csv_data as $index => $csv_row) {
                    if ($index == 0) {
                        if ($this->Links->getCsvHeaders() != $csv_row) {
                            throw new CakeException('HeaderCheckError');
                        }
                        continue;
                    }

                    $link = $this->Links->createEntityByCsvRow($csv_row);
                    if ($link->isNew()) {
                        $insert_count++;
                    } else {
                        $update_count++;
                    }
                    if (!$this->Links->save($link, ['atomic' => false])) {
                        throw new CakeException('SaveError');
                    }
                }
                if (!$conn->commit()) {
                    throw new CakeException('CommitError');
                }
                $this->Flash->success("リンク集CSVの登録が完了しました。<br />新規：{$insert_count}件<br />更新：{$update_count}件", ['escape' => false]);
            } catch (CakeException $e) {
                $error_message = 'リンク集CSVの登録でエラーが発生しました。';
                if (!empty($e->getMessage())) {
                    $error_message .= "(" . $e->getMessage() . ")";
                }
                $this->Flash->error($error_message);
                $conn->rollback();
            }
        }

        return $this->redirect(['action' => 'index', '?' => _code('InitialOrders.Links')]);
    }

    /**
     * excel export method
     * @return \Cake\Http\Response
     */
    public function excelExport()
    {
        $request = $this->getRequest()->getQueryParams();
        /** @var \App\Model\Entity\Link[] $links */
        $links = $this->Links->getSearchQuery($request)->toArray();

        $reader = new XlsxReader();
        $spreadsheet = $reader->load(EXCEL_TEMPLATE_DIR . 'links_template.xlsx');
        $data_sheet = $spreadsheet->getSheetByName('DATA');
        $row_num = 2;

        // 取得したデータをExcelに書き込む
        foreach ($links as $link) {
            // ID
            $data_sheet->setCellValue("A{$row_num}", $link->id);
            // リンクカテゴリ
            $cell_value = '';
            if (isset($link->category) && array_key_exists($link->category, _code('Codes.Links.category'))) {
                $cell_value = $link->category . ':' . _code('Codes.Links.category.' . $link->category);
            }
            $data_sheet->setCellValue("B{$row_num}", $cell_value);
            // リンクタイトル
            $data_sheet->setCellValue("C{$row_num}", $link->title);
            // リンクURL
            $data_sheet->setCellValue("D{$row_num}", $link->url);
            // リンク説明
            $data_sheet->setCellValue("E{$row_num}", $link->description);
            // 作成日時
            $cell_value = @$link->created->i18nFormat('yyyy-MM-dd HH:mm:ss');
            $data_sheet->setCellValue("F{$row_num}", $cell_value);
            // 更新日時
            $cell_value = @$link->modified->i18nFormat('yyyy-MM-dd HH:mm:ss');
            $data_sheet->setCellValue("G{$row_num}", $cell_value);
            $row_num++;
        }

        // データ入力行のフォーマットを文字列に設定
        $links_row_num = count($links) + 100;
        $data_sheet->getStyle("A2:G{$links_row_num}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);

        // データ入力行に入力規則を設定（1048576はExcelの最大行数）
        // リンクカテゴリ
        $data_sheet->setDataValidation('B2:B1048576', ExcelUtils::getDataValidation("=OFFSET('LIST'!\$A\$2,0,0,COUNTA('LIST'!\$A:\$A)-1,1)"));

        // 罫線設定、A2セルを選択、1行目固定、DATAシートをアクティブ化
        $data_sheet->getStyle("A1:G{$links_row_num}")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $data_sheet->setSelectedCell('A2');
        $data_sheet->freezePane('A2');
        $spreadsheet->setActiveSheetIndexByName('DATA');

        $datetime = (new DateTime('now', new DateTimeZone('Asia/Tokyo')))->format('YmdHis');
        $writer = new XlsxWriter($spreadsheet);
        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });

        return $this->response->withHeader('Content-Type', EXCEL_CONTENT_TYPE)
        ->withHeader('Content-Disposition', "attachment; filename=\"links-{$datetime}.xlsx\"")
        ->withHeader('Cache-Control', 'max-age=0')
        ->withBody($stream);
    }

    /**
     * excel import method
     * @return \Cake\Http\Response|NULL
     */
    public function excelImport()
    {
        if ($this->getRequest()->is(['post'])) {
            $form = new ExcelImportForm('Links');
            if (!$form->validate($this->getRequest()->getData())) {
                $this->Flash->error(implode('<br />', $form->getErrorMessages()), ['escape' => false]);
                return $this->redirect(['action' => 'index', '?' => _code('InitialOrders.Links')]);
            }

            try {
                $conn = $this->Links->getConnection();
                $conn->begin();

                $data_sheet = $form->getSpreadsheet()->getSheetByName('DATA');
                $data_sheet_info = $data_sheet->getHighestRowAndColumn();
                $insert_count = $update_count = 0;
                for ($row_num = 2; $row_num <= $data_sheet_info['row']; $row_num++) {
                    $excel_row = $data_sheet->rangeToArray("A{$row_num}:{$data_sheet_info['column']}{$row_num}", '')[0];
                    if (empty(array_filter($excel_row))) {
                        continue;
                    }

                    $link = $this->Links->createEntityByExcelRow($excel_row);
                    $link->isNew() ? $insert_count++ : $update_count++;
                    if (!$this->Links->save($link, ['atomic' => false])) {
                        throw new CakeException('SaveError');
                    }
                }
                if (!$conn->commit()) {
                    throw new CakeException('CommitError');
                }
                $this->Flash->success("リンク集Excelの登録が完了しました。<br />新規：{$insert_count}件<br />更新：{$update_count}件", ['escape' => false]);
            } catch (CakeException $e) {
                $error_message = 'リンク集Excelの登録でエラーが発生しました。';
                if (!empty($e->getMessage())) {
                    $error_message .= "(" . $e->getMessage() . ")";
                }
                $this->Flash->error($error_message);
                $conn->rollback();
            }
        }

        return $this->redirect(['action' => 'index', '?' => _code('InitialOrders.Links')]);
    }
}
