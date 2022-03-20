<?php
    class Appointment {

        private $id;
        private $vaccinationCenter;
        private $user;
        private $date;
        private $time;
        private $completed;

        //constructor που κατά το validation αν αποτύχει κάνει throw ένα exception
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
        //Setters
        function __set($atrr, $value) {
            switch ($atrr) {
                case 'completed':
                    $this->$atrr = $value;                  
                    break;
                
                case 'user':
                    $this->$atrr = $value;                  
                    break;
                    
                default:
                    $exMessage = 'setterOnlyForCompletedAndUser';                            
                    throw new Exception($exMessage);
                    break;
            }
        }
    }
