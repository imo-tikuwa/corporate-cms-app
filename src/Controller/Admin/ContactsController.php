<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\Admin\AppController;
use App\Form\SearchForm;
use App\Utils\ExcelUtils;
use Cake\Http\CallbackStream;
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
 * Contacts Controller
 *
 * @property \App\Model\Table\ContactsTable $Contacts
 *
 * @method \App\Model\Entity\Contact[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ContactsController extends AppController
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
        $query = $this->Contacts->getSearchQuery($request);
        $contacts = $this->paginate($query);
        $search_form = new SearchForm();
        $search_form->setData($request);

        $this->set(compact('contacts', 'search_form'));
    }

    /**
     * View method
     *
     * @param string|null $id Contact id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $contact = $this->Contacts->get($id);

        $this->set('contact', $contact);
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
     * @param string|null $id お問い合わせ情報ID
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
     * @param string|null $id お問い合わせ情報ID
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    private function _form($id = null)
    {
        if ($this->getRequest()->getParam('action') == 'edit') {
            $contact = $this->Contacts->get($id);
            $this->Contacts->touch($contact);
        } else {
            $contact = $this->Contacts->newEmptyEntity();
        }
        if ($this->getRequest()->is(['patch', 'post', 'put'])) {
            $contact = $this->Contacts->patchEntity($contact, $this->getRequest()->getData());
            if ($contact->hasErrors()) {
                $this->Flash->set(implode('<br />', $contact->getErrorMessages()), [
                    'escape' => false,
                    'element' => 'validation_error',
                ]);
            } else {
                $conn = $this->Contacts->getConnection();
                $conn->begin();
                if ($this->Contacts->save($contact, ['atomic' => false])) {
                    $conn->commit();
                    $this->Flash->success('お問い合わせ情報の登録が完了しました。');

                    return $this->redirect(['action' => 'index', '?' => _code('InitialOrders.Contacts')]);
                }
                $conn->rollback();
            }
        }
        $this->set(compact('contact'));
        $this->render('edit');
    }

    /**
     * Delete method
     *
     * @param string|null $id お問い合わせ情報ID
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->getRequest()->allowMethod(['post', 'delete']);
        $entity = $this->Contacts->get($id);
        if ($this->Contacts->delete($entity)) {
            $this->Flash->success('お問い合わせ情報の削除が完了しました。');
        } else {
            $this->Flash->error('エラーが発生しました。');
        }

        return $this->redirect(['action' => 'index', '?' => _code('InitialOrders.Contacts')]);
    }

    /**
     * csv export method
     * @return void
     */
    public function csvExport()
    {
        $request = $this->getRequest()->getQueryParams();
        $contacts = $this->Contacts->getSearchQuery($request)->toArray();
        $extract = [
            // ID
            'id',
            // お名前
            'name',
            // メールアドレス
            'email',
            // お問い合わせ内容
            function ($row) {
                if (!empty($row['type'])) {
                    return _code('Codes.Contacts.type.' . $row['type']);
                }

                return "";
            },
            // お電話番号
            'tel',
            // ご希望日時／その他ご要望等
            'content',
            // ホームページURL
            'hp_url',
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
        $this->response = $this->response->withDownload("contacts-{$datetime}.csv");
        $this->viewBuilder()->setClassName('CsvView.Csv');
        $this->viewBuilder()->setOptions([
            'serialize' => 'contacts',
            'header' => $this->Contacts->getCsvHeaders(),
            'extract' => $extract,
            'csvEncoding' => 'UTF-8'
        ]);
        $this->set(compact('contacts'));
    }

    /**
     * excel export method
     * @return \Cake\Http\Response
     */
    public function excelExport()
    {
        $request = $this->getRequest()->getQueryParams();
        /** @var \App\Model\Entity\Contact[] $contacts */
        $contacts = $this->Contacts->getSearchQuery($request)->toArray();

        $reader = new XlsxReader();
        $spreadsheet = $reader->load(EXCEL_TEMPLATE_DIR . 'contacts_template.xlsx');
        $data_sheet = $spreadsheet->getSheetByName('DATA');
        $row_num = 2;

        // 取得したデータをExcelに書き込む
        foreach ($contacts as $contact) {
            // ID
            $data_sheet->setCellValue("A{$row_num}", $contact->id);
            // お名前
            $data_sheet->setCellValue("B{$row_num}", $contact->name);
            // メールアドレス
            $data_sheet->setCellValue("C{$row_num}", $contact->email);
            // お問い合わせ内容
            $cell_value = '';
            if (isset($contact->type) && array_key_exists($contact->type, _code('Codes.Contacts.type'))) {
                $cell_value = $contact->type . ':' . _code('Codes.Contacts.type.' . $contact->type);
            }
            $data_sheet->setCellValue("D{$row_num}", $cell_value);
            // お電話番号
            $data_sheet->setCellValue("E{$row_num}", $contact->tel);
            // ご希望日時／その他ご要望等
            $data_sheet->setCellValue("F{$row_num}", $contact->content);
            // ホームページURL
            $data_sheet->setCellValue("G{$row_num}", $contact->hp_url);
            // 作成日時
            $cell_value = ($contact->created instanceof FrozenTime) ? $contact->created->i18nFormat('yyyy-MM-dd HH:mm:ss') : null;
            $data_sheet->setCellValue("H{$row_num}", $cell_value);
            // 更新日時
            $cell_value = ($contact->modified instanceof FrozenTime) ? $contact->modified->i18nFormat('yyyy-MM-dd HH:mm:ss') : null;
            $data_sheet->setCellValue("I{$row_num}", $cell_value);
            $row_num++;
        }

        // データ入力行のフォーマットを文字列に設定
        $contacts_row_num = count($contacts) + 100;
        $data_sheet->getStyle("A2:I{$contacts_row_num}")->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_TEXT);

        // データ入力行に入力規則を設定（1048576はExcelの最大行数）
        // お問い合わせ内容
        $data_sheet->setDataValidation('D2:D1048576', ExcelUtils::getDataValidation("=OFFSET('LIST'!\$A\$2,0,0,COUNTA('LIST'!\$A:\$A)-1,1)"));

        // 罫線設定、A2セルを選択、1行目固定、DATAシートをアクティブ化
        $data_sheet->getStyle("A1:I{$contacts_row_num}")->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
        $data_sheet->setSelectedCell('A2');
        $data_sheet->freezePane('A2');
        $spreadsheet->setActiveSheetIndexByName('DATA');

        $datetime = (new DateTime('now', new DateTimeZone('Asia/Tokyo')))->format('YmdHis');
        $writer = new XlsxWriter($spreadsheet);
        $stream = new CallbackStream(function () use ($writer) {
            $writer->save('php://output');
        });

        return $this->response->withHeader('Content-Type', EXCEL_CONTENT_TYPE)
        ->withHeader('Content-Disposition', "attachment; filename=\"contacts-{$datetime}.xlsx\"")
        ->withHeader('Cache-Control', 'max-age=0')
        ->withBody($stream);
    }
}
