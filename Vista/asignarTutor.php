<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asignar Tutor a Mascota</title>
    <link rel="stylesheet" href="../vista/modificar.css">
    <script src="../Controlador/cntrolRelacion.js"></script>
</head>
<body>
    <header>
        <h1>Relacionar Mascota con Tutor</h1>
        <nav>
                <button class="botonEncabezado" onclick="location.href='HomeVet.html'">Inicio</button>
                <button class="botonEncabezado" onclick="location.href='consultartutores.html'">Tutores</button>
                <button class="botonEncabezado" onclick="location.href='Mascota.html'">Mascotas</button>
                <button class="botonEncabezado" onclick="location.href='consultarhis.html'">Historiales</button>
                <button class="botonEncabezado" id="Citas">Citas</button>
                <button class="botonEncabezado" id="inventario">Inventario</button>
                <button class="botonEncabezado" id="configuracion">Configuracion</button>
        </nav>
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