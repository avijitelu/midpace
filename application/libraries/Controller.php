<?php
    /**
     * Base Controller
     * Loads the Models
     */
    class Controller {
        // Load the model
        public function model($model) {
            // Require the model file
            require_once "application/models/" . $model . ".php";
            // Instantiate the model
            return new $model();
        }
    }