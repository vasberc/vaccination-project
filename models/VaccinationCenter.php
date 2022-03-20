<?php
    class VaccinationCenter {

        private $id;
        private $name;
        private $address;
        private $postCode;
        private $telephoneNumber;

        //constructor που κατά το validation αν αποτύχει κάνει throw ένα exception
        function __construct($id, $name, $address, $postCode, $telephoneNumber) {
            $this->id = $id;
            $this->name = $name;
            $this->address = $address;
            $this->postCode = $postCode;
            $this->telephoneNumber = $telephoneNumber;
        }

        //Getters
        function __get($attr) {
            return $this->$attr;
        }
        
    }
