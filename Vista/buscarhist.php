<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar historial | Dog&amp;God</title>
    <script src="../Controlador/cntrl.js" defer></script>
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
                <p class="tabla-pagina-eyebrow">EXPEDIENTES</p>
                <h1>Buscar historial</h1>
                <p>Encuentra pacientes por su nombre o por el nombre de su tutor.</p>
            </div>
        </section>
        <form class="tabla-filtros" onsubmit="return false;">
            <div class="tabla-filtro-campo">
                <label for="buscarMascota">Nombre de la mascota</label>
                <input type="search" name="buscarMascota" id="buscarMascota" placeholder="Buscar mascota">
            </div>
            <div class="tabla-filtro-campo">
                <label for="buscarTutor">Nombre del tutor</label>
                <input type="search" name="buscarTutor" id="buscarTutor" placeholder="Buscar tutor">
            </div>
            <button type="button" id="btnBuscar">Buscar</button>
        </form>
        <div class="tabla-contenedor">
            <table class="tabla-datos" id="tabla">
                <thead>
                    <tr>
                        <th>ID Mascota</th>
                        <th>Nombre Mascota</th>
                        <th>Especie</th>
                        <th>Raza</th>
                        <th>Fecha Adopcion</th>
                        <th>Sexo</th>
                        <th>Esterilizado</th>
                        <th>Nombre Tutor</th>
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
