Dropzone.autoDiscover = false;

const dropzone = new Dropzone("#tinydash-dropzone", {
  autoProcessQueue: false,
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
        const seenNSS = new Set();

        rows.forEach((fila, i) => {
          const filaIndex = i + 2; // por el encabezado

          const paterno = (fila.Paterno || "").trim();
          const materno = (fila.Materno || "").trim();
          const nombre = (fila.Nombre || "").trim();
          const nss = (fila.NSS || "").trim();
          const curp = (fila.CURP || "").toUpperCase().trim();
          const rfc = (fila.RFC || "").toUpperCase().trim();
          const cpFiscal = (fila.CP_Fiscal || "").toString().trim();
          const fechaAlta = (fila.Fecha_Alta || "").trim();
          const clabe = (fila.Clabe || "").toString().trim();
          const servicio = (fila.Servicio || "").trim();
          const direccion = (fila.Direccion_Inmueble || "").trim();
          const sueldo = (fila.Sueldo || "").toString().trim();
          const alergia = (fila.Alergia || "").trim();
          const foto = (fila.Foto || "").trim();

          // --- Validaciones ---
          if (!paterno || !nombre) {
            errores.push(`Fila ${filaIndex}: Nombre incompleto (Paterno o Nombre vacío)`);
          }

          if (nss && !/^\d{11}$/.test(nss)) {
            errores.push(`Fila ${filaIndex}: NSS inválido (${nss})`);
          }

          if (curp.length !== 18 || !/^[A-Z]{4}\d{6}[A-Z]{6}\d{2}$/.test(curp)) {
            errores.push(`Fila ${filaIndex}: CURP inválido (${curp})`);
          }

          if (rfc.length < 12 || rfc.length > 13) {
            errores.push(`Fila ${filaIndex}: RFC inválido (${rfc})`);
          }

          if (cpFiscal && !/^\d{5}$/.test(cpFiscal)) {
            errores.push(`Fila ${filaIndex}: Código Postal inválido (${cpFiscal})`);
          }

          if (fechaAlta && isNaN(Date.parse(fechaAlta))) {
            errores.push(`Fila ${filaIndex}: Fecha de Alta inválida (${fechaAlta})`);
          }

          if (clabe && !/^\d{18}$/.test(clabe)) {
            errores.push(`Fila ${filaIndex}: Clabe inválida (${clabe})`);
          }

          if (sueldo && isNaN(parseFloat(sueldo))) {
            errores.push(`Fila ${filaIndex}: Sueldo inválido (${sueldo})`);
          }

          // --- Duplicados ---
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

          if (nss && seenNSS.has(nss)) {
            errores.push(`Fila ${filaIndex}: NSS duplicado (${nss})`);
          } else if (nss) {
            seenNSS.add(nss);
          }

          datosValidados.push({
            paterno,
            materno,
            nombre,
            nss,
            curp,
            rfc,
            cpFiscal,
            fechaAlta,
            clabe,
            servicio,
            direccion,
            sueldo,
            alergia,
            foto,
          });
        });

        // --- DOM Elements ---
        const enviarBtn = document.getElementById("enviar");
        const countErrors = document.getElementById("countErrors");
        const errorSection = document.getElementById("errorSection");
        const notificationsContainer = document.getElementById("notificationsContainer");
        const errorTable = document.getElementById("errorTable");

        errorTable.innerHTML = "";

        if (errores.length > 0) {
          errorSection.style.display = "block";
          enviarBtn.disabled = true;
          notificationsContainer.style.display = "none";
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
          console.log("✅ Datos validados correctamente:", datosValidados);
        }
      };

      reader.readAsArrayBuffer(file);
    });
  },
});