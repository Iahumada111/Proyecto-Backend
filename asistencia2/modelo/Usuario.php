<?php
require_once 'modelo/Conexion.php';

class Usuario
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = (new Conexion())->getConexion();
    }

    // ✅ Verificar credenciales (login por email)
    public function verificarCredenciales($email, $password)
    {
        $stmt = $this->conexion->prepare(
            "SELECT Id_usuario, Password, Rol, Email, Matricula
             FROM usuario
             WHERE Email = ?"
        );
        if (!$stmt) {
            die("Error en la consulta (usuario): " . $this->conexion->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $usuario = $resultado->fetch_assoc();
        $stmt->close();

        if (!$usuario) {
            return false; // no existe ese email
        }

        // ✅ verificar contraseña
        if (!password_verify($password, $usuario['Password'])) {
            return false; 
        }

        // ✅ obtener Nombre/Apellido desde la tabla correspondiente según el rol
        $idUsuario = (int) $usuario['Id_usuario'];
        $nombre = '';
        $apellido = '';

        if ($usuario['Rol'] === 'docente') {
            $stmt2 = $this->conexion->prepare("SELECT Nombre, Apellido FROM docente WHERE Id_usuario = ?");
        } else {
            $stmt2 = $this->conexion->prepare("SELECT Nombre, Apellido FROM estudiante WHERE Id_usuario = ?");
        }

        if ($stmt2) {
            $stmt2->bind_param("i", $idUsuario);
            $stmt2->execute();
            $res2 = $stmt2->get_result();
            $fila = $res2->fetch_assoc();
            $stmt2->close();

            if ($fila) {
                $nombre = $fila['Nombre'] ?? '';
                $apellido = $fila['Apellido'] ?? '';
            }
        }

        $usuario['Nombre'] = $nombre;
        $usuario['Apellido'] = $apellido;

        return $usuario;
    }

    // ✅ Registrar nuevo usuario (correo único)
    public function registrar($nombre, $apellido, $email, $passwordHash, $rol, $matricula = null)
    {
        try {
            // Insertar en tabla usuario
            $stmt = $this->conexion->prepare(
                "INSERT INTO usuario (Password, Rol, Matricula, Email) 
                 VALUES (?, ?, ?, ?)"
            );
            $stmt->bind_param("ssss", $passwordHash, $rol, $matricula, $email);
            $stmt->execute();
            $idUsuario = $this->conexion->insert_id;
            $stmt->close();

            // Insertar en tabla dependiente
            if ($rol === 'docente') {
                $stmt = $this->conexion->prepare(
                    "INSERT INTO docente (Nombre, Apellido, Email, Id_usuario) VALUES (?, ?, ?, ?)"
                );
                $stmt->bind_param("sssi", $nombre, $apellido, $email, $idUsuario);
            } elseif ($rol === 'estudiante') {
                $stmt = $this->conexion->prepare(
                    "INSERT INTO estudiante (Nombre, Apellido, Email, Id_usuario) VALUES (?, ?, ?, ?)"
                );
                $stmt->bind_param("sssi", $nombre, $apellido, $email, $idUsuario);
            } else {
                return false;
            }

            return $stmt->execute();

        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) {
                return "duplicado"; // ✅ Correo ya existe
            }
            return false; // Otro error
        }
    }
}


