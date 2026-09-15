document.addEventListener('DOMContentLoaded', function() {
    const selectMascota = document.getElementById('selectMascota');
    const selectTutor = document.getElementById('selectTutor');
    const btnAsignar = document.getElementById('btnAsignar');
    const mensaje = document.getElementById('mensaje');

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
            data.forEach(m => {
                let option = document.createElement('option');
                option.value = m.id_mascota;
                option.textContent = `${m.id_mascota} - ${m.nom_mascota}`;
                selectMascota.appendChild(option);
            });
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
            data.forEach(t => {
                let option = document.createElement('option');
                option.value = t.correo_tutor;
                option.textContent = `${t.nom_tutor} ${t.app_tutor} (${t.correo_tutor})`;
                selectTutor.appendChild(option);
            });
        });
    }

    if (btnAsignar) {
        btnAsignar.addEventListener('click', () => {
            const idMascota = selectMascota.value;
            const correoTutor = selectTutor.value;

            if (!idMascota || !correoTutor) {
                alert("Debe seleccionar mascota y tutor");
                return;
            }

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
                alert(data.message);
                if (data.success) {
                    cargarMascotasSinTutor();
                    selectTutor.value = "";
                }
            });
        });
    }

    cargarMascotasSinTutor();
    cargarTutores();
});