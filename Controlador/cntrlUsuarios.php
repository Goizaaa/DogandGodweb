<?php
require_once("../Modelo/crud.php");

header("Content-Type: application/json");

$opc = $_POST['opc'];

switch ($opc) {
    case "create":
        $db = new Database();
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
            "nom_mascota" => $_POST['nom_mascota'],
            "especie" => $_POST['especie'],
            "raza" => $_POST['raza'],
            "fecha_adopcion" => $_POST['fecha_adopcion'],
            "peso_inicial" => $_POST['peso_inicial'],
            "sexo" => $_POST['sexo'],
            "esterilizado" => $_POST['esterilizado']
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
