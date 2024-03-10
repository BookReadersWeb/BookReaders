<?php

namespace controllers;
use models\User;

class UserController
{
    private $userModel;

    public function __construct(User $user)
    {
        $this->userModel = new $user;
    }

    public function createUser($username, $email, $password, $role)
    {
        $this->userModel->username = $username;
        $this->userModel->email = $email;
        $this->userModel->password = $password;
        $this->userModel->role = $role;

        if ($this->userModel->createUser()) 
		{
            return true;
        } 
		else 
		{
            return false;
        }
    }

	public function readByUserID($user_id)
	{
		if ($user_id == null) {
			echo "El ID de usuario no puede estar vacío";
			return false;
		}
		return $this->userModel->readByUserID($user_id);
	}

	public function readByUsernameOrEmail($username)
	{
		if ($username == null)
		{
			echo "El nombre de usuario no puede estar vacío";
			return false;
		}
		return $this->userModel->readByUsernameOrEmail($username);
	}

	public function readAllUsers()
	{
		//TODO - Funcional pero mal implementado
		return $this->userModel->readAll();
	}

	public function updateUser($user_id, $username, $email, $password, $role)
	{
		//All other fields will be nulled, so I only check for user_id
		if ($user_id == null) 
		{
			return false;
		}
		if ($this->userModel->updateUser($user_id, $username, $email, $password, $role)) 
		{
			return true;
		} 
		else 
		{
			return false;
		}
	}

	public function deleteUser($user_id)
	{
		if ($user_id == null) 
		{
			echo "El ID de usuario no puede estar vacío";
			return false;
		}
		if ($this->userModel->deleteUser($user_id)) 
		{
			return true;
		}
		else 
		{
			return false;
		}
	}

    public function isUsernameExists($username)
    {
        if ($username == null)
		{
			echo "El nombre de usuario no puede estar vacío";
			return false;
		}
        return $this->userModel->isUsernameExists($username);
    }

    public function isEmailExists($email)
    {
        if ($email == null)
		{
			echo "El email no puede estar vacío";
			return false;
		}
        return $this->userModel->isEmailExists($email);
    }

	public function isUsernameExistsForUpdate($user_id, $username)
	{
		if ($username == null || $user_id == null)
		{
			echo "El nombre de usuario no puede estar vacío";
			return false;
		}
		return $this->userModel->isUsernameExistsForUpdate($user_id, $username);
	}

	public function isEmailExistsForUpdate($user_id, $email)
	{
		//TODO - Funcional pero mal implementado
		return $this->userModel->isEmailExistsForUpdate($user_id, $email);
	}
}