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

        function safe(value) {
          if (value === undefined || value === null) return "";
          return String(value).trim();
        }

        rows.forEach((fila, i) => {
          const filaIndex = i + 2; // por el encabezado

          const paterno = safe(fila.Paterno);
          const materno = safe(fila.Materno);
          const nombre = safe(fila.Nombre);
          const nss = safe(fila.NSS);
          const curp = safe(fila.CURP).toUpperCase();
          const rfc = safe(fila.RFC).toUpperCase();
          const cp = safe(fila.CP_Fiscal);
          const fechaAlta = safe(fila.Fecha_Alta);
          const interbancaria = safe(fila.Clabe);
          const sueldo = safe(fila.Sueldo);
          const alergia = safe(fila.Alergia);
          const fotos = safe(fila.Foto);

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

          if (cp && !/^\d{5}$/.test(cp)) {
            errores.push(`Fila ${filaIndex}: Código Postal inválido (${cp})`);
          }

          if (fechaAlta && isNaN(Date.parse(fechaAlta))) {
            errores.push(`Fila ${filaIndex}: Fecha de Alta inválida (${fechaAlta})`);
          }

          if (interbancaria && !/^\d{18}$/.test(interbancaria)) {
            errores.push(`Fila ${filaIndex}: Clabe interbancaria inválida (${interbancaria})`);
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
            cp,
            fechaAlta,
            interbancaria,
            sueldo,
            alergia,
            fotos,
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

            const dropzone = document.getElementById("tinydash-dropzone");
            const overlay = document.getElementById("loadingOverlay");

            dropzone.classList.add("success");

            // Mostrar overlay mientras se procesan los fetch
            overlay.style.display = "flex";

            let completados = 0;

            datosValidados.forEach((value, index) => {
              const API_BASE_URL = window.env.API_URL + 'employees';

              value.action = "empleados",

              fetch(API_BASE_URL, {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/json',
                  'X-API-KEY': window.env.API_KEY,
                  'Authorization': `Bearer ${localStorage.getItem('token')}`
                },
                body: JSON.stringify(value)
              })
                .then(response => {
                  if (!response.ok) throw new Error('Error en la respuesta del servidor');
                  return response.json();
                })
                .then(result => {
                  
                  if (result.status === "error") throw new Error(result.mensaje || 'Error al agregar empleado');

                  console.log('Empleado agregado:', result);
                  Toast.fire({
                    icon: "success",
                    title: result.mensaje || "Empleado agregado correctamente"
                  });
                })
                .catch(error => {
                  console.error('Error en el fetch:', error);
                  Toast.fire({
                    icon: "error",
                    title: error.message
                  });
                })
                .finally(() => {
                  completados++;
                  // Cuando termine el último fetch, ocultamos el overlay
                  if (completados === datosValidados.length) {
                    overlay.style.display = "none";
                  }
                });
            });



        }
      };

      reader.readAsArrayBuffer(file);
    });
  },
});


function resetDropzone() {
  const dropzoneElement = document.getElementById("tinydash-dropzone");
  const notificationsContainer = document.getElementById("notificationsContainer");

  dropzoneElement.classList.remove("success");
  notificationsContainer.style.display = "none";

}

document.getElementById("recetear").addEventListener("click", function() {
  dropzone.removeAllFiles(true);  
  resetDropzone();
});