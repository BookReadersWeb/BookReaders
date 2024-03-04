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
    <link rel="stylesheet" href="lib/bootstrap-5.3.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <title>Register</title>
</head>
<body class="d-flex align-items-center justify-content-center vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Registro de usuarios</h3>
                    </div>
                    <div class="card-body">
                        <?php
                            if (!empty($errorMessage)) {
                                echo "<div class='alert alert-danger' role='alert'>$errorMessage</div>";
                            } elseif (!empty($successMessage)) {
                                echo "<div class='alert alert-success' role='alert'>$successMessage</div>";
                            }
                            else{
                        ?>
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="repeatPassword" class="form-label">Repetir contraseña</label>
                                <input type="password" class="form-control" id="repeatPassword" name="repeatPassword" required>
                            </div>
                            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') { ?>
                            <div class="mb-3">
                                <label for="role" class="form-label">Rol</label>
                                <select class="form-select" id="role" name="role">
                                    <option value="user">Usuario</option>
                                    <option value="admin">Administrador</option>
                                </select>
                            </div>
                            <?php } ?>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Registrarse</button>
                            </div>
                        </form>
                        <?php
                            }
                            ?>
                        <div class="d-flex justify-content-center gap-5 mt-3">
                            <?php if(isset($_SESSION['success']) || isset($_SESSION['alert'])) { ?>
                            <a href="register">Volver</a>
                            <?php
                            }
                            ?>
                            <a href="login">Iniciar sesión</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="lib/jquery-3.7.1/js/jquery-3.7.1.min.js"></script>
    <script src="lib/bootstrap-5.3.3/js/bootstrap.min.js"></script>
</body>
</html>
