<?php
    class VaccinationCenterDoctor extends User {

        /** 
         * Κλάση που εξειδικεύει την κλάση User και τα 2 extra πεδία που έχει
         * αντιστοιχούν στα πεδία vaccination_centers_doctors_id, vaccination_center_id του πίνακα
         * vaccination_centers_doctors της βάσης δεδομένων.
         * Εκμεταλλευόμενος την δυνατότητα της php για δυναμικό ορισμό type στα
         * variables πολλές φορές μέσα στο project το vaccinationCenter το έχω αντιστοιχήσει
         * με το αντικείμενο που αντιστοιχεί το vaccination_center_id που υπάρχει στον πίνακα
         * vaccination_centers_doctors.
         */
        private $vaccinationCentersDoctorsId;
        private $vaccinationCenter;

        /**
         * Ο constructor δέχεται ένα αντικείμενο User και στην ουσία το μετατρέπει σε αντικείμενο
         * VaccinationCenterDoctor, δίνοντας default τιμές null στα πεδία vaccinationCenter και vaccinationCentersDoctorsId
         * γιατί ο γιατρός πρέπει να επιλέξει μόνος του το κέντρο εμβολιασμού που εργάζεται, άρα το πεδίο
         * μπορεί να είναι κοινό, έτσι δεν υπάρχει εγγραφή στο db και δεν μπορεί να υπάρχει ούτε vaccination_centers_doctors_id
         * στην περίπτωση αυτή.
         */
        function __construct($user, $vaccinationCenter = null, $vaccinationCentersDoctorsId = null) {
            parent::__construct(
                $user->name,
                $user->surname,
                $user->amka,
                $user->afm,
                $user->adt,
                $user->sex,
                $user->email,
                $user->age,
                $user->mobile,
                $user->isDoctor,
                $user->id
            );
            $this->vaccinationCentersDoctorsId = $vaccinationCentersDoctorsId;
            $this->vaccinationCenter = $vaccinationCenter;
        }

        //Getters
        function __get($attr) {
            return $this->$attr;
        }
        //Setters μόνο για τα πεδία vaccinationCenter, doctorId
        function __set($atrr, $value) {
            switch ($atrr) {
                case 'vaccinationCenter':
                case 'vaccinationCentersDoctorsId':
                    $this->$atrr = $value;                  
                    break;
                    
                default:
                    $exMessage = 'setterOnlyForVaccinationCenter';                            
                    throw new Exception($exMessage);
                    break;
            }
        }
    }
