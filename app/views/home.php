<?php

session_start();

if (!isset($_SESSION['userData']) || empty($_SESSION['userData']['username'])) {
    header('Location: login');
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
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-body d-flex justify-content-between">
                        <h2 class="card-title">¡Bienvenido, <?php echo htmlspecialchars($userData['username']); ?>!</h2>
						<?php if ($userData['role'] === 'admin'): ?>
                            <a href="adminpanel">
                                <button type="button">Ir al panel de administración</button>
                            </a>
                        <?php endif; ?>
                        <form action="logout" method="post" onsubmit="return confirm('¿Estás seguro de que quieres cerrar tu sesión?');">
                            <button type="submit" class="btn btn-danger">Cerrar sesión</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="lib/jquery-3.7.1/js/jquery-3.7.1.min.js"></script>
    <script src="lib/bootstrap-5.3.3/js/bootstrap.min.js"></script>
</body>
</html>
