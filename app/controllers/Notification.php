<?php
    session_start();
    class Notification extends Controller{
        public $user_id;
        public $role;
        public function __construct(){
            $this->user_id = $_SESSION['user_id'];
            $this->role = $_SESSION['role'];
        }

        public function index(){
            // for body header details of the accessor
            switch($this->role){
                case 'dealer':
                    $model = "Dealer";
                    $func = "getDealer";
                    break;
                case 'customer':
                    $model = "Customer";
                    $func = "getCustomerImage";
                    break;
            }
            // $row = mysqli_fetch_assoc($this->model($model)->$func($this->user_id));
            $data['image'] = $row['image'];
            $data['name'] = $row['first_name'].' '.$row['last_name'];
            $data['navigation'] = 'dashboard';
            $this->view($this->user_id.'/notifications',$data);
        }
    }
?>