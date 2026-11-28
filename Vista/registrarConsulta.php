<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Consulta | Dog&God</title>
    <link rel="stylesheet" href="../css/CssGlobal.css?v=20261127-2">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="../Controlador/cntrolConsult.js?v=20261127-2" defer></script>
</head>
<body class="vista-consultar-cita vista-registro-consulta">
    <header>
        <?php include_once("include/header.php") ?>
    </header>

    <main class="consultar-cita-main">
        <div class="consultar-cita-titulo">
            <div>
                <p class="consultar-cita-eyebrow">EXPEDIENTE VETERINARIO</p>
                <h1>Registrar Consulta Médica</h1>
                <p class="registro-consulta-intro">Completa la consulta en cuatro pasos. Tu avance se conserva mientras recorres las secciones.</p>
            </div>
        </div>

        <dialog class="modal-agregar-cita modal-flujo-consulta" id="modalRegistroConsulta" aria-labelledby="titulo-modal-consulta">
            <div class="modal-agregar-cita-heading">
                <div>
                    <p class="consultar-cita-eyebrow">EXPEDIENTE VETERINARIO</p>
                    <h2 id="titulo-modal-consulta">Registrar Consulta Médica</h2>
                </div>
                <button class="modal-cita-cerrar" type="button" id="cerrarRegistroConsulta" aria-label="Salir del registro">&times;</button>
            </div>

            <ol class="consulta-progreso" aria-label="Pasos del registro">
                <li class="activo" data-indicador="0"><span>1</span><small>Consulta</small></li>
                <li data-indicador="1"><span>2</span><small>Diagnóstico</small></li>
                <li data-indicador="2"><span>3</span><small>Tratamiento</small></li>
                <li data-indicador="3"><span>4</span><small>Vigencia</small></li>
            </ol>

            <form id="frmAgregarConsulta" class="formulario-agregar-cita" novalidate>
                <input type="hidden" id="id_cita" name="id_cita" value="">

                <section class="consulta-paso activo" data-paso="0" aria-labelledby="titulo-paso-consulta">
                    <div class="consulta-paso-titulo">
                        <span class="consulta-paso-icono"><i class="fas fa-stethoscope" aria-hidden="true"></i></span>
                        <div><p>PASO 1 DE 4</p><h3 id="titulo-paso-consulta">Datos generales de consulta</h3></div>
                    </div>
                    <div class="consulta-campos-grid">
                        <div class="campo-agregar-cita"><label for="fecha">Fecha de Consulta (*)</label><input type="date" id="fecha" name="fecha" required></div>
                        <div class="campo-agregar-cita"><label for="peso_consulta">Peso de Consulta (kg) (*)</label><input type="number" step="0.1" min="0" id="peso_consulta" name="peso_consulta" placeholder="Ej. 12" required></div>
                        <div class="campo-agregar-cita"><label for="temperatura">Temperatura (°C)</label><input type="number" step="0.1" min="0" id="temperatura" name="temperatura" placeholder="Ej. 38"></div>
                        <div class="campo-agregar-cita"><label for="frecuencia_card">Frecuencia Cardíaca (ppm)</label><input type="number" min="0" id="frecuencia_card" name="frecuencia_card" placeholder="Ej. 110"></div>
                    </div>
                </section>

                <section class="consulta-paso" data-paso="1" aria-labelledby="titulo-paso-diagnostico" hidden>
                    <div class="consulta-paso-titulo">
                        <span class="consulta-paso-icono"><i class="fas fa-notes-medical" aria-hidden="true"></i></span>
                        <div><p>PASO 2 DE 4</p><h3 id="titulo-paso-diagnostico">Diagnóstico</h3></div>
                    </div>
                    <div class="consulta-campos-grid">
                        <div class="campo-agregar-cita"><label for="detalles_diagnosticos">Detalles del Diagnóstico</label><input type="text" id="detalles_diagnosticos" name="detalles_diagnosticos" maxlength="100" placeholder="Ej. Gastritis aguda"></div>
                        <div class="campo-agregar-cita"><label for="analisis_clinicos">Análisis Clínicos</label><input type="text" id="analisis_clinicos" name="analisis_clinicos" maxlength="100" placeholder="Ej. Hemograma completo"></div>
                    </div>
                </section>

                <section class="consulta-paso" data-paso="2" aria-labelledby="titulo-paso-tratamiento" hidden>
                    <div class="consulta-paso-titulo">
                        <span class="consulta-paso-icono"><i class="fas fa-pills" aria-hidden="true"></i></span>
                        <div><p>PASO 3 DE 4</p><h3 id="titulo-paso-tratamiento">Tratamiento prescrito</h3></div>
                    </div>
                    <div class="consulta-campos-grid consulta-campos-una-columna">
                        <div id="listaTratamientosConsulta">
                            <div class="consulta-tratamiento-item" data-tratamiento="1">
                                <h4>Tratamiento 1</h4>
                                <div class="consulta-campos-grid consulta-campos-una-columna">
                                    <div class="campo-agregar-cita"><label for="nombre_medicamento_1">Nombre del Medicamento (*)</label><input type="text" id="nombre_medicamento_1" name="nombre_medicamento[]" maxlength="100" placeholder="Ej. Amoxicilina" required></div>
                                    <div class="campo-agregar-cita"><label for="dosis_1">Dosis (*)</label><input type="text" id="dosis_1" name="dosis[]" maxlength="50" placeholder="Ej. 250 mg" required></div>
                                    <div class="campo-agregar-cita"><label for="frecuencia_administracion_1">Frecuencia de Administración (*)</label><input type="text" id="frecuencia_administracion_1" name="frecuencia_administracion[]" maxlength="100" placeholder="Ej. Cada 8 horas por 7 días" required></div>
                                </div>
                            </div>
                        </div>
                        <button class="consultar-cita-agregar btn" type="button" id="btnAgregarTratamiento"><i class="fas fa-plus-circle" aria-hidden="true"></i> Agregar otro tratamiento</button>
                    </div>
                    <template id="plantillaTratamientoConsulta">
                        <div class="consulta-tratamiento-item" data-tratamiento="__NUMERO__">
                            <h4>Tratamiento __NUMERO__</h4>
                            <div class="consulta-campos-grid consulta-campos-una-columna">
                                <div class="campo-agregar-cita"><label for="nombre_medicamento___NUMERO__">Nombre del Medicamento (*)</label><input type="text" id="nombre_medicamento___NUMERO__" name="nombre_medicamento[]" maxlength="100" placeholder="Ej. Amoxicilina" required></div>
                                <div class="campo-agregar-cita"><label for="dosis___NUMERO__">Dosis (*)</label><input type="text" id="dosis___NUMERO__" name="dosis[]" maxlength="50" placeholder="Ej. 250 mg" required></div>
                                <div class="campo-agregar-cita"><label for="frecuencia_administracion___NUMERO__">Frecuencia de Administración (*)</label><input type="text" id="frecuencia_administracion___NUMERO__" name="frecuencia_administracion[]" maxlength="100" placeholder="Ej. Cada 8 horas por 7 días" required></div>
                            </div>
                        </div>
                    </template>
                </section>

                <section class="consulta-paso" data-paso="3" aria-labelledby="titulo-paso-vigencia" hidden>
                    <div class="consulta-paso-titulo">
                        <span class="consulta-paso-icono"><i class="fas fa-calendar-check" aria-hidden="true"></i></span>
                        <div><p>PASO 4 DE 4</p><h3 id="titulo-paso-vigencia">Vigencia del tratamiento</h3></div>
                    </div>
                    <div class="consulta-campos-grid">
                        <div class="campo-agregar-cita"><label for="fecha_inicial">Fecha Inicial (*)</label><input type="date" id="fecha_inicial" name="fecha_inicial" required></div>
                        <div class="campo-agregar-cita"><label for="fecha_final">Fecha Final (*)</label><input type="date" id="fecha_final" name="fecha_final" required></div>
                    </div>
                    <p class="consulta-ayuda-final"><i class="fas fa-circle-info" aria-hidden="true"></i> Revisa las fechas y guarda para agregar la consulta al historial.</p>
                </section>

                <p class="consulta-error-paso" id="errorPasoConsulta" role="alert" aria-live="polite"></p>
                <div class="modal-agregar-cita-acciones consulta-acciones">
                    <button class="modal-cita-cancelar" type="button" id="btnPasoAnterior" hidden><i class="fas fa-arrow-left" aria-hidden="true"></i> Anterior</button>
                    <button class="modal-cita-cancelar" type="button" id="cancelarRegistroConsulta">Cancelar</button>
                    <button class="consultar-cita-agregar btn" type="button" id="btnPasoSiguiente">Siguiente <i class="fas fa-arrow-right" aria-hidden="true"></i></button>
                    <button class="consultar-cita-agregar btn" type="submit" id="btnGuardarConsulta" hidden><i class="fas fa-plus-circle" aria-hidden="true"></i> Agregar al historial</button>
                </div>
            </form>
        </dialog>
    </main>
</body>
</html>
