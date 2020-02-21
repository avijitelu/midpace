<?php
    class DocpanelModel {
        private $db;

        public function __construct() {
            $this->db = new Database();
        }

        // this method is used to fetch all data from specialities table
        public function selectUserById($id) {
            $sql = "SELECT * FROM users WHERE id=:id";

            $this->db->query($sql);
            $this->db->bind(":id", $id);
            return $this->db->single();
        }

        // Select patient by doctors id
        public function selectPatients($doc_id) {
            $sql = "SELECT * FROM booking_list WHERE doc_id=:doc_id";

            $this->db->query($sql);
            $this->db->bind(":doc_id", $doc_id);
            return $this->db->resultSet();
        }

        // Update doctor booking status
        public function updateBookingStatus($status, $user_id) {
            $sql = "UPDATE users SET booking_status=:status WHERE id=:id";

            $this->db->query($sql);
            $this->db->bind(":status", $status);
            $this->db->bind(":id", $user_id);
            $this->db->execute();
        }

        // Update urgent Notice
        public function updateUrgentNotice($user_id, $urgent_msg) {
            $sql = "UPDATE users SET urgent_notice=:notice WHERE id=:id";

            $this->db->query($sql);
            $this->db->bind(":notice", $urgent_msg);
            $this->db->bind(":id", $user_id);
            $this->db->execute();
        }

        // Delete all patient list By doctor ID
        public function deletePatientList($doc_id) {
            $sql = "DELETE FROM booking_list WHERE doc_id=:doc_id";

            $this->db->query($sql);
            $this->db->bind(":doc_id", $doc_id);
            $this->db->execute();
        }
    }