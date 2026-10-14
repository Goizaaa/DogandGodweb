<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Consultar Tutores</title>
    <script src="../Controlador/cntrolTutor.js" defer></script>
    <script src="../Controlador/cntrolRelacion.js?v=20261014-1" defer></script>
    <script src="../Controlador/paginacionTablas.js?v=20261013-1" defer></script>
    <link rel="stylesheet" href="../css/CssGlobal.css?v=20261014-3">
</head>
<body class="vista-tablas">

<header>
    
        <!--encabezado-->
        <?php include_once("include/header.php") ?>
        <!--fin encabezado-->

    </header>

    <main class="tabla-pagina-main">
        <section class="tabla-pagina-cabecera">
            <div>
                <p class="tabla-pagina-eyebrow">DIRECTORIO</p>
                <h1>Lista de tutores</h1>
                <p>Consulta y administra la información de los tutores registrados.</p>
            </div>
            <div class="tabla-pagina-acciones">
                <a class="btn-nuevo" href="registrartutor.php">+ Nuevo tutor</a>
                <button class="btn-nuevo btn-secundario" id="abrir-modal-relacion" type="button">Relacionar mascota con tutor</button>
            </div>
        </section>
        <div class="tabla-contenedor">
            <table class="tabla-datos" id="tablaTutores">
                    <thead>
                        <tr>
                            <th>Correo</th>
                            <th>Nombre</th>
                            <th>Apellido Paterno</th>
                            <th>Apellido Materno</th>
                            <th>Teléfono</th>
                            <th>Sexo</th>
                            <th>Dirección</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="cuerpo-tabla">
                    </tbody>
            </table>
        </div>
    </main>

    <dialog class="tabla-modal" id="modal-relacion-tutor" aria-labelledby="titulo-modal-relacion">
        <div class="tabla-modal-cabecera">
            <div>
                <p class="tabla-pagina-eyebrow">RELACIONES</p>
                <h2 id="titulo-modal-relacion">Relacionar mascota con tutor</h2>
                <p>Selecciona una mascota sin tutor y asígnale una persona responsable.</p>
            </div>
            <button class="tabla-modal-cerrar" id="cerrar-modal-relacion" type="button" aria-label="Cerrar ventana">&times;</button>
        </div>
        <div class="tabla-modal-cuerpo">
            <div class="tabla-modal-campo">
                <label for="selectMascota">Mascota sin tutor</label>
                <select id="selectMascota" required>
                    <option value="">Cargando mascotas...</option>
                </select>
            </div>
            <div class="tabla-modal-campo">
                <label for="selectTutor">Tutor</label>
                <select id="selectTutor" required>
                    <option value="">Cargando tutores...</option>
                </select>
            </div>
            <div id="mensaje" class="tabla-modal-mensaje" role="status" aria-live="polite"></div>
            <div class="tabla-modal-acciones">
                <button id="btnAsignar" type="button">Asignar tutor</button>
                <button class="tabla-modal-secundario" id="cancelar-modal-relacion" type="button">Cerrar</button>
            </div>
        </div>
    </dialog>
</body>
</html>
