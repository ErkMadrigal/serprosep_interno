<?php 
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
    $root = $protocol . $_SERVER["HTTP_HOST"] . "/SIA/frontEnd/";
    // $root = $protocol . $_SERVER["HTTP_HOST"] . "/serprosep_interno/frontEnd/";

