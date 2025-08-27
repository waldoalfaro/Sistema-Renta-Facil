<?php
session_start();
require 'conexion.php';

$usuario = $_POST['usuario'];
$clave = $_POST['clave'];

$sql = "SELECT u.*, t.nombre_tipo AS tipo_nombre FROM usuarios u
        JOIN tipos_usuario t ON u.id_tipo = t.id_tipo
        WHERE u.usuario = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 1) {
    $fila = $resultado->fetch_assoc();

    if (password_verify($clave, $fila['clave'])) {
        $_SESSION['usuario_id'] = $fila['id'];
        $_SESSION['usuario'] = $fila['usuario'];
        $_SESSION['nombre'] = $fila['nombre'];
        $_SESSION['tipo'] = $fila['tipo_nombre'];
        header("Location: dashboard.php");
        exit;
    } else {
        $_SESSION['error'] = "Contraseña incorrecta.";
    }
} else {
    $_SESSION['error'] = "Usuario no encontrado o inactivo.";
}

header("Location: login.php");
exit;
