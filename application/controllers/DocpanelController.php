<?php
    class DocpanelController extends Controller {
        protected $docpanelModel;

        public function __construct() {
            $this->docpanelModel = $this->model("DocpanelModel");
            if(!$_SESSION['email'] || $_SESSION['user_mode'] !== "doctor") {
                Common::redirect('/auth/login');
            }
        }

        /**
         * @route   /docpanel
         * @desc    show the Doctor Dashboard page
         */
        public function index() {
            $user_id = $_SESSION['user_id'];
            $user = $this->docpanelModel->selectUserById($user_id);
            $patient_list = $this->docpanelModel->selectPatients($user_id);
            $data = [
                "user"          =>  $user,
                "patient_list"  =>  $patient_list
            ];
            
            if($_SERVER['REQUEST_METHOD'] === "POST") {
                $urgent_msg = trim($_POST['message']);
                $urgent_msg = htmlspecialchars($urgent_msg);
                $this->docpanelModel->updateUrgentNotice($user_id, $urgent_msg);

            }

            echo Twig::getInstance()->render("docpanel/index.html", $data);
        }

        /**
         * @route   /docpanel/booking-status
         * @desc    show the Doctor Dashboard page
         * @method  POST
         */
        public function bookingStatus() {
            if($_SERVER['REQUEST_METHOD'] === "POST") {
                $user_id = $_SESSION['user_id'];
                $user = $this->docpanelModel->selectUserById($user_id);

                if($user->booking_status == 0) {
                    $current_status = 1;
                } else {
                    $current_status = 0;
                }

                $this->docpanelModel->updateBookingStatus($current_status, $user_id);
                echo 1;
                return;
            }

            // Prevent GET requests
            if($_SERVER['REQUEST_METHOD'] === "GET") {
                Common::show404();
            }
        }

        /**
         * @route   /docpanel/delete-patients
         */
        public function deletePatients() {
            if($_SERVER['REQUEST_METHOD'] === "POST") {
                $user_id = $_SESSION['user_id'];
                $this->docpanelModel->deletePatientList($user_id);
                header("Location: " . $_SERVER['HTTP_REFERER']);
            }

            if($_SERVER['REQUEST_METHOD'] === "GET") {
                Common::show404();
            }
        }
    }