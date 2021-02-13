<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ContactsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ContactsTable Test Case
 */
class ContactsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ContactsTable
     */
    protected $Contacts;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Contacts',
    ];

    /**
     * contact valid data.
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
        $config = $this->getTableLocator()->exists('Contacts') ? [] : ['className' => ContactsTable::class];
        $this->Contacts = $this->getTableLocator()->get('Contacts', $config);

        $this->valid_data = [
            // お名前
            'name' => 'valid data.',
            // メールアドレス
            'email' => 'valid data.',
            // お問い合わせ内容
            'type' => '01',
            // お電話番号
            'tel' => 'valid data.',
            // ご希望日時／その他ご要望等
            'content' => 'valid data.',
            // ホームページURL
            'hp_url' => 'valid data.',
        ];
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Contacts);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $contact = $this->Contacts->newEmptyEntity();
        $contact = $this->Contacts->patchEntity($contact, $this->valid_data);
        $this->assertEmpty($contact->getErrors());
    }

    /**
     * Test patchEntity method
     *
     * @return void
     */
    public function testPatchEntity(): void
    {
        $contact = $this->Contacts->get(1);
        $this->assertInstanceOf('\App\Model\Entity\Contact', $contact);
        $contact = $this->Contacts->patchEntity($contact, $this->valid_data);
        $this->assertInstanceOf('\Cake\Datasource\EntityInterface', $contact);

        $this->assertFalse($contact->hasErrors());
    }

    /**
     * Test getSearchQuery method
     *
     * @return void
     */
    public function testGetSearchQuery(): void
    {
        $query = $this->Contacts->getSearchQuery([]);
        $contact = $query->select(['id'])->enableHydration(false)->first();

        $this->assertInstanceOf('\Cake\ORM\Query', $query);
        $this->assertTrue(array_key_exists('id', $contact));
        $this->assertEquals(1, $contact['id']);

        $query = $this->Contacts->getSearchQuery(['id' => 99999]);
        $contact = $query->enableHydration(false)->first();

        $this->assertInstanceOf('\Cake\ORM\Query', $query);
        $this->assertNull($contact);
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
            'お名前',
            'メールアドレス',
            'お問い合わせ内容',
            'お電話番号',
            'ご希望日時／その他ご要望等',
            'ホームページURL',
            '作成日時',
            '更新日時',
        ];
        $this->assertEquals($this->Contacts->getCsvHeaders(), $data);
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
            'email',
            'type',
            'tel',
            'content',
            'hp_url',
            'created',
            'modified',
        ];
        $this->assertEquals($this->Contacts->getCsvColumns(), $data);
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
            'email',
            'type',
            'tel',
            'content',
            'hp_url',
            'created',
            'modified',
        ];
        $this->assertEquals($this->Contacts->getExcelColumns(), $data);
    }

    /**
     * Test query method
     *
     * @return void
     */
    public function testQuery(): void
    {
        $query = $this->Contacts->query();
        $this->assertInstanceOf('\SoftDelete\ORM\Query', $query);
    }

    /**
     * Test deleteAll method
     *
     * @return void
     */
    public function testDeleteAll(): void
    {
        $this->Contacts->deleteAll([]);
        $this->assertEquals(0, $this->Contacts->find()->count());
        $this->assertNotEquals(0, $this->Contacts->find('all', ['withDeleted'])->count());
    }

    /**
     * Test getSoftDeleteField method
     *
     * @return void
     */
    public function testGetSoftDeleteField(): void
    {
        $this->assertEquals($this->Contacts->getSoftDeleteField(), 'deleted');
    }

    /**
     * Test hardDelete method
     *
     * @return void
     */
    public function testHardDelete(): void
    {
        $contact = $this->Contacts->get(1);
        $this->Contacts->hardDelete($contact);
        $contact = $this->Contacts->findById(1)->first();
        $this->assertEquals(null, $contact);

        $contact = $this->Contacts->find('all', ['withDeleted'])->where(['id' => 1])->first();
        $this->assertEquals(null, $contact);
    }

    /**
     * Test hardDeleteAll method
     *
     * @return void
     */
    public function testHardDeleteAll(): void
    {
        $affected_rows = $this->Contacts->hardDeleteAll(new \DateTime('now'));
        $this->assertEquals(0, $affected_rows);

        $contacts_rows_count = $this->Contacts->find('all', ['withDeleted'])->count();

        $this->Contacts->delete($this->Contacts->get(1));
        $affected_rows = $this->Contacts->hardDeleteAll(new \DateTime('now'));
        $this->assertEquals(1, $affected_rows);

        $newcontacts_rows_count = $this->Contacts->find('all', ['withDeleted'])->count();
        $this->assertEquals($contacts_rows_count - 1, $newcontacts_rows_count);
    }

    /**
     * Test restore method
     *
     * @return void
     */
    public function testRestore(): void
    {
        $contact = $this->Contacts->findById(1)->first();
        $this->assertNotNull($contact);
        $this->Contacts->delete($contact);
        $contact = $this->Contacts->findById(1)->first();
        $this->assertNull($contact);

        $contact = $this->Contacts->find('all', ['withDeleted'])->where(['id' => 1])->first();
        $this->Contacts->restore($contact);
        $contact = $this->Contacts->findById(1)->first();
        $this->assertNotNull($contact);
    }
}
