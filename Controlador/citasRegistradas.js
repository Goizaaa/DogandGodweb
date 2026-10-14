document.addEventListener("DOMContentLoaded", () => {
    const tabla = document.querySelector("#tablaCitas tbody");
    if (!tabla) return;

    const mostrarMensaje = mensaje => {
        tabla.replaceChildren();
        const fila = document.createElement("tr");
        const celda = document.createElement("td");
        celda.colSpan = 7;
        celda.textContent = mensaje;
        fila.appendChild(celda);
        tabla.appendChild(fila);
    };

    const cargarCitas = () => {
        const valores = new FormData();
        valores.append("opc", "listar");

        fetch("../Controlador/ControladorCita.php", { method: "POST", body: valores })
            .then(respuesta => {
                if (!respuesta.ok) throw new Error(`Error HTTP ${respuesta.status}`);
                return respuesta.json();
            })
            .then(citas => {
                tabla.replaceChildren();
                if (!Array.isArray(citas) || citas.length === 0) {
                    mostrarMensaje("No hay citas registradas.");
                    return;
                }

                citas.forEach(cita => {
                    const fila = document.createElement("tr");
                    [cita.id_cita, cita.fecha, String(cita.hora || "").slice(0, 5), cita.procedimiento,
                        cita.correo_tutor, cita.correo_veterinario].forEach(valor => {
                        const celda = document.createElement("td");
                        celda.textContent = valor || "—";
                        fila.appendChild(celda);
                    });

                    const celdaAcciones = document.createElement("td");
                    const cancelar = document.createElement("button");
                    cancelar.type = "button";
                    cancelar.className = "cita-cancelar-btn";
                    cancelar.textContent = "Cancelar";
                    cancelar.addEventListener("click", () => {
                        if (!window.confirm(`¿Deseas cancelar la cita ${cita.id_cita}? Esta acción no se puede deshacer.`)) return;
                        cancelar.disabled = true;
                        cancelar.textContent = "Cancelando…";

                        const datos = new FormData();
                        datos.append("opc", "delete");
                        datos.append("id_cita", cita.id_cita);
                        fetch("../Controlador/ControladorCita.php", { method: "POST", body: datos })
                            .then(respuesta => respuesta.json().then(resultado => {
                                if (!respuesta.ok || !resultado.success) throw new Error(resultado.message || "No se pudo cancelar la cita.");
                                return resultado;
                            }))
                            .then(resultado => {
                                window.alert(resultado.message || "Cita cancelada correctamente.");
                                cargarCitas();
                            })
                            .catch(error => {
                                cancelar.disabled = false;
                                cancelar.textContent = "Cancelar";
                                window.alert(error.message || "Ocurrió un error al cancelar la cita.");
                            });
                    });
                    celdaAcciones.appendChild(cancelar);
                    fila.appendChild(celdaAcciones);
                    tabla.appendChild(fila);
                });
            })
            .catch(error => {
                console.error("Error al cargar las citas:", error);
                mostrarMensaje("No se pudieron cargar las citas. Intenta de nuevo más tarde.");
            });
    };

    cargarCitas();
});
