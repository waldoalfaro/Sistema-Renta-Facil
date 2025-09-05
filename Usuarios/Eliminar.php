<?php

include "../conexion.php";

if (isset($_GET['id_usu'])){
    $id = $_GET['id_usu'];

    $sql = "DELETE FROM usuarios WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $id); 
        $stmt->execute();
        $stmt->close();
    }

    // Redirigir a la lista de usuarios
    header('Location: Usuarios.php');
    exit();

}

?>