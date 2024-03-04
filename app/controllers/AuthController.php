<?php

namespace controllers;
use models\User;

class AuthController
{
    private $userModel;

    public function __construct(User $user)
    {
        $this->userModel =  $user;
    }
	public function login($email, $password)
	{
		//security
		$email = htmlspecialchars(strip_tags($email));
		$password = htmlspecialchars(strip_tags($password));

		$userData = $this->userModel->readByUsernameOrEmail($email);

		if (!$userData) {
			echo "Usuario no encontrado";
			die();
		}
		if (password_verify($password, $userData['password'])) 
		{
			// echo "Usuario logueado";
			session_start();
			$_SESSION['email'] = $userData['email'];
			$_SESSION['role'] = $userData['role'];
			return true;
		}
		 else 
		{
			// echo "Contraseña incorrecta";
			return false;
		}
	}

	public function logout()
	{
		session_unset();
		session_destroy();
		header('Location: /');
	}
}
