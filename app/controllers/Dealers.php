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
    //select dealers according to brand and city
    public function customer_dealers($brand_name=null,$city_name = null) {

        $customer_id = $_SESSION['user_id'];
        $data['navigation'] = 'dealers';

        $customer_details = $this->model('Customer')->getCustomerImage($customer_id);
        $row1 = mysqli_fetch_assoc($customer_details);
        $data['image'] = $row1['image'];
        $data['name'] = $row1['first_name'].' '.$row1['last_name'];

        $data['brands']= $this->model("Customer")->getCompanyBrand();
        $data['dealers']= $this->model("Customer")->getdealers($brand_name,$city_name);

        $this->view('customer/dealers/viewdealers',$data);

    }

    //display dealers table according to selected brand and city
    public function selected_brand_dealers($brand_name=null,$city_name=null) {

        $data['dealers']= $this->model("Customer")->getdealers($brand_name,$city_name);
        //view of changing part of table
        $this -> view('customer/dealers/dealers_ajax',$data);
    }


}

?>