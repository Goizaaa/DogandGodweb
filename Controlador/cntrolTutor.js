document.addEventListener("DOMContentLoaded", () => {
    // ========== REGISTRAR TUTOR ==========
    const formTutor = document.querySelector("#register-tutor-form");
    
    if (formTutor && formTutor.dataset.flujoModal !== "true") {
        formTutor.addEventListener("submit", (event) => {
            event.preventDefault();

            let errores = [];
            let correo = document.querySelector("#correoTutor").value.trim();
            let nombre = document.querySelector("#nomTutor").value.trim();
            let app = document.querySelector("#appTutor").value.trim();
            let apm = document.querySelector("#apmTutor").value.trim();
            let telefono = document.querySelector("#numtelTutor").value.trim();
            let direccion = document.querySelector("#direccionTutor").value.trim();

            if (correo === "") {
                errores.push("El correo es obligatorio");
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(correo)) {
                errores.push("El formato del correo no es válido");
            }

            if (nombre === "") errores.push("El nombre es obligatorio");
            if (app === "") errores.push("El apellido paterno es obligatorio");
            if (apm === "") errores.push("El apellido materno es obligatorio");
            if (telefono === "") {
                errores.push("El teléfono es obligatorio");
            } else if (!/^\d{10}$/.test(telefono)) {
                errores.push("El teléfono debe tener 10 dígitos");
            }
            if (direccion === "") errores.push("La dirección es obligatoria");

            if (errores.length > 0) {
                Swal.fire({ icon: "error", text: errores.join("\n") });
                return;
            }

            let valores = new FormData(formTutor);
            valores.append("opc", "create");

            fetch("../Controlador/controladorTutor.php", {
                method: "POST",
                body: valores
            })
            .then(response => response.json())
            .then(data => {
                return Swal.fire({
                    icon: data.success ? "success" : "error",
                    text: data.message
                }).then(() => {
                    if (!data.success) return;
                    formTutor.reset();
                    cargarTutores();
                    window.location.href = "consultartutores.html";
                });
            })
            .catch(error => {
                console.error("Error:", error);
                Swal.fire({ icon: "error", text: "Error al registrar tutor" });
            });
        });
    }

    // ========== CONSULTAR TUTORES ==========
    const tablaTutores = document.querySelector("#tablaTutores tbody");
    
    function cargarTutores() {
        if(!tablaTutores) return;
        
        let valores = new FormData();
        valores.append("opc", "listar");
        
        fetch("../Controlador/controladorTutor.php", {
            method: "POST",
            body: valores
        })
        .then(res => res.json())
        .then(datos => {
            tablaTutores.innerHTML = "";
            
            datos.forEach(tutor => {
                let fila = document.createElement("tr");
                
                let celdaCorreo = document.createElement("td");
                celdaCorreo.textContent = tutor.correo_tutor;
                fila.appendChild(celdaCorreo);
                
                let celdaNombre = document.createElement("td");
                celdaNombre.textContent = tutor.nom_tutor;
                fila.appendChild(celdaNombre);
                
                let celdaApp = document.createElement("td");
                celdaApp.textContent = tutor.app_tutor;
                fila.appendChild(celdaApp);
                
                let celdaApm = document.createElement("td");
                celdaApm.textContent = tutor.apm_tutor;
                fila.appendChild(celdaApm);
                
                let celdaTelefono = document.createElement("td");
                celdaTelefono.textContent = tutor.numtel_tutor;
                fila.appendChild(celdaTelefono);
                
                let celdaSexo = document.createElement("td");
                celdaSexo.textContent = tutor.sexo || "No especificado";
                fila.appendChild(celdaSexo);
                
                let celdaDireccion = document.createElement("td");
                celdaDireccion.textContent = tutor.direccion;
                fila.appendChild(celdaDireccion);
                
                let celdaAcciones = document.createElement("td");
                
                let btnEditar = document.createElement("button");
                btnEditar.textContent = "Editar";
                btnEditar.style.border = "none";
                btnEditar.style.padding = "5px 10px";
                btnEditar.style.borderRadius = "4px";
                btnEditar.style.marginRight = "5px";
                btnEditar.onclick = function() {
                    editarTutor(tutor);
                };
                
                let btnEliminar = document.createElement("button");
                btnEliminar.textContent = "Eliminar";
                btnEliminar.style.border = "none";
                btnEliminar.style.padding = "5px 10px";
                btnEliminar.style.borderRadius = "4px";
                btnEliminar.onclick = function() {
                    eliminarTutor(tutor.correo_tutor, tutor.nom_tutor);
                };
                
                celdaAcciones.appendChild(btnEditar);
                celdaAcciones.appendChild(btnEliminar);
                fila.appendChild(celdaAcciones);
                
                tablaTutores.appendChild(fila);
            });
        })
        .catch(error => console.error("Error al cargar tutores:", error));
    }

    window.recargarTablaTutores = cargarTutores;
    
    // ========== EDITAR TUTOR ==========
    async function editarTutor(tutor) {
        const correo = await Swal.fire({
            title: "Nuevo correo electrónico",
            input: "email",
            inputValue: tutor.correo_tutor,
            showCancelButton: true,
            confirmButtonText: "Continuar",
            cancelButtonText: "Cancelar",
            inputValidator: value => !value || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value.trim())
                ? "Ingresa un correo válido."
                : undefined
        });
        if (!correo.isConfirmed) return;

        const telefono = await Swal.fire({
            title: "Nuevo teléfono",
            input: "tel",
            inputValue: tutor.numtel_tutor,
            showCancelButton: true,
            confirmButtonText: "Continuar",
            cancelButtonText: "Cancelar",
            inputValidator: value => !/^\d{10}$/.test(value.trim())
                ? "El teléfono debe tener 10 dígitos."
                : undefined
        });
        if (!telefono.isConfirmed) return;

        const direccion = await Swal.fire({
            title: "Nueva dirección",
            input: "text",
            inputValue: tutor.direccion,
            showCancelButton: true,
            confirmButtonText: "Guardar",
            cancelButtonText: "Cancelar",
            inputValidator: value => !value.trim()
                ? "La dirección no puede estar vacía."
                : undefined
        });
        if (!direccion.isConfirmed) return;
        
        let valores = new FormData();
        valores.append("opc", "update");
        valores.append("correo_original", tutor.correo_tutor);
        valores.append("correo_tutor", correo.value.trim());
        valores.append("numtel_tutor", telefono.value.trim());
        valores.append("direccion", direccion.value.trim());
        
        fetch("../Controlador/controladorTutor.php", {
            method: "POST",
            body: valores
        })
        .then(res => res.json())
        .then(data => {
            Swal.fire({
                icon: data.success ? "success" : "error",
                text: data.message
            });
            if (data.success) {
                cargarTutores();
            }
        })
        .catch(error => {
            console.error("Error:", error);
            Swal.fire({ icon: "error", text: "Error al actualizar tutor" });
        });
    }
    
    // ========== ELIMINAR TUTOR ==========
    async function eliminarTutor(correo, nombre) {
        const confirmacion = await Swal.fire({
            icon: "warning",
            text: `¿Estás seguro de eliminar al tutor "${nombre}" con correo ${correo}?`,
            showCancelButton: true,
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "Cancelar"
        });
        if (!confirmacion.isConfirmed) return;

        let valores = new FormData();
        valores.append("opc", "delete");
        valores.append("correo_tutor", correo);

        fetch("../Controlador/controladorTutor.php", {
            method: "POST",
            body: valores
        })
        .then(res => res.json())
        .then(data => {
            Swal.fire({
                icon: data.success ? "success" : "error",
                text: data.message
            });
            if (data.success) {
                cargarTutores();
            }
        })
        .catch(error => {
            console.error("Error:", error);
            Swal.fire({ icon: "error", text: "Error al eliminar tutor" });
        });
    }
    
    // Cargar tutores al iniciar
    cargarTutores();
});
