document.addEventListener("DOMContentLoaded", () => {
    const inputHidden = document.querySelector("#id_mascota");

    // Recuperamos el ID limpio de la memoria (Ej: M268)
    const idMascota = localStorage.getItem("id_mascota_editar");

    // Forzamos la escritura en el campo hidden del HTML
    if (inputHidden && idMascota) {
        inputHidden.value = idMascota;
        console.log("ID inyectado con éxito en el campo hidden:", inputHidden.value);
    } else {
        console.error("Error: No se pudo escribir el ID en el HTML.");
    }

    const btn = document.getElementById("btnModificar");
    
    btn.addEventListener("click", (e) => {
        e.preventDefault();

let peso = document.getElementById("peso").value;
let esterilizado = document.getElementById("esterilizado").value;

let valores = new FormData();
valores.append("opc", "update");
valores.append("peso_inicial", peso);
valores.append("esterilizado", esterilizado);

valores.append("id_mascota", idMascota); 



        console.log("Enviando ID a actualizar:", idMascota);

        fetch("../Controlador/modeloHistorial.php", {
            method: "POST",
            body: valores
        })
        .then(res => res.json())
        .then(data => {
            console.log(data);
            if (data.success) {
                alert("Actualizado correctamente");
                
                window.location.href = "consultarhis.html?id_mascota=" + idMascota;
            } else {
                alert("Error al actualizar");
            }
        })
        .catch(err => {
            console.error(err);
            alert("Error en el servidor");
        });
    });
});
