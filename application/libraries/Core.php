<?php
    /**
     * App core class
     * Create URL & load core controller
     * URL Format - /controller/method/params
     */
    class Core {
        private $currentController = null;
        private $currentMethod = null;
        private $params = [];

        public function __construct() {
            $this->getUrl();

            // Check the existance of the controller
            if(file_exists("application/controllers/" . $this->currentController . "Controller.php")) {
                require_once "application/controllers/" . $this->currentController . "Controller.php";
                $controller_name = $this->currentController . "Controller";
                // Instantiate controller
                $this->currentController = new $controller_name();

                // Check the method existance
                if(!method_exists($this->currentController, $this->currentMethod)) {
                    Common::show404();
                }

                // Call a controller method with array of params
                call_user_func_array([$this->currentController, $this->currentMethod], $this->params);

            }  
            else {
                Common::show404();
            }
        }

        // Separate the URL parts
        private function getUrl() {
            if(isset($_GET['url'])) {
                $url = filter_var($_GET['url'], FILTER_SANITIZE_URL);
                $url = explode("/", $url);

                $url_controller = Common::capitalCamelCase($url[0]);
                $url_method = (isset($url[1]) && !empty($url[1])) ? Common::camelCase($url[1]) : "index";

                // get the URL params
                $this->params = array_slice($url, 2);

                $_GET['request_controller'] = $this->currentController = $url_controller;
                $_GET['request_method'] = $this->currentMethod = $url_method;

            } else {
                $_GET['request_controller'] = $this->currentController = "Home";
                $_GET['request_method'] = $this->currentMethod = "index";
            }
        }
    }