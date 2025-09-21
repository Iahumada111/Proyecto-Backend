<?php
require_once 'controlador/UsuarioControlador.php';

// Crear una instancia del controlador
$controlador = new ControladorUsuario();

if (isset($_GET['action'])) {
    switch ($_GET['action']) {
        case 'iniciarSesion':
            // ✅ Ahora el login usa email y password
            $controlador->iniciarSesion($_POST['email'], $_POST['password']);
            break;

        case 'registrar':
            // ✅ Ahora el registro recibe todos los campos
            $controlador->registrarUsuario(
                $_POST['nombre'],
                $_POST['apellido'],
                $_POST['email'],
                $_POST['password'],
                $_POST['rol'],
                $_POST['matricula'] ?? null
            );
            break;

        case 'mostrarRegistro':
            $controlador->mostrarRegistro();
            break;

        case 'cerrarSesion':
            $controlador->cerrarSesion();
            break;

        default:
            $controlador->mostrarLogin();
            break;
    }
} else {
    $controlador->mostrarLogin();
}
