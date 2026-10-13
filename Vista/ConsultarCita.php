<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar citas | Dog&God</title>
    <link rel="stylesheet" href="../css/CssGlobal.css?v=20261012-4">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="../Controlador/cntrolCita.js?v=20261012-4" defer></script>
</head>
<body class="vista-consultar-cita">
    <header>
    <?php include_once("include/header.php") ?>
</header>

    <main class="consultar-cita-main">
        <div class="consultar-cita-titulo">
            <div><p class="consultar-cita-eyebrow">AGENDA VETERINARIA</p><h1>Consultar citas</h1></div>
            <a class="consultar-cita-agregar btn" href="AgregarCita.php"><i class="fas fa-plus" aria-hidden="true"></i> Agregar cita</a>
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

        <section class="citas-registradas" aria-labelledby="titulo-citas-registradas">
            <div class="citas-registradas-heading">
                <div><p class="consultar-cita-eyebrow">ADMINISTRACIÓN</p><h2 id="titulo-citas-registradas">Todas las citas</h2></div>
            </div>
            <div class="tabla-citas-contenedor">
                <table class="table table-hover" id="tablaCitas">
                    <thead><tr><th>ID cita</th><th>Fecha</th><th>Hora</th><th>Procedimiento</th><th>Correo tutor</th><th>Correo veterinario</th><th>Acciones</th></tr></thead>
                    <tbody></tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>





