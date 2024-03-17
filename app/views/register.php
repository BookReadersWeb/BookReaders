<?php

require_once "../app/models/User.php";
require_once "../app/controllers/UserController.php";

use models\User;
use controllers\UserController;

session_start();

unset($_SESSION['success']);
unset($_SESSION['alert']);

if (!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['repeatPassword'])){
    
    $user = new User();

    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repeatPassword = $_POST['repeatPassword'];
    $role = isset($_POST['role']) ? $_POST['role'] : 'user';
    
    $userController = new UserController($user);

    if ($userController->isUsernameExists($username)) {
        $_SESSION['alert'] = "El nombre de usuario ya existe";
    } else if ($userController->isEmailExists($email)) {
        $_SESSION['alert'] = "El email ya existe";
    } else if ($password !== $repeatPassword) {
        $_SESSION['alert'] = "Las contraseñas no coinciden";
    }
    else {
        if($userController->createUser($username, $email, $password, $role)) {
            $_SESSION['success'] = "Usuario registrado correctamente";            
        } else {
            $_SESSION['alert'] = "Error al registrar el usuario";
        }
    }
    
    // Verificar si hay un mensaje de éxito
    $successMessage = isset($_SESSION['success']) ? $_SESSION['success'] : '';

    // Verificar si hay un mensaje de alerta si no hay un mensaje de éxito
    $errorMessage = !empty($successMessage) ? '' : (isset($_SESSION['alert']) ? $_SESSION['alert'] : '');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Register</title>
</head>
<body>
    <div class="flex justify-center items-center h-screen">
        <div class="bg-white p-8 rounded shadow-2xl w-1/3">
            <h2 class="text-3xl font-bold mb-4">Register</h2>
            <form action="" method="POST">
                <div class="mb-4">
                    <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Nombre de usuario</label>
                    <input type="text" class="border-2 border-gray-400 p-2 w-full" id="username" name="username" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input type="email" class="border-2 border-gray-400 p-2 w-full" id="email" name="email" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Contraseña</label>
                    <input type="password" class="border-2 border-gray-400 p-2 w-full" id="password" name="password" required>
                </div>
                <div class="mb-4">
                    <label for="repeatPassword" class="block text-gray-700 text-sm font-bold mb-2">Repetir contraseña</label>
                    <input type="password" class="border-2 border-gray-400 p-2 w-full" id="repeatPassword" name="repeatPassword" required>
                </div>
                <div class="mb-4">
                    <label for="role" class="block text-gray-700 text-sm font-bold mb-2">Rol</label>
                    <select name="role" id="role" class="border-2 border-gray-400 p-2 w-full">
                        <option value="user">Usuario</option>
                        <option value="admin">Administrador</option>
                    </select>
                </div>
                <div class="flex justify-center">
                    <button type="submit"class="bg-blue-500 text-white p-2 w-full">Register</button>
                </div>

                <?php
                if (!empty($successMessage)) {
                    echo "<div class='text-green-600 mt-4'>$successMessage</div>";
                } else if (!empty($errorMessage)) {
                    echo "<div class='text-red-600 mt-4'>$errorMessage</div>";
                }
                ?>

                <div class="text-center mt-3">
                    <a href="login" class="text-indigo-600">Iniciar sesión</a>
                </div>
            </form>
        </div>
    </div>    
</body>

</html>
