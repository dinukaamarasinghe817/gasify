<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header('Location: ' . BASEURL . '/home');
}

class Orders extends Controller{
    public $user_id;
    function __construct(){
        parent::__construct();
        $this->AuthorizeLogin();
        $this->user_id = $_SESSION['user_id'];
    }

    function dealer($tab1, $tab2=null){
        $this->AuthorizeUser('dealer');

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
        $this->AuthorizeUser('dealer');

        $this->model('Dealer')->dealerAcceptOrder($order_id);
        header('LOCATION: '.BASEURL.'/orders/dealer/pending');
    }

    function dealerissue($order_id){
        $this->AuthorizeUser('dealer');

        $this->model('Dealer')->dealerIssueOrder($order_id);
        header('LOCATION: '.BASEURL.'/orders/dealer/accepted/pickup');
    }

    function dealersubmitpayslip($order_id){
        $this->AuthorizeUser('dealer');

        $data = $this->model('Dealer')->dealersubmitpayslipOrder($order_id);
        header('LOCATION: '.BASEURL.'/orders/dealer/canceled');
    }


    /*...................................................Customer my reservation.............................................................*/
    //customer all past reservtions
    function customer_allreservations($error = null){
        $this->AuthorizeUser('customer');

        //if there is error display the error message
        switch($error){
            case "1":
                $data['toast'] = ['type' => 'success', 'message' => "You've successfully cancelled your order."];
                break;
        }

        $customer_id = $_SESSION['user_id'];
        $data['navigation'] = 'myreservation';
        //get all reservations relavant to customer
        $data['allmyreservations'] = $this->model('Customer')->getAllmyreservations($customer_id);
        $this->view('customer/my_reservation/allmyreservation', $data);   //send data to allmyreservation view
    }

    //customer selected one reservation details from all past reservations
    function customer_myreservation($order_id){
        $this->AuthorizeUser('customer');

        $customer_id = $_SESSION['user_id'];
        $data['navigation'] = 'myreservation';
        //get selected reservation details relavant to customer
        $data['myreservation'] = $this->model('Customer')->ViewMyreservation($order_id,$customer_id);
        $data['confirmation'] = '';  //to display popup confirmation

        $this->view('customer/my_reservation/viewmyreservation', $data); //send data to viewmyreservation view
    }

    //get collecting method for display review type in review form
    function customer_reviewform($order_id,$error=null){
        $this->AuthorizeUser('customer');

        $customer_id = $_SESSION['user_id'];
        $data['navigation'] = 'myreservation';

        $data['collecting_method'] = $this->model('Customer')->getcollecting_method($order_id,$customer_id);
        $data['order_id'] = $order_id;
        $data['customer_id'] = $customer_id;
        if($error != null){
            $data['toast'] = ['type'=>'error', 'message'=>$error];
        }
       
        $this->view('customer/my_reservation/addreview', $data);
    }

    //add review for the selected past reservstion
    function customer_addreview($order_id){
        $this->AuthorizeUser('customer');

        $customer_id = $_SESSION['user_id'];
        $reviews = $_POST['review'];
        $review_type = "";
        if(isset($_POST['review_type'])){
            $review_type = $_POST['review_type'];
        }
        //return if there is any errors(emppty fields)
        $data['add_review_error'] = $this->model('Customer')->AddReview($order_id,$customer_id,$reviews,$review_type);
        if(!empty($data['add_review_error'])){
            $this->customer_reviewform($order_id,$data['add_review_error']);
        }
        else{
            $this->customer_myreservation($order_id);
        }    
       
    }


    //cancel the reservation
    function customer_cancelreservation($order_id,$error = null){
        $this->AuthorizeUser('customer');

         //if there is error display the error message
         switch($error){
            case "1":
                $data['toast'] = ['type' => 'error', 'message' => "All fields are required"];
                break;
        }

        $customer_id = $_SESSION['user_id'];
        $data['navigation'] = 'myreservation';
        $data['order_id'] = $order_id;
        $data['confirmation'] = ''; //to display popup confirmation
        $this->view('customer/my_reservation/cancel_reservation', $data);


    }

    //refund form data for update reservation table
    function refund_bank_details($order_id){
        $this->AuthorizeUser('customer');

        $customer_id = $_SESSION['user_id'];
        if(isset($_POST['bank'])){
            $bank = $_POST['bank'];
        }else{
            $bank = -1;
        } 
        $branch = $_POST['branch'];
        $Acc_no = $_POST['Acc_no'];
        
       

        $this->model('Customer')->add_refund_details($order_id, $bank,$branch,$Acc_no);
        if($bank == -1 || empty($branch) ||empty($Acc_no) ){
            $this->customer_cancelreservation($order_id,1);
        }
        else{
            $this->customer_allreservations(1);
        }    
    }

    /*.................Customer place reservation.................*/
    //select brand,city and dealer
    function select_brand_city_dealer($error=null){
        $this->AuthorizeUser('customer');

        $customer_id = $_SESSION['user_id'];
        $data['navigation'] = 'placereservation';


        $data['brands'] = $this->model('Customer')->getCompanyBrand();      //get all gas companies for display
        $data['dealers'] = $this->model('Customer')->getdealers();          //get all dealers for display
        $data['city'] = $this->model('Customer')->getCustomer($customer_id);  //get customer city for display

        //not selected brand,city,dealer error
        if($error != null){
            $data['toast'] = ['type'=>'error', 'message'=>$error];
        }

        $this->view('customer/place_reservation/select_brand_city_dealer',$data);

    }

    function filter_dealers($company_id=null,$city=null,$dealer=null){
        $this->AuthorizeUser('customer');

        $customer_id = $_SESSION['user_id'];
        $data['navigation'] = 'placereservation';
        $data['dealers'] = $this->model('Customer')->getdealers($company_id,$city);  //get dealers according to selected company and city
        
        $this -> view('customer/place_reservation/filter_dealers',$data);

    }


    function get_brand_city_dealer(){
        $this->AuthorizeUser('customer');

        $customer_id = $_SESSION['user_id'];
        $data['navigation'] = 'placereservation';

        

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
        $this->AuthorizeUser('customer');

        $customer_id = $_SESSION['user_id'];
        $data['navigation'] = 'placereservation';
      
       

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
        $this->AuthorizeUser('customer');

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
        $this->AuthorizeUser('customer');

        $customer_id = $_SESSION['user_id'];
        $data['navigation'] = 'placereservation';

        $customer_details = $this->model('Customer')->getCustomerImage($customer_id);
        $row1 = mysqli_fetch_assoc($customer_details);
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
        $this->AuthorizeUser('customer');

        $customer_id = $_SESSION['user_id'];
        $data['navigation'] = 'placereservation';

     

        $data['bank_details'] = $this->model('Customer')->getDealerBankDetails();
        $data['confirmation'] = ''; //to display popup confirmation
        if($error != null){
            $data['toast'] = ['type'=>'error', 'message'=>$error];
        }
        
        $this->view('customer/place_reservation/bank_slip_upload',$data);
        
    }

    function get_bank_slip(){
        $this->AuthorizeUser('customer');

        $customer_id = $_SESSION['user_id'];
        $customer_details = $this->model('Customer')->getCustomerImage($customer_id);
        $row1 = mysqli_fetch_assoc($customer_details);
        $customer_type = $row1['type'];

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
                $_SESSION['order_id'] = $data['order_id']; //get the order id in session variable
                $this -> model('Customer')->update_remaining_weight($customer_type);   //update remaining weight of customer quota
                // $data['toast'] = ['type' => 'success', 'message' => "Your payment was successfull"];
                // $data['confirmation'] = '';
                // $this->view('customer/place_reservation/collecting_method',$data);
                header('LOCATION:'.BASEURL.'/Orders/select_collecting_method');

            }
            
        } 
    }

    //display payment gateway
    function payment_gateway(){
       $this->AuthorizeUser('customer');

        $customer_id = $_SESSION['user_id'];
        $data['navigation'] = 'placereservation';
        $customer_details = $this->model('Customer')->getCustomerImage($customer_id);
        $row1 = mysqli_fetch_assoc($customer_details);
        $data['name'] = $row1['first_name'].' '.$row1['last_name'];
        $customer_type = $row1['type'];
       
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
            $_SESSION['order_id'] = $data['order_id']; //get the order id in session variable
            $this -> model('Customer')->update_remaining_weight($customer_type);   //update remaining weight of customer quota
            // $data['toast'] = ['type' => 'success', 'message' => "Your payment was successfull"];
            // $data['confirmation'] = '';
            header('LOCATION:'.BASEURL.'/Orders/select_collecting_method');

        }else{
            //charging unsuccess
            $data['toast'] = ['type' => 'error', 'message' => "Payment failed, Please check you card details"];
            $this->select_payment_method($data['toast']);
        }
        // $this->view('customer/place_reservation/payment_gateway',$data);
    }

    //select collecting method of reservation(display delivery charge in pop up)
    function select_collecting_method(){
        $this->AuthorizeUser('customer');

        $customer_id = $_SESSION['user_id'];
        $data['navigation'] = 'placereservation';
        
        $customer_details = $this->model('Customer')->getCustomerImage($customer_id);
        $row1 = mysqli_fetch_assoc($customer_details);
        
        $order_id = $_SESSION['order_id'];
        $data['city'] = $row1['city'];
        $data['street'] = $row1['street'];
        $data['delivery_charge']= number_format($this->model('Customer')->get_delivery_charge($order_id,$data['street'],$data['city']),2); //take delivery charge 

        $data['confirmation'] = ''; //to display popup confirmation
        $data['toast'] = ['type' => 'success', 'message' => "Your payment was successfull"];
       
        $this->view('customer/place_reservation/collecting_method',$data);
        
    }



    //select delivery as collecting method then get delivery address and display delivery charge
    function change_delivery_address(){
        $this->AuthorizeUser('customer');

        $order_id = $_SESSION['order_id'];
        $data['order_id'] = $order_id;
        $customer_id = $_SESSION['user_id'];
        $data['navigation'] = 'placereservation';

        $customer_details = $this->model('Customer')->getCustomerImage($customer_id);
        $row1 = mysqli_fetch_assoc($customer_details);
        

        $data['selected_city'] = $_SESSION['city'];
        $data['home_city'] = $row1['city'];

        $data['city'] = $row1['city'];
        $data['street'] = $row1['street'];
        if(isset($_POST['new_street'])){
            if($_POST['new_street']==null){
                $data['error'] = 'Please enter your street';
                
            }else{
                $data['street'] = $_POST['new_street'];
                if(isset($_POST['new_city'])){
                    $data['city'] = $_POST['new_city'];
                }
            }

        }

        $data['delivery_charge']= number_format($this->model('Customer')->get_delivery_charge($order_id,$data['street'],$data['city']),2);   //take delivery charge
        $data['confirmation'] = ''; //to display popup confirmation

        echo json_encode($data);
    }

    function getcollecting_method($collecting_method,$delivery_city=null,$delivery_street=null,$delivery_charge=null){
        $this->AuthorizeUser('customer');

        $_SESSION['collecting_method'] = $collecting_method;
        $order_id = $_SESSION['order_id']; 

        $this -> model('Customer')->insertcollectingmethod($order_id,$delivery_city,$delivery_street,$delivery_charge);
        header('LOCATION:'.BASEURL.'/Dashboard/customer');

        //unset session variables of place_reservation
        unset($_SESSION['order_id']);
        unset($_SESSION['company_id']);
        unset($_SESSION['city']);
        unset($_SESSION['dealer_id']);
        unset($_SESSION['order_products']);
        unset($_SESSION['collecting_method']);
    }

    function sendMailLateDelivery(){
        echo $this->model("Dealer")->sendMailonLateDelivery();
    }

    function actiontodelay($mode,$order_id){
        $data = $this->model('Dealer')->actiontodelay($mode,$order_id);
        header('LOCATION: '.BASEURL.'/dashboard/customer/'.$data['error']);
    }

    function confirmCompleteOrder($order_id){
        if($this->model('Customer')->confirmCompleteOrder($order_id)){
            $toastnum = '4';
        }else{
            $toastnum = '5';
        }
        header('LOCATION: '.BASEURL.'/dashboard/customer/$toastnum');
    }



    /*..........................Customer quota......................... */
  
    function customer_quota(){
        $this->AuthorizeUser('customer');

        $data = array();
        $customer_id = $_SESSION['user_id'];

        // take quota information on each company
        $data['companies_array'] = $this->model('Customer')->getcustomerquota($customer_id);

        // get customer personal information and naviagation
        $data['navigation'] = 'quota';
        $this->view('customer/quota/quota',$data);
    }

 

    /*..............................DISTRIBUTOR GAS ORDERS TAB.........................................*/

    // distributor -> phurchase order interface
     public function distributor($param=null, $error=null) {
        $this->AuthorizeUser('distributor');

        // navigation and active tab in body
        $data['navigation'] = 'orders';
        $data['tab'] = $param;
        if($error != null) {
            $data['toast'] = $error;}

        // profile picture & notifications
        $distributor_details = $this->model('Distributor')->getDistributor($this->user_id);
        $row = mysqli_fetch_assoc($distributor_details);
        $data['image'] = $row['image'];
        $data['name'] = $row['first_name'].' '.$row['last_name'];
        $data['purchaseorder'] = $this->model('Distributor')->distributorstock($this->user_id); 
        $this->view('distributor/phurchase_orders',$data); 
     
    }

    // distributor place a purchase order
    public function purchase_order($param=null) {
        $this->AuthorizeUser('distributor');

        $productid = $_SESSION['productarray'];
        $postproducts = [];

        for($i=0; $i<count($productid); $i++) {
            $postproducts[$productid[$i]] = $_POST[$productid[$i]];
        }

        $data = $this->model('Distributor')->distributorplaceorder($this->user_id, $productid, $postproducts);

        if(isset($data['toast'])) {
            $this->distributor("purchaseorder", $data['toast']);
        }else {
            $this->view("/distributor/reports/purchaseorder", $data);
        }  
    }

    // distributor current stock (Gas Orders)
    public function distributor_currentstock() {
        $this->AuthorizeUser('distributor');

        $user_id = $_SESSION['user_id'];
        $data['navigation'] = 'orders';

        // profile picture
        $distributor_details = $this->model('Distributor')->getDistributorImage($user_id);
        $row = mysqli_fetch_assoc($distributor_details);
        $data['image'] = $row['image'];

        $data['currentstock']= $this->model("Distributor")->currentstock($user_id);
        
        $this->view('distributor/current_stock',$data);
    }
    
    //Placed orders list (Gas Orders)
    public function distributor_orderlist() {
        $this->AuthorizeUser('distributor');

        $user_id = $_SESSION['user_id'];
        $data['navigation'] = 'orders';

        // profile picture
        $distributor_details = $this->model('Distributor')->getDistributorImage($user_id);
        $row = mysqli_fetch_assoc($distributor_details);
        $data['image'] = $row['image'];

        $this->view('distributor/placed_pending',$data);

    }

    // (Gas Orders -> Placed Orders List) Pending gas orders
    public function dis_placed_pending() {
        $this->AuthorizeUser('distributor');

        $user_id = $_SESSION['user_id'];
        $data['navigation'] = 'orders';

        // profile picture
        $distributor_details = $this->model('Distributor')->getDistributorImage($user_id);
        $row = mysqli_fetch_assoc($distributor_details);
        $data['image'] = $row['image'];

        $data['pendingorders']= $this->model("Distributor")->pendingGasOrders($user_id);

        $this->view('distributor/placed_pending',$data);

    }

    // (Gas Orders -> Placed Orders List) Delayed gas orders
    public function dis_placed_accepted() {
        $this->AuthorizeUser('distributor');

        $user_id = $_SESSION['user_id'];
        $data['navigation'] = 'orders';

        // profile picture
        $distributor_details = $this->model('Distributor')->getDistributorImage($user_id);
        $row = mysqli_fetch_assoc($distributor_details);
        $data['image'] = $row['image'];

        $data['acceptedorders']= $this->model("Distributor")->acceptedGasOrders($user_id);
        
        $this->view('distributor/placed_accepted',$data);

    }
    
    // (Gas Orders -> Placed Orders List) completed gas orders
    public function dis_placed_completed() {
        $this->AuthorizeUser('distributor');

        $user_id = $_SESSION['user_id'];
        $data['navigation'] = 'orders';

        $distributor_details = $this->model('Distributor')->getDistributorImage($user_id);
        $row = mysqli_fetch_assoc($distributor_details);
        $data['image'] = $row['image'];

        $data['completedorders']= $this->model("Distributor")->completedGasOrders($user_id);
        
        $this->view('distributor/placed_completed',$data);

    }
    
    // suitable vehicle list for pending  gas orders
    public function suitableVehicleList(){
        $this->AuthorizeUser('distributor');

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
        $this->AuthorizeUser('admin');

        $data = $this->model('Admin')->getPaymentVerifications($tab);
        $this->view('admin/payments',$data);
    }

    public function validatepaymentsubmit($validity,$tab,$order_id){
        $this->AuthorizeUser('admin');
        
        $validity = ($validity == 'valid') ? true : false;
        $data = $this->model('Admin')->validatepaymentsubmit($validity,$tab,$order_id);
        header('location:'.BASEURL.'/orders/validatepayments/'.$tab.'');
    }

}

?>


