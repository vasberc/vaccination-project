<?php 

    include("./dbManager/dbManager.php");
    //Αντικείμενο για την αναζήτηση και εγγραφή στην Βάση δεδομένων
    $dbManager = new DbManager();
    //Flags για την εμφάνιση μηνύματος success ή error
    $hasError = isset($_GET['error']) ? $_GET['error'] == 1 ? true : false : false;
    $hasSucceed = isset($_GET['error']) ? $_GET['error'] == 0 ? true : false : false;

    //Παίρνουμε από την βάση όλα τα ραντεβού από το εμβολιαστικό κέντρο που εργάζεται ο Γιατρός
    $scheduledAppointments = $dbManager->getAppointmentsOfSelectedVaccinationCenter($_SESSION['user']->vaccinationCenter->id);

    /**
     * Όταν επιλέγεται αλλαγή κατάστασης ραντεβού, σώσουμε την νέα κατάσταση στην βάση δεδομένων
     * και έπειτα φορτώνουμε πάλι την σελίδα με το μήνυμα success.
     * Αν προκύψει κάποιο σφάλμα στην σελίδα εμφανίζεται το ανάλογο error message
     */
    if(isset($_GET['appointment_id']) && isset($_GET['completed'])) {
        if($dbManager->setStatusOfAppointment($_GET['appointment_id'], $_GET['completed'])) {
            $message = 'statusChangedSuccess'; 
            header("Location: ./scheduled-appointments.php?message=$message&error=0");
            exit();
        } else {
            $message = 'statusChangedError'; 
            header("Location: ./scheduled-appointments.php?message=$message&error=1");
            exit();
        }
    }
            
    
?>