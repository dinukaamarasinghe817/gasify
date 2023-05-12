<?php
session_start();
// if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
//     header('Location: ' . BASEURL . '/home');
// }

class GasDistributions extends Controller {
    function __construct() {
        parent::__construct();
        $this->AuthorizeLogin();
    }

        // gas distributions - pending gas distributions
    public function pending_distributions($error=null, $success=null) {
        $this->AuthorizeUser('distributor');

        $user_id = $_SESSION['user_id'];
        $data['navigation'] = 'distributions';

        $distributor_details = $this->model('Distributor')->getDistributorImage($user_id);
        $row = mysqli_fetch_assoc($distributor_details);
        $data['image'] = $row['image'];

        if($error != null) {
            $data['toast'] = $error;
        }
        if($success != null) {
            $data['success'] = $success;
        }

        $data['pending_distributions']= $this->model("Distributor")->pendingdistributions($user_id);
        $this->view('distributor/pending_distributions', $data);
   
    }

    // after distributing an order
    public function donepending($distribution_id) {
        $this->AuthorizeUser('distributor');

        $data = $this->model("Distributor")->finishpendingdistributions($distribution_id);

        if(isset($data['toast'])) {
            $this->pending_distributions($data['toast']);
        }elseif(isset($data['success'])) {
            $this->pending_distributions($data['success']);
        }
        $this->pending_distributions();
    }

        // gas distributions - completed gas distributions
        public function completed_distributions() {
        $this->AuthorizeUser('distributor');
        
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