<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citas registradas | Dog&amp;God</title>
    <script src="../Controlador/citasRegistradas.js?v=20261013-1" defer></script>
    <script src="../Controlador/paginacionTablas.js?v=20261013-1" defer></script>
    <link rel="stylesheet" href="../css/CssGlobal.css?v=20261014-3">
</head>

<body class="vista-tablas">
    <header>
        <!--encabezado-->
        <?php include_once("include/header.php") ?>
        <!--fin encabezado-->
    </header>

    <main class="tabla-pagina-main">
        <section class="tabla-pagina-cabecera">
            <div>
                <p class="tabla-pagina-eyebrow">AGENDA VETERINARIA</p>
                <h1>Citas registradas</h1>
                <p>Consulta y administra las citas agendadas.</p>
            </div>
            <div class="tabla-pagina-acciones">
                <a class="btn-nuevo" href="ConsultarCitaV.php">+ Agregar cita</a>
            </div>
        </section>
        <div class="tabla-contenedor">
            <table class="tabla-datos" id="tablaCitas">
                <thead>
                    <tr>
                        <th>ID Cita</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Procedimiento</th>
                        <th>Correo Tutor</th>
                        <th>Correo Veterinario</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </main>

</body>

</html>

