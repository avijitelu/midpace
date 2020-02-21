<?php
    class AddonController extends Controller {
        protected $addonModel;

        public function __construct() {
            $this->addonModel = $this->model("AddonModel");

            if(!$_SESSION["email"] || $_SESSION['user_mode'] !== "super") {
                Common::redirect("/auth/addon");
            }
        }

        // this function is used for filtering input data
        private function test_input($data) {
            $data = trim($data);
            $data = htmlspecialchars($data);
            return $data;
        }


        // @route   /addon or /addon/index
        // @desc    used for doctors registration
        public function index() {
            $special = $this->addonModel->selectSpeciality();

            // if user made a POST request then this code block is execute
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $firstname = $this->test_input($_POST['fname']);
                $lastname = $this->test_input($_POST['lname']);
                $mode = $this->test_input($_POST['mode']);
                $speciality = $this->test_input($_POST['speciality']);
                $email = $this->test_input($_POST['email']);
                $password = htmlspecialchars($_POST['password']);
                $password_encrypt = password_hash($password, PASSWORD_DEFAULT);

                $user_data = [
                    "firstname"     =>  $firstname,
                    "lastname"      =>  $lastname,
                    "mode"          =>  $mode,
                    "speciality"    =>  $speciality,
                    "email"         =>  $email,
                    "password"      =>  $password_encrypt,
                    "specialities"  =>  $special
                ];

                if($this->addonModel->selectSingleUser($email)) {
                    $user_data['error'] = "Email already register";

                    echo Twig::getInstance()->render("addon/user_registration.html", $user_data);
                    exit;

                } else {
                    $user_id = $this->addonModel->createNewUser($user_data);
                    $this->addonModel->preInsertPersonalinfo($user_id);
                }
            }
            
            $data = [
                "specialities"       =>  $special
            ];
            echo Twig::getInstance()->render("addon/user_registration.html", $data);
        }


        /**
         * @route   /addon/profile-update
         * @desc    update the user profile
         */
        public function profileUpdate() {
            if($_SERVER["REQUEST_METHOD"] === "POST") {
                $firstname = $this->test_input($_POST['fname']);
                $lastname = $this->test_input($_POST['lname']);
                $mode = $this->test_input($_POST['mode']);
                $speciality = $this->test_input($_POST['speciality']);
                $email = $this->test_input($_POST['email']);
                $user_id = $_POST["user_id"];

                $user_data = [
                    "firstname"     =>  $firstname,
                    "lastname"      =>  $lastname,
                    "mode"          =>  $mode,
                    "speciality"    =>  $speciality,
                    "email"         =>  $email,
                    "user_id"       =>  $user_id
                ];

                $this->addonModel->updateUserProfile($user_data);
                header("Location:" . $_SERVER["HTTP_REFERER"]);
            }
        }


        /**
         * @route   /addon/doctor_list
         * @desc    :used for show all doctors
         */
        public function doctorList($current_page='page=1') {
            // check the params 'page=1|2|3|4....' exactly match
            $query_test = preg_match('/\b(\w*page\w*)\b=[0-9]+/', $current_page);
            
            if($query_test || $current_page == '') {
                if($current_page == '') {
                    $page = 1;
                } else {
                    $page_array = explode('=', $current_page);
                    $page = $page_array[1];
                }

                $record_per_page = 10;
                $start = (($page - 1) * $record_per_page);
                $total_users = $this->addonModel->numberOfUsers();
                $max_pages = (($total_users[0]->user_count) / $record_per_page);
                $max_pages = ceil($max_pages);
                $users = $this->addonModel->selectUserset($start, $record_per_page);

                $data = [
                    "users"               =>  $users,
                    "current_page"        =>  $page,
                    "max_pages"           =>  $max_pages
                ];
                echo Twig::getInstance()->render("addon/doctors_list.html", $data);

            } else {
                $data = [];
                echo Twig::getInstance()->render("common/error404.html", $data);
            }
        }


        // @route   /addon/editprofile
        // @desc    :used for managing doctors profile information
        public function editProfile($id_string) {
            $id_string = explode('-', $id_string);
            $id = $id_string[0];
            $user = $this->addonModel->selectUserById($id);
            $special = $this->addonModel->selectSpeciality();
            $qualification = $this->addonModel->selectQualification($id);
            $chamber_addr = $this->addonModel->selectChamberAddr($id);
            $chambers_time = $this->addonModel->selectTimeChamber($id);
            
            $data = [
                "user"              => $user,
                "specialities"      => $special,
                "qualification"     =>  $qualification,
                "chamber_addr"      =>  $chamber_addr,
                "chambers_time"      =>  $chambers_time
            ];

            echo Twig::getInstance()->render("addon/edit_profile.html", $data);
        }


        // @route   /addon/editprofile
        // @desc    :used for managing doctors profile information
        public function deleteProfile($id_string) {
            $id_string = explode('-', $id_string);
            $id = $id_string[0];
            $user = $this->addonModel->selectUserById($id);

            if($user) {
                $this->addonModel->deleteUserById($id);
                header("Location: " . $_SERVER["HTTP_REFERER"]);
            }
        }


        /**
         * @route   /addon/personal_info
         * @desc    -used for UPDATE user personal information
         */
        public function personalInfo() {
            if($_SERVER['REQUEST_METHOD'] === 'POST') {
                $reg_no = $_POST['reg_no'];
                $gender = $_POST['gender'];
                $hometown = $_POST['hometown'];
                $current_location = $_POST['current_location'];
                $dob = $_POST['dob'];
                $mobile = $_POST['mobile'];
                $experience = $_POST['experience'];
                $fees = $_POST['fees'];
                $user_id = $_POST['id'];
                $about = $_POST["about"];
                $profile_pic = $_FILES['profile_pic']['name'];

                // get personal infomation data of the user
                $user = $this->addonModel->getPersonalinfoByUserId($user_id);
                
                if(strlen($profile_pic) === 0) {
                    $file_name = $user->user_img;
                } else {
                    $profile_pic_size = $_FILES['profile_pic']['size'];
                    $profile_pic_tmp = $_FILES['profile_pic']['tmp_name'];

                    $target_dir = ROOT_PATH . '/public/images/users/';
                    $file_ext = strtolower(end(explode('.', $profile_pic)));
                    $extension = array('jpg', 'png', 'jpeg');

                    $file_name = 'user-image' . '-' . $user_id . '.' . $file_ext;
                    $target_file = $target_dir . $file_name;
                    $error = [];

                    if(in_array($file_ext, $extension) == false) {
                        $error[] = "The file extension must be jpeg, jpg or png";
                    }
                    
                    if($profile_pic_size > 2097152) {
                        $error[] ='File size should be less than 2MB';
                    }

                    if(empty($error)) {
                        move_uploaded_file($profile_pic_tmp, $target_file);
                    }
                }

                $user_data = [
                    "reg"           =>  $reg_no,
                    "user_id"       =>  $user_id,
                    "gender"        =>  $gender,
                    "home"          =>  $hometown,
                    "current"       =>  $current_location,
                    "dob"           =>  $dob,
                    "mobile"        =>  $mobile,
                    "experience"    =>  $experience,
                    "fees"          =>  $fees,
                    "image"         =>  $file_name,
                    "about"         =>  $about
                ];

                // update personal information of the user
                $this->addonModel->updatePersonalinfo($user_data);

                header("Location:" . $_SERVER["HTTP_REFERER"]);
            }
        }


        /**
         * @route   /addon/add_specialization
         * @desc    :used for ADD specialization
         */
        public function addSpecialization() {
            if($_SERVER['REQUEST_METHOD'] === "POST") {
                $specialization = trim($_POST['special']);

                $this->addonModel->insertSpeciality($specialization);
            }
            $data = [];
            echo Twig::getInstance()->render("addon/add_specialization.html", $data);
        }


        // @route   /addon/qualification
        // @desc    :used for INSERT user qualification
        public function qualification() {
            if($_SERVER['REQUEST_METHOD'] === "POST") {
                $year = trim($_POST['passing_year']);
                $institute = trim($_POST['institute']);
                $course = trim($_POST['course']);
                $user_id = $_POST['id'];
                $level = $_POST['level'];

                $user_qulification = [
                    "level"         =>  $level,
                    "institute"     =>  $institute,
                    "course"        =>  $course,
                    "user_id"       =>  $user_id,
                    "year"          =>  $year
                ];

                $this->addonModel->insertQualification($user_qulification);

                header("Location: " . $_SERVER['HTTP_REFERER']);
            }
        }


        // @route   /addon/delete-qualification
        // @desc    :used for DELETE user qualification
        public function deleteQualification($qual_id) {
            $this->addonModel->deleteQualification($qual_id);
            echo 1;
        }


        // @route   /addon/update-qualification
        // @desc    :used for UPDATE user qualification
        public function updateQualification($qual_id) {
            if($_SERVER['REQUEST_METHOD'] === "POST") {
                $institute = trim($_POST['institute']);
                $course = trim($_POST['course']);
                $passing_year = trim($_POST['passing_year']);

                $qual_data = [
                    "institute"     =>  $institute,
                    "course"        =>  $course,
                    "passing_year"  =>  $passing_year,
                    "qual_id"       =>  $qual_id
                ];

                $this->addonModel->updateQualification($qual_data);

                header("Location: " . $_SERVER['HTTP_REFERER']);
            }
        }


        // @route   /addon/chamber
        // @desc    :used for insert & update chambers address
        public function chamber($chamber_id = null) {
            if($_SERVER['REQUEST_METHOD'] === "POST") {

                if(empty($chamber_id)) {    // this if block is execute for insert new address
                    $address = trim($_POST['address']);
                    $city = trim($_POST['city']);
                    $district = trim($_POST['district']);
                    $pin = trim($_POST['pin']);
                    $state = trim($_POST['state']);
                    $user_id = trim($_POST['id']);

                    $chamber_address = [
                        "address"       =>  $address,
                        "city"          =>  $city,
                        "district"      =>  $district,
                        "pin"           =>  $pin,
                        "state"         =>  $state,
                        "user_id"       =>  $user_id,
                    ];

                    $this->addonModel->insertChamberAddress($chamber_address);

                } else {    // else block is execute when update existing address
                    $address = trim($_POST['address']);
                    $city = trim($_POST['city']);
                    $district = trim($_POST['district']);
                    $pin = trim($_POST['pin']);
                    $state = trim($_POST['state']);

                    $chamber_address = [
                        "address"       =>  $address,
                        "city"          =>  $city,
                        "district"      =>  $district,
                        "pin"           =>  $pin,
                        "state"         =>  $state,
                        "chamber_id"    =>  $chamber_id
                    ];

                    $this->addonModel->updateChamberAddress($chamber_address);
                }
            }
        }


        // @route   /addon/delete_chamber
        // @desc    :used to delete chamber address
        public function deleteChamber($chamber_id) {
            $this->addonModel->deleteChamber($chamber_id);
            echo 1;
        }


        // @route   /addon/timetable
        // @desc    :used to INSERT doctors chamber opening & closing time
        public function addTime() {
            if($_SERVER['REQUEST_METHOD'] === "POST") {
                $chamber_id         = trim($_POST['chamber_addr']);
                $monday_start       = trim($_POST['mon_start']);
                $monday_end         = trim($_POST['mon_end']);
                $tuesday_start      = trim($_POST['tues_start']);
                $tuesday_end        = trim($_POST['tues_end']);
                $wednesday_start    = trim($_POST['wed_start']);
                $wednesday_end      = trim($_POST['wed_end']);
                $thusday_start      = trim($_POST['thus_start']);
                $thusday_end        = trim($_POST['thus_end']);
                $friday_start       = trim($_POST['fri_start']);
                $friday_end         = trim($_POST['fri_end']);
                $saturday_start     = trim($_POST['sat_start']);
                $saturday_end       = trim($_POST['sat_end']);
                $sunday_start       = trim($_POST['sun_start']);
                $sunday_end         = trim($_POST['sun_end']);

                $time_data = [
                    "monday_start"          =>  $monday_start,
                    "monday_end"            =>  $monday_end,
                    "tuesday_start"         =>  $tuesday_start,
                    "tuesday_end"           =>  $tuesday_end,
                    "wednesday_start"       =>  $wednesday_start,
                    "wednesday_end"         =>  $wednesday_end,
                    "thusday_start"         =>  $thusday_start,
                    "thusday_end"           =>  $thusday_end,
                    "friday_start"          =>  $friday_start,
                    "friday_end"            =>  $friday_end,
                    "saturday_start"        =>  $saturday_start,
                    "saturday_end"          =>  $saturday_end,
                    "sunday_start"          =>  $sunday_start,
                    "sunday_end"            =>  $sunday_end,
                    "chamber_id"            =>  $chamber_id
                ];

                $this->addonModel->insertTime($time_data);
            }
        }
        

        /**
         * @route   /addon/time/(del|edit)/:id
         * @desc    :used to DELETE & UPDATE doctors chamber opening & closing time
         */
        public function time($action, $time_id = null) {
            // action must be "del" or "edit"
            $valid_action = in_array($action, ["del", "edit"]);

            // check $time_id is exist & must be a number
            if(is_numeric($time_id) && !empty($time_id)) {
                $valid_time_id = $this->addonModel->selectTimeById($time_id);
            }

            if($valid_time_id && $valid_action) {
                if($action === "del") {
                    // this block is execute when user DELETE time
                    $this->addonModel->deleteChamberTime($time_id);
                }
                elseif($action === "edit") {
                    // this block is execute when user UPDATE time
                    if($_SERVER['REQUEST_METHOD'] === "POST") {
                        $chamber_id         = trim($_POST['chamber_addr']);
                        $monday_start       = trim($_POST['mon_start']);
                        $monday_end         = trim($_POST['mon_end']);
                        $tuesday_start      = trim($_POST['tues_start']);
                        $tuesday_end        = trim($_POST['tues_end']);
                        $wednesday_start    = trim($_POST['wed_start']);
                        $wednesday_end      = trim($_POST['wed_end']);
                        $thusday_start      = trim($_POST['thus_start']);
                        $thusday_end        = trim($_POST['thus_end']);
                        $friday_start       = trim($_POST['fri_start']);
                        $friday_end         = trim($_POST['fri_end']);
                        $saturday_start     = trim($_POST['sat_start']);
                        $saturday_end       = trim($_POST['sat_end']);
                        $sunday_start       = trim($_POST['sun_start']);
                        $sunday_end         = trim($_POST['sun_end']);
        
                        $time_data = [
                            "monday_start"          =>  $monday_start,
                            "monday_end"            =>  $monday_end,
                            "tuesday_start"         =>  $tuesday_start,
                            "tuesday_end"           =>  $tuesday_end,
                            "wednesday_start"       =>  $wednesday_start,
                            "wednesday_end"         =>  $wednesday_end,
                            "thusday_start"         =>  $thusday_start,
                            "thusday_end"           =>  $thusday_end,
                            "friday_start"          =>  $friday_start,
                            "friday_end"            =>  $friday_end,
                            "saturday_start"        =>  $saturday_start,
                            "saturday_end"          =>  $saturday_end,
                            "sunday_start"          =>  $sunday_start,
                            "sunday_end"            =>  $sunday_end,
                            "chamber_id"            =>  $chamber_id,
                            "time_id"               =>  $time_id
                        ];
        
                        $this->addonModel->updateTime($time_data);
                    }

                    header("Location: " . $_SERVER["HTTP_REFERER"]);
                } else {
                    Common::show404();
                }
            } else {
                Common::show404();
            }
        }
        
    }