<?php
    class Controller{
        public function __construct(){

        }

        public function model($model){
            require_once '../app/models/'.$model.'.php';

            return new $model();
        }

        public function view($view, $data = []){
            if(file_exists('../app/views/'.$view.'.php')){
                require_once '../app/views/'.$view.'.php';
            }else{
                die('View could not be found!');
            }

        }

        public function AuthorizeLogin(){
            if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
                header('Location: ' . BASEURL . '/home');
            }
        }
        
        public function AuthorizeUser($user){
            if(!isset($_SESSION['role']) || $_SESSION['role'] != $user){
                header('Location: ' . BASEURL . '/home');
            }
        }
    }
?>