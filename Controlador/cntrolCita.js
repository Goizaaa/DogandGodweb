document.addEventListener("DOMContentLoaded", () => {
    const tablaCitas = document.querySelector("#tablaCitas tbody");
    const frmAgregarCita = document.querySelector("#frmAgregarCita");
    const monthYearEl = document.getElementById("month-year");
    const daysEl = document.getElementById("days");
    const prevMonthBtn = document.getElementById("prev-month");
    const nextMonthBtn = document.getElementById("next-month");
    const todayBtn = document.getElementById("today-btn");
    const eventDateEl = document.getElementById("event-date");
    const eventListEl = document.getElementById("event-list");

    let citas = [];
    let currentDate = new Date();
    currentDate.setDate(1);
    let selectedDate = null;
    const formatoFecha = new Intl.DateTimeFormat("es-MX", { weekday: "long", day: "numeric", month: "long", year: "numeric" });
    const formatoMes = new Intl.DateTimeFormat("es-MX", { month: "long", year: "numeric" });

    function claveFecha(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, "0");
        const day = String(date.getDate()).padStart(2, "0");
        return `${year}-${month}-${day}`;
    }

    function fechaDeCita(fecha) {
        const coincidencia = String(fecha || "").match(/^(\d{4})-(\d{1,2})-(\d{1,2})/);
        if (!coincidencia) return null;
        return new Date(Number(coincidencia[1]), Number(coincidencia[2]) - 1, Number(coincidencia[3]));
    }

    function citasPorFecha() {
        return citas.reduce((grupos, cita) => {
            const fecha = fechaDeCita(cita.fecha);
            if (!fecha) return grupos;
            const clave = claveFecha(fecha);
            if (!grupos.has(clave)) grupos.set(clave, []);
            grupos.get(clave).push(cita);
            return grupos;
        }, new Map());
    }

    function limpiarEventos(mensaje) {
        eventListEl.replaceChildren();
        const vacio = document.createElement("div");
        vacio.className = "no-events";
        vacio.textContent = mensaje;
        eventListEl.appendChild(vacio);
    }

    function mostrarCitas(date) {
        const clave = claveFecha(date);
        eventDateEl.textContent = formatoFecha.format(date);
        eventListEl.replaceChildren();
        const delDia = citasPorFecha().get(clave) || [];
        if (!delDia.length) {
            limpiarEventos("No hay citas agendadas para este día.");
            return;
        }
        delDia.forEach(cita => {
            const item = document.createElement("article");
            item.className = "event-item";
            const punto = document.createElement("span");
            punto.className = "event-color";
            punto.setAttribute("aria-hidden", "true");
            const hora = document.createElement("span");
            hora.className = "event-time";
            hora.textContent = cita.hora || "Sin hora";
            const detalle = document.createElement("div");
            detalle.className = "event-text";
            const procedimiento = document.createElement("strong");
            procedimiento.textContent = cita.procedimiento || "Cita veterinaria";
            const veterinario = document.createElement("small");
            veterinario.textContent = cita.correo_veterinario || "";
            detalle.append(procedimiento, veterinario);
            item.append(punto, hora, detalle);
            eventListEl.appendChild(item);
        });
    }

    function renderCalendar() {
        if (!daysEl || !monthYearEl) return;
        monthYearEl.textContent = formatoMes.format(currentDate);
        daysEl.replaceChildren();
        const firstDay = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
        const startDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1 - firstDay.getDay());
        const grupos = citasPorFecha();
        const hoy = claveFecha(new Date());
        for (let indice = 0; indice < 42; indice++) {
            const fecha = new Date(startDate.getFullYear(), startDate.getMonth(), startDate.getDate() + indice);
            const clave = claveFecha(fecha);
            const boton = document.createElement("button");
            boton.type = "button";
            boton.className = "day";
            boton.textContent = String(fecha.getDate());
            boton.dataset.date = clave;
            boton.setAttribute("aria-label", formatoFecha.format(fecha));
            if (fecha.getMonth() !== currentDate.getMonth()) boton.classList.add("other-month");
            if (clave === hoy) boton.classList.add("today");
            if (selectedDate && clave === claveFecha(selectedDate)) boton.classList.add("selected");
            if (grupos.has(clave)) boton.classList.add("has-events");
            if (clave === hoy) boton.setAttribute("aria-current", "date");
            if (selectedDate && clave === claveFecha(selectedDate)) boton.setAttribute("aria-pressed", "true");
            else boton.setAttribute("aria-pressed", "false");
            boton.addEventListener("click", () => {
                selectedDate = fecha;
                currentDate = new Date(fecha.getFullYear(), fecha.getMonth(), 1);
                renderCalendar();
                mostrarCitas(fecha);
            });
            daysEl.appendChild(boton);
        }
    }

    function cargarCitas() {
        const valores = new FormData();
        valores.append("opc", "listar");
        fetch("../Controlador/ControladorCita.php", { method: "POST", body: valores })
            .then(respuesta => {
                if (!respuesta.ok) throw new Error(`Error HTTP ${respuesta.status}`);
                return respuesta.json();
            })
            .then(datos => {
                if (Array.isArray(datos)) {
                    citas = datos;
                } else if (datos && Array.isArray(datos.citas)) {
                    citas = datos.citas;
                } else if (datos && datos.success === false) {
                    throw new Error(datos.message || "El servidor no pudo consultar las citas.");
                } else {
                    throw new Error("El servidor devolvió un formato inesperado: " + JSON.stringify(datos));
                }
                if (tablaCitas) {
                    tablaCitas.replaceChildren();
                    citas.forEach(cita => {
                        const fila = document.createElement("tr");
                        [cita.id_cita, cita.fecha, cita.hora, cita.procedimiento, cita.correo_tutor, cita.correo_veterinario].forEach(valor => {
                            const celda = document.createElement("td");
                            celda.textContent = valor || "—";
                            fila.appendChild(celda);
                        });
                        const acciones = document.createElement("td");
                        const cancelar = document.createElement("button");
                        cancelar.type = "button";
                        cancelar.className = "cita-cancelar-btn";
                        cancelar.textContent = "Cancelar";
                        cancelar.addEventListener("click", () => redirigirCancelar(cita.id_cita));
                        acciones.appendChild(cancelar);
                        fila.appendChild(acciones);
                        tablaCitas.appendChild(fila);
                    });
                }
                renderCalendar();
                if (selectedDate) mostrarCitas(selectedDate);
            })
            .catch(error => {
                console.error("Error al cargar citas:", error);
                if (tablaCitas) {
                    const fila = document.createElement("tr");
                    const celda = document.createElement("td");
                    celda.colSpan = 7;
                    celda.textContent = "No fue posible cargar las citas: " + error.message;
                    fila.appendChild(celda);
                    tablaCitas.replaceChildren(fila);
                }
                limpiarEventos("Error al cargar las citas: " + error.message);
                renderCalendar();
            });
    }

    window.redirigirCancelar = idCita => {
        window.location.href = `CancelarCita.php?id_cita=${encodeURIComponent(idCita)}`;
    };

    if (prevMonthBtn) prevMonthBtn.addEventListener("click", () => {
        currentDate = new Date(currentDate.getFullYear(), currentDate.getMonth() - 1, 1);
        selectedDate = null;
        eventDateEl.textContent = "Selecciona una fecha";
        limpiarEventos("Selecciona un día para ver las citas agendadas.");
        renderCalendar();
    });
    if (nextMonthBtn) nextMonthBtn.addEventListener("click", () => {
        currentDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 1);
        selectedDate = null;
        eventDateEl.textContent = "Selecciona una fecha";
        limpiarEventos("Selecciona un día para ver las citas agendadas.");
        renderCalendar();
    });
    if (todayBtn) todayBtn.addEventListener("click", () => {
        const hoy = new Date();
        currentDate = new Date(hoy.getFullYear(), hoy.getMonth(), 1);
        selectedDate = hoy;
        renderCalendar();
        mostrarCitas(hoy);
    });

    if (frmAgregarCita) frmAgregarCita.addEventListener("submit", evento => {
        evento.preventDefault();
        const valores = new FormData(frmAgregarCita);
        valores.append("opc", "create");
        fetch("../Controlador/ControladorCita.php", { method: "POST", body: valores })
            .then(async respuesta => {
                const texto = await respuesta.text();
                let datos;
                try { datos = JSON.parse(texto); }
                catch { throw new Error("El servidor devolvió una respuesta inesperada."); }
                if (!respuesta.ok) throw new Error(datos.message || "No se pudo registrar la cita.");
                return datos;
            })
            .then(datos => {
                alert(datos.message);
                if (datos.success) window.location.href = "ConsultarCita.php";
            })
            .catch(error => {
                alert(error.message || "Ocurrió un error al procesar la solicitud.");
                console.error("Error al agendar cita:", error);
            });
    });

    renderCalendar();
    cargarCitas();
});