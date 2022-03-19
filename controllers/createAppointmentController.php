<?php 

    include("./dbManager/dbManager.php");
    //Αντικείμενο για την αναζήτηση και εγγραφή στην Βάση δεδομένων
    $dbManager = new DbManager();
    //Μεταβλητή που θα λέει στην σελίδα αν υπάρχει σφάλμα για να εμφανίζει το ανάλογο μήνυμα
    $hasError = isset($_GET['error']) ? $_GET['error'] == 1 ? true : false : false;
    $hasSucceed = isset($_GET['error']) ? $_GET['error'] == 0 ? true : false : false;

    $timeslot[1]['date'] = '2022-04-01'; $timeslot[1]['time'] = '08:00:00';
    $timeslot[2]['date'] = '2022-04-01'; $timeslot[2]['time'] = '09:00:00';
    $timeslot[3]['date'] = '2022-04-01'; $timeslot[3]['time'] = '10:00:00';

    $timeslot[4]['date'] = '2022-04-02'; $timeslot[4]['time'] = '08:00:00';
    $timeslot[5]['date'] = '2022-04-02'; $timeslot[5]['time'] = '09:00:00';
    $timeslot[6]['date'] = '2022-04-02'; $timeslot[6]['time'] = '10:00:00';

    //Όταν φορτώνει η σελίδα παίρνουμε από την βάση όλα τα εμβολιαστικά κέντρα
    $vaccinationCenters = $dbManager->getVaccinationCenters();
    $selectedVaccinationCenter = false;
    $reservedAppointments = false;
    //Επιλογή εμβολιαστικού κέντρου από το drop down
    if(isset($_GET['vaccination_center_id']) && isset($_GET['timeslot'])) {      
        try {
            if($dbManager->saveNewAppointment($_GET['vaccination_center_id'], $timeslot[(int)$_GET['timeslot']], $_SESSION['user'])) {
                $_SESSION['user']->appointment = $dbManager->getUserAppointmentFromDb($_SESSION['user']);
                $message = 'appointmentSavedSuccessfully';
                //Αν καταχωρηθεί σωστά το ραντεβού μεταφορά στην αρχική χρήστη με success message              
                header("Location: ./userpage.php?message=$message&error=0");
                exit();
            } else {
                $message = 'saveAppointmentError';
                //Αν προκύψει σφάλμα κατά την δημιουργία του ραντεβού μήνυμα σφάλματος
                header("Location: ./create-appointment.php?message=$message&error=1");
                exit();
            }
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            //Αν αποτύχει η αποθήκευση εμφάνιση μηνύματος ανάλογα το σφάλμα              
            header("Location: ./create-appointment.php?message=$message&error=1");
            exit();
        }
         
        
    } else if (isset($_GET['vaccination_center_id'])) {
        foreach($vaccinationCenters as $item) {
            if($item->id == $_GET['vaccination_center_id']) {
                $selectedVaccinationCenter = $item;
            }
        } 
        
        if($selectedVaccinationCenter) {
            $slotOneAvailable = true;
            $slotTwoAvailable = true;
            $slotThreeAvailable = true;
            $slotFourAvailable = true;
            $slotFiveAvailable = true;
            $slotSixAvailable = true;
            $reservedAppointments = $dbManager->getAppointmentsOfSelectedVaccinationCenter($selectedVaccinationCenter->id);
            if($reservedAppointments) {
                foreach($reservedAppointments as $item) {
                    switch($item->date) {
                        case '2022-04-01':
                            if($item->time == '08:00:00') {
                                $slotOneAvailable = false;
                            } else if ($item->time == '09:00:00') {
                                $slotTwoAvailable = false;
                            } else if ($item->time == '10:00:00') {
                                $slotThreeAvailable = false;
                            }
                            break;
                        case '2022-04-02':
                            if($item->time == '08:00:00') {
                                $slotFourAvailable = false;
                            } else if ($item->time == '09:00:00') {
                                $slotFiveAvailable = false;
                            } else if ($item->time == '10:00:00') {
                                $slotSixAvailable = false;
                            }
                            break;
                    }
                } 
            }
        }
    }
    
?>