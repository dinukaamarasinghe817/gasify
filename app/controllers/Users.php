<?php
    session_start();
class Users extends Controller{
    public $user_id;
    function __construct(){
        parent::__construct();
        $this->user_id = $_SESSION['user_id'];
    }

    public function validate($user_id,$validity){
        $data = $this->model("Admin")->validatecustomer($user_id,$validity);
    }

    function companies(){
        $data = $this->model("Admin")->companies();
        $row = mysqli_fetch_assoc($this->model("Admin")->getAdmin($this->user_id));
        $data['image'] = $row['image'];
        $data['name'] = $row['first_name'].' '.$row['last_name'];
        $this->view('admin/companies', $data);
    }
    
    function distributors(){
        $data = $this->model("Admin")->distributors();
        $row = mysqli_fetch_assoc($this->model("Admin")->getAdmin($this->user_id));
        $data['image'] = $row['image'];
        $data['name'] = $row['first_name'].' '.$row['last_name'];
        $this->view('admin/distributors', $data);
    }

    function dealers(){
        $data = $this->model("Admin")->dealers();
        $row = mysqli_fetch_assoc($this->model("Admin")->getAdmin($this->user_id));
        $data['image'] = $row['image'];
        $data['name'] = $row['first_name'].' '.$row['last_name'];
        $this->view('admin/dealers', $data);
    }

    function deliveries($tab=null){
        $data = $this->model("Admin")->deliveries();
        $row = mysqli_fetch_assoc($this->model("Admin")->getAdmin($this->user_id));
        $data['image'] = $row['image'];
        $data['name'] = $row['first_name'].' '.$row['last_name'];
        if($tab != null){
            $this->view('admin/deliverycharges', $data);
        }else{
            $this->view('admin/deliveries', $data);
        }
    }

    function customers(){
        $data = $this->model("Admin")->customers();
        $row = mysqli_fetch_assoc($this->model("Admin")->getAdmin($this->user_id));
        $data['image'] = $row['image'];
        $data['name'] = $row['first_name'].' '.$row['last_name'];
        $this->view('admin/customers', $data);
    }

}