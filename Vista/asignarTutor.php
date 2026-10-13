<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asignar Tutor a Mascota</title>
    <link rel="stylesheet" href="../vista/modificar.css">
    <script src="../Controlador/cntrolRelacion.js"></script>
    <link rel="stylesheet" href="../css/CssGlobal.css?v=20261012-4">
</head>
<body>
    <header>
    <?php include_once("include/header.php") ?>
</header>
    <main>
        <section>
            <h2>Asignar tutor a una mascota</h2>
            <div>
                <label>Mascota sin tutor:</label>
                <select id="selectMascota"></select>
            </div>
            <div>
                <label>Tutor:</label>
                <select id="selectTutor"></select>
            </div>
            <button id="btnAsignar">Asignar Tutor</button>
            <div id="mensaje"></div>
        </section>
    </main>
</body>
</html>

