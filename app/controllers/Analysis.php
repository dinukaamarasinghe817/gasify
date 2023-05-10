<?php
    session_start();
    class Analysis extends Controller{
        public $user_id;
        public $role;
        public function __construct(){
            $this->AuthorizeLogin();
            $this->user_id = $_SESSION['user_id'];
            $this->role = $_SESSION['role'];
        }

        public function dealer(){
            $this->AuthorizeUser('dealer');
            if(isset($_POST['start_date'])){
                $start_date = $_POST['start_date'];
            }else{
                $start_date = null;
            }

            if(isset($_POST['end_date'])){
                $end_date = $_POST['end_date'];
            }else{
                $end_date = date('Y-m-d');
            }
            
            $data = $this->model("Dealer")->getanalysis($this->user_id,$start_date,$end_date);
            $row = mysqli_fetch_assoc($this->model('Dealer')->getDealer($this->user_id));
            $data['date_joined'] = $row['date_joined'];
            $data['navigation'] = 'dashboard';
            $this->view('dealer/analysis',$data);
        }

        public function dealerrefresh(){
            $start_date = $_POST['start_date'];
            echo $start_date;
            //echo json_encode($this->model("Dealer")->getanalysis($this->user_id,$start_date,$end_date));
        }

        public function admin(){
            $this->AuthorizeUser('admin');
            if(isset($_POST['start_date'])){
                $start_date = $_POST['start_date'];
            }else{
                $start_date = null;
            }

            if(isset($_POST['end_date'])){
                $end_date = $_POST['end_date'];
            }else{
                $end_date = date('Y-m-d');
            }

            if(isset($_POST['company'])){
                $company = $_POST['company'];
            }else{
                $company = 'all';
            }
            $data = $this->model("Admin")->getanalysis($this->user_id,$start_date,$end_date,$company);
            $data['navigation'] = 'dashboard';
            $this->view('admin/analysis',$data);
        }
    }
?>