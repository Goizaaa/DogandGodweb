document.addEventListener("DOMContentLoaded", () => {
    
    const tabla = document.querySelector("#tabla tbody");
    const tablaConsultas = document.querySelector("#tablaConsultas tbody");
    const tablaProcedimientos = document.querySelector("#tablaProcedimientos tbody");
    const tablaLaboratorio = document.querySelector("#tablaLaboratorio tbody");
    const tablaRadiografias = document.querySelector("#tablaRadiografias tbody");


    const urlParams = new URLSearchParams(window.location.search);
    let idMascotaURL = urlParams.get('id_mascota');

    if (idMascotaURL) {
        idMascotaURL = idMascotaURL.replace(/^"|"$/g, '').trim();
    }

    const idMascota = idMascotaURL;

    if (!idMascota || idMascota === "null" || idMascota === "undefined") {
        console.error("Error: No se encontró ningún 'id_mascota' válido.");
        alert("Error: Identificador de mascota no encontrado.");
        return; 
    }

    localStorage.setItem("id_mascota_editar", idMascota);

    const general = document.getElementById("informacionGeneral");
    const consultas = document.getElementById("consultas");
    const procedimientos = document.getElementById("procedimientos");
    const laboratorio = document.getElementById("laboratorio");
    const radiografias = document.getElementById("radiografias");

    function ocultarTodo() {
        if(general) general.style.display = "none";
        if(consultas) consultas.style.display = "none";
        if(procedimientos) procedimientos.style.display = "none";
        if(laboratorio) laboratorio.style.display = "none";
        if(radiografias) radiografias.style.display = "none";
    }

    document.getElementById("btnGeneral").onclick = function () { ocultarTodo(); general.style.display = "block"; };
    document.getElementById("btnConsultas").onclick = function () { ocultarTodo(); consultas.style.display = "block"; };
    document.getElementById("btnProcedimientos").onclick = function () { ocultarTodo(); procedimientos.style.display = "block"; };
    document.getElementById("btnLaboratorio").onclick = function () { ocultarTodo(); laboratorio.style.display = "block"; };
    document.getElementById("btnRadiografias").onclick = function () { ocultarTodo(); radiografias.style.display = "block"; };

    function llenarTabla(opc, tablaDestino) {
        if (!tablaDestino) return;

        tablaDestino.innerHTML = ""; 

        let valores = new FormData();
        valores.append("opc", opc);
        valores.append("id_mascota", idMascota); 

        fetch("../controlador/modeloHistorial.php", {
            method: "POST",
            body: valores
        })
        .then(res => {
            if (!res.ok) throw new Error("Error en la respuesta del servidor");
            return res.json();
        })
        .then(datos => {
            console.log(`Datos recibidos para [${opc}]:`, datos);

            if (!datos || datos.length === 0) {
                let fila = document.createElement("tr");
                let celda = document.createElement("td");
                celda.textContent = "No hay registros disponibles.";
                celda.colSpan = 10;
                celda.style.textAlign = "center";
                fila.appendChild(celda);
                tablaDestino.appendChild(fila);
                return;
            }

            datos.forEach(obj => {
                let fila = document.createElement("tr");
                for (let propiedad in obj) {
                    let celda = document.createElement("td");
                    celda.textContent = obj[propiedad];
                    fila.appendChild(celda);
                }
                tablaDestino.appendChild(fila);
            });
        })
        .catch(error => console.error(`Error cargando la sección ${opc}:`, error));
    }

    llenarTabla("general", tabla);
    llenarTabla("consultas", tablaConsultas);
    llenarTabla("procedimientos", tablaProcedimientos);
    llenarTabla("laboratorio", tablaLaboratorio);
    llenarTabla("radiografias", tablaRadiografias);
});
