<?php
require_once __DIR__ . "/crud.php";

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
if ((int)($_SESSION['id_rol'] ?? 0) !== 3) {
    http_response_code(403);
    header("Content-Type: application/json; charset=utf-8");
    echo json_encode(["message" => "No tienes permiso para consultar usuarios."]);
    exit;
}

$db = new Database();
$sql = "SELECT u.id_usuario, u.correo, u.nombre, u.apellido_paterno,
               u.apellido_materno, u.id_rol, r.nombre AS rol, u.sexo
        FROM usuarios u
        LEFT JOIN roles r ON r.id_rol = u.id_rol
        ORDER BY u.id_usuario";
$result = $db->readCustom($sql);
$roles = $db->read("roles", "1 ORDER BY id_rol");

header("Content-Type: application/json; charset=utf-8");
echo json_encode(["usuarios" => $result, "roles" => $roles]);
?>