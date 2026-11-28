<?php
require_once("../Modelo/crud.php");
header("Content-Type: application/json; charset=utf-8");

function responderTutor($datos, $codigo = 200) {
    http_response_code($codigo);
    echo json_encode($datos, JSON_UNESCAPED_UNICODE);
    exit();
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$transaccionActiva = false;

try {
    $db = new Database();
    $conexion = $db->conexion();
    $opc = isset($_POST["opc"]) ? $_POST["opc"] : "";

    switch ($opc) {
        case "create":
            $correo = trim($_POST["correo_tutor"] ?? "");
            $nombre = trim($_POST["nom_tutor"] ?? "");
            $apellidoPaterno = trim($_POST["app_tutor"] ?? "");
            $apellidoMaterno = trim($_POST["apm_tutor"] ?? "");
            $telefono = trim($_POST["numtel_tutor"] ?? "");
            $direccion = trim($_POST["direccion"] ?? "");

            if (!filter_var($correo, FILTER_VALIDATE_EMAIL) || $nombre === ""
                || $apellidoPaterno === "" || $apellidoMaterno === ""
                || $telefono === "" || $direccion === "") {
                responderTutor(array("success" => false, "message" => "Completa todos los datos del tutor con valores válidos."), 400);
            }

            $correoSeguro = $conexion->real_escape_string($correo);
            $tutores = $db->read("tutor", "correo_tutor = '$correoSeguro'");
            if (count($tutores) > 0) {
                responderTutor(array("success" => false, "message" => "El correo ya está registrado como tutor."), 409);
            }

            $usuarios = $db->read("usuarios", "LOWER(TRIM(correo)) = LOWER('$correoSeguro') LIMIT 1");
            if (count($usuarios) === 0) {
                responderTutor(array(
                    "success" => false,
                    "message" => "Primero registra una cuenta de usuario con este correo para poder vincularla como tutor."
                ), 400);
            }

            $idUsuario = (int)$usuarios[0]["id_usuario"];
            $conexion->begin_transaction();
            $transaccionActiva = true;
            $usuarioActualizado = $db->update("usuarios", array(
                "nombre" => $nombre,
                "apellido_paterno" => $apellidoPaterno,
                "apellido_materno" => $apellidoMaterno
            ), "id_usuario = " . $idUsuario);
            $tutorCreado = $db->create("tutor", array(
                "correo_tutor" => $correo,
                "id_usuario" => (string)$idUsuario,
                "numtel_tutor" => $telefono,
                "direccion" => $direccion
            ));

            if (!$usuarioActualizado || !$tutorCreado) {
                $conexion->rollback();
                $transaccionActiva = false;
                responderTutor(array("success" => false, "message" => "No se pudo registrar el tutor."), 500);
            }

            $conexion->commit();
            $transaccionActiva = false;
            responderTutor(array("success" => true, "message" => "Tutor registrado correctamente."));

        case "listar":
            $sql = "SELECT
                        t.correo_tutor,
                        u.nombre AS nom_tutor,
                        u.apellido_paterno AS app_tutor,
                        u.apellido_materno AS apm_tutor,
                        t.numtel_tutor,
                        t.direccion
                    FROM tutor t
                    LEFT JOIN usuarios u ON t.id_usuario = u.id_usuario
                    ORDER BY u.nombre, u.apellido_paterno, u.apellido_materno";
            responderTutor($db->readCustom($sql));

        case "update":
            $correoOriginal = trim($_POST["correo_original"] ?? "");
            $correoNuevo = trim($_POST["correo_tutor"] ?? "");
            $telefono = trim($_POST["numtel_tutor"] ?? "");
            $direccion = trim($_POST["direccion"] ?? "");
            if ($correoOriginal === "" || !filter_var($correoNuevo, FILTER_VALIDATE_EMAIL)
                || $telefono === "" || $direccion === "") {
                responderTutor(array("success" => false, "message" => "Revisa el correo, teléfono y dirección."), 400);
            }

            if (strcasecmp($correoOriginal, $correoNuevo) !== 0) {
                $correoNuevoSeguro = $conexion->real_escape_string($correoNuevo);
                $existe = $db->read("tutor", "correo_tutor = '$correoNuevoSeguro'");
                if (count($existe) > 0) {
                    responderTutor(array("success" => false, "message" => "El nuevo correo ya está registrado por otro tutor."), 409);
                }
            }

            $correoOriginalSeguro = $conexion->real_escape_string($correoOriginal);
            $resultado = $db->update("tutor", array(
                "correo_tutor" => $correoNuevo,
                "numtel_tutor" => $telefono,
                "direccion" => $direccion
            ), "correo_tutor = '$correoOriginalSeguro'");
            responderTutor(array(
                "success" => (bool)$resultado,
                "message" => $resultado ? "Tutor actualizado correctamente." : "Error al actualizar tutor."
            ));

        case "delete":
            $correo = trim($_POST["correo_tutor"] ?? "");
            if ($correo === "") {
                responderTutor(array("success" => false, "message" => "Correo del tutor no válido."), 400);
            }
            $correoSeguro = $conexion->real_escape_string($correo);
            $resultado = $db->delete("tutor", "correo_tutor = '$correoSeguro'");
            responderTutor(array(
                "success" => (bool)$resultado,
                "message" => $resultado ? "Tutor eliminado correctamente." : "Error al eliminar tutor."
            ));

        default:
            responderTutor(array("success" => false, "message" => "Operación no válida."), 400);
    }
} catch (mysqli_sql_exception $error) {
    if ($transaccionActiva && isset($conexion)) {
        $conexion->rollback();
    }
    error_log("Error al procesar tutores: " . $error->getMessage());
    responderTutor(array("success" => false, "message" => "Ocurrió un error al procesar los tutores."), 500);
}
