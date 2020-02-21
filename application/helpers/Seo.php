<?php
    /*
     * @desc    This file is created for SEO purpose.
     *          File is contained page description, keywords, title
     *          for different controller & methods
     */
    class Seo {
        public static $page_title;
        public static $page_description;
        public static $page_keywords;


        /*
         * @desc    SEO data for HomeController & its method
         * @param   $method(String) - HomeController method
         */
        public static function seoForHomeController($method) {
            if($method === "index") {
                self::$page_title = "Specialised Doctors in Midnapore | Address, Time, Qualification";
                self::$page_description = "Get detailed information on specialised doctors in Midnapore. Check chamber address, opening & closing time, their qualification and much more.";
            }

            return [
                "page_title"        =>  self::$page_title,
                "page_description"  =>  self::$page_description
            ];
        }


        /*
         * @desc    SEO data for AboutUsController & its method
         * @param   $method(String) - AboutUsController method
         */
        public static function seoForAboutUsController($method) {
            if($method === "index") {
                self::$page_title = "Midpace About us";
                self::$page_description = "About Midpace";
            }

            return [
                "page_title"        =>  self::$page_title,
                "page_description"  =>  self::$page_description
            ];
        }


        /*
         * @desc    SEO data for ContactUsController & its method
         * @param   $method(String) - ContactUsController method
         */
        public static function seoContactUsController($method) {
            if($method === "index") {
                self::$page_title = "Contact Us | Midpace";
                self::$page_description = "Contact Us";
            }

            return [
                "page_title"        =>  self::$page_title,
                "page_description"  =>  self::$page_description
            ];
        }


        /**
         * @desc    SEO data for PrivacyPolicyController & its method
         * @param   $method(String) - PrivacyPolicyController class method
         */
        public static function seoPrivacyPolicyController($method) {
            if($method === "index") {
                self::$page_title = "Midpace Privacy Policy";
                self::$page_description = "Midpace Privacy Policy";
            }

            return [
                "page_title"        =>  self::$page_title,
                "page_description"  =>  self::$page_description
            ];
        }


        /**
         * @desc    SEO data for PrivacyPolicyController & its method
         * @param   $method(String) - PrivacyPolicyController class method
         */
        public static function seoTermConditionController($method) {
            if($method === "index") {
                self::$page_title = "Midpace Term and Condition";
                self::$page_description = "Midpace Term and Condition";
            }

            return [
                "page_title"        =>  self::$page_title,
                "page_description"  =>  self::$page_description
            ];
        }


        /**
         * @desc    SEO data for DoctorsController & its method
         * @param   $method(String) - DoctorsController class method
         */
        public static function seoDoctorsController($method, $name = null, $speciality = null) {
            switch($method) {
                case "index":
                    self::$page_title = "List of Specialised Doctors in Midnapore | Chamber Address, Opening & closing Time, Qualification";
                    self::$page_description = "Get detailed information on specialised doctors in Midnapore. Check chamber address, opening & closing time, their qualification and much more.";
                    break;
                case "profile":
                    self::$page_title = "Dr. " . $name . " - " . $speciality . " in Midnapore | Chamber Address, Opening & closing Time, Qualification";
                    self::$page_description = "Dr. " . $name . " - " . $speciality . " in Midnapore. Get detailed information about their chamber address, opening & closing time and qualification";
                    break;
                case "search":
                    self::$page_title = "List of Specialised Doctors in Midnapore | Chamber Address, Opening & closing Time, Qualification";
                    self::$page_description = "Get detailed information on specialised doctors in Midnapore. Check chamber address, opening & closing time, their qualification and much more.";
                    break;
                case "speciality":
                    self::$page_title = "List of " . ucwords($name) . " in Midnapore | Chamber Address, Opening & closing Time, Qualification";
                    self::$page_description = "Top " . ucwords($name) . " in midnapore. Get detailed information about their chamber address, opening & closing time and qualification";
                    break;
                case "booking":
                    self::$page_title = "Dr. " . $name . " - online booking | Patient List";
                    self::$page_description = "Dr. " . $name . " online booking page. Enlist your name for medical checkup.";
                    break;
            }

            return [
                "page_title"        =>  self::$page_title,
                "page_description"  =>  self::$page_description
            ];
        }






    }