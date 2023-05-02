<?php
session_start();
// if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
//     header('Location: ' . BASEURL . '/home');
// }

class GasDistributions extends Controller {
    function __construct() {
        parent::__construct();
    }

    // public function pending_distributions($error=NULL) {
    //     $user_id = $_SESSION['user_id'];
    //     $data['navigation'] = 'distributions';

    //     if($error!= NULL) {
    //         $data['toast'] = $error;
    //     }

    //     $distributor_details = $this->model('Distributor')->getDistributorImage($user_id);
    //     $row = mysqli_fetch_assoc($distributor_details);
    //     $data['image'] = $row['image'];

    //     $data['pending_distributions']= $this->model("Distributor")->pendingdistributions($user_id);

    //     $this->view('distributor/pending_distributions', $data);
   
    // }

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
       
        // $data = $this->model("Distributor")->finishpendingdistributions($distribution_id);

        // if(isset($result['toast'])) {
        //     // $toast = $result['toast'];
        //     $this->pending_distributions($data['toast']);
        // }
        // $this->pending_distributions();

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