<?php
require_once __DIR__ . "/../Modelo/crud.php";

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
header("Content-Type: application/json; charset=utf-8");
if ((int)($_SESSION['id_rol'] ?? 0) !== 3) {
    http_response_code(403);
    echo json_encode(["success" => false, "message" => "No tienes permiso para administrar usuarios."]);
    exit;
}

$db = new Database();
$opc = $_POST['opc'] ?? '';

function responderUsuario(bool $success, string $message): void
{
    echo json_encode(["success" => $success, "message" => $message]);
}

switch ($opc) {
    case 'update':
        $idUsuario = filter_var($_POST['id_usuario'] ?? null, FILTER_VALIDATE_INT);
        $correo = trim($_POST['correo'] ?? '');
        $nombre = trim($_POST['nombre'] ?? '');
        $apellidoPaterno = trim($_POST['apellido_paterno'] ?? '');
        $apellidoMaterno = trim($_POST['apellido_materno'] ?? '');
        $sexo = $_POST['sexo'] ?? '';
        $idRol = filter_var($_POST['id_rol'] ?? null, FILTER_VALIDATE_INT);
        $nuevaPassword = (string)($_POST['password'] ?? '');

        if (!$idUsuario || $nombre === '' || strlen($nombre) > 100 ||
            strlen($apellidoPaterno) > 100 || strlen($apellidoMaterno) > 100) {
            responderUsuario(false, "Revisa el ID, nombre y apellidos del usuario.");
            break;
        }
        if (strlen($correo) > 100 || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            responderUsuario(false, "Ingresa un correo válido de máximo 100 caracteres.");
            break;
        }
        if (!in_array($sexo, ["Femenino", "Masculino"], true)) {
            responderUsuario(false, "Selecciona un sexo válido.");
            break;
        }
        if (!$idRol || count($db->read("roles", "id_rol = " . intval($idRol))) === 0) {
            responderUsuario(false, "Selecciona un rol válido.");
            break;
        }
        if ($nuevaPassword !== '' && strlen($nuevaPassword) < 8) {
            responderUsuario(false, "La contraseña debe tener al menos 8 caracteres.");
            break;
        }

        $conexion = $db->conexion();
        $correoSeguro = $conexion->real_escape_string($correo);
        $idUsuarioSeguro = intval($idUsuario);
        if (count($db->read("usuarios", "correo = '$correoSeguro' AND id_usuario != $idUsuarioSeguro")) > 0) {
            responderUsuario(false, "El correo ya está registrado por otro usuario.");
            break;
        }

        $data = [
            "correo" => $correo,
            "nombre" => $nombre,
            "apellido_paterno" => $apellidoPaterno === '' ? null : $apellidoPaterno,
            "apellido_materno" => $apellidoMaterno === '' ? null : $apellidoMaterno,
            "sexo" => $sexo,
            "id_rol" => (string)$idRol
        ];
        if ($nuevaPassword !== '') {
            $data["password"] = password_hash($nuevaPassword, PASSWORD_DEFAULT);
        }

        $result = $db->update("usuarios", $data, "id_usuario = $idUsuarioSeguro");
        responderUsuario($result, $result ? "Usuario actualizado correctamente." : "Error al actualizar el usuario.");
        break;

    case 'delete':
        $idUsuario = filter_var($_POST['id_usuario'] ?? null, FILTER_VALIDATE_INT);
        if (!$idUsuario) {
            responderUsuario(false, "ID de usuario no válido.");
            break;
        }
        $result = $db->delete("usuarios", "id_usuario = " . intval($idUsuario));
        responderUsuario($result, $result ? "Usuario eliminado correctamente." : "Error al eliminar el usuario.");
        break;

    default:
        responderUsuario(false, "Operación no válida.");
        break;
}
?>
