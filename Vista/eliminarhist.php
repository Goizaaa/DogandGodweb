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
    <h1>Eliminar Historial</h1>
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
        <aside>
            <nav>
                            <nav>
                <ul>
                    <li><button id="btnGeneral" class="botonaside" onclick="location.href='consultarhis.html'">Informacion General</button></li>
                    <li><button id="btnConsultas" class="botonaside">Consultas realizadas</button></li>
                    <li><button id="btnProcedimientos" class="botonaside">Procedimientos</button></li>
                    <li><button id="btnLaboratorio" class="botonaside">Resultados de laboratorio</button></li>
                    <li><button id="btnRadiografias" class="botonaside">Radiografías</button></li>
                    <li><button onclick="location.href='modificarhist.html'" class="botonaside">Modificar</button></li>
                    <li><button onclick="location.href='eliminarhist.html'" class="botonaside">Eliminar</button></li>
                </ul>
            </nav>
        </aside>
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
