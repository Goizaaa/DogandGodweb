document.addEventListener("DOMContentLoaded", () => {
    const formMascota = document.getElementById("register-pet-form");
    const modalMascota = document.getElementById("modal-agregar-mascota");
    const mensaje = document.getElementById("mensaje-nueva-mascota");
    const botonRegistrar = document.getElementById("btn-registrar-mascota");

    const cerrar = modal => {
        if (modal && modal.open) modal.close();
    };

    document.getElementById("abrir-modal-nueva-mascota")?.addEventListener("click", () => {
        formMascota.reset();
        mensaje.textContent = "";
        mensaje.classList.remove("es-exito", "es-error");
        modalMascota.showModal();
    });

    document.querySelectorAll('[data-cerrar-dialog="modal-agregar-mascota"]').forEach(boton => {
        boton.addEventListener("click", () => cerrar(modalMascota));
    });

    formMascota.addEventListener("submit", async evento => {
        evento.preventDefault();
        if (!formMascota.reportValidity()) return;

        botonRegistrar.disabled = true;
        mensaje.textContent = "Registrando mascota…";
        mensaje.classList.add("es-exito");
        mensaje.classList.remove("es-error");
        const valores = new FormData(formMascota);
        valores.append("opc", "create");

        try {
            const respuesta = await fetch("../Controlador/cntrlUsuarios.php", { method: "POST", body: valores });
            const datos = await respuesta.json();
            if (!respuesta.ok || !datos.success) throw new Error(datos.message || "No se pudo registrar la mascota.");

            formMascota.reset();
            mensaje.textContent = datos.message || "Mascota registrada correctamente.";
            mensaje.classList.add("es-exito");
            if (typeof window.recargarTablaMascotas === "function") window.recargarTablaMascotas();
        } catch (error) {
            mensaje.textContent = error.message || "Ocurrió un error al registrar la mascota.";
            mensaje.classList.add("es-error");
            mensaje.classList.remove("es-exito");
        } finally {
            botonRegistrar.disabled = false;
        }
    });
});
