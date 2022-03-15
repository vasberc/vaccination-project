<?php
    //Κλάση για την διαχείριση της βάσης δεδομένων
    class DbManager {

        private $dbhost;
	    private $dbuser;
	    private $dbpass;
	    private $dbname;
        //Στον constructor θέτουμε τα στοιχεία για την σύνδεση με την βάση
        function __construct() {
            $this->dbhost = 'localhost';
	        $this->dbuser = 'root';
	        $this->dbpass = "";
	        $this->dbname = 'berkovits_ioannidis_ge3';
        }
        //Όταν καλείται αυτό το function ενεργοποιείται μια σύνδεση με την βάση δεδομένων
        private function connect() {
            if(!$con = mysqli_connect($this->dbhost, $this->dbuser, $this->dbpass, $this->dbname)) {
                return false;
            } else {
                //Σε επιτυχή σύνδεση θέτουμε σε utf8 το charset που θα περνάμε στην βάση δεδομένων
                mysqli_set_charset($con, "utf8");
                return $con;
            }
        }
        //Function που εισάγει εγγραφή χρήστη στην βάση
        public function saveUserToDb(User $user) {
            $con = $this->connect();
            $isDoctor = $user->isDoctor ? 1 : 0 ;
            $query = "INSERT INTO users(name, surname, amka, afm, adt, sex, email, age, mobile, isDoctor)
                    VALUES (
                        '$user->name', 
                        '$user->surname', 
                        '$user->amka', 
                        '$user->afm', 
                        '$user->adt', 
                        '$user->sex', 
                        '$user->email',
                        '".(int)$user->age."', 
                        '$user->mobile', 
                        '$isDoctor'                          
                    )";
            if(!mysqli_query($con, $query)) {
                if((stripos(mysqli_error($con), "Duplicate entry") !== false)) {
                    $message = 'userSignUpErrorDuplicateEntry';                    
                } else {
                    $message = 'userSignUpError';
                }
                mysqli_close($con);
                throw new Exception($message);
            }
            mysqli_close($con);            
        }
        //Function που βρίσκει από την βάση τον χρήστη με το δοθέν ΑΜΚΑ
        public function getUserFromDbByAmka($amka) {
            $con = $this->connect();
            $amka = mysqli_real_escape_string($con, $amka);
            $query = "select * from users where amka = '".$amka."' limit 1";
            $result = mysqli_query($con, $query);
            mysqli_close($con);
            if($result) {
			    if($result && mysqli_num_rows($result) > 0) {
                    $userData = mysqli_fetch_assoc($result);
                    $isDoctor = $userData['isDoctor'] == 1 ? true : false;
                    $email = isset($userData['email']) && $userData['email'] != false ? $userData['email'] : null;
                    $user = new User(
                        $userData['name'],
                        $userData['surname'],
                        $userData['amka'],
                        $userData['afm'],
                        $userData['adt'],
                        $userData['sex'],
                        $email,
                        (int)$userData['age'],
                        $userData['mobile'],
                        $isDoctor,
                        (int)$userData['user_id']
                    );

                    $user->appointment = $this->getUserAppointmentFromDb($user);

                    mysqli_free_result($result);

                    return $user;
                }
            }
            return null;
        }
        //Function που βρίσκει από την βάση τον χρήστη με το δοθέν ΑΜΚΑ και ελέγχει αν ταιριάζει με το δοθέν ΑΦΜ
        public function getUserFromDbForLogin($amka, $afm) {
            $user = $this->getUserFromDbByAmka($amka);
            if(isset($user)) {
                if($user->afm == $afm) {
                    return $user;
                }
            }
            return null;           
        }
        //Function που βρίσκει το ραντεβού του χρήστη
        public function getUserAppointmentFromDb($user) {
            $con = $this->connect();
            $query = "select * from appointments where user_id = '".$user->id."' limit 1";
            $result = mysqli_query($con, $query);
            mysqli_close($con);
            if($result) {
			    if($result && mysqli_num_rows($result) > 0) {
                    $appointmentData = mysqli_fetch_assoc($result);
                    $appointment = new Appointment (
                        $this->getVaccinationCenterByIdFromDb($appointmentData['vaccination_center_id']),
                        $appointmentData['user_id'],
                        $appointmentData['date'],
                        $appointmentData['time'],
                        $appointmentData['completed'],
                        $appointmentData['appointment_id']
                    );
                    mysqli_free_result($result);
                    return $appointment;
                }
            }
            $appointment = null;
            return $appointment;
        }

        //Function που βρίσκει από την βάση τον γιατρό με το δοθέν χρήστη
        public function getDoctorFromDbByUser($user) {
            $con = $this->connect();
            $query = "select * from vaccination_centers_doctors where doctor_id = '".$user->id."' limit 1";
            $result = mysqli_query($con, $query);
            mysqli_close($con);
            if($result) {
			    if($result && mysqli_num_rows($result) > 0) {
                    $doctorData = mysqli_fetch_assoc($result);
                    $vaccinationCenter = $this->getVaccinationCenterByIdFromDb($doctorData['vaccination_center_id']);
                    $doctor = new VaccinationCenterDoctor(
                        $user,
                        $vaccinationCenter,
                        $doctorData['vaccination_centers_doctors_id']
                    );

                    mysqli_free_result($result);

                    return $doctor;
                }
            }
            return null;
        }

        //Function που βρίσκει από την βάση το κέντρο εμβολιασμού με το δοθέν id
        public function getVaccinationCenterByIdFromDb($vaccinationCenterId) {
            $con = $this->connect();
            $query = "select * from `vaccination-centers` where vaccination_center_id = '".$vaccinationCenterId."' limit 1";
            $result = mysqli_query($con, $query);
            mysqli_close($con);
            if($result) {
			    if($result && mysqli_num_rows($result) > 0) {
                    $vaccinationCenterData = mysqli_fetch_assoc($result);
                    $vaccinationCenterDoctorsId = $this->getVaccinationCenterDoctorsIdFromDb($vaccinationCenterData['vaccination_center_id']);
                    $vaccinationCenter = new VaccinationCenter(
                        $vaccinationCenterData['vaccination_center_id'],
                        $vaccinationCenterData['name'],
                        $vaccinationCenterData['address'],
                        $vaccinationCenterData['post_code'],
                        $vaccinationCenterData['telephone_number'],
                        $vaccinationCenterDoctorsId
                    );

                    mysqli_free_result($result);

                    return $vaccinationCenter;
                }
            }
            return null;
        }

        //Function που βρίσκει από την βάση το κέντρο εμβολιασμού με το δοθέν id
        public function getVaccinationCenterDoctorsIdFromDb($vaccinationCenterId) {
            $con = $this->connect();
            $query = "select * from vaccination_centers_doctors where vaccination_center_id = '".$vaccinationCenterId."' ";
            $result = mysqli_query($con, $query);
            mysqli_close($con);
            if($result) {
			    if($result && mysqli_num_rows($result) > 0) {
                    $i = 0;
                    foreach($result as $item){ 
                        $getVaccinationCenterDoctorsId[i] = $q['doctor_id'];
                        $i = $i + 1	;
                    }
                    mysqli_free_result($result);

                    return $getVaccinationCenterDoctorsId;
                }
            }
            return null;
        }

        public function deleteAppointment($appointmentId) {
            $con = $this->connect();
            $query = "delete from appointments where appointment_id = '".$appointmentId."' ";
            $result = mysqli_query($con, $query);
            mysqli_close($con);
            $succeed = false;
            if($result) {			    
                $succeed = true; 
            }
            mysqli_free_result($result);
            return $succeed;
        }
    } 