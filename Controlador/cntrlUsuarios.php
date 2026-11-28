<?php
require_once("../Modelo/crud.php");

header("Content-Type: application/json; charset=utf-8");

function longitudTextoMascota($valor)
{
    return function_exists("mb_strlen") ? mb_strlen($valor, "UTF-8") : strlen($valor);
}

$opc = $_POST['opc'] ?? '';

switch ($opc) {
    case "create":
        $db = new Database();
        $nombre = trim($_POST['nom_mascota'] ?? '');
        $especie = trim($_POST['especie'] ?? '');
        $raza = trim($_POST['raza'] ?? '');
        $fecha = trim($_POST['fecha_adopcion'] ?? '');
        $peso = trim($_POST['peso_inicial'] ?? '');
        $sexo = trim($_POST['sexo'] ?? '');
        $esterilizado = $_POST['esterilizado'] ?? '';
        $alergia = trim($_POST['alergia'] ?? '');
        $microchip = trim($_POST['NumMicrochip'] ?? '');
        $fechaValida = DateTime::createFromFormat('!Y-m-d', $fecha);

        if ($nombre === '' || longitudTextoMascota($nombre) > 100 ||
            $especie === '' || longitudTextoMascota($especie) > 50 ||
            $raza === '' || longitudTextoMascota($raza) > 50 ||
            !$fechaValida || $fechaValida->format('Y-m-d') !== $fecha ||
            $sexo === '' || longitudTextoMascota($sexo) > 50 ||
            !preg_match('/^\d{1,10}$/', $peso) || !in_array($esterilizado, ['0', '1'], true)) {
            http_response_code(400);
            echo json_encode(array("success" => false, "message" => "Revisa los datos obligatorios de la mascota y su peso."));
            break;
        }
        if (longitudTextoMascota($alergia) > 50 || longitudTextoMascota($microchip) > 15) {
            http_response_code(400);
            echo json_encode(array("success" => false, "message" => "Las alergias admiten hasta 50 caracteres y el microchip hasta 15."));
            break;
        }

        $correoTutor = trim($_POST['correo_tutor'] ?? '');

        if ($correoTutor !== '') {
            if (!filter_var($correoTutor, FILTER_VALIDATE_EMAIL)) {
                http_response_code(400);
                echo json_encode(array("success" => false, "message" => "El correo del tutor no es válido."));
                break;
            }
            $tutorExiste = $db->read("tutor", "correo_tutor = '" . addslashes($correoTutor) . "'");
            if (!$tutorExiste || count($tutorExiste) === 0) {
                http_response_code(400);
                echo json_encode(array("success" => false, "message" => "No se encontró el tutor para relacionar la mascota."));
                break;
            }
        }

        //  utimo ifd de la tabla mascota
        $datos = $db->read("mascota", "1 ORDER BY id_mascota DESC LIMIT 1");

        if (count($datos) > 0) {
            $ultimo = $datos[0]['id_mascota']; // 550
            $numero = intval(substr($ultimo, 1)) + 1;
            $nuevoId = "M" . str_pad($numero, 3, "0", STR_PAD_LEFT);
        } else {
            $nuevoId = "M001";
        }

        //create
        $datosMascota = array(
            "id_mascota" => $nuevoId,
            "nom_mascota" => $nombre,
            "especie" => $especie,
            "raza" => $raza,
            "fecha_adopcion" => $fecha,
            "peso_inicial" => $peso,
            "sexo" => $sexo,
            "esterilizado" => $esterilizado,
            "alergia" => $alergia === '' ? null : $alergia,
            "NumMicrochip" => $microchip === '' ? null : $microchip
        );
        if ($correoTutor !== '') $datosMascota["correo_tutor"] = $correoTutor;

        $res = $db->create("mascota", $datosMascota);

        echo json_encode(array(
            "success" => $res,
            "id_mascota" => $res ? $nuevoId : null,
            "message" => $res ? "Mascota registrada y relacionada con su tutor." : "No se pudo registrar la mascota."
        ));
        break;
}
?>
