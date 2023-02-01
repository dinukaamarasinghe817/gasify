<?php
    session_start();
    class Analysis extends Controller{
        public $user_id;
        public $role;
        public function __construct(){
            $this->user_id = $_SESSION['user_id'];
            $this->role = $_SESSION['role'];
        }

        public function dealer(){
            $data = $this->view();
            $this->view('dealer/analysis',$data);
        }
    }
?>