<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\Admin\AppController;
use App\Form\SearchForm;
use App\Utils\ExcelUtils;
use Cake\Http\CallbackStream;
use Cake\Utility\Hash;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx as XlsxWriter;
use DateTime;
use DateTimeZone;
use Cake\View\CellTrait;

/**
 * Charges Controller
 *
 * @property \App\Model\Table\ChargesTable $Charges
 *
 * @method \App\Model\Entity\Charge[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ChargesController extends AppController
{
    /** コントローラ内でcellを使用するためのTrait */
    use CellTrait;

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
        $query = $this->Charges->getSearchQuery($request);
        $charges = $this->paginate($query);
        $search_form = new SearchForm();
        $search_form->setData($request);

        $this->set(compact('charges', 'search_form'));
    }

    /**
     * View method
     *
     * @param string|null $id Charge id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $charge = $this->Charges->get($id, [
            'contain' => [
                'ChargeDetails',
            ]
        ]);

        $this->set('charge', $charge);
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
     * @param string|null $id 料金ID
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
     * @param string|null $id 料金ID
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    private function _form($id = null)
    {
        if ($this->getRequest()->getParam('action') == 'edit') {
            $charge = $this->Charges->get($id, [
                'contain' => [
                    'ChargeDetails',
                ]
            ]);
            $this->Charges->touch($charge);
        } else {
            $charge = $this->Charges->newEmptyEntity();
            $charge->charge_details = [];
            for ($i = 0; $i < 1; $i++) {
                $charge->charge_details[] = $this->Charges->ChargeDetails->newEmptyEntity();
            }
        }
        if ($this->getRequest()->is(['patch', 'post', 'put'])) {
            $charge = $this->Charges->patchEntity($charge, $this->getRequest()->getData(), [
                'associated' => [
                    'ChargeDetails',
                ]
            ]);
            if ($charge->hasErrors()) {
                $this->Flash->set(implode('<br />', $charge->getErrorMessages()), [
                    'escape' => false,
                    'element' => 'validation_error',
                ]);
            } else {
                $conn = $this->Charges->getConnection();
                $conn->begin();
                if ($this->Charges->save($charge, ['atomic' => false])) {
                    $conn->commit();
                    $this->Flash->success('料金の登録が完了しました。');

                    return $this->redirect(['action' => 'index', '?' => _code('InitialOrders.Charges')]);
                }
                $conn->rollback();
            }
        }
        $this->set(compact('charge'));
        $this->render('edit');
    }

    /**
     * Delete method
     *
     * @param string|null $id 料金ID
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->getRequest()->allowMethod(['post', 'delete']);
        $entity = $this->Charges->get($id);
        if ($this->Charges->delete($entity)) {
            $this->Flash->success('料金の削除が完了しました。');
        } else {
            $this->Flash->error('エラーが発生しました。');
        }

        return $this->redirect(['action' => 'index', '?' => _code('InitialOrders.Charges')]);
    }

    /**
     * csv export method
     * @return void
     */
    public function csvExport()
    {
        $request = $this->getRequest()->getQueryParams();
        $charges = $this->Charges->getSearchQuery($request)->toArray();
        $extract = [
            // ID
            'id',
            // プラン名
            'name',
            // プラン名下注釈
            'annotation',
            // 作成日時
            function ($row) {
                return $row['created']?->i18nFormat('yyyy-MM-dd HH:mm:ss');
            },
            // 更新日時
            function ($row) {
                return $row['modified']?->i18nFormat('yyyy-MM-dd HH:mm:ss');
            },
        ];

        $datetime = (new DateTime('now', new DateTimeZone('Asia/Tokyo')))->format('YmdHis');
        $this->response = $this->response->withDownload("charges-{$datetime}.csv");
        $this->viewBuilder()->setClassName('CsvView.Csv');
        $this->viewBuilder()->setOptions([
            'serialize' => 'charges',
            'header' => $this->Charges->getCsvHeaders(),
            'extract' => $extract,
            'csvEncoding' => 'UTF-8'
        ]);
        $this->set(compact('charges'));
    }

    /**
     * excel export method
     * @return \Cake\Http\Response
     */
    public function excelExport()
    {
        $request = $this->getRequest()->getQueryParams();
        /** @var \App\Model\Entity\Charge[] $charges */
        $charges = $this->Charges->getSearchQuery($request)->toArray();

        $reader = new XlsxReader();
        $spreadsheet = $reader->load(EXCEL_TEMPLATE_DIR . 'charges_template.xlsx');
        $data_sheet = $spreadsheet->getSheetByName('DATA');
        $row_num = 2;

        // 取得したデータをExcelに書き込む
        foreach ($charges as $charge) {
            // ID
            $data_sheet->setCellValue("A{$row_num}", $charge->id);
            // プラン名
            $data_sheet->setCellValue("B{$row_num}", $charge->name);
            // プラン名下注釈
            $data_sheet->setCellValue("C{$row_num}", $charge->annotation);
            // 作成日時
            $data_sheet->setCellValue("D{$row_num}", $charge->created?->i18nFormat('yyyy-MM-dd HH:mm:ss'));
            // 更新日時
            $data_sheet->setCellValue("E{$row_num}", $charge->modified?->i18nFormat('yyyy-MM-dd HH:mm:ss'));
            $row_num++;
        }

        // データ入力行のフォーマットを文字列に設定
        $charges_row_num = count($charges) + 100;
        $data_sheet->getStyle("A2:E{$charges_row_num}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);


        // 罫線設定、A2セルを選択、1行目固定、DATAシートをアクティブ化
        $data_sheet->getStyle("A1:E{$charges_row_num}")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $data_sheet->setSelectedCell('A2');
        $data_sheet->freezePane('A2');
        $spreadsheet->setActiveSheetIndexByName('DATA');

        $datetime = (new DateTime('now', new DateTimeZone('Asia/Tokyo')))->format('YmdHis');
        $writer = new XlsxWriter($spreadsheet);
        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });

        return $this->response->withHeader('Content-Type', EXCEL_CONTENT_TYPE)
        ->withHeader('Content-Disposition', "attachment; filename=\"charges-{$datetime}.xlsx\"")
        ->withHeader('Cache-Control', 'max-age=0')
        ->withBody($stream);
    }

    /**
     * 料金詳細のフォームを追加する
     * @return \Cake\Http\Response|null
     */
    public function appendChargeDetailRow()
    {
        $this->autoRender = false;
        if ($this->getRequest()->is('ajax') && $this->getRequest()->is('get')) {
            $cell = $this->cell('ChargeDetail', [
                'charge_detail' => $this->Charges->ChargeDetails->newEmptyEntity(),
                'append_index' => $this->getRequest()->getQuery('append_index'),
            ]);

            return $this->getResponse()->withType('html')->withStringBody($cell->render());
        }

        return $this->redirect(['action' => 'index', '?' => _code('InitialOrders.Charges')]);
    }
}
