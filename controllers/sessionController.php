<?php 
    include ("./models/User.php");
    include ("./models/VaccinationCenterDoctor.php");
    include("./models/Appointment.php");
    include ("./models/VaccinationCenter.php");
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
    function deleteAppointmentFromSession() {
        $_SESSION['user']->appointment = null;
    }
    //Μεταβλητή boolean που είναι true μόνο αν ο χρήστης έχει κάνει login
    $isLoggedIn = isset($_SESSION['user']);
?>