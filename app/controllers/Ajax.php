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

        public function vehicle(){
            $data = $this->model('Distributor')->eligibleVechicles(49);
            var_dump($data);
        }
    }
?>