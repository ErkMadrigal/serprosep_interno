Dropzone.autoDiscover = false;

const dropzone = new Dropzone("#tinydash-dropzone", {
  autoProcessQueue: false, // No sube el archivo al servidor automáticamente
  acceptedFiles: ".xlsx,.xls",
  maxFiles: 1,
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

        const seenCURPs = new Set();
        const seenRFCs = new Set();

        rows.forEach((fila, i) => {
          const filaIndex = i + 2;
          const curp = (fila.CURP || "").toUpperCase().trim();
          const rfc = (fila.RFC || "").toUpperCase().trim();
          const nombre = (fila.Nombre || "").trim();

          if (curp.length !== 18 || !/^[A-Z]{4}\d{6}[A-Z]{6}\d{2}$/.test(curp)) {
            errores.push(`Fila ${filaIndex}: CURP inválido (${curp})`);
          }

          if (rfc.length < 12 || rfc.length > 13) {
            errores.push(`Fila ${filaIndex}: RFC inválido (${rfc})`);
          }

          if (seenCURPs.has(curp)) {
            errores.push(`Fila ${filaIndex}: CURP duplicado (${curp})`);
          } else {
            seenCURPs.add(curp);
          }

          if (seenRFCs.has(rfc)) {
            errores.push(`Fila ${filaIndex}: RFC duplicado (${rfc})`);
          } else {
            seenRFCs.add(rfc);
          }

          datosValidados.push({ curp, rfc, nombre });
        });

        const enviarBtn = document.getElementById("enviar");
        const countErrors = document.getElementById("countErrors");
        const errorSection = document.getElementById("errorSection");
        const notificationsContainer = document.getElementById("notificationsContainer");
        const errorTable = document.getElementById("errorTable");

        errorTable.innerHTML = "";

        if (errores.length > 0) {
          errorSection.style.display = "block";
          enviarBtn.disabled = true;
          countErrors.textContent = ` ${errores.length} `;

          errores.forEach((error) => {
            const filaMatch = error.match(/Fila (\d+):/);
            const filaNum = filaMatch ? filaMatch[1] : "—";
            const mensaje = error.split(": ").slice(1).join(": ");

            const row = document.createElement("tr");
            row.innerHTML = `<td>${filaNum}</td><td>${mensaje}</td>`;
            errorTable.appendChild(row);
          });
        } else {
          notificationsContainer.style.display = "block";
          enviarBtn.disabled = false;
          errorSection.style.display = "none";
          console.log("Datos validados:", datosValidados);
        }
      };

      reader.readAsArrayBuffer(file);
    });
  }
});
