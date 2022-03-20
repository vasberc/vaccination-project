<?php

    /** 
     * Κλάση Appointment, αντιστοιχεί στον πίνακα του db appointments και περιέχει όλα πεδία του πίνακα
     */
    class Appointment {

        private $id;
        private $vaccinationCenter;
        private $user;
        private $date;
        private $time;
        private $completed;

        /** 
         * constructor με το id να έχει default τιμή null, γιατί αντιστοιχεί στο πεδίο appointment_id
         * και το παίρνουμε μετά την εγγραφή στην βάση δεδομένων
         */
        function __construct($vaccinationCenter, $user, $date, $time, $completed, $id = null) {
            $this->id = $id;
            $this->vaccinationCenter = $vaccinationCenter;
            $this->user = $user;
            $this->date = $date;
            $this->time = $time;
            $this->completed = $completed;
        }

        //Getters
        function __get($attr) {

            return $this->$attr;
        }
        //Setters, δυνατότητα να αλλάζει μόνο το πεδίο completed
        function __set($atrr, $value) {
            switch ($atrr) {
                case 'completed':
                    $this->$atrr = $value;                  
                    break;

                default:
                    $exMessage = 'setterOnlyForCompleted';                            
                    throw new Exception($exMessage);
                    break;
            }
        }
    }
