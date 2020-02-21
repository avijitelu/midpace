<?php
    class AuthModel {
        private $db;

        public function __construct() {
            $this->db = new Database();
        }

        public function selectAdminByEmail($email) {
            $sql = "SELECT * FROM admins WHERE email = :email";

            $this->db->query($sql);
            $this->db->bind(":email", $email);
            return $this->db->single();
        }

        public function selectUserByEmail($email) {
            $sql = "SELECT * FROM users WHERE email=:email";

            $this->db->query($sql);
            $this->db->bind(":email", $email);
            return $this->db->single();
        }
    }