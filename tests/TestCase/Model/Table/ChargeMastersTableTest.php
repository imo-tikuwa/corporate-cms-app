<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ChargeMastersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ChargeMastersTable Test Case
 */
class ChargeMastersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ChargeMastersTable
     */
    protected $ChargeMasters;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.ChargeMasters',
        'app.ChargeRelations',
    ];

    /**
     * charge_master valid data.
     */
    protected $valid_data;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ChargeMasters') ? [] : ['className' => ChargeMastersTable::class];
        $this->ChargeMasters = $this->getTableLocator()->get('ChargeMasters', $config);

        $this->valid_data = [
            // マスタ名
            'name' => 'valid data.',
            // 基本料金
            'basic_charge' => 0,
            // キャンペーン料金
            'campaign_charge' => 0,
        ];
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->ChargeMasters);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $charge_master = $this->ChargeMasters->newEmptyEntity();
        $charge_master = $this->ChargeMasters->patchEntity($charge_master, $this->valid_data);
        $this->assertEmpty($charge_master->getErrors());
    }

    /**
     * Test patchEntity method
     *
     * @return void
     */
    public function testPatchEntity(): void
    {
        $charge_master = $this->ChargeMasters->get(1);
        $this->assertInstanceOf('\App\Model\Entity\ChargeMaster', $charge_master);
        $charge_master = $this->ChargeMasters->patchEntity($charge_master, $this->valid_data);
        $this->assertInstanceOf('\Cake\Datasource\EntityInterface', $charge_master);

        $this->assertFalse($charge_master->hasErrors());
    }

    /**
     * Test getCsvHeaders method
     *
     * @return void
     */
    public function testGetCsvHeaders(): void
    {
        $data = [
            'ID',
            'マスタ名',
            '基本料金',
            'キャンペーン料金',
            '作成日時',
            '更新日時',
        ];
        $this->assertEquals($this->ChargeMasters->getCsvHeaders(), $data);
    }

    /**
     * Test getCsvColumns method
     *
     * @return void
     */
    public function testGetCsvColumns(): void
    {
        $data = [
            'id',
            'name',
            'basic_charge',
            'campaign_charge',
            'created',
            'modified',
        ];
        $this->assertEquals($this->ChargeMasters->getCsvColumns(), $data);
    }

    /**
     * Test query method
     *
     * @return void
     */
    public function testQuery(): void
    {
        $query = $this->ChargeMasters->query();
        $this->assertInstanceOf('\SoftDelete\ORM\Query', $query);
    }

    /**
     * Test deleteAll method
     *
     * @return void
     */
    public function testDeleteAll(): void
    {
        $this->ChargeMasters->deleteAll([]);
        $this->assertEquals(0, $this->ChargeMasters->find()->count());
        $this->assertNotEquals(0, $this->ChargeMasters->find('all', ['withDeleted'])->count());
    }

    /**
     * Test getSoftDeleteField method
     *
     * @return void
     */
    public function testGetSoftDeleteField(): void
    {
        $this->assertEquals($this->ChargeMasters->getSoftDeleteField(), 'deleted');
    }

    /**
     * Test hardDelete method
     *
     * @return void
     */
    public function testHardDelete(): void
    {
        $charge_master = $this->ChargeMasters->get(1);
        $this->ChargeMasters->hardDelete($charge_master);
        $charge_master = $this->ChargeMasters->findById(1)->first();
        $this->assertEquals(null, $charge_master);

        $charge_master = $this->ChargeMasters->find('all', ['withDeleted'])->where(['id' => 1])->first();
        $this->assertEquals(null, $charge_master);
    }

    /**
     * Test hardDeleteAll method
     *
     * @return void
     */
    public function testHardDeleteAll(): void
    {
        $affected_rows = $this->ChargeMasters->hardDeleteAll(new \DateTime('now'));
        $this->assertEquals(0, $affected_rows);

        $charge_masters_rows_count = $this->ChargeMasters->find('all', ['withDeleted'])->count();

        $this->ChargeMasters->delete($this->ChargeMasters->get(1));
        $affected_rows = $this->ChargeMasters->hardDeleteAll(new \DateTime('now'));
        $this->assertEquals(1, $affected_rows);

        $newcharge_masters_rows_count = $this->ChargeMasters->find('all', ['withDeleted'])->count();
        $this->assertEquals($charge_masters_rows_count - 1, $newcharge_masters_rows_count);
    }

    /**
     * Test restore method
     *
     * @return void
     */
    public function testRestore(): void
    {
        $charge_master = $this->ChargeMasters->findById(1)->first();
        $this->assertNotNull($charge_master);
        $this->ChargeMasters->delete($charge_master);
        $charge_master = $this->ChargeMasters->findById(1)->first();
        $this->assertNull($charge_master);

        $charge_master = $this->ChargeMasters->find('all', ['withDeleted'])->where(['id' => 1])->first();
        $this->ChargeMasters->restore($charge_master);
        $charge_master = $this->ChargeMasters->findById(1)->first();
        $this->assertNotNull($charge_master);
    }
}
