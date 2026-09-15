<?php
require_once("../Modelo/crud.php");

header("Content-Type: application/json");

$opc = $_POST['opc'];

switch ($opc) {
    case "create":
        $db = new Database();

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
        $res = $db->create("mascota", array(
            "id_mascota" => $nuevoId,
            "nom_mascota" => $_POST['nom_mascota'],
            "especie" => $_POST['especie'],
            "raza" => $_POST['raza'],
            "fecha_adopcion" => $_POST['fecha_adopcion'],
            "peso_inicial" => $_POST['peso_inicial'],
            "sexo" => $_POST['sexo'],
            "esterilizado" => $_POST['esterilizado']
        ));

        echo json_encode(array(
            "success" => $res,
            "id_mascota" => $nuevoId
        ));
        break;
}
?>