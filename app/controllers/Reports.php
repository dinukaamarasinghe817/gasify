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

        if(isset($_POST['option'])){
            $option = $_POST['option'];
        }else{
            $option = 'today';
        }
        // profile picture
        $distributor_details = $this->model('Distributor')->getDistributorImage($user_id);
        $row = mysqli_fetch_assoc($distributor_details);
        $data['image'] = $row['image'];

        $data['distributions'] = $this->model("Distributor")-> reportpastdistributions($user_id, $option);
       
        $data['option'] = $option;
        $this->view('distributor/reports',$data);

    }

    public function distributor_pdf($user_id) {
        $data = [];
        $data['reportdetails'] = $this->model("Distributor")-> reportdetails($user_id);

        $this->view('distributor/reports/report_pdf',$data);
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
    public function companySales(){
        $data = [];
        $this->view('company/reports/salesreport',$data);
    }
    public function deliverySales(){
        $data = [];
        $this->view('delivery/reports/salesreport',$data);
    }

    public function admin(){
        $start_date = '';
        $to_date = '';
        $order_by = '';
        $data = $this->model("Admin")->getReportInfo($start_date,$to_date,$order_by);
        $row = mysqli_fetch_assoc($this->model('Admin')->getAdmin($this->user_id));
        $data['image'] = $row['image'];
        $data['name'] = $row['first_name'].' '.$row['last_name'];
        $this->view('admin/reports',$data);
    }

    public function salesadmin(){
        $data = [];
        $this->view('admin/reports/salesreport',$data);
    }

}


?>