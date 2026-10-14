<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Consulta | Dog&God</title>
    <link rel="stylesheet" href="../css/CssGlobal.css?v=20261013-4">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="../controlador/cntrolConsulta.js?v=20261013-4" defer></script>
</head>
<body class="vista-consultar-cita">
    <header>
        <?php include_once("include/header.php") ?>
    </header>

    <main class="consultar-cita-main">
        <div class="consultar-cita-titulo">
            <div>
                <p class="consultar-cita-eyebrow">EXPEDIENTE VETERINARIO</p>
                <h1>Registrar Consulta Médica</h1>
            </div>
        </div>

        <section class="formulario-container" style="max-width: 650px; margin: 0 auto; background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <form id="frmAgregarConsulta" class="formulario-agregar-cita">
                <input type="hidden" id="id_cita" name="id_cita" value="">

                <h3>1. Datos de la Consulta</h3>
                <div class="campo-agregar-cita">
                    <label for="fecha">Fecha de Consulta (*):</label>
                    <input type="date" id="fecha" name="fecha" required>
                </div>

                <div class="campo-agregar-cita">
                    <label for="temperatura">Temperatura (°C):</label>
                    <input type="number" step="1" id="temperatura" name="temperatura" placeholder="Ej. 38">
                </div>

                <div class="campo-agregar-cita">
                    <label for="peso_consulta">Peso de Consulta (kg) (*):</label>
                    <input type="number" step="1" id="peso_consulta" name="peso_consulta" placeholder="Ej. 12" required>
                </div>

                <div class="campo-agregar-cita">
                    <label for="frecuencia_card">Frecuencia Cardíaca (ppm):</label>
                    <input type="number" id="frecuencia_card" name="frecuencia_card" placeholder="Ej. 110">
                </div>

                <h3 style="margin-top: 15px;">2. Diagnóstico</h3>
                <div class="campo-agregar-cita">
                    <label for="detalles_diagnosticos">Detalles del Diagnóstico:</label>
                    <input type="text" id="detalles_diagnosticos" name="detalles_diagnosticos" maxlength="100" placeholder="Ej. Gastritis aguda">
                </div>

                <div class="campo-agregar-cita">
                    <label for="analisis_clinicos">Análisis Clínicos:</label>
                    <input type="text" id="analisis_clinicos" name="analisis_clinicos" maxlength="100" placeholder="Ej. Hemograma completo">
                </div>

                <h3 style="margin-top: 15px;">3. Tratamiento Prescrito</h3>
                <div class="campo-agregar-cita">
                    <label for="nombre_medicamento">Nombre del Medicamento (*):</label>
                    <input type="text" id="nombre_medicamento" name="nombre_medicamento" maxlength="100" placeholder="Ej. Amoxicilina" required>
                </div>

                <div class="campo-agregar-cita">
                    <label for="dosis">Dosis (*):</label>
                    <input type="text" id="dosis" name="dosis" maxlength="50" placeholder="Ej. 250 mg" required>
                </div>

                <div class="campo-agregar-cita">
                    <label for="frecuencia_administracion">Frecuencia de Administración (*):</label>
                    <input type="text" id="frecuencia_administracion" name="frecuencia_administracion" maxlength="100" placeholder="Ej. Cada 8 horas por 7 días" required>
                </div>

                <div class="campo-agregar-cita">
                    <label for="fecha_inicial">Fecha Inicial (*):</label>
                    <input type="date" id="fecha_inicial" name="fecha_inicial" required>
                </div>

                <div class="campo-agregar-cita">
                    <label for="fecha_final">Fecha Final (*):</label>
                    <input type="date" id="fecha_final" name="fecha_final" required>
                </div>

                <div class="modal-agregar-cita-acciones" style="margin-top: 25px;">
                    <button class="consultar-cita-agregar btn" type="submit" id="btnGuardarConsulta">
                        <i class="fas fa-plus-circle"></i> Agregar al historial
                    </button>
                    <button class="modal-cita-cancelar" type="button" onclick="window.history.back()">Cancelar</button>
                </div>
            </form>
        </section>
    </main>
</body>
</html>