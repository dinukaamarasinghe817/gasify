<?php 
session_start();


class Reports extends Controller{
    private $user_id;
    function __construct() {
        parent::__construct();
        $this->user_id = $_SESSION['user_id'];
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

    public function dealer(){
        $start_date = '';
        $to_date = '';
        $order_by = '';
        $data = $this->model("Dealer")->getReportInfo($start_date,$to_date,$order_by);
        $row = mysqli_fetch_assoc($this->model('Dealer')->getDealer($this->user_id));
        $data['image'] = $row['image'];
        $data['name'] = $row['first_name'].' '.$row['last_name'];
        $this->view('dealer/reports',$data);
    }

    public function salesdealer(){
        $data = [];
        $this->view('dealer/reports/salesreport',$data);
    }

}


?>