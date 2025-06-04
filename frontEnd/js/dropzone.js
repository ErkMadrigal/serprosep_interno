Dropzone.autoDiscover = false;

let datosValidados = [];

const dropzone = new Dropzone("#tinydash-dropzone", {
  url: "#", // No se envía automáticamente
  autoProcessQueue: false,
  acceptedFiles: ".xlsx",
  init: function () {
    this.on("addedfile", function (file) {
      const reader = new FileReader();

      reader.onload = function (e) {
        const data = new Uint8Array(e.target.result);
        const workbook = XLSX.read(data, { type: "array" });
        const sheet = workbook.Sheets[workbook.SheetNames[0]];
        const rows = XLSX.utils.sheet_to_json(sheet);

        let errores = [];
        datosValidados = [];

        rows.forEach((fila, i) => {
          const filaIndex = i + 2;
          const curp = (fila.CURP || "").trim();
          const rfc = (fila.RFC || "").trim();
          const nombre = (fila.Nombre || "").trim();

          if (curp.length !== 18) {
            errores.push(`Fila ${filaIndex}: CURP inválido (${curp})`);
          }

          if (rfc.length < 12 || rfc.length > 13) {
            errores.push(`Fila ${filaIndex}: RFC inválido (${rfc})`);
          }

          datosValidados.push({ curp, rfc, nombre });
        });

        const errorDiv = document.getElementById("errores");
        const enviarBtn = document.getElementById("enviar");

        if (errores.length > 0) {
          errorDiv.innerHTML = errores.map(e => `<p>${e}</p>`).join("");
          enviarBtn.disabled = true;
        } else {
          errorDiv.innerHTML = "<p class='text-success'>Datos correctos. Listo para enviar.</p>";
          enviarBtn.disabled = false;
        }
      };

      reader.readAsArrayBuffer(file);
    });
  }
});

document.getElementById("enviar").addEventListener("click", () => {
  fetch("backend.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(datosValidados)
  })
    .then(res => res.json())
    .then(data => {
      alert(data.message || "Todo cargado correctamente.");
    })
    .catch(err => alert("Error al enviar: " + err));
});
