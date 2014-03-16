<?php
namespace Driver\Config\JSON;


use Strawberry\Driver\Config\JSON\ConfigProvider;

class ConfigProviderTest extends \PHPUnit_Framework_TestCase
{

    public function testMQConfig()
    {
        $configEntity = $this->getProviderWithTestPrefixedConfig()->getMQConfig();

        $this->assertInstanceOf('Strawberry\Driver\Config\ConfigEntity', $configEntity);

        $this->assertEquals('strProperty', $configEntity->getValue('prop1'));
        $this->assertEquals(10, $configEntity->getValue('prop2'));
    }

    public function testWorkerConfig()
    {
        $configEntity = $this->getProviderWithTestPrefixedConfig()->getWorkerConfig('test');

        $this->assertInstanceOf('Strawberry\Driver\Config\ConfigEntity', $configEntity);

        $this->assertEquals('strProperty2', $configEntity->getValue('prop1'));
        $this->assertEquals(20, $configEntity->getValue('prop2'));
    }

    /**
     * @expectedException Strawberry\Exception\ConfigurationNotProvidedException
     */
    public function testNotExistingWorkerConfig()
    {
        $configEntity = $this->getProviderWithTestPrefixedConfig()->getWorkerConfig('notExisting');
    }

    /**
     * @return ConfigProvider
     */
    private function getProviderWithTestPrefixedConfig()
    {
        return new ConfigProvider(realpath(__DIR__) . DIRECTORY_SEPARATOR . 'Data/test1.json', 'prefix1');
    }
}
 