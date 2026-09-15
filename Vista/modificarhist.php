<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar historial</title>
    <link rel="stylesheet" href="../vista/modificar.css">
    <script src="../Controlador/modificarHistorial.js"></script>
</head>
<body>
<header>
    <h1>Modificar historial</h1>
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
                <ul>
                    <li><button id="btnGeneral" class="botonaside">Informacion General</button></li>
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
   <form id="modificar" class="register-form">
    <label>Peso:</label>
    <input type="text" id="peso" name="peso_inicial"> 
    <br><br>
    
    <label>Esterilizado:</label>
    <select id="esterilizado" name="esterilizado">
        <option value="1">Si</option>
        <option value="0">No</option>
    </select>
    
    <!-- CORRECCIÓN CRÍTICA: Debe tener id Y name obligatoriamente -->
    <input type="hidden" id="id_mascota" name="id_mascota">
    
    <br><br>
    <button id="btnModificar">Aceptar</button> 
</form>

</article>

            
            <!-- Tu campo hidden indispensable -->
            <input type="hidden" id="id_mascota" name="id_mascota">
        </section>
    </main>

    <dialog id="modalConfirmar" style="padding: 20px; border-radius: 8px; border: 1px solid #ccc; text-align: center;">
        <h3>¿Confirmar cambios?</h3>
        <p>¿Estás seguro de que deseas actualizar el peso y estado de esterilización?</p>
        <button id="btnCancelarModal">Cancelar</button>
        <button id="btnAceptarModal" style="background-color: #4CAF50; color: white;">Sí, Guardar</button>
    </dialog>

    <dialog id="modalExito" style="padding: 20px; border-radius: 8px; border: 1px solid #ccc; text-align: center;">
        <h3>¡Éxito!</h3>
        <p>El expediente ha sido actualizado correctamente.</p>
        <button id="btnCerrarExito">OK</button>
    </dialog>
</body>
</html>
