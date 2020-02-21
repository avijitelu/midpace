<?php
    class DoctorModel {
        private $db;

        public function __construct() {
            $this->db = new Database();
        }

        // @desc    used for select set of doctors
        public function selectUserset($start, $limit) {
            $sql = "SELECT * FROM users
                        LEFT JOIN personal_info ON users.id = personal_info.user_id
                        LIMIT $start, $limit";

            $this->db->query($sql);
            $this->db->bind(":start", $start);
            $this->db->bind(":limit", $limit);
            return $this->db->resultSet();
        }

        // @desc    select doctor by there ID
        public function selectDoctorById($user_id) {
            $sql = "SELECT * FROM users
                        INNER JOIN personal_info ON users.id = personal_info.user_id
                        WHERE users.id = :user_id";

            $this->db->query($sql);
            $this->db->bind(":user_id", $user_id);
            return $this->db->single();
        }


        // @desc    used for count number of doctors
        public function countDoctors() {
            $sql = "SELECT COUNT(*) AS number_of_doc FROM users";

            $this->db->query($sql);
            return $this->db->single();
        }


        // @desc    select speciality from specialities table
        public function selectSpeciality() {
            $sql = "SELECT * FROM specialities";

            $this->db->query($sql);
            return $this->db->resultSet();
        }


        // @desc    search doctors
        public function searchByDoctorName($search, $start, $limit) {
            $sql = "SELECT * FROM users
                        INNER JOIN personal_info
                        ON users.id = personal_info.user_id
                        WHERE CONCAT(fname,' ',lname) LIKE :special
                        LIMIT :start_index, :limit_per_page";

            $this->db->query($sql);
            $this->db->bind(":special", $search."%");
            $this->db->bind(":start_index", $start);
            $this->db->bind(":limit_per_page", $limit);
            return $this->db->resultSet();
        }

        // @desc    search doctors by their specialization
        public function searchBySpecialization($search, $start, $limit) {
            $sql = "SELECT * FROM users
                        INNER JOIN personal_info
                        ON users.id = personal_info.user_id
                        WHERE speciality LIKE :special
                        LIMIT :start_index, :limit_per_page";

            $this->db->query($sql);
            $this->db->bind(":special", $search."%");
            $this->db->bind(":start_index", $start);
            $this->db->bind(":limit_per_page", $limit);
            return $this->db->resultSet();
        }

        // @desc    number of doctors in search result
        public function searchDoctorsCount($search) {
            $sql = "SELECT COUNT(*) AS number_of_doc FROM users
                        WHERE speciality LIKE :special OR CONCAT(fname,' ',lname) LIKE :special";

            $this->db->query($sql);
            $this->db->bind(":special", $search."%");
            return $this->db->single();
        }

        public function doctorCountBySpeciality($speciality) {
            $sql = "SELECT * FROM users WHERE speciality LIKE :speciality";

            $this->db->query($sql);
            $this->db->bind(":speciality", $speciality);
            $doctors = $this->db->resultSet();
            $no_of_doctors = count($doctors);
            return $no_of_doctors;
        }


        // @desc    fetch chambers by the help of user ID
        public function selectChamberByDoctorId($user_id) {
            $sql = "SELECT * FROM chambers WHERE user_id = :user_id";

            $this->db->query($sql);
            $this->db->bind(":user_id", $user_id);
            return $this->db->resultSet();
        }


        // @desc    fetch time by the help of chamber ID
        public function selectTimeByChamberId($chamber_id) {
            $sql = "SELECT * FROM timings WHERE chamber_id = :chamber_id";

            $this->db->query($sql);
            $this->db->bind(":chamber_id", $chamber_id);
            return $this->db->resultSet();
        }

        // @desc    Insert patient
        public function insertPatient($patient_data) {
            $sql = "INSERT INTO booking_list(name, mobile, location, doc_id) 
                    VALUES(:name, :mobile, :location, :doc_id)";
            
            $this->db->query($sql);
            $this->db->bind(":name", $patient_data['name']);
            $this->db->bind(":mobile", $patient_data['mobile']);
            $this->db->bind(":location", $patient_data['location']);
            $this->db->bind(":doc_id", $patient_data['doc_id']);

            $this->db->execute();
        }

        // @desc    Select booking patient
        public function selectAllPatient($doctor_id) {
            $sql = "SELECT * from booking_list WHERE doc_id=:doc_id";

            $this->db->query($sql);
            $this->db->bind(":doc_id", $doctor_id);
            return $this->db->resultSet();
        }

        // Insert Patient to The patient_list Table
        public function insertPatientData($patient_data) {
            $sql = "INSERT INTO patient_list(name, mobile, doc_id) 
                    VALUES(:name, :mobile, :doc_id)";
            
            $this->db->query($sql);
            $this->db->bind(":name", $patient_data['name']);
            $this->db->bind(":mobile", $patient_data['mobile']);
            $this->db->bind(":doc_id", $patient_data['doc_id']);

            $this->db->execute();
        }

        
    }