<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header('Location: ' . BASEURL . '/home');
}

class Support extends Controller{
    function __construct(){
        parent::__construct();
    }


    function customer_support(){

        $customer_id = $_SESSION['user_id'];
        $data['navigation'] = 'help';
       

        $customer_details = $this->model('Customer')->getCustomerImage($customer_id);
        $row = mysqli_fetch_assoc($customer_details);
        $data['image'] = $row['image'];

        // $data['products']= $this ->model('Customer')->getCompanyProducts($company_id);
        $this->view('customer/support',$data);
    }


}

?>