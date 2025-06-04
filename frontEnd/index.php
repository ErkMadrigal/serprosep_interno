
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
            $links = ['css/select2.css','css/dropzone.css','css/uppy.min.css','css/jquery.steps.css','css/jquery.timepicker.css','css/quill.snow.css'];
            include "./components/header.php";
            include "./components/menu.php";
            include "$ruta/empleados/empleados.php";
            $scripts = ['js/jquery.mask.min.js','js/select2.min.js','js/jquery.steps.min.js','js/jquery.validate.min.js','js/jquery.timepicker.js','js/dropzone.min.js','js/uppy.min.js','js/quill.min.js', 'js/table-users.js'];
            include "./components/footer.php";
        break;

        case 'nuevo-empleado':
            $title = "Nuevo Empleado";
            $links = ['css/select2.css','css/dropzone.css','css/uppy.min.css','css/jquery.steps.css','css/jquery.timepicker.css','css/quill.snow.css'];
            include "./components/header.php";
            include "./components/menu.php";
            include "$ruta/empleados/nuevo-empleado.php";
            $scripts = ['js/jquery.mask.min.js','js/select2.min.js','js/jquery.steps.min.js','js/jquery.validate.min.js','js/jquery.timepicker.js','js/dropzone.min.js','js/uppy.min.js','js/quill.min.js', 'js/nuevo-empleado.js'];
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

        case 'carga-masiva-empleados':
            $title = "Carga Masiva Empleados";
            $links = ["https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css"];
            include "./components/header.php";
            include "./components/menu.php";
            include "$ruta/imports/carga-masiva-empleados.php";
            $scripts = ['js/dropzone.min.js', 'js/dropzone.min.js', 'https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js'];
            include "./components/footer.php";
        break;

    }
    