<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header('Location: ' . BASEURL . '/home');
}

class Orders extends Controller{
    function __construct(){
        parent::__construct();
    }

    function dealer($tab1, $tab2){
        $dealer_id = $_SESSION['user_id'];
        $data['navigation'] = 'orders';
        $dealer_details = $this->model('Dealer')->getDealer($dealer_id);
        $row = mysqli_fetch_assoc($dealer_details);
        $data['image'] = $row['image'];
        $dealer_details = $this->model('Dealer')->dealerOrders($dealer_id,$tab1,$tab2);
        $this->view('dealer/orders', $data);
    }

    /*.................Customer my reservation...............*/
    //customer all past reservtions
    function customer_allreservations(){
        $customer_id = $_SESSION['user_id'];
        $data['navigation'] = 'myreservation';

        $customer_details = $this->model('Customer')->getCustomerImage($customer_id);
        $row = mysqli_fetch_assoc($customer_details);
        $data['image'] = $row['image'];

        $data['allmyreservations'] = $this->model('Customer')->getAllmyreservations($customer_id);
       
        $this->view('customer/allmyreservation', $data);
    }

    //customer selected one reservation details from all past reservations
    function customer_myreservation($order_id){
        $customer_id = $_SESSION['user_id'];
        $data['navigation'] = 'myreservation';

        $customer_details = $this->model('Customer')->getCustomerImage($customer_id);
        $row = mysqli_fetch_assoc($customer_details);
        $data['image'] = $row['image'];

        $data['myreservation'] = $this->model('Customer')->ViewMyreservation($order_id,$customer_id);
        
        $this->view('customer/viewmyreservation', $data);
    }

    //get collecting method for display review type in review form
    function customer_reviewform($order_id){
        $customer_id = $_SESSION['user_id'];
        $data['navigation'] = 'myreservation';

        $customer_details = $this->model('Customer')->getCustomerImage($customer_id);
        $row = mysqli_fetch_assoc($customer_details);
        $data['image'] = $row['image'];

        $data['collecting_method'] = $this->model('Customer')->getcollecting_method($order_id,$customer_id);
        $data['order_id'] = $order_id;
        $data['customer_id'] = $customer_id;
        $this->view('customer/addreview', $data);
    }

    //add review for the selected past reservstion
    function customer_addreview($order_id){
        $customer_id = $_SESSION['user_id'];
        $reviews = $_POST['review'];
        $review_type = "";
        if(isset($_POST['review_type'])){
            $review_type = $_POST['review_type'];
        }
        $data['add_review'] = $this->model('Customer')->AddReviw($order_id,$customer_id,$reviews,$review_type);

        $this->customer_myreservation($order_id);
    }

    /*.................Customer place reservation.................*/
    //select brand,city and dealer
    function select_brand_city_dealer(){
        $customer_id = $_SESSION['user_id'];
        $data['navigation'] = 'placereservation';

        $customer_details = $this->model('Customer')->getCustomerImage($customer_id);
        $row = mysqli_fetch_assoc($customer_details);
        $data['image'] = $row['image'];

        $this->view('customer/select_brand_city_dealer',$data);

    }




     // distributor phurchase orders to company (Gas Orders)
     public function distributor() {
        $user_id = $_SESSION['user_id'];
        $data['navigation'] = 'orders';

        // profile picture
        $distributor_details = $this->model('Distributor')->getDistributorImage($user_id);
        $row = mysqli_fetch_assoc($distributor_details);
        $data['image'] = $row['image'];

        // phurchase order  view
        // create the model
        // $this->view('distributor/reports',$data);
        $this->view('distributor/phurchase_orders',$data);

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

        // phurchase order  view
        // create the model
        // $this->view('distributor/reports',$data);
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

        // phurchase order  view
        // create the model
        // $this->view('distributor/reports',$data);
        $this->view('distributor/placed_accepted',$data);

    }

    // Gas Orders -> Places orders list , completed gas orders
    public function dis_placed_completed() {
        $user_id = $_SESSION['user_id'];
        $data['navigation'] = 'orders';

        // profile picture
        $distributor_details = $this->model('Distributor')->getDistributorImage($user_id);
        $row = mysqli_fetch_assoc($distributor_details);
        $data['image'] = $row['image'];

        // phurchase order  view
        // create the model
        // $this->view('distributor/reports',$data);
        $this->view('distributor/placed_completed',$data);

    }

}



