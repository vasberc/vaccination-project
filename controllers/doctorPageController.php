<?php 
	include("./dbManager/dbManager.php");
    //Αντικείμενο για την αναζήτηση και εγγραφή στην Βάση δεδομένων
    $dbManager = new DbManager();
    //Μεταβλητή που θα λέει στην σελίσα αν υπάρχει σφάλμα για να εμφανίζει το ανάλογο μήνυμα
    $hasError = isset($_GET['error']) ? $_GET['error'] == 1 ? true : false : false;
    $hasSucceed = isset($_GET['error']) ? $_GET['error'] == 0 ? true : false : false;

    //Όταν φορτώνει η σελίδα παίρνουμε από την βάση όλα τα εμβολιαστικά κέντρα
    $vaccinationCenters = $dbManager->getVaccinationCenters();
    
    if(isset($_POST['action'])) {
        if($_POST['action'] == 'registered') { 
            $message = 'alreadyRegistered'; 
            header("Location: ./doctor-page.php?message=$message&error=1");
            exit();
        } else if ($_POST['action'] == 'register') {
            $message = 'alreadyRegistered'; 
            header("Location: ./doctor-page.php?message=$message&error=0");
            exit();
        } else if ($_POST['action'] == 'notRegistered') {
            $message = 'pleaseRegisterVaccinationCenter'; 
            header("Location: ./doctor-page.php?message=$message&error=1");
            exit();
        } else if ($_POST['action'] == 'scheduledAppointments') {

            header("Location: ./scheduled-appointments.php");
            exit();
        } else if ($_POST['action'] == 'logout') {
            deleteSession();
            header("Location: ./index.php");
            exit();
        }
    } 
        
?>