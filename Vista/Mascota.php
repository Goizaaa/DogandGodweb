<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mascotas</title>
    <link rel="stylesheet" href="../vista/modificar.css">
    <script src="../controlador/cntrl.js"></script>
</head>
<body>
<header>
    <h1>Nombre de la página</h1>
    <nav>
        <button class="botonEncabezado" onclick="location.href='HomeVet.html'">Inicio</button>
        <button class="botonEncabezado" onclick="location.href='consultartutores.html'">Tutores</button>
        <button class="botonEncabezado" onclick="location.href='consultarhis.html'">Historiales</button>
        <button class="botonEncabezado" onclick="location.href='SolicitarCita.html'">Citas</button>
        <button class="botonEncabezado" onclick="location.href='respaldo.html'">Inventario</button>
        <button class="botonEncabezado" onclick="location.href='respaldo.html'">Configuración</button>
    </nav>
</header>
    <main>
        <section id="TabMascota">
            <h2>Pacientes registrados</h2>
            <table id="tabla">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Especie</th>
                        <th>Raza</th>
                        <th>Fecha Nacimiento</th>
                        <th>Peso (kg)</th>
                        <th>Sexo</th>
                        <th>Esterilizado</th>
                        <th>Tutor</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </section>
    </main>
</body>
</html>