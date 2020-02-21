<?php
    class AddonModel {
        private $db;

        public function __construct() {
            $this->db = new Database();
        }

        // this method creates new user
        public function createNewUser($user_data) {
            $sql = "INSERT INTO users(fname, lname, user_mode, speciality, email, user_psw)
                    VALUES(:fname, :lname, :user_mode, :speciality, :email, :user_psw)";

            $this->db->query($sql);
            $this->db->bind(":fname", $user_data['firstname']);
            $this->db->bind(":lname", $user_data['lastname']);
            $this->db->bind(":user_mode", $user_data['mode']);
            $this->db->bind(":speciality", $user_data['speciality']);
            $this->db->bind(":email", $user_data['email']);
            $this->db->bind(":user_psw", $user_data['password']);
            $this->db->execute();

            return $this->db->lastInsertRowId();
        }

        // this method is used for update user profile
        public function updateUserProfile($user_data) {
            $sql = "UPDATE users SET
                        fname = :fname,
                        lname = :lname,
                        user_mode = :user_mode,
                        speciality = :speciality
                        WHERE id = :id";

            $this->db->query($sql);
            $this->db->bind(":fname", $user_data["firstname"]);
            $this->db->bind(":lname", $user_data["lastname"]);
            $this->db->bind(":user_mode", $user_data["mode"]);
            $this->db->bind(":speciality", $user_data["speciality"]);
            $this->db->bind(":id", $user_data["user_id"]);

            $this->db->execute();
            return $this->db->lastInsertRowId();
        }

        public function selectSingleUser($user_email) {
            $sql = "SELECT * FROM users WHERE email = :email";

            $this->db->query($sql);
            $this->db->bind(":email", $user_email);
            return $this->db->single();
        }

        public function selectUserById($user_id) {
            $sql = "SELECT *, users.id AS userId FROM users
                    LEFT JOIN personal_info ON users.id = personal_info.user_id
                    WHERE users.id = :id";

            $this->db->query($sql);
            $this->db->bind(":id", $user_id);
            return $this->db->single();
        }

        public function deleteUserById($user_id) {
            $sql = "DELETE FROM users WHERE id = :user_id";

            $this->db->query($sql);
            $this->db->bind(":user_id", $user_id);
            $this->db->execute();
        }

        public function numberOfUsers() {
            $sql = "SELECT COUNT(id) AS user_count, email FROM users";
            $this->db->query($sql);
            return $this->db->resultSet();
        }

        public function selectUserset($start, $limit) {
            $sql = "SELECT * FROM users LIMIT $start, $limit";

            $this->db->query($sql);
            $this->db->bind(":start", $start);
            $this->db->bind(":limit", $limit);
            return $this->db->resultSet();
        }

        // fetch personal information of the user form personal_info table by user_id
        public function getPersonalinfoByUserId($user_id) {
            $sql = "SELECT * FROM personal_info WHERE user_id = :id";

            $this->db->query($sql);
            $this->db->bind(":id", $user_id);
            return $this->db->single();
        }

        public function preInsertPersonalinfo($user_id) {
            $sql = "INSERT INTO personal_info(user_id) VALUES(:user_id)";
            $this->db->query($sql);
            $this->db->bind(":user_id", $user_id);
            $this->db->execute();
        }

        public function insertPersonalinfo($user_data) {
            $sql = "INSERT INTO personal_info(user_id, reg_no, user_img, fees, gender, home_location, current_location, year_exp, mobile, about, dob) VALUES(:id, :reg, :img, :fee, :gender, :home, :current, :exp, :mobile, :about, :dob)";

            $this->db->query($sql);

            $this->db->bind(":id", $user_data['user_id']);
            $this->db->bind(":reg", $user_data['reg']);
            $this->db->bind(":img", $user_data['image']);
            $this->db->bind(":fee", $user_data['fees']);
            $this->db->bind(":gender", $user_data['gender']);
            $this->db->bind(":home", $user_data['home']);
            $this->db->bind(":current", $user_data['current']);
            $this->db->bind(":exp", $user_data['experience']);
            $this->db->bind(":mobile", $user_data['mobile']);
            $this->db->bind(":about", $user_data['about']);
            $this->db->bind(":dob", $user_data['dob']);

            $this->db->execute();
        }

        public function updatePersonalinfo($user_data) {
            $sql = "UPDATE personal_info SET
                        reg_no = :reg,
                        user_img = :img,
                        fees = :fee, 
                        gender = :gender,
                        home_location = :home,
                        current_location = :current,
                        year_exp = :exp,
                        mobile = :mobile,
                        about = :about,
                        dob = :dob
                        WHERE user_id = :id";

            $this->db->query($sql);

            $this->db->bind(":reg", $user_data['reg']);
            $this->db->bind(":img", $user_data['image']);
            $this->db->bind(":fee", $user_data['fees']);
            $this->db->bind(":gender", $user_data['gender']);
            $this->db->bind(":home", $user_data['home']);
            $this->db->bind(":current", $user_data['current']);
            $this->db->bind(":exp", $user_data['experience']);
            $this->db->bind(":mobile", $user_data['mobile']);
            $this->db->bind(":about", $user_data['about']);
            $this->db->bind(":dob", $user_data['dob']);
            $this->db->bind(":id", $user_data['user_id']);

            $this->db->execute();
        }

        public function insertSpeciality($speciality) {
            $sql = "INSERT INTO specialities(speciality_name) VALUES(:speciality)";

            $this->db->query($sql);
            $this->db->bind(":speciality", $speciality);
            $this->db->execute();
        }

        public function selectSpeciality() {
            $sql = "SELECT * FROM specialities";

            $this->db->query($sql);
            return $this->db->resultSet();
        }

        public function insertQualification($qualification) {
            $sql = "INSERT INTO qualifications(level, institute, course_name, passing_year, user_id) VALUES(:level, :institute_name, :course, :year, :user_id)";

            $this->db->query($sql);
            $this->db->bind(":level", $qualification['level']);
            $this->db->bind(":institute_name", $qualification['institute']);
            $this->db->bind(":course", $qualification['course']);
            $this->db->bind(":year", $qualification['year']);
            $this->db->bind(":user_id", $qualification['user_id']);
            $this->db->execute();
        }

        public function selectQualification($user_id) {
            $sql = "SELECT * FROM qualifications WHERE user_id = :user_id ORDER BY passing_year DESC";

            $this->db->query($sql);
            $this->db->bind(":user_id", $user_id);
            return $this->db->resultSet();
        }

        public function deleteQualification($qual_id) {
            $sql = "DELETE FROM qualifications WHERE id = :qual_id";

            $this->db->query($sql);
            $this->db->bind(":qual_id", $qual_id);
            $this->db->execute();
        }

        public function updateQualification($qual_data) {
            $sql = "UPDATE qualifications SET
                        institute = :name,
                        course_name = :course,
                        passing_year = :year
                        WHERE id = :qual_id";

            $this->db->query($sql);
            $this->db->bind(":name", $qual_data['institute']);
            $this->db->bind(":course", $qual_data['course']);
            $this->db->bind(":year", $qual_data['passing_year']);
            $this->db->bind(":qual_id", $qual_data['qual_id']);
            $this->db->execute();
        }

        public function insertChamberAddress($chamber_addr) {
            $sql = "INSERT INTO chambers(address, city, district, pincode, state, user_id)
                    VALUES(:addr, :city, :dist, :pin, :state, :user_id)";

            $this->db->query($sql);

            $this->db->bind(":addr", $chamber_addr['address']);
            $this->db->bind(":city", $chamber_addr['city']);
            $this->db->bind(":dist", $chamber_addr['district']);
            $this->db->bind(":pin", $chamber_addr['pin']);
            $this->db->bind(":state", $chamber_addr['state']);
            $this->db->bind(":user_id", $chamber_addr['user_id']);

            $this->db->execute();
        }

        public function updateChamberAddress($chamber_addr) {
            $sql = "UPDATE chambers SET
                        address = :addr,
                        city = :city,
                        district = :dist,
                        pincode = :pin,
                        state = :state
                        WHERE id = :chamber_id";

            $this->db->query($sql);
            $this->db->bind(":addr", $chamber_addr['address']);
            $this->db->bind(":city", $chamber_addr['city']);
            $this->db->bind(":dist", $chamber_addr['district']);
            $this->db->bind(":pin", $chamber_addr['pin']);
            $this->db->bind(":state", $chamber_addr['state']);
            $this->db->bind(":chamber_id", $chamber_addr['chamber_id']);

            $this->db->execute();
        }

        public function selectChamberAddr($user_id) {
            $sql = "SELECT * FROM chambers WHERE user_id = :id";

            $this->db->query($sql);
            $this->db->bind(":id", $user_id);

            return $this->db->resultSet();
        }

        public function deleteChamber($chamber_id) {
            $sql = "DELETE FROM chambers WHERE id = :chamber_id";

            $this->db->query($sql);
            $this->db->bind(":chamber_id", $chamber_id);
            $this->db->execute();
        }

        public function insertTime($time_data) {
            $sql = "INSERT INTO timings
                        (monday_start, monday_end, tuesday_start, tuesday_end, wednesday_start, wednesday_end, thusday_start, thusday_end, friday_start, friday_end, saturday_start, saturday_end, sunday_start, sunday_end, chamber_id) 
                        VALUES(:mon_start, :mon_end, :tues_start, :tues_end, :wed_start, :wed_end, :thus_start, :thus_end, :fri_start, :fri_end, :sat_start, :sat_end, :sun_start, :sun_end, :chamber_id)";

            $this->db->query($sql);
            $this->db->bind(":mon_start", $time_data['monday_start']);
            $this->db->bind(":mon_end", $time_data['monday_end']);
            $this->db->bind(":tues_start", $time_data['tuesday_start']);
            $this->db->bind(":tues_end", $time_data['tuesday_end']);
            $this->db->bind(":wed_start", $time_data['wednesday_start']);
            $this->db->bind(":wed_end", $time_data['wednesday_end']);
            $this->db->bind(":thus_start", $time_data['thusday_start']);
            $this->db->bind(":thus_end", $time_data['thusday_end']);
            $this->db->bind(":fri_start", $time_data['friday_start']);
            $this->db->bind(":fri_end", $time_data['friday_end']);
            $this->db->bind(":sat_start", $time_data['saturday_start']);
            $this->db->bind(":sat_end", $time_data['saturday_end']);
            $this->db->bind(":sun_start", $time_data['sunday_start']);
            $this->db->bind(":sun_end", $time_data['sunday_end']);
            $this->db->bind(":chamber_id", $time_data['chamber_id']);
            $this->db->execute();
        }

        public function selectTimeChamber($user_id) {
            $sql = "SELECT * FROM chambers
                        INNER JOIN timings ON chambers.id = timings.chamber_id
                        WHERE chambers.user_id = :user_id";
            
            $this->db->query($sql);
            $this->db->bind(":user_id", $user_id);
            return $this->db->resultSet();
        }

        public function selectTimeById($id) {
            $sql = "SELECT * FROM timings WHERE id = :time_id";
            
            $this->db->query($sql);
            $this->db->bind(":time_id", $id);
            return $this->db->single();
        }

        public function deleteChamberTime($time_id) {
            $sql = "DELETE FROM timings WHERE id = :time_id";

            $this->db->query($sql);
            $this->db->bind("time_id", $time_id);
            $this->db->execute();
        }

        public function updateTime($time_data) {
            $sql = "UPDATE timings SET
                        monday_start = :mon_start,
                        monday_end = :mon_end,
                        tuesday_start = :tues_start,
                        tuesday_end = :tues_end,
                        wednesday_start = :wed_start,
                        wednesday_end = :wed_end,
                        thusday_start = :thus_start,
                        thusday_end = :thus_end,
                        friday_start = :fri_start,
                        friday_end = :fri_end,
                        saturday_start = :sat_start,
                        saturday_end = :sat_end,
                        sunday_start = :sun_start,
                        sunday_end = :sun_end
                        WHERE id = :time_id";

            $this->db->query($sql);
            $this->db->bind(":mon_start", $time_data['monday_start']);
            $this->db->bind(":mon_end", $time_data['monday_end']);
            $this->db->bind(":tues_start", $time_data['tuesday_start']);
            $this->db->bind(":tues_end", $time_data['tuesday_end']);
            $this->db->bind(":wed_start", $time_data['wednesday_start']);
            $this->db->bind(":wed_end", $time_data['wednesday_end']);
            $this->db->bind(":thus_start", $time_data['thusday_start']);
            $this->db->bind(":thus_end", $time_data['thusday_end']);
            $this->db->bind(":fri_start", $time_data['friday_start']);
            $this->db->bind(":fri_end", $time_data['friday_end']);
            $this->db->bind(":sat_start", $time_data['saturday_start']);
            $this->db->bind(":sat_end", $time_data['saturday_end']);
            $this->db->bind(":sun_start", $time_data['sunday_start']);
            $this->db->bind(":sun_end", $time_data['sunday_end']);
            $this->db->bind(":time_id", $time_data['time_id']);
            $this->db->execute();
        }


    }