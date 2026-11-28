document.addEventListener('DOMContentLoaded', function() {
    const tbody = document.getElementById('cuerpo-tabla');
    let rolesDisponibles = [];

    function crearCelda(valor) {
        const celda = document.createElement('td');
        celda.textContent = valor || '';
        return celda;
    }

    async function cargarUsuarios() {
        const response = await fetch("../Modelo/modeloUsuario.php");
        if (!response.ok) throw new Error("No se pudieron cargar los usuarios.");
        const datos = await response.json();
        rolesDisponibles = datos.roles || [];
        tbody.replaceChildren();

        (datos.usuarios || []).forEach(usuario => {
            const fila = document.createElement('tr');
            [
                usuario.id_usuario,
                usuario.nombre,
                usuario.apellido_paterno,
                usuario.apellido_materno,
                usuario.correo,
                usuario.rol || usuario.id_rol,
                usuario.sexo
            ].forEach(valor => fila.appendChild(crearCelda(valor)));

            const acciones = document.createElement('td');
            const editar = document.createElement('button');
            editar.type = 'button';
            editar.className = 'editar';
            editar.textContent = 'Editar';
            editar.addEventListener('click', () => editarUsuario(usuario));

            const eliminar = document.createElement('button');
            eliminar.type = 'button';
            eliminar.className = 'eliminar';
            eliminar.textContent = 'Eliminar';
            eliminar.addEventListener('click', () => eliminarUsuario(usuario.id_usuario));

            acciones.append(editar, document.createTextNode(' '), eliminar);
            fila.appendChild(acciones);
            tbody.appendChild(fila);
        });
    }

    async function editarUsuario(usuario) {
        const opcionesRol = rolesDisponibles.map(rol =>
            `<option value="${Number(rol.id_rol)}" ${Number(rol.id_rol) === Number(usuario.id_rol) ? 'selected' : ''}>${escapeHtml(rol.nombre)}</option>`
        ).join('');
        const resultado = await Swal.fire({
            title: "Editar usuario",
            html: `
                <input id="usuario-nombre" class="swal2-input" placeholder="Nombre" value="${escapeHtml(usuario.nombre)}">
                <input id="usuario-apellido-paterno" class="swal2-input" placeholder="Apellido paterno" value="${escapeHtml(usuario.apellido_paterno)}">
                <input id="usuario-apellido-materno" class="swal2-input" placeholder="Apellido materno (opcional)" value="${escapeHtml(usuario.apellido_materno)}">
                <input id="usuario-correo" class="swal2-input" type="email" placeholder="Correo" value="${escapeHtml(usuario.correo)}">
                <select id="usuario-sexo" class="swal2-select">
                    <option value="Femenino" ${usuario.sexo === 'Femenino' ? 'selected' : ''}>Femenino</option>
                    <option value="Masculino" ${usuario.sexo === 'Masculino' ? 'selected' : ''}>Masculino</option>
                </select>
                <select id="usuario-rol" class="swal2-select">${opcionesRol}</select>
                <input id="usuario-password" class="swal2-input" type="password" placeholder="Nueva contraseña (opcional)">
            `,
            showCancelButton: true,
            confirmButtonText: "Guardar",
            cancelButtonText: "Cancelar",
            focusConfirm: false,
            preConfirm: () => {
                const values = {
                    nombre: document.getElementById('usuario-nombre').value.trim(),
                    apellido_paterno: document.getElementById('usuario-apellido-paterno').value.trim(),
                    apellido_materno: document.getElementById('usuario-apellido-materno').value.trim(),
                    correo: document.getElementById('usuario-correo').value.trim(),
                    sexo: document.getElementById('usuario-sexo').value,
                    id_rol: document.getElementById('usuario-rol').value,
                    password: document.getElementById('usuario-password').value
                };
                if (!values.nombre || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(values.correo)) {
                    Swal.showValidationMessage("Ingresa nombre y un correo válido.");
                    return false;
                }
                if (values.password && values.password.length < 8) {
                    Swal.showValidationMessage("La contraseña debe tener al menos 8 caracteres.");
                    return false;
                }
                return values;
            }
        });
        if (!resultado.isConfirmed) return;

        const formData = new FormData();
        formData.append("opc", "update");
        formData.append("id_usuario", usuario.id_usuario);
        Object.entries(resultado.value).forEach(([key, value]) => formData.append(key, value));
        try {
            const response = await fetch("../Controlador/ControlUsuarios.php", { method: "POST", body: formData });
            const resp = await response.json();
            await Swal.fire({ icon: resp.success ? "success" : "error", text: resp.message });
            if (resp.success) await cargarUsuarios();
        } catch (error) {
            Swal.fire({ icon: "error", text: "No se pudo actualizar el usuario: " + error.message });
        }
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
        try {
            const response = await fetch("../Controlador/ControlUsuarios.php", { method: "POST", body: formData });
            const resp = await response.json();
            await Swal.fire({ icon: resp.success ? "success" : "error", text: resp.message });
            if (resp.success) await cargarUsuarios();
        } catch (error) {
            Swal.fire({ icon: "error", text: "No se pudo eliminar el usuario: " + error.message });
        }
    }

    function escapeHtml(value) {
        return String(value || '').replace(/[&<>"']/g, character => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        })[character]);
    }

    cargarUsuarios().catch(error => {
        console.error("Error al cargar usuarios:", error);
        Swal.fire({ icon: "error", text: error.message });
    });
});
