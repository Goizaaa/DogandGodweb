<?php
require_once("../Modelo/crud.php");
header("Content-Type: application/json");

$db = new Database();

$opc = isset($_POST['opc']) ? $_POST['opc'] : '';

switch ($opc) {
    case "buscar":
        $id_producto = isset($_POST['id_producto']) ? trim($_POST['id_producto']) : '';
        $nom_producto = isset($_POST['nom_producto']) ? trim($_POST['nom_producto']) : '';

        // Se eliminó la coma sobrante después de m.costo_prod
        $sql = "SELECT 
                    m.id_producto,
                    m.nom_producto,
                    m.precio_prod,
                    m.marca_prod,
                    m.stock_prod,
                    m.costo_prod
                FROM producto m
                WHERE 1=1";

        if (!empty($id_producto)) {
            $sql .= " AND m.id_producto = '$id_producto'";
        }
        if (!empty($nom_producto)) {
            $sql .= " AND m.nom_producto LIKE '%" . addslashes($nom_producto) . "%'";
        }
        
        $sql .= " ORDER BY m.nom_producto ASC";

        $result = $db->readCustom($sql);
        echo json_encode($result);
        exit();
}
?>