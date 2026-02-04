<?php

class Database
{
    private static ?Database $instance = null;
    private PDO $connection;
    
    private const DB_HOST = 'localhost';
    private const DB_NAME = 'todo_app';
    private const DB_USER = 'root';
    private const DB_PASS = '';
    private const DB_CHARSET = 'utf8mb4';
    
    private function __construct()
    {
        try {
            $dsn = sprintf(
                'mysql:host=%s;dbname=%s;charset=%s',
                self::DB_HOST,
                self::DB_NAME,
                self::DB_CHARSET
            );
            
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ];
            
            $this->connection = new PDO($dsn, self::DB_USER, self::DB_PASS, $options);
            
        } catch (PDOException $e) {
            die('Erreur de connexion à la base de données : ' . $e->getMessage());
        }
    }
    
    private function __clone() {}
    
    public function __wakeup()
    {
        throw new Exception("Un singleton ne peut pas être désérialisé.");
    }
    
    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        
        return self::$instance;
    }
    
    public function getConnection(): PDO
    {
        return $this->connection;
    }
}
