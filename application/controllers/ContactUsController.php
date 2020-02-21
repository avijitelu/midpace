<?php
    class ContactUsController extends Controller {
        /**
         * @route   /contact-us
         * @desc    display the contact us page
         */
        public function index() {
            $seo_data = Seo::seoContactUsController("index");
            $data = [
                "page_title"        =>  $seo_data["page_title"],
                "page_description"  =>  $seo_data["page_description"]
            ];
            echo Twig::getInstance()->render("pages/contact.html", $data);
        }


        /**
         * @route   /contact-us/contact
         * @desc    used for sending contact form email
         */
        public function contact() {
            $name = $_POST["name"];
            $email = $_POST["email"];
            $mobile = $_POST["mobile"];
            $message = $_POST["message"];

            $from = $email;
            $to = "midpacecontact@gmail.com";
            $subject = "Message from user: From contact us page of Midpace";
            $body = "Hi\n\n" . $message . "\n\nFrom: \n" . $name . "\nEmail: " . $email . "\nPhone:" . $mobile;

            $resp = Common::mail($from, $to, $subject, $body);

            if($resp) {
                echo "Email send";
            } else {
                echo "Email not send";
            }
            
        }
    }