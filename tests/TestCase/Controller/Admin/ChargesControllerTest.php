<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Admin;

use App\Controller\Admin\ChargesController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Admin\ChargesController Test Case
 *
 * @uses \App\Controller\Admin\ChargesController
 */
class ChargesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Admins',
        'app.Charges',
        'app.ChargeRelations',
    ];

    /**
     * charges table.
     * @var \App\Model\Table\ChargesTable $Charges
     */
    protected $Charges;

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
        parent::setUp();
        $Charges_config = $this->getTableLocator()->exists('Charges') ? [] : ['className' => \App\Model\Table\ChargesTable::class];
        /** @var \App\Model\Table\ChargesTable $Charges */
        $this->Charges = $this->getTableLocator()->get('Charges', $Charges_config);

        $admins_config = $this->getTableLocator()->exists('Admins') ? [] : ['className' => \App\Model\Table\AdminsTable::class];
        /** @var \App\Model\Table\AdminsTable $Admins */
        $this->Admins = $this->getTableLocator()->get('Admins', $admins_config);

        $super_admin = $this->Admins->newEntity([
            'id' => SUPER_USER_ID,
            'mail' => 'admin@example.com',
            'password' => 'password',
        ]);
        $this->Admins->save($super_admin);
        /** @var \App\Model\Entity\Admin $super_admin */
        $this->super_admin = $this->Admins->get(SUPER_USER_ID, [
            'finder' => 'auth',
        ]);

        $read_admin = $this->Admins->newEntity([
            'mail' => 'read@example.com',
            'password' => 'password',
            'privilege' => [
                'Charges' => [ROLE_READ],
            ]
        ]);
        $this->Admins->save($read_admin);
        /** @var \App\Model\Entity\Admin $read_admin */
        $this->read_admin = $this->Admins->get($read_admin->id, [
            'finder' => 'auth',
        ]);

        $write_admin = $this->Admins->newEntity([
            'mail' => 'write@example.com',
            'password' => 'password',
            'privilege' => [
                'Charges' => [ROLE_WRITE],
            ]
        ]);
        $this->Admins->save($write_admin);
        /** @var \App\Model\Entity\Admin $write_admin */
        $this->write_admin = $this->Admins->get($write_admin->id, [
            'finder' => 'auth',
        ]);

        $delete_admin = $this->Admins->newEntity([
            'mail' => 'delete@example.com',
            'password' => 'password',
            'privilege' => [
                'Charges' => [ROLE_DELETE],
            ]
        ]);
        $this->Admins->save($delete_admin);
        /** @var \App\Model\Entity\Admin $delete_admin */
        $this->delete_admin = $this->Admins->get($delete_admin->id, [
            'finder' => 'auth',
        ]);

        $csv_export_admin = $this->Admins->newEntity([
            'mail' => 'csv_export@example.com',
            'password' => 'password',
            'privilege' => [
                'Charges' => [ROLE_CSV_EXPORT],
            ]
        ]);
        $this->Admins->save($csv_export_admin);
        /** @var \App\Model\Entity\Admin $csv_export_admin */
        $this->csv_export_admin = $this->Admins->get($csv_export_admin->id, [
            'finder' => 'auth',
        ]);

        $excel_export_admin = $this->Admins->newEntity([
            'mail' => 'excel_export@example.com',
            'password' => 'password',
            'privilege' => [
                'Charges' => [ROLE_EXCEL_EXPORT],
            ]
        ]);
        $this->Admins->save($excel_export_admin);
        /** @var \App\Model\Entity\Admin $excel_export_admin */
        $this->excel_export_admin = $this->Admins->get($excel_export_admin->id, [
            'finder' => 'auth',
        ]);

        $no_authority_admin = $this->Admins->newEntity([
            'mail' => 'no_authority@example.com',
            'password' => 'password',
            'privilege' => [
                'Charges' => [],
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
        $this->get('/admin/charges');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->super_admin
        ]);
        $this->get('/admin/charges');
        $this->assertResponseCode(200);
        $this->assertHeaderContains('Content-Type', 'text/html;');
        $this->assertTextContains('<title>基本料金</title>', (string)$this->_response->getBody());

        $this->session([
            'Auth.Admin' => $this->read_admin
        ]);
        $this->get('/admin/charges');
        $this->assertResponseCode(200);
        $this->assertHeaderContains('Content-Type', 'text/html;');
        $this->assertTextContains('<title>基本料金</title>', (string)$this->_response->getBody());

        $this->session([
            'Auth.Admin' => $this->write_admin
        ]);
        $this->get('/admin/charges');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->delete_admin
        ]);
        $this->get('/admin/charges');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->csv_export_admin
        ]);
        $this->get('/admin/charges');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->excel_export_admin
        ]);
        $this->get('/admin/charges');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->no_authority_admin
        ]);
        $this->get('/admin/charges');
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
        $this->get('/admin/charges/view/1');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->super_admin
        ]);
        $this->get('/admin/charges/view/1');
        $this->assertResponseCode(200);
        $this->assertHeaderContains('Content-Type', 'text/html;');
        $this->assertTextContains('<title>基本料金詳細</title>', (string)$this->_response->getBody());

        $this->session([
            'Auth.Admin' => $this->read_admin
        ]);
        $this->get('/admin/charges/view/1');
        $this->assertResponseCode(200);
        $this->assertHeaderContains('Content-Type', 'text/html;');
        $this->assertTextContains('<title>基本料金詳細</title>', (string)$this->_response->getBody());

        $this->session([
            'Auth.Admin' => $this->write_admin
        ]);
        $this->get('/admin/charges/view/1');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->delete_admin
        ]);
        $this->get('/admin/charges/view/1');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->csv_export_admin
        ]);
        $this->get('/admin/charges/view/1');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->excel_export_admin
        ]);
        $this->get('/admin/charges/view/1');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->no_authority_admin
        ]);
        $this->get('/admin/charges/view/1');
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
        $this->get('/admin/charges/add');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->super_admin
        ]);
        $this->get('/admin/charges/add');
        $this->assertResponseCode(200);
        $this->assertHeaderContains('Content-Type', 'text/html;');
        $this->assertTextContains('<title>基本料金登録</title>', (string)$this->_response->getBody());

        $this->session([
            'Auth.Admin' => $this->read_admin
        ]);
        $this->get('/admin/charges/add');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->write_admin
        ]);
        $this->get('/admin/charges/add');
        $this->assertResponseCode(200);
        $this->assertHeaderContains('Content-Type', 'text/html;');
        $this->assertTextContains('<title>基本料金登録</title>', (string)$this->_response->getBody());

        $this->session([
            'Auth.Admin' => $this->delete_admin
        ]);
        $this->get('/admin/charges/add');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->csv_export_admin
        ]);
        $this->get('/admin/charges/add');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->excel_export_admin
        ]);
        $this->get('/admin/charges/add');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->no_authority_admin
        ]);
        $this->get('/admin/charges/add');
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
        $this->get('/admin/charges/edit/1');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->super_admin
        ]);
        $this->get('/admin/charges/edit/1');
        $this->assertResponseCode(200);
        $this->assertHeaderContains('Content-Type', 'text/html;');
        $this->assertTextContains('<title>基本料金更新</title>', (string)$this->_response->getBody());

        $this->session([
            'Auth.Admin' => $this->read_admin
        ]);
        $this->get('/admin/charges/edit/1');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->write_admin
        ]);
        $this->get('/admin/charges/edit/1');
        $this->assertResponseCode(200);
        $this->assertHeaderContains('Content-Type', 'text/html;');
        $this->assertTextContains('<title>基本料金更新</title>', (string)$this->_response->getBody());

        $this->session([
            'Auth.Admin' => $this->delete_admin
        ]);
        $this->get('/admin/charges/edit/1');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->csv_export_admin
        ]);
        $this->get('/admin/charges/edit/1');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->excel_export_admin
        ]);
        $this->get('/admin/charges/edit/1');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->no_authority_admin
        ]);
        $this->get('/admin/charges/edit/1');
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

        $this->get('/admin/charges/delete/1');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->super_admin
        ]);
        $charge = $this->Charges->get(1);
        $this->assertInstanceOf('\App\Model\Entity\Charge', $charge);
        $this->post('/admin/charges/delete/1');
        $this->assertResponseCode(302);
        $this->assertSession('基本料金の削除が完了しました。', 'Flash.flash.0.message');
        $charge = $this->Charges->findById(1)->first();
        $this->assertEquals(null, $charge);

        $this->session([
            'Auth.Admin' => $this->read_admin
        ]);
        $this->post('/admin/charges/delete/1');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->write_admin
        ]);
        $this->post('/admin/charges/delete/1');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->loadFixtures('Charges');
        $this->session([
            'Auth.Admin' => $this->delete_admin
        ]);
        $this->post('/admin/charges/delete/1');
        $this->assertResponseCode(302);
        $this->assertSession('基本料金の削除が完了しました。', 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->csv_export_admin
        ]);
        $this->post('/admin/charges/delete/1');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->excel_export_admin
        ]);
        $this->post('/admin/charges/delete/1');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->no_authority_admin
        ]);
        $this->post('/admin/charges/delete/1');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');
    }

    /**
     * Test to throw an exception in get request with "delete method"
     *
     * @return void
     */
    public function testDeleteIfGetRequest(): void
    {
        $this->expectException(\Cake\Http\Exception\MethodNotAllowedException::class);
        $this->expectExceptionCode(405);
        $url = new \Cake\Http\ServerRequest([
            'url' => 'admin/charges/delete/1',
            'params' => [
                'prefix' => 'admin',
                'controller' => 'Charges',
                'action' => 'delete',
                'pass' => ['1'],
            ]
        ]);
        $response = new \Cake\Http\Response();
        $controller = new ChargesController($url, $response);
        $controller->delete(1);
    }

    /**
     * Test csvExport method
     *
     * @return void
     */
    public function testCsvExport(): void
    {
        $this->get('/admin/charges/csv-export');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->super_admin
        ]);
        $this->get('/admin/charges/csv-export');
        $this->assertResponseCode(200);
        $this->assertHeaderContains('Content-Disposition', 'attachment;');
        $this->assertHeaderContains('Content-Type', 'text/csv;');

        $this->session([
            'Auth.Admin' => $this->read_admin
        ]);
        $this->get('/admin/charges/csv-export');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->write_admin
        ]);
        $this->get('/admin/charges/csv-export');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->delete_admin
        ]);
        $this->get('/admin/charges/csv-export');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->csv_export_admin
        ]);
        $this->get('/admin/charges/csv-export');
        $this->assertResponseCode(200);
        $this->assertHeaderContains('Content-Disposition', 'attachment;');
        $this->assertHeaderContains('Content-Type', 'text/csv;');

        $this->session([
            'Auth.Admin' => $this->excel_export_admin
        ]);
        $this->get('/admin/charges/csv-export');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->no_authority_admin
        ]);
        $this->get('/admin/charges/csv-export');
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
        $this->get('/admin/charges/excel-export');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->super_admin
        ]);
        $this->get('/admin/charges/excel-export');
        $this->assertResponseCode(200);
        $this->assertHeaderContains('Content-Disposition', 'attachment;');
        $this->assertHeaderContains('Content-Type', EXCEL_CONTENT_TYPE);

        $this->session([
            'Auth.Admin' => $this->read_admin
        ]);
        $this->get('/admin/charges/excel-export');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->write_admin
        ]);
        $this->get('/admin/charges/excel-export');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->delete_admin
        ]);
        $this->get('/admin/charges/excel-export');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->csv_export_admin
        ]);
        $this->get('/admin/charges/excel-export');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->excel_export_admin
        ]);
        $this->get('/admin/charges/excel-export');
        $this->assertResponseCode(200);
        $this->assertHeaderContains('Content-Disposition', 'attachment;');
        $this->assertHeaderContains('Content-Type', EXCEL_CONTENT_TYPE);

        $this->session([
            'Auth.Admin' => $this->no_authority_admin
        ]);
        $this->get('/admin/charges/excel-export');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');
    }
}
