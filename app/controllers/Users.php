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
        if(isset($_POST['option'])){
            $option = $_POST['option'];
        }else{
            $option = "stock";
        }
        $data = $this->model("Admin")->companies($option);
        $row = mysqli_fetch_assoc($this->model("Admin")->getAdmin($this->user_id));
        $data['image'] = $row['image'];
        $data['name'] = $row['first_name'].' '.$row['last_name'];
        $this->view('admin/companies', $data);
    }
    
    function distributors(){
        if(isset($_POST['option1'])){
            $option1 = $_POST['option1'];
        }else{
            $option1 = "all";
        }
        if(isset($_POST['option2'])){
            $option2 = $_POST['option2'];
        }else{
            $option2 = "all";
        }
        $data = $this->model("Admin")->distributors($option1, $option2);
        $row = mysqli_fetch_assoc($this->model("Admin")->getAdmin($this->user_id));
        $data['image'] = $row['image'];
        $data['name'] = $row['first_name'].' '.$row['last_name'];
        $this->view('admin/distributors', $data);
    }

    function dealers(){
        if(isset($_POST['option1'])){
            $option1 = $_POST['option1'];
        }else{
            $option1 = "all";
        }
        if(isset($_POST['option2'])){
            $option2 = $_POST['option2'];
        }else{
            $option2 = "all";
        }
        $data = $this->model("Admin")->dealers($option1, $option2);
        $row = mysqli_fetch_assoc($this->model("Admin")->getAdmin($this->user_id));
        $data['image'] = $row['image'];
        $data['name'] = $row['first_name'].' '.$row['last_name'];
        $this->view('admin/dealers', $data);
    }

    function deliveries($tab=null){
        if(isset($_POST['option'])){
            $option = $_POST['option'];
        }else{
            $option = "all";
        }
        if($tab == null){
            $data = $this->model("Admin")->deliveries($option);
        }else{
            if(isset($_POST['0'])){
                $i = 0; $mindist = [];
                while(isset($_POST[$i])){
                    $mindist[$i] = $_POST[$i];
                    $i+=10;
                }
                $data = $this->model("Admin")->deliverycharges($mindist);
            }else{
                $data = $this->model("Admin")->deliverycharges();
            }
        }
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