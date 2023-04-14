<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header('Location: ' . BASEURL . '/home');
}

class Orders extends Controller{
    public $user_id;
    function __construct(){
        parent::__construct();
        $this->user_id = $_SESSION['user_id'];
    }

    function dealer($tab1, $tab2=null){
        $dealer_id = $_SESSION['user_id'];
        $data['navigation'] = 'orders';
        $dealer_details = $this->model('Dealer')->getDealer($dealer_id);
        $row = mysqli_fetch_assoc($dealer_details);
        $data['image'] = $row['image'];
        $data['name'] = $row['first_name'].' '.$row['last_name'];
        $data['orders'] = $this->model('Dealer')->dealerOrders($dealer_id,$tab1,$tab2);
        // var_dump($data);
        $data['verification'] = '';
        $data['tab1'] = $tab1;
        $data['tab2'] = $tab2;
        $this->view('dealer/orders', $data);
    }

    function dealeraccept($order_id){
        $this->model('Dealer')->dealerAcceptOrder($order_id);
        header('LOCATION: '.BASEURL.'/orders/dealer/pending');
    }

    function dealerissue($order_id){
        $this->model('Dealer')->dealerIssueOrder($order_id);
        header('LOCATION: '.BASEURL.'/orders/dealer/accepted/pickup');
    }

    function dealersubmitpayslip($order_id){
        $data = $this->model('Dealer')->dealersubmitpayslipOrder($order_id);
        header('LOCATION: '.BASEURL.'/orders/dealer/canceled');
    }


    /*.................Customer my reservation...............*/
    //customer all past reservtions
    function customer_allreservations(){
        $customer_id = $_SESSION['user_id'];
        $data['navigation'] = 'myreservation';

        $customer_details = $this->model('Customer')->getCustomerImage($customer_id);
        $row1 = mysqli_fetch_assoc($customer_details);
        $data['image'] = $row1['image'];
        $data['name'] = $row1['first_name'].' '.$row1['last_name'];


        $data['allmyreservations'] = $this->model('Customer')->getAllmyreservations($customer_id);
       
        $this->view('customer/my_reservation/allmyreservation', $data);
    }

    //customer selected one reservation details from all past reservations
    function customer_myreservation($order_id){
        $customer_id = $_SESSION['user_id'];
        $data['navigation'] = 'myreservation';

        $customer_details = $this->model('Customer')->getCustomerImage($customer_id);
        $row1 = mysqli_fetch_assoc($customer_details);
        $data['image'] = $row1['image'];
        $data['name'] = $row1['first_name'].' '.$row1['last_name'];
        

        $data['myreservation'] = $this->model('Customer')->ViewMyreservation($order_id,$customer_id);
        $data['confirmation'] = '';

        $this->view('customer/my_reservation/viewmyreservation', $data);
    }

    //get collecting method for display review type in review form
    function customer_reviewform($order_id,$error=null){
        $customer_id = $_SESSION['user_id'];
        $data['navigation'] = 'myreservation';

        $customer_details = $this->model('Customer')->getCustomerImage($customer_id);
        $row1 = mysqli_fetch_assoc($customer_details);
        $data['image'] = $row1['image'];
        $data['name'] = $row1['first_name'].' '.$row1['last_name'];


        $data['collecting_method'] = $this->model('Customer')->getcollecting_method($order_id,$customer_id);
        $data['order_id'] = $order_id;
        $data['customer_id'] = $customer_id;
        if($error != null){
            // $data['error'] = $error;
            $data['toast'] = ['type'=>'error', 'message'=>$error];
        }
       
        $this->view('customer/my_reservation/addreview', $data);
    }

    //add review for the selected past reservstion
    function customer_addreview($order_id){
        $customer_id = $_SESSION['user_id'];
        $reviews = $_POST['review'];
        $review_type = "";
        if(isset($_POST['review_type'])){
            $review_type = $_POST['review_type'];
        }
        $data['add_review_error'] = $this->model('Customer')->AddReviw($order_id,$customer_id,$reviews,$review_type);
        if(!empty($data['add_review_error'])){
            $this->customer_reviewform($order_id,$data['add_review_error']);
        }
        else{
            $this->customer_myreservation($order_id);
            // $this->view('customer/viewmyreservation', $data);
        }    
       
    }


    //cancel the reservation
    function customer_cancelreservation($order_id,$error = null){

        $customer_id = $_SESSION['user_id'];
        $data['navigation'] = 'myreservation';

        $customer_details = $this->model('Customer')->getCustomerImage($customer_id);
        $row1 = mysqli_fetch_assoc($customer_details);
        $data['image'] = $row1['image'];
        $data['name'] = $row1['first_name'].' '.$row1['last_name'];
        $data['order_id'] = $order_id;

        if($error != null){
            $data['toast'] = ['type'=>'error', 'message'=>$error];
        }

        $data['confirmation'] = '';
        $this->view('customer/my_reservation/cancel_reservation', $data);


    }

    //refund form data for update reservation table
    function refund_bank_details($order_id){
        $customer_id = $_SESSION['user_id'];
        if(isset($_POST['bank'])){
            $bank = $_POST['bank'];
        }else{
            $bank = -1;
        } 
        $Acc_no = $_POST['Acc_no'];
        
       
        $data['refund_detail_error'] = $this->model('Customer')->add_refund_details($order_id, $bank,$Acc_no);
        if(!empty($data['refund_detail_error'])){
            $this->customer_cancelreservation($order_id,$data['refund_detail_error']);
        }
        else{
            // $this->customer_cancelreservation($order_id);
            $this->customer_allreservations();
        }    
    }

    /*.................Customer place reservation.................*/
    //select brand,city and dealer
    function select_brand_city_dealer($error=null){
        $customer_id = $_SESSION['user_id'];
        $data['navigation'] = 'placereservation';

        $customer_details = $this->model('Customer')->getCustomerImage($customer_id);
        $row1 = mysqli_fetch_assoc($customer_details);
        $data['image'] = $row1['image'];
        $data['name'] = $row1['first_name'].' '.$row1['last_name'];

        $data['brands'] = $this->model('Customer')->getCompanyBrand();
        $data['dealers'] = $this->model('Customer')->getdealers();
        $data['city'] = $this->model('Customer')->getCustomer($customer_id);

        if($error != null){
            // $data['error'] = $error;
            $data['toast'] = ['type'=>'error', 'message'=>$error];
        }

        $this->view('customer/place_reservation/select_brand_city_dealer',$data);

    }

    function filter_dealers($company_id=null,$city=null,$dealer=null){

        $customer_id = $_SESSION['user_id'];
        $data['navigation'] = 'placereservation';

        $data['dealers'] = $this->model('Customer')->getdealers($company_id,$city);
        
        $this -> view('customer/place_reservation/filter_dealers',$data);

    }


    function get_brand_city_dealer(){

        $customer_id = $_SESSION['user_id'];
        $data['navigation'] = 'placereservation';

        $customer_details = $this->model('Customer')->getCustomerImage($customer_id);
        $row1 = mysqli_fetch_assoc($customer_details);
        $data['image'] = $row1['image'];
        $data['name'] = $row1['first_name'].' '.$row1['last_name'];

        if(isset($_POST['brand'])){$brand = $_POST['brand'];}else{$brand = null;}
        $city = $_POST['city'];
        if(isset($_POST['dealer'])){$dealer = $_POST['dealer'];}else{$dealer = null;}
      
        $_SESSION['company_id'] = $brand;
        $_SESSION['city'] = $city;
        $_SESSION['dealer_id'] = $dealer;

       if($brand == null || $dealer == null){
            $error = "Please fill all fields";
            $this->select_brand_city_dealer($error);
            // $this -> select_products($brand,$city,$dealer);

       }
       if($brand != null && $dealer != null){
            // $this -> select_products($brand,$city,$dealer);
            $this -> select_products();
       }
       

      

    }

     //display all products according to the selected dealer
     function select_products($error=null){

    
        $customer_id = $_SESSION['user_id'];
        $data['navigation'] = 'placereservation';
      
        $customer_details = $this->model('Customer')->getCustomerImage($customer_id);
        $row1 = mysqli_fetch_assoc($customer_details);
        $data['image'] = $row1['image'];
        $data['name'] = $row1['first_name'].' '.$row1['last_name'];

        $company_id = $_SESSION['company_id'];

        $city = $_SESSION['city'];
        $dealer_id = $_SESSION['dealer_id'];

        
        $data['products']= $this ->model('Customer')->getDealerProducts($dealer_id);

        $data['company_id'] = $company_id;
        $data['city'] = $city;
        $data['dealer_id'] = $dealer_id;

        if($error != NULL){
            $data['toast'] = ['type'=>'error', 'message'=>$error];
        }


        $this->view('customer/place_reservation/select_products',$data);

        
    }

    //get customer selected products 
    function selected_products($dealer_id){
        $customer_id = $_SESSION['user_id'];
        $data['navigation'] = 'placereservation';
        $result = $this->model('Customer')->getCustomer($customer_id);
        $row = mysqli_fetch_assoc($result);
        $customer_type = $row['c_type'];

        $data['products']= $this ->model('Customer')->getDealerProducts($dealer_id);
        $products = $data['products'];

        //check selected products weights are higher than remaining quota
        $quota_details = $this->model('Customer')->getQuotaDetails($customer_type);
        foreach($quota_details as $quota_detail){
           $quota_state = $quota_detail['state'];
           $monthly_limit = $quota_detail['monthly_limit'];
           $remaining_weight = $quota_detail['remaining_weight'];
        }

       


        $selected_products = array();

        foreach($products as $product){
            $product_id = $product['p_id'];
            $unit_price = $product['unit_price'];
            $qty = $_POST[$product_id];
            if($qty != 0){
                array_push($selected_products,['product_id'=>$product_id ,'qty'=> $qty ,'unit_price'=>$unit_price]);

            }
        }

      
        //check atleast one product is selected
        if(count($selected_products) > 0){
            $_SESSION['order_products'] = $selected_products;
            $total_weight_cylinders = $this->model('Customer')->products_total_weight();
            //check quota is active or not
            if($quota_state == 'ON'){
                //check remaining quota exceed or not
                if($total_weight_cylinders <= $remaining_weight ){
                    $this->select_payment_method();
                }else{
                   $error = "Your quota amount is exceeded!";
                   $this->select_products($error);
                }
            }else{
                $this->select_payment_method();
            }
           
            
        }
        else{
            $error = "You must select at least one product";
            $this->select_products($error);
        }

    }

    //select payment method
    function select_payment_method($error=null){
        $customer_id = $_SESSION['user_id'];
        $data['navigation'] = 'placereservation';

        $customer_details = $this->model('Customer')->getCustomerImage($customer_id);
        $row1 = mysqli_fetch_assoc($customer_details);
        $data['image'] = $row1['image'];
        $data['name'] = $row1['first_name'].' '.$row1['last_name'];
        $data['email'] = $row1['email'];
       
        $data['selected_products']= $this ->model('Customer')->getSelectedProducts();
        $data['dealer_keys'] = $this ->model('Customer')->getdealerpubkey($_SESSION['dealer_id']);
        if($error != null){
            $data['toast'] = $error;
        }
       
        $this->view('customer/place_reservation/select_payment_method',$data);
    }


    //display bank slip uploader
    function bank_slip_upload($error=null){
    
        $customer_id = $_SESSION['user_id'];
        $data['navigation'] = 'placereservation';

        $customer_details = $this->model('Customer')->getCustomerImage($customer_id);
        $row1 = mysqli_fetch_assoc($customer_details);
        $data['image'] = $row1['image'];
        $data['name'] = $row1['first_name'].' '.$row1['last_name'];

        $data['bank_details'] = $this->model('Customer')->getDealerBankDetails();

        if($error != null){
            $data['toast'] = ['type'=>'error', 'message'=>$error];
        }
        
        $this->view('customer/place_reservation/bank_slip_upload',$data);
        
    }

    function get_bank_slip(){
        $customer_id = $_SESSION['user_id'];
        $customer_details = $this->model('Customer')->getCustomerImage($customer_id);
        $row1 = mysqli_fetch_assoc($customer_details);
        $customer_type = $row1['type'];

        $data['image'] = $row1['image'];
        $data['name'] = $row1['first_name'].' '.$row1['last_name'];
        $data['navigation'] = 'placereservation';
        
        if(isset($_POST['submit_btn'])){
           $file_name = $_FILES['slip_img']['name'];
            $file_type = $_FILES['slip_img']['type'];
            $file_size = $_FILES['slip_img']['size'];
            $temp_name = $_FILES['slip_img']['tmp_name'];

            $upload_to = 'C:/xampp/htdocs/mvc/public/img/payslips/';

            // $slip_image = array();
            // array_push($slip_image,['file_name' => $file_name, 'temp_name' =>$temp_name]);
            $_SESSION['slip_img'] = ['file_name' => $file_name, 'temp_name' =>$temp_name];
            // move_uploaded_file($temp_name,$upload_to . $file_name);

            

            if($file_size<=0){
                $error = "Please upload a bank slip image!";
                $this -> bank_slip_upload($error);
            }
            else{
                // $this->model('Customer')->place_reservation($customer_type);  ///
                // $this->model('Customer')->check_quota_state($customer_type);  ///
                // $this->select_collecting_method();
                //successfully payed
                $dealer_id = $_SESSION['dealer_id'];
                $products = $_SESSION['order_products'];
                $data['order_id'] = $this->model('Dealer')->customerOrder($customer_id,$dealer_id,$products,'Bank Deposit');
                $this -> model('Customer')->update_remaining_weight($customer_type);   //update remaining weight of customer quota
                $data['confirmation'] = '';
                $this->view('customer/place_reservation/collecting_method',$data);
            }

        } 

    }

    //display payment gateway
    function payment_gateway(){
       
        $customer_id = $_SESSION['user_id'];
        $data['navigation'] = 'placereservation';
        $customer_details = $this->model('Customer')->getCustomerImage($customer_id);
        $row1 = mysqli_fetch_assoc($customer_details);
        $customer_type = $row1['type'];
        $data['image'] = $row1['image'];
        $data['name'] = $row1['first_name'].' '.$row1['last_name'];
        //check customer quota
        //post data from payment component
        $dealer_id = $_POST['dealer_id'];
        $customer_email= $_POST['customer_email'];
        //first of all charge the customer
        $charge = new Charge($_POST['rest_key'],$data['name'],$_POST['amount']);
        if($charge->make()){
            //successfully charged
            $products = $_SESSION['order_products'];
            $data['order_id'] = $this->model('Dealer')->customerOrder($customer_id,$dealer_id,$products,'Credit card');
            $this -> model('Customer')->update_remaining_weight($customer_type);   //update remaining weight of customer quota
            $data['toast'] = ['type' => 'success', 'message' => "Your payment was successfull"];
            $data['confirmation'] = '';
            $this->view('customer/place_reservation/collecting_method',$data);
        }else{
            //charging unsuccess
            $data['toast'] = ['type' => 'error', 'message' => "Payment failed, Please check you card details"];
            $this->select_payment_method($data['toast']);
        }
        // $this->view('customer/place_reservation/payment_gateway',$data);
    }

    //select collecting method of reservation
    function select_collecting_method(){
        $customer_id = $_SESSION['user_id'];
        $data['navigation'] = 'placereservation';

        $customer_details = $this->model('Customer')->getCustomerImage($customer_id);
        $row1 = mysqli_fetch_assoc($customer_details);
        $data['image'] = $row1['image'];
        $data['name'] = $row1['first_name'].' '.$row1['last_name'];

        $data['confirmation'] = '';

        $this->view('customer/place_reservation/collecting_method',$data);

    }

    //select delivery as collecting method
    function select_delivery_method($order_id){
        $data['order_id'] = $order_id;
        $customer_id = $_SESSION['user_id'];
        $data['navigation'] = 'placereservation';

        $customer_details = $this->model('Customer')->getCustomerImage($customer_id);
        $row1 = mysqli_fetch_assoc($customer_details);
        $data['image'] = $row1['image'];
        $data['name'] = $row1['first_name'].' '.$row1['last_name'];

        $data['selected_city'] = $_SESSION['city'];
        $data['home_city'] = $row1['city'];
        
        if(isset($_POST['new_street'])){
            $data['street'] = $_POST['new_street'];
            if(isset($_POST['new_city'])){
                $data['city'] = $_POST['new_city'];
            }

        }else{
            $data['city'] = $row1['city'];
            $data['street'] = $row1['street'];
        }

        $distance = 9;   //********************** *have to take distance using maps ******************************************
        $data['delivery_charge']= $this->model('Customer')->insertdelivery_street($order_id,$data['street'],$distance);   //insert delivery street  and distance range to reservation table


        // $data['delivery_charge'] = $this->
       

        $data['confirmation'] = '';

        $this->view('customer/place_reservation/delivery_collecting_method',$data);
    }

    function getcollecting_method($collecting_method,$order_id){
        $customer_id = $_SESSION['user_id'];
        $data['navigation'] = 'placereservation';

        $customer_details = $this->model('Customer')->getCustomerImage($customer_id);
        $row1 = mysqli_fetch_assoc($customer_details);
        $data['image'] = $row1['image'];
        $data['name'] = $row1['first_name'].' '.$row1['last_name'];

        $_SESSION['collecting_method'] = $collecting_method;
        $this -> model('Customer')->insertcollectingmethod($order_id);
        header('LOCATION:'.BASEURL.'/Dashboard/customer');

        // $this->view('customer/place_reservation/collecting_method',$data);

    }



    /*..........................Customer quota......................... */
  
    function customer_quota(){
        $data = array();
        $customer_id = $_SESSION['user_id'];

        // take quota information on each company
        $data['companies_array'] = $this->model('Customer')->getcustomerquota($customer_id);

        // get customer personal information and naviagation
        $customer_details = $this->model('Customer')->getCustomerImage($customer_id);
        $row1 = mysqli_fetch_assoc($customer_details);
        $data['image'] = $row1['image'];
        $data['name'] = $row1['first_name'].' '.$row1['last_name'];
        $data['navigation'] = 'quota';
        $this->view('customer/quota/quota',$data);
    }

    // function customer_quotas(){
    //     $customer_id = $_SESSION['user_id'];
    //     $data['navigation'] = 'quota';

    //     $customer_details = $this->model('Customer')->getCustomerImage($customer_id);
    //     $row1 = mysqli_fetch_assoc($customer_details);
    //     $data['image'] = $row1['image'];
    //     $data['name'] = $row1['first_name'].' '.$row1['last_name'];
       
    //     $result = $this->model('Customer')->getCustomer($customer_id);
    //     $row = mysqli_fetch_assoc($result);
    //     $customer_type = $row['c_type'];

       
    //    $data['company_details'] = $this->model('Customer')->getCompanyBrand();  //get all companies
    //    while($company = mysqli_fetch_assoc($data['company_details'])){
    //         $company_id = $company['company_id'];
    //         if(isset($_POST[$company_id])){
    //              $selected_product_id = $_POST[$company_id];
    //         }else{
    //             $selected_product_id = null;
    //         }
    //         //input of dropdown in not null
    //         if($selected_product_id != null){
    //             $data['quota_details'] = $this->model('Customer')->getQuotaDetails($customer_type,$company_id,$selected_product_id);
    //             $quota_details = $data['quota_details'];
    //             foreach($quota_details as $quota_detail){
                
    //                 $data['quota_state'] = $quota_detail['quota_state'];
    //                 if($data['quota_state'] == 'ON'){
    //                     $data['total_quota_weight'] = $quota_detail['total_quota_cylinders'];
    //                     $data['remaining_quota_weight'] = $quota_detail['remaining_quota_cylinders'];
    //                 }
    //             }

    //             $data['product_weight'] = $this->model('Customer')->getproductweight($selected_product_id);
    //             $this->view('customer/quota/quota',$data);

    //         }
    //         //otherwise take default product as input
    //         else{
    //             $data['company_products'] = $this->model('Customer')->getCompanyProducts($company_id);
    //             $products = mysqli_fetch_assoc($data['company_products']);
    //             foreach ($products as $product){
    //                 $default_product = 4;
    //             }
    //             $default_product_id = $default_product['product_id'];
    //             $data['quota_details'] = $this->model('Customer')->getQuotaDetails($customer_type,$company_id,$default_product_id);
               
    //             $quota_details = $data['quota_details'];
    //             foreach($quota_details as $quota_detail){
    //                 $data['quota_state'] = $quota_detail['quota_state'];
    //                 if($data['quota_state'] == 'ON'){
    //                     $data['total_quota_weight'] = $quota_detail['total_quota_cylinders'];
    //                     $data['remaining_quota_weight'] = $quota_detail['remaining_quota_cylinders'];
    //                 }
    //             }


    //             $data['product_weight'] = $this->model('Customer')->getproductweight($default_product_id);
    //             $this->view('customer/quota/quota',$data);
    //         }
    //    }



    // }


    /*..............................DISTRIBUTOR GAS ORDERS TAB.........................................*/

    // distributor -> phurchase order interface
     public function distributor() {
        $user_id = $_SESSION['user_id'];
        $data['navigation'] = 'orders';
        $distributor_details = $this->model('Distributor')->getDistributorImage($user_id);
        $row = mysqli_fetch_assoc($distributor_details);
        $data['image'] = $row['image'];
        /*
        $productid = $_SESSION['productarray'];
        $postproducts = [];
        for($i=0; $i<count($productid); $i++) {
            $postproducts[$productid[$i]] = $_POST[$productid[$i]];
        }
        $data = $this->model("Distributor")->phurchaseOrders($this->$user_id, $productid, $postproducts);
        if(isset($data['toast'])) {
            // $this->distributor("phurchase_orders", $data['toast']);
        }else {
            $this->view('distributor/phurchase_orders',$data);      
        } */

        $data['productdetails'] = $this->model('Distributor')->productdetails();

        $this->view('distributor/phurchase_orders',$data);      

        // $data['placeorderpg'] = $this->model("Distributor")->phurchaseOrders($user_id);
        // $this->view('distributor/phurchase_orders',$data);   
    }

    public function purchase_order() {
        $user_id = $_SESSION['user_id'];

        $quantities = array();
        $result = $this->model('Distributor')->productdetails();

        $records = mysqli_num_rows($result);
        $isvalidity = false;
        for($i=0; $i<$records; $i++) {
            $product = mysqli_fetch_assoc($result);
            $product_id = $product['product_id'];
            $name = $product['name'];
            $qty = $POST["$product_id"];
            if($qty!=0) {
                $isvalidity = true;
            }
            $quantities[$i] = array($product['product_id'], $qty);
        }
        

      
        



    }



    // distributor current stock (Gas Orders)
    public function distributor_currentstock() {
        $user_id = $_SESSION['user_id'];
        $data['navigation'] = 'orders';

        // profile picture
        $distributor_details = $this->model('Distributor')->getDistributorImage($user_id);
        $row = mysqli_fetch_assoc($distributor_details);
        $data['image'] = $row['image'];

        $data['currentstock']= $this->model("Distributor")->currentstock($user_id);
        
        $this->view('distributor/current_stock',$data);
        // $this->view('distributor/dashboard/distributor',$data);
      

    }
    
    //Placed orders list (Gas Orders)
    public function distributor_orderlist() {
        $user_id = $_SESSION['user_id'];
        $data['navigation'] = 'orders';

        // profile picture
        $distributor_details = $this->model('Distributor')->getDistributorImage($user_id);
        $row = mysqli_fetch_assoc($distributor_details);
        $data['image'] = $row['image'];

        // phurchase order  view
        // create the model
        // $this->view('distributor/reports',$data);
        $this->view('distributor/placed_pending',$data);

    }

    // (Gas Orders -> Placed Orders List) Pending gas orders
    public function dis_placed_pending() {
        $user_id = $_SESSION['user_id'];
        $data['navigation'] = 'orders';

        // profile picture
        $distributor_details = $this->model('Distributor')->getDistributorImage($user_id);
        $row = mysqli_fetch_assoc($distributor_details);
        $data['image'] = $row['image'];

        $data['pendingorders']= $this->model("Distributor")->pendingGasOrders($user_id);

        $this->view('distributor/placed_pending',$data);

    }
    // Gas Orders -> Places orders list , accepted gas orders
    public function dis_placed_accepted() {
        $user_id = $_SESSION['user_id'];
        $data['navigation'] = 'orders';

        // profile picture
        $distributor_details = $this->model('Distributor')->getDistributorImage($user_id);
        $row = mysqli_fetch_assoc($distributor_details);
        $data['image'] = $row['image'];

        $data['acceptedorders']= $this->model("Distributor")->acceptedGasOrders($user_id);
        
        $this->view('distributor/placed_accepted',$data);

    }

    // Gas Orders -> Places orders list , completed gas orders
    public function dis_placed_completed() {
        $user_id = $_SESSION['user_id'];
        $data['navigation'] = 'orders';

        $distributor_details = $this->model('Distributor')->getDistributorImage($user_id);
        $row = mysqli_fetch_assoc($distributor_details);
        $data['image'] = $row['image'];

        $data['completedorders']= $this->model("Distributor")->completedGasOrders($user_id);
        
        $this->view('distributor/placed_completed',$data);

    }
    
    // suitable vehicle list for pending , accepted gas orders
    public function suitableVehicleList(){
        $user_id = $_SESSION['user_id'];
        $data['navigation'] = 'orders';

        $distributor_details = $this->model('Distributor')->getDistributorImage($user_id);
        $row = mysqli_fetch_assoc($distributor_details);
        $data['image'] = $row['image'];

        $data['suitablevehiclelist'] = $this->model("Distributor")->viewvehicle($user_id);

        $this->view('distributor/suitableVehicleList', $data);
    }


    /*****************************************************************************************************/

    public function validatepayments($tab){
        $row = mysqli_fetch_assoc($this->model("Admin")->getAdmin($this->user_id));
        $data['name'] = $row['first_name'].' '.$row['last_name'];
        $data['image'] = $row['image'];
        $data['activetab'] = $tab;
        $this->view('admin/payments',$data);
    }

}

?>


