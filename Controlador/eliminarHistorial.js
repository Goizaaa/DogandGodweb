document.addEventListener("DOMContentLoaded", () => {
    const tituloMascota = document.querySelector("#tituloMascota");
    const btnSi = document.querySelector("#btnSi");
    const btnNo = document.querySelector("#btnNo");

    const idMascota = localStorage.getItem("id_mascota_editar");

    if (!idMascota || idMascota === "null" || idMascota === "undefined") {
        alert("Error: No se ha seleccionado ninguna mascota.");
        window.location.href = "consultarhis.html";
        return;
    }

    function cargarNombreMascota() {
        let valores = new FormData();
        valores.append("opc", "general"); // Reutiliza tu consulta limpia existente
        valores.append("id_mascota", idMascota);

        fetch("../controlador/modeloHistorial.php", {
            method: "POST",
            body: valores
        })
        .then(res => res.json())
        .then(datos => {
            if (datos && datos.length > 0) {
                const registro = datos;
                if (tituloMascota && registro.nom_mascota) {
                    tituloMascota.textContent = `¿Eliminar historial de: ${registro.nom_mascota}?`;
                }
            }
        })
        .catch(err => console.error("Error al precargar el nombre:", err));
    }

    cargarNombreMascota(); // Ejecucion automica al abrir la pantalla

    if (btnNo) {
        btnNo.addEventListener("click", () => {
            window.location.href = `consultarhis.html?id_mascota=${idMascota}`;
        });
    }

    if (btnSi) {
        btnSi.addEventListener("click", (e) => {
            e.preventDefault();

            let valoresEnviar = new FormData();
            valoresEnviar.append("opc", "delete"); // Nueva opci para el switch de tu PHP
            valoresEnviar.append("id_mascota", idMascota);

            fetch("../Controlador/modeloHistorial.php", {
                method: "POST",
                body: valoresEnviar
            })
            .then(res => {
                if (!res.ok) throw new Error("Error en la respuesta del servidor.");
                return res.json();
            })
.then(data => {
    if (data.success) {
        alert("Historial eliminado correctamente");
        
        localStorage.removeItem("id_mascota_editar");
        

        window.location.href = "registhist.html"; 
        alert("Error al intentar eliminar el registro.");
    }
})

            .catch(err => {
                console.error("Error en la baja:", err);
                alert("Ocurrió un error en el servidor.");
            });
        });
    }
});
