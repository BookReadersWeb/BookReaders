<?php

namespace models;
use PDO;

require_once "../app/config/Database.php";

use config\Database;

class User
{  
    private $conn;
    private $table_name = "users";

    // Propiedades del usuario
    public $user_id;
    public $username;
    public $email;
    public $password;
    public $role;

    //Constructor to connect to the database
    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    //Method to create a new user in the database
    public function createUser()
    {
        try {
            //Check if username or email already exist
            if ($this->isUsernameExists($this->username) || $this->isEmailExists($this->email)) {
                //TODO - Necesitamos caso por caso para saber si el USER o el EMAIL ya existen
                // echo "El usuario o el email ya existen";
                return false;
            }
            
            $query = "INSERT INTO " . $this->table_name . " (username, email, password, role) VALUES (:username, :email, :password, :role)";
            
            // Preparamos la sentencia SQL para insertar los datos
            $stmt = $this->conn->prepare($query);
            
            // Sanitizar los datos
            $this->username = htmlspecialchars(strip_tags($this->username));
            $this->email = htmlspecialchars(strip_tags($this->email));
            $this->password = htmlspecialchars(strip_tags($this->password));
            $this->role = htmlspecialchars(strip_tags($this->role));
            
            // Vincular los datos
            $stmt->bindParam(':username', $this->username);
            $stmt->bindParam(':email', $this->email);
            $password_hash = password_hash($this->password, PASSWORD_DEFAULT);
            $stmt->bindParam(':password', $password_hash);
            $stmt->bindParam(':role', $this->role);

            // Ejecutar la consulta
            if($stmt->execute()) {
                return true;
            }
            
            return false;
            
        } catch (PDOException $e) {
            echo "Error al crear usuario: " . $e->getMessage();
            die();
        }
    }

    //Method to obtain a user's information by user_id
    public function readByUserId($user_id)
    {
        try {
            //Prepare the query to get a user by their ID
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE user_id = :user_id");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();

            //Get next row of execution results as associative array
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener usuario por ID: " . $e->getMessage();
            die();
        }
    }

    //Method to obtain user information by username or email (identifier)
    public function readByUsernameOrEmail($identifier)
    {
        try {
            //Prepare the query to obtain a user by their username or email
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = :identifier OR email = :identifier");
            $stmt->bindParam(':identifier', $identifier);
            $stmt->execute();

            //Get next row of execution results as associative array
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener usuario por nombre de usuario o email: " . $e->getMessage();
            die();
        }
    }

    //Method to get all users
    public function readAll()
    {
        try {
            //Prepare the query to obtain a user by their username or email
            $stmt = $this->conn->prepare("SELECT * FROM users");
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener todos los usuarios: " . $e->getMessage();
            die();
        }
    }

    //Method to update a user's information by user_id
    //Default to null for the user to give it a new value
    public function updateUser($user_id, $username = null, $email = null, $password = null, $role = null)
    {
        try {
            //Check if the username or email already exists for other users
            if ($this->isUsernameExistsForUpdate($user_id, $username) || $this->isEmailExistsForUpdate($user_id, $email)) {
                
                //TODO - Necesitamos caso por caso para saber si el USER o el EMAIL ya existen
                return false;
            }

            //Prepare the query to update user information
            $stmt = $this->conn->prepare("UPDATE users SET username = COALESCE(:username, username), email = COALESCE(:email, email), password = COALESCE(:password, password), role = COALESCE(:role, role) WHERE user_id = :user_id");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':role', $role);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            echo "Error al actualizar usuario: " . $e->getMessage();
            die();
        }
    }

    //Method to delete a user from the database by its user_id
    public function deleteUser($user_id)
    {
        try {
            //Prepare the query to delete a user by their ID
            $stmt = $this->conn->prepare("DELETE FROM users WHERE user_id = :user_id");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            echo "Error al eliminar usuario: " . $e->getMessage();
            die();
        }
    }

    //Method to check if a username already exists in the database
    public function isUsernameExists($username)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    //Method to check if an email already exists in the database
    public function isEmailExists($email)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    //Method to check if a username already exists in the database when updating
    public function isUsernameExistsForUpdate($user_id, $username)
    {
        //TODO - Diria que es el mismo que el de arriba isUsernameExists. Lo revisamos
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = :username AND user_id != :user_id");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    //Method to check if an email already exists in the database when updating
    public function isEmailExistsForUpdate($user_id, $email)
    {
        //TODO - Diria que es el mismo que el de arriba isEmailExists. Lo revisamos
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email AND user_id != :user_id");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
}
?>