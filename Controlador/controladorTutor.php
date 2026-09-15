<?php
require_once("../Modelo/crud.php");
header("Content-Type: application/json");

$db = new Database();
$opc = isset($_POST['opc']) ? $_POST['opc'] : '';

switch ($opc) {
    case 'create':
        $correo = isset($_POST['correo_tutor']) ? $_POST['correo_tutor'] : '';
        
        $existe = $db->read("tutor", "correo_tutor = '$correo'");
        
        if (count($existe) > 0) {
            echo json_encode([
                "success" => false, 
                "message" => "El correo ya está registrado"
            ]);
            exit;
        }
        
        $res = $db->create("tutor", array(
            "correo_tutor" => $_POST['correo_tutor'],
            "nom_tutor" => $_POST['nom_tutor'],
            "app_tutor" => $_POST['app_tutor'],
            "apm_tutor" => $_POST['apm_tutor'],
            "numtel_tutor" => $_POST['numtel_tutor'],
            "sexo" => $_POST['sexo'],
            "direccion" => $_POST['direccion']
        ));
        
        echo json_encode(array(
            "success" => $res,
            "message" => $res ? "Tutor registrado correctamente" : "Error al registrar tutor"
        ));
        break;
        
    case 'listar':
        $tutores = $db->read("tutor", "1 ORDER BY nom_tutor ASC");
        echo json_encode($tutores);
        break;
        
    case 'update':
        $correo_original = isset($_POST['correo_original']) ? $_POST['correo_original'] : '';
        $correo_nuevo = isset($_POST['correo_tutor']) ? $_POST['correo_tutor'] : '';
        
        if($correo_original != $correo_nuevo) {
            $existe = $db->read("tutor", "correo_tutor = '$correo_nuevo'");
            if (count($existe) > 0) {
                echo json_encode([
                    "success" => false, 
                    "message" => "El nuevo correo ya está registrado por otro tutor"
                ]);
                exit;
            }
        }
        
        $data = array(
            "correo_tutor" => $correo_nuevo,

            "numtel_tutor" => $_POST['numtel_tutor'],
            "direccion" => $_POST['direccion']
        );
        
        $condition = "correo_tutor = '$correo_original'";
        $result = $db->update("tutor", $data, $condition);
        
        echo json_encode([
            "success" => $result, 
            "message" => $result ? "Tutor actualizado correctamente" : "Error al actualizar tutor"
        ]);
        break;
        
    case 'delete':
        $correo = isset($_POST['correo_tutor']) ? $_POST['correo_tutor'] : '';
        $result = $db->delete("tutor", "correo_tutor = '$correo'");
        
        echo json_encode([
            "success" => $result, 
            "message" => $result ? "Tutor eliminado correctamente" : "Error al eliminar tutor"
        ]);
        break;
        
    default:
        echo json_encode(["success" => false, "message" => "Operación no válida"]);
        break;
}
?>