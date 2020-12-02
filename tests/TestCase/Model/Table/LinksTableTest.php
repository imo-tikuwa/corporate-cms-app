<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LinksTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LinksTable Test Case
 */
class LinksTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LinksTable
     */
    protected $Links;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Links',
    ];

    /**
     * link valid data.
     */
    protected $valid_data;

    /**
     * link valid csv data.
     */
    protected $valid_csv_data;

    /**
     * link valid excel data.
     */
    protected $valid_excel_data;

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Links') ? [] : ['className' => LinksTable::class];
        $this->Links = $this->getTableLocator()->get('Links', $config);

        $this->valid_data = [
            // リンクカテゴリ
            'category' => '01',
            // リンクタイトル
            'title' => 'valid data.',
            // リンクURL
            'url' => 'valid data.',
            // リンク説明
            'description' => 'valid data.',
        ];

        $this->valid_csv_data = [];
        // ID
        $this->valid_csv_data[] = '';
        // リンクカテゴリ
        $this->valid_csv_data[] = 'ショップ関連';
        // リンクタイトル
        $this->valid_csv_data[] = 'valid data.';
        // リンクURL
        $this->valid_csv_data[] = 'valid data.';
        // リンク説明
        $this->valid_csv_data[] = 'valid data.';
        // 作成日時
        $this->valid_csv_data[] = date('Y-m-d H:i:00');
        // 更新日時
        $this->valid_csv_data[] = date('Y-m-d H:i:00');

        $this->valid_excel_data = [];
        // ID
        $this->valid_excel_data[] = '';
        // リンクカテゴリ
        $this->valid_excel_data[] = '01:ショップ関連';
        // リンクタイトル
        $this->valid_excel_data[] = 'valid data.';
        // リンクURL
        $this->valid_excel_data[] = 'valid data.';
        // リンク説明
        $this->valid_excel_data[] = 'valid data.';
        // 作成日時
        $this->valid_excel_data[] = date('Y-m-d H:i:00');
        // 更新日時
        $this->valid_excel_data[] = date('Y-m-d H:i:00');
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Links);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $link = $this->Links->newEmptyEntity();
        $link = $this->Links->patchEntity($link, $this->valid_data);
        $this->assertEmpty($link->getErrors());
    }

    /**
     * Test validationCsv method
     *
     * @return void
     */
    public function testValidationCsv(): void
    {
        $link = $this->Links->newEmptyEntity();
        $link = $this->Links->patchEntity($link, $this->valid_data, [
            'validate' => 'csv',
        ]);
        $this->assertEmpty($link->getErrors());
    }

    /**
     * Test validationExcel method
     *
     * @return void
     */
    public function testValidationExcel(): void
    {
        $link = $this->Links->newEmptyEntity();
        $link = $this->Links->patchEntity($link, $this->valid_data, [
            'validate' => 'excel',
        ]);
        $this->assertEmpty($link->getErrors());
    }

    /**
     * Test patchEntity method
     *
     * @return void
     */
    public function testPatchEntity(): void
    {
        $link = $this->Links->get(1);
        $this->assertInstanceOf('\App\Model\Entity\Link', $link);
        $link = $this->Links->patchEntity($link, $this->valid_data);
        $this->assertInstanceOf('\Cake\Datasource\EntityInterface', $link);

        $this->assertFalse($link->hasErrors());
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
            'リンクカテゴリ',
            'リンクタイトル',
            'リンクURL',
            'リンク説明',
            '作成日時',
            '更新日時',
        ];
        $this->assertEquals($this->Links->getCsvHeaders(), $data);
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
            'category',
            'title',
            'url',
            'description',
            'created',
            'modified',
        ];
        $this->assertEquals($this->Links->getCsvColumns(), $data);
    }

    /**
     * Test createEntityByCsvRow method
     *
     * @return void
     */
    public function testCreateEntityByCsvRow(): void
    {
        $link = $this->Links->createEntityByCsvRow($this->valid_csv_data);
        $this->assertInstanceOf('\App\Model\Entity\Link', $link);
        $this->assertFalse($link->hasErrors());

        $result = $this->Links->save($link);
        $this->assertTrue(!empty($result));
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
            'category',
            'title',
            'url',
            'description',
            'created',
            'modified',
        ];
        $this->assertEquals($this->Links->getExcelColumns(), $data);
    }

    /**
     * Test createEntityByExcelRow method
     *
     * @return void
     */
    public function testCreateEntityByExcelRow(): void
    {
        $link = $this->Links->createEntityByExcelRow($this->valid_excel_data);
        $this->assertInstanceOf('\App\Model\Entity\Link', $link);
        $this->assertFalse($link->hasErrors());

        $result = $this->Links->save($link);
        $this->assertTrue(!empty($result));
    }
}
