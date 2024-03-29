<?php
    session_start();
class Users extends Controller{
    public $user_id;
    function __construct(){
        parent::__construct();
        $this->AuthorizeLogin();
        $this->user_id = $_SESSION['user_id'];
    }

    public function validate($user_id,$validity){
        $data = $this->model("Admin")->validatecustomer($user_id,$validity);
    }

    function companies(){
        $this->AuthorizeUser('admin');

        if(isset($_POST['option'])){
            $option = $_POST['option'];
        }else{
            $option = "stock";
        }
        $data = $this->model("Admin")->companies($option);
        $this->view('admin/companies', $data);
    }
    
    function distributors(){
        $this->AuthorizeUser('admin');

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
        $this->view('admin/distributors', $data);
    }

    function dealers(){
        $this->AuthorizeUser('admin');

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
        $this->view('admin/dealers', $data);
    }

    function deliveries($tab=null){
        $this->AuthorizeUser('admin');

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
        if($tab != null){
            $this->view('admin/deliverycharges', $data);
        }else{
            $this->view('admin/deliveries', $data);
        }
    }

    function customers(){
        $this->AuthorizeUser('admin');
        
        if(isset($_POST['option'])){
            $option = $_POST['option'];
        }else{
            $option = "all";
        }
        $data = $this->model("Admin")->customers($option);
        $this->view('admin/customers', $data);
    }

}