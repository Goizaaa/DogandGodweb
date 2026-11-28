
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Consultar historial </title>
    <script src="../Controlador/consultarHistorial.js?v=20261127-3" defer></script>
    <script src="../Controlador/paginacionTablas.js?v=20261013-2" defer></script>
    <link rel="stylesheet" href="../css/CssGlobal.css?v=20261123-1">
</head>

<body class="vista-tablas">

<header>
    
        <!--encabezado-->
        <?php include_once("include/header.php") ?>
        <!--fin encabezado-->

    </header>

    <main>

    <aside>
    <!--nav bar laterial-->
    <ul class="nav flex-column">
  <li class="nav-item">
    <a class="nav-link active" aria-current="page"  id="btnGeneral">Informacion General</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#" id="btnConsultas">Consultas realizadas</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#" id="btnProcedimientos">Procedimientos</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#" id="btnLaboratorio">Resultados de laboratorio</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#" id="btnRadiografias">Radiografías</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#" id="btnUltrasonido">Ultrasonidos</a>
  </li>
  <li class="nav-item" >
    <a class="nav-link" onclick="location.href='modificarhist.php'">Modificar</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" onclick="location.href='eliminarhist.php'">Eliminar</a>
  </li>
</ul>
</aside>
<!-- terrmina nav bar laterial-->
      

        <section>
            <article id="informacionGeneral">
                <h2>Información General</h2>
                <table id="tabla" class="table table-hover tabla-datos">
                    <thead>
                        <tr>
                            <th>Nombre Mascota</th>
                            <th>Nombre Tutor</th>
                            <th>Especie</th>
                            <th>Raza</th>
                            <th>Fecha Nacimiento</th>
                            <th>Peso (kg)</th>
                            <th>Sexo</th>
                            <th>Esterilizado</th>
                            <th>Teléfono</th>
                            <th>Alergias</th>
                            <th>Microchip</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody></tbody> 
                </table>
            </article>

            <article id="consultas">
                <div class="historial-seccion-cabecera">
                    <h2>Consultas realizadas</h2>
                    <button class="btn-nuevo" type="button" id="btnRegistrarConsulta">Registrar consulta</button>
                </div>
                <table id="tablaConsultas" class="tabla-datos">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Peso (kg)</th>
                            <th>Temperatura (°C)</th>
                            <th>Frecuencia cardíaca</th>
                            <th>Análisis clínicos</th>
                            <th>Diagnóstico</th>
                            <th>Medicamento</th>
                            <th>Dosis</th>
                            <th>Frecuencia de administración</th>
                            <th>Fecha inicial</th>
                            <th>Fecha final</th>
                        </tr>
                    </thead>
                     <tbody></tbody>
                </table>
            </article>

            <article id="procedimientos">
                <div class="historial-seccion-cabecera">
                    <h2>Procedimientos</h2>
                    <button class="btn-nuevo" type="button" data-abrir-modal="modalProcedimientos">Agregar</button>
                </div>
                <table id="tablaProcedimientos" class="tabla-datos">
                    <thead>
                        <tr>
                            <th>Procedimiento</th>
                            <th>Descripción</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                     <tbody></tbody>
                </table>
            </article>

            <article id="laboratorio">
                <div class="historial-seccion-cabecera">
                    <h2>Resultados de laboratorio</h2>
                    <button class="btn-nuevo" type="button" data-abrir-modal="modalLaboratorio">Agregar</button>
                </div>
                <table id="tablaLaboratorio" class="tabla-datos">
                    <thead>
                        <tr>
                            <th>Análisis: </th>
                            <th>Descripción</th>
                            <th>Fecha</th>
                            <th>Archivo</th>
                        </tr>
                    </thead>
                     <tbody></tbody>
                </table>
            </article>

            <article id="radiografias">
                <div class="historial-seccion-cabecera">
                    <h2>Radiografías</h2>
                    <button class="btn-nuevo" type="button" data-abrir-modal="modalRadiografias">Agregar</button>
                </div>
                <table id="tablaRadiografias" class="tabla-datos">
                    <thead>
                        <tr>
                            <th>Radiografía</th>
                            <th>Descripción</th>
                            <th>Fecha</th>
                            <th>Archivo</th>
                        </tr>
                    </thead>
                     <tbody></tbody>
                </table>
            </article>

            <article id="ultrasonido">
                <div class="historial-seccion-cabecera">
                    <h2>Ultrasonidos</h2>
                    <button class="btn-nuevo" type="button" data-abrir-modal="modalUltrasonido">Agregar</button>
                </div>
                <table id="tablaUltrasonido" class="tabla-datos">
                    <thead>
                        <tr>
                            <th>Ultrasonido</th>
                            <th>Descripción</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                     <tbody></tbody>
                </table>
            </article>
        </section>
        <input type="hidden" id="id_mascota" name="id_mascota">
    </main>

    <dialog class="tabla-modal" id="modalEditarMascota" aria-labelledby="tituloModalEditarMascota">
        <div class="tabla-modal-cabecera">
            <div>
                <h2 id="tituloModalEditarMascota">Modificar datos de la mascota</h2>
                <p>Actualiza el peso, la esterilización, las alergias o el número de microchip.</p>
            </div>
            <button class="tabla-modal-cerrar" type="button" data-cerrar-edicion aria-label="Cerrar">&times;</button>
        </div>
        <form class="tabla-modal-form" id="formEditarMascota">
            <div class="tabla-modal-campo">
                <label for="editarPeso">Peso (kg)</label>
                <input id="editarPeso" name="peso_inicial" type="number" min="0" max="9999999999" step="1" required>
            </div>
            <div class="tabla-modal-campo">
                <label for="editarEsterilizado">Esterilizado</label>
                <select id="editarEsterilizado" name="esterilizado" required>
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                </select>
            </div>
            <div class="tabla-modal-campo">
                <label for="editarAlergia">Alergias (opcional)</label>
                <input id="editarAlergia" name="alergia" type="text" maxlength="50">
            </div>
            <div class="tabla-modal-campo">
                <label for="editarMicrochip">Número de microchip (opcional)</label>
                <input id="editarMicrochip" name="NumMicrochip" type="text" maxlength="15">
            </div>
            <div class="tabla-modal-mensaje" id="mensaje-editar-mascota" role="status" aria-live="polite"></div>
            <div class="tabla-modal-acciones">
                <button class="tabla-modal-secundario" type="button" data-cerrar-edicion>Cancelar</button>
                <button class="tabla-modal-guardar" type="submit">Guardar cambios</button>
            </div>
        </form>
    </dialog>

    <dialog class="tabla-modal" id="modalProcedimientos" aria-labelledby="tituloModalProcedimientos">
        <div class="tabla-modal-cabecera">
            <div>
                <h2 id="tituloModalProcedimientos">Agregar procedimiento</h2>
                <p>Registra un procedimiento en el expediente de esta mascota.</p>
            </div>
            <button class="tabla-modal-cerrar" type="button" data-cerrar-modal aria-label="Cerrar">&times;</button>
        </div>
        <form class="tabla-modal-form" data-form-historial data-tipo="procedimientos">
            <div class="tabla-modal-campo">
                <label for="procedimientoNombre">Procedimiento</label>
                <input id="procedimientoNombre" name="nombre" maxlength="100" required>
            </div>
            <div class="tabla-modal-campo">
                <label for="procedimientoDescripcion">Descripción</label>
                <textarea id="procedimientoDescripcion" name="descripcion" maxlength="300" required></textarea>
            </div>
            <div class="tabla-modal-campo">
                <label for="procedimientoFecha">Fecha</label>
                <input id="procedimientoFecha" name="fecha" type="date" required>
            </div>
            <div class="tabla-modal-mensaje" role="status" aria-live="polite"></div>
            <div class="tabla-modal-acciones">
                <button class="tabla-modal-secundario" type="button" data-cerrar-modal>Cancelar</button>
                <button class="tabla-modal-guardar" type="submit">Guardar</button>
            </div>
        </form>
    </dialog>

    <dialog class="tabla-modal" id="modalLaboratorio" aria-labelledby="tituloModalLaboratorio">
        <div class="tabla-modal-cabecera">
            <div>
                <h2 id="tituloModalLaboratorio">Agregar análisis clínico</h2>
                <p>Registra el análisis y, si lo deseas, adjunta el resultado.</p>
            </div>
            <button class="tabla-modal-cerrar" type="button" data-cerrar-modal aria-label="Cerrar">&times;</button>
        </div>
        <form class="tabla-modal-form" data-form-historial data-tipo="analisisclinicos" enctype="multipart/form-data">
            <div class="tabla-modal-campo">
                <label for="analisisNombre">Análisis</label>
                <input id="analisisNombre" name="nombre" maxlength="100" required>
            </div>
            <div class="tabla-modal-campo">
                <label for="analisisDescripcion">Descripción / resultados</label>
                <textarea id="analisisDescripcion" name="descripcion" maxlength="200" required></textarea>
            </div>
            <div class="tabla-modal-campo">
                <label for="analisisFecha">Fecha</label>
                <input id="analisisFecha" name="fecha" type="date" required>
            </div>
            <div class="tabla-modal-campo">
                <label for="analisisArchivo">Archivo (PDF o imagen, opcional)</label>
                <input id="analisisArchivo" name="archivo" type="file" accept=".pdf,.jpg,.jpeg,.png">
            </div>
            <div class="tabla-modal-mensaje" role="status" aria-live="polite"></div>
            <div class="tabla-modal-acciones">
                <button class="tabla-modal-secundario" type="button" data-cerrar-modal>Cancelar</button>
                <button class="tabla-modal-guardar" type="submit">Guardar</button>
            </div>
        </form>
    </dialog>

    <dialog class="tabla-modal" id="modalRadiografias" aria-labelledby="tituloModalRadiografias">
        <div class="tabla-modal-cabecera">
            <div>
                <h2 id="tituloModalRadiografias">Agregar radiografía</h2>
                <p>Registra la radiografía y adjunta su archivo.</p>
            </div>
            <button class="tabla-modal-cerrar" type="button" data-cerrar-modal aria-label="Cerrar">&times;</button>
        </div>
        <form class="tabla-modal-form" data-form-historial data-tipo="radiografias" enctype="multipart/form-data">
            <div class="tabla-modal-campo">
                <label for="radiografiaNombre">Radiografía</label>
                <input id="radiografiaNombre" name="nombre" maxlength="100" required>
            </div>
            <div class="tabla-modal-campo">
                <label for="radiografiaDescripcion">Descripción</label>
                <textarea id="radiografiaDescripcion" name="descripcion" maxlength="200" required></textarea>
            </div>
            <div class="tabla-modal-campo">
                <label for="radiografiaFecha">Fecha</label>
                <input id="radiografiaFecha" name="fecha" type="date" required>
            </div>
            <div class="tabla-modal-campo">
                <label for="radiografiaArchivo">Archivo (PDF o imagen)</label>
                <input id="radiografiaArchivo" name="archivo" type="file" accept=".pdf,.jpg,.jpeg,.png" required>
            </div>
            <div class="tabla-modal-mensaje" role="status" aria-live="polite"></div>
            <div class="tabla-modal-acciones">
                <button class="tabla-modal-secundario" type="button" data-cerrar-modal>Cancelar</button>
                <button class="tabla-modal-guardar" type="submit">Guardar</button>
            </div>
        </form>
    </dialog>

    <dialog class="tabla-modal" id="modalUltrasonido" aria-labelledby="tituloModalUltrasonido">
        <div class="tabla-modal-cabecera">
            <div>
                <h2 id="tituloModalUltrasonido">Agregar ultrasonido</h2>
                <p>Registra un estudio de ultrasonido en el expediente.</p>
            </div>
            <button class="tabla-modal-cerrar" type="button" data-cerrar-modal aria-label="Cerrar">&times;</button>
        </div>
        <form class="tabla-modal-form" data-form-historial data-tipo="ultrasonido">
            <div class="tabla-modal-campo">
                <label for="ultrasonidoNombre">Ultrasonido</label>
                <input id="ultrasonidoNombre" name="nombre" maxlength="100" required>
            </div>
            <div class="tabla-modal-campo">
                <label for="ultrasonidoDescripcion">Descripción</label>
                <textarea id="ultrasonidoDescripcion" name="descripcion" maxlength="100" required></textarea>
            </div>
            <div class="tabla-modal-campo">
                <label for="ultrasonidoFecha">Fecha</label>
                <input id="ultrasonidoFecha" name="fecha" type="date" required>
            </div>
            <div class="tabla-modal-mensaje" role="status" aria-live="polite"></div>
            <div class="tabla-modal-acciones">
                <button class="tabla-modal-secundario" type="button" data-cerrar-modal>Cancelar</button>
                <button class="tabla-modal-guardar" type="submit">Guardar</button>
            </div>
        </form>
    </dialog>

    <script>
        // Obtener el ID de la mascota (puede venir de la URL o del campo hidden)
        const urlParams = new URLSearchParams(window.location.search);
        const idMascota = urlParams.get('id_mascota') || document.getElementById("id_mascota")?.value || "id_mascota";
        
        // Guardar el ID en localStorage para usarlo en modificarhist.html
        localStorage.setItem("id_mascota_editar", idMascota);
        
        console.log("ID de mascota guardado en localStorage:", idMascota);
    </script>
</body>

</html>

