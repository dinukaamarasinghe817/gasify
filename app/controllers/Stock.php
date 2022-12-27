<?php
// AuthorizeLogin();
session_start();
// if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
//     header('Location: ' . BASEURL . '/home');
// }
class Stock extends Controller{
    function __construct(){
        parent::__construct();
    }

    function dealer(){
        $user_id = $_SESSION['user_id'];
        $data['navigation'] = 'stock';
        // profile picture & notifications
        $dealer_details = $this->model('Dealer')->getDealerImage($user_id);
        $row = mysqli_fetch_assoc($dealer_details);
        $data['image'] = $row['image'];

        // body data
        $data['current_stock'] = $this->model('Dealer')->getStockInfo($user_id);

        $this->view('dealer/stock', $data);
    }
}