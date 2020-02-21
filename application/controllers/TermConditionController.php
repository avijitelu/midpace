<?php
    class TermConditionController extends Controller {
        /**
         * @route   /term-condition
         * @desc    display the term & condition page
         */
        public function index() {
            $seo_data = Seo::seoTermConditionController("index");
            $data = [
                "page_title"        =>  $seo_data["page_title"],
                "page_description"  =>  $seo_data["page_description"]
            ];
            echo Twig::getInstance()->render("pages/terms_conditions.html", $data);
        }
    }