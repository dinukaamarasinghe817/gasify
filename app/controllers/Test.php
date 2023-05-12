<?php
// this controller is used to test the functionality of individual units
    class Test extends Controller{
        public function __construct(){
            
        }

        public function index(){
            
        }

        public function testDeliveryCharges(){
            $order_id = 18; //any order_id in the database
            $street = "No:30, Temple Road"; 
            $city = "Boralesgamuwa";

            echo $this->model("Customer")->get_delivery_charge($order_id,$street,$city);

        }

        public function testPasswordStrength($password){
            if(isPasswordNotStrength($password)){
                echo "FALSE";
            }else{
                echo "TRUE";
            }
        }

        public function testEmailValidation($email){
            if(isNotValidEmail($email)){
                echo "FALSE";
            }else{
                echo "TRUE";
            }
        }

        public function testRandomPasswordGeneration(){
            if(isPasswordNotStrength(randomString())){
                echo "FALSE";
            }else{
                echo "TRUE";
            }
        }


        
    }
?>