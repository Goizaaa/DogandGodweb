document.addEventListener("DOMContentLoaded", () => {
    const formTutor = document.getElementById("register-tutor-form");
    const formMascota = document.getElementById("register-pet-form");
    const modalTutor = document.getElementById("modal-nuevo-tutor");
    const modalOpciones = document.getElementById("modal-opciones-tutor");
    const modalMascota = document.getElementById("modal-agregar-mascota");
    const modalOtraMascota = document.getElementById("modal-otra-mascota");
    const modalRelacion = document.getElementById("modal-relacion-tutor");
    const mensajeTutor = document.getElementById("mensaje-nuevo-tutor");
    const mensajeMascota = document.getElementById("mensaje-nueva-mascota");
    const btnRegistrarTutor = document.getElementById("btn-registrar-tutor");
    const btnRegistrarMascota = document.getElementById("btn-registrar-mascota");
    const correoTutorMascota = document.getElementById("correo-tutor-mascota");
    const resumenTutor = document.getElementById("resumen-tutor-registrado");
    const textoTutorMascota = document.getElementById("tutor-mascota-actual");

    let tutorActual = null;
    let volverAOpcionesTrasRelacion = false;

    const abrir = modal => {
        if (modal && !modal.open) modal.showModal();
    };
    const cerrar = modal => {
        if (modal && modal.open) modal.close();
    };
    const mostrarMensaje = (elemento, texto, exito = false) => {
        elemento.textContent = texto;
        elemento.classList.toggle("es-exito", exito);
        elemento.classList.toggle("es-error", !exito);
    };
    const actualizarTabla = () => {
        if (typeof window.recargarTablaTutores === "function") window.recargarTablaTutores();
    };

    document.getElementById("abrir-modal-nuevo-tutor")?.addEventListener("click", () => {
        formTutor.reset();
        mensajeTutor.textContent = "";
        abrir(modalTutor);
    });

    document.querySelectorAll("[data-cerrar-dialog]").forEach(boton => {
        boton.addEventListener("click", () => cerrar(document.getElementById(boton.dataset.cerrarDialog)));
    });

    formTutor?.addEventListener("submit", async evento => {
        evento.preventDefault();
        if (!formTutor.reportValidity()) return;

        btnRegistrarTutor.disabled = true;
        mostrarMensaje(mensajeTutor, "Registrando tutor…", true);
        const valores = new FormData(formTutor);
        valores.append("opc", "create");

        try {
            const respuesta = await fetch("../Controlador/controladorTutor.php", { method: "POST", body: valores });
            const datos = await respuesta.json();
            if (!respuesta.ok || !datos.success) throw new Error(datos.message || "No se pudo registrar el tutor.");

            tutorActual = {
                correo: valores.get("correo_tutor"),
                nombre: `${valores.get("nom_tutor")} ${valores.get("app_tutor")} ${valores.get("apm_tutor")}`.trim()
            };
            formTutor.reset();
            actualizarTabla();
            resumenTutor.textContent = `${tutorActual.nombre} (${tutorActual.correo})`;
            cerrar(modalTutor);
            abrir(modalOpciones);
        } catch (error) {
            mostrarMensaje(mensajeTutor, error.message || "Ocurrió un error al registrar el tutor.");
        } finally {
            btnRegistrarTutor.disabled = false;
        }
    });

    document.getElementById("relacionar-mascota-tutor")?.addEventListener("click", () => {
        if (!tutorActual) return;
        volverAOpcionesTrasRelacion = true;
        cerrar(modalOpciones);
        if (typeof window.abrirModalRelacionTutor === "function") {
            window.abrirModalRelacionTutor(tutorActual.correo);
        } else {
            volverAOpcionesTrasRelacion = false;
            abrir(modalOpciones);
        }
    });

    modalRelacion?.addEventListener("close", () => {
        if (volverAOpcionesTrasRelacion && tutorActual) {
            volverAOpcionesTrasRelacion = false;
            abrir(modalOpciones);
        }
    });

    const abrirRegistroMascota = () => {
        if (!tutorActual) return;
        formMascota.reset();
        mensajeMascota.textContent = "";
        correoTutorMascota.value = tutorActual.correo;
        textoTutorMascota.textContent = `Se relacionará automáticamente con ${tutorActual.nombre}.`;
        abrir(modalMascota);
    };

    document.getElementById("agregar-mascota-tutor")?.addEventListener("click", () => {
        cerrar(modalOpciones);
        abrirRegistroMascota();
    });

    formMascota?.addEventListener("submit", async evento => {
        evento.preventDefault();
        if (!tutorActual || !formMascota.reportValidity()) return;

        btnRegistrarMascota.disabled = true;
        mostrarMensaje(mensajeMascota, "Registrando y relacionando mascota…", true);
        const valores = new FormData(formMascota);
        valores.set("correo_tutor", tutorActual.correo);
        valores.append("opc", "create");

        try {
            const respuesta = await fetch("../Controlador/cntrlUsuarios.php", { method: "POST", body: valores });
            const datos = await respuesta.json();
            if (!respuesta.ok || !datos.success) throw new Error(datos.message || "No se pudo registrar la mascota.");

            formMascota.reset();
            correoTutorMascota.value = tutorActual.correo;
            cerrar(modalMascota);
            actualizarTabla();
            abrir(modalOtraMascota);
        } catch (error) {
            mostrarMensaje(mensajeMascota, error.message || "Ocurrió un error al registrar la mascota.");
        } finally {
            btnRegistrarMascota.disabled = false;
        }
    });

    document.getElementById("agregar-otra-mascota")?.addEventListener("click", () => {
        cerrar(modalOtraMascota);
        abrirRegistroMascota();
    });

    const finalizarFlujo = modal => {
        cerrar(modal);
        tutorActual = null;
        volverAOpcionesTrasRelacion = false;
        actualizarTabla();
    };
    document.getElementById("finalizar-mascotas")?.addEventListener("click", () => finalizarFlujo(modalOtraMascota));
    document.getElementById("finalizar-registro-tutor")?.addEventListener("click", () => finalizarFlujo(modalOpciones));
});
