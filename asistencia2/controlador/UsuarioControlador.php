<?php
require_once 'modelo/Usuario.php';

class ControladorUsuario
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new Usuario();
    }

    public function mostrarLogin()
    {
        require 'vista/login.php';
    }

    // ✅ Ahora recibe email y password
    public function iniciarSesion($email, $password)
    {
        $usuario = $this->modelo->verificarCredenciales($email, $password);

        if ($usuario) {
            session_start();
            // Guardamos todos los datos del usuario (array asociativo)
            $_SESSION['usuario'] = $usuario;
            header('Location: vista/bienvenida.php');
            exit();
        } else {
            // Si falla, recargamos login con variable de error
            $errorLogin = true;
            require 'vista/login.php';
        }
    }

    public function mostrarRegistro()
    {
        require 'vista/registro.php';
    }

    // ✅ Ahora recibe todos los campos de la BD
    public function registrarUsuario($nombre, $apellido, $email, $password, $rol, $matricula = null)
    {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $resultado = $this->modelo->registrar($nombre, $apellido, $email, $passwordHash, $rol, $matricula);

        if ($resultado === true) {
            // Registro exitoso → mostramos login con SweetAlert
            $registroExitoso = true;
            require 'vista/login.php';
        } elseif ($resultado === "duplicado") {
            // Correo ya registrado
            $usuarioExistente = true;
            require 'vista/registro.php';
        } else {
            // Otro error
            $registroError = true;
            require 'vista/registro.php';
        }
    }

    public function cerrarSesion()
    {
        session_start();
        session_unset();
        session_destroy();
        header('Location: index.php');
        exit();
    }
}


