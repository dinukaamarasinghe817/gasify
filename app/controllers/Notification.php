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
            $data = $this->model("User")->getnotifications($this->user_id);
            switch($this->role){
                case 'dealer':
                    $model = "Dealer";
                    $func = "getDealer";
                    break;
                case 'customer':
                    $model = "Customer";
                    $func = "getCustomerImage";
                    break;
                case 'distributor':
                    $model = "Distributor";
                    $func = "getDistributorImage";
                    break;
                case 'delivery':
                    $model = "Delivery";
                    $func = "getDeliveryImage";
                    break;
                case 'company':
                    $model = "Company";
                    $func = "getCompanyImage";
                    break;
                case 'admin':
                    $model = "Admin";
                    $func = "getAdmin";
                    break;
            }
            $row = mysqli_fetch_assoc($this->model($model)->$func($this->user_id));
            if(isset($row['image'])){$data['image'] = $row['image'];}
            else if(isset($row['logo'])){$data['image'] = $row['logo'];}
            else{}
            $data['name'] = $row['first_name'].' '.$row['last_name'];
            $data['navigation'] = 'dashboard';
            $this->view($this->role.'/notifications',$data);
        }
    }
?>