<?php

namespace config;

use PDO;
use PDOException;

class Database{
    private $host = "localhost";
    private $db_name = "nombre_de_tu_base_de_datos"; //hay que rellenar con el nombre de la base de datos
    private $username = "root";
    private $password = "";
    public $conn;

    //start the connection
    public function getConnection(){
        $this->conn = null;

        try{
            $this->conn = new PDO("mysql:host=".$this->host.";dbname=".$this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Error de conexion: ".$exception->getMessage();
        }

        return $this->conn;
    }

    //stop the connection
    public function closeConnection(){
        $this->conn = null;
    }
}
