<?php

require_once __DIR__ . '/../vendor/autoload.php';

use PHPUnit\Framework\TestCase;

/**
 * @testdox Config Tests
 */
class ConfigTest extends TestCase
{
    /**
     * @testdox DB Config file exists in the config directory
     */
    public function testDbConfigFileExists()
    {
        $this->assertTrue(file_exists(__DIR__ . '/../config/database.config.php'));
    }

    /**
     * @testdox DB Config file returns an array when included
     */
    public function testDbConfigFileReturnsArray()
    {
        try {
            $config = include __DIR__ . '/../config/database.config.php';
        } catch(\Exception $e) {
            $this->fail('Failed to include config file');
        }

        $this->assertIsArray($config);
    }
}