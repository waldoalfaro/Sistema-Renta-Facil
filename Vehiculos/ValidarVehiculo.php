<?php

include '../conexion.php';






    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $color = $_POST['color'];
    $placa = $_POST['placa'];
    $año = $_POST['anio'];
    $asientos = $_POST['asientos'];
    $aire = $_POST['aire'];
    $estado = $_POST['estado'];

$fotoNombre = null;

if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $fotoNombre = uniqid() . "_" . $_FILES['foto']['name']; // nombre único
    $rutaTemp   = $_FILES['foto']['tmp_name'];
    $destino    = "../FotosSubidas/" . $fotoNombre;

    
    if (!is_dir("../FotosSubidas/")) {
        mkdir("../FotosSubidas/", 0777, true);
    }

    move_uploaded_file($rutaTemp, $destino);
}

    
   
    $sql_insert = "INSERT INTO vehiculos (marca, modelo, color, placa, anio, asientos, aire_acondicionado, foto, estado) VALUES ('$marca', '$modelo', '$color', '$placa', '$año', '$asientos', '$aire', '$fotoNombre', '$estado')";
    
    if ($conn->query($sql_insert) === TRUE) {
        header("Location: vehiculos.php");
        exit;
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }



?>