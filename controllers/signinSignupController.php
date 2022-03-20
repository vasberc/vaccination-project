<?php 
	include("./dbManager/dbManager.php");
    //Αντικείμενο για την αναζήτηση και εγγραφή στην Βάση δεδομένων
    $dbManager = new DbManager();
    //Flag για την εμφάνιση μηνύματος error
    $hasError = isset($_GET['error']) ? $_GET['error'] == 1 ? true : false : false;
    
    //Αν υποβλήθηκε η φόρμα της εγγραφής
    if(isset($_POST['name']) && isset($_POST['surname']) && isset($_POST['amka1']) && 
    isset($_POST['afm1']) && isset($_POST['adt']) && isset($_POST['age']) && 
    isset($_POST['sex']) && isset($_POST['mobile']) && isset($_POST['role'])) {
        //Η Δημιουργία των αντικειμένων User μπορεί να προκαλέσει exception οπότε γίνεται σε try block
        try {
            //Αρχικοποίηση της μεταβλητής isDoctor
            if($_POST['role'] == 'civilian') {
                $isDoctor = false;
            } else if($_POST['role'] == 'doctor') {
                $isDoctor = true;
            } else {
                $isDoctor = null;
            }
            //Αρχικοποίηση της μεταβλητής email
            if (isset($_POST['email']) && trim($_POST['email']) !== "") {
                $email = $_POST['email'];
            } else {
                $email = null;
            }
            //Δημιουργία αντικείμενου User χωρίς id 
            $user = new User(
                $_POST['name'],
                $_POST['surname'],
                $_POST['amka1'],
                $_POST['afm1'],
                $_POST['adt'],
                $_POST['sex'],
                $email,
                $_POST['age'],
                $_POST['mobile'],
                $isDoctor
            );
        } catch (Exception $ex) {
        //Σε περίπτωση σφάλματος φορτώνει πάλι η σελίδα με τις μεταβλητές λάθους σαν query στο λινκ
        $message = $ex->getMessage();                
        header("Location: ./signin-signup.php?message=$message&error=1");
        exit();
        }
        //Έλεγχος ότι ο χρήστης δημιουργήθηκε
        if(isset($user)) {            
            try {
                //Με τον dbManager κάνουμε αποθήκευση στην βάση
                $dbManager->saveUserToDb($user);              
                //Αν επιτύχει η εγγραφή παίρνουμε τον χρήστη από την βάση για να έχουμε το id του
                $user = $dbManager->getUserFromDbByAmka($user->amka);
                //Αν ο χρήστης είναι γιατρός δημιουργούμε ένα αντικείμενο VaccinationCenterDoctor που είναι υποκλάση του user
                if($user->isDoctor) {
                    $user = new VaccinationCenterDoctor(
                        $user,
                        null,
                        null
                    );
                    startSession($user);
                    header("Location: ./doctor-page.php");
                    exit();
                }
                //Ξεκινάμε το session για τον χρήστη αυτό και μεταφερόμαστε αυτόματα στην σελίδα του χρήστη
                startSession($user);
                header("Location: ./userpage.php");
                exit();
            } catch (Exception $ex) {
                $message = $ex->getMessage();
                //Αν αποτύχει η αποθήκευση εμφάνιση μηνύματος ανάλογα το σφάλμα                
                header("Location: ./signin-signup.php?message=$message&error=1");
                exit();
            }
        }
    } else if (isset($_POST['amka']) && isset($_POST['afm'])) {
        //Αν υποβλήθηκε η φόρμα για το login καλούμε τον dbManager να μας βρει από την βάση τον χρήστη με τα στοιχεία που δόθηκαν
        $user = $dbManager->getUserFromDbForLogin(trim($_POST['amka']), trim($_POST['afm']));
        //Αν υπάρχει τέτοιος χρήστης τότε ξεκινάμε το session και μεταφερόμαστε στην σελίδα χρήστη
        if(isset($user)) {
            if($user->isDoctor) {
                //Αν ο χρήστης είναι γιατρός, κάνουμε get το αντικείμενο του γιατρού από το db
                $doctor = $dbManager->getDoctorFromDbByUser($user);
                /**
                 * Αν έρθει null αρχικοποιούμε ένα γιατρό χωρίς vaccinationCenterId και χωρίς vaccinationCenterDoctorId
                 * έπειτα θέτουμε τον τρέχον user να είναι ο γιατρός. 
                 * */
                if(!isset($doctor)) {
                    $user = new VaccinationCenterDoctor(
                        $user,
                        null,
                        null
                    );
                } else {
                    $user = $doctor;
                    startSession($user);
                    header("Location: ./doctor-page.php");
                    exit();
                }
            }
            startSession($user);
            header("Location: ./userpage.php");
            exit();
        } else {
            //Αλλιώς φορτώνουμε πάλι την σελίδα με error
            $message = 'userSignInError';
            header("Location: ./signin-signup.php?message=$message&error=1");
            exit();
        }
    }
        
?>