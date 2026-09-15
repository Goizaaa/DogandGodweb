<?php
require_once("crud.php");
header("Content-Type: application/json");

$db = new Database();

$sql = "SELECT 
            m.id_mascota,
            m.nom_mascota, 
            m.especie, 
            m.raza, 
            m.fecha_adopcion,
            m.peso_inicial,
            m.sexo,
            IF(m.esterilizado = 1, 'Sí', 'No') AS esterilizado,
            COALESCE(CONCAT(t.nom_tutor, ' ', t.app_tutor, ' ', t.apm_tutor), 'Sin tutor') AS nom_tutor
        FROM mascota m
        LEFT JOIN tutor t ON m.correo_tutor = t.correo_tutor
        ORDER BY m.id_mascota ASC";

$result = $db->readCustom($sql);
echo json_encode($result);
?>