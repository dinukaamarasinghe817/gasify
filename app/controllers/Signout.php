<?php
    class Signout extends Controller{
        public function __construct(){
            
        }

        public function index(){
            session_start();
            session_destroy();
            header("Location: home");
            return;
        }
    }
?>