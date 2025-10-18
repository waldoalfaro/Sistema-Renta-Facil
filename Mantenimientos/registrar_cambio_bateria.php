<?php
include '../conexion.php';
include '../seguridad.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_vehiculo = $_POST['id_vehiculo'];
    $fecha = $_POST['Fecha'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $voltaje = $_POST['voltaje'];
    $garantia = $_POST['garantia'];
    $costo = $_POST['costo'];
    $realizado_por = $_POST['realizado_por'];
    $telefono = $_POST['telefono'];
    $observaciones = $_POST['observaciones'];

    // Consulta SQL
    $sql = "UPDATE cambio_bateria 
            SET fecha = ?, 
                marca_bateria = ?, 
                modelo_bateria = ?, 
                voltaje = ?, 
                garantia_meses = ?, 
                costo = ?, 
                realizado_por = ?, 
                telefono = ?, 
                observaciones = ?
            WHERE id_vehiculo = ?";

    $stmt = $conn->prepare($sql);

    // Enlazamos los parámetros (sssss d s s s i)
    $stmt->bind_param(
        "sssssdsssi",
        $fecha,
        $marca,
        $modelo,
        $voltaje,
        $garantia,
        $costo,
        $realizado_por,
        $telefono,
        $observaciones,
        $id_vehiculo
    );

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo "<script>
                alert('✅ Cambio de batería actualizado correctamente.');
                window.location.href = 'mantenimiento.php';
            </script>";
        } else {
            echo "<script>
                alert('⚠️ No se actualizó ningún registro. Verifica el ID del vehículo o si los datos son iguales.');
                window.history.back();
            </script>";
        }
    } else {
        echo "<script>
            alert('❌ Error al actualizar el cambio de batería: " . $stmt->error . "');
            window.history.back();
        </script>";
    }

    $stmt->close();
    $conn->close();
}
?>
