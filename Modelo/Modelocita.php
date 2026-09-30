<?php
require_once("../Modelo/crud.php");
header("Content-Type: application/json");

$db = new Database();

$opc = isset($_POST['opc']) ? $_POST['opc'] : '';

switch ($opc) {
    case "buscar":
        $id_cita = isset($_POST['id_cita']) ? trim($_POST['id_cita']) : '';

        $sql = "SELECT 
                    m.id_cita,
                    m.fecha,
                    m.hora,
                    m.procedimiento,
                    m.correo_tutor,
                    m.correo_veterinario,
                FROM cita m
                WHERE 1=1";

        if (!empty($id_cita)) {
            $sql .= " AND m.id_cita = '$id_cita'";
        }
        
        $sql .= " ORDER BY m.id_cita ASC";

        $result = $db->readCustom($sql);
        echo json_encode($result);
        exit();
}
?>