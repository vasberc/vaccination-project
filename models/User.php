<?php
    class User {

        protected $id;
        protected $name;
        protected $surname;
        protected $amka;
        protected $afm;
        protected $adt;
        protected $sex;
        protected $email;
        protected $age;
        protected $mobile;
        protected $isDoctor;
        private $appointment;

        //constructor που κατά το validation αν αποτύχει κάνει throw ένα exception
        function __construct($name, $surname, $amka, $afm, $adt, $sex, $email, $age, $mobile, $isDoctor, $id = null) {
            
            //Εδώ γίνεται το validation καλώντας τις ανάλογες συναρτήσεις
            $id = isset($id) && is_numeric($id) ? $id : null;          
            $name = $this->mandatoryPattern($name) ? trim($name) : false ;
            $surname = $this->mandatoryPattern($surname) ? trim($surname) : false ;
            $amka = $this->amkaPattern($amka) ? trim($amka) : false ;
            $afm = $this->afmPattern($afm) ? trim($afm) : false ;
            $adt = $this->mandatoryPattern($adt) ? trim($adt) : false ;
            $sex = $this->sexPattern($sex) ? trim($sex) : false ;
            $email = isset($email) ? $this->emailPattern($email) ? trim($email) : false : null ;
            $age = is_numeric($age) && $age > 17 && $age < 151 ? $age : false;            
            $mobile = $this->mobilePattern($mobile) ? trim($mobile) : false ;
            $isDoctor = isset($isDoctor) ? $isDoctor : null;

            //Έλεγχος αν έχει γίνει το validation σωστά
            if($name && $surname && $amka && $afm && $adt && $sex !== false && $email !== false && $age && $mobile && isset($isDoctor)) {
                $this->id = $id;
                $this->name = $name;
                $this->surname = $surname;
                $this->amka = $amka;
                $this->afm = $afm;
                $this->adt = $adt;
                $this->sex = $sex;
                $this->email = $email;
                $this->age = $age;
                $this->mobile = $mobile;
                $this->isDoctor = $isDoctor;
            } else {
                
                $exMessage = 'userConstructorError';

                throw new Exception($exMessage);
            }
        }

        //Getters
        function __get($attr) {
            return $this->$attr;
        }
        // function  getAppointment(): Appointment {
        //     return $this->appointment;
        // }
        // function setAppointment(Appointment $appointment) {
        //     $this->appointment = $appointment;
        // }
        //Setters
        function __set($atrr, $value) {
            switch ($atrr) {
                case 'appointment':
                    $this->$atrr = $value;                  
                    break;
                    
                default:
                    $exMessage = 'setterOnlyForAppointment';                            
                    throw new Exception($exMessage);
                    break;
            }
        }
            
        private function mandatoryPattern($field) {
             //Υποχρεωτικό πεδίο             
             return trim($field) != "";
        }
        private function afmPattern($afm) {
            //Να είναι 9 αριθμοί 
            $pattern = '/^[0-9]{9}$/';
            return preg_match($pattern, $afm);
        }
        private function amkaPattern($amka) {
            //Να είναι 11 αριθμοί 
            $pattern = '/^[0-9]{11}$/';
            return preg_match($pattern, $amka);
        }
        private function sexPattern($sex) {
            //Επιτρέπει μόνο τις λέξεις male, female ή να μην έχει συμπληρωθεί          
            return $sex == 'male' or $sex == 'female' or $sex == null;
        }
        private function emailPattern($email) {
            //Να έχει απλά το @ αν δεν είναι άδειο          
            return strpos($email, '@') !== false ;
        }
        private function mobilePattern($mobile) {
            //Να είναι 10 αριθμοί 
            $pattern = '/^[0-9]{10}$/';
            return preg_match($pattern, $mobile);
        }
        
    }
