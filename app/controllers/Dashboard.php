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

            //echo $data['image'];
            // $this->view('dashboard/dealer', $data);
            $data['option'] = $option;
            $this->view('dashboard/dealer', $data);
        }
        public function company($error=null){
            $company_id=$_SESSION['user_id'];
            $company_details = $this->model('Company')->getCompanyImage($company_id);
            $product_details = $this->model('Company')->getProductCount($company_id);
            $pendingReq = $this->model('Company')->getPendingReqCount($company_id);
            $distCount= $this->model('Company')->getDistributorCount($company_id);
            $dealerCount= $this->model('Company')->getDealerCount($company_id);
            $data['products']=$product_details;
            $data['reqCount']=$pendingReq;
            $data['distCount']=$distCount;
            $data['dealerCount']=$dealerCount;
            $row = mysqli_fetch_assoc($company_details);
            $data['navigation'] = 'dashboard';
            $data['image'] = $row['logo'];
            //$data=[];
            $this->view('dashboard/company', $data);
        }
        public function delivery($error=null){
            $data=[];
            $delivery_id=$_SESSION['user_id'];
            $delivery_details = $this->model('Delivery')->getDeliveryImage($delivery_id);
            $row = mysqli_fetch_assoc($delivery_details);
            $data['navigation'] = 'dashboard';
            $data['image'] = $row['image'];
            $data['vehicle_no']=$row['vehicle_no'];
            $data['vehicle_type']=$row['vehicle_type'];
            $data['weight_limit']=$row['weight_limit'];
            $data['cost_per_km']=$row['cost_per_km'];
            //$data=[];
            $this->view('dashboard/delivery', $data);
        }
   


        //customer dashboard 
        public function customer($error = null){

            //toast for place reservation
            switch($error){
                case "1":
                    $data['toast'] = ['type' => 'success', 'message' => "You've successfully placed order."];
                    break;
            }

            $customer_id = $_SESSION['user_id'];
            //profile image
            $customer_details = $this->model('Customer')->getCustomerImage($customer_id);
            $row1 = mysqli_fetch_assoc($customer_details);
            $data['image'] = $row1['image'];
            $data['name'] = $row1['first_name'].' '.$row1['last_name'];



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
            if(isset($_POST['option'])){
                $option = $_POST['option'];
            }else{
                $option = 'today';
            }

            $data = $this->model('Distributor')->dashboard($this->user_id, $option);

            $distributor_details = $this->model('Distributor')->getDistributorImage($distributor_id);
            $row = mysqli_fetch_assoc($distributor_details);
            $data['image'] = $row['image'];
            $data['navigation'] = 'dashboard';

            $data['currentstock']= $this->model("Distributor")->currentstock($distributor_id);

            // $data['pendingorders']= $this->model("Distributor")->pendingGasOrders($distributor_id);
            $data['pending_distributions']= $this->model("Distributor")->pendingdistributions($distributor_id);
            
            // count of pending distributions
            $data['count_pending_distributions'] = $this->model("Distributor")->sumpendingdistirbutions($distributor_id, $option);

            // count of received gas orders
            $data['count_received_gasorders'] = $this->model("Distributor")->countReceivedOrders($distributor_id, $option);

            $data['chart'] = $this->model("Distributor")->dashboard($distributor_id,$option);
            $data['option'] = $option;
            $this->view('dashboard/distributor',$data);

        }

        public function admin($error = null){
            if(isset($_POST['option1'])){
                $option = $_POST['option1'];
            }else{
                $option = 'today';
            }
            if(isset($_POST['option2'])){
                $option2 = $_POST['option2'];
            }else{
                $option2 = 'all';
            }
            $data = $this->model('Admin')->dashboard($this->user_id,$option,$option2);
            $row = mysqli_fetch_assoc($this->model('Admin')->getAdmin($this->user_id));
            $data['name'] = $row['first_name'].' '.$row['last_name'];
            $data['image'] = $row['image'];
            $data['navigation'] = 'dashboard';
            // var_dump($data);
            $this->view('dashboard/admin', $data);
        }

    }
?>