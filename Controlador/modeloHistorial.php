<?php
require_once("../Modelo/crud.php");
header("Content-Type: application/json; charset=utf-8");

function responderHistorial($datos, $codigo = 200) {
    http_response_code($codigo);
    echo json_encode($datos, JSON_UNESCAPED_UNICODE);
    exit();
}

function longitudHistorial($valor) {
    return function_exists("mb_strlen") ? mb_strlen($valor, "UTF-8") : strlen($valor);
}

function guardarArchivoHistorial(&$nombreArchivo, $obligatorio) {
    if (!isset($_FILES["archivo"]) || $_FILES["archivo"]["error"] === UPLOAD_ERR_NO_FILE) {
        return $obligatorio ? "Adjunta el archivo de la radiografía." : "";
    }

    $archivo = $_FILES["archivo"];
    if ($archivo["error"] !== UPLOAD_ERR_OK) {
        return "No se pudo recibir el archivo adjunto.";
    }
    if ($archivo["size"] > 10 * 1024 * 1024) {
        return "El archivo no puede superar los 10 MB.";
    }

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    if (!$finfo) {
        return "No se pudo validar el tipo del archivo.";
    }
    $mime = finfo_file($finfo, $archivo["tmp_name"]);
    finfo_close($finfo);

    $tiposPermitidos = array(
        "application/pdf" => "pdf",
        "image/jpeg" => "jpg",
        "image/png" => "png"
    );
    if (!isset($tiposPermitidos[$mime])) {
        return "El archivo debe ser PDF, JPG o PNG.";
    }

    $directorio = dirname(__DIR__) . DIRECTORY_SEPARATOR . "recursos" . DIRECTORY_SEPARATOR . "historial";
    if (!is_dir($directorio) && !mkdir($directorio, 0755, true) && !is_dir($directorio)) {
        return "No se pudo preparar el almacenamiento de archivos.";
    }

    $nombreArchivo = bin2hex(random_bytes(16)) . "." . $tiposPermitidos[$mime];
    if (!move_uploaded_file($archivo["tmp_name"], $directorio . DIRECTORY_SEPARATOR . $nombreArchivo)) {
        $nombreArchivo = null;
        return "No se pudo guardar el archivo adjunto.";
    }

    return "";
}

function eliminarArchivoHistorial($nombreArchivo) {
    if ($nombreArchivo) {
        $ruta = dirname(__DIR__) . DIRECTORY_SEPARATOR . "recursos" . DIRECTORY_SEPARATOR
            . "historial" . DIRECTORY_SEPARATOR . basename($nombreArchivo);
        if (is_file($ruta)) {
            unlink($ruta);
        }
    }
}

$opc = isset($_POST["opc"]) ? $_POST["opc"] : "";
$id = isset($_POST["id_mascota"]) ? trim($_POST["id_mascota"], " \"'") : "";
$archivoGuardado = null;

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $db = new Database();
    $conexion = $db->conexion();
    switch ($opc) {
        case "general":
            $sql = "SELECT
                        m.nom_mascota,
                        COALESCE(NULLIF(TRIM(CONCAT_WS(' ', u.nombre, u.apellido_paterno, u.apellido_materno)), ''), 'Sin tutor') AS nom_tutor,
                        m.especie,
                        m.raza,
                        m.fecha_adopcion,
                        m.peso_inicial,
                        m.sexo,
                        m.esterilizado AS esterilizado_valor,
                        IF(m.esterilizado = 1, 'Sí', 'No') AS esterilizado,
                        t.numtel_tutor AS telefono,
                        COALESCE(NULLIF(m.alergia, ''), 'No registrada') AS alergia,
                        m.alergia AS alergia_valor,
                        COALESCE(NULLIF(m.NumMicrochip, ''), 'No registrado') AS NumMicrochip,
                        m.NumMicrochip AS NumMicrochip_valor
                    FROM mascota m
                    LEFT JOIN tutor t ON m.correo_tutor = t.correo_tutor
                    LEFT JOIN usuarios u ON t.id_usuario = u.id_usuario
                    WHERE m.id_mascota = ?";
            $stmt = $conexion->prepare($sql);
            $stmt->bind_param("s", $id);
            $stmt->execute();
            responderHistorial($stmt->get_result()->fetch_all(MYSQLI_ASSOC));

        case "procedimientos":
            $sql = "SELECT nombre, descripcion, fecha FROM procedimientos
                    WHERE id_mascota = ? ORDER BY fecha DESC, id_procedimiento DESC";
            break;
        case "laboratorio":
            $sql = "SELECT nombre, descripcion, fecha, archivo FROM analisisclinicos
                    WHERE id_mascota = ? ORDER BY fecha DESC, id_analisis DESC";
            break;
        case "radiografias":
            $sql = "SELECT nombre, descripcion, fecha, archivo FROM radiografias
                    WHERE id_mascota = ? ORDER BY fecha DESC, id_radiografia DESC";
            break;
        case "ultrasonido":
            $sql = "SELECT nombre, descricion AS descripcion, fecha FROM ultrasonido
                    WHERE id_mascota = ? ORDER BY fecha DESC, id_ultrasonido DESC";
            break;
        case "consultas":
            responderHistorial(array());

        case "agregar":
            if ($id === "" || longitudHistorial($id) > 25) {
                responderHistorial(array("success" => false, "message" => "Identificador de mascota no válido."), 400);
            }

            $tipo = isset($_POST["tipo"]) ? $_POST["tipo"] : "";
            $nombre = isset($_POST["nombre"]) ? trim($_POST["nombre"]) : "";
            $descripcion = isset($_POST["descripcion"]) ? trim($_POST["descripcion"]) : "";
            $fecha = isset($_POST["fecha"]) ? trim($_POST["fecha"]) : "";
            $limitesDescripcion = array(
                "procedimientos" => 300,
                "analisisclinicos" => 200,
                "radiografias" => 200,
                "ultrasonido" => 100
            );
            if (!isset($limitesDescripcion[$tipo])) {
                responderHistorial(array("success" => false, "message" => "Tipo de registro no válido."), 400);
            }
            if ($nombre === "" || longitudHistorial($nombre) > 100
                || $descripcion === "" || longitudHistorial($descripcion) > $limitesDescripcion[$tipo]) {
                responderHistorial(array("success" => false, "message" => "Revisa el nombre y la descripción del registro."), 400);
            }
            if (!preg_match("/^\\d{4}-\\d{2}-\\d{2}$/", $fecha)
                || !checkdate((int)substr($fecha, 5, 2), (int)substr($fecha, 8, 2), (int)substr($fecha, 0, 4))) {
                responderHistorial(array("success" => false, "message" => "La fecha indicada no es válida."), 400);
            }

            $archivoObligatorio = $tipo === "radiografias";
            $errorArchivo = guardarArchivoHistorial($archivoGuardado, $archivoObligatorio);
            if ($errorArchivo !== "") {
                responderHistorial(array("success" => false, "message" => $errorArchivo), 400);
            }

            if ($tipo === "procedimientos") {
                $stmt = $conexion->prepare("INSERT INTO procedimientos (nombre, descripcion, fecha, id_mascota) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $nombre, $descripcion, $fecha, $id);
            } elseif ($tipo === "analisisclinicos") {
                $rutaArchivo = $archivoGuardado
                    ? "../recursos/historial/" . $archivoGuardado
                    : null;
                $stmt = $conexion->prepare("INSERT INTO analisisclinicos (nombre, descripcion, fecha, id_mascota, archivo) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $nombre, $descripcion, $fecha, $id, $rutaArchivo);
            } elseif ($tipo === "radiografias") {
                $rutaArchivo = "../recursos/historial/" . $archivoGuardado;
                $stmt = $conexion->prepare("INSERT INTO radiografias (nombre, descripcion, archivo, fecha, id_mascota) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $nombre, $descripcion, $rutaArchivo, $fecha, $id);
            } else {
                $stmt = $conexion->prepare("INSERT INTO ultrasonido (nombre, descricion, fecha, id_mascota) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $nombre, $descripcion, $fecha, $id);
            }

            if (!$stmt->execute()) {
                eliminarArchivoHistorial($archivoGuardado);
                responderHistorial(array("success" => false, "message" => "No se pudo guardar el registro."), 500);
            }
            responderHistorial(array("success" => true, "message" => "Registro agregado correctamente."));

        case "update":
            $peso = trim($_POST["peso_inicial"] ?? "");
            $esterilizado = $_POST["esterilizado"] ?? "";
            $alergia = trim($_POST["alergia"] ?? "");
            $microchip = trim($_POST["NumMicrochip"] ?? "");
            $actualizarAlergia = array_key_exists("alergia", $_POST) ? 1 : 0;
            $actualizarMicrochip = array_key_exists("NumMicrochip", $_POST) ? 1 : 0;

            if ($id === "" || longitudHistorial($id) > 25) {
                responderHistorial(array("success" => false, "message" => "Identificador de mascota no válido."), 400);
            }
            if (!preg_match("/^\\d{1,10}$/", $peso)
                || !in_array($esterilizado, array("0", "1"), true)
                || longitudHistorial($alergia) > 50
                || longitudHistorial($microchip) > 15) {
                responderHistorial(array("success" => false, "message" => "Revisa el peso, esterilización, alergias y número de microchip."), 400);
            }

            $stmt = $conexion->prepare("SELECT id_mascota FROM mascota WHERE id_mascota = ?");
            $stmt->bind_param("s", $id);
            $stmt->execute();
            if (!$stmt->get_result()->fetch_assoc()) {
                responderHistorial(array("success" => false, "message" => "No se encontró la mascota."), 404);
            }

            $esterilizado = (int)$esterilizado;
            $alergia = $actualizarAlergia && $alergia === "" ? null : $alergia;
            $microchip = $actualizarMicrochip && $microchip === "" ? null : $microchip;
            $stmt = $conexion->prepare("UPDATE mascota
                SET peso_inicial = ?, esterilizado = ?,
                    alergia = IF(?, ?, alergia),
                    NumMicrochip = IF(?, ?, NumMicrochip)
                WHERE id_mascota = ?");
            $stmt->bind_param("siisiss", $peso, $esterilizado, $actualizarAlergia, $alergia, $actualizarMicrochip, $microchip, $id);
            $stmt->execute();
            responderHistorial(array("success" => true, "message" => "Datos de la mascota actualizados correctamente."));

        case "delete":
            $stmt = $conexion->prepare("DELETE FROM mascota WHERE id_mascota = ?");
            $stmt->bind_param("s", $id);
            $stmt->execute();
            responderHistorial(array("success" => $stmt->affected_rows > 0));

        case "buscar":
            $nomMascota = isset($_POST["nom_mascota"]) ? trim($_POST["nom_mascota"]) : "";
            $nomTutor = isset($_POST["nom_tutor"]) ? trim($_POST["nom_tutor"]) : "";
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
                    WHERE 1=1";
            if ($nomMascota !== "" && $nomTutor !== "") {
                $busquedaMascota = "%" . $nomMascota . "%";
                $busquedaTutor = "%" . $nomTutor . "%";
                $sql .= " AND m.nom_mascota LIKE ? AND CONCAT_WS(' ', COALESCE(u.nombre,''), COALESCE(u.apellido_paterno,''), COALESCE(u.apellido_materno,'')) LIKE ?";
                $stmt = $conexion->prepare($sql . " ORDER BY m.nom_mascota ASC");
                $stmt->bind_param("ss", $busquedaMascota, $busquedaTutor);
            } elseif ($nomMascota !== "") {
                $busquedaMascota = "%" . $nomMascota . "%";
                $stmt = $conexion->prepare($sql . " AND m.nom_mascota LIKE ? ORDER BY m.nom_mascota ASC");
                $stmt->bind_param("s", $busquedaMascota);
            } elseif ($nomTutor !== "") {
                $busquedaTutor = "%" . $nomTutor . "%";
                $stmt = $conexion->prepare($sql . " AND CONCAT_WS(' ', COALESCE(u.nombre,''), COALESCE(u.apellido_paterno,''), COALESCE(u.apellido_materno,'')) LIKE ? ORDER BY m.nom_mascota ASC");
                $stmt->bind_param("s", $busquedaTutor);
            } else {
                $stmt = $conexion->prepare($sql . " ORDER BY m.nom_mascota ASC");
            }
            $stmt->execute();
            responderHistorial($stmt->get_result()->fetch_all(MYSQLI_ASSOC));

        default:
            responderHistorial(array("success" => false, "message" => "Operación no válida."), 400);
    }

    if ($id === "") {
        responderHistorial(array("success" => false, "message" => "Identificador de mascota no válido."), 400);
    }
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    responderHistorial($stmt->get_result()->fetch_all(MYSQLI_ASSOC));
} catch (mysqli_sql_exception $error) {
    eliminarArchivoHistorial($archivoGuardado);
    error_log("Error al consultar o actualizar el historial: " . $error->getMessage());
    responderHistorial(array("success" => false, "message" => "Ocurrió un error al procesar el historial."), 500);
}
