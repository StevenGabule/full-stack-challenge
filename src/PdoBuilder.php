<?php

namespace Otto;

use PDO;
use PDOException;

class PdoBuilder
{
    protected $config;

    public function __construct(array $config)
    {
        $this->setConfig($config);
        $this->setPdo($this->createPdoInstance());
    }

    public function createPdoInstance()
    {
        $config = $this->getConfig();

        $dsn = "mysql:host={$config['host']};dbname={$config['database']}";
        $attrs = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ];

        try {
            $pdo = new PDO($dsn, $config['user'], $config['password'], $attrs);
        } catch (PDOException $e) {
            die($e->getMessage());
        }

        return $pdo;
    }

    public function setPdo(\PDO $pdo)
    {
        $this->pdo = $pdo;
        return $this;
    }

    public function getPdo()
    {
        return $this->pdo;
    }

    public function setConfig($config)
    {
        $this->config = $config;
        return $this;
    }

    public function getConfig()
    {
        return $this->config;
    }
}