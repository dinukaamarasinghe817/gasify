<?php 
session_start();

class Dealers extends Controller {
    function __construct() {
        parent::__construct();
    }

    public function distributor_dealers() {
        $user_id = $_SESSION['user_id'];
        $data['navigation'] = 'dealers';

        $distributor_details = $this->model('Distributor')->getDistributorImage($user_id);
        $row = mysqli_fetch_assoc($distributor_details);
        $data['image'] = $row['image'];

        $data['dealers']= $this->model("Distributor")->viewdealers($user_id);

        $this->view('distributor/dealers',$data);

    }


    /*................................customer view dealers....................................*/
    public function customer_dealers() {
        $customer_id = $_SESSION['user_id'];
        $data['navigation'] = 'dealers';

        $customer_details = $this->model('Customer')->getCustomerImage($customer_id);
        $row1 = mysqli_fetch_assoc($customer_details);
        $data['image'] = $row1['image'];
        $data['name'] = $row1['first_name'].' '.$row1['last_name'];

        $data['dealers']= $this->model("Customer")->getAlldealers();
        $data['brands']= $this->model("Customer")->getCompanyBrand();

        $this->view('customer/dealers/viewdealers',$data);
    }

    // public function customer_selectdealer($dealer_id) {
    //     $customer_id  = $_SESSION['user_id'];
    //     $data['navigation'] = 'dealers';

    //     $customer_details = $this->model('Customer')->getCustomerImage($customer_id);
    //     $row1 = mysqli_fetch_assoc($customer_details);
    //     $data['image'] = $row1['image'];
    //     $data['name'] = $row1['first_name'].' '.$row1['last_name'];

    //     // $data['dealers']= $this->model("Customer")->viewdealers($user_id);

    //     $this->view('customer/dealers/selectdealer',$data);
    // }
   
}

?>