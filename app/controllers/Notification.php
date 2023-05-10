<?php
    session_start();
    class Notification extends Controller{
        public $user_id;
        public $role;
        public function __construct(){
            $this->AuthorizeLogin();
            $this->user_id = $_SESSION['user_id'];
            $this->role = $_SESSION['role'];
        }

        public function index(){
            // for body header details of the accessor
            $data = $this->model("User")->getnotifications($this->user_id);
            $data['navigation'] = 'dashboard';
            $this->view($this->role.'/notifications',$data);
        }

        public function count(){
            $data['count'] = $this->model("User")->getnewnotificationcount($this->user_id);
            echo $data['count'];
        }
    }
?>