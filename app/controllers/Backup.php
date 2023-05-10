<?php
    class Backup extends Controller{
        public function __construct(){
            $this->AuthorizeLogin();
        }

        public function index(){
            $this->AuthorizeUser('admin');
            $data['error'] = 'input all fields';
            if($data['error']){
                echo $data['error'];
            }else{
                $this->view('',$data);
            }
        }

        public function takebackup(){
            $this->AuthorizeUser('admin');
            $this->model('Admin')->takebackup();
        }
    }
?>