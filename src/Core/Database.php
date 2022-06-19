<?php

namespace Core;

use Core\Response;

class Database {
    private string $host;
    private string $user;
    private string $password;
    private string $dbName;

    private $connection = null;

    public function __construct($dbConfig = []){
        $this->host = $dbConfig['host'] ?? 'localhost';
        $this->user = $dbConfig['user'] ?? '';
        $this->password = $dbConfig['password'] ?? '';
        $this->dbName = $dbConfig['db_name'] ?? '';

        //connect to database;
        $this->connect();
    }

    protected function connect(){
        if($this->connection == null){
            try{
                $dsn = "mysql:host=$this->host;dbname=$this->dbName;charset=UTF8";
                $connection = new \PDO($dsn,$this->user, $this->password);
                if($connection){
                    $connection->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
                    $this->connection = $connection;
                }
            }catch (\PDOException $e){
                // TODO :: change to more proper error hangling.
                Response::statusCode(500);
                Response::json([
                    "Error" => "Database Connection Error",
                    "Message" => $e->getMessage()
                ]);
                die();
            }
        }
    }

    public function getConnection() : PDO{
        return $this->connection;
    }

    public function disconnect(){
        $this->connection = null;
    }
}