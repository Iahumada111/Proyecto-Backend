<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="assets/css/login.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container">
        <h1>Inicio de Sesión</h1>
        <form method="POST" action="index.php?action=iniciarSesion">
            <label for="email">Correo electrónico:</label>
            <input type="email" name="email" required>

            <label for="password">Contraseña:</label>
            <input type="password" name="password" required>

            <button type="submit">Iniciar Sesión</button>
        </form>

        <p>¿No estás registrado? 
            <a href="?action=mostrarRegistro">Regístrate aquí</a>
        </p>
    </div>

    <!-- SweetAlert para error de login -->
    <?php if (isset($errorLogin) && $errorLogin): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Credenciales inválidas',
            text: 'El correo o la contraseña son incorrectos. Vuelve a intentarlo.',
            confirmButtonText: 'Aceptar',
            confirmButtonColor: '#d33'
        });
    </script>
    <?php endif; ?>

    <!-- SweetAlert para registro exitoso -->
    <?php if (isset($registroExitoso) && $registroExitoso): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: '¡Registro exitoso!',
            text: 'Ahora puedes iniciar sesión con tus credenciales',
            confirmButtonText: 'Iniciar sesión',
            confirmButtonColor: '#4a90e2'
        });
    </script>
    <?php endif; ?>
</body>
</html>

