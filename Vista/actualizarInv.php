<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario home</title>
    <link rel="stylesheet" href="../css/Inventario.css">
<script src="../controlador/cntrlInv.js"></script></head>
<body>


<header>
    
        <!--encabezado-->
        <?php include_once("include/header.php") ?>
        <!--fin encabezado-->

    </header>


    <!-- Agrega onsubmit="return false;" -->
<form id="BuscarProducto" onsubmit="return false;">
    <label for="BusProducto"> Nombre del producto: </label>
    <input type="text" name="BusProducto" id="BusProducto">
    
    <!-- Agrega type="button" -->
    <button type="button" class="boton-buscar" id="boton-buscar">Buscar</button>
</form>

    <div class="botones-editar-agregar">
        <button class="boton-editar">Editar producto</button>
        <button class="boton-agregar">Agregar producto</button>
    </div>

    <div class="botones-inventario">
        <button>Total de productos</button>
        <button>Valor del inventario</button>
    </div>

    <table id="tabla-inventario" class="tabla-inventario">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre del Producto</th>
                <th>Precio</th>
                <th>Marca</th>
                <th>Cantidad</th>
                <th>Costo</th>
            </tr>
        </thead>
        <tbody>
            <!-- Datos dinámicos -->
        </tbody>
    </table>

    <footer>
        <p>&copy; 2023 Inventario. Todos los derechos reservados.</p>
    </footer>
</body>
</html>