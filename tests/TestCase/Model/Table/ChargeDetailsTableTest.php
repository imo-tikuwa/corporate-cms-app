<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ChargeDetailsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ChargeDetailsTable Test Case
 */
class ChargeDetailsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ChargeDetailsTable
     */
    protected $ChargeDetails;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.ChargeDetails',
        'app.Charges',
    ];

    /**
     * charge_detail valid data.
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
        $config = $this->getTableLocator()->exists('ChargeDetails') ? [] : ['className' => ChargeDetailsTable::class];
        $this->ChargeDetails = $this->getTableLocator()->get('ChargeDetails', $config);

        $this->valid_data = [
            // 料金名
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
        unset($this->ChargeDetails);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $charge_detail = $this->ChargeDetails->newEmptyEntity();
        $charge_detail = $this->ChargeDetails->patchEntity($charge_detail, $this->valid_data);
        $this->assertEmpty($charge_detail->getErrors());
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $charge_detail = $this->ChargeDetails->get(1);
        $this->assertTrue($this->ChargeDetails->checkRules($charge_detail));

        $charge_detail = $this->ChargeDetails->get(1);
        $charge_detail->set('charge_id', -1);
        $this->assertFalse($this->ChargeDetails->checkRules($charge_detail));

        $expected = [
            'charge_id' => [
                '_existsIn' => 'This value does not exist'
            ],
        ];
        $this->assertEquals($charge_detail->getErrors(), $expected);
    }

    /**
     * Test patchEntity method
     *
     * @return void
     */
    public function testPatchEntity(): void
    {
        $charge_detail = $this->ChargeDetails->get(1);
        $this->assertInstanceOf('\App\Model\Entity\ChargeDetail', $charge_detail);
        $charge_detail = $this->ChargeDetails->patchEntity($charge_detail, $this->valid_data);
        $this->assertInstanceOf('\Cake\Datasource\EntityInterface', $charge_detail);

        $this->assertFalse($charge_detail->hasErrors());
    }

    /**
     * Test query method
     *
     * @return void
     */
    public function testQuery(): void
    {
        $query = $this->ChargeDetails->query();
        $this->assertInstanceOf('\SoftDelete\ORM\Query', $query);
    }

    /**
     * Test deleteAll method
     *
     * @return void
     */
    public function testDeleteAll(): void
    {
        $this->ChargeDetails->deleteAll([]);
        $this->assertEquals(0, $this->ChargeDetails->find()->count());
        $this->assertNotEquals(0, $this->ChargeDetails->find('all', ['withDeleted'])->count());
    }

    /**
     * Test getSoftDeleteField method
     *
     * @return void
     */
    public function testGetSoftDeleteField(): void
    {
        $this->assertEquals($this->ChargeDetails->getSoftDeleteField(), 'deleted');
    }

    /**
     * Test hardDelete method
     *
     * @return void
     */
    public function testHardDelete(): void
    {
        $charge_detail = $this->ChargeDetails->get(1);
        $this->ChargeDetails->hardDelete($charge_detail);
        $charge_detail = $this->ChargeDetails->findById(1)->first();
        $this->assertEquals(null, $charge_detail);

        $charge_detail = $this->ChargeDetails->find('all', ['withDeleted'])->where(['id' => 1])->first();
        $this->assertEquals(null, $charge_detail);
    }

    /**
     * Test hardDeleteAll method
     *
     * @return void
     */
    public function testHardDeleteAll(): void
    {
        $affected_rows = $this->ChargeDetails->hardDeleteAll(new \DateTime('now'));
        $this->assertEquals(0, $affected_rows);

        $charge_details_rows_count = $this->ChargeDetails->find('all', ['withDeleted'])->count();

        $this->ChargeDetails->delete($this->ChargeDetails->get(1));
        $affected_rows = $this->ChargeDetails->hardDeleteAll(new \DateTime('now'));
        $this->assertEquals(1, $affected_rows);

        $newcharge_details_rows_count = $this->ChargeDetails->find('all', ['withDeleted'])->count();
        $this->assertEquals($charge_details_rows_count - 1, $newcharge_details_rows_count);
    }

    /**
     * Test restore method
     *
     * @return void
     */
    public function testRestore(): void
    {
        $charge_detail = $this->ChargeDetails->findById(1)->first();
        $this->assertNotNull($charge_detail);
        $this->ChargeDetails->delete($charge_detail);
        $charge_detail = $this->ChargeDetails->findById(1)->first();
        $this->assertNull($charge_detail);

        $charge_detail = $this->ChargeDetails->find('all', ['withDeleted'])->where(['id' => 1])->first();
        $this->ChargeDetails->restore($charge_detail);
        $charge_detail = $this->ChargeDetails->findById(1)->first();
        $this->assertNotNull($charge_detail);
    }
}
