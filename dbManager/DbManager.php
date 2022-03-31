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
        /**
         * Function που εισάγει εγγραφή χρήστη στην βάση, σε περίπτωση σφάλματος
         * κάνει trow ένα exception με το ανάλογο μήνυμα 
         */  
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
                //Σε περίπτωση που δεν εκτελέστηκε το query εμφάνιση ανάλογου σφάλματος
                if((stripos(mysqli_error($con), "Duplicate entry") !== false)) {
                    //Duplicate entry εμφανίζεται σύμφωνα με τα constraints του πίνακα
                    $message = 'userSignUpErrorDuplicateEntry';                    
                } else {
                    $message = 'userSignUpError';
                }
                mysqli_close($con);
                throw new Exception($message);
            }
            mysqli_close($con);            
        }
        /**
         * Function που βρίσκει από την βάση τον χρήστη με το δοθέν ΑΜΚΑ,
         * επιστρέφει αντικείμενο User με το ραντεβού του αν έχει κλείσει ραντεβού,
         * σε περίπτωση σφάλματος null
         */
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
                    //Ανάκτηση του ραντεβού του χρήστη αν υπάρχει
                    $user->appointment = $this->getUserAppointmentFromDb($user);

                    mysqli_free_result($result);

                    return $user;
                }
            }
            return null;
        }
        /**
         * Function που βρίσκει από την βάση τον χρήστη με το δοθέν ΑΜΚΑ και ελέγχει αν ταιριάζει με το δοθέν ΑΦΜ
         * επιστρέφει αντικείμενο User,
         * σε περίπτωση σφάλματος null
         */
        public function getUserFromDbForLogin($amka, $afm) {
            //Ανάκτηση του User από την υλοποιημένη μέθοδο
            $user = $this->getUserFromDbByAmka($amka);
            if(isset($user)) {
                //Έλεγχος αν ταιριάζει το afm που δόθηκε
                if($user->afm == $afm) {
                    return $user;
                }
            }
            return null;           
        }
        /**
         * Function που βρίσκει το ραντεβού του χρήστη
         * επιστρέφει αντικείμενο Appointment,
         * σε περίπτωση σφάλματος null
         * 
         * Στο πεδίο vaccinationCenter περιέχει αντικείμενο VaccinationCenter
         * ή null σε περίπτωση σφάλματος κατά την ανάκτησή του
         */
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
        /**
         * Function που βρίσκει από την βάση τον γιατρό με το δοθέν χρήστη
         * επιστρέφει αντικείμενο VaccinationCenterDoctor που είναι υποκλάση του User,
         * σε περίπτωση σφάλματος null
         * 
         * Στο πεδίο vaccinationCenter περιέχει αντικείμενο VaccinationCenter
         * ή null σε περίπτωση σφάλματος κατά την ανάκτησή του
         */
        public function getDoctorFromDbByUser($user) {
            $con = $this->connect();
            $query = "select * from vaccination_centers_doctors where user_id = '".$user->id."' limit 1";
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
        /**
         * Function που βρίσκει από την βάση όλα τα κέντρα εμβολιασμού
         * επιστρέφει πίνακα που περιέχει αντικείμενα VaccinationCenter,
         * σε περίπτωση σφάλματος false
         */
        public function getVaccinationCenters() {
            $con = $this->connect();
            $query = "select * from `vaccination-centers`";
            $result = mysqli_query($con, $query);
            mysqli_close($con);
            if($result && mysqli_num_rows($result) > 0) {
                $i=0;
                foreach($result as $item){ 
                    $vaccinationCenters[$i] = new VaccinationCenter (
                        $item['vaccination_center_id'],
                        $item['name'],
                        $item['address'],
                        $item['post_code'],
                        $item['telephone_number']
                    );
                    $i = $i + 1	;
                }
                return $vaccinationCenters;
            } else {
                return false;
            }
        }
        /**
         * Function που βρίσκει από την βάση το κέντρο εμβολιασμού με το δοθέν id
         * επιστρέφει αντικείμενο VaccinationCenter,
         * σε περίπτωση σφάλματος null
         */
        public function getVaccinationCenterByIdFromDb($vaccinationCenterId) {
            $con = $this->connect();
            $query = "select * from `vaccination-centers` where vaccination_center_id = '".$vaccinationCenterId."' limit 1";
            $result = mysqli_query($con, $query);
            mysqli_close($con);
            if($result) {
			    if($result && mysqli_num_rows($result) > 0) {
                    $vaccinationCenterData = mysqli_fetch_assoc($result);
                    $vaccinationCenter = new VaccinationCenter(
                        $vaccinationCenterData['vaccination_center_id'],
                        $vaccinationCenterData['name'],
                        $vaccinationCenterData['address'],
                        $vaccinationCenterData['post_code'],
                        $vaccinationCenterData['telephone_number']
                    );

                    mysqli_free_result($result);

                    return $vaccinationCenter;
                }
            }
            return null;
        }
        /**
         * Function που βρίσκει τα ραντεβού ενός κέντρου εμβολιασμού με το δοθέν id του κέντρου
         * επιστρέφει πίνακα με αντικείμενα Appointment ταξινομημένα με βάση το date και το time,
         * σε περίπτωση σφάλματος false
         */
        public function getAppointmentsOfSelectedVaccinationCenter($selectedVaccinationCenterId) {
            $con = $this->connect();
            $query = "select * from appointments where vaccination_center_id = '".$selectedVaccinationCenterId."' ORDER BY date ASC, time ASC";
            $result = mysqli_query($con, $query);
            mysqli_close($con);
            if($result && mysqli_num_rows($result) > 0) {
                $i=0;
                foreach($result as $item){ 
                    $appointmentsOfSelectedVaccinationCenter[$i] = new Appointment (
                        $item['vaccination_center_id'],
                        $item['user_id'],
                        $item['date'],
                        $item['time'],
                        $item['completed'] == "1",
                        $item['appointment_id']
                    );
                    $i = $i + 1	;
                }
                return $appointmentsOfSelectedVaccinationCenter;
            } else {
                return false;
            }
        }
        /**
         * Function που διαγράφει ένα ραντεβού από την βάση με το δοθέν id
         * επιστρέφει true,
         * σε περίπτωση σφάλματος false
         */
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
        /**
         * Function που εισάγει ένα ραντεβού στην βάση
         * επιστρέφει true,
         * σε περίπτωση σφάλματος αν είναι duplicate entry κάνει throw exception
         * με το ανάλογο μήνυμα αλλιώς επιστρέφει false
         */
        public function saveNewAppointment($vaccinationCenterId, $timeslot, $user) {
            $con = $this->connect();
            $query = "INSERT INTO appointments(vaccination_center_id, user_id, date, time)
                    VALUES (
                        '$vaccinationCenterId', 
                        '$user->id', 
                        '".$timeslot['date']."', 
                        '".$timeslot['time']."'                   
                    )";
            if(!mysqli_query($con, $query)) {
                if((stripos(mysqli_error($con), "Duplicate entry") !== false)) {
                    $message = 'appointmentErrorDuplicateEntry';  
                    mysqli_close($con);
                    throw new Exception($message);                  
                } else {
                    mysqli_close($con);
                    return false;
                }                
            } else return true;
            mysqli_close($con);            
        }
        /**
         * Function που εισάγει ένα εγγραφή στον πίνακα vaccination_centers_doctors στην βάση
         * επιστρέφει true,
         * σε περίπτωση σφάλματος επιστρέφει false
         */
        public function saveVaccinationCenterDoctor($vaccinationCenterId, $userId) {
            $con = $this->connect();
            $query = "INSERT INTO vaccination_centers_doctors(vaccination_center_id, user_id)
                    VALUES (
                        '$vaccinationCenterId', 
                        '$userId'
                    )";
            if(!mysqli_query($con, $query)) {             
                mysqli_close($con);
                return false;
                            
            } else {
                mysqli_close($con);
                return true;
            }
            
        }
        /**
         * Function που βρίσκει από την βάση τον χρήστη με το δοθέν id
         * επιστρέφει αντικείμενο User,
         * σε περίπτωση σφάλματος επιστρέφει null
         */
        public function getUserFromDbById($userId) {
            $con = $this->connect();
            $query = "select * from users where user_id = '".$userId."' limit 1";
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
                    mysqli_free_result($result);

                    return $user;
                }
            }
            return null;
        }
        /**
         * Function που ενημερώνει το πεδίο completed στο πίνακα appointments στην εγγραφή με το δοθέν id
         * επιστρέφει true,
         * σε περίπτωση σφάλματος επιστρέφει false
         */
        public function setStatusOfAppointment($appointmentId, $completed) {
            $con = $this->connect();
            $query = "UPDATE appointments SET `completed`='$completed' WHERE appointment_id='$appointmentId'";
            if(!mysqli_query($con, $query)) {             
                mysqli_close($con);
                return false;
                            
            } else {
                mysqli_close($con);
                return true;
            }
        }
    } 