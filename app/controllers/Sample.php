<?php
    class Sample extends Controller{
        public function __construct(){
            
        }

        public function index(){
            $this->view('dealer/sample');
        }

        public function charge(){
            $c_email = $_POST['customer_email'];
            $amount = $_POST['amount'];
            $dealer_id = $_POST['dealer_id'];
            $restkey = 'rk_test_51Mlx3nB8mjSuIMbv89nNBY2afbg1oxGt0tLflMSOjeRn5xMfrRzrlCgAtnKlqsfiC5ZUM8gKWqFdcn62mtcaiv2y00axWgBtHV';
            $ch = new Charge($restkey,"Random Bits",$amount);
            if($ch->make()){
                echo "Success";
            }else{
                echo "Failed";
            }
        }
    }
?>