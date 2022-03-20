<?php 

    include("./dbManager/dbManager.php");
    //Αντικείμενο για την αναζήτηση και εγγραφή στην Βάση δεδομένων
    $dbManager = new DbManager();
    //Μεταβλητή που θα λέει στην σελίδα αν υπάρχει σφάλμα για να εμφανίζει το ανάλογο μήνυμα
    $hasError = isset($_GET['error']) ? $_GET['error'] == 1 ? true : false : false;
    $hasSucceed = isset($_GET['error']) ? $_GET['error'] == 0 ? true : false : false;

    $scheduledAppointments = $dbManager->getAppointmentsOfSelectedVaccinationCenter($_SESSION['user']->vaccinationCenter->id);

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