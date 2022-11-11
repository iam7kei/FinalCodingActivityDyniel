<?php

namespace app\core;

final class Database
{
    private static ?Database $instance = null;
    public \PDO $pdo;
    private array $config = [];

    private function __construct()
    {
        $this->config = $this->getConfig();
        $dsn = $this->config['dsn'] ?? '';
        $user = $this->config['user'] ?? '';
        $password = $this->config['password'] ?? '';
        $this->pdo = new \PDO($dsn, $user, $password);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    private function getConfig(): array
    {
        return [
                'dsn' => 'mysql:host=localhost;port=3306;dbname=final_dyniel',
                'user' => 'root',
                'password' => 'root',
            ];
    }

    public function prepare($sql)
    {
        return $this->pdo->prepare($sql);
    }

    private function __clone()
    {
    }

    public function __wakeup()
    {
        throw new \Exception('Cannot unserialize Database');
    }
}
