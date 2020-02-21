<?php
    // Required the config file
    require_once "config/config.php";
    
    // Required the helpers file
    require_once "helpers/Common.php";
    require_once "helpers/Seo.php";

    // Autoload libraries class
    spl_autoload_register(function($className) {
        require_once "libraries/" . $className . ".php";
    });