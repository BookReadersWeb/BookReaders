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
    <link rel="stylesheet" href="lib/bootstrap-5.3.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
    <title>Home</title>    
</head>
<body>
    <h1>Bienvenido <?php echo htmlspecialchars($userData['username']); ?></h1>
    <form action="logout" method="post" onsubmit="return confirm('¿Estás seguro de que quieres cerrar tu sesión?');">
        <button type="submit">Cerrar sesión</button>
    </form>
    
    <script src="lib/jquery-3.7.1/js/jquery-3.7.1.min.js"></script>
    <script src="lib/bootstrap-5.3.3/js/bootstrap.min.js"></script>
</body>
</html>
