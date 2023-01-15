<?php
    // session_start();
    // if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    //     header('Location: ' . BASEURL . '/home');
    // }
    class Dashboard extends Controller{
        public $user_id;
        public function __construct(){
            $this->AuthorizeLogin();
            $this->user_id = $_SESSION['user_id'];
        }

        public function dealer($error = null){
            // check if the user is actually a gas dealer
            $this->AuthorizeUser("dealer");
            if(isset($_POST['option'])){
                $option = $_POST['option'];
            }else{
                $option = 'today';
            }
            $dealer_details = $this->model('Dealer')->getDealer($this->user_id);
            $row = mysqli_fetch_assoc($dealer_details);
            
            $data = $this->model('Dealer')->dashboard($this->user_id,$option);
            // $data['stock'] = $result['stock'];
            // $data['dispatched'] = $result['dispatched'];
            // $data['pending'] = $result['pending']; // multi dimensional array
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
            $data['image'] = $row['image'];
            $data['name'] = $row['first_name'].' '.$row['last_name'];
            $data['navigation'] = 'dashboard';
            $data['option'] = $option;
            $this->view('dashboard/dealer', $data);
        }

        //customer dashboard 
        public function customer($error = null){
            $customer_id = $_SESSION['user_id'];
            //profile image
            $customer_details = $this->model('Customer')->getCustomerImage($customer_id);
            $row1 = mysqli_fetch_assoc($customer_details);
            $data['image'] = $row1['image'];

            // get registered company brands
            $brand = $this->model('Customer')->getCompanyBrand(); 
            $data['brand'] = $brand;

            //get recent orders of customer
            $data['orders'] = $this->model('Customer')->getRecentOrders($customer_id);
           
            //get popular products
            $data['popular_products'] = $this->model('Customer')->getPopularProducts();

            $data['navigation'] = 'dashboard';
            $this->view('dashboard/customer', $data);
        }
        
        public function distributor($error = null){
            $distributor_id = $_SESSION['user_id'];
            
            $distributor_details = $this->model('Distributor')->getDistributorImage($distributor_id);
            $row = mysqli_fetch_assoc($distributor_details);
            $data['image'] = $row['image'];

    
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