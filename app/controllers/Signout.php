<?php
    class Signout extends Controller{
        public function __construct(){
            
        }

        public function index(){
            session_start();
            if(isset($_SESSION['user_id'])){
                unset($_SESSION['user_id']);
            }
            if(isset($_SESSION['role'])){
                unset($_SESSION['role']);
            }
            header("Location: ../home");
            return;
        }
    }
?>