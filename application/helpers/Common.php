<?php
use PHPMailer\PHPMailer\PHPMailer;

class Common {

    /**
     * Function for showing 404 error
     */
    public static function show404() {
        require_once ROOT_PATH . "/application/controllers/ErrorsController.php";
        $_GET["request_controller"] = "ErrorsController";
        $_GET["request_method"] = "index";
        $error = new ErrorsController();
        $error->index();
        die();
    }

    /**
     * convert to capital camel case
     * @parameter string $str
     * @return string
     */
    public static function capitalCamelCase($str) {
        $words = explode("-", $str);
        $converted_words = array();
        foreach($words as $word) {
            $converted_words[] = ucfirst($word);
        }
        return implode("", $converted_words);
    }


    /**
     * convert to camel case
     * @parameter string $str
     * @return string
     */
    public static function camelCase($str) {
        $words = explode("-", $str);
        $converted_words = array();
        $first = true;
        foreach($words as $word) {
            if($first) {
                $word = strtolower($word);
                $first = false;
            } else {
                $word = ucfirst($word);
            }
            $converted_words[] = $word;
        }
        return implode("", $converted_words);
    }

    /**
     * this function replace all space with "-"
     * @param   $str - A string
     */
    public static function createSlug($str) {
        $slug = str_replace(" ", "-", $str);
        return $slug;
    }

    /**
     * this function replace all "-" with space
     * @param   $str - A string
     */
    public static function removeSlug($str) {
        $slug = str_replace("-", " ", $str);
        return $slug;
    }


    /**
     * redirect to different url
     * @parameter   $url_path
     */
    public static function redirect($url_path, $status_code = 303) {
        header("Location: " . ROOTURL . $url_path, true, $status_code);
        die();
    }
    

    /**
     * @desc    use for sending emails
     * @param   $from - mail from whom
     * @param   $to - whom to send the email
     * @param   $subject - subject of the mail
     * @param   $body - body of the email
     */
    public static function mail($from, $to, $subject, $body) {
        $mail = new PHPMailer();

        $mail->setFrom($from);
        $mail->addAddress($to);
        $mail->Subject = $subject;
        $mail->Body = $body;

        if(!$mail->send()) {
            return 0;
        } else {
            return 1;
        }
    }


}