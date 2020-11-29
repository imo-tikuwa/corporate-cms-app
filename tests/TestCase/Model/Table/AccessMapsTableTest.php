<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AccessMapsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AccessMapsTable Test Case
 */
class AccessMapsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AccessMapsTable
     */
    protected $AccessMaps;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.AccessMaps',
    ];

    /**
     * access_map valid data.
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
        $config = $this->getTableLocator()->exists('AccessMaps') ? [] : ['className' => AccessMapsTable::class];
        $this->AccessMaps = $this->getTableLocator()->get('AccessMaps', $config);

        $this->valid_data = [
            // アクセス方法
            'description' => 'valid data.',
            // GoogleMap地図座標
            'location' => json_encode([
                'zoom' => 13,
                'latitude' => 35.658599,
                'longitude' => 139.745443,
            ]),
            // 地図リンク
            'map_link' => 'valid data.',
        ];
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->AccessMaps);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $access_map = $this->AccessMaps->newEmptyEntity();
        $access_map = $this->AccessMaps->patchEntity($access_map, $this->valid_data);
        $this->assertEmpty($access_map->getErrors());
    }

    /**
     * Test patchEntity method
     *
     * @return void
     */
    public function testPatchEntity(): void
    {
        $access_map = $this->AccessMaps->get(1);
        $this->assertInstanceOf('\App\Model\Entity\AccessMap', $access_map);
        $access_map = $this->AccessMaps->patchEntity($access_map, $this->valid_data);
        $this->assertInstanceOf('\Cake\Datasource\EntityInterface', $access_map);

        $this->assertSame(json_decode($this->valid_data['location'], true), $access_map->location);
        $this->assertFalse($access_map->hasErrors());
    }
}
