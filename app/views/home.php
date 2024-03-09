<?php

session_start();

if (!isset($_SESSION['userData']) || empty($_SESSION['userData']['username'])) {
    header('Location: login.php');
    exit;
} else {
    $userData = $_SESSION['userData'];
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>    
</head>
<body>
    <h1>Bienvenido <?php echo htmlspecialchars($userData['username']); ?></h1>
    <form action="logout" method="post" onsubmit="return confirm('¿Estás seguro de que quieres cerrar tu sesión?');">
        <button type="submit">Cerrar sesión</button>
    </form>
</body>
</html>
