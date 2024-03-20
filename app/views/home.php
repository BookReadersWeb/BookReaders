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
    <link rel="stylesheet" href="css/styles.css">
    <title>Home</title>    
</head>
<body>
    <div class="container mx-auto mt-5 ">
        <div class="md:w-1/2 md:mx-auto">
            <div class="card">
                <div class="card-body flex justify-between">
                    <h2 class="card-title">¡Bienvenido, <?php echo htmlspecialchars($userData['username']); ?>!</h2>
                    <?php if ($userData['role'] === 'admin'): ?>
                        <a href="adminpanel" class="text-blue-500">
                            <button type="button" class="px-4 py-2 rounded-md bg-blue-200 hover:bg-blue-300 focus:outline-none focus:bg-blue-300">Ir al panel de administración</button>
                        </a>
                    <?php endif; ?>
                    <form action="logout" method="post" onsubmit="return confirm('¿Estás seguro de que quieres cerrar tu sesión?');">
                        <button type="submit" class="btn-danger px-4 py-2 rounded-md bg-red-500 hover:bg-red-600 focus:outline-none focus:bg-red-600">Cerrar sesión</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

<!-- TODO: Borrar las clases absolute bottom-0 y w-full. Ahora estan para que se vea el footer!! -->
<footer class="bg-gray-900 absolute bottom-0 w-full"> 
    <div class="mx-auto w-full max-w-screen-xl p-8">
        <div class="md:flex md:justify-evenly md:gap-64">
            <div class="mb-6 md:mb-0">
                <a href="home" class="flex items-center">
                    <img src="#" class="h-8 me-3 text-white" alt="Logo BookReaders" />
                    <span class="self-center text-2xl font-semibold whitespace-nowrap text-white"></span>
                </a>
            </div>
            <div class="grid grid-cols-2 md:gap-20 lg:gap-20 sm:grid-cols-3">
                    <div>
                        <h2 class="mb-6 text-sm font-semibold uppercase text-white">Recursos</h2>
                        <ul class="text-gray-400 font-medium">
                            <li class="mb-4">
                                <a href="#" class="hover:underline">Sobre nosotros</a>
                            </li>
                            <li class="mb-4">
                                <a href="#" class="hover:underline">Términos y condiciones</a>
                            </li>
                            <li class="mb-4">
                                <a href="#" class="hover:underline">Política de privacidad</a>
                            </li>
                            <li>
                                <a href="#" class="hover:underline">FAQ</a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h2 class="mb-6 text-sm font-semibold uppercase text-white">Información</h2>
                        <ul class="text-gray-400 font-medium">
                            <li class="mb-4">
                                <a href="#" class="hover:underline">Email: email@gmail.com</a>
                            </li>
                            <li class="mb-4">
                                <a href="#" class="hover:underline">Teléfono: 000 000 000</a>
                            </li>
                            <li>
                                <a href="#" class="hover:underline">Dirección: Casa de Jon</a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h2 class="mb-6 text-sm font-semibold uppercase text-white">Redes Sociales</h2>
                        <ul class="text-gray-400 font-medium">
                            <li class="mb-4">
                                <a href="#" class="flex items-center gap-2 -ml-1 text-gray-400 hover:text-white">
                                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 8 19">
                                        <path fill-rule="evenodd" d="M6.135 3H8V0H6.135a4.147 4.147 0 0 0-4.142 4.142V6H0v3h2v9.938h3V9h2.021l.592-3H5V3.591A.6.6 0 0 1 5.592 3h.543Z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>Facebook</span>
                                </a>
                            </li>
                            <li class="mb-4">
                                <a href="#" class="flex items-center gap-2 -ml-1 text-gray-400 hover:text-white">
                                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 17">
                                        <path fill-rule="evenodd" d="M20 1.892a8.178 8.178 0 0 1-2.355.635 4.074 4.074 0 0 0 1.8-2.235 8.344 8.344 0 0 1-2.605.98A4.13 4.13 0 0 0 13.85 0a4.068 4.068 0 0 0-4.1 4.038 4 4 0 0 0 .105.919A11.705 11.705 0 0 1 1.4.734a4.006 4.006 0 0 0 1.268 5.392 4.165 4.165 0 0 1-1.859-.5v.05A4.057 4.057 0 0 0 4.1 9.635a4.19 4.19 0 0 1-1.856.07 4.108 4.108 0 0 0 3.831 2.807A8.36 8.36 0 0 1 0 14.184 11.732 11.732 0 0 0 6.291 16 11.502 11.502 0 0 0 17.964 4.5c0-.177 0-.35-.012-.523A8.143 8.143 0 0 0 20 1.892Z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>Twitter</span>
                                </a>
                            </li>
                            <li class="mb-4">
                                <a href="#" class="flex items-center gap-2 -ml-1 text-gray-400 hover:text-white">
                                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 17">
                                        <path fill-rule="evenodd" d="M20 1.892a8.178 8.178 0 0 1-2.355.635 4.074 4.074 0 0 0 1.8-2.235 8.344 8.344 0 0 1-2.605.98A4.13 4.13 0 0 0 13.85 0a4.068 4.068 0 0 0-4.1 4.038 4 4 0 0 0 .105.919A11.705 11.705 0 0 1 1.4.734a4.006 4.006 0 0 0 1.268 5.392 4.165 4.165 0 0 1-1.859-.5v.05A4.057 4.057 0 0 0 4.1 9.635a4.19 4.19 0 0 1-1.856.07 4.108 4.108 0 0 0 3.831 2.807A8.36 8.36 0 0 1 0 14.184 11.732 11.732 0 0 0 6.291 16 11.502 11.502 0 0 0 17.964 4.5c0-.177 0-.35-.012-.523A8.143 8.143 0 0 0 20 1.892Z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>Instagram</span>
                                </a>
                            </li>
                        </ul>
                    </div>
            </div>
        </div>
        <hr class="my-6 sm:mx-auto border-gray-500 lg:my-8" />
        <div class="sm:flex sm:items-center sm:justify-center">
            <div class="flex flex-col gap-2">
                <span class="text-sm sm:text-center text-gray-400">© 2024 <a href="home" class="hover:underline">BookReaders</a>. All Rights Reserved.</span>
                <span class="text-sm  text-gray-400">Algunas imágenes utilizadas bajo licencia Creative Commons. Atribución a los respectivos autores.</span>
            </div>
        </div>
    </div>
</footer>
</html>
