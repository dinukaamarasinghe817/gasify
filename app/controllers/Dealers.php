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

    //   rest of models
        $this->view('distributor/dealers',$data);

    }

}

?>