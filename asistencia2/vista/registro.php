<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="assets/css/registro.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="container">
    <h1>Registro de Usuario</h1>
    <form method="POST" action="index.php?action=registrar">

        <!-- Nombre y Apellido en la misma fila -->
        <div class="form-group">
            <div>
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" required>
            </div>
            <div>
                <label for="apellido">Apellido:</label>
                <input type="text" name="apellido" required>
            </div>
        </div>

        <!-- Email y Contraseña en dos columnas -->
        <div class="form-group">
            <div>
                <label for="email">Correo electrónico:</label>
                <input type="email" name="email" required>
            </div>
            <div>
                <label for="password">Contraseña:</label>
                <input type="password" name="password" required>
            </div>
        </div>

        <!-- Rol y Matrícula en dos columnas -->
        <div class="form-group">
            <div>
                <label for="rol">Rol:</label>
                <select name="rol" required>
                    <option value="">-- Selecciona un rol --</option>
                    <option value="docente">Docente</option>
                    <option value="estudiante">Estudiante</option>
                </select>
            </div>
            <div>
                <label for="matricula">Matrícula:</label>
                <input type="text" name="matricula" placeholder="Si es estudiante, ingresa matrícula">
            </div>
        </div>

        <!-- Botón ocupa todo el ancho -->
        <div class="form-group full-width">
            <button type="submit">Registrar</button>
        </div>
    </form>
    <a href="./">Iniciar Sesión</a>
</div>



    <!-- SweetAlert si el correo ya existe -->
    <?php if (isset($usuarioExistente) && $usuarioExistente): ?>
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Correo ya registrado',
                text: 'Este correo electrónico ya está en uso',
                confirmButtonColor: '#d33'
            });
        </script>
    <?php endif; ?>

    <!-- SweetAlert si hubo error de registro -->
    <?php if (isset($registroError) && $registroError): ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error en registro',
                text: 'No se pudo completar el registro. Intenta de nuevo.',
                confirmButtonColor: '#d33'
            });
        </script>
    <?php endif; ?>
</body>

</html>