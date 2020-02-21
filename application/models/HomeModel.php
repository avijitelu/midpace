<?php
    class HomeModel {
        private $db;

        public function __construct() {
            $this->db = new Database();
        }

        // this method is used to fetch all data from specialities table
        public function selectSpeciality() {
            $sql = "SELECT *, LOWER(REPLACE(speciality_name, ' ', '-')) AS speciality_icon FROM specialities";

            $this->db->query($sql);
            return $this->db->resultSet();
        }
    }