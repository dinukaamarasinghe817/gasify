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

    /*************************************************************CUSTOMER ORDERS******************************************************************/ 
    /*....................................................Customer my reservation.................................................................*/
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
    function customer_myreservation($order_id,$error=null){
        $this->AuthorizeUser('customer');

        //if there is error display the error message
        switch($error){
            //rejected payslip upload successful message
            case "1":
                $data['toast'] = ['type' => 'success', 'message' => "You've successfully uploaded your payslip."];
                break;
        }

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

        //get collecting method to display review type(Only delivery orders have review type)
        $data['collecting_method'] = $this->model('Customer')->getcollecting_method($order_id,$customer_id);
        $data['order_id'] = $order_id;
        $data['customer_id'] = $customer_id;
        if($error != null){
            $data['toast'] = ['type'=>'error', 'message'=>$error];
        }
    
        //view of review form
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
        //return if there is any errors(emppty fields) or insert review 
        $data['add_review_error'] = $this->model('Customer')->AddReview($order_id,$customer_id,$reviews,$review_type);
        if(!empty($data['add_review_error'])){
            $this->customer_reviewform($order_id,$data['add_review_error']);  //in the same page with error message
        }
        else{
            $this->customer_myreservation($order_id); //moves to myreservation page
        }    
       
    }


    //cancel the reservation(display refund form)
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
        $this->view('customer/my_reservation/cancel_reservation', $data);  //display refund form


    }

    //take refund form data and update reservation table
    function refund_bank_details($order_id){
        $this->AuthorizeUser('customer');

        $customer_id = $_SESSION['user_id'];

        //get form data
        if(isset($_POST['bank'])){
            $bank = $_POST['bank'];
        }else{
            $bank = -1;
        } 
        $branch = $_POST['branch'];
        $Acc_no = $_POST['Acc_no'];
        
        $this->model('Customer')->add_refund_details($order_id, $bank,$branch,$Acc_no);
        if($bank == -1 || empty($branch) ||empty($Acc_no) ){
            $this->customer_cancelreservation($order_id,1); //in the same page with error message
        }
        else{
            $this->customer_allreservations(1);  //move to all reservations tab with success message
        }    
    }

    /*............................................................Rejected payslip...............................................................*/ 

    //display bank slip uploader for rejected payslips
    function reject_bank_slip_upload($order_id,$dealer_id,$error=null){
        $this->AuthorizeUser('customer');

        //if there is error display the error message
        switch($error){
            //not upload bank slip
            case "1":
                $data['toast'] = ['type' => 'error', 'message' => "Please upload a bank slip image!"];
                break;
        }

        $customer_id = $_SESSION['user_id'];
        $data['navigation'] = 'myreservation';

        $data['order_id'] = $order_id;
        $data['dealer_id'] = $dealer_id;
        //get bank details of relevant dealer
        $data['bank_details'] = $this->model('Customer')->getDealerBankDetails_rejectpayment($dealer_id);
        $data['confirmation'] = ''; //to display popup confirmation
        
        $this->view('customer/place_reservation/rejected_bank_slip_upload',$data);  //display bank slip uploader
        
    }

    //get new bank slip and store when previous slip rejected
    function get_rejected_bank_slip($order_id,$dealer_id){
        $this->AuthorizeUser('customer');

        $customer_id = $_SESSION['user_id'];
        $data['navigation'] = 'myreservation';
        
        if(isset($_POST['submit_btn'])){
            $file_name = $_FILES['slip_img']['name']; 
            $file_type = $_FILES['slip_img']['type'];
            $file_size = $_FILES['slip_img']['size'];
            $temp_name = $_FILES['slip_img']['tmp_name'];

            $image = getImageRename($file_name,$temp_name);  //timebind the image and rename
            $upload_to = 'C:/xampp/htdocs/mvc/public/img/payslips/';
            move_uploaded_file($temp_name,$upload_to . $file_name);  //store the payslip ipayslips folder 


            if($file_size<=0){
                $this -> reject_bank_slip_upload($order_id,$dealer_id,1);  //if not upload any file display error message
            }
            else{
                $this->model('Customer')->update_payment_slip($order_id,$image); //update reservation table with new payslip
                $this->customer_myreservation($order_id,1); //move to myreservation tab with success message
            }
            
        } 
    }

   

    /*.........................................................Customer quota.................................................................... */
  
    function customer_quota(){
        $this->AuthorizeUser('customer');

        $data = array();
        $customer_id = $_SESSION['user_id'];

        // take quota information on each company
        $data['companies_array'] = $this->model('Customer')->getcustomerquota($customer_id);

        // get customer personal information and naviagation
        $data['navigation'] = 'quota';
        $this->view('customer/quota/quota',$data);   //display the quota details
    }

 
    /*..........................................................Customer place reservation........................................................*/
    //select brand,city and dealer
    function select_brand_city_dealer($error=null){
        $this->AuthorizeUser('customer');

         //if there is error display the error message
         switch($error){
            //not selected brand,city,dealer error
            case "1":
                $data['toast'] = ['type' => 'error', 'message' => "Please fill all fields"];
                break;
        }

        $customer_id = $_SESSION['user_id'];
        $data['navigation'] = 'placereservation';


        $data['brands'] = $this->model('Customer')->getCompanyBrand();      //get all gas companies for display
        $data['dealers'] = $this->model('Customer')->getdealers();          //get all dealers for display
        $data['city'] = $this->model('Customer')->getCustomer($customer_id);  //get customer city for display

        $this->view('customer/place_reservation/select_brand_city_dealer',$data);  //display to select brand,city,dealer

    }

    //display dealer dropdown ,dealers according to brand and city
    function filter_dealers($company_id=null,$city=null,$dealer=null){
        $this->AuthorizeUser('customer');

        $customer_id = $_SESSION['user_id'];
        $data['navigation'] = 'placereservation';
        $data['dealers'] = $this->model('Customer')->getdealers($company_id,$city);  //get dealers according to selected company and city
        
        $this -> view('customer/place_reservation/filter_dealers',$data);  //display dealer dropdown with relevant options

    }

    //get brand,city,dealer values and store them in session variables
    function get_brand_city_dealer(){
        $this->AuthorizeUser('customer');

        $customer_id = $_SESSION['user_id'];
        $data['navigation'] = 'placereservation';

        //get brand,city,dealer values
        if(isset($_POST['brand'])){$brand = $_POST['brand'];}else{$brand = null;}
        $city = $_POST['city'];
        if(isset($_POST['dealer'])){$dealer = $_POST['dealer'];}else{$dealer = null;}

        //declare session variables
        $_SESSION['company_id'] = $brand;
        $_SESSION['city'] = $city;
        $_SESSION['dealer_id'] = $dealer;

       if($brand == null || $dealer == null){
            $this->select_brand_city_dealer(1); //in the same page with error message
       }
       if($brand != null && $dealer != null){
            $this -> select_products();  //move to select products page
       }

    }

     //display all products according to the selected dealer
     function select_products($error=null){
        $this->AuthorizeUser('customer');

        //if there is error display the error message
        switch($error){
            //not selected atleast one product
            case "1":
                $data['toast'] = ['type' => 'error', 'message' => "You must select at least one product"];
                break;
            //exceed quota limit error message
            case "2":
                $data['toast'] = ['type' => 'error', 'message' => "Your quota amount is exceeded!"];
                break;
        }

        $customer_id = $_SESSION['user_id'];
        $data['navigation'] = 'placereservation';
      
        //get brand,city,dealer from session
        $company_id = $_SESSION['company_id'];
        $city = $_SESSION['city'];
        $dealer_id = $_SESSION['dealer_id'];

        //get selected dealer selling products from database
        $data['products']= $this ->model('Customer')->getDealerProducts($dealer_id);
        $data['company_id'] = $company_id;
        $data['city'] = $city;
        $data['dealer_id'] = $dealer_id;

        $this->view('customer/place_reservation/select_products',$data);  //display relevant dealer selling products

    }

    //get customer selected products and insert into database
    function selected_products($dealer_id){
        $this->AuthorizeUser('customer');

        $customer_id = $_SESSION['user_id'];
        $data['navigation'] = 'placereservation';
        //customer type to check quota
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

        //selected product details put into array
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
            $_SESSION['order_products'] = $selected_products;  //store the selected products in the session
            $total_weight_cylinders = $this->model('Customer')->products_total_weight();   //total weight of selected cylinder products
            //check quota is active or not
            if($quota_state == 'ON'){
                //check remaining quota exceed or not
                if($total_weight_cylinders <= $remaining_weight ){
                    $this->select_payment_method();
                }else{
                   $this->select_products(2);  //in the same page with error message
                }
            }else{
                $this->select_payment_method();  //move to select payment method
            }
               
        }
        else{
            $this->select_products(1);  //in the same page with error message
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
       
        $data['selected_products']= $this ->model('Customer')->getSelectedProducts();  //get require details of selected products in session
        $data['dealer_keys'] = $this ->model('Customer')->getdealerpubkey($_SESSION['dealer_id']); //get dealer keys for payment gateway
        if($error != null){
            $data['toast'] = $error;
        }
       
        $this->view('customer/place_reservation/select_payment_method',$data); //display to select payment method
    }


    //display bank slip uploader
    function bank_slip_upload($error=null){
        $this->AuthorizeUser('customer');

        //if there is error display the error message
        switch($error){
            //not upload slip
            case "1":
                $data['toast'] = ['type' => 'error', 'message' => "Please upload a bank slip image!"];
                break;
        }

        $customer_id = $_SESSION['user_id'];
        $data['navigation'] = 'placereservation';

        $data['bank_details'] = $this->model('Customer')->getDealerBankDetails();
        $data['confirmation'] = ''; //to display popup confirmation
        $this->view('customer/place_reservation/bank_slip_upload',$data);  //display bank slip uploader
        
    }

    //place reservation if bank slip upload sucessfully
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
            $_SESSION['slip_img'] = ['file_name' => $file_name, 'temp_name' =>$temp_name];
            // move_uploaded_file($temp_name,$upload_to . $file_name);

            //check bank slip upload or not
            if($file_size<=0){
                $this -> bank_slip_upload(1);
            }
            else{
                $dealer_id = $_SESSION['dealer_id'];
                $products = $_SESSION['order_products'];
                //place the reservation(insert reservation to db in Dealer model query)
                $data['order_id'] = $this->model('Dealer')->customerOrder($customer_id,$dealer_id,$products,'Bank Deposit');
                $_SESSION['order_id'] = $data['order_id']; //store the order id in session variable
                $this -> model('Customer')->update_remaining_weight($customer_type);   //update remaining weight of customer quota if active
                header('LOCATION:'.BASEURL.'/Orders/select_collecting_method'); //move to select collecting method page

            }
            
        } 
    }

    //place reservation if credit card payment sucessful
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
             //place the reservation(insert reservation to db in Dealer model query)
            $data['order_id'] = $this->model('Dealer')->customerOrder($customer_id,$dealer_id,$products,'Credit card');
            $_SESSION['order_id'] = $data['order_id']; //store the order id in session variable
            $this -> model('Customer')->update_remaining_weight($customer_type);   //update remaining weight of customer quota if active
            header('LOCATION:'.BASEURL.'/Orders/select_collecting_method');

        }else{
            //charging unsuccess
            $data['toast'] = ['type' => 'error', 'message' => "Payment failed, Please check you card details"];
            $this->select_payment_method($data['toast']);
        }
        
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
       
        $this->view('customer/place_reservation/collecting_method',$data);  //display to select collecting method
        
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
        $data['home_city'] = $row1['city'];  //default city 

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

        echo json_encode($data);  //return new address and delivery charge
    }

    //update reservation collecting method and unset session varables(end of the reservation process)
    function getcollecting_method($collecting_method,$delivery_city=null,$delivery_street=null,$delivery_charge=null){
        $this->AuthorizeUser('customer');

        $_SESSION['collecting_method'] = $collecting_method;  //store collecting method in session
        $order_id = $_SESSION['order_id']; 

        $this -> model('Customer')->insertcollectingmethod($order_id,$delivery_city,$delivery_street,$delivery_charge);
        header('LOCATION:'.BASEURL.'/Dashboard/customer');  //move to dashboard

        //unset session variables of place_reservation
        unset($_SESSION['order_id']);
        unset($_SESSION['company_id']);
        unset($_SESSION['city']);
        unset($_SESSION['dealer_id']);
        unset($_SESSION['order_products']);
        unset($_SESSION['collecting_method']);
    }

    /****************************************************customer mails and notifications*********************************************************/ 
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


    /*********************************************************DISTRIBUTOR GAS ORDERS TAB***********************************************************/

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
    
    // suitable vehicle list for pending , accepted gas orders
    public function suitableVehicleList($po_id){
        $this->AuthorizeUser('distributor');

        $user_id = $_SESSION['user_id'];
        $data['navigation'] = 'distributions';

        $distributor_details = $this->model('Distributor')->getDistributorImage($user_id);
        $row = mysqli_fetch_assoc($distributor_details);
        $data['image'] = $row['image'];

        // previouse method
        // $data['suitablevehiclelist'] = $this->model("Distributor")->viewvehicle($user_id);
        $data['suitablevehiclelist'] = $this->model("Distributor")->getOnlyEligibleVehicles($po_id);
        // var_dump($data['suitablevehiclelist']);
        $data['po_id'] = $po_id;
        $this->view('distributor/suitableVehicleList', $data);
    }

    public function selectedVehicle($po_id,$vehicle_id){
        $this->model('Distributor')->selectedVehicle($po_id,$vehicle_id);
        // navigate user to pending distributions
        header('Location: '.BASEURL.'/gasdistributions/pending_distributions/1');
    }

    // suitable vehicle list for gas orders 
    public function suitableVehicles(){
        $this->AuthorizeUser('distributor');

        $user_id = $_SESSION['user_id'];
        $data['navigation'] = 'distributions';

        $distributor_details = $this->model('Distributor')->getDistributorImage($user_id);
        $row = mysqli_fetch_assoc($distributor_details);
        $data['image'] = $row['image'];

        $data['suitablevehiclelist'] = $this->model("Distributor")->viewvehicle($user_id);
        $this->view('distributor/suitable', $data);

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


