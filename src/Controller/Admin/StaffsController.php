<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\Admin\AppController;
use App\Utils\ExcelUtils;
use Cake\Http\CallbackStream;
use Cake\I18n\FrozenDate;
use Cake\I18n\FrozenTime;
use Cake\Utility\Hash;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as XlsxWriter;

/**
 * Staffs Controller
 *
 * @property \App\Model\Table\StaffsTable $Staffs
 *
 * @method \App\Model\Entity\Staff[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class StaffsController extends AppController
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
        $this->set('params', $request);
        $query = $this->_getQuery($request);
        $staffs = $this->paginate($query);

        $this->set(compact('staffs'));
    }

    /**
     * ページネートに渡すクエリオブジェクトを生成する
     * @param array $request リクエスト情報
     * @return \Cake\ORM\Query $query
     */
    private function _getQuery($request)
    {
        $query = $this->Staffs->find();
        // ID
        if (isset($request['id']) && !is_null($request['id']) && $request['id'] !== '') {
            $query->where([$this->Staffs->aliasField('id') => $request['id']]);
        }
        // スタッフ名
        if (isset($request['name']) && !is_null($request['name']) && $request['name'] !== '') {
            $query->where([$this->Staffs->aliasField('name LIKE') => "%{$request['name']}%"]);
        }
        // スタッフ名(英)
        if (isset($request['name_en']) && !is_null($request['name_en']) && $request['name_en'] !== '') {
            $query->where([$this->Staffs->aliasField('name_en LIKE') => "%{$request['name_en']}%"]);
        }
        // スタッフ役職
        if (isset($request['staff_position']) && !is_null($request['staff_position']) && $request['staff_position'] !== '') {
            $query->where([$this->Staffs->aliasField('staff_position') => $request['staff_position']]);
        }
        // 画像表示位置
        if (isset($request['photo_position']) && !is_null($request['photo_position']) && $request['photo_position'] !== '') {
            $query->where([$this->Staffs->aliasField('photo_position') => $request['photo_position']]);
        }
        // スタッフ説明1
        if (isset($request['description1']) && !is_null($request['description1']) && $request['description1'] !== '') {
            $query->where([$this->Staffs->aliasField('description1') => $request['description1']]);
        }
        // 見出し1
        if (isset($request['midashi1']) && !is_null($request['midashi1']) && $request['midashi1'] !== '') {
            $query->where([$this->Staffs->aliasField('midashi1 LIKE') => "%{$request['midashi1']}%"]);
        }
        // スタッフ説明2
        if (isset($request['description2']) && !is_null($request['description2']) && $request['description2'] !== '') {
            $query->where([$this->Staffs->aliasField('description2') => $request['description2']]);
        }
        // フリーワード
        if (isset($request['search_snippet']) && !is_null($request['search_snippet']) && $request['search_snippet'] !== '') {
            $search_snippet_conditions = [];
            foreach (explode(' ', str_replace('　', ' ', $request['search_snippet'])) as $search_snippet) {
                $search_snippet_conditions[] = [$this->Staffs->aliasField('search_snippet LIKE') => "%{$search_snippet}%"];
            }
            if (isset($request['search_snippet_format']) && $request['search_snippet_format'] == 'AND') {
                $query->where($search_snippet_conditions);
            } else {
                $query->where(function ($exp) use ($search_snippet_conditions) {
                    return $exp->or($search_snippet_conditions);
                });
            }
        }

        return $query;
    }

    /**
     * View method
     *
     * @param string|null $id Staff id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $staff = $this->Staffs->get($id);

        $this->set('staff', $staff);
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
     * @param string|null $id スタッフID
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
     * @param string|null $id スタッフID
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    private function _form($id = null)
    {
        if ($this->getRequest()->getParam('action') == 'edit') {
            $staff = $this->Staffs->get($id);
            $this->Staffs->touch($staff);
        } else {
            $staff = $this->Staffs->newEmptyEntity();
        }
        if ($this->getRequest()->is(['patch', 'post', 'put'])) {
            $staff = $this->Staffs->patchEntity($staff, $this->getRequest()->getData());
            if (!$staff->hasErrors()) {
                $conn = $this->Staffs->getConnection();
                $conn->begin();
                if ($this->Staffs->save($staff, ['atomic' => false])) {
                    $conn->commit();
                    $this->Flash->success('スタッフの登録が完了しました。');

                    return $this->redirect(['action' => 'index', '?' => _code('InitialOrders.Staffs')]);
                }
                $conn->rollback();
            }
        }
        $this->set(compact('staff'));
        $this->render('edit');
    }

    /**
     * Delete method
     *
     * @param string|null $id スタッフID
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->getRequest()->allowMethod(['post', 'delete']);
        $entity = $this->Staffs->get($id);
        if ($this->Staffs->delete($entity)) {
            $this->Flash->success('スタッフの削除が完了しました。');
        } else {
            $this->Flash->error('エラーが発生しました。');
        }

        return $this->redirect(['action' => 'index', '?' => _code('InitialOrders.Staffs')]);
    }

    /**
     * csv export method
     * @return void
     */
    public function csvExport()
    {
        $request = $this->getRequest()->getQueryParams();
        $staffs = $this->_getQuery($request)->toArray();
        $_extract = [
            // ID
            'id',
            // スタッフ名
            'name',
            // スタッフ名(英)
            'name_en',
            // スタッフ役職
            function ($row) {
                if (!empty($row['staff_position'])) {
                    return _code('Codes.Staffs.staff_position.' . $row['staff_position']);
                }

                return "";
            },
            // 画像表示位置
            function ($row) {
                if (!empty($row['photo_position'])) {
                    return _code('Codes.Staffs.photo_position.' . $row['photo_position']);
                }

                return "";
            },
            // スタッフ説明1
            'description1',
            // 見出し1
            'midashi1',
            // スタッフ説明2
            'description2',
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

        $datetime = new \DateTime();
        $datetime->setTimezone(new \DateTimeZone('Asia/Tokyo'));

        $this->response = $this->response->withDownload("staffs-{$datetime->format('YmdHis')}.csv");
        $this->viewBuilder()->setClassName('CsvView.Csv');
        $this->viewBuilder()->setOptions([
            'serialize' => 'staffs',
            'header' => $this->Staffs->getCsvHeaders(),
            'extract' => $_extract,
            'csvEncoding' => 'UTF-8'
        ]);
        $this->set(compact('staffs'));
    }

    /**
     * excel export method
     * @return \Cake\Http\Response
     */
    public function excelExport()
    {
        $request = $this->getRequest()->getQueryParams();
        $staffs = $this->_getQuery($request)->toArray();

        $reader = new XlsxReader();
        $spreadsheet = $reader->load(EXCEL_TEMPLATE_DIR . 'staffs_template.xlsx');
        $data_sheet = $spreadsheet->getSheetByName('DATA');
        $row_num = 2;

        // 取得したデータをExcelに書き込む
        foreach ($staffs as $staff) {
            // ID
            $data_sheet->setCellValue("A{$row_num}", $staff['id']);
            // スタッフ名
            $data_sheet->setCellValue("B{$row_num}", $staff['name']);
            // スタッフ名(英)
            $data_sheet->setCellValue("C{$row_num}", $staff['name_en']);
            // スタッフ役職
            $cell_value = "";
            if (isset($staff['staff_position']) && array_key_exists($staff['staff_position'], _code('Codes.Staffs.staff_position'))) {
                $cell_value = $staff['staff_position'] . ':' . _code('Codes.Staffs.staff_position.' . $staff['staff_position']);
            }
            $data_sheet->setCellValue("D{$row_num}", $cell_value);
            // 画像表示位置
            $cell_value = "";
            if (isset($staff['photo_position']) && array_key_exists($staff['photo_position'], _code('Codes.Staffs.photo_position'))) {
                $cell_value = $staff['photo_position'] . ':' . _code('Codes.Staffs.photo_position.' . $staff['photo_position']);
            }
            $data_sheet->setCellValue("E{$row_num}", $cell_value);
            // スタッフ説明1
            $data_sheet->setCellValue("F{$row_num}", $staff['description1']);
            // 見出し1
            $data_sheet->setCellValue("G{$row_num}", $staff['midashi1']);
            // スタッフ説明2
            $data_sheet->setCellValue("H{$row_num}", $staff['description2']);
            // 作成日時
            $cell_value = @$staff['created']->i18nFormat('yyyy-MM-dd HH:mm:ss');
            $data_sheet->setCellValue("I{$row_num}", $cell_value);
            // 更新日時
            $cell_value = @$staff['modified']->i18nFormat('yyyy-MM-dd HH:mm:ss');
            $data_sheet->setCellValue("J{$row_num}", $cell_value);
            $row_num++;
        }

        // データ入力行のフォーマットを文字列に設定
        $staffs_row_num = count($staffs) + 100;
        $data_sheet->getStyle("A2:J{$staffs_row_num}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);

        // データ入力行に入力規則を設定（1048576はExcelの最大行数）
        // スタッフ役職
        $data_sheet->setDataValidation("D2:D1048576", ExcelUtils::getDataValidation("=OFFSET('LIST'!\$A\$2,0,0,COUNTA('LIST'!\$A:\$A)-1,1)"));
        // 画像表示位置
        $data_sheet->setDataValidation("E2:E1048576", ExcelUtils::getDataValidation("=OFFSET('LIST'!\$B\$2,0,0,COUNTA('LIST'!\$B:\$B)-1,1)"));

        // 罫線設定、A2セルを選択、1行目固定、DATAシートをアクティブ化
        $data_sheet->getStyle("A1:J{$staffs_row_num}")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $data_sheet->setSelectedCell('A2');
        $data_sheet->freezePane('A2');
        $spreadsheet->setActiveSheetIndexByName('DATA');

        $datetime = new \DateTime();
        $datetime->setTimezone(new \DateTimeZone('Asia/Tokyo'));
        $writer = new XlsxWriter($spreadsheet);
        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });

        return $this->response->withHeader('Content-Type', EXCEL_CONTENT_TYPE)
        ->withHeader('Content-Disposition', "attachment; filename=\"staffs-{$datetime->format('YmdHis')}.xlsx\"")
        ->withHeader('Cache-Control', 'max-age=0')
        ->withBody($stream);
    }
}
