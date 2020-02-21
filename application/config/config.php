<?php
    /**
     * This file contain all paths of the application  
     */

    // Switch mode between production and development
    define("MODE", "PRODUCTION");
    // define("MODE", "TEST");
    
    if(strcasecmp(MODE, "production") === 0) {
        // DB params for development
        define("DB_HOST", "");
        define("DB_USER", "");
        define("DB_PASS", "");
        define("DB_NAME", "");

        define("ROOTURL", "http://your-domain.com");
    } else {
        // DB params for development
        define("DB_HOST", "localhost");
        define("DB_USER", "username");
        define("DB_PASS", "");
        define("DB_NAME", "database_name");

        // URL root
        define("ROOTURL", "http://localhost/midpace");
    }

    // Sitename
    define("SITENAME", "Midpace");

    // Root path
    define("ROOT_PATH", dirname(dirname(dirname(__FILE__))));
    // CSS Path
    define("CSS_PATH", ROOTURL . "/public/assets/build/css");
    // Image Path
    define("IMAGE_PATH", ROOTURL . "/public/images");
    // Packages Path
    define("PACKAGE_PATH", ROOTURL . "/public/packages");

    if(strcasecmp(MODE, "production") === 0) {
        // View path for development Environment
        define("VIEW_PATH", ROOT_PATH . "/application/views");
        // JS path for production Environment
        define("JS_PATH", ROOTURL . "/public/assets/build/js");
    } else {
        // View path for development Environment
        define("VIEW_PATH", ROOT_PATH . "/application/views");
        // JS path for development Environment
        define("JS_PATH", ROOTURL . "/public/assets/dev/js");
    }

    // Set default timezone
    date_default_timezone_set("Asia/Kolkata");