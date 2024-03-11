<?php

require_once '../app/controllers/UserController.php';
require_once '../app/models/User.php';

$userController = new controllers\UserController(new models\User());

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['edit_user'])) {
        $user_id = $_POST['user_id'];

        $user = $userController->readByUserID($user_id);

    } else if (isset($_POST['update_user'])) {
        $user_id = $_POST['user_id'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['new_password'];
        $role = $_POST['role'];

        if ($userController->updateUser($user_id, $username, $email, $password, $role)) {
            echo "Usuario actualizado con éxito.";
            header("Location: adminpanel");
            exit;
        } else {
            echo "Error al actualizar el usuario.";
        }

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
    <h2>Editar Usuario</h2>
    <form action="edit_user" method="post">
        <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
        <input type="text" name="username" value="<?php echo $user['username']; ?>">
        <input type="email" name="email" value="<?php echo $user['email']; ?>">
        <input type="password" name="new_password" placeholder="Nueva contraseña">
        <select name="role">
            <option value="user" <?php if ($user['role'] === 'user') echo 'selected'; ?>>Usuario</option>
            <option value="admin" <?php if ($user['role'] === 'admin') echo 'selected'; ?>>Administrador</option>
        </select>
        <button type="submit" name="update_user">Actualizar</button>
        
    </form>
    <a href="adminpanel">Volver</a>
    <script src="lib/bootstrap-5.3.3/js/bootstrap.bundle.min.js"></script>    
</body>
</html>