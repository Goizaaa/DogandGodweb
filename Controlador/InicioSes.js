document.addEventListener('DOMContentLoaded', () => {
    const secciones = ['inicio', 'recuperar', 'crear']
        .reduce((obj, id) => (obj[id] = document.getElementById(id), obj), {});
    let propositoCodigo = null;
    const modalRecuperacion = document.getElementById('modal-recuperacion');
    const pasoCodigo = document.getElementById('paso-codigo-recuperacion');
    const pasoNuevaContrasena = document.getElementById('paso-nueva-contrasena');
    const mostrar = id => Object.entries(secciones).forEach(([key, el]) => { if (el) el.style.display = key === id ? 'block' : 'none'; });
    const mostrarMensajeRecuperacion = (mensaje, tipo = 'danger') => {
        const elemento = document.getElementById('mensaje-recuperacion');
        elemento.textContent = mensaje;
        elemento.className = `alert alert-${tipo} mb-3`;
        elemento.hidden = false;
    };
    const mostrarPasoRecuperacion = paso => {
        pasoCodigo.hidden = paso !== 'codigo';
        pasoNuevaContrasena.hidden = paso !== 'contrasena';
        document.getElementById('mensaje-recuperacion').hidden = true;
        document.getElementById('instruccion-recuperacion').textContent = paso === 'codigo'
            ? 'Ingresa el código de 6 dígitos que enviamos a tu correo.'
            : 'Elige una contraseña nueva de al menos 8 caracteres.';
    };
    const solicitar = async datos => {
        const form = new FormData();
        Object.entries(datos).forEach(([key, value]) => form.append(key, value));
        const response = await fetch('../Controlador/ControLogin.php', { method: 'POST', body: form });
        return response.json();
    };

    mostrar('inicio');
    document.getElementById('abrerecuperar')?.addEventListener('click', e => { e.preventDefault(); mostrar('recuperar'); });
    document.getElementById('abrecrear')?.addEventListener('click', e => { e.preventDefault(); mostrar('crear'); });

    document.getElementById('CONFIRMAR')?.addEventListener('click', async e => {
        e.preventDefault();
        const correo = document.getElementById('usuarioD').value.trim();
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(correo)) { Swal.fire({ icon: 'error', text: 'Ingresa un correo válido.' }); return; }
        try {
            const result = await solicitar({ enviar_codigo_recuperacion: '1', correo });
            if (!result.status) { Swal.fire({ icon: 'error', text: result.mensaje }); return; }
            propositoCodigo = 'recuperacion';
            document.getElementById('usuarioC').value = '';
            await Swal.fire({ icon: 'success', text: result.mensaje });
            mostrarPasoRecuperacion('codigo');
            modalRecuperacion.showModal();
        } catch (_) { Swal.fire({ icon: 'error', text: 'No se pudo contactar al servidor.' }); }
    });

    document.getElementById('ConfirC')?.addEventListener('click', async e => {
        e.preventDefault();
        const codigo = document.getElementById('usuarioC').value.trim();
        if (!/^\d{6}$/.test(codigo)) { mostrarMensajeRecuperacion('Ingresa el código de 6 dígitos.'); return; }
        try {
            const result = await solicitar({ verificar_codigo: '1', codigo });
            if (!result.status) { mostrarMensajeRecuperacion(result.mensaje); return; }
            if (propositoCodigo !== 'recuperacion' || result.proposito !== 'recuperacion') { mostrarMensajeRecuperacion('El código solo sirve para recuperar la contraseña.'); return; }
            mostrarPasoRecuperacion('contrasena');
        } catch (_) { mostrarMensajeRecuperacion('No se pudo verificar el código.'); }
    });

    document.getElementById('Restabtn')?.addEventListener('click', async e => {
        e.preventDefault();
        const password = document.getElementById('contraseñaT').value;
        const confirmacion = document.getElementById('contraseñadTR').value;
        if (password.length < 8) { mostrarMensajeRecuperacion('La contraseña debe tener al menos 8 caracteres.'); return; }
        if (password !== confirmacion) { mostrarMensajeRecuperacion('Las contraseñas no coinciden.'); return; }
        try {
            const result = await solicitar({ actualizar_password: '1', password });
            if (result.status) {
                document.getElementById('contraseñaT').value = '';
                document.getElementById('contraseñadTR').value = '';
                document.getElementById('usuarioC').value = '';
                document.getElementById('usuarioD').value = '';
                propositoCodigo = null;
                modalRecuperacion.close();
                mostrar('inicio');
                await Swal.fire({ icon: 'success', text: result.mensaje });
            } else { mostrarMensajeRecuperacion(result.mensaje); }
        } catch (_) { mostrarMensajeRecuperacion('No se pudo actualizar la contraseña.'); }
    });

    document.getElementById('cerrar-modal-recuperacion')?.addEventListener('click', () => modalRecuperacion.close());
    modalRecuperacion?.addEventListener('click', e => { if (e.target === modalRecuperacion) modalRecuperacion.close(); });
    modalRecuperacion?.addEventListener('close', () => {
        propositoCodigo = null;
        document.getElementById('usuarioC').value = '';
        document.getElementById('contraseñaT').value = '';
        document.getElementById('contraseñadTR').value = '';
        document.getElementById('mensaje-recuperacion').hidden = true;
        mostrarPasoRecuperacion('codigo');
    });

    const login = document.getElementById('registro');
    login?.addEventListener('submit', async e => {
        e.preventDefault();
        const correo = document.getElementById('correoU').value.trim();
        const password = document.getElementById('contraU').value;
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(correo) || !password) { Swal.fire({ icon: 'error', text: 'Ingresa un correo y una contraseña válidos.' }); return; }
        try {
            const result = await solicitar({ login: '1', correo, password });
            if (!result.status) { Swal.fire({ icon: 'error', text: result.mensaje }); return; }
            localStorage.setItem('correo_tutor', result.correo || correo);
            await Swal.fire({ icon: 'success', text: result.mensaje });
            window.location.href = '../Vista/HomeVet.php';
        } catch (_) { Swal.fire({ icon: 'error', text: 'No se pudo contactar al servidor.' }); }
    });

    document.getElementById('crearbtn')?.addEventListener('click', async e => {
        e.preventDefault();
        const nombre = document.getElementById('NomU').value.trim();
        const apellidoP = document.getElementById('aPpU').value.trim();
        const apellidoM = document.getElementById('aPmU').value.trim();
        const correo = document.getElementById('usuarioCI').value.trim();
        const correo2 = document.getElementById('usuarioaCI').value.trim();
        const password = document.getElementById('contraseñaCI').value;
        const password2 = document.getElementById('contraseñaa').value;
        if (!nombre || !apellidoP || !apellidoM || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(correo) || correo !== correo2 || password.length < 8 || password !== password2) {
            Swal.fire({ icon: 'error', text: 'Revisa nombre, apellidos, correos y contraseñas. La contraseña requiere al menos 8 caracteres.' }); return;
        }
        try {
            const result = await solicitar({ crear: '1', correo, password, nombre, apellido_paterno: apellidoP, apellido_materno: apellidoM });
            await Swal.fire({ icon: result.status ? 'success' : 'error', text: result.mensaje });
            if (result.status) { login.reset(); mostrar('inicio'); }
        } catch (_) { Swal.fire({ icon: 'error', text: 'No se pudo crear la cuenta.' }); }
    });
});
