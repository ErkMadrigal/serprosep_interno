const API_BASE_URL = window.env.API_URL + 'employees';


let inputLang = document.getElementById("inputLang"); 
// Variables globales para estado de paginación
let totalEmpleados = 0;  // mutable porque lo actualizarás después
const itemsPorPagina = inputLang.value;
let paginaActual = 1;

inputLang.onchange = () => {

  getData(1, inputLang.value);
}

const getData = async (pagina = 1, items = 5 ) => {
  paginaActual = pagina; // Actualiza la página activa global

  const reload = document.querySelector("#reload");
  const progressBar = document.querySelector("#progressBar");
  const loadingContainer = document.querySelector("#loadingContainer");

  // Mostrar barra de carga
  loadingContainer.style.display = 'block';
  progressBar.style.width = '0%';
  progressBar.setAttribute('aria-valuenow', 0);

  // Simular progreso visual
  let progreso = 0;
  const interval = setInterval(() => {
    progreso += 10;
    if (progreso <= 90) {
      progressBar.style.width = `${progreso}%`;
      progressBar.setAttribute('aria-valuenow', progreso);
    }
  }, 100);

  if (reload) {
    reload.disabled = true;
    reload.innerText = "Cargando...";
  }

  try {
    // Enviar la página y cantidad por página para paginar en backend
    const response = await fetch(API_BASE_URL, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-API-KEY': window.env.API_KEY,
        'Authorization': `Bearer ${localStorage.getItem('token')}`
      },
      body: JSON.stringify({
        action: "getEmpleados",
        pagina: paginaActual,
        limit: items
      })
    });

    if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

    const data = await response.json();

    // Actualizar contadores en el DOM
    document.querySelector("#completado").innerText = data?.completados?.empleadosTotales ?? 0;
    document.querySelector("#bajas").innerText = data?.bajas?.empleadosTotales ?? 0;
    document.querySelector("#pendeintes").innerText = data?.pendientes?.empleadosTotales ?? 0;
    document.querySelector("#total").innerText = data?.AllEmpleados?.empleadosTotales ?? 0;

    // Actualizar totalEmpleados y paginación
    totalEmpleados = data?.AllEmpleados?.empleadosTotales ?? 0;
    generarPaginacion(totalEmpleados, items, pagina);

    // Aquí deberías actualizar la tabla o listado con los empleados de la página actual
    cargarPagina(paginaActual, data.empleados || []);

  } catch (error) {
    console.error('Error fetching catalogos:', error);
  } finally {
    clearInterval(interval);
    progressBar.style.width = '100%';
    progressBar.setAttribute('aria-valuenow', 100);

    setTimeout(() => {
      loadingContainer.style.display = 'none';
      progressBar.style.width = '0%';
    }, 300);

    if (reload) {
      reload.disabled = false;
      reload.innerHTML = `<span class="fe fe-refresh-ccw fe-16 text-muted"></span>`;
    }
  }
};

document.querySelector("#reload").onclick = () => getData();

// Función para generar la paginación dinámica
function generarPaginacion(totalItems, itemsPorPagina, paginaActual) {
  const totalPaginas = Math.ceil(totalItems / itemsPorPagina);
  const ul = document.querySelector('.pagination');
  ul.innerHTML = '';

  // Botón "Previous"
  const prevLi = document.createElement('li');
  prevLi.className = 'page-item ' + (paginaActual === 1 ? 'disabled' : '');
  prevLi.innerHTML = `<a class="page-link" href="#" aria-label="Previous">&laquo;</a>`;
  prevLi.addEventListener('click', e => {
    e.preventDefault();
    if (paginaActual > 1) {
      getData(paginaActual - 1);
    }
  });
  ul.appendChild(prevLi);

  // Botones numéricos
  for(let i = 1; i <= totalPaginas; i++) {
    const li = document.createElement('li');
    li.className = 'page-item ' + (i === paginaActual ? 'active' : '');
    li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
    li.addEventListener('click', e => {
      e.preventDefault();
      if (i !== paginaActual) {
        getData(i);
      }
    });
    ul.appendChild(li);
  }

  // Botón "Next"
  const nextLi = document.createElement('li');
  nextLi.className = 'page-item ' + (paginaActual === totalPaginas ? 'disabled' : '');
  nextLi.innerHTML = `<a class="page-link" href="#" aria-label="Next">&raquo;</a>`;
  nextLi.addEventListener('click', e => {
    e.preventDefault();
    if (paginaActual < totalPaginas) {
      getData(paginaActual + 1);
    }
  });
  ul.appendChild(nextLi);
}

// Función para mostrar datos de la página actual (implementa tú la UI)
function cargarPagina(pagina, empleados) {
  console.log(`Cargar datos para página ${pagina}`, empleados);
  // Aquí actualizas tu tabla o listado con los empleados que te trae el backend
}

// Carga inicial
getData();
