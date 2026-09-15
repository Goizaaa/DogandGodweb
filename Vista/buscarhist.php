<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar historial</title>
    <link rel="stylesheet" href="../Vista/modificar.css">
    <script src="../Controlador/cntrl.js"></script>
</head>

<body>
    <header>
    
        <!--encabezado-->
        <?php include_once("include/header.php") ?>
        <!--fin encabezado-->

    </header>

    <main class="buscar">
        <section class="buscador">
            <label>Nombre mascota:</label>
            <input type="text" name="buscarMascota" id="buscarMascota" placeholder="Buscar mascota">

            <label>Nombre tutor:</label>
            <input type="text" name="buscarTutor" id="buscarTutor" placeholder="Buscar tutor">
            
            <button id="btnBuscar">Buscar</button>
        </section>
         
        <div>
        <table class="table table-hover" id="tabla">
                <thead>
                    <tr>
                        <th>ID Mascota</th>s
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