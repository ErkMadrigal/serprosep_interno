const searchModal = new bootstrap.Modal(document.getElementById('searchModal'));
let buscador = document.getElementById('buscador');
const results = document.getElementById("searchResults");

const datos = [
    { nombre: "Configuración general", ruta: "configuracion" },
    { nombre: "Usuarios", ruta: "usuarios" },
    { nombre: "Panel de control", ruta: "dashboard" },
    { nombre: "Reportes", ruta: "reportes" },
    { nombre: "Preferencias del sistema", ruta: "preferencias" },
   
    {nombre : 'empleados', ruta: 'empleados'},
    {nombre : 'home', ruta: 'home'},
    {nombre : 'nuevo empleado', ruta: 'nuevo-empleado'},
    {nombre : 'importaciones', ruta: 'importaciones'},
    {nombre : 'carga masiva empleados', ruta: 'carga-masiva-empleados'},
    {nombre : 'configuraciones', ruta: 'configuraciones'},
    {nombre : 'actividades', ruta: 'actividades'},
  ];

  

function openSearch() {
    searchModal.show();

    setInterval(() => buscador.focus(), 200);
}

// Ctrl + K para abrir
document.addEventListener("keydown", (e) => {
    if (e.ctrlKey && e.key.toLowerCase() === "k") {
        e.preventDefault();
        openSearch();
    }
    if (e.key === "Escape") {
        closeSearch();
    }
});

  buscador.addEventListener("input", () => {
    const query = buscador.value.toLowerCase();
    results.innerHTML = "";

    const filtrados = datos.filter(d => d.nombre.toLowerCase().includes(query));

    if (filtrados.length === 0) {
      results.innerHTML = `<div class="text-muted px-2">Sin resultados...</div>`;
      return;
    }

    filtrados.forEach(item => {
      const div = document.createElement("a");
      div.className = "list-group-item list-group-item-action modal-search-result";
      div.textContent = item.nombre;
      div.href = item.ruta;
      div.onclick = () => closeSearch();
      results.appendChild(div);
    });
  });

  

  document.querySelector('#logout').onclick = () => {
    document.cookie = "jwt=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    localStorage.removeItem('token');
    localStorage.removeItem('user');
}
  
window.env = {
  API_URL: "http://localhost/serprosep_interno/API/",
  API_KEY: "k8sd7f9a2v1b4mzqp0xlj5ngtu3wrceh"
};