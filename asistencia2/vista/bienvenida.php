/*hola*/
<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../index.php');
    exit();
}

$usuario = $_SESSION['usuario']; // contiene ['Nombre', 'Apellido', 'Rol', ...]
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Bienvenida</title>
    <link rel="stylesheet" href="../assets/css/bienvenida.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    <!-- Encabezado -->
    <header>
        <div class="welcome-message">
            <h1>¡Bienvenido <?php echo htmlspecialchars($usuario['Nombre']); ?>!</h1>
            <p>Has iniciado sesión como <?php echo htmlspecialchars($usuario['Rol']); ?></p>
        </div>

        <div class="menu-container">
            <!-- Ícono de usuario -->
            <div class="user-icon">
                <i class="fa-solid fa-user"></i>
            </div>

            <!-- Menú desplegable -->
            <div class="dropdown-menu">
                <div class="user-info">
                    <i class="fa-solid fa-circle-user"></i>
                    <span><?php echo htmlspecialchars($usuario['Nombre'] . " " . $usuario['Apellido']); ?></span>
                </div>
                <a href="perfil.php"><i class="fa-solid fa-user"></i> Perfil</a>
                <a href="../index.php?action=cerrarSesion"><i class="fa-solid fa-right-from-bracket"></i> Cerrar Sesión</a>
            </div>
        </div>
    </header>

    <!-- Contenedor principal -->
    <div class="container">
        <p> Disfruta de tu sesión.</p>
    </div>

    <script>
        // Script para menú desplegable
        const userIcon = document.querySelector('.user-icon');
        const dropdown = document.querySelector('.dropdown-menu');

        userIcon.addEventListener('click', () => {
            dropdown.classList.toggle('active');
        });

        document.addEventListener('click', (e) => {
            if (!userIcon.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.remove('active');
            }
        });
    </script>
</body>

</html>
