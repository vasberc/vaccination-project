<?php
    class VaccinationCenter {

        private $id;
        private $name;
        private $address;
        private $postCode;
        private $telephoneNumber;
        private $doctorsId;

        //constructor που κατά το validation αν αποτύχει κάνει throw ένα exception
        function __construct($id, $name, $address, $postCode, $telephoneNumber, $doctorsId = null) {
            $this->id = $id;
            $this->name = $name;
            $this->address = $address;
            $this->postCode = $postCode;
            $this->telephoneNumber = $telephoneNumber;
            $this->doctorsId = $doctorsId;
        }

        //Getters
        function __get($attr) {
            return $this->$attr;
        }
        //Setters
        function __set($atrr, $value) {
            switch ($atrr) {
                case 'doctorsId':
                    $this->$atrr = $value;                  
                    break;
                    
                default:
                    $exMessage = 'setterOnlyForDoctors';                            
                    throw new Exception($exMessage);
                    break;
            }
        }
    }
