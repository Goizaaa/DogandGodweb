document.addEventListener('DOMContentLoaded', function() {
    const selectMascota = document.getElementById('selectMascota');
    const selectTutor = document.getElementById('selectTutor');
    const btnAsignar = document.getElementById('btnAsignar');
    const mensaje = document.getElementById('mensaje');
    const modalRelacion = document.getElementById('modal-relacion-tutor');
    const abrirModal = document.getElementById('abrir-modal-relacion');
    const cerrarModal = document.getElementById('cerrar-modal-relacion');
    const cancelarModal = document.getElementById('cancelar-modal-relacion');

    function mostrarMensaje(texto, exito) {
        if (!mensaje) return;
        mensaje.textContent = texto;
        mensaje.classList.toggle('es-exito', Boolean(exito));
        mensaje.classList.toggle('es-error', !exito);
    }

    function cargarMascotasSinTutor() {
        let valores = new FormData();
        valores.append("opc", "listarMascotasSinTutor");

        fetch("../Controlador/controladorRelacion.php", {
            method: "POST",
            body: valores
        })
        .then(res => res.json())
        .then(data => {
            selectMascota.innerHTML = '<option value="">Seleccione una mascota</option>';
            (Array.isArray(data) ? data : []).forEach(m => {
                let option = document.createElement('option');
                option.value = m.id_mascota;
                option.textContent = `${m.id_mascota} - ${m.nom_mascota}`;
                selectMascota.appendChild(option);
            });
            if (selectMascota.options.length === 1) {
                selectMascota.options[0].textContent = 'No hay mascotas pendientes de asignación';
            }
        })
        .catch(() => {
            selectMascota.innerHTML = '<option value="">No se pudieron cargar las mascotas</option>';
        });
    }

    function cargarTutores() {
        let valores = new FormData();
        valores.append("opc", "listarTodosTutores");

        fetch("../Controlador/controladorRelacion.php", {
            method: "POST",
            body: valores
        })
        .then(res => res.json())
        .then(data => {
            selectTutor.innerHTML = '<option value="">Seleccione un tutor</option>';
            (Array.isArray(data) ? data : []).forEach(t => {
                let option = document.createElement('option');
                option.value = t.correo_tutor;
                option.textContent = `${t.nom_tutor} ${t.app_tutor} (${t.correo_tutor})`;
                selectTutor.appendChild(option);
            });
            if (selectTutor.options.length === 1) {
                selectTutor.options[0].textContent = 'No hay tutores registrados';
            }
        })
        .catch(() => {
            selectTutor.innerHTML = '<option value="">No se pudieron cargar los tutores</option>';
        });
    }

    if (btnAsignar) {
        btnAsignar.addEventListener('click', () => {
            const idMascota = selectMascota.value;
            const correoTutor = selectTutor.value;

            if (!idMascota || !correoTutor) {
                mostrarMensaje("Selecciona una mascota y un tutor para continuar.", false);
                return;
            }

            btnAsignar.disabled = true;
            mostrarMensaje("Asignando tutor...", true);

            let valores = new FormData();
            valores.append("opc", "asignarTutor");
            valores.append("id_mascota", idMascota);
            valores.append("correo_tutor", correoTutor);

            fetch("../Controlador/controladorRelacion.php", {
                method: "POST",
                body: valores
            })
            .then(res => res.json())
            .then(data => {
                mostrarMensaje(data.message || (data.success ? "Tutor asignado correctamente." : "No se pudo asignar el tutor."), data.success);
                if (data.success) {
                    cargarMascotasSinTutor();
                    selectTutor.value = "";
                }
            })
            .catch(() => mostrarMensaje("Ocurrió un error al asignar el tutor. Intenta de nuevo.", false))
            .finally(() => { btnAsignar.disabled = false; });
        });
    }

    if (abrirModal && modalRelacion) abrirModal.addEventListener('click', () => modalRelacion.showModal());
    [cerrarModal, cancelarModal].forEach(boton => {
        if (boton && modalRelacion) boton.addEventListener('click', () => modalRelacion.close());
    });
    if (modalRelacion) modalRelacion.addEventListener('click', evento => {
        if (evento.target === modalRelacion) modalRelacion.close();
    });

    cargarMascotasSinTutor();
    cargarTutores();
});
