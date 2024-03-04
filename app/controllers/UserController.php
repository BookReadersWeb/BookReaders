<?php

namespace controllers;

use models\User;

class UserController
{
    private $userModel;

    public function __construct(User $user)
    {
        $this->userModel =  $user;
    }

    public function createUser($username, $email, $password, $role)
    {
        $this->userModel->username = $username;
        $this->userModel->email = $email;
        $this->userModel->password = $password;
        $this->userModel->role = $role;

        if ($this->userModel->createUser()) {
            return true;
        } else {
            return false;
        }
    }

    public function isUsernameExists($username)
    {
        //TODO - Funcional pero mal implementado
        return $this->userModel->isUsernameExists($username);
    }

    public function isEmailExists($email)
    {
        //TODO - Funcional pero mal implementado
        return $this->userModel->isEmailExists($email);
    }

}