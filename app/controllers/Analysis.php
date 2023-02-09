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
            $start_date = '';
            $end_date = '';
            $data = $this->model("Dealer")->getanalysis($this->user_id,$start_date,$end_date);
            $row = mysqli_fetch_assoc($this->model('Dealer')->getDealer($this->user_id));
            $data['image'] = $row['image'];
            $data['name'] = $row['first_name'].' '.$row['last_name'];
            $data['navigation'] = 'dashboard';
            // echo count($data['charts']);
            $this->view('dealer/analysis',$data);
        }

        public function admin(){
            $start_date = '';
            $end_date = '';
            $data = $this->model("Admin")->getanalysis($this->user_id,$start_date,$end_date);
            $row = mysqli_fetch_assoc($this->model('Admin')->getAdmin($this->user_id));
            $data['image'] = $row['image'];
            $data['name'] = $row['first_name'].' '.$row['last_name'];
            $data['navigation'] = 'dashboard';
            $this->view('admin/analysis',$data);
        }
    }
?>