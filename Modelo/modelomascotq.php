


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
            COALESCE(NULLIF(m.alergia, ''), 'No registrada') AS alergia,
            COALESCE(NULLIF(m.NumMicrochip, ''), 'No registrado') AS NumMicrochip,
            COALESCE(NULLIF(TRIM(CONCAT_WS(' ', u.nombre, u.apellido_paterno, u.apellido_materno)), ''), 'Sin tutor') AS nom_tutor
        FROM mascota m
        LEFT JOIN tutor t ON m.correo_tutor = t.correo_tutor
        LEFT JOIN usuarios u ON t.id_usuario = u.id_usuario
        ORDER BY m.id_mascota ASC";

$result = $db->readCustom($sql);
echo json_encode($result);
?>