<?php 
include "../conexion.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idvehiculo   = $_POST['id_vehiculo']; 
    $marca        = $_POST['marca'];
    $modelo       = $_POST['modelo'];
    $color        = $_POST['color'];
    $placa        = $_POST['placa'];
    $anio         = $_POST['anio'];
    $asientos     = $_POST['asientos'];
    $foto_actual  = $_POST['foto_actual']; 

    $precio_dia   = $_POST['precio_dia'];
    $combustible  = $_POST['combustible'];
    $gps          = $_POST['gps'];
    $seguro       = $_POST['seguro'];
    $vin          = $_POST['vin'];

    $ubicaciones  = isset($_POST['ubicacion_dano']) ? $_POST['ubicacion_dano'] : [];
    $tipos        = isset($_POST['tipo_dano']) ? $_POST['tipo_dano'] : [];

    // Manejo de la foto
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $nombreFoto = uniqid() . "_" . $_FILES['foto']['name'];
        $rutaTemp   = $_FILES['foto']['tmp_name'];
        move_uploaded_file($rutaTemp, "../FotosSubidas/" . $nombreFoto);
        $foto = $nombreFoto;
    } else {
        $foto = $foto_actual;
    }

    // 1️⃣ Actualizar datos del vehículo
    if($conn){
        $sql = "UPDATE vehiculos 
                   SET marca=?, modelo=?, color=?, placa=?, anio=?, asientos=?, foto=?, 
                       precio_dia=?, combustible=?, gps=?, seguro=?, vin=? 
                 WHERE id_vehiculo=?"; 

        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "ssssiisssssii", 
            $marca, $modelo, $color, $placa, $anio, $asientos, $foto, 
            $precio_dia, $combustible, $gps, $seguro, $vin, $idvehiculo
        );
        $stmt->execute();
        $stmt->close();

        // 2️⃣ Eliminar daños anteriores
        $conn->query("DELETE FROM vehiculos_danos WHERE id_vehiculo = $idvehiculo");

        // 3️⃣ Insertar los daños nuevos
        if(!empty($ubicaciones) && !empty($tipos)){
            for($i=0; $i<count($ubicaciones); $i++){
                $ubi = $conn->real_escape_string($ubicaciones[$i]);
                $tipo = isset($tipos[$i]) ? $conn->real_escape_string($tipos[$i]) : '';
                $conn->query("INSERT INTO vehiculos_danos (id_vehiculo, ubicacion_dano, tipo_dano) 
                              VALUES ('$idvehiculo', '$ubi', '$tipo')");
            }
        }

        header('Location: vehiculos.php?msg=editado'); 
        exit(); 
    } else {
        echo "❌ Error en la conexión a la base de datos.";
    }
}
?>
