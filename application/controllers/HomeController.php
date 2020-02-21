<?php
    class HomeController extends Controller {
        protected $homeModel;

        public function __construct() {
            $this->homeModel = $this->model("HomeModel");
        }


        /**
         * @route   / or /index
         * @desc    this is the root directory. Home page of the application
         */
        public function index() {
            $specialities = $this->homeModel->selectSpeciality();

            foreach($specialities as $value) {
                $special = Common::createSlug($value->speciality_name);
                $value->speciality_link = $special;
            }

            $seo_data = Seo::seoForHomeController("index");

            $data = [
                "specialities"      =>  $specialities,
                "page_title"        =>  $seo_data["page_title"],
                "page_description"  =>  $seo_data["page_description"]
            ];
            
            echo Twig::getInstance()->render("pages/home.html", $data);
        }
    }