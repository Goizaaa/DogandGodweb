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
                    alert("Consulta, diagnóstico y tratamiento agregados con éxito.");
                    window.location.href = "consultarHistorial.php";
                } else {
                    alert("Error: " + res.message);
                }
            } catch (error) {
                console.error("Error al guardar:", error);
                alert("Error de conexión al procesar el registro.");
            }
        });
    }
});