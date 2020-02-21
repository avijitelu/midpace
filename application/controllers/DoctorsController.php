<?php
    class DoctorsController extends Controller {
        protected $doctorModel;

        public function __construct() {
            $this->doctorModel = $this->model("DoctorModel");
        }


        /**
         * @route   /doctors
         * @desc    used for show all doctors
         */
        public function index() {
            $count_doctors = $this->doctorModel->countDoctors();
            $total_doctors = $count_doctors->number_of_doc;
            $per_page_limit = 12;
            $no_of_pages = ceil($total_doctors/$per_page_limit);

            $specialities = $this->doctorModel->selectSpeciality();

            foreach($specialities as $value) {
                $special = Common::createSlug($value->speciality_name);
                $value->speciality_link = $special;
            }

            $seo_data = Seo::seoDoctorsController("index");

            $data = [
                "specialities"      =>  $specialities,
                "no_of_pages"       =>  $no_of_pages,
                "ajax_url"          =>  ROOTURL . "/doctors?ajax=1",
                "page_title"        =>  $seo_data["page_title"],
                "page_description"  =>  $seo_data["page_description"]
            ];

            // ajax request for load more doctors
            if(isset($_GET["ajax"])) {
                $page = $_GET["page"];
                $start = $per_page_limit * ($page - 1);
                $doctor_list = $this->doctorModel->selectUserset($start, $per_page_limit);

                $data["doctors"] = $doctor_list;

                echo Twig::getInstance()->render("components/card.html", $data);
                return 0;
            }

            $doctor_list = $this->doctorModel->selectUserset(0, $per_page_limit);

            $data["doctors"] = $doctor_list;
            echo Twig::getInstance()->render("doctors/listings.html", $data);
            
        }


        /**
         * @route   /doctors/profile/id-doctorname
         * @desc    used for show single doctors profile
         */
        public function profile($params) {
            $params_array = explode("-", $params);
            $user_id = $params_array[0];
            $doctor = $this->doctorModel->selectDoctorById($user_id);
            $chambers_array = [];

            if($doctor) {
                $chambers = $this->doctorModel->selectChamberByDoctorId($user_id);
                if($chambers) {
                    foreach($chambers as $chamber) {
                        $timings = $this->doctorModel->selectTimeByChamberId($chamber->id);
                        foreach($timings as $time) {
                            $time_array[] = [
                                "monday_start"      =>  $time->monday_start,
                                "monday_end"        =>  $time->monday_end,
                                "tuesday_start"     =>  $time->tuesday_start,
                                "tuesday_end"       =>  $time->tuesday_end,
                                "wednesday_start"   =>  $time->wednesday_start,
                                "wednesday_end"     =>  $time->wednesday_end,
                                "thusday_start"     =>  $time->thusday_start,
                                "thusday_end"       =>  $time->thusday_end,
                                "friday_start"      =>  $time->friday_start,
                                "friday_end"        =>  $time->friday_end,
                                "saturday_start"    =>  $time->saturday_start,
                                "saturday_end"      =>  $time->saturday_end,
                                "sunday_start"      =>  $time->sunday_start,
                                "sunday_end"        =>  $time->sunday_end
                            ];
                        }
                        $chambers_array[] = [
                            "address"       =>  $chamber->address,
                            "city"          =>  $chamber->city,
                            "district"      =>  $chamber->district,
                            "state"         =>  $chamber->state,
                            "pincode"       =>  $chamber->pincode,
                            "time"          =>  $time_array
                        ];
                    }

                }

                $doctor_fullname = $doctor->fname . " " . $doctor->lname;
                $seo_data = Seo::seoDoctorsController("profile", $doctor_fullname, $doctor->speciality);
                
                $data = [
                    "doctor"            =>  $doctor,
                    "chambers"          =>  $chambers_array,
                    "page_title"        =>  $seo_data["page_title"],
                    "page_description"  =>  $seo_data["page_description"]
                ];
                echo Twig::getInstance()->render("doctors/profile.html", $data);

            } else {
                Common::show404();
            }
        }


        /**
         * @route   /doctors/search?query=something or /doctors/search/specialization
         * @desc    used for search doctors
         */
        public function search($speciality = null) {
            $specialities = $this->doctorModel->selectSpeciality();

            foreach($specialities as $value) {
                $special = Common::createSlug($value->speciality_name);
                $value->speciality_link = $special;
            }

            // ajax request for load more doctors
            if(isset($_GET["ajax"])) {
                $page = $_GET["page"];
                $per_page_limit = 12;
                $start = $per_page_limit * ($page - 1);

                if(isset($_GET["search_name"])) {
                    $doctor_list = $this->doctorModel->searchByDoctorName($_GET["search_name"], $start, $per_page_limit);
                    $data["doctors"] = $doctor_list;

                } elseif(isset($_GET["search_cat"])) {
                    $doctor_list = $this->doctorModel->searchBySpecialization($_GET["search_cat"], $start, $per_page_limit);
                    $data["doctors"] = $doctor_list;
                }

                echo Twig::getInstance()->render("components/card.html", $data);
                return 0;
            }

            if(isset($_GET["search"]) && !empty($_GET["search"])) {
                $search = $_GET["search"];
                
                $count_doctors = $this->doctorModel->searchDoctorsCount($search);
                $total_doctors = $count_doctors->number_of_doc;
                $per_page_limit = 12;
                $no_of_pages = ceil($total_doctors/$per_page_limit);
                
                $doctors = $this->doctorModel->searchByDoctorName($search, 0, $per_page_limit);
                $seo_data = Seo::seoDoctorsController("search");
                $data = [
                    "doctors"           =>  $doctors,
                    "specialities"      =>  $specialities,
                    "no_of_pages"       =>  $no_of_pages,
                    "ajax_url"          =>  ROOTURL . "/doctors/search?ajax=1&search_name=" . $search,
                    "page_title"        =>  $seo_data["page_title"],
                    "page_description"  =>  $seo_data["page_description"]
                ];
                echo Twig::getInstance()->render("doctors/listings.html", $data);

            } elseif($speciality) {  // when url look like- '/doctors/search/specialization'
                $speciality = Common::removeSlug($speciality);
                
                $total_doctors = $this->doctorModel->doctorCountBySpeciality($speciality);
                $per_page_limit = 12;
                $no_of_pages = ceil($total_doctors/$per_page_limit);

                $doctors = $this->doctorModel->searchBySpecialization($speciality, 0, $per_page_limit);
                $seo_data = Seo::seoDoctorsController("speciality", $speciality);
                $data = [
                    "doctors"           =>  $doctors,
                    "specialities"      =>  $specialities,
                    "no_of_pages"       =>  $no_of_pages,
                    "ajax_url"          =>  ROOTURL . "/doctors/search?ajax=1&search_cat=" . $speciality,
                    "page_title"        =>  $seo_data["page_title"],
                    "page_description"  =>  $seo_data["page_description"]
                ];
                echo Twig::getInstance()->render("doctors/listings.html", $data);

            } else {
                $seo_data = Seo::seoDoctorsController("search");
                $data = [
                    "specialities"      =>  $specialities,
                    "page_title"        =>  $seo_data["page_title"],
                    "page_description"  =>  $seo_data["page_description"]
                ];
                echo Twig::getInstance()->render("doctors/listings.html", $data);
            }
        }


        /**
         * @route   /doctors/booking/:id-doctor-name
         * @desc    used for Doctors Booking 
         */
        public function booking($params = null) {
            if($_SERVER['REQUEST_METHOD'] === "POST") {
                $doctor = $this->doctorModel->selectDoctorById($_POST['doc_id']);
                $patient_data = [
                    "name"        =>  trim($_POST['name']),
                    "mobile"      =>  trim($_POST['mobile']),
                    "location"    =>  trim($_POST['location']),
                    "doc_id"      =>  trim($_POST['doc_id'])
                ];

                if($doctor) {
                    $this->doctorModel->insertPatient($patient_data);
                    $this->doctorModel->insertPatientData($patient_data);
                }
                header("Location: " . $_SERVER['HTTP_REFERER']);
            }

            if($_SERVER['REQUEST_METHOD'] === "GET") {
                $params_array = explode("-", $params);
                $doctor_id = $params_array[0];
                $doctor = $this->doctorModel->selectDoctorById($doctor_id);
                if(!$doctor) {
                    Common::show404();
                }
                $doctor_name = $doctor->fname . " " . $doctor->lname;
                $chambers = $this->doctorModel->selectChamberByDoctorId($doctor_id);
                $seo_data = Seo::seoDoctorsController("booking", $doctor_name);
                
                $all_patient = $this->doctorModel->selectAllPatient($doctor_id);
                $data = [
                    "doctor"            =>  $doctor,
                    "patients"          =>  $all_patient,
                    "page_title"        =>  $seo_data['page_title'],
                    "page_description"  =>  $seo_data['page_description'],
                    "chambers"          =>  $chambers
                ];
                echo Twig::getInstance()->render("doctors/booking.html", $data);
            }
        }


        
    }