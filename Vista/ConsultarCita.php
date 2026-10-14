<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar citas | Dog&God</title>
    <link rel="stylesheet" href="../css/CssGlobal.css?v=20261013-4">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="../Controlador/cntrolCita.js?v=20261013-4" defer></script>
</head>
<body class="vista-consultar-cita">
    <header>
    <?php include_once("include/header.php") ?>
</header>

    <main class="consultar-cita-main">
        <div class="consultar-cita-titulo">
            <div><p class="consultar-cita-eyebrow">AGENDA VETERINARIA</p><h1>Consultar citas</h1></div>
            <button class="consultar-cita-agregar btn" id="abrir-modal-cita" type="button"><i class="fas fa-plus" aria-hidden="true"></i> Agregar cita</button>
        </div>

        <div class="calendario-layout">
            <section class="calendar-container" aria-label="Calendario de citas">
                <div class="calendar-header">
                    <div class="nav-buttons">
                        <button class="nav-btn" id="prev-month" type="button" aria-label="Mes anterior"><i class="fas fa-chevron-left" aria-hidden="true"></i></button>
                        <button class="nav-btn" id="next-month" type="button" aria-label="Mes siguiente"><i class="fas fa-chevron-right" aria-hidden="true"></i></button>
                    </div>
                    <div class="month-year" id="month-year" aria-live="polite"></div>
                </div>
                <div class="weekdays" aria-hidden="true">
                    <div class="weekday">Dom</div><div class="weekday">Lun</div><div class="weekday">Mar</div>
                    <div class="weekday">Mié</div><div class="weekday">Jue</div><div class="weekday">Vie</div><div class="weekday">Sáb</div>
                </div>
                <div class="days" id="days" aria-label="Días del mes"></div>
                <div class="calendar-footer">
                    <button class="today-btn" id="today-btn" type="button"><i class="fas fa-calendar-day" aria-hidden="true"></i> Hoy</button>
                    <div class="event-indicator"><i class="fas fa-circle" aria-hidden="true"></i><span>Fecha con citas</span></div>
                </div>
            </section>

            <section class="event-panel" id="event-panel" aria-label="Citas del día seleccionado">
                <div class="event-header">
                    <div class="event-date" id="event-date">Selecciona una fecha</div>
                    <i class="fas fa-calendar-alt event-icon" aria-hidden="true"></i>
                </div>
                <div class="event-list" id="event-list" aria-live="polite">
                    <div class="no-events">Selecciona un día para ver las citas agendadas.</div>
                </div>
            </section>
        </div>

        <dialog class="modal-agregar-cita" id="modal-agregar-cita" aria-labelledby="titulo-modal-cita">
            <div class="modal-agregar-cita-heading">
                <div><p class="consultar-cita-eyebrow">AGENDA VETERINARIA</p><h2 id="titulo-modal-cita">Agregar nueva cita</h2></div>
                <button class="modal-cita-cerrar" id="cerrar-modal-cita" type="button" aria-label="Cerrar ventana">&times;</button>
            </div>
            <form id="frmAgregarCita" class="formulario-agregar-cita">
                <div class="campo-agregar-cita">
                    <label for="fecha">Fecha:</label>
                    <input type="date" id="fecha" name="fecha" required>
                </div>
                <div class="campo-agregar-cita">
                    <label for="hora">Hora:</label>
                    <select class="selector-horario-cita" id="hora" name="hora" required>
                        <option value="">Selecciona un horario</option>
                    </select>
                    <small class="horario-ayuda">Atención de 09:00 a 15:40, con turnos cada 40 minutos.</small>
                </div>
                <div class="campo-agregar-cita">
                    <label for="procedimiento">Procedimiento / Servicio:</label>
                    <select id="procedimiento" name="procedimiento" required>
                        <option value="Consulta Médica">Consulta Médica</option>
                        <option value="Estética">Estética</option>
                        <option value="Revisión">Revisión</option>
                        <option value="Vacunación">Vacunación</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>
                <div class="campo-agregar-cita">
                    <label for="correo_tutor">Correo del Tutor:</label>
                    <input type="email" id="correo_tutor" name="correo_tutor" placeholder="ejemplo@tutor.com" required>
                </div>
                <div class="campo-agregar-cita">
                    <label for="correo_veterinario">Correo del Veterinario:</label>
                    <input type="email" id="correo_veterinario" name="correo_veterinario" placeholder="ejemplo@vet.com" required>
                </div>
                <div class="modal-agregar-cita-acciones">
                    <button class="consultar-cita-agregar btn" type="submit" id="btnGuardarCita">Agendar cita</button>
                    <button class="modal-cita-cancelar" id="cancelar-modal-cita" type="button">Cerrar</button>
                </div>
            </form>
        </dialog>
    </main>
</body>
</html>
