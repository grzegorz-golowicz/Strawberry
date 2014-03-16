<?php
namespace Driver\Config;

use Strawberry\Driver\Config\ConfigEntity;


class ConfigEntityTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructWithArray()
    {
        $ce = new ConfigEntity($this->getTestConfigArray());
        $this->assertInstanceOf('Strawberry\Driver\Config\ConfigEntity', $ce);
    }

    public function testGetNode()
    {
        $ce = new ConfigEntity($this->getTestConfigArray());
        $node = $ce->getNode('testNode');
        $this->assertInstanceOf('Strawberry\Driver\Config\ConfigEntity', $node);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGetNonExistingNode()
    {
        $ce = new ConfigEntity($this->getTestConfigArray());
        $node = $ce->getNode('testNonExistingNode');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGetValueNode()
    {
        $ce = new ConfigEntity($this->getTestConfigArray());
        $node = $ce->getNode('testStringValue');
    }

    public function testGetValue()
    {
        $ce = new ConfigEntity($this->getTestConfigArray());
        $valueStr = $ce->getValue('testStringValue');
        $this->assertEquals('testValue', $valueStr);
        $valueInt = $ce->getValue('testIntValue');
        $this->assertEquals(17, $valueInt);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGetNonExistingValue()
    {
        $ce = new ConfigEntity($this->getTestConfigArray());
        $valueStr = $ce->getValue('testNonExistingStringValue');
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGetNodeValue()
    {
        $ce = new ConfigEntity($this->getTestConfigArray());
        $node = $ce->getValue('testNode');
    }

    public function testGetArray()
    {
        $ce = new ConfigEntity($this->getTestConfigArray());
        $arr = $ce->getAsArray();

        $this->assertEquals($this->getTestConfigArray(), $arr);
    }

    private function getTestConfigArray()
    {
        return array('testStringValue' => 'testValue',
            'testIntValue' => 17,
            'testNode' => array('testStringValueInNode' => 'testValueInNode',
                'testIntValueInNode' => 20));
    }
}
 