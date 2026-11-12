document.addEventListener("DOMContentLoaded", () => {
    const frmConsulta = document.getElementById("frmAgregarConsulta");

    if (frmConsulta) {
        frmConsulta.addEventListener("submit", async (e) => {
            e.preventDefault();

            const formData = new FormData(frmConsulta);
            formData.append("accion", "guardar_consulta");

            try {
                const response = await fetch("../controlador/cntrolConsultaBackend.php", {
                    method: "POST",
                    body: formData
                });

                const res = await response.json();

                if (res.status === "success") {
                    Swal.fire({ icon: "success", text: "Consulta, diagnóstico y tratamiento agregados con éxito." })
                        .then(() => {
                            window.location.href = "consultarHistorial.php";
                        });
                } else {
                    Swal.fire({ icon: "error", text: "Error: " + res.message });
                }
            } catch (error) {
                console.error("Error al guardar:", error);
                Swal.fire({ icon: "error", text: "Error de conexión al procesar el registro." });
            }
        });
    }
});