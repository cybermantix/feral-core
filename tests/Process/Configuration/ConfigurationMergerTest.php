<?php

namespace NoLoCo\Core\Tests\Process\Configuration;

use NoLoCo\Core\Process\Configuration\ConfigurationManager;
use PHPUnit\Framework\TestCase;

class ConfigurationMergerTest extends TestCase
{
    protected ConfigurationManager $manager;

    protected function setUp(): void
    {
        $this->manager = new ConfigurationManager();
    }

    public function testOverride()
    {
        $this->manager->merge(['one' => 1]);
        $this->manager->merge(['one' => 2]);
        $configuration = $this->manager->getConfiguration();
        $this->assertEquals(2, $configuration['one']);
    }

    public function testAdd()
    {
        $this->manager->merge(['one' => 1]);
        $this->manager->merge(['two' => 2]);
        $configuration = $this->manager->getConfiguration();
        $this->assertEquals(1, $configuration['one']);
        $this->assertEquals(2, $configuration['two']);
    }

    public function testDelete()
    {
        $this->manager->merge(['one' => 1]);
        $merge = $this->manager->addDeleteValue([], 'one');
        $this->manager->merge($merge);
        $configuration = $this->manager->getConfiguration();
        $this->assertFalse(isset($configuration['one']));
    }
}
