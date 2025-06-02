
<?php
    include './components/_root.php'; 
    $ruta = './views/';

    $url=(isset($_GET['dir']))?$_GET['dir']:'index';

    switch ($url) {
      
        case 'auth':
            $title = "auth";
            include "$ruta/auth/auth.php";
            
        break;

        case 'home':
            $title = "home";
            $links = [];
            include "./components/header.php";
            include "./components/menu.php";
            include "$ruta/home/home.php";
            $scripts = [];
            include "./components/footer.php";
        break;

        case 'empleados':
            $title = "empleados";
            $links = ['css/dataTables.bootstrap4.css'];
            include "./components/header.php";
            include "./components/menu.php";
            include "$ruta/empleados/empleados.php";
            $scripts = ['js/jquery.dataTables.min.js', 'js/dataTables.bootstrap4.min.js', 'js/empleadosDataTable.js'];
            include "./components/footer.php";
        break;

    }
    