<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Admin;

use App\Controller\Admin\AccessMapsController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\Admin\AccessMapsController Test Case
 *
 * @uses \App\Controller\Admin\AccessMapsController
 */
class AccessMapsControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Admins',
        'app.AccessMaps',
    ];

    /**
     * By default, all fixtures attached to this class will be truncated and reloaded after each test.
     * Set this to false to handle manually
     *
     * @var bool
     */
    public $autoFixtures = false;

    /**
     * access_maps table.
     * @var \App\Model\Table\AccessMapsTable $AccessMaps
     */
    protected $AccessMaps;

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
        $access_maps_config = $this->getTableLocator()->exists('AccessMaps') ? [] : ['className' => \App\Model\Table\AccessMapsTable::class];
        /** @var \App\Model\Table\AccessMapsTable $AccessMaps */
        $this->AccessMaps = $this->getTableLocator()->get('AccessMaps', $access_maps_config);

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
                'AccessMaps' => [ROLE_READ],
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
                'AccessMaps' => [ROLE_WRITE],
            ]
        ]);
        $this->Admins->save($write_admin);
        /** @var \App\Model\Entity\Admin $write_admin */
        $this->write_admin = $this->Admins->get($write_admin->id, [
            'finder' => 'auth',
        ]);

        $no_authority_admin = $this->Admins->newEntity([
            'name' => '権限なし',
            'mail' => 'no_authority@example.com',
            'password' => 'password',
            'use_otp' => '0',
            'privilege' => [
                'AccessMaps' => [],
            ]
        ]);
        $this->Admins->save($no_authority_admin);
        /** @var \App\Model\Entity\Admin $no_authority_admin */
        $this->no_authority_admin = $this->Admins->get($no_authority_admin->id, [
            'finder' => 'auth',
        ]);
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit(): void
    {
        $this->get('/admin/access-maps/edit');
        $this->assertResponseCode(302);
        $this->assertHeaderContains('location', '/admin/auth/login');

        $this->session([
            'Auth.Admin' => $this->super_admin
        ]);
        $this->get('/admin/access-maps/edit');
        $this->assertResponseCode(200);
        $this->assertHeaderContains('Content-Type', 'text/html;');
        $this->assertTextContains('<title>アクセスマップ更新</title>', (string)$this->_response->getBody());

        $this->session([
            'Auth.Admin' => $this->read_admin
        ]);
        $this->get('/admin/access-maps/edit');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');

        $this->session([
            'Auth.Admin' => $this->write_admin
        ]);
        $this->get('/admin/access-maps/edit');
        $this->assertResponseCode(200);
        $this->assertHeaderContains('Content-Type', 'text/html;');
        $this->assertTextContains('<title>アクセスマップ更新</title>', (string)$this->_response->getBody());

        $this->session([
            'Auth.Admin' => $this->no_authority_admin
        ]);
        $this->get('/admin/access-maps/edit');
        $this->assertResponseCode(302);
        $this->assertSession(MESSAGE_AUTH_ERROR, 'Flash.flash.0.message');
    }
}
