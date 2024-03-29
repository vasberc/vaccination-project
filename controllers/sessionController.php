<?php 
    include ($_SERVER['DOCUMENT_ROOT']."/models/User.php");
    include ($_SERVER['DOCUMENT_ROOT']."/models/VaccinationCenterDoctor.php");
    include($_SERVER['DOCUMENT_ROOT']."/models/Appointment.php");
    include ($_SERVER['DOCUMENT_ROOT']."/models/VaccinationCenter.php");
    //Κώδικας που συμπεριλαμβάνεται στην κορυφή κάθε σελίδας και δίνει την δυνατότητα να γνωρίζουμε αν ο χρήστης έχει κάνει login
	session_start();    
    //Function για να εκκινήσουμε ένα session
    function startSession(User $user) {
        $_SESSION['user'] = $user;
    }
    //Function για να τερματίσουμε ένα session
    function deleteSession() {
        unset($_SESSION['user']);
    }
    //Μεταβλητή boolean που είναι true μόνο αν ο χρήστης έχει κάνει login
    $isLoggedIn = isset($_SESSION['user']);
?>