<?php
    class Ajax extends Controller{
        public function __construct(){
            
        }

        public function index(){
            $this->model('Test')->test();
            
            // echo randomString();
        }

        public function vehicle(){
            $data = $this->model('Distributor')->eligibleVechicles(49);
            var_dump($data);
        }

        public function just(){
            $stripeKey = 'hello world';
            echo $stripeKey;
            echo '<br>';
            echo encryptStripeKey($stripeKey);
            echo '<br>';
            echo decryptStripeKey(encryptStripeKey($stripeKey));
        }
    }
?>