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
	public function login()
	{
		//security
		$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
		$password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);

		$userData = $this->userModel->readByUsernameOrEmail($email);

		if (!$userData) {
			echo "Usuario no encontrado";
			return false;
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
