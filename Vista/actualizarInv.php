<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario | Dog&amp;God</title>
    <script src="../controlador/cntrlInv.js" defer></script>
    <script src="../Controlador/paginacionTablas.js?v=20261013-1" defer></script>
    <link rel="stylesheet" href="../css/CssGlobal.css?v=20261013-7">
</head>
<body class="vista-tablas vista-inventario">


<header>
    
        <!--encabezado-->
        <?php include_once("include/header.php") ?>
        <!--fin encabezado-->

    </header>


    <!-- Agrega onsubmit="return false;" -->
<main class="tabla-pagina-main">
    <section class="tabla-pagina-cabecera">
        <div>
            <p class="tabla-pagina-eyebrow">GESTIÓN DE PRODUCTOS</p>
            <h1>Inventario</h1>
            <p>Busca productos y consulta las existencias registradas.</p>
        </div>
        <div class="tabla-pagina-acciones botones-editar-agregar">
            <button type="button" class="boton-editar">Editar producto</button>
            <button type="button" class="boton-agregar">Agregar producto</button>
        </div>
    </section>

    <form class="tabla-filtros inventario-filtros" id="BuscarProducto" onsubmit="return false;">
        <label for="BusProducto">Nombre del producto</label>
        <input type="search" name="BusProducto" id="BusProducto" placeholder="Ej. alimento para perro">
        <button type="button" class="boton-buscar" id="boton-buscar">Buscar</button>
    </form>

    <div class="botones-inventario tabla-resumen">
        <button type="button">Total de productos</button>
        <button type="button">Valor del inventario</button>
    </div>

    <div class="tabla-contenedor">
      <table id="tabla-inventario" class="tabla-datos">
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
    </div>
</main>

    <footer>
        <p>&copy; Dog&amp;God · Inventario</p>
    </footer>
</body>
</html>
