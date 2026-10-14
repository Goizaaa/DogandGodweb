document.addEventListener("DOMContentLoaded", () => {
    const frmAgregarCita = document.querySelector("#frmAgregarCita");
    const monthYearEl = document.getElementById("month-year");
    const daysEl = document.getElementById("days");
    const prevMonthBtn = document.getElementById("prev-month");
    const nextMonthBtn = document.getElementById("next-month");
    const todayBtn = document.getElementById("today-btn");
    const eventDateEl = document.getElementById("event-date");
    const eventListEl = document.getElementById("event-list");
    const fechaCitaInput = document.getElementById("fecha");
    const horaCitaSelect = document.getElementById("hora");
    const modalAgregarCita = document.getElementById("modal-agregar-cita");
    const abrirModalCitaBtn = document.getElementById("abrir-modal-cita");
    const cerrarModalCitaBtn = document.getElementById("cerrar-modal-cita");
    const cancelarModalCitaBtn = document.getElementById("cancelar-modal-cita");
    const vistaCliente = document.body.dataset.vista === "cliente";

    let citas = [];
    let currentDate = new Date();
    currentDate.setDate(1);
    let selectedDate = null;
    const formatoFecha = new Intl.DateTimeFormat("es-MX", { weekday: "long", day: "numeric", month: "long", year: "numeric" });
    const formatoMes = new Intl.DateTimeFormat("es-MX", { month: "long", year: "numeric" });

    const horariosAtencion = [];
    for (let minutos = 9 * 60; minutos <= 15 * 60 + 40; minutos += 40) {
        const hora = String(Math.floor(minutos / 60)).padStart(2, "0");
        const minuto = String(minutos % 60).padStart(2, "0");
        horariosAtencion.push(`${hora}:${minuto}`);
    }

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

    function actualizarHorariosDisponibles() {
        if (!horaCitaSelect) return;
        const fechaSeleccionada = fechaCitaInput ? fechaCitaInput.value : "";
        const seleccionAnterior = horaCitaSelect.value;
        const ocupadas = new Set(citas
            .filter(cita => {
                const fecha = fechaDeCita(cita.fecha);
                return fecha && claveFecha(fecha) === fechaSeleccionada;
            })
            .map(cita => String(cita.hora || "").slice(0, 5)));

        horaCitaSelect.replaceChildren();
        const indicacion = document.createElement("option");
        indicacion.value = "";
        indicacion.textContent = "Selecciona un horario";
        horaCitaSelect.appendChild(indicacion);

        horariosAtencion.forEach(hora => {
            const opcion = document.createElement("option");
            opcion.value = hora;
            opcion.disabled = ocupadas.has(hora);
            opcion.textContent = opcion.disabled ? `${hora} · Ocupado` : hora;
            horaCitaSelect.appendChild(opcion);
        });

        if (seleccionAnterior && !ocupadas.has(seleccionAnterior)) horaCitaSelect.value = seleccionAnterior;
        else horaCitaSelect.value = "";
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
            const item = document.createElement("details");
            item.className = "event-item";
            const resumen = document.createElement("summary");
            resumen.className = "event-summary";
            const punto = document.createElement("span");
            punto.className = "event-color";
            punto.setAttribute("aria-hidden", "true");
            const hora = document.createElement("span");
            hora.className = "event-time";
            hora.textContent = cita.hora || "Sin hora";
            const procedimiento = document.createElement("strong");
            procedimiento.className = "event-procedure";
            procedimiento.textContent = cita.procedimiento || "Cita veterinaria";
            resumen.append(punto, hora, procedimiento);

            const detalle = document.createElement("div");
            detalle.className = "event-details";
            [
                ["ID cita", cita.id_cita],
                ["Fecha", cita.fecha],
                ["Hora", cita.hora],
                ["Procedimiento", cita.procedimiento],
                ["Correo tutor", cita.correo_tutor],
                ["Correo veterinario", cita.correo_veterinario]
            ].forEach(([etiqueta, valor]) => {
                const campo = document.createElement("p");
                const nombre = document.createElement("strong");
                nombre.textContent = `${etiqueta}: `;
                campo.append(nombre, document.createTextNode(valor || "—"));
                detalle.appendChild(campo);
            });

            const cancelar = document.createElement("button");
            cancelar.type = "button";
            cancelar.className = "cita-cancelar-btn";
            cancelar.textContent = "Cancelar cita";
            cancelar.addEventListener("click", () => cancelarCita(cita.id_cita, cancelar));
            detalle.appendChild(cancelar);
            item.append(resumen, detalle);
            eventListEl.appendChild(item);
        });
    }

    function mostrarHorariosOcupados(date) {
        const clave = claveFecha(date);
        eventDateEl.textContent = formatoFecha.format(date);
        const ocupadas = [...new Set((citasPorFecha().get(clave) || [])
            .map(cita => String(cita.hora || "").slice(0, 5)))]
            .filter(hora => horariosAtencion.includes(hora))
            .sort();
        eventListEl.replaceChildren();
        if (!ocupadas.length) {
            limpiarEventos("No hay horarios ocupados para este día.");
            return;
        }
        const lista = document.createElement("ul");
        lista.className = "horarios-ocupados-lista";
        ocupadas.forEach(hora => {
            const item = document.createElement("li");
            item.textContent = `${hora} · Ocupado`;
            lista.appendChild(item);
        });
        eventListEl.appendChild(lista);
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
            if (vistaCliente) {
                const ocupadas = new Set((grupos.get(clave) || [])
                    .map(cita => String(cita.hora || "").slice(0, 5))
                    .filter(hora => horariosAtencion.includes(hora)));
                if (ocupadas.size === horariosAtencion.length) boton.classList.add("fully-booked");
            } else if (grupos.has(clave)) {
                boton.classList.add("has-events");
            }
            if (clave === hoy) boton.setAttribute("aria-current", "date");
            if (selectedDate && clave === claveFecha(selectedDate)) boton.setAttribute("aria-pressed", "true");
            else boton.setAttribute("aria-pressed", "false");
            boton.addEventListener("click", () => {
                selectedDate = fecha;
                currentDate = new Date(fecha.getFullYear(), fecha.getMonth(), 1);
                renderCalendar();
                if (vistaCliente) mostrarHorariosOcupados(fecha);
                else mostrarCitas(fecha);
            });
            daysEl.appendChild(boton);
        }
    }

    function cargarCitas() {
        const valores = new FormData();
        valores.append("opc", vistaCliente ? "disponibilidad" : "listar");
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
                actualizarHorariosDisponibles();
                renderCalendar();
                if (selectedDate) {
                    if (vistaCliente) mostrarHorariosOcupados(selectedDate);
                    else mostrarCitas(selectedDate);
                }
            })
            .catch(error => {
                console.error("Error al cargar citas:", error);
                limpiarEventos("Error al cargar las citas: " + error.message);
                renderCalendar();
            });
    }

    function cancelarCita(idCita, boton) {
        if (!window.confirm(`¿Deseas cancelar la cita ${idCita}? Esta acción no se puede deshacer.`)) return;

        boton.disabled = true;
        boton.textContent = "Cancelando...";
        const valores = new FormData();
        valores.append("opc", "delete");
        valores.append("id_cita", idCita);

        fetch("../Controlador/ControladorCita.php", { method: "POST", body: valores })
            .then(async respuesta => {
                const texto = await respuesta.text();
                let datos;
                try { datos = JSON.parse(texto); }
                catch { throw new Error("El servidor devolvió una respuesta inesperada."); }
                if (!respuesta.ok || !datos.success) throw new Error(datos.message || "No se pudo cancelar la cita.");
                return datos;
            })
            .then(datos => {
                citas = citas.filter(cita => String(cita.id_cita) !== String(idCita));
                actualizarHorariosDisponibles();
                renderCalendar();
                if (selectedDate) mostrarCitas(selectedDate);
                alert(datos.message || "Cita cancelada correctamente.");
            })
            .catch(error => {
                boton.disabled = false;
                boton.textContent = "Cancelar cita";
                alert(error.message || "Ocurrió un error al cancelar la cita.");
                console.error("Error al cancelar cita:", error);
            });
    }

    if (prevMonthBtn) prevMonthBtn.addEventListener("click", () => {
        currentDate = new Date(currentDate.getFullYear(), currentDate.getMonth() - 1, 1);
        selectedDate = null;
        eventDateEl.textContent = "Selecciona una fecha";
        limpiarEventos(vistaCliente ? "Selecciona un día para consultar los horarios ocupados." : "Selecciona un día para ver las citas agendadas.");
        renderCalendar();
    });
    if (nextMonthBtn) nextMonthBtn.addEventListener("click", () => {
        currentDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 1);
        selectedDate = null;
        eventDateEl.textContent = "Selecciona una fecha";
        limpiarEventos(vistaCliente ? "Selecciona un día para consultar los horarios ocupados." : "Selecciona un día para ver las citas agendadas.");
        renderCalendar();
    });
    if (todayBtn) todayBtn.addEventListener("click", () => {
        const hoy = new Date();
        currentDate = new Date(hoy.getFullYear(), hoy.getMonth(), 1);
        selectedDate = hoy;
        renderCalendar();
        if (vistaCliente) mostrarHorariosOcupados(hoy);
        else mostrarCitas(hoy);
    });

    if (modalAgregarCita && abrirModalCitaBtn) abrirModalCitaBtn.addEventListener("click", () => modalAgregarCita.showModal());
    if (fechaCitaInput) fechaCitaInput.addEventListener("change", actualizarHorariosDisponibles);
    [cerrarModalCitaBtn, cancelarModalCitaBtn].forEach(boton => {
        if (boton && modalAgregarCita) boton.addEventListener("click", () => modalAgregarCita.close());
    });
    if (modalAgregarCita) modalAgregarCita.addEventListener("click", evento => {
        if (evento.target === modalAgregarCita) modalAgregarCita.close();
    });

    if (frmAgregarCita) frmAgregarCita.addEventListener("submit", evento => {
        evento.preventDefault();
        const valores = new FormData(frmAgregarCita);
        const fechaAgendada = fechaDeCita(valores.get("fecha"));
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
                if (!datos.success) throw new Error(datos.message || "No se pudo registrar la cita.");
                if (!modalAgregarCita) {
                    alert(datos.message || "Cita agendada correctamente.");
                    window.location.href = "ConsultarCitaV.php";
                    return;
                }
                modalAgregarCita.close();
                frmAgregarCita.reset();
                if (fechaAgendada) {
                    selectedDate = fechaAgendada;
                    currentDate = new Date(fechaAgendada.getFullYear(), fechaAgendada.getMonth(), 1);
                }
                cargarCitas();
                alert(datos.message || "Cita agendada correctamente.");
            })
            .catch(error => {
                alert(error.message || "Ocurrió un error al procesar la solicitud.");
                console.error("Error al agendar cita:", error);
            });
    });

    renderCalendar();
    cargarCitas();
});
