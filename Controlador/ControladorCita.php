<?php
// Desactivar impresión de errores HTML directos para no romper el JSON
error_reporting(0);
ini_set('display_errors', 0);

header("Content-Type: application/json; charset=UTF-8");

require_once("../Modelo/crud.php");

try {
    $db = new Database();
    $opc = isset($_POST['opc']) ? $_POST['opc'] : '';

    switch ($opc) {
        case "create":
        case "add":
            // Generar autoincrementable C001, C002...
            $datos = $db->read("cita", "1 ORDER BY id_cita DESC LIMIT 1");

            if ($datos && count($datos) > 0) {
                $ultimo = $datos[0]['id_cita'];
                $numero = intval(substr($ultimo, 1)) + 1;
                $nuevoId = "C" . str_pad($numero, 3, "0", STR_PAD_LEFT);
            } else {
                $nuevoId = "C001";
            }

            $res = $db->create("cita", array(
                "id_cita"            => $nuevoId,
                "fecha"              => $_POST['fecha'],
                "hora"               => $_POST['hora'],
                "procedimiento"      => $_POST['procedimiento'],
                "correo_tutor"       => $_POST['correo_tutor'],
                "correo_veterinario" => $_POST['correo_veterinario']
            ));

            echo json_encode(array(
                "success" => (bool)$res,
                "message" => $res ? "Cita agendada correctamente" : "Error al registrar la cita en la base de datos",
                "id_cita" => $nuevoId
            ));
            break;

        case "listar":
            $citas = $db->read("cita", "1 ORDER BY fecha ASC, hora ASC");
            echo json_encode($citas ? $citas : array());
            break;

        case "delete":
            $id_cita = isset($_POST['id_cita']) ? $_POST['id_cita'] : '';
            $res = $db->delete("cita", "id_cita = '$id_cita'");

            echo json_encode(array(
                "success" => (bool)$res,
                "message" => $res ? "Cita eliminada correctamente" : "Error al eliminar la cita"
            ));
            break;

        default:
            echo json_encode(array("success" => false, "message" => "Operación no válida"));
            break;
    }
} catch (Exception $e) {
    echo json_encode(array(
        "success" => false,
        "message" => "Error interno en el servidor: " . $e->getMessage()
    ));
}
?>