<?php
require_once("../Modelo/crud.php");
header("Content-Type: application/json");

$db = new Database();

$opc = $_POST['opc'] ?? '';

switch ($opc) {
    case "buscar":
        $nom_producto = trim($_POST['nom_producto'] ?? '');
        $sql = "SELECT id_producto, nom_producto, precio_prod, categoria_prod, marca_prod,
                       Stock_prod AS stock_prod, costo_prod
                FROM producto";
        if ($nom_producto !== '') {
            $stmt = $db->conexion()->prepare($sql . " WHERE nom_producto LIKE ? ORDER BY nom_producto ASC");
            $busqueda = '%' . $nom_producto . '%';
            $stmt->bind_param('s', $busqueda);
        } else {
            $stmt = $db->conexion()->prepare($sql . " ORDER BY nom_producto ASC");
        }
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        echo json_encode($result);
        exit();

    case "editar":
        $id = trim($_POST['id_producto'] ?? '');
        $nombre = trim($_POST['NewProducto'] ?? '');
        $categoria = trim($_POST['NewCategoria'] ?? '');
        $precio = $_POST['NewPrecio'] ?? '';
        $marca = trim($_POST['NewMarca'] ?? '');
        $cantidad = $_POST['NewCantidad'] ?? '';
        $costo = $_POST['NewCosto'] ?? '';

        if ($id === '' || $nombre === '' || $categoria === '' || $marca === ''
            || !is_numeric($precio) || (float)$precio < 0
            || filter_var($cantidad, FILTER_VALIDATE_INT) === false || (int)$cantidad < 0
            || !is_numeric($costo) || (float)$costo < 0) {
            echo json_encode(["status" => "error", "message" => "Completa los datos del producto correctamente."]);
            exit();
        }

        $stmt = $db->conexion()->prepare(
            "UPDATE producto SET nom_producto = ?, precio_prod = ?, categoria_prod = ?,
             marca_prod = ?, Stock_prod = ?, costo_prod = ? WHERE id_producto = ?"
        );
        $precio = (float)$precio;
        $cantidad = (int)$cantidad;
        $costo = (float)$costo;
        $stmt->bind_param('sdssids', $nombre, $precio, $categoria, $marca, $cantidad, $costo, $id);
        $ok = $stmt->execute();
        $actualizado = $stmt->affected_rows > 0;
        $stmt->close();
        echo json_encode($ok ? ["status" => "success", "message" => $actualizado ? "Producto actualizado." : "Los datos del producto no cambiaron."] : ["status" => "error", "message" => "No se pudo actualizar el producto."]);
        exit();

    case "eliminar":
        $id = trim($_POST['id_producto'] ?? '');
        if ($id === '') {
            echo json_encode(["status" => "error", "message" => "Falta el identificador del producto."]);
            exit();
        }
        $stmt = $db->conexion()->prepare("DELETE FROM producto WHERE id_producto = ?");
        $stmt->bind_param('s', $id);
        $ok = $stmt->execute() && $stmt->affected_rows > 0;
        $stmt->close();
        echo json_encode($ok ? ["status" => "success", "message" => "Producto eliminado."] : ["status" => "error", "message" => "No se encontró el producto o no se pudo eliminar."]);
        exit();
}
?>
