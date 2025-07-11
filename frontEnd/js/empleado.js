(async () => {

    const API_BASE_URL = window.env.API_URL + 'employees';

    const path = window.location.pathname; // "/serprosep_interno/frontEnd/empleado/5112"
    const partes = path.split("/"); // ["", "serprosep_interno", "frontEnd", "empleado", "5112"]
    const id = partes[partes.length - 1]; // último elemento


    let nombreCompleto = document.querySelector("#nombreCompleto")
    let puestoElemento = document.querySelector("#puestoElemento")
    let CURP = document.querySelector("#CURP")
    let RFC = document.querySelector("#RFC")
    let NSS = document.querySelector("#NSS")

    let nombre = document.querySelector("#nombre")
    let paterno = document.querySelector("#paterno")
    let materno = document.querySelector("#materno")
    let curp = document.querySelector("#curp")
    let rfc = document.querySelector("#rfc")
    let nss = document.querySelector("#nss")
    let cp = document.querySelector("#cp")

    let empresa = document.querySelector("#empresa")
    let unidadNegocio = document.querySelector("#unidadNegocio")
    let regional = document.querySelector("#regional")
    let zona = document.querySelector("#zona")
    let servicioId = document.querySelector("#servicioId")
    let turno = document.querySelector("#turno")
    let puesto = document.querySelector("#puesto")
    let periocidad = document.querySelector("#periocidad")
    let sueldo = document.querySelector("#sueldo")

    let cuenta = document.querySelector("#cuenta")
    let interbancaria = document.querySelector("#interbancaria")
    let banco = document.querySelector("#banco")
    let institucionBancaria = document.querySelector("#institucionBancaria")

    let data_json = {
        "action": "getEmpleado",
        "id_empleado": id
    }

     try {
        const response = await fetch(API_BASE_URL, {
            method: 'POST',
            headers: {
            'Content-Type': 'application/json',
            'X-API-KEY': window.env.API_KEY,
            'Authorization': `Bearer ${localStorage.getItem('token')}`
            },
            body: JSON.stringify(data_json)
        });

        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

        const data = await response.json();

        let usr = data.data

        console.log(usr)
        nombreCompleto.innerText = usr.nombreCompleto
        puestoElemento.innerText = usr.puesto ? usr.puesto : '' 
        CURP.innerText = "CURP " + usr.curp ? usr.curp : '' 
        RFC.innerText = "RFC " + usr.rfc ? usr.rfc : ''
        NSS.innerText = "NSS " + usr.nss ? usr.nss : ''

        nombre.value = usr.nombre
        paterno.value = usr.paterno
        materno.value = usr.materno
        curp.value = usr.curp
        rfc.value = usr.rfc
        nss.value = usr.nss
        cp.value = usr.CP_fiscal

        document.querySelector("#trabajo-tab").onclick = () => {
            empresa.value = usr.id_empresa ? usr.id_empresa: ''
            unidadNegocio.value = usr.id_unidad_negocio ? usr.id_unidad_negocio: ''
            regional.value = usr.id_regional ? usr.id_regional: ''
            zona.value = usr.id_zona ? usr.id_zona: ''
            servicioId.value = usr.id_servicio ? usr.id_servicio: ''
            turno.value = usr.id_turno ? usr.id_turno: ''
            puesto.value = usr.id_puesto ? usr.id_puesto: ''
            periocidad.value = usr.id_periocidad ? usr.id_periocidad: ''
            sueldo.value = usr.sueldo ? usr.sueldo: ''

        }

        document.querySelector("#banco-tab").onclick = () => {
            interbancaria.value = usr.clave_interbancaria ? usr.clave_interbancaria : ''
            cuenta.value = usr.cuenta ? usr.cuenta : ''
            banco.value = usr.id_banco ? usr.id_banco : ''
            institucionBancaria.value = usr.institucionBancaria ? usr.institucionBancaria : ''
        }



    } catch (error) {
        console.error('Error al obtener datos:', error);
    }
})();