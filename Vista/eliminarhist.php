<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar historial</title>
    <link rel="stylesheet" href="../vista/modificar.css">
    <script src="../Controlador/eliminarHistorial.js"></script>
</head>
<body>
<header>
    
<!--encabezado-->
<?php include_once("include/header.php") ?>
<!--fin encabezado-->

</header>

    <main>

        <section>
            <article>
                <h2 id="tituloMascota">Nombre de la mascota</h2>
            </article>
            <div class="confirmar-baja">
                <p>¿Está seguro de querer eliminar de forma permanente este historial?</p>
                <button id="btnSi">Sí, Eliminar</button>
                <button id="btnNo">No, Cancelar</button>
            </div>
        </section>
    </main>
</body>
</html>
