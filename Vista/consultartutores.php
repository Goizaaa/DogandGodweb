<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Consultar Tutores</title>
    <script src="../Controlador/cntrolTutor.js?v=20261021-1" defer></script>
    <script src="../Controlador/cntrolRelacion.js?v=20261021-1" defer></script>
    <script src="../Controlador/tutorAltaModal.js?v=20261021-1" defer></script>
    <script src="../Controlador/paginacionTablas.js?v=20261013-2" defer></script>
    <link rel="stylesheet" href="../css/CssGlobal.css?v=20261022-1">
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
                <button class="btn-nuevo" id="abrir-modal-nuevo-tutor" type="button">+ Nuevo tutor</button>
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

    <dialog class="tabla-modal" id="modal-nuevo-tutor" aria-labelledby="titulo-modal-nuevo-tutor">
        <div class="tabla-modal-cabecera">
            <div>
                <p class="tabla-pagina-eyebrow">DIRECTORIO</p>
                <h2 id="titulo-modal-nuevo-tutor">Registrar tutor</h2>
                <p>Ingresa los datos de la persona responsable.</p>
            </div>
            <button class="tabla-modal-cerrar" type="button" data-cerrar-dialog="modal-nuevo-tutor" aria-label="Cerrar ventana">&times;</button>
        </div>
        <form class="tabla-modal-form" id="register-tutor-form" data-flujo-modal="true">
            <div class="tabla-modal-campo"><label for="correoTutor">Correo electrónico</label><input type="email" name="correo_tutor" id="correoTutor" required></div>
            <div class="tabla-modal-campo"><label for="nomTutor">Nombre del tutor</label><input type="text" name="nom_tutor" id="nomTutor" required></div>
            <div class="tabla-modal-campo"><label for="appTutor">Apellido paterno</label><input type="text" name="app_tutor" id="appTutor" required></div>
            <div class="tabla-modal-campo"><label for="apmTutor">Apellido materno</label><input type="text" name="apm_tutor" id="apmTutor" required></div>
            <div class="tabla-modal-campo"><label for="numtelTutor">Teléfono</label><input type="tel" name="numtel_tutor" id="numtelTutor" inputmode="numeric" pattern="[0-9]{10}" maxlength="10" required></div>
            <div class="tabla-modal-campo"><label for="sexoTutor">Sexo</label><select id="sexoTutor" name="sexo"><option value="Masculino">Masculino</option><option value="Femenino">Femenino</option><option value="Otro">Otro</option></select></div>
            <div class="tabla-modal-campo"><label for="direccionTutor">Dirección</label><input type="text" name="direccion" id="direccionTutor" required></div>
            <div class="tabla-modal-mensaje" id="mensaje-nuevo-tutor" role="status" aria-live="polite"></div>
            <div class="tabla-modal-acciones">
                <button type="submit" id="btn-registrar-tutor">Registrar tutor</button>
                <button class="tabla-modal-secundario" type="button" data-cerrar-dialog="modal-nuevo-tutor">Cancelar</button>
            </div>
        </form>
    </dialog>

    <dialog class="tabla-modal" id="modal-opciones-tutor" aria-labelledby="titulo-modal-opciones-tutor">
        <div class="tabla-modal-cabecera">
            <div><p class="tabla-pagina-eyebrow">TUTOR REGISTRADO</p><h2 id="titulo-modal-opciones-tutor">¿Qué deseas hacer?</h2><p id="resumen-tutor-registrado"></p></div>
        </div>
        <div class="tabla-modal-cuerpo">
            <div class="tabla-modal-acciones tabla-modal-acciones-apiladas">
                <button type="button" id="relacionar-mascota-tutor">Relacionar mascota</button>
                <button type="button" id="agregar-mascota-tutor">Agregar mascota</button>
                <button class="tabla-modal-secundario" type="button" id="finalizar-registro-tutor">Finalizar</button>
            </div>
        </div>
    </dialog>

    <dialog class="tabla-modal" id="modal-agregar-mascota" aria-labelledby="titulo-modal-agregar-mascota">
        <div class="tabla-modal-cabecera">
            <div><p class="tabla-pagina-eyebrow">PACIENTES</p><h2 id="titulo-modal-agregar-mascota">Registrar mascota</h2><p id="tutor-mascota-actual"></p></div>
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
            <input type="hidden" name="correo_tutor" id="correo-tutor-mascota">
            <div class="tabla-modal-mensaje" id="mensaje-nueva-mascota" role="status" aria-live="polite"></div>
            <div class="tabla-modal-acciones">
                <button type="submit" id="btn-registrar-mascota">Registrar mascota</button>
                <button class="tabla-modal-secundario" type="button" data-cerrar-dialog="modal-agregar-mascota">Cancelar</button>
            </div>
        </form>
    </dialog>

    <dialog class="tabla-modal" id="modal-otra-mascota" aria-labelledby="titulo-modal-otra-mascota">
        <div class="tabla-modal-cabecera"><div><p class="tabla-pagina-eyebrow">MASCOTA REGISTRADA</p><h2 id="titulo-modal-otra-mascota">¿Deseas agregar otra mascota?</h2></div></div>
        <div class="tabla-modal-cuerpo"><div class="tabla-modal-acciones">
            <button type="button" id="agregar-otra-mascota">Agregar otra mascota</button>
            <button class="tabla-modal-secundario" type="button" id="finalizar-mascotas">Finalizar</button>
        </div></div>
    </dialog>

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
