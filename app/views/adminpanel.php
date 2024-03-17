<?php

require_once '../app/controllers/UserController.php';
require_once '../app/models/User.php';

session_start();
//doble comprobación porque se salta la primera por alguna razón
if (!isset($_SESSION['userData']) || $_SESSION['userData']['role'] !== 'admin') {
    header('Location: home');
    exit;
}


$userController = new controllers\UserController(new models\User());
$users = $userController->readAllUsers();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_user'])) {
        $user_id = $_POST['user_id'];
        
        if ($userController->deleteUser($user_id)) {
            echo "Usuario eliminado con éxito.";
            header("Location: adminpanel");
            exit;
        } else {
            echo "Error al eliminar el usuario.";
        }
    } elseif (isset($_POST['edit_user'])) {
        
        header("Location: edit_user");
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Panel de administración</title>
</head>

<body>
    <div class="flex justify-center items-center h-screen">
        <div class="bg-white p-8 rounded shadow-2xl w-1/3">
            <h2 class="text-2xl font-bold mb-4">Lista de Usuarios</h2>

            <form action="register" method="post">
                <button type="submit" name="add_user" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:bg-blue-600">Añadir Usuario</button>
            </form>

            <?php if (!empty($users)): ?>
                <ul class="mt-4">
                    <?php foreach ($users as $user): ?>
                        <li class="mb-2">
                            <?php echo $user['username']; ?> - <?php echo $user['email']; ?>
                            <span class="ml-2 text-gray-500"> -> <?php echo $user['role']; ?></span>
                            <form class="inline-block ml-2" action="edit_user" method="post">
                                <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                                <?php if ($user['username'] !== 'admin' && $user['username'] !== $_SESSION['userData']['username']): ?>
                                    <button type="submit" name="edit_user" class="px-2 py-1 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:bg-green-600">Editar</button>
                                <?php endif; ?>
                            </form>
                            <form class="inline-block ml-2" action="adminpanel" method="post">
                                <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                                <?php if ($user['username'] !== 'admin' && $user['username'] !== $_SESSION['userData']['username']): ?>
                                    <button type="submit" onclick="return confirm('¿Seguro que quieres eliminar este usuario?');" name="delete_user" class="px-2 py-1 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:bg-red-600">Eliminar</button>
                                <?php endif; ?>
                            </form>                    
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p class="mt-4">No hay usuarios para mostrar.</p>
            <?php endif; ?>
            <a href="home" class="mt-4 inline-block">
                <button type="button" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:bg-gray-600">Volver a Home</button>
            </a>
        </div>
    </div>
</body>

</html>
