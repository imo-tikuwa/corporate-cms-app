<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ChargeRelationsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ChargeRelationsTable Test Case
 */
class ChargeRelationsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ChargeRelationsTable
     */
    protected $ChargeRelations;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.ChargeRelations',
        'app.Charges',
        'app.ChargeMasters',
    ];

    /**
     * charge_relation valid data.
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
        $config = $this->getTableLocator()->exists('ChargeRelations') ? [] : ['className' => ChargeRelationsTable::class];
        $this->ChargeRelations = $this->getTableLocator()->get('ChargeRelations', $config);

        /** @var \App\Model\Entity\Charge $charge */
        $charge = $this->getTableLocator()->get('Charges')->get(1);
        /** @var \App\Model\Entity\ChargeMaster $charge_master */
        $charge_master = $this->getTableLocator()->get('ChargeMasters')->get(1);

        $this->valid_data = [
            // 基本料金ID
            'charge_id' => $charge->id,
            // 料金マスタID
            'charge_master_id' => $charge_master->id,
        ];
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->ChargeRelations);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $charge_relation = $this->ChargeRelations->newEmptyEntity();
        $charge_relation = $this->ChargeRelations->patchEntity($charge_relation, $this->valid_data);
        $this->assertEmpty($charge_relation->getErrors());
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $charge_relation = $this->ChargeRelations->get(1);
        $this->assertTrue($this->ChargeRelations->checkRules($charge_relation));

        $charge_relation = $this->ChargeRelations->get(1);
        $charge_relation->set('charge_id', -1);
        $this->assertFalse($this->ChargeRelations->checkRules($charge_relation));

        $expected = [
            'charge_id' => [
                '_existsIn' => 'This value does not exist'
            ],
        ];
        $this->assertEquals($charge_relation->getErrors(), $expected);
        $charge_relation = $this->ChargeRelations->get(1);
        $charge_relation->set('charge_master_id', -1);
        $this->assertFalse($this->ChargeRelations->checkRules($charge_relation));

        $expected = [
            'charge_master_id' => [
                '_existsIn' => 'This value does not exist'
            ],
        ];
        $this->assertEquals($charge_relation->getErrors(), $expected);
    }

    /**
     * Test patchEntity method
     *
     * @return void
     */
    public function testPatchEntity(): void
    {
        $charge_relation = $this->ChargeRelations->get(1);
        $this->assertInstanceOf('\App\Model\Entity\ChargeRelation', $charge_relation);
        $charge_relation = $this->ChargeRelations->patchEntity($charge_relation, $this->valid_data);
        $this->assertInstanceOf('\Cake\Datasource\EntityInterface', $charge_relation);

        $this->assertFalse($charge_relation->hasErrors());
    }

    /**
     * Test getSearchQuery method
     *
     * @return void
     */
    public function testGetSearchQuery(): void
    {
        $query = $this->ChargeRelations->getSearchQuery([]);
        $charge_relation = $query->select(['id'])->enableHydration(false)->first();

        $this->assertInstanceOf('\Cake\ORM\Query', $query);
        $this->assertTrue(array_key_exists('id', $charge_relation));
        $this->assertEquals(1, $charge_relation['id']);

        $query = $this->ChargeRelations->getSearchQuery(['id' => 99999]);
        $charge_relation = $query->enableHydration(false)->first();

        $this->assertInstanceOf('\Cake\ORM\Query', $query);
        $this->assertNull($charge_relation);
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
            '基本料金ID',
            '料金マスタID',
            '作成日時',
            '更新日時',
        ];
        $this->assertEquals($this->ChargeRelations->getCsvHeaders(), $data);
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
            'charge_id',
            'charge_master_id',
            'created',
            'modified',
        ];
        $this->assertEquals($this->ChargeRelations->getCsvColumns(), $data);
    }

    /**
     * Test query method
     *
     * @return void
     */
    public function testQuery(): void
    {
        $query = $this->ChargeRelations->query();
        $this->assertInstanceOf('\SoftDelete\ORM\Query', $query);
    }

    /**
     * Test deleteAll method
     *
     * @return void
     */
    public function testDeleteAll(): void
    {
        $this->ChargeRelations->deleteAll([]);
        $this->assertEquals(0, $this->ChargeRelations->find()->count());
        $this->assertNotEquals(0, $this->ChargeRelations->find('all', ['withDeleted'])->count());
    }

    /**
     * Test getSoftDeleteField method
     *
     * @return void
     */
    public function testGetSoftDeleteField(): void
    {
        $this->assertEquals($this->ChargeRelations->getSoftDeleteField(), 'deleted');
    }

    /**
     * Test hardDelete method
     *
     * @return void
     */
    public function testHardDelete(): void
    {
        $charge_relation = $this->ChargeRelations->get(1);
        $this->ChargeRelations->hardDelete($charge_relation);
        $charge_relation = $this->ChargeRelations->findById(1)->first();
        $this->assertEquals(null, $charge_relation);

        $charge_relation = $this->ChargeRelations->find('all', ['withDeleted'])->where(['id' => 1])->first();
        $this->assertEquals(null, $charge_relation);
    }

    /**
     * Test hardDeleteAll method
     *
     * @return void
     */
    public function testHardDeleteAll(): void
    {
        $affected_rows = $this->ChargeRelations->hardDeleteAll(new \DateTime('now'));
        $this->assertEquals(0, $affected_rows);

        $charge_relations_rows_count = $this->ChargeRelations->find('all', ['withDeleted'])->count();

        $this->ChargeRelations->delete($this->ChargeRelations->get(1));
        $affected_rows = $this->ChargeRelations->hardDeleteAll(new \DateTime('now'));
        $this->assertEquals(1, $affected_rows);

        $newcharge_relations_rows_count = $this->ChargeRelations->find('all', ['withDeleted'])->count();
        $this->assertEquals($charge_relations_rows_count - 1, $newcharge_relations_rows_count);
    }

    /**
     * Test restore method
     *
     * @return void
     */
    public function testRestore(): void
    {
        $charge_relation = $this->ChargeRelations->findById(1)->first();
        $this->assertNotNull($charge_relation);
        $this->ChargeRelations->delete($charge_relation);
        $charge_relation = $this->ChargeRelations->findById(1)->first();
        $this->assertNull($charge_relation);

        $charge_relation = $this->ChargeRelations->find('all', ['withDeleted'])->where(['id' => 1])->first();
        $this->ChargeRelations->restore($charge_relation);
        $charge_relation = $this->ChargeRelations->findById(1)->first();
        $this->assertNotNull($charge_relation);
    }
}
