<?php
    session_start();
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
        header('Location: ' . BASEURL . '/home');
    }
    class Dashboard extends Controller{
        public $user_id;
        public function __construct(){
            $this->user_id = $_SESSION['user_id'];
        }

        public function dealer($error = null){
            // check if the user is actually a gas dealer
            // AuthorizeUser("dealer");

            $data['stock'] = $this->model('Dealer')->getcurrentstock($this->user_id);
            $dealer_details = $this->model('Dealer')->getDealer($this->user_id);
            $row = mysqli_fetch_assoc($dealer_details);
            $data['image'] = $row['image'];
            
            // get new pending orders
            $result1 = $this->model('Dealer')->getpendigorders($this->user_id);
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
            $this->view('dashboard/dealer', $data);
        }

        public function customer($error = null){
            $customer_id = $_SESSION['user_id'];
            $customer_details = $this->model('Customer')->getCustomerImage($customer_id);
            $row = mysqli_fetch_assoc($customer_details);
            $data['image'] = $row['image'];
            // get new pending orders
            $data['navigation'] = 'dashboard';
            $this->view('dashboard/customer', $data);
        }
        
        public function distributor($error = null){
            $distributor_id = $_SESSION['user_id'];
            $distributor_details = $this->model('Distributor')->getDistributorImage($distributor_id);
            $row = mysqli_fetch_assoc($distributor_details);
            $data['image'] = $row['image'];
            // get new pending orders
            $data['navigation'] = 'dashboard';
            $this->view('dashboard/distributor', $data);
        }

        public function admin($error = null){
            $data['image'] = 'user.png';
            // get new pending orders
            $data['navigation'] = 'dashboard';
            $this->view('dashboard/admin', $data);
        }
    }
?>