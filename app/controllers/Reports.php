<?php 
session_start();


class Reports extends Controller{
    function __construct() {
        parent::__construct();
    }

    public function distributor() {
        $user_id = $_SESSION['user_id'];
        $data['navigation'] = 'reports';

        // profile picture
        $distributor_details = $this->model('Distributor')->getDistributorImage($user_id);
        $row = mysqli_fetch_assoc($distributor_details);
        $data['image'] = $row['image'];

        // report view
        // create the model
        // $this->view('distributor/reports',$data);
        $this->view('distributor/reports',$data);


    }

}


?>