<?php
include '../conexion.php';
include '../seguridad.php';

// Verificar que la petición sea POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Obtener datos comunes
    $id_vehiculo = $_POST['id_vehiculo'];
    $tipo_mantenimiento = $_POST['tipo_mantenimiento'];
    
    // Inicializar variables
    $fecha_cambio_aceite = null;
    $kilometraje_actual = null;
    $proximo_cambio_km = null;
    $tipo_aceite = null;
    $realizado_por_aceite = null;
    $telefono_aceite = null;
    $costo_aceite = null;
    $obs_aceite = null;
    
    $tipo_danio = null;
    $fecha_reparacion = null;
    $descripcion_danio = null;
    $reparaciones_realizadas = null;
    $reparado_por = null;
    $telefono_reparacion = null;
    $costo_reparacion = null;
    
    // Verificar qué tipo de mantenimiento es y obtener los datos correspondientes
    if ($tipo_mantenimiento == 'cambio_aceite') {
        // Datos de cambio de aceite
        $fecha_cambio_aceite = !empty($_POST['fecha_cambio_aceite']) ? $_POST['fecha_cambio_aceite'] : null;
        $kilometraje_actual = !empty($_POST['kilometraje_actual']) ? $_POST['kilometraje_actual'] : null;
        $proximo_cambio_km = !empty($_POST['proximo_cambio_km']) ? $_POST['proximo_cambio_km'] : null;
        $tipo_aceite = !empty($_POST['tipo_aceite']) ? $_POST['tipo_aceite'] : null;
        $realizado_por_aceite = !empty($_POST['realizado_por_aceite']) ? $_POST['realizado_por_aceite'] : null;
        $telefono_aceite = !empty($_POST['telefono_aceite']) ? $_POST['telefono_aceite'] : null;
        $costo_aceite = !empty($_POST['costo_aceite']) ? $_POST['costo_aceite'] : null;
        $obs_aceite = !empty($_POST['obs_aceite']) ? $_POST['obs_aceite'] : null;
        
    } elseif ($tipo_mantenimiento == 'reparacion') {
        // Datos de reparación
        $tipo_danio = !empty($_POST['tipo_danio']) ? $_POST['tipo_danio'] : null;
        $fecha_reparacion = !empty($_POST['fecha_reparacion']) ? $_POST['fecha_reparacion'] : null;
        $descripcion_danio = !empty($_POST['descripcion_danio']) ? $_POST['descripcion_danio'] : null;
        $reparaciones_realizadas = !empty($_POST['reparaciones_realizadas']) ? $_POST['reparaciones_realizadas'] : null;
        $reparado_por = !empty($_POST['reparado_por']) ? $_POST['reparado_por'] : null;
        $telefono_reparacion = !empty($_POST['telefono_reparacion']) ? $_POST['telefono_reparacion'] : null;
        $costo_reparacion = !empty($_POST['costo_reparacion']) ? $_POST['costo_reparacion'] : null;
        $estado_reparacion = !empty($_POST['estado_reparacion']);
    }
    
    // Preparar la consulta SQL
    $sql = "INSERT INTO mantenimientos (
        id_vehiculo,
        tipo_mantenimiento,
        fecha_cambio_aceite,
        kilometraje_actual,
        proximo_cambio_km,
        tipo_aceite,
        realizado_por_aceite,
        telefono_aceite,
        costo_aceite,
        obs_aceite,
        tipo_danio,
        fecha_reparacion,
        descripcion_danio,
        reparaciones_realizadas,
        reparado_por,
        telefono_reparacion,
        costo_reparacion
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    // Preparar statement
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        // Bind parameters
        $stmt->bind_param(
            "isssissdssssssssd",
            $id_vehiculo,
            $tipo_mantenimiento,
            $fecha_cambio_aceite,
            $kilometraje_actual,
            $proximo_cambio_km,
            $tipo_aceite,
            $realizado_por_aceite,
            $telefono_aceite,
            $costo_aceite,
            $obs_aceite,
            $tipo_danio,
            $fecha_reparacion,
            $descripcion_danio,
            $reparaciones_realizadas,
            $reparado_por,
            $telefono_reparacion,
            $costo_reparacion,
        );
        
        // Ejecutar la consulta
        if ($stmt->execute()) {
            
            echo "<script>
                alert('✅ Mantenimiento registrado exitosamente');
                window.location.href = 'mantenimiento.php';
            </script>";
        } else {
           
            echo "<script>
                alert('❌ Error al registrar el mantenimiento: " . $stmt->error . "');
                window.history.back();
            </script>";
        }
        
        $stmt->close();
    } else {
        // Error al preparar
        echo "<script>
            alert('❌ Error al preparar la consulta: " . $conn->error . "');
            window.history.back();
        </script>";
    }
    
    $conn->close();
    
} else {
    // Si no es POST, redirigir
    header("Location: mantenimiento.php");
    exit();
}
?>