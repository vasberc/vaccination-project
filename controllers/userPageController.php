<?php 
	include("./dbManager/dbManager.php");
    //Αντικείμενο για την αναζήτηση και εγγραφή στην Βάση δεδομένων
    $dbManager = new DbManager();
    //Μεταβλητή που θα λέει στην σελίσα αν υπάρχει σφάλμα για να εμφανίζει το ανάλογο μήνυμα
    $hasError = isset($_GET['error']) ? $_GET['error'] == 1 ? true : false : false;
    $hasSucceed = isset($_GET['error']) ? $_GET['error'] == 0 ? true : false : false;
    
    if(isset($_POST['action'])) {
        if($_POST['action'] == 'create') {
            if($_SESSION['user']->age < 40 or $_SESSION['user']->age > 65) {
                $message = 'notCurrentVaccinationAgeGroup';
                header("Location: ./userpage.php?message=$message&error=1");
            } else {
                header("Location: ./create-appointment.php");
            }
        } else if ($_POST['action'] == 'delete') {
            if($dbManager->deleteAppointment($_SESSION['user']->appointment->id)) {
                deleteAppointmentFromSession();
                $message = 'appointmentDeletedSuccessfully';
                header("Location: ./userpage.php?message=$message&error=0");
            } else {
                $message = 'deleteAppointmentError';
                header("Location: ./userpage.php?message=$message&error=1");
            }
            
        } else if ($_POST['action'] == 'logout') {
            deleteSession();
            header("Location: ./index.php");
        }
    } 
        
?>