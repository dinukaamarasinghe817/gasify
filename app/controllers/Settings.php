<?php
session_start();


class Settings extends Controller {
    function __construct() {
        parent::__construct();
    }

    public function distributor() {
        $user_id = $_SESSION['user_id'];
        $data['navigation'] = 'settings';

        $distributor_details = $this->model('Distributor')->getDistributorImage($user_id);
        $row = mysqli_fetch_assoc($distributor_details);
        $data['image']=$row['image'];

        $data['profile'] = $this->model("Distributor")->viewprofile($user_id);

        $this->view('distributor/settings', $data);
    }


    public function updateprofile() {
        $user_id = $_SESSION['user_id'];
        $data['navigation'] = 'settings';

        $distributor_details = $this->model('Distributor')->getDistributorImage($user_id);
        $row = mysqli_fetch_assoc($distributor_details);
        $data['image']=$row['image'];

        $data['profiledata'] = $this->model("Distributor")->viewprofile($user_id);

        $this->view('distributor/settings', $data);
    }

    // public function updateprofile_form() {
    //     $user_id = $_SESSION['user_id'];
    //     $data['navigation'] = 'settings';

    //     $distributor_details = $this->model('Distributor')->getDistributorImage($user_id);
    //     $row = mysqli_fetch_assoc($distributor_details);
    //     $data['image']=$row['image'];

    //     $this->view('distributor/settings', $data);
    // }



}


?>