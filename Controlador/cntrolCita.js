document.addEventListener("DOMContentLoaded", () => {
    const tablaCitas = document.querySelector("#tablaCitas tbody");
    const frmAgregarCita = document.querySelector("#frmAgregarCita");

    // ========== LISTAR CITAS (ConsultarCita.php) ==========
    function cargarCitas() {
        if (!tablaCitas) return;

        let valores = new FormData();
        valores.append("opc", "listar");

        fetch("../Controlador/ControladorCita.php", {
            method: "POST",
            body: valores
        })
        .then(res => res.json())
        .then(datos => {
            tablaCitas.innerHTML = "";

            datos.forEach(cita => {
                let fila = document.createElement("tr");

                fila.innerHTML = `
                    <td>${cita.id_cita}</td>
                    <td>${cita.fecha}</td>
                    <td>${cita.hora}</td>
                    <td>${cita.procedimiento}</td>
                    <td>${cita.correo_tutor}</td>
                    <td>${cita.correo_veterinario}</td>
                    <td>
                        <button onclick="redirigirCancelar('${cita.id_cita}')">Cancelar</button>
                    </td>
                `;

                tablaCitas.appendChild(fila);
            });
        })
        .catch(error => console.error("Error al cargar citas:", error));
    }

    // Redirigir a CancelarCita enviando el ID por URL
    window.redirigirCancelar = function(idCita) {
        window.location.href = `CancelarCita.php?id_cita=${idCita}`;
    };

    // ========== AGREGAR CITA Y REDIRIGIR (AgregarCita.php) ==========
    if (frmAgregarCita) {
        frmAgregarCita.addEventListener("submit", (e) => {
            e.preventDefault();

            let valores = new FormData(frmAgregarCita);
            valores.append("opc", "create");

            fetch("../Controlador/ControladorCita.php", {
                method: "POST",
                body: valores
            })
            .then(async res => {
                const texto = await res.text();
                try {
                    return JSON.parse(texto);
                } catch (err) {
                    console.error("Respuesta del servidor no es JSON:", texto);
                    throw new Error("El servidor devolvió una respuesta inesperada.");
                }
            })
            .then(data => {
                alert(data.message);
                if (data.success) {
                    // Redirección a la interfaz de consultar citas
                    window.location.href = "ConsultarCita.php";
                }
            })
            .catch(error => {
                alert("Ocurrió un error al procesar la solicitud.");
                console.error("Error al agendar cita:", error);
            });
        });
    }

    cargarCitas();
});