<?php

    // require_once 'router.php';
    require_once './db/Conection.php';
    require_once './pruebas/Consultas.pruebas.php';
    
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Max-Age: 3600");

    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
    
    date_default_timezone_set('America/Mexico_City');
    
    // if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    //     header("HTTP/1.1 200 OK");
    //     exit();
    // }
    
    
    // $router = new Router();
    // $inserciones = new Inserciones();
    $consultas = new Consultas();
    $conn = DataBase::getConnection();


    if(!empty($_POST)){
        $opcion=(isset($_POST["opcion"]))?$_POST["opcion"]:'';
    }elseif(!empty($_GET)){
        // Para obtener el valor de opcion desde la URL
        // Ejemplo: http://tu_dominio.com/api.php?opcion=pruebaVida
        $opcion=(isset($_GET["opcion"]))?$_GET["opcion"]:'';
    }else{
        $opcion = 'pruebaVida';
    }


    switch( $opcion ){
        case "pruebaVida":
            echo json_encode($consultas::prueba());
        break;
        case "PruebaConexion":
            if($conn){
                echo json_encode(["status" => "ok", "message" => "Conexión exitosa"]);
            }
        break;
       
        
                
    }
           
