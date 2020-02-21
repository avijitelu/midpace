<?php
    class Twig {
        public static $twig = null;

        public static function getInstance() {
            $loader = new Twig_Loader_Filesystem(VIEW_PATH);
            self::$twig = new Twig_Environment($loader, array(
                "auto_reload"   => true,
                "debug"         =>  true,
                "cache"         =>  ROOT_PATH . "/application/cache"
            ));
            self::$twig->addExtension(new Twig_Extension_Debug());
            self::$twig->addGlobal("get", $_GET);
            self::$twig->addGlobal("session", $_SESSION);
            return self::$twig;
        }
    }