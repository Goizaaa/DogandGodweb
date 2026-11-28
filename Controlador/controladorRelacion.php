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
        $sql = "SELECT
                    t.correo_tutor,
                    u.nombre AS nom_tutor,
                    u.apellido_paterno AS app_tutor,
                    u.apellido_materno AS apm_tutor
                FROM tutor t
                LEFT JOIN usuarios u ON t.id_usuario = u.id_usuario
                ORDER BY u.nombre, u.apellido_paterno, u.apellido_materno";
        $tutores = $db->readCustom($sql);
        echo json_encode($tutores);
        break;
        
    case 'asignarTutor':
        $id_mascota = isset($_POST['id_mascota']) ? trim($_POST['id_mascota']) : '';
        $correo_tutor = isset($_POST['correo_tutor']) ? trim($_POST['correo_tutor']) : '';
        if ($id_mascota === '' || $correo_tutor === '') {
            http_response_code(400);
            echo json_encode(["success" => false, "message" => "Selecciona una mascota y un tutor."]);
            break;
        }
        $stmt = $db->conexion()->prepare("UPDATE mascota SET correo_tutor = ? WHERE id_mascota = ?");
        $stmt->bind_param("ss", $correo_tutor, $id_mascota);
        $result = $stmt->execute();
        echo json_encode(["success" => $result, "message" => $result ? "Tutor asignado correctamente" : "Error al asignar"]);
        break;
        
    default:
        echo json_encode([]);
        break;
}
?>