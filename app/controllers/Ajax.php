<?php
    class Ajax extends Controller{
        public function __construct(){
            
        }

        public function index(){
            $data['error'] = 'input all fields';
            if($data['error']){
                echo $data['error'];
            }else{
                $this->view('',$data);
            }
        }

        public function ebill($bill_no){
            // $this->model('Admin')->gever();
            if(verify_ebill($bill_no)){
                echo "good";
            }else{
                echo "bad";
            }
            // echo getDistance("No 43, Lional Jayasinghe Mawatha, Godagama","No 43, Lional Jayasinghe Mawatha, Godagama");
        }
    }
?>