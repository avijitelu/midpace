<?php
    class PrivacyPolicyController extends Controller {
        /**
         * @route   /privacy-policy
         * @desc    display the privacy policy page
         */
        public function index() {
            $seo_data = Seo::seoPrivacyPolicyController("index");
            $data = [
                "page_title"        =>  $seo_data["page_title"],
                "page_description"  =>  $seo_data["page_description"]
            ];
            echo Twig::getInstance()->render("pages/privacy_policy.html", $data);
        }
    }