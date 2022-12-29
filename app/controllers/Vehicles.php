<?php
// AuthorizeLogin();
session_start();
// if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
//     header('Location: ' . BASEURL . '/home');
// }
class Vehicles extends Controller{
    function __construct(){
        parent::__construct();
    }

    function distributor(){
        $user_id = $_SESSION['user_id'];
        $data['navigation'] = 'vehicles';
        // profile picture & notifications
        $distributor_details = $this->model('Distributor')->getDistributorImage($user_id);
        $row = mysqli_fetch_assoc($distributor_details);
        $data['image'] = $row['image'];

        // body data
        $data['vehicles'] = $this->model('Distributor')->getVehicleInfo($user_id);

        $this->view('distributor/vehicles', $data);
    }
}