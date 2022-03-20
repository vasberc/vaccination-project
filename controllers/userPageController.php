<?php 
	include("./dbManager/dbManager.php");
    //Αντικείμενο για την αναζήτηση και εγγραφή στην Βάση δεδομένων
    $dbManager = new DbManager();

    //Flags για την εμφάνιση μηνύματος success ή error
    $hasError = isset($_GET['error']) ? $_GET['error'] == 1 ? true : false : false;
    $hasSucceed = isset($_GET['error']) ? $_GET['error'] == 0 ? true : false : false;

    //Ανάκτηση του ραντεβού του χρήστη, σε περίπτωση που είναι ήδη μέσα και ο Γιατρός του αλλάξει status να έχει ενημερωθεί
    $_SESSION['user']->appointment = $dbManager->getUserAppointmentFromDb($_SESSION['user']);
    
    //Εδώ θα μπει αν πατηθεί κάποιο κουμπί από τις hidden forms
    if(isset($_POST['action'])) {
        /**
         * Όταν πατηθεί το κουμπί κλείστε το ραντεβού σας, γίνεται έλεγχος αν ο χρήστης
         * ανήκει στην ηλικιακή ομάδα που εμβολιάζεται την τρέχουσα περίοδο, αν ανήκει 
         * μεταφερόμαστε στην σελίδα create appointment, αλλιώς φορτώνει ξανά η σελίδα 
         * με το ανάλογο μήνυμα σφάλματος.
         */
        if($_POST['action'] == 'create') {
            if($_SESSION['user']->age < 40 or $_SESSION['user']->age > 65) {
                $message = 'notCurrentVaccinationAgeGroup';
                header("Location: ./userpage.php?message=$message&error=1");
                exit();
            } else {
                header("Location: ./create-appointment.php");
                exit();
            }
        /**
         * Αν πατήθηκε το κουμπί ακυρώστε το ραντεβού σας, τότε διαγράφουμε από την βάση δεδομένων
         * το ραντεβού, το διαγράφουμε και από το πεδίο του χρήστη του session και εμφανίζουμε το
         * ανάλογο μήνυμα success.
         * Σε περίπτωση σφάλματος κατά την διαγραφή από την βάση δεδομένων, εμφανίζουμε το ανάλογο
         * μήνυμα.
         */
        } else if ($_POST['action'] == 'delete') {
            if($dbManager->deleteAppointment($_SESSION['user']->appointment->id)) {
                deleteAppointmentFromSession();
                $message = 'appointmentDeletedSuccessfully';
                header("Location: ./userpage.php?message=$message&error=0");
                exit();
            } else {
                $message = 'deleteAppointmentError';
                header("Location: ./userpage.php?message=$message&error=1");
                exit();
            }
        /**
         * Αν πατήθηκε το κουμπί αποσύνδεση, κάνουμε delete το session
         * και μεταφερόμαστε στο home page
         */
        } else if ($_POST['action'] == 'logout') {
            deleteSession();
            header("Location: ./index.php");
            exit();
        }
    } 
        
?>