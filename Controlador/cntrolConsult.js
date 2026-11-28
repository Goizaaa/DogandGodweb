document.addEventListener("DOMContentLoaded", () => {
    const frmConsulta = document.getElementById("frmAgregarConsulta");
    const modal = document.getElementById("modalRegistroConsulta");

    if (!frmConsulta || !modal) return;

    const idMascota = frmConsulta.elements.id_mascota.value.trim();
    const pasos = Array.from(frmConsulta.querySelectorAll(".consulta-paso"));
    const indicadores = Array.from(modal.querySelectorAll("[data-indicador]"));
    const btnAnterior = document.getElementById("btnPasoAnterior");
    const btnSiguiente = document.getElementById("btnPasoSiguiente");
    const btnGuardar = document.getElementById("btnGuardarConsulta");
    const btnAgregarTratamiento = document.getElementById("btnAgregarTratamiento");
    const listaTratamientos = document.getElementById("listaTratamientosConsulta");
    const plantillaTratamiento = document.getElementById("plantillaTratamientoConsulta");
    const errorPaso = document.getElementById("errorPasoConsulta");
    let pasoActual = 0;

    btnAgregarTratamiento?.addEventListener("click", () => {
        if (!listaTratamientos || !plantillaTratamiento) return;
        const numero = listaTratamientos.querySelectorAll("[data-tratamiento]").length + 1;
        const bloque = document.createElement("div");
        bloque.innerHTML = plantillaTratamiento.innerHTML.replaceAll("__NUMERO__", String(numero));
        const nuevoTratamiento = bloque.firstElementChild;
        if (!nuevoTratamiento) return;
        listaTratamientos.appendChild(nuevoTratamiento);
        nuevoTratamiento.querySelector("input")?.focus();
    });

    const mostrarError = mensaje => {
        errorPaso.textContent = mensaje;
    };

    const mostrarPaso = (indice, direccion = 1) => {
        pasoActual = indice;
        pasos.forEach((paso, i) => {
            paso.hidden = i !== indice;
            paso.classList.toggle("activo", i === indice);
            if (i === indice) {
                paso.classList.remove("entra-desde-izquierda", "entra-desde-derecha");
                paso.classList.add(direccion > 0 ? "entra-desde-derecha" : "entra-desde-izquierda");
            }
        });
        indicadores.forEach((indicador, i) => {
            indicador.classList.toggle("activo", i === indice);
            indicador.classList.toggle("completado", i < indice);
            if (i === indice) indicador.setAttribute("aria-current", "step");
            else indicador.removeAttribute("aria-current");
        });
        btnAnterior.hidden = indice === 0;
        btnSiguiente.hidden = indice === pasos.length - 1;
        btnGuardar.hidden = indice !== pasos.length - 1;
        mostrarError("");
        const primerCampo = pasos[indice].querySelector("input, select, textarea");
        primerCampo?.focus({ preventScroll: true });
    };

    const validarPaso = () => {
        const campos = Array.from(pasos[pasoActual].querySelectorAll("input, select, textarea"));
        const invalido = campos.find(campo => !campo.checkValidity());
        if (invalido) {
            mostrarError("Completa el campo obligatorio para continuar.");
            invalido.reportValidity();
            invalido.focus();
            return false;
        }
        return true;
    };

    btnSiguiente.addEventListener("click", () => {
        if (validarPaso()) mostrarPaso(pasoActual + 1, 1);
    });

    btnAnterior.addEventListener("click", () => mostrarPaso(pasoActual - 1, -1));

    const regresarAlHistorial = () => {
        window.location.href = "consultarhis.php?id_mascota=" + encodeURIComponent(idMascota);
    };
    document.getElementById("cerrarRegistroConsulta")?.addEventListener("click", regresarAlHistorial);
    document.getElementById("cancelarRegistroConsulta")?.addEventListener("click", regresarAlHistorial);

    frmConsulta.addEventListener("submit", async evento => {
        evento.preventDefault();
        if (!validarPaso()) return;

        const fechaInicial = document.getElementById("fecha_inicial");
        const fechaFinal = document.getElementById("fecha_final");
        if (fechaInicial.value && fechaFinal.value && fechaFinal.value < fechaInicial.value) {
            mostrarError("La fecha final debe ser igual o posterior a la fecha inicial.");
            fechaFinal.focus();
            return;
        }

        btnGuardar.disabled = true;
        btnGuardar.innerHTML = '<i class="fas fa-spinner fa-spin" aria-hidden="true"></i> Guardando…';
        const formData = new FormData(frmConsulta);
        formData.append("accion", "guardar_consulta");

        try {
            const response = await fetch("../Controlador/ConsultaControlador.php", {
                method: "POST",
                body: formData
            });
            const res = await response.json();

            if (res.status === "success") {
                Swal.fire({ icon: "success", text: "Consulta, diagnóstico y tratamiento agregados con éxito." })
                    .then(() => {
                        regresarAlHistorial();
                    });
            } else {
                mostrarError(res.message || "No se pudo completar el registro.");
                btnGuardar.disabled = false;
                btnGuardar.innerHTML = '<i class="fas fa-plus-circle" aria-hidden="true"></i> Agregar al historial';
            }
        } catch (error) {
            console.error("Error al guardar:", error);
            mostrarError("Error de conexión al procesar el registro.");
            btnGuardar.disabled = false;
            btnGuardar.innerHTML = '<i class="fas fa-plus-circle" aria-hidden="true"></i> Agregar al historial';
        }
    });

    mostrarPaso(0, 1);
    modal.showModal();
});
