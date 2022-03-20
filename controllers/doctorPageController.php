<?php 
	include("./dbManager/dbManager.php");
    //Αντικείμενο για την αναζήτηση και εγγραφή στην Βάση δεδομένων
    $dbManager = new DbManager();

    //Flags για την εμφάνιση μηνύματος success ή error
    $hasError = isset($_GET['error']) ? $_GET['error'] == 1 ? true : false : false;
    $hasSucceed = isset($_GET['error']) ? $_GET['error'] == 0 ? true : false : false;

    //Όταν φορτώνει η σελίδα αν ο Γιατρός δεν έχει επιλέξει εμβολιαστικό κέντρο τα παίρνουμε από την βάση δεδομένων
    if($_SESSION['user']->vaccinationCenter == null) {
        $vaccinationCenters = $dbManager->getVaccinationCenters();
    }
    
    
    //Εδώ θα μπει αν πατηθεί κάποιο κουμπί από τις hidden forms
    if(isset($_POST['action'])) {
        /**
         * Αν πατήθηκε η καταχώρηση εμβολιαστικού κέντρου, αλλά είχε ήδη καταχωρηθεί
         * φορτώνει πάλι η σελίδα με το ανάλογο error message
         */
        if($_POST['action'] == 'registered') { 
            $message = 'alreadyRegistered'; 
            header("Location: ./doctor-page.php?message=$message&error=1");
            exit();
        /**
         * Αν πατήθηκε το κουμπί προγραμματισμένα ραντεβού ενώ δεν έχει καταχωρηθεί
         * εμβολιαστικό κέντρο, φορτώνει πάλι η σελίδα με το ανάλογο error message
         */
        } else if ($_POST['action'] == 'notRegistered') {
            $message = 'pleaseRegisterVaccinationCenter'; 
            header("Location: ./doctor-page.php?message=$message&error=1");
            exit();
        /**
         * Αν πατήθηκε το κουμπί προγραμματισμένα ραντεβού μεταφερόμαστε στην σελίδα
         * προγραμματισμένα ραντεβού
         */
        } else if ($_POST['action'] == 'scheduledAppointments') {
            header("Location: ./scheduled-appointments.php");
            exit();
        /**
         * Αν πατήθηκε το κουμπί αποσύνδεση, κάνουμε delete το session
         * και μεταφερόμαστε στο home page
         */
        } else if ($_POST['action'] == 'logout') {
            deleteSession();
            header("Location: ./index.php");
            exit();
        }
    /**
     * Αν επιλέχθηκε εμβολιαστικό κέντρο για καταχώρηση, παίρνουμε το id του
     * και το αποθηκεύουμε στην βάση δεδομένων. Μετά παίρνουμε από την βάση
     * ξανά τον γιατρό, που πλέον θα έχει καταχωρημένο το εμβολιαστικό του κέντρο,
     * και τον θέτουμε σαν τρέχον χρήστη του session και μεταφερόμαστε πάλι
     * στην σελίδα του Γιατρού με success message.
     * Σε περίπτωση σφάλματος κατά την καταχώρηση του εμβολιαστικού κέντρου,
     * μεταφερόμαστε στην σελίδα του γιατρού με το ανάλογο μήνυμα σφάλματος.
     */
    } else if (isset($_POST['register_vaccination_center_with_id'])) {
        if($dbManager->saveVaccinationCenterDoctor($_POST['register_vaccination_center_with_id'], $_SESSION['user']->id)) {
            $doctor = $dbManager->getDoctorFromDbByUser($_SESSION['user']);
            if($doctor) {
                $_SESSION['user'] = $doctor;
                $message = 'registrationSuccess'; 
                header("Location: ./doctor-page.php?message=$message&error=0");
                exit();
            }                
        }
        $message = 'registrationError'; 
        header("Location: ./doctor-page.php?message=$message&error=1");
        exit();            
    }
        
?>