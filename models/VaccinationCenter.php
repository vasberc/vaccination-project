<?php
    class VaccinationCenter {
        /** 
         * Κλάση που αντιστοιχεί με τον πίνακα vaccination-centers
         * Λόγω του ότι η εισαγωγή στην βάση δεδομένων έχει γίνει από εμάς
         * το id δεν έχει default τιμή γιατί η κλάση χρησιμοποιείται μόνο
         * για ήδη υπάρχουσες εγγραφές στο db.
         * Για τον ίδιο λόγο υπάρχουν ορισμένοι μόνο οι getters
         */
        private $id;
        private $name;
        private $address;
        private $postCode;
        private $telephoneNumber;
        
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
