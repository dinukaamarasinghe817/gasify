<?php
session_start();
// if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
//     header('Location: ' . BASEURL . '/home');
// }

class GasDistributions extends Controller {
    function __construct() {
        parent::__construct();
    }

    public function pending_distributions() {
        $user_id = $_SESSION['user_id'];
        $data['navigation'] = 'distributions';

        $distributor_details = $this->model('Distributor')->getDistributorImage($user_id);
        $row = mysqli_fetch_assoc($distributor_details);
        $data['image'] = $row['image'];

        $data['pending_distributions']= $this->model("Distributor")->pendingdistributions($user_id);

        $this->view('distributor/pending_distributions', $data);
   
    }

    public function donepending($distribution_id) {
        $this->model("Distributor")->finishpendingdistributions($distribution_id);
        $this->pending_distributions();
    }

    public function completed_distributions() {
        $user_id = $_SESSION['user_id'];
        $data['navigation'] = 'distributions';

        $distributor_details = $this->model('Distributor')->getDistributorImage($user_id);
        $row = mysqli_fetch_assoc($distributor_details);
        $data['image'] = $row['image'];

        $data['completed_distributions']= $this->model("Distributor")->completedistributions($user_id);


        $this->view('distributor/completed_distributions', $data);

    }
}

?>