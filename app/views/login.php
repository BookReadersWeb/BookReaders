<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../app/models/User.php';
    require_once '../app/controllers/UserController.php';
    require_once '../app/controllers/AuthController.php';

    $user = new models\User();
    $authController = new controllers\AuthController($user);

    if ($authController->login()) {
        header('Location: home');
    } else {
        $errorMessage = "Usuario o contraseña incorrectos";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Login</title>
</head>
<body>
    <div class="flex justify-center items-center h-screen">
        <div class="bg-white p-8 rounded shadow-2xl w-1/3">
            <h2 class="text-3xl font-bold mb-4">Login</h2>
            <form action="" method="POST">
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input type="email" class="border-2 border-gray-400 p-2 w-full" id="email" name="email" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Contraseña</label>
                    <input type="password" class="border-2 border-gray-400 p-2 w-full" id="password" name="password" required>
                </div>
                <div class="flex justify-center">
                    <button type="submit"class="bg-blue-500 text-white p-2 w-full">Login</button>
                </div>

                <?php
                if (!empty($errorMessage)) {
                    echo "<div class='text-red-600 mt-4'>$errorMessage</div>";
                }
                ?>

                <div class="text-center mt-3">
                    <a href="register" class="text-indigo-600">Registrarse</a>
                </div>
            </form>           
        </div>
    </div>
</body>
<!-- <body class="flex items-center justify-center h-screen">
    <div class="container mx-auto">
        <div class="flex justify-center">
            <div class="w-full md:w-1/2">
                <div class="bg-blue-900 shadow-md rounded-md">
                    <div class="bg-orange-300 py-4 px-6">
                        <h3 class="text-center">Login</h3>
                    </div>
                    <div class="p-6">
                        <form action="" method="POST">
                            <div class="mb-4">
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" id="email" name="email" required>
                            </div>
                            <div class="mb-4">
                                <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                                <input type="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" id="password" name="password" required>
                            </div>
                            <div class="flex justify-center">
                                <button type="submit" class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Login</button>
                            </div>

                            <?php
                            if (!empty($errorMessage)) {
                                echo "<div class='text-red-600 mt-4'>$errorMessage</div>";
                            }
                            ?>

                            <div class="text-center mt-3">
                                <a href="register" class="text-indigo-600">Registrarse</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body> -->
</html>
