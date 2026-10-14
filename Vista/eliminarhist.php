<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar historial</title>
    <script src="../Controlador/eliminarHistorial.js"></script>
    <link rel="stylesheet" href="../css/CssGlobal.css?v=20261014-3">
</head>
<body class="vista-formularios">
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

