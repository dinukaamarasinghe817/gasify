<?php
    session_start();
    class Dashboard extends Controller{
        public $user_id;
        public function __construct(){
            $this->AuthorizeLogin();
            $this->user_id = $_SESSION['user_id'];
        }

        public function dealer($error = null){
            $this->AuthorizeUser('dealer');
            // check if the user is actually a gas dealer
            $this->AuthorizeUser("dealer");
            if(isset($_POST['option'])){
                $option = $_POST['option'];
            }else{
                $option = 'today';
            }
            
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
            $data['navigation'] = 'dashboard';

            //echo $data['image'];
            // $this->view('dashboard/dealer', $data);
            $data['option'] = $option;
            $this->view('dashboard/dealer', $data);
        }
        public function company($error=null){
            $this->AuthorizeUser('company');

            $company_id=$_SESSION['user_id'];
            $company_details = $this->model('Company')->getCompanyImage($company_id);
            $user_id=mysqli_fetch_assoc($company_details);
            $data['name']=$user_id['first_name'].' '.$user_id['last_name'];
            //print_r( $user_id);
            $product_details = $this->model('Company')->getProductCount($company_id);
            $pendingReq = $this->model('Company')->getPendingReqCount($company_id);
            $distCount= $this->model('Company')->getDistributorCount($company_id);
            $dealerCount= $this->model('Company')->getDealerCount($company_id);
            $lowStockProducts = $this->model('Company')->getProductDetails($company_id);
            $order_details=$this->model('Company')->getStockReqDetails($company_id);
            $productDetails = $this->model('Company')->getProductDetails($company_id);
            $data['products']=$product_details;
            $data['reqCount']=$pendingReq;
            $data['distCount']=$distCount;
            $data['dealerCount']=$dealerCount;
            $data['order_details']=$order_details;
            $data['product_details']=$productDetails;
            //$data['name']="ffg";
            $row = mysqli_fetch_assoc($company_details);
            $data['navigation'] = 'dashboard';
            $data['image'] = $user_id['logo'];
            $lowStock = array();
            foreach($lowStockProducts as $row){
                if($row['quantity']<=$row['cylinder_limit']){
                    array_push($lowStock,['name'=>$row['name'],'quantity'=>$row['quantity']]);
                   //$lowStock+=array($row['name']=>$row['quantity']);
                }
            }
            $data['lowStock']=$lowStock;
            
            //$data=[];
            $this->view('dashboard/company', $data);
        }
        public function delivery($error=null){
            $this->AuthorizeUser('delivery');

            $data=[];
            $delivery_id=$_SESSION['user_id'];
            $delivery_details = $this->model('Delivery')->getDeliveryImage($delivery_id);
            //$dispatched_delivery_count=$this->model('Delivery')->getPendingDeliveryCount();
            //$completed_delivery_count=$this->model('Delivery')->getDeliveredOrdersCount();
            $row = mysqli_fetch_assoc($delivery_details);
            $data['navigation'] = 'dashboard';
            $data['image'] = $row['image'];
            $data['vehicle_no']=$row['vehicle_no'];
            $data['vehicle_type']=$row['vehicle_type'];
            $data['weight_limit']=$row['weight_limit'];
            $data['cost_per_km']=$row['cost_per_km'];
            $data['name']=$row['first_name'].' '.$row['last_name'];
            $data['dispatched_count']=$this->model('Delivery')->getPendingDeliveryCount()['count'];
            $data['completed_count']=$this->model('Delivery')->getDeliveredOrdersCount()['count'];
            $data['review_count']=$this->model('Delivery')->getReviewCount()['count'];
            $data['completed_orders']=$this->model('Delivery')->getTodayRevenue($delivery_id);
            $data['delivey_charge']=$this->model('Delivery')->getDeliveryCharges();
            $data['reviews']=$this->model('Delivery')->getMostRecentReviews();
            $processedOrders = array();
            $revenue=0;
            foreach($data['completed_orders'] as $row){
                $orderID = $row['order_id'];
                if(!(in_array($orderID,$processedOrders))){
                    $revenue+=intval($row['deliver_charge']);
                    array_push($processedOrders,$orderID);
                }
                
            }
            $data['revenue']=$revenue;
            //$data=[];
            $this->view('dashboard/delivery', $data);
        }
   


        //customer dashboard 
        public function customer($error = null){
            $this->AuthorizeUser('customer');
            //toast for place reservation
            switch($error){
                case "1":
                    $data['toast'] = ['type' => 'success', 'message' => "You've successfully placed order."];
                    break;
                case "2":
                    $data['toast'] = ['type' => 'success', 'message' => "Update successful!"];
                    break;
                case "3":
                    $data['toast'] = ['type' => 'error', 'message' => "Delivery option can only be changed once!"];
                    break;
                case "4":
                    $data['toast'] = ['type' => 'success', 'message' => "Your order has been successfully completed!"];
                    break;
                case "5":
                    $data['toast'] = ['type' => 'error', 'message' => "Database server error!"];
                    break;
            }

            $customer_id = $_SESSION['user_id'];
            
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
            $this->AuthorizeUser('distributor');

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
            $this->AuthorizeUser('admin');

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
            $data['navigation'] = 'dashboard';
            $this->view('dashboard/admin', $data);
        }

    }
?>