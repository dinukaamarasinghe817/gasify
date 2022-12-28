<?php
    session_start();
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
        header('Location: ' . BASEURL . '/home');
    }
    class Dashboard extends Controller{
        public function __construct(){
            
        }

        public function dealer($error = null){
            $dealer_id = $_SESSION['user_id'];
            // get the current stock
            $data['stock'] = $this->model('Dealer')->getcurrentstock($dealer_id);
            $dealer_details = $this->model('Dealer')->getDealerImage($dealer_id);
            $row = mysqli_fetch_assoc($dealer_details);
            $data['image'] = $row['image'];
            // get new pending orders
            $result1 = $this->model('Dealer')->getpendigorders($dealer_id);
            $data['pending'] = $result1; // multi dimensional array
            // result1 [
            //     [0] = [
            //         'row' => $row,
            //         'products' => [
            //                             [0] = product1,
            //                             [1] = product2,
            //                             [2] = product3,
            //                         ]
            //         ],
            //     [1] = [
            //         'row' => $row,
            //         'products' => [
            //                             [0] = product1,
            //                             [1] = product2,
            //                             [2] = product3,
            //                         ]
            //             ]
            // ]
            $data['navigation'] = 'dashboard';
            //echo $data['image'];
            $this->view('dashboard/dealer', $data);
        }
        public function company($error=null){
            $company_id=$_SESSION['user_id'];
            $company_details = $this->model('Company')->getCompanyImage($company_id);
            $row = mysqli_fetch_assoc($company_details);
            $data['navigation'] = 'dashboard';
            $data['image'] = $row['logo'];
            //$data=[];
            $this->view('dashboard/company', $data);
        }
        public function delivery($error=null){
            $data=[];
            $this->view('dashboard/delivery', $data);
        }
    }
?>