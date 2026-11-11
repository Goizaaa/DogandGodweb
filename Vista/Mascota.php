<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mascotas</title>
    <script src="../Controlador/cntrl.js?v=20261110-1" defer></script>
    <script src="../Controlador/cntrolRelacion.js?v=20261110-1" defer></script>
    <script src="../Controlador/mascotaAltaModal.js?v=20261110-1" defer></script>
    <script src="../Controlador/paginacionTablas.js?v=20261013-2" defer></script>
    <link rel="stylesheet" href="../css/CssGlobal.css?v=20261022-1">
</head>
<body class="vista-tablas">
<header>
    <?php include_once("include/header.php") ?>
</header>
    <main class="tabla-pagina-main">
        <section class="tabla-pagina-cabecera">
            <div>
                <p class="tabla-pagina-eyebrow">PACIENTES</p>
                <h1>Mascotas registradas</h1>
                <p>Consulta los datos de los pacientes y accede a sus historiales.</p>
            </div>
            <div class="tabla-pagina-acciones">
                <button class="btn-nuevo" id="abrir-modal-nueva-mascota" type="button">+ Nueva mascota</button>
                <button class="btn-nuevo btn-secundario" id="abrir-modal-relacion" type="button">Enlazar mascota y tutor</button>
            </div>
        </section>
        <div class="tabla-contenedor">
            <table class="tabla-datos" id="tabla">
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
        </div>
    </main>

    <dialog class="tabla-modal" id="modal-agregar-mascota" aria-labelledby="titulo-modal-agregar-mascota">
        <div class="tabla-modal-cabecera">
            <div>
                <p class="tabla-pagina-eyebrow">PACIENTES</p>
                <h2 id="titulo-modal-agregar-mascota">Registrar mascota</h2>
                <p>Ingresa los datos del nuevo paciente. Podrás enlazarlo con un tutor después.</p>
            </div>
            <button class="tabla-modal-cerrar" type="button" data-cerrar-dialog="modal-agregar-mascota" aria-label="Cerrar ventana">&times;</button>
        </div>
        <form class="tabla-modal-form" id="register-pet-form">
            <div class="tabla-modal-campo"><label for="nomMascota">Nombre de la mascota</label><input type="text" name="nom_mascota" id="nomMascota" required></div>
            <div class="tabla-modal-campo"><label for="especie">Especie</label><input type="text" name="especie" id="especie" required></div>
            <div class="tabla-modal-campo"><label for="raza">Raza</label><input type="text" name="raza" id="raza" required></div>
            <div class="tabla-modal-campo"><label for="fecNac">Fecha de nacimiento aproximada</label><input type="date" name="fecha_adopcion" id="fecNac" required></div>
            <div class="tabla-modal-campo"><label for="peso">Peso (kg)</label><input type="number" name="peso_inicial" id="peso" min="0" step="0.01" required></div>
            <div class="tabla-modal-campo"><label for="mascota">Sexo</label><select id="mascota" name="sexo"><option value="Hembra">Hembra</option><option value="Macho">Macho</option></select></div>
            <div class="tabla-modal-campo"><label for="esterilizado">Esterilizado</label><select id="esterilizado" name="esterilizado"><option value="1">Sí</option><option value="0">No</option></select></div>
            <div class="tabla-modal-mensaje" id="mensaje-nueva-mascota" role="status" aria-live="polite"></div>
            <div class="tabla-modal-acciones">
                <button type="submit" id="btn-registrar-mascota">Registrar mascota</button>
                <button class="tabla-modal-secundario" type="button" data-cerrar-dialog="modal-agregar-mascota">Cancelar</button>
            </div>
        </form>
    </dialog>

    <dialog class="tabla-modal" id="modal-relacion-tutor" aria-labelledby="titulo-modal-relacion">
        <div class="tabla-modal-cabecera">
            <div>
                <p class="tabla-pagina-eyebrow">RELACIONES</p>
                <h2 id="titulo-modal-relacion">Enlazar mascota y tutor</h2>
                <p>Selecciona una mascota sin tutor y asígnale una persona responsable.</p>
            </div>
            <button class="tabla-modal-cerrar" id="cerrar-modal-relacion" type="button" aria-label="Cerrar ventana">&times;</button>
        </div>
        <div class="tabla-modal-cuerpo">
            <div class="tabla-modal-campo">
                <label for="selectMascota">Mascota sin tutor</label>
                <select id="selectMascota" required><option value="">Cargando mascotas...</option></select>
            </div>
            <div class="tabla-modal-campo">
                <label for="selectTutor">Tutor</label>
                <select id="selectTutor" required><option value="">Cargando tutores...</option></select>
            </div>
            <div id="mensaje" class="tabla-modal-mensaje" role="status" aria-live="polite"></div>
            <div class="tabla-modal-acciones">
                <button id="btnAsignar" type="button">Enlazar tutor</button>
                <button class="tabla-modal-secundario" id="cancelar-modal-relacion" type="button">Cancelar</button>
            </div>
        </div>
    </dialog>
</body>
</html>
