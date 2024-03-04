<?php

namespace models;
use PDO;

require_once 'Database.php';

class User
{  
    private $conn;
    private $table_name = "users";

    // Propiedades del usuario
    private $user_id;
    private $username;
    private $email;
    private $password;
    private $role;

    //Constructor to connect to the database
    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    //Method to create a new user in the database
    public function createUser($username, $email, $password, $role)
    {
        try {
            //Check if username already exist
            if ($this->isUsernameExists($username)) {
                
                return ["success" => false, "message" => "El nombre de usuario ya existe."];
            }

            //Check if email already exist
            if ($this->isEmailExists($email)) {
                
                return return ["success" => false, "message" => "El correo electrónico ya está registrado."];
            }

            //Prepare the query to insert a new user
            $stmt = $this->db->prepare("INSERT INTO users (username, email, password, role) VALUES (:username, :email, :password, :role)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':role', $role);
            $stmt->execute();

            return true;
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
            $stmt = $this->db->prepare("SELECT * FROM users WHERE user_id = :user_id");
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
            $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :identifier OR email = :identifier");
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
            $stmt = $this->db->prepare("SELECT * FROM users");
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
            //Check if the username already exists for other users
            if ($this->isUsernameExists($username)) {
                
                return ["success" => false, "message" => "El nombre de usuario ya existe."];
            }

            //Check if the email already exists for other users
            if ($this->isEmailExists($email)) {
                
                return ["success" => false, "message" => "El correo electrónico ya está registrado."];
            }

            //Prepare the query to update user information
            $stmt = $this->db->prepare("UPDATE users SET username = COALESCE(:username, username), email = COALESCE(:email, email), password = COALESCE(:password, password), role = COALESCE(:role, role) WHERE user_id = :user_id");
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
            $stmt = $this->db->prepare("DELETE FROM users WHERE user_id = :user_id");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            echo "Error al eliminar usuario: " . $e->getMessage();
            die();
        }
    }

    //Method to check if a username already exists in the database
    private function isUsernameExists($username)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    //Method to check if an email already exists in the database
    private function isEmailExists($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
}
?>