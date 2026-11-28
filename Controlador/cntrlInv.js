console.log("¡CÓDIGO NUEVO CARGADO!");

document.addEventListener("DOMContentLoaded", () => {

    const tbody = document.querySelector("#tabla-inventario tbody");
    const btnBuscar = document.querySelector("#boton-buscar");
    const buscarProducto = document.querySelector("#BusProducto");
    const modalEditarProducto = document.querySelector("#modal-editar-producto");
    const formularioEditarProducto = document.querySelector("#form-editar-producto");
    const btnCerrarEdicion = document.querySelector("#cerrar-modal-editar-producto");
    const btnCancelarEdicion = document.querySelector("#cancelar-modal-editar-producto");
    const modalAgregarProducto = document.querySelector("#modal-agregar-producto");
    const btnAbrirAgregar = document.querySelector("#abrir-modal-agregar-producto");
    const btnCerrarAgregar = document.querySelector("#cerrar-modal-agregar-producto");
    const btnCancelarAgregar = document.querySelector("#cancelar-modal-agregar-producto");

    function cargarInventario(e) {
        if (e) e.preventDefault(); // Evita recargar la página

        let valores = new FormData();
        valores.append("opc", "buscar");
        
        if (buscarProducto && buscarProducto.value.trim() !== "") {
            valores.append("nom_producto", buscarProducto.value.trim());
        }

        // Asegúrate de que esta ruta sea correcta según la estructura de tu proyecto
        fetch("../Modelo/modeloInventario.php", {
            method: "POST",
            body: valores
        })
        .then(res => res.json())
        .then(datos => {
            if (tbody) {
                tbody.innerHTML = "";   
            }

            if (!datos || datos.length === 0) {
                let fila = document.createElement("tr");
                let celda = document.createElement("td");
                celda.textContent = "No se encontraron resultados";
                celda.colSpan = 7;
                celda.style.textAlign = "center";
                fila.appendChild(celda);
                tbody.appendChild(fila);
                return;
            }

            datos.forEach(obj => {
                let fila = document.createElement("tr");

                ["id_producto", "nom_producto", "precio_prod", "marca_prod", "stock_prod", "costo_prod"].forEach(propiedad => {
                    let celda = document.createElement("td");
                    celda.textContent = obj[propiedad];
                    fila.appendChild(celda);

                });

                const celdaAcciones = document.createElement("td");
                celdaAcciones.className = "inventario-acciones-fila";
                const btnEditarFila = document.createElement("button");
                btnEditarFila.type = "button";
                btnEditarFila.className = "inventario-accion inventario-accion-editar";
                btnEditarFila.dataset.accion = "editar";
                btnEditarFila.textContent = "Editar";
                btnEditarFila.setAttribute("aria-label", `Editar ${obj.nom_producto}`);

                const btnEliminarFila = document.createElement("button");
                btnEliminarFila.type = "button";
                btnEliminarFila.className = "inventario-accion inventario-accion-eliminar";
                btnEliminarFila.dataset.accion = "eliminar";
                btnEliminarFila.textContent = "Eliminar";
                btnEliminarFila.setAttribute("aria-label", `Eliminar ${obj.nom_producto}`);

                celdaAcciones.append(btnEditarFila, btnEliminarFila);
                fila.appendChild(celdaAcciones);
                fila.dataset.producto = JSON.stringify(obj);
                
                tbody.appendChild(fila);
            });
        })
        .catch(error => {
            console.error("Error:", error);
            if (tbody) {
                tbody.innerHTML = `<tr><td colspan="7" style="text-align:center;">Error al cargar los datos</td></tr>`;
            }
        });
    }

    if (btnBuscar) {
        btnBuscar.addEventListener("click", cargarInventario);
    }

    [btnCerrarEdicion, btnCancelarEdicion].forEach(boton => {
        if (boton && modalEditarProducto) {
            boton.addEventListener("click", () => modalEditarProducto.close());
        }
    });

    if (modalEditarProducto) {
        modalEditarProducto.addEventListener("click", evento => {
            if (evento.target === modalEditarProducto) modalEditarProducto.close();
        });
    }

    const mostrarAviso = (icon, title, text) => {
        if (window.Swal) return Swal.fire({ icon, title, text });
        window.alert(text);
    };

    tbody?.addEventListener("click", async evento => {
        const boton = evento.target.closest("button[data-accion]");
        if (!boton) return;
        const fila = boton.closest("tr");
        if (!fila) return;
        const producto = JSON.parse(fila.dataset.producto || "{}");

        if (boton.dataset.accion === "editar") {
            formularioEditarProducto.elements.id_producto.value = producto.id_producto || "";
            formularioEditarProducto.elements.NewProducto.value = producto.nom_producto || "";
            formularioEditarProducto.elements.NewCategoria.value = producto.categoria_prod || "";
            formularioEditarProducto.elements.NewPrecio.value = producto.precio_prod || "";
            formularioEditarProducto.elements.NewMarca.value = producto.marca_prod || "";
            formularioEditarProducto.elements.NewCantidad.value = producto.stock_prod || "0";
            formularioEditarProducto.elements.NewCosto.value = producto.costo_prod || "0";
            modalEditarProducto.showModal();
            return;
        }

        let confirmado = false;
        if (window.Swal) {
            const resultado = await Swal.fire({
                icon: "warning",
                title: "¿Eliminar producto?",
                text: `Se eliminará ${producto.nom_producto}.`,
                showCancelButton: true,
                confirmButtonText: "Eliminar",
                cancelButtonText: "Cancelar",
                confirmButtonColor: "#b63d52"
            });
            confirmado = resultado.isConfirmed;
        } else {
            confirmado = window.confirm(`¿Eliminar ${producto.nom_producto}?`);
        }
        if (!confirmado) return;

        const valores = new FormData();
        valores.append("opc", "eliminar");
        valores.append("id_producto", producto.id_producto);
        try {
            const respuesta = await fetch("../Modelo/modeloInventario.php", { method: "POST", body: valores });
            const resultado = await respuesta.json();
            if (resultado.status !== "success") throw new Error(resultado.message || "No se pudo eliminar el producto.");
            await mostrarAviso("success", "Producto eliminado", resultado.message);
            cargarInventario();
        } catch (error) {
            mostrarAviso("error", "No se pudo eliminar", error.message || "Ocurrió un error al eliminar el producto.");
        }
    });

    formularioEditarProducto?.addEventListener("submit", async evento => {
        evento.preventDefault();
        if (!formularioEditarProducto.reportValidity()) return;
        const valores = new FormData(formularioEditarProducto);
        valores.append("opc", "editar");
        const botonGuardar = formularioEditarProducto.querySelector(".tabla-modal-guardar");
        botonGuardar.disabled = true;
        try {
            const respuesta = await fetch("../Modelo/modeloInventario.php", { method: "POST", body: valores });
            const resultado = await respuesta.json();
            if (resultado.status !== "success") throw new Error(resultado.message || "No se pudo actualizar el producto.");
            modalEditarProducto.close();
            await mostrarAviso("success", "Cambios guardados", resultado.message);
            cargarInventario();
        } catch (error) {
            mostrarAviso("error", "No se pudo guardar", error.message || "Ocurrió un error al actualizar el producto.");
        } finally {
            botonGuardar.disabled = false;
        }
    });

    if (btnAbrirAgregar && modalAgregarProducto) {
        btnAbrirAgregar.addEventListener("click", () => modalAgregarProducto.showModal());
    }

    [btnCerrarAgregar, btnCancelarAgregar].forEach(boton => {
        if (boton && modalAgregarProducto) {
            boton.addEventListener("click", () => modalAgregarProducto.close());
        }
    });

    if (modalAgregarProducto) {
        modalAgregarProducto.addEventListener("click", evento => {
            if (evento.target === modalAgregarProducto) modalAgregarProducto.close();
        });
    }

    // Cargar la lista al iniciar
    cargarInventario();
});
