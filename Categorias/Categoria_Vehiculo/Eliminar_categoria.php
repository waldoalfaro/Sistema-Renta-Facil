<?php

include "../../conexion.php";

if (isset($_GET['id_cate'])){
    $id = $_GET['id_cate'];

    $sql = "DELETE FROM categorias WHERE id_categoria = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $id); 
        $stmt->execute();
        $stmt->close();
    }

    // Redirigir a la lista de usuarios
    header('Location: categorias_vehiculos.php');
    exit();

}

?>