<?php
require_once("../Modelo/crud.php");
header("Content-Type: application/json");

$db = new Database();
$opc = isset($_POST['opc']) ? $_POST['opc'] : '';

switch ($opc) {
    case 'listarMascotasSinTutor':
        $mascotas = $db->read("mascota", "correo_tutor IS NULL OR correo_tutor = ''");
        echo json_encode($mascotas);
        break;
        
    case 'listarTodosTutores':
        $tutores = $db->read("tutor", "1 ORDER BY nom_tutor ASC");
        echo json_encode($tutores);
        break;
        
    case 'asignarTutor':
        $id_mascota = $_POST['id_mascota'];
        $correo_tutor = $_POST['correo_tutor'];
        $result = $db->update("mascota", ["correo_tutor" => $correo_tutor], "id_mascota = '$id_mascota'");
        echo json_encode(["success" => $result, "message" => $result ? "Tutor asignado correctamente" : "Error al asignar"]);
        break;
        
    default:
        echo json_encode([]);
        break;
}
?>