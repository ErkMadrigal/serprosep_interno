
<?php

    include './components/_root.php'; 
    include './jwt/verify_jwt.php';
    
    $ruta = './views/';


    
    $publicas = ['auth', 'index', 'login']; // rutas sin protección

    $url = (isset($_GET['dir'])) ? $_GET['dir'] : 'index';
    if (!in_array($url, $publicas)) {
        // var_dump($_COOKIE['jwt']);
        // Verificar si el token JWT está presente y es válido
        $direcition = $root.'login';
        if (!isset($_COOKIE['jwt']) || !verificarToken($_COOKIE['jwt'])) {
            
            header("Location: $direcition");
            exit;
        }
    }


    switch ($url) {
      
        case 'auth':
        case 'login':
        case 'index':
            $title = "auth";
            include "$ruta/auth/auth.php";
            
        break;

        case 'home':
            $title = "Home";
            $links = [];
            include "./components/header.php";
            include "./components/menu.php";
            include "$ruta/home/home.php";
            $scripts = [];
            include "./components/footer.php";
        break;

        case 'empleados':
            $title = "Empleados";
            $links = ['css/select2.css', 'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css'];
            include "./components/header.php";
            include "./components/menu.php";
            include "$ruta/empleados/empleados.php";
            $scripts = ['https://cdn.jsdelivr.net/npm/flatpickr', 'https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js', 'js/jquery.mask.min.js','js/select2.min.js', 'js/table-users.js', 'js/getUsers.js', 'js/filtros.js'];
            include "./components/footer.php";
        break;

        case 'empleado':
            $title = "Empleado";
            $links = [];
            include "./components/header.php";
            include "./components/menu.php";
            include "$ruta/empleados/empleado.php";
            $scripts = [ 'js/getCatalogos.js', 'js/empleado.js'];
            include "./components/footer.php";
        break;

        case 'nuevo-empleado':
            $title = "Nuevo Empleado";
            $links = ['css/select2.css'];
            include "./components/header.php";
            include "./components/menu.php";
            include "$ruta/empleados/nuevo-empleado.php";
            $scripts = ['js/jquery.mask.min.js','js/select2.min.js', 'js/nuevo-empleado.js', 'js/getCatalogos.js'];
            include "./components/footer.php";
        break;

        case 'importaciones':
            $title = "Importaciones";
            $links = [];
            include "./components/header.php";
            include "./components/menu.php";
            include "$ruta/imports/importaciones.php";
            $scripts = [];
            include "./components/footer.php";
        break;

        case 'editarUsuarios':
            $title = "Editar Usuarios";
            $links = [];
            include "./components/header.php";
            include "./components/menu.php";
            include "$ruta/imports/editarUsuarios.php";
            $scripts = ['js/edicionMasiva.js'];
            include "./components/footer.php";
        break;

        case 'carga-masiva-empleados':
            $title = "Carga Masiva Empleados";
            $links = ["css/dropzone.min.css"];
            include "./components/header.php";
            include "./components/menu.php";
            include "$ruta/imports/carga-masiva-empleados.php";
            $scripts = ['js/dropzone.min.js', 'js/xlsx.full.min.js', 'js/dropzone.js'];
            include "./components/footer.php";
        break;

        case 'configuraciones':
            $title = "configuraciones";
            $links = [];
            include "./components/header.php";
            include "./components/menu.php";
            include "$ruta/conf/configuraciones.php";
            $scripts = [];
            include "./components/footer.php";
        break;

        case 'actividades':
            $title = "actividades";
            $links = [];
            include "./components/header.php";
            include "./components/menu.php";
            include "$ruta/activities/activities.php";
            $scripts = [];
            include "./components/footer.php";
        break;

        case 'colaborador':
            $title = "colaborador";
            $links = [];
            include "./components/header.php";
            include "./components/menu.php";
            include "$ruta/users/users.php";
            $scripts = ['js/users.js'];
            include "./components/footer.php";
        break;

        case 'multicatalogo':
            $title = "multicatalogo";
            $links = ['css/select2.css'];
            include "./components/header.php";
            include "./components/menu.php";
            include "$ruta/conf/multicatalogo.php";
            $scripts = ['js/select2.min.js', 'js/multicatalogo.js'];
            include "./components/footer.php";
        break;

    }
    