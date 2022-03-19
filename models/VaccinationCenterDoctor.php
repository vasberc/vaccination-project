<?php
    class VaccinationCenterDoctor extends User {

        private $doctorId;
        private $vaccinationCenter;

        //constructor που κατά το validation αν αποτύχει κάνει throw ένα exception
        function __construct($user, $vaccinationCenter = null, $doctorId = null ) {
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
            $this->doctorId = $doctorId;
            $this->vaccinationCenter = $vaccinationCenter;
        }

        //Getters
        function __get($attr) {
            return $this->$attr;
        }
        //Setters
        function __set($atrr, $value) {
            switch ($atrr) {
                case 'vaccinationCenter':
                case 'doctorId':
                    $this->$atrr = $value;                  
                    break;
                    
                default:
                    $exMessage = 'setterOnlyForVaccinationCenter';                            
                    throw new Exception($exMessage);
                    break;
            }
        }
    }
