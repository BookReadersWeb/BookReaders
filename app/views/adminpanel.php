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


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
    $user_id = $_POST['user_id'];
    
    if ($userController->deleteUser($user_id)) {
        echo "Usuario eliminado con éxito.";
        header("Location: adminpanel");
    } else {
        echo "Error al eliminar el usuario.";
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="lib/bootstrap-5.3.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <title>Panel de administración</title>
</head>

<body>
    <h2>Lista de Usuarios</h2>

    <?php if (!empty($users)): ?>
        <ul>
            <?php foreach ($users as $usern): ?>
                <li>
                    <?php echo $usern['username']; ?> - <?php echo $usern['email']; ?>
                    <form action="adminpanel" method="post" style="display: inline;">
                        <input type="hidden" name="user_id" value="<?php echo $usern['user_id']; ?>">
						<?php if ($usern['username'] !== 'admin'): ?>
                        	<button type="submit" onclick="return confirm('¿Seguro que quieres eliminar este usuario?');" name="delete_user">Eliminar</button>
						<?php endif; ?>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No hay usuarios para mostrar.</p>
    <?php endif; ?>
	<a href="home">
  		<button type="button">Volver a Home</button>
	</a>
</body>
</html>
