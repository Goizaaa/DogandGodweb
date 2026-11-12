document.addEventListener('DOMContentLoaded', function() {
    const tbody = document.getElementById('cuerpo-tabla');
    let filaSeleccionada = null;
    let usuarioSeleccionadoId = null;

    function cargarUsuarios() {
        fetch("../Modelo/modeloUsuario.php")   
            .then(response => response.json())
            .then(usuarios => {
                tbody.innerHTML = '';
                usuarios.forEach(usuario => {
                    const fila = document.createElement('tr');
                    fila.innerHTML = `
                        <td>${usuario.id_usuario}</td>
                        <td>${usuario.nombre || ""}</td>
                        <td>${usuario.apellido_paterno || ""}</td>
                        <td>${usuario.apellido_materno || ""}</td>
                        <td>${usuario.correo || ""}</td>
                        <td>${usuario.password || ""}</td>
                        <td>
                            <button class="editar" data-id="${usuario.id_usuario}">Editar</button>
                            <button class="eliminar" data-id="${usuario.id_usuario}">Eliminar</button>
                        </td>
                    `;
                     // Evento click para seleccionar fila
                    fila.addEventListener('click', function() {
                        // Remover selección anterior
                        if (filaSeleccionada) {
                            filaSeleccionada.classList.remove('seleccionado');
                        }
                        // Seleccionar nueva fila
                        fila.classList.add('seleccionado');
                        filaSeleccionada = fila;
                        usuarioSeleccionadoId = usuario.id_usuario;
                    });
                    tbody.appendChild(fila);
                });
                // Asignar eventos a los botones
                document.querySelectorAll(".editar").forEach(btn => {
                    btn.addEventListener("click", () => editarUsuario(btn.dataset.id));
                });
                document.querySelectorAll(".eliminar").forEach(btn => {
                    btn.addEventListener("click", () => eliminarUsuario(btn.dataset.id));
                });
            })
            .catch(err => console.error("Error al cargar usuarios:", err));
    }

    async function editarUsuario(id) {
        const fila = document.querySelector(`.editar[data-id='${id}']`).closest("tr");
        const correoActual = fila.cells[4].innerText;

        const correo = await Swal.fire({
            title: "Nuevo correo electrónico",
            input: "email",
            inputValue: correoActual,
            showCancelButton: true,
            confirmButtonText: "Continuar",
            cancelButtonText: "Cancelar",
            inputValidator: value => !value || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value.trim())
                ? "Ingresa un correo válido."
                : undefined
        });
        if (!correo.isConfirmed) return;

        const cambioPassword = await Swal.fire({
            icon: "question",
            text: "¿Desea cambiar la contraseña?",
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: "Cambiar contraseña",
            denyButtonText: "Mantener actual",
            cancelButtonText: "Cancelar"
        });
        if (cambioPassword.isDismissed) return;

        let nuevaPassword = "";
        if (cambioPassword.isConfirmed) {
            const password = await Swal.fire({
                title: "Nueva contraseña",
                input: "password",
                showCancelButton: true,
                confirmButtonText: "Continuar",
                cancelButtonText: "Cancelar",
                inputValidator: value => value.length < 4
                    ? "La contraseña debe tener al menos 4 caracteres."
                    : undefined
            });
            if (!password.isConfirmed) return;

            const confirmar = await Swal.fire({
                title: "Confirmar contraseña",
                input: "password",
                showCancelButton: true,
                confirmButtonText: "Guardar",
                cancelButtonText: "Cancelar",
                inputValidator: value => value !== password.value
                    ? "Las contraseñas no coinciden."
                    : undefined
            });
            if (!confirmar.isConfirmed) return;
            nuevaPassword = password.value;
        }

        const formData = new FormData();
        formData.append("opc", "update");
        formData.append("id_usuario", id);
        formData.append("correo", correo.value.trim());
        if (nuevaPassword) {
            formData.append("password", nuevaPassword);
        }

        fetch("../Controlador/ControlUsuarios.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(resp => {
            Swal.fire({
                icon: resp.success ? "success" : "error",
                text: resp.message
            });
            if (resp.success) cargarUsuarios();
        })
        .catch(err => Swal.fire({ icon: "error", text: "Error: " + err }));
    }

    async function eliminarUsuario(id) {
        const confirmacion = await Swal.fire({
            icon: "warning",
            text: "¿Estás seguro de eliminar este usuario?",
            showCancelButton: true,
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "Cancelar"
        });
        if (!confirmacion.isConfirmed) return;

        const formData = new FormData();
        formData.append("opc", "delete");
        formData.append("id_usuario", id);
        fetch("../Controlador/ControlUsuarios.php", {
            method: "POST",
            body: formData
        })
        .then(res => res.json())
        .then(resp => {
            Swal.fire({
                icon: resp.success ? "success" : "error",
                text: resp.message
            });
            if (resp.success) cargarUsuarios();
        })
        .catch(err => Swal.fire({ icon: "error", text: "Error: " + err }));
    }


    cargarUsuarios();  // Iniciar la carga
});