<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header('Location: ' . BASEURL . '/home');
}

class Orders extends Controller{
    function __construct(){
        parent::__construct();
    }

    function dealer(){
        $dealer_id = $_SESSION['user_id'];
        $data['navigation'] = 'orders';
        $dealer_details = $this->model('Dealer')->getDealerImage($dealer_id);
        $row = mysqli_fetch_assoc($dealer_details);
        $data['image'] = $row['image'];
        $this->view('dashboard/dealer', $data);
    }


    //customer past all reservtions
    function customer(){
        $customer_id = $_SESSION['user_id'];
        $data['navigation'] = 'myreservation';
        $customer_details = $this->model('Customer')->getCustomerImage($customer_id);
        $row = mysqli_fetch_assoc($customer_details);
        $data['image'] = $row['image'];
        $this->view('customer/allmyreservation', $data);
    }



}