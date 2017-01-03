<?php

namespace Adarts;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2016-10-01 at 19:11:51.
 */
class DictionaryTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var Dictionary
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new Dictionary;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {

    }

    /**
     * @covers Adarts\Dictionary::add
     * @todo   Implement testAdd().
     */
    public function testAdd() {
        $this->object
            ->add("毛 abcfd")
            ->add("bcev")
            ->add("毛 主 席")
            ->add("主 导")
            ->add("习boss")
            ->confirm();
        du($this->object);

        $packed = serialize($this->object);
//        var_dump($packed);
//        du(strlen($packed));
        $this->object = unserialize($packed);

        // 测试找批量
        $result_list = [
            '毛 abcfd'  => 1,
            '主 导'     => 1,
            '习boss'    => 1,
        ];
        foreach ($this->object->seek('abd毛 主毛 abcfd 毛 主 导习bossk') as $result) {
            $word = $this->object->getWordsByState($result);
            $this->assertTrue(isset($result_list[$word]));
            unset($result_list[$word]);
        }
        $this->assertEquals(0, count($result_list));

        // 测试深回归
        $result = $this->object->seek('123毛 abcfwr')->current();
        $this->assertNull($result);
        $this->assertEquals('', $this->object->getWordsByState($result));

        // 测试失败指针
        $result = $this->object->seek('abd毛 主d 毛 主 导k')->current();
        $this->assertEquals(26, $result);
        $this->assertEquals('主 导', $this->object->getWordsByState($result));

        // 简化
        $packed = serialize($this->object->simplify());
//        var_dump($packed);
//        du(strlen($packed));
        $this->object = unserialize($packed);

        // 测试未找到
        $result = $this->object->seek('abd毛习')->current();
        $this->assertNull($result);
        $this->assertEquals('', $this->object->getWordsByState($result));

        // 测试找到
        $result = $this->object->seek('abd习bosseee')->current();
        $this->assertEquals(33, $result);

        // 测试限制
        foreach ($this->object->seek('主 导 习boss bcev', 3) as $result) {}
        $this->assertEquals(26, $result);
        foreach ($this->object->seek('主 导 习boss bcev', 1, 3) as $result) {}
        $this->assertEquals(33, $result);

    }

    /**
     * @covers Adarts\Dictionary::prepare
     * @todo   Implement testPrepare().
     */
    public function testPrepare() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers Adarts\Dictionary::compress
     * @todo   Implement testCompress().
     */
    public function testCompress() {
        // Remove the following lines when you implement this test.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

}
