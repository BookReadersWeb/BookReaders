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
			// echo "Usuario no encontrado";
			return false;
		}

		if (password_verify($password, $userData['password'])) 
		{
			// echo "Usuario logueado";
			session_start();
			$_SESSION['userData'] = $userData;
			return true;
		} else {
			// echo "Contraseña incorrecta";
			return false;
		}
	}


    public static function logout() {
        session_start();
		session_unset();
        session_destroy();

		header('Location: login');
    }

    public static function isLoggedIn() {
        session_start();
        return isset($_SESSION['user']);
    }

    public static function getUser() {
        session_start();
        return isset($_SESSION['user']) ? $_SESSION['user'] : null;
    }
}
