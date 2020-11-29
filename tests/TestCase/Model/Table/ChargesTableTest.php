<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ChargesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ChargesTable Test Case
 */
class ChargesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ChargesTable
     */
    protected $Charges;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Charges',
        'app.ChargeRelations',
    ];

    /**
     * charge valid data.
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
        $config = $this->getTableLocator()->exists('Charges') ? [] : ['className' => ChargesTable::class];
        $this->Charges = $this->getTableLocator()->get('Charges', $config);

        $this->valid_data = [
            // プラン名
            'name' => 'valid data.',
            // プラン名下注釈
            'annotation' => 'valid data.',
        ];
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Charges);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $charge = $this->Charges->newEmptyEntity();
        $charge = $this->Charges->patchEntity($charge, $this->valid_data);
        $this->assertEmpty($charge->getErrors());
    }

    /**
     * Test patchEntity method
     *
     * @return void
     */
    public function testPatchEntity(): void
    {
        $charge = $this->Charges->get(1);
        $this->assertInstanceOf('\App\Model\Entity\Charge', $charge);
        $charge = $this->Charges->patchEntity($charge, $this->valid_data);
        $this->assertInstanceOf('\Cake\Datasource\EntityInterface', $charge);

        $this->assertFalse($charge->hasErrors());
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
            'プラン名',
            'プラン名下注釈',
            '作成日時',
            '更新日時',
        ];
        $this->assertEquals($this->Charges->getCsvHeaders(), $data);
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
            'annotation',
            'created',
            'modified',
        ];
        $this->assertEquals($this->Charges->getCsvColumns(), $data);
    }

    /**
     * Test getExcelColumns method
     *
     * @return void
     */
    public function testGetExcelColumns(): void
    {
        $data = [
            'id',
            'name',
            'annotation',
            'created',
            'modified',
        ];
        $this->assertEquals($this->Charges->getExcelColumns(), $data);
    }

    /**
     * Test query method
     *
     * @return void
     */
    public function testQuery(): void
    {
        $query = $this->Charges->query();
        $this->assertInstanceOf('\SoftDelete\ORM\Query', $query);
    }

    /**
     * Test deleteAll method
     *
     * @return void
     */
    public function testDeleteAll(): void
    {
        $this->Charges->deleteAll([]);
        $this->assertEquals(0, $this->Charges->find()->count());
        $this->assertNotEquals(0, $this->Charges->find('all', ['withDeleted'])->count());
    }

    /**
     * Test getSoftDeleteField method
     *
     * @return void
     */
    public function testGetSoftDeleteField(): void
    {
        $this->assertEquals($this->Charges->getSoftDeleteField(), 'deleted');
    }

    /**
     * Test hardDelete method
     *
     * @return void
     */
    public function testHardDelete(): void
    {
        $charge = $this->Charges->get(1);
        $this->Charges->hardDelete($charge);
        $charge = $this->Charges->findById(1)->first();
        $this->assertEquals(null, $charge);

        $charge = $this->Charges->find('all', ['withDeleted'])->where(['id' => 1])->first();
        $this->assertEquals(null, $charge);
    }

    /**
     * Test hardDeleteAll method
     *
     * @return void
     */
    public function testHardDeleteAll(): void
    {
        $affected_rows = $this->Charges->hardDeleteAll(new \DateTime('now'));
        $this->assertEquals(0, $affected_rows);

        $charges_rows_count = $this->Charges->find('all', ['withDeleted'])->count();

        $this->Charges->delete($this->Charges->get(1));
        $affected_rows = $this->Charges->hardDeleteAll(new \DateTime('now'));
        $this->assertEquals(1, $affected_rows);

        $newcharges_rows_count = $this->Charges->find('all', ['withDeleted'])->count();
        $this->assertEquals($charges_rows_count - 1, $newcharges_rows_count);
    }

    /**
     * Test restore method
     *
     * @return void
     */
    public function testRestore(): void
    {
        $charge = $this->Charges->findById(1)->first();
        $this->assertNotNull($charge);
        $this->Charges->delete($charge);
        $charge = $this->Charges->findById(1)->first();
        $this->assertNull($charge);

        $charge = $this->Charges->find('all', ['withDeleted'])->where(['id' => 1])->first();
        $this->Charges->restore($charge);
        $charge = $this->Charges->findById(1)->first();
        $this->assertNotNull($charge);
    }
}
