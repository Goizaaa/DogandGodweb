<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link rel="stylesheet" href="../css/Inventario.css">
</head>



<header>
    
        <!--encabezado-->
        <?php include_once("include/header.php") ?>
        <!--fin encabezado-->

    </header>

    <form action="" id="AgregarProducto" class="AgregarProducto">
        <label for="NewProducto"> Nombre del producto: </label>
        <input type="text" name="NewProducto" id="NewProducto">

        <label for="NewCategoria"> Categoria del producto: </label>
        <select name="NewCategoria" id="NewCategoria">
            <option value="NewMedicamento">Medicamento</option>
            <option value="NewVacuna">Vacuna</option>
            <option value="NewAlimentos">Alimentos</option>
            <option value="NewAccesorios">Accesorios</option>
        </select>

        <label for="NewPrecio">Precio:</label>
            <div class="input-moneda">
                <span>$</span>
        <input type="number" step="0.01" min="0" name="NewPrecio" id="NewPrecio" placeholder="0.00">
            </div>

        <label for="NewMarca"> Marca: </label>
        <input type="text" name="NewMarca" id="NewMarca">

        <label for="NewCantidad"> Cantidad: </label>
        <input type="text" name="NewCantidad" id="NewCantidad">

        <label for="NewCosto">Costo:</label>
            <div class="input-moneda">
                <span>$</span>
        <input type="number" step="0.01" min="0" name="NewCosto" id="NewCosto" placeholder="0.00">
        </div>

    </form>

        <div class="botones-editar">
            <button class="boton-editarE">Guardar cambios</button>
            <button class="boton-agregarE">Cancelar</button>     
        </div>




<footer>
    <p> </p>
</footer>

<body>
    
</body>
</html>