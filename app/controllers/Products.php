<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header('Location: ' . BASEURL . '/home');
}

class Products extends Controller{
    function __construct(){
        parent::__construct();
    }

    // customer view company products in dashboard
    function view_company_products($company_id){

        $customer_id = $_SESSION['user_id'];
        $data['navigation'] = 'dashboard';
        $data['company_id'] = $company_id;

        $customer_details = $this->model('Customer')->getCustomerImage($customer_id);
        $row1 = mysqli_fetch_assoc($customer_details);
        $data['image'] = $row1['image'];
        $data['name'] = $row1['first_name'].' '.$row1['last_name'];


        $data['products']= $this ->model('Customer')->getCompanyProducts($company_id);
        $this->view('customer/dashboard/view_company_products',$data);
    }


}

?>