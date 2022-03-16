<?php 

    include("./dbManager/dbManager.php");
    //Αντικείμενο για την αναζήτηση και εγγραφή στην Βάση δεδομένων
    $dbManager = new DbManager();
    //Μεταβλητή που θα λέει στην σελίσα αν υπάρχει σφάλμα για να εμφανίζει το ανάλογο μήνυμα
    $hasError = isset($_GET['error']) ? $_GET['error'] == 1 ? true : false : false;
    $hasSucceed = isset($_GET['error']) ? $_GET['error'] == 0 ? true : false : false;

    $vaccinationCenters = $dbManager->getVaccinationCenters();
    $selectedVaccinationCenter = false;
    $reservedAppointments = false;
    if(isset($_GET['vaccination_center_id'])) {
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
                                $slotTwoAvailable = false;
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