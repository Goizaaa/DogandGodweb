<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario | Dog&amp;God</title>
<<<<<<< HEAD
    <script src="../controlador/cntrlInv.js" defer></script>
    <script src="../Controlador/paginacionTablas.js?v=20261013-2" defer></script>
    <link rel="stylesheet" href="../css/CssGlobal.css?v=20261022-1">
=======
    <script src="../Controlador/cntrlInv.js?v=20261106-2" defer></script>
    <script src="../Controlador/paginacionTablas.js?v=20261013-1" defer></script>
    <link rel="stylesheet" href="../css/CssGlobal.css?v=20261106-1">
>>>>>>> 1f1432157c121ddda9eb5c8ec9097a6a1f39ea18
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
            <button type="button" class="boton-editar" id="abrir-modal-editar-producto">Editar producto</button>
            <button type="button" class="boton-agregar" id="abrir-modal-agregar-producto">Agregar producto</button>
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

<dialog class="tabla-modal tabla-modal-editar-producto" id="modal-editar-producto" aria-labelledby="titulo-modal-editar-producto">
    <div class="tabla-modal-cabecera">
        <div>
            <p class="tabla-pagina-eyebrow">GESTIÓN DE PRODUCTOS</p>
            <h2 id="titulo-modal-editar-producto">Editar producto</h2>
            <p>Completa los datos del producto que deseas actualizar.</p>
        </div>
        <button class="tabla-modal-cerrar" id="cerrar-modal-editar-producto" type="button" aria-label="Cerrar ventana">&times;</button>
    </div>

    <form action="" id="form-editar-producto" class="tabla-modal-formulario">
        <div class="tabla-modal-campo">
            <label for="NewProducto">Nombre del producto</label>
            <input type="text" name="NewProducto" id="NewProducto">
        </div>

        <div class="tabla-modal-campo">
            <label for="NewCategoria">Categoría del producto</label>
            <select name="NewCategoria" id="NewCategoria">
                <option value="NewMedicamento">Medicamento</option>
                <option value="NewVacuna">Vacuna</option>
                <option value="NewAlimentos">Alimentos</option>
                <option value="NewAccesorios">Accesorios</option>
            </select>
        </div>

        <div class="tabla-modal-campo">
            <label for="NewPrecio">Precio</label>
            <div class="input-moneda">
                <span>$</span>
                <input type="number" step="0.01" min="0" name="NewPrecio" id="NewPrecio" placeholder="0.00">
            </div>
        </div>

        <div class="tabla-modal-campo">
            <label for="NewMarca">Marca</label>
            <input type="text" name="NewMarca" id="NewMarca">
        </div>

        <div class="tabla-modal-campo">
            <label for="NewCantidad">Cantidad</label>
            <input type="number" min="0" name="NewCantidad" id="NewCantidad">
        </div>

        <div class="tabla-modal-campo">
            <label for="NewCosto">Costo</label>
            <div class="input-moneda">
                <span>$</span>
                <input type="number" step="0.01" min="0" name="NewCosto" id="NewCosto" placeholder="0.00">
            </div>
        </div>

        <div class="tabla-modal-acciones">
            <button class="tabla-modal-guardar" type="button">Guardar cambios</button>
            <button class="tabla-modal-secundario" id="cancelar-modal-editar-producto" type="button">Cancelar</button>
        </div>
    </form>
</dialog>

<dialog class="tabla-modal tabla-modal-editar-producto" id="modal-agregar-producto" aria-labelledby="titulo-modal-agregar-producto">
    <div class="tabla-modal-cabecera">
        <div>
            <p class="tabla-pagina-eyebrow">GESTIÓN DE PRODUCTOS</p>
            <h2 id="titulo-modal-agregar-producto">Agregar producto</h2>
            <p>Completa la información del producto que deseas registrar.</p>
        </div>
        <button class="tabla-modal-cerrar" id="cerrar-modal-agregar-producto" type="button" aria-label="Cerrar ventana">&times;</button>
    </div>

    <form action="" id="form-agregar-producto" class="tabla-modal-formulario">
        <div class="tabla-modal-campo">
            <label for="AddProducto">Nombre del producto</label>
            <input type="text" name="NewProducto" id="AddProducto">
        </div>

        <div class="tabla-modal-campo">
            <label for="AddCategoria">Categoría del producto</label>
            <select name="NewCategoria" id="AddCategoria">
                <option value="NewMedicamento">Medicamento</option>
                <option value="NewVacuna">Vacuna</option>
                <option value="NewAlimentos">Alimentos</option>
                <option value="NewAccesorios">Accesorios</option>
            </select>
        </div>

        <div class="tabla-modal-campo">
            <label for="AddPrecio">Precio</label>
            <div class="input-moneda">
                <span>$</span>
                <input type="number" step="0.01" min="0" name="NewPrecio" id="AddPrecio" placeholder="0.00">
            </div>
        </div>

        <div class="tabla-modal-campo">
            <label for="AddMarca">Marca</label>
            <input type="text" name="NewMarca" id="AddMarca">
        </div>

        <div class="tabla-modal-campo">
            <label for="AddCantidad">Cantidad</label>
            <input type="number" min="0" name="NewCantidad" id="AddCantidad">
        </div>

        <div class="tabla-modal-campo">
            <label for="AddCosto">Costo</label>
            <div class="input-moneda">
                <span>$</span>
                <input type="number" step="0.01" min="0" name="NewCosto" id="AddCosto" placeholder="0.00">
            </div>
        </div>

        <div class="tabla-modal-acciones">
            <button class="tabla-modal-guardar" type="button">Agregar producto</button>
            <button class="tabla-modal-secundario" id="cancelar-modal-agregar-producto" type="button">Cancelar</button>
        </div>
    </form>
</dialog>

    <footer>
        <p>&copy; Dog&amp;God · Inventario</p>
    </footer>
</body>
</html>
