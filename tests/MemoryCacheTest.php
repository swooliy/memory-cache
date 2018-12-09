<?php

namespace Swooliy\Tests\MemoryCache;

use Swoole\Table;
use PHPUnit\Framework\TestCase;
use Swooliy\MemoryCache\MemoryCache;

/**
 * Memory Cache Base on Swoole Memory implements psr-16: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-16-simple-cache.md
 * 
 * @category Cache
 * @package  Swooliy\MemoryCache
 * @author   ney <zoobile@gmail.com>
 * @license  MIT 
 * @link     https://github.com/swooliy/memory-cache
 */
class MemoryCacheTest extends TestCase
{
    
    protected $cache;

    /**
     * Setup
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $columns = [
            'name' => [
                'type' => Table::TYPE_STRING,
                'size' => 100,
            ],
            'value' => [
                'type' => Table::TYPE_STRING,
                'size' => 300,
            ],
        ];

        $this->cache = new MemoryCache($columns, 10);
    }

    /**
     * Test Set function 
     *
     * @return void
     */
    public function testSetAndGet()
    {
        $data = [
            'name' => 'name',
            'value' => 'value',
        ];

        $this->cache->set("1", $data);

        $this->assertEquals($data, $this->cache->get("1"));
    }

    /**
     * Test Delete function 
     *
     * @return void
     */
    public function testDelete()
    {
        $this->cache->delete("1");

        $this->assertEquals(false, $this->cache->get("1"));
    }

    /**
     * Test GetMultiple and SetMultiple function
     *
     * @return void
     */
    public function testGetMultipleAndSetMultiple()
    {
        $datas = [
            "1" => [
                'name' => 'name1',
                'value' => 'value1',
            ],
            "2" => [
                'name' => 'name2',
                'value' => 'value2',
            ],
        ];

        $this->cache->setMultiple($datas);

        $this->assertEquals($datas, $this->cache->getMultiple(["1", "2"]));
    }

    /**
     * Test Has function
     *
     * @return void
     */
    public function testHas()
    {
        $datas = [
            "1" => [
                'name' => 'name1',
                'value' => 'value1',
            ],
            "2" => [
                'name' => 'name2',
                'value' => 'value2',
            ],
        ];

        $this->cache->setMultiple($datas);

        $this->assertTrue($this->cache->has("1"));
        $this->assertTrue($this->cache->has("2"));
    }

    /**
     * Test clear function 
     *
     * @return void
     */
    public function testClear()
    {
        $datas = [
            "1" => [
                'name' => 'name1',
                'value' => 'value1',
            ],
            "2" => [
                'name' => 'name2',
                'value' => 'value2',
            ],
        ];

        $this->cache->setMultiple($datas);

        $this->cache->clear();

        $this->assertFalse($this->cache->has("1"));
        $this->assertFalse($this->cache->has("2"));
    }

}