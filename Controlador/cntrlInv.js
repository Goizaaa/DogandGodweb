console.log("¡CÓDIGO NUEVO CARGADO!");

document.addEventListener("DOMContentLoaded", () => {

    const tbody = document.querySelector("#tabla-inventario tbody");
    const btnBuscar = document.querySelector("#boton-buscar");
    const buscarProducto = document.querySelector("#BusProducto");

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

    // Cargar la lista al iniciar
    cargarInventario();
});