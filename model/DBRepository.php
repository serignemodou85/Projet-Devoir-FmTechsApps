<?php

class DBRepository
{
    private $host;
    private $dbname;
    private $user;
    private $password;
    protected $db;

    public function __construct() 
    {
        $this->host = getenv('DB_HOST') ?: "localhost";
        $this->dbname = getenv('DB_NAME') ?: "fmtech";
        $this->user = getenv('DB_USER') ?: "root";
        $this->password = getenv('DB_PASSWORD') ?: "";

        // Initialisation de la connexion directement dans le constructeur
        $this->connect();
    }

    private function connect()
    {
        $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4";

        try {
            $this->db = new PDO(
                $dsn,
                $this->user, 
                $this->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch (PDOException $error) {
            error_log("Erreur de connexion à la base de données : " . $error->getMessage());
            die("Erreur de connexion à la base de données.");
        }
    }

    public function getDb()
    {
        return $this->db;
    }
}
?>

