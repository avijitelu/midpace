<?php
    class AboutController extends Controller {
        protected $aboutModel;

        public function __construct() {
            $this->aboutModel = $this->model("AboutModel");
        }


        /**
         * @route   /about
         * @desc    show the about-us page
         */
        public function index() {
            $seo_data = Seo::seoForAboutUsController("index");

            $data = [
                "page_title"        =>  $seo_data["page_title"],
                "page_description"  =>  $seo_data["page_description"]
            ];
            echo Twig::getInstance()->render("pages/about.html", $data);
        }
    }