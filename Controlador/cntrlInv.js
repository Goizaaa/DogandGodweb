console.log("¡CÓDIGO NUEVO CARGADO!");

document.addEventListener("DOMContentLoaded", () => {

    const tbody = document.querySelector("#tabla-inventario tbody");
    const btnBuscar = document.querySelector("#boton-buscar");
    const buscarProducto = document.querySelector("#BusProducto");
    const modalEditarProducto = document.querySelector("#modal-editar-producto");
    const btnAbrirEdicion = document.querySelector("#abrir-modal-editar-producto");
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
                celda.colSpan = 6;
                celda.style.textAlign = "center";
                fila.appendChild(celda);
                tbody.appendChild(fila);
                return;
            }

            datos.forEach(obj => {
                let fila = document.createElement("tr");

                for (let propiedad in obj) {
                    let celda = document.createElement("td");
                    celda.textContent = obj[propiedad];
                    fila.appendChild(celda);
                }
                
                tbody.appendChild(fila);
            });
        })
        .catch(error => {
            console.error("Error:", error);
            if (tbody) {
                tbody.innerHTML = `<tr><td colspan="6" style="text-align:center;">Error al cargar los datos</td></tr>`;
            }
        });
    }

    if (btnBuscar) {
        btnBuscar.addEventListener("click", cargarInventario);
    }

    if (btnAbrirEdicion && modalEditarProducto) {
        btnAbrirEdicion.addEventListener("click", () => modalEditarProducto.showModal());
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