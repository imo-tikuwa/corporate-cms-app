<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Admin;

use App\Controller\Admin\ContactsController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Admin\ContactsController Test Case
 *
 * @uses \App\Controller\Admin\ContactsController
 */
class ContactsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Admins',
        'app.Contacts',
    ];

    /**
     * By default, all fixtures attached to this class will be truncated and reloaded after each test.
     * Set this to false to handle manually
     *
     * @var bool
     */
    public $autoFixtures = false;

    /**
     * contacts table.
     * @var \App\Model\Table\ContactsTable $Contacts
     */
    protected $Contacts;

    /**
     * admins table.
     * @var \App\Model\Table\AdminsTable $Admins
     */
    protected $Admins;

    /**
     * super auth data. (id = 1)
     */
    protected $super_admin;

    /**
     * general auth data. (has read authority)
     */
    protected $read_admin;

    /**
     * general auth data. (has write authority)
     */
    protected $write_admin;

    /**
     * general auth data. (has delete authority)
     */
    protected $delete_admin;

    /**
     * general auth data. (has csv_export authority)
     */
    protected $csv_export_admin;

    /**
     * general auth data. (has excel_export authority)
     */
    protected $excel_export_admin;

    /**
     * general auth data. (No authority)
     */
    protected $no_authority_admin;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->loadFixtures();

        parent::setUp();
        $contacts_config = $this->getTableLocator()->exists('Contacts') ? [] : ['className' => \App\Model\Table\ContactsTable::class];
        /** @var \App\Model\Table\ContactsTable $Contacts */
        $this->Contacts = $this->getTableLocator()->get('Contacts', $contacts_config);

        $admins_config = $this->getTableLocator()->exists('Admins') ? [] : ['className' => \App\Model\Table\AdminsTable::class];
        /** @var \App\Model\Table\AdminsTable $Admins */
        $this->Admins = $this->getTableLocator()->get('Admins', $admins_config);

        /** @var \App\Model\Entity\Admin $super_admin */
        $this->super_admin = $this->Admins->get(SUPER_USER_ID, [
            'finder' => 'auth',
        ]);

        $read_admin = $this->Admins->newEntity([
            'name' => 'READ権限のみ',
            'mail' => 'read@example.com',
            'password' => 'password',
            'use_otp' => '0',
            'privilege' => [
                'Contacts' => [ROLE_READ],
            ]
        ]);
        $this->Admins->save($read_admin);
        /** @var \App\Model\Entity\Admin $read_admin */
        $this->read_admin = $this->Admins->get($read_admin->id, [
            'finder' => 'auth',
        ]);

        $write_admin = $this->Admins->newEntity([
            'name' => 'WRITE権限のみ',
            'mail' => 'write@example.com',
            'password' => 'password',
            'use_otp' => '0',
            'privilege' => [
                'Contacts' => [ROLE_WRITE],
            ]
        ]);
        $this->Admins->save($write_admin);
        /** @var \App\Model\Entity\Admin $write_admin */
        $this->write_admin = $this->Admins->get($write_admin->id, [
            'finder' => 'auth',
        ]);

        $delete_admin = $this->Admins->newEntity([
            'name' => 'DELETE権限のみ',
            'mail' => 'delete@example.com',
            'password' => 'password',
            'use_otp' => '0',
            'privilege' => [
                'Contacts' => [ROLE_DELETE],
            ]
        ]);
        $this->Admins->save($delete_admin);
        /** @var \App\Model\Entity\Admin $delete_admin */
        $this->delete_admin = $this->Admins->get($delete_admin->id, [
            'finder' => 'auth',
        ]);

        $csv_export_admin = $this->Admins->newEntity([
            'name' => 'CSV_EXPORT権限のみ',
            'mail' => 'csv_export@example.com',
            'password' => 'password',
            'use_otp' => '0',
            'privilege' => [
                'Contacts' => [ROLE_CSV_EXPORT],
            ]
        ]);
        $this->Admins->save($csv_export_admin);
        /** @var \App\Model\Entity\Admin $csv_export_admin */
        $this->csv_export_admin = $this->Admins->get($csv_export_admin->id, [
            'finder' => 'auth',
        ]);

        $excel_export_admin = $this->Admins->newEntity([
            'name' => 'EXCEL_EXPORT権限のみ',
            'mail' => 'excel_export@example.com',
            'password' => 'password',
            'use_otp' => '0',
            'privilege' => [
                'Contacts' => [ROLE_EXCEL_EXPORT],
            ]
        ]);
        $this->Admins->save($excel_export_admin);
        /** @var \App\Model\Entity\Admin $excel_export_admin */
        $this->excel_export_admin = $this->Admins->get($excel_export_admin->id, [
            'finder' => 'auth',
        ]);

        $no_authority_admin = $this->Admins->newEntity([
            'name' => '権限なし',
            'mail' => 'no_authority@example.com',
            'password' => 'password',
            'use_otp' => '0',
            'privilege' => [
                'Contacts' => [],
            ]
        ]);
        $this->Admins->save($no_authority_admin);
        /** @var \App\Model\Entity\Admin $no_authority_admin */
        $this->no_authority_admin = $this->Admins->get($no_authority_admin->id, [
            'finder' => 'auth',
        ]);
    }

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex(): void
    {
        $this->get('/admin/contacts');
        $this->assertResponseCode(302);
        $this->assertHeaderContains('location', '/admin/auth/login');

        $this->session([
            'Auth.Admin' => $this->super_admin
        ]);
        $this->get('/admin/contacts');
        $this->assertResponseCode(200);
        $this->assertHeaderContains('Content-Type', 'text/html;');
        $this->assertTextContains('<title>お問い合わせ情報</title>', (string)$this->_response->getBody());

        $this->session([
            'Auth.Admin' => $this->read_admin
        ]);
        $this->get('/admin/contacts');
        $this->assertResponseCode(200);
        $this->assertHeaderContains('Content-Type', 'text/html;');
        $this->assertTextContains('<title>お問い合わせ情報</title>', (string)$this->_response->getBody());

        $this->session([
            'Auth.Admin' => $this->write_admin
        ]);
        $this->get('/admin/contacts');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->delete_admin
        ]);
        $this->get('/admin/contacts');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->csv_export_admin
        ]);
        $this->get('/admin/contacts');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->excel_export_admin
        ]);
        $this->get('/admin/contacts');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->no_authority_admin
        ]);
        $this->get('/admin/contacts');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView(): void
    {
        $this->get('/admin/contacts/view/1');
        $this->assertResponseCode(302);
        $this->assertHeaderContains('location', '/admin/auth/login');

        $this->session([
            'Auth.Admin' => $this->super_admin
        ]);
        $this->get('/admin/contacts/view/1');
        $this->assertResponseCode(200);
        $this->assertHeaderContains('Content-Type', 'text/html;');
        $this->assertTextContains('<title>お問い合わせ情報詳細</title>', (string)$this->_response->getBody());

        $this->session([
            'Auth.Admin' => $this->read_admin
        ]);
        $this->get('/admin/contacts/view/1');
        $this->assertResponseCode(200);
        $this->assertHeaderContains('Content-Type', 'text/html;');
        $this->assertTextContains('<title>お問い合わせ情報詳細</title>', (string)$this->_response->getBody());

        $this->session([
            'Auth.Admin' => $this->write_admin
        ]);
        $this->get('/admin/contacts/view/1');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->delete_admin
        ]);
        $this->get('/admin/contacts/view/1');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->csv_export_admin
        ]);
        $this->get('/admin/contacts/view/1');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->excel_export_admin
        ]);
        $this->get('/admin/contacts/view/1');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->no_authority_admin
        ]);
        $this->get('/admin/contacts/view/1');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd(): void
    {
        $this->get('/admin/contacts/add');
        $this->assertResponseCode(302);
        $this->assertHeaderContains('location', '/admin/auth/login');

        $this->session([
            'Auth.Admin' => $this->super_admin
        ]);
        $this->get('/admin/contacts/add');
        $this->assertResponseCode(200);
        $this->assertHeaderContains('Content-Type', 'text/html;');
        $this->assertTextContains('<title>お問い合わせ情報登録</title>', (string)$this->_response->getBody());

        $this->session([
            'Auth.Admin' => $this->read_admin
        ]);
        $this->get('/admin/contacts/add');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->write_admin
        ]);
        $this->get('/admin/contacts/add');
        $this->assertResponseCode(200);
        $this->assertHeaderContains('Content-Type', 'text/html;');
        $this->assertTextContains('<title>お問い合わせ情報登録</title>', (string)$this->_response->getBody());

        $this->session([
            'Auth.Admin' => $this->delete_admin
        ]);
        $this->get('/admin/contacts/add');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->csv_export_admin
        ]);
        $this->get('/admin/contacts/add');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->excel_export_admin
        ]);
        $this->get('/admin/contacts/add');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->no_authority_admin
        ]);
        $this->get('/admin/contacts/add');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit(): void
    {
        $this->get('/admin/contacts/edit/1');
        $this->assertResponseCode(302);
        $this->assertHeaderContains('location', '/admin/auth/login');

        $this->session([
            'Auth.Admin' => $this->super_admin
        ]);
        $this->get('/admin/contacts/edit/1');
        $this->assertResponseCode(200);
        $this->assertHeaderContains('Content-Type', 'text/html;');
        $this->assertTextContains('<title>お問い合わせ情報更新</title>', (string)$this->_response->getBody());

        $this->session([
            'Auth.Admin' => $this->read_admin
        ]);
        $this->get('/admin/contacts/edit/1');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->write_admin
        ]);
        $this->get('/admin/contacts/edit/1');
        $this->assertResponseCode(200);
        $this->assertHeaderContains('Content-Type', 'text/html;');
        $this->assertTextContains('<title>お問い合わせ情報更新</title>', (string)$this->_response->getBody());

        $this->session([
            'Auth.Admin' => $this->delete_admin
        ]);
        $this->get('/admin/contacts/edit/1');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->csv_export_admin
        ]);
        $this->get('/admin/contacts/edit/1');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->excel_export_admin
        ]);
        $this->get('/admin/contacts/edit/1');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->no_authority_admin
        ]);
        $this->get('/admin/contacts/edit/1');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete(): void
    {
        $this->enableCsrfToken();

        $this->get('/admin/contacts/delete/1');
        $this->assertResponseCode(302);
        $this->assertHeaderContains('location', '/admin/auth/login');

        $this->session([
            'Auth.Admin' => $this->super_admin
        ]);
        $contact = $this->Contacts->get(1);
        $this->assertInstanceOf('\App\Model\Entity\Contact', $contact);
        $this->post('/admin/contacts/delete/1');
        $this->assertResponseCode(302);
        $this->assertSession('お問い合わせ情報の削除が完了しました。', 'Flash.flash.0.message');
        $contact = $this->Contacts->findById(1)->first();
        $this->assertEquals(null, $contact);

        $this->session([
            'Auth.Admin' => $this->read_admin
        ]);
        $this->post('/admin/contacts/delete/1');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->write_admin
        ]);
        $this->post('/admin/contacts/delete/1');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->loadFixtures();
        $this->session([
            'Auth.Admin' => $this->delete_admin
        ]);
        $this->post('/admin/contacts/delete/1');
        $this->assertResponseCode(302);
        $this->assertSession('お問い合わせ情報の削除が完了しました。', 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->csv_export_admin
        ]);
        $this->post('/admin/contacts/delete/1');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->excel_export_admin
        ]);
        $this->post('/admin/contacts/delete/1');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->no_authority_admin
        ]);
        $this->post('/admin/contacts/delete/1');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->cleanup();
        $this->expectException(\Cake\Http\Exception\MethodNotAllowedException::class);
        $this->expectExceptionCode(405);
        $url = new \Cake\Http\ServerRequest([
            'url' => 'admin/contacts/delete/1',
            'params' => [
                'prefix' => 'admin',
                'controller' => 'Contacts',
                'action' => 'delete',
                'pass' => ['1'],
            ]
        ]);
        $response = new \Cake\Http\Response();
        $controller = new ContactsController($url, $response);
        $controller->delete(1);
    }

    /**
     * Test csvExport method
     *
     * @return void
     */
    public function testCsvExport(): void
    {
        $this->get('/admin/contacts/csv-export');
        $this->assertResponseCode(302);
        $this->assertHeaderContains('location', '/admin/auth/login');

        $this->session([
            'Auth.Admin' => $this->super_admin
        ]);
        $this->get('/admin/contacts/csv-export');
        $this->assertResponseCode(200);
        $this->assertHeaderContains('Content-Disposition', 'attachment;');
        $this->assertHeaderContains('Content-Type', 'text/csv;');

        $this->session([
            'Auth.Admin' => $this->read_admin
        ]);
        $this->get('/admin/contacts/csv-export');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->write_admin
        ]);
        $this->get('/admin/contacts/csv-export');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->delete_admin
        ]);
        $this->get('/admin/contacts/csv-export');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->csv_export_admin
        ]);
        $this->get('/admin/contacts/csv-export');
        $this->assertResponseCode(200);
        $this->assertHeaderContains('Content-Disposition', 'attachment;');
        $this->assertHeaderContains('Content-Type', 'text/csv;');

        $this->session([
            'Auth.Admin' => $this->excel_export_admin
        ]);
        $this->get('/admin/contacts/csv-export');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->no_authority_admin
        ]);
        $this->get('/admin/contacts/csv-export');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');
    }

    /**
     * Test excelExport method
     *
     * @return void
     */
    public function testExcelExport(): void
    {
        $this->get('/admin/contacts/excel-export');
        $this->assertResponseCode(302);
        $this->assertHeaderContains('location', '/admin/auth/login');

        $this->session([
            'Auth.Admin' => $this->super_admin
        ]);
        $this->get('/admin/contacts/excel-export');
        $this->assertResponseCode(200);
        $this->assertHeaderContains('Content-Disposition', 'attachment;');
        $this->assertHeaderContains('Content-Type', EXCEL_CONTENT_TYPE);

        $this->session([
            'Auth.Admin' => $this->read_admin
        ]);
        $this->get('/admin/contacts/excel-export');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->write_admin
        ]);
        $this->get('/admin/contacts/excel-export');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->delete_admin
        ]);
        $this->get('/admin/contacts/excel-export');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->csv_export_admin
        ]);
        $this->get('/admin/contacts/excel-export');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->excel_export_admin
        ]);
        $this->get('/admin/contacts/excel-export');
        $this->assertResponseCode(200);
        $this->assertHeaderContains('Content-Disposition', 'attachment;');
        $this->assertHeaderContains('Content-Type', EXCEL_CONTENT_TYPE);

        $this->session([
            'Auth.Admin' => $this->no_authority_admin
        ]);
        $this->get('/admin/contacts/excel-export');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');
    }
}
