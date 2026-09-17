document.addEventListener("DOMContentLoaded",()=>{

    const tbody = document.querySelector("#tabla tbody");  // Cambia a tbody
    const btnBuscar = document.querySelector("#btnBuscar");
    const buscarMascota = document.querySelector("#buscarMascota");
    const buscarTutor = document.querySelector("#buscarTutor");

    function cargarHistoriales() {
        let valores = new FormData();
        valores.append("opc", "buscar");
        
        if(buscarMascota && buscarMascota.value.trim() !== "") {
            valores.append("nom_mascota", buscarMascota.value.trim());
        }
        if(buscarTutor && buscarTutor.value.trim() !== "") {
            valores.append("nom_tutor", buscarTutor.value.trim());
        }

        fetch("../Controlador/modeloHistorial.php", {
            method: "POST",
            body: valores
        })
        .then(res => res.json())
        .then(datos => {
            if(tbody) {
                tbody.innerHTML = "";   
            }

            if(datos.length === 0) {
                let fila = document.createElement("tr");
                let celda = document.createElement("td");
                celda.textContent = "No se encontraron resultados";
                celda.colSpan = 9;
                celda.style.textAlign = "center";
                fila.appendChild(celda);
                tbody.appendChild(fila);
                return;
            }

            datos.forEach(obj => {
                let fila = document.createElement("tr");

                for(let propiedad in obj) {
                    let celda = document.createElement("td");
                    celda.textContent = obj[propiedad];
                    fila.appendChild(celda);
                }

                // Botón para ver historial completo
                let celdaBoton = document.createElement("td");
                let btnVer = document.createElement("button");
                btnVer.textContent = "Ver Historial";
                btnVer.style.backgroundColor = "#0ca4d4";
                btnVer.style.color = "white";
                btnVer.style.border = "none";
                btnVer.style.padding = "5px 10px";
                btnVer.style.borderRadius = "4px";
                btnVer.style.cursor = "pointer";
                btnVer.onclick = function() {
                    localStorage.setItem("id_mascota_editar", obj.id_mascota);
                    window.location.href = "consultarhis.php?id_mascota=" + obj.id_mascota;
                };
                celdaBoton.appendChild(btnVer);
                fila.appendChild(celdaBoton);
                
                tbody.appendChild(fila);
            });
        })
        .catch(error => {
            console.error("Error:", error);
            let fila = document.createElement("tr");
            let celda = document.createElement("td");
            celda.textContent = "Error al cargar los datos";
            celda.colSpan = 9;
            celda.style.textAlign = "center";
            fila.appendChild(celda);
            tbody.appendChild(fila);
        });
    }

    if(btnBuscar) {
        btnBuscar.addEventListener("click", cargarHistoriales);
    }

    // Cargar todos al inicio
    cargarHistoriales();
});