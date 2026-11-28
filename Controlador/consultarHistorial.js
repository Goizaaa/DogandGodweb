document.addEventListener("DOMContentLoaded", () => {
    const tabla = document.querySelector("#tabla tbody");
    const tablaConsultas = document.querySelector("#tablaConsultas tbody");
    const tablaProcedimientos = document.querySelector("#tablaProcedimientos tbody");
    const tablaLaboratorio = document.querySelector("#tablaLaboratorio tbody");
    const tablaRadiografias = document.querySelector("#tablaRadiografias tbody");
    const tablaUltrasonido = document.querySelector("#tablaUltrasonido tbody");

    const urlParams = new URLSearchParams(window.location.search);
    let idMascotaURL = urlParams.get('id_mascota');

    if (idMascotaURL) {
        idMascotaURL = idMascotaURL.replace(/^"|"$/g, '').trim();
    }

    const idMascota = idMascotaURL;

    if (!idMascota || idMascota === "null" || idMascota === "undefined") {
        console.error("Error: No se encontró ningún 'id_mascota' válido.");
        window.alert("Error: Identificador de mascota no encontrado.");
        return; 
    }

    localStorage.setItem("id_mascota_editar", idMascota);

    const general = document.getElementById("informacionGeneral");
    const consultas = document.getElementById("consultas");
    const procedimientos = document.getElementById("procedimientos");
    const laboratorio = document.getElementById("laboratorio");
    const radiografias = document.getElementById("radiografias");
    const ultrasonido = document.getElementById("ultrasonido");

    function ocultarTodo() {
        [general, consultas, procedimientos, laboratorio, radiografias, ultrasonido]
            .forEach(seccion => {
                if (seccion) seccion.style.display = "none";
            });
    }

    document.getElementById("btnGeneral").onclick = function () { ocultarTodo(); general.style.display = "block"; };
    document.getElementById("btnConsultas").onclick = function () { ocultarTodo(); consultas.style.display = "block"; };
    document.getElementById("btnProcedimientos").onclick = function () { ocultarTodo(); procedimientos.style.display = "block"; };
    document.getElementById("btnLaboratorio").onclick = function () { ocultarTodo(); laboratorio.style.display = "block"; };
    document.getElementById("btnRadiografias").onclick = function () { ocultarTodo(); radiografias.style.display = "block"; };
    document.getElementById("btnUltrasonido").onclick = function (evento) {
        evento.preventDefault();
        ocultarTodo();
        ultrasonido.style.display = "block";
    };

    const columnas = {
        general: ["nom_mascota", "nom_tutor", "especie", "raza", "fecha_adopcion", "sexo", "esterilizado", "telefono", "alergia", "NumMicrochip"],
        consultas: ["fecha", "diagnostico", "tratamiento"],
        procedimientos: ["nombre", "descripcion", "fecha"],
        laboratorio: ["nombre", "descripcion", "fecha", "archivo"],
        radiografias: ["nombre", "descripcion", "fecha", "archivo"],
        ultrasonido: ["nombre", "descripcion", "fecha"]
    };

    async function llenarTabla(opc, tablaDestino) {
        if (!tablaDestino) return;

        tablaDestino.innerHTML = "";

        const valores = new FormData();
        valores.append("opc", opc);
        valores.append("id_mascota", idMascota);

        try {
            const respuesta = await fetch("../Controlador/modeloHistorial.php", {
                method: "POST",
                body: valores
            });
            const datos = await respuesta.json();
            if (!respuesta.ok) throw new Error(datos.message || "Error en la respuesta del servidor");
            if (!datos || datos.length === 0) {
                const fila = document.createElement("tr");
                const celda = document.createElement("td");
                celda.textContent = "No hay registros disponibles.";
                celda.colSpan = (columnas[opc] || []).length || 1;
                fila.appendChild(celda);
                tablaDestino.appendChild(fila);
                return;
            }

            datos.forEach(obj => {
                const fila = document.createElement("tr");
                (columnas[opc] || Object.keys(obj)).forEach(propiedad => {
                    const celda = document.createElement("td");
                    if (propiedad === "archivo" && obj[propiedad]) {
                        const rutaPermitida = /^\.\.\/recursos\/historial\/[a-f0-9]+\.(pdf|jpg|jpeg|png)$/i;
                        if (rutaPermitida.test(obj[propiedad])) {
                            const enlace = document.createElement("a");
                            enlace.href = obj[propiedad];
                            enlace.target = "_blank";
                            enlace.rel = "noopener noreferrer";
                            enlace.textContent = "Ver archivo";
                            celda.appendChild(enlace);
                        } else {
                            celda.textContent = "Archivo no disponible";
                        }
                    } else {
                        celda.textContent = obj[propiedad] || "—";
                    }
                    fila.appendChild(celda);
                });
                tablaDestino.appendChild(fila);
            });
        } catch (error) {
            console.error(`Error cargando la sección ${opc}:`, error);
            const fila = document.createElement("tr");
            const celda = document.createElement("td");
            celda.colSpan = (columnas[opc] || []).length || 1;
            celda.textContent = "No se pudo cargar la información.";
            fila.appendChild(celda);
            tablaDestino.appendChild(fila);
        }
    }

    llenarTabla("general", tabla);
    llenarTabla("consultas", tablaConsultas);
    llenarTabla("procedimientos", tablaProcedimientos);
    llenarTabla("laboratorio", tablaLaboratorio);
    llenarTabla("radiografias", tablaRadiografias);
    llenarTabla("ultrasonido", tablaUltrasonido);

    document.querySelectorAll("[data-abrir-modal]").forEach(boton => {
        boton.addEventListener("click", () => {
            const modal = document.getElementById(boton.dataset.abrirModal);
            if (modal) modal.showModal();
        });
    });

    document.querySelectorAll(".tabla-modal").forEach(modal => {
        modal.querySelectorAll("[data-cerrar-modal]").forEach(boton => {
            boton.addEventListener("click", () => modal.close());
        });
        modal.addEventListener("click", evento => {
            if (evento.target === modal) modal.close();
        });
        modal.addEventListener("close", () => {
            const formulario = modal.querySelector("[data-form-historial]");
            if (formulario) {
                formulario.reset();
                formulario.querySelector(".tabla-modal-mensaje").textContent = "";
                formulario.querySelector(".tabla-modal-mensaje").classList.remove("es-exito");
            }
        });
    });

    document.querySelectorAll("[data-form-historial]").forEach(formulario => {
        formulario.addEventListener("submit", async evento => {
            evento.preventDefault();
            const mensaje = formulario.querySelector(".tabla-modal-mensaje");
            const guardar = formulario.querySelector('[type="submit"]');
            const datos = new FormData(formulario);
            datos.append("opc", "agregar");
            datos.append("tipo", formulario.dataset.tipo);
            datos.append("id_mascota", idMascota);
            mensaje.textContent = "";
            mensaje.classList.remove("es-exito");
            guardar.disabled = true;

            try {
                const respuesta = await fetch("../Controlador/modeloHistorial.php", {
                    method: "POST",
                    body: datos
                });
                const resultado = await respuesta.json();
                if (!respuesta.ok || !resultado.success) {
                    throw new Error(resultado.message || "No se pudo guardar el registro.");
                }

                mensaje.textContent = resultado.message;
                mensaje.classList.add("es-exito");
                const seccionActualizada = {
                    procedimientos: { opcion: "procedimientos", tabla: tablaProcedimientos },
                    analisisclinicos: { opcion: "laboratorio", tabla: tablaLaboratorio },
                    radiografias: { opcion: "radiografias", tabla: tablaRadiografias },
                    ultrasonido: { opcion: "ultrasonido", tabla: tablaUltrasonido }
                }[formulario.dataset.tipo];
                await llenarTabla(seccionActualizada.opcion, seccionActualizada.tabla);
                window.setTimeout(() => {
                    const modal = formulario.closest("dialog");
                    if (modal && modal.open) modal.close();
                }, 900);
            } catch (error) {
                mensaje.textContent = error.message || "Ocurrió un error al guardar.";
            } finally {
                guardar.disabled = false;
            }
        });
    });
});
