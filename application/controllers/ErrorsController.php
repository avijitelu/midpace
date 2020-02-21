<?php
    class ErrorsController extends Controller {

        /**
         * @desc    this method is shows 404 error
         */
        public function index() {
            $page_title = "404 Page not found";
            http_response_code(404);
            
            echo Twig::getInstance()->render("error/index.html", ["page_title" => $page_title]);
        }
    }