<?php
require_once("../Modelo/crud.php");
header("Content-Type: application/json");

$db = new Database();

$opc = isset($_POST['opc']) ? $_POST['opc'] : '';
$id = isset($_POST['id_mascota']) ? trim($_POST['id_mascota'], " \"'") : '';

switch ($opc) {
case "general":
    $sql = "SELECT 
                m.nom_mascota, 
                CONCAT(t.nom_tutor, ' ', t.app_tutor, ' ', t.apm_tutor) AS nom_tutor,
                m.especie, 
                m.raza, 
                m.fecha_adopcion, 
                m.sexo, 
                IF(m.esterilizado = 1, 'Sí', 'No') AS esterilizado,
                t.numtel_tutor AS telefono
            FROM mascota m
            LEFT JOIN tutor t ON m.correo_tutor = t.correo_tutor
            WHERE m.id_mascota = '$id'";
    
    $result = $db->readCustom($sql);
    echo json_encode($result);
    exit();
    
    case "consultas":
    case "procedimientos":
    case "laboratorio":
    case "radiografias":
        echo json_encode(array());
        exit();

    case "update":
        $peso = isset($_POST['peso_inicial']) ? $_POST['peso_inicial'] : '';
        $esterilizado = isset($_POST['esterilizado']) ? $_POST['esterilizado'] : '';
        
        $resultado = $db->update("mascota", array(
            "peso_inicial" => $peso,
            "esterilizado" => $esterilizado
        ), "id_mascota = '$id'");
        
        echo json_encode(["success" => (bool)$resultado]);
        exit();

    case "delete":
        $resultado = $db->delete("mascota", "id_mascota = '$id'");
        echo json_encode(["success" => (bool)$resultado]);
        exit();

case "buscar":
    $nom_mascota = isset($_POST['nom_mascota']) ? trim($_POST['nom_mascota']) : '';
    $nom_tutor   = isset($_POST['nom_tutor'])   ? trim($_POST['nom_tutor'])   : '';

    $sql = "SELECT 
                m.id_mascota,
                m.nom_mascota, 
                m.especie, 
                m.raza, 
                m.fecha_adopcion,
                m.sexo,
                IF(m.esterilizado = 1, 'Sí', 'No') AS esterilizado,
                COALESCE(CONCAT(t.nom_tutor, ' ', t.app_tutor, ' ', t.apm_tutor), 'Sin tutor') AS nom_tutor
            FROM mascota m 
            LEFT JOIN tutor t ON m.correo_tutor = t.correo_tutor
            WHERE 1=1";

    if (!empty($nom_mascota)) {
        $sql .= " AND m.nom_mascota LIKE '%" . addslashes($nom_mascota) . "%'";
    }

    if (!empty($nom_tutor)) {
        $sql .= " AND CONCAT(COALESCE(t.nom_tutor,''), ' ', COALESCE(t.app_tutor,''), ' ', COALESCE(t.apm_tutor,'')) LIKE '%" . addslashes($nom_tutor) . "%'";
    }

    // Ordenar por nombre de mascota
    $sql .= " ORDER BY m.nom_mascota ASC";

    $result = $db->readCustom($sql);
    echo json_encode($result);
    exit();
}
?>