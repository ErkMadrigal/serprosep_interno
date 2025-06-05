Dropzone.autoDiscover = false;

let datosValidados = [];

const dropzone = new Dropzone("#tinydash-dropzone", {
  url: "#", // No se envía automáticamente
  autoProcessQueue: false,
  acceptedFiles: ".xlsx",
  addRemoveLinks: true,
  dictRemoveFile: "Eliminar",

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
          console.log(fila)
          if (curp.length !== 18 || !/^[A-Z]{4}\d{6}[A-Z]{6}\d{2}$/.test(curp)) {
            errores.push(`Fila ${filaIndex}: CURP inválido (${curp})`);
          }

          if (rfc.length < 12 || rfc.length > 13) {
            errores.push(`Fila ${filaIndex}: RFC inválido (${rfc})`);
          }

          datosValidados.push({ curp, rfc, nombre });
        });

        const enviarBtn = document.getElementById("enviar");
        const countErrors = document.getElementById("countErrors");
        const errorSection = document.getElementById("errorSection");
        const notificationsContainer = document.getElementById("notificationsContainer");

        if (errores.length > 0) {
            errorSection.style.display = "block";
            enviarBtn.disabled = true;
            countErrors.textContent = ` ${errores.length} `;
            const errorTable = document.getElementById("errorTable");
            errorTable.innerHTML = ""; // Limpiar errores anteriores

            errores.forEach((error) => {
              const filaMatch = error.match(/Fila (\d+):/);
              const filaNum = filaMatch ? filaMatch[1] : "—";
              const mensaje = error.split(": ").slice(1).join(": ");

              const row = document.createElement("tr");
              row.innerHTML = `<td>${filaNum}</td><td>${mensaje}</td>`;
              errorTable.appendChild(row);
            });
        } else {
          console.log("Datos validados:", datosValidados);
          notificationsContainer.style.display = "block";
          enviarBtn.disabled = false;
          errores.length = []
          document.getElementById("errorTable").innerHTML = "";
        }
      };

      reader.readAsArrayBuffer(file);
    });
    this.on("removedfile", function (file) {
      console.log("Archivo eliminado:", file.name);
      datosValidados = [];
      errorSection.style.display = "none";

      document.getElementById("enviar").disabled = true;
    });
  }
});

// document.getElementById("enviar").addEventListener("click", () => {
//   fetch("backend.php", {
//     method: "POST",
//     headers: { "Content-Type": "application/json" },
//     body: JSON.stringify(datosValidados)
//   })
//     .then(res => res.json())
//     .then(data => {
//       alert(data.message || "Todo cargado correctamente.");
//     })
//     .catch(err => alert("Error al enviar: " + err));
// });
