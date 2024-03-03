<?php

namespace config;

use PDO;
use PDOException;

class Database{
    private $host = "localhost";
    private $db_name = "BookReadersDB";
    private $username = "root";
    private $password = "";
    public $conn;

    // start the connection
    public function getConnection(){
        $this->conn = null;

        try{
            $this->conn = new PDO("mysql:host=".$this->host.";dbname=".$this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);            
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Error de conexion: ".$exception->getMessage();
        }

        return $this->conn;
    }

    // stop the connection
    public function closeConnection(){
        $this->conn = null;
    }
    
    // create database
    public function createDatabase(){
        try {
            $this->conn = new PDO("mysql:host=".$this->host, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            $sql = "CREATE DATABASE IF NOT EXISTS " . $this->db_name;
            $this->conn->exec($sql);
            
            // If exists, close the connection and open a new one
            if ($this->conn) {
                $this->getConnection();
            }
        } catch(PDOException $e) {
            echo "Error al crear la base de datos: " . $e->getMessage();
        }
    }

    // create users table
    public function createUsersTable(){
        try {
            $sql = "CREATE TABLE IF NOT EXISTS users (
                user_id INT AUTO_INCREMENT PRIMARY KEY,
                email VARCHAR(255) NOT NULL,
                username VARCHAR(255) NOT NULL,
                password VARCHAR(255) NOT NULL,
                role VARCHAR(50) DEFAULT 'user',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )";
            $this->conn->exec($sql);
            // echo "Tabla de usuarios creada exitosamente.";
        } catch(PDOException $e) {
            echo "Error al crear la tabla de usuarios: " . $e->getMessage();
        }
    }

    // create default admin user
    public function createDefaultAdminUser(){
        try {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE role = 'admin'");
            $stmt->execute();
            $existingAdmin = $stmt->fetch(PDO::FETCH_ASSOC);

            if(!$existingAdmin){
                $username = "admin";
                $email = "admin@gmail.com";
                $password = password_hash("admin", PASSWORD_DEFAULT);

                $stmt = $this->conn->prepare("INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, 'admin')");
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $password);
                $stmt->execute();

                // echo "Usuario administrador creado exitosamente.";
            } else {
                // echo "Ya existe un usuario administrador en la base de datos.";
            }
        } catch(PDOException $e) {
            echo "Error al crear el usuario administrador: " . $e->getMessage();
        }
    }
}

?>