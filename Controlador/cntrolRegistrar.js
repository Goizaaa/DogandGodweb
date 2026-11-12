document.addEventListener("DOMContentLoaded", () => {
    if (document.querySelector("#register-form")) {
        let fcuenta = document.querySelector("#register-form");

        fcuenta.addEventListener("submit", (event) => {
            event.preventDefault(); 

            let valores = new FormData(fcuenta);
            valores.append("opc", "create");

            fetch("../controlador/cntrlUsuarios.php", {
                method: "POST",
                body: valores
            })
            .then(response => {
                if (!response.ok) throw new Error("Error en la respuesta del servidor");
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    Swal.fire({ icon: "success", text: "Insertado correctamente" })
                        .then(() => {
                            localStorage.setItem("id_mascota_editar", data.id_mascota);
                            window.location.href = "consultarhis.html?id_mascota=" + data.id_mascota;
                        });
                    fcuenta.reset();
                } else {
                    Swal.fire({ icon: "error", text: "Error al insertar: " + (data.message || "Motivo desconocido") });
                }
            })
            .catch(error => {
                Swal.fire({ icon: "error", text: error.message });
            });
        });
    }
});
