<?php
/**
 * Classe Database - Pattern Singleton pour la connexion PDO
 */
class Database
{
    // Instance unique de la classe
    private static ?Database $instance = null;
    
    // Connexion PDO
    private PDO $connection;
    
    // Configuration de la base de données
    private const DB_HOST = 'localhost';
    private const DB_NAME = 'todo_app';
    private const DB_USER = 'root';
    private const DB_PASS = '';
    private const DB_CHARSET = 'utf8mb4';
    
    /**
     * Constructeur privé - empêche l'instanciation directe
     */
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
    
    /**
     * Empêche le clonage de l'instance
     */
    private function __clone() {}
    
    /**
     * Empêche la désérialisation de l'instance
     */
    public function __wakeup()
    {
        throw new Exception("Un singleton ne peut pas être désérialisé.");
    }
    
    /**
     * Récupère l'instance unique de Database (Singleton)
     */
    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        
        return self::$instance;
    }
    
    /**
     * Récupère la connexion PDO
     */
    public function getConnection(): PDO
    {
        return $this->connection;
    }
}
