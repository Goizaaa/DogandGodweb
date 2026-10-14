(() => {
    const iniciarPaginacion = () => {
        document.querySelectorAll("table").forEach(tabla => {
            if (tabla.dataset.paginacionInicializada === "true" || !tabla.tBodies.length) return;
            tabla.dataset.paginacionInicializada = "true";
            tabla.classList.add("tabla-datos");

            let contenedor = tabla.closest(".tabla-contenedor");
            if (!contenedor) {
                contenedor = document.createElement("div");
                contenedor.className = "tabla-contenedor";
                tabla.parentNode.insertBefore(contenedor, tabla);
                contenedor.appendChild(tabla);
            }

            const paginacion = document.createElement("nav");
            paginacion.className = "tabla-paginacion";
            paginacion.setAttribute("aria-label", "Paginación de la tabla");

            const selectorGrupo = document.createElement("label");
            selectorGrupo.className = "tabla-paginacion-tamano";
            selectorGrupo.append(document.createTextNode("Filas por página"));

            const selector = document.createElement("select");
            selector.setAttribute("aria-label", "Filas por página");
            [10, 30, 50, 100, "all"].forEach(cantidad => {
                const opcion = document.createElement("option");
                opcion.value = cantidad;
                opcion.textContent = cantidad === "all" ? "Todos" : String(cantidad);
                if (cantidad === 30) opcion.selected = true;
                selector.appendChild(opcion);
            });
            selectorGrupo.appendChild(selector);

            const resumen = document.createElement("span");
            resumen.className = "tabla-paginacion-resumen";
            resumen.setAttribute("aria-live", "polite");

            const navegacion = document.createElement("div");
            navegacion.className = "tabla-paginacion-controles";

            const anterior = document.createElement("button");
            anterior.type = "button";
            anterior.className = "tabla-paginacion-boton";
            anterior.textContent = "Anterior";

            const paginaActual = document.createElement("span");
            paginaActual.className = "tabla-paginacion-pagina";
            paginaActual.setAttribute("aria-live", "polite");

            const siguiente = document.createElement("button");
            siguiente.type = "button";
            siguiente.className = "tabla-paginacion-boton";
            siguiente.textContent = "Siguiente";

            navegacion.append(anterior, paginaActual, siguiente);
            paginacion.append(selectorGrupo, resumen, navegacion);
            contenedor.insertAdjacentElement("afterend", paginacion);

            let pagina = 1;
            let actualizando = false;

            const filasDeDatos = () => Array.from(tabla.tBodies)
                .flatMap(cuerpo => Array.from(cuerpo.rows))
                .filter(fila => {
                    const unicaCelda = fila.cells.length === 1 ? fila.cells[0] : null;
                    return !(unicaCelda && unicaCelda.colSpan > 1);
                });

            const renderizar = () => {
                actualizando = true;
                const filas = filasDeDatos();
                const tamano = selector.value === "all" ? Math.max(filas.length, 1) : Number(selector.value);
                const paginas = Math.max(1, Math.ceil(filas.length / tamano));
                pagina = Math.min(pagina, paginas);
                const inicio = filas.length ? (pagina - 1) * tamano : 0;
                const fin = Math.min(inicio + tamano, filas.length);

                filas.forEach((fila, indice) => {
                    fila.hidden = indice < inicio || indice >= fin;
                });

                resumen.textContent = filas.length ? `Mostrando ${inicio + 1}–${fin} de ${filas.length}` : "0 registros";
                paginaActual.textContent = `Página ${pagina} de ${paginas}`;
                anterior.disabled = pagina <= 1;
                siguiente.disabled = pagina >= paginas;
                selector.disabled = filas.length === 0;
                actualizando = false;
            };

            selector.addEventListener("change", () => {
                pagina = 1;
                renderizar();
            });
            anterior.addEventListener("click", () => {
                if (pagina > 1) {
                    pagina -= 1;
                    renderizar();
                }
            });
            siguiente.addEventListener("click", () => {
                pagina += 1;
                renderizar();
            });

            let framePendiente = false;
            const observer = new MutationObserver(() => {
                if (actualizando || framePendiente) return;
                framePendiente = true;
                requestAnimationFrame(() => {
                    framePendiente = false;
                    renderizar();
                });
            });
            Array.from(tabla.tBodies).forEach(cuerpo => observer.observe(cuerpo, { childList: true }));
            renderizar();
        });
    };

    if (document.readyState === "loading") document.addEventListener("DOMContentLoaded", iniciarPaginacion);
    else iniciarPaginacion();
})();
