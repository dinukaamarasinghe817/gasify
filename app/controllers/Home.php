<?php
    session_start();
    if (isset($_SESSION['user_id']) && isset($_SESSION['role'])) {
        $role = $_SESSION['role'];
        header('Location: ' . BASEURL . '/dashboard/'.$role);
    }
    class Home extends Controller{
        public function __construct(){
            
        }

        public function index($error = null){
            $data["company"] = $this->model("Company")->getAllCompanies();
            $data["distributor"] = $this->model("Distributor")->getAllDistributors();
            $data["dealer"] = $this->model("Dealer")->getAllDealers();
            $this->view('home/index',$data);
        }

        public function about($error = null){
            if($error != null){
                $this->view('home/about',['error'=>$error]);
            }else{
                $this->view('home/about');
            }
        }

        public function aboutpost(){
            $key = $_POST['name'];
            if($key != 'key'){
                header("Location: ./about/$key");
            }else{

            }
        }
    }
?>