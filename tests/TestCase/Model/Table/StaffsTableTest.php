<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\StaffsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\StaffsTable Test Case
 */
class StaffsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\StaffsTable
     */
    protected $Staffs;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Staffs',
    ];

    /**
     * staff valid data.
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
        $config = $this->getTableLocator()->exists('Staffs') ? [] : ['className' => StaffsTable::class];
        $this->Staffs = $this->getTableLocator()->get('Staffs', $config);

        $this->valid_data = [
            // スタッフ名
            'name' => 'valid data.',
            // スタッフ名(英)
            'name_en' => 'valid data.',
            // スタッフ役職
            'staff_position' => '01',
            // 画像表示位置
            'photo_position' => '01',
            // スタッフ画像
            'photo' => json_encode([
                0 => [
                    'key' => "9288ac73e78f44b37f81596ed38eb0f27da6f7bd.jpg",
                    'size' => 775702,
                    'cur_name' => "9288ac73e78f44b37f81596ed38eb0f27da6f7bd.jpg",
                    'org_name' => "Test.jpg",
                    'delete_url' => "/admin/staffs/fileDelete/photo_file",
                ],
            ]),
            // スタッフ説明1
            'description1' => 'valid data.',
            // 見出し1
            'midashi1' => 'valid data.',
            // スタッフ説明2
            'description2' => 'valid data.',
        ];
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Staffs);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $staff = $this->Staffs->newEmptyEntity();
        $staff = $this->Staffs->patchEntity($staff, $this->valid_data);
        $this->assertEmpty($staff->getErrors());
    }

    /**
     * Test patchEntity method
     *
     * @return void
     */
    public function testPatchEntity(): void
    {
        $staff = $this->Staffs->get(1);
        $this->assertInstanceOf('\App\Model\Entity\Staff', $staff);
        $staff = $this->Staffs->patchEntity($staff, $this->valid_data);
        $this->assertInstanceOf('\Cake\Datasource\EntityInterface', $staff);

        $this->assertSame(json_decode($this->valid_data['photo'], true), $staff->photo);
        $this->assertFalse($staff->hasErrors());
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
            'スタッフ名',
            'スタッフ名(英)',
            'スタッフ役職',
            '画像表示位置',
            'スタッフ説明1',
            '見出し1',
            'スタッフ説明2',
            '作成日時',
            '更新日時',
        ];
        $this->assertEquals($this->Staffs->getCsvHeaders(), $data);
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
            'name_en',
            'staff_position',
            'photo_position',
            'description1',
            'midashi1',
            'description2',
            'created',
            'modified',
        ];
        $this->assertEquals($this->Staffs->getCsvColumns(), $data);
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
            'name_en',
            'staff_position',
            'photo_position',
            'description1',
            'midashi1',
            'description2',
            'created',
            'modified',
        ];
        $this->assertEquals($this->Staffs->getExcelColumns(), $data);
    }

    /**
     * Test query method
     *
     * @return void
     */
    public function testQuery(): void
    {
        $query = $this->Staffs->query();
        $this->assertInstanceOf('\SoftDelete\ORM\Query', $query);
    }

    /**
     * Test deleteAll method
     *
     * @return void
     */
    public function testDeleteAll(): void
    {
        $this->Staffs->deleteAll([]);
        $this->assertEquals(0, $this->Staffs->find()->count());
        $this->assertNotEquals(0, $this->Staffs->find('all', ['withDeleted'])->count());
    }

    /**
     * Test getSoftDeleteField method
     *
     * @return void
     */
    public function testGetSoftDeleteField(): void
    {
        $this->assertEquals($this->Staffs->getSoftDeleteField(), 'deleted');
    }

    /**
     * Test hardDelete method
     *
     * @return void
     */
    public function testHardDelete(): void
    {
        $staff = $this->Staffs->get(1);
        $this->Staffs->hardDelete($staff);
        $staff = $this->Staffs->findById(1)->first();
        $this->assertEquals(null, $staff);

        $staff = $this->Staffs->find('all', ['withDeleted'])->where(['id' => 1])->first();
        $this->assertEquals(null, $staff);
    }

    /**
     * Test hardDeleteAll method
     *
     * @return void
     */
    public function testHardDeleteAll(): void
    {
        $affected_rows = $this->Staffs->hardDeleteAll(new \DateTime('now'));
        $this->assertEquals(0, $affected_rows);

        $staffs_rows_count = $this->Staffs->find('all', ['withDeleted'])->count();

        $this->Staffs->delete($this->Staffs->get(1));
        $affected_rows = $this->Staffs->hardDeleteAll(new \DateTime('now'));
        $this->assertEquals(1, $affected_rows);

        $newstaffs_rows_count = $this->Staffs->find('all', ['withDeleted'])->count();
        $this->assertEquals($staffs_rows_count - 1, $newstaffs_rows_count);
    }

    /**
     * Test restore method
     *
     * @return void
     */
    public function testRestore(): void
    {
        $staff = $this->Staffs->findById(1)->first();
        $this->assertNotNull($staff);
        $this->Staffs->delete($staff);
        $staff = $this->Staffs->findById(1)->first();
        $this->assertNull($staff);

        $staff = $this->Staffs->find('all', ['withDeleted'])->where(['id' => 1])->first();
        $this->Staffs->restore($staff);
        $staff = $this->Staffs->findById(1)->first();
        $this->assertNotNull($staff);
    }
}
