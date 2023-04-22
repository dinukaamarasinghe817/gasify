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
        // $data = $this->model("Distributor")->reportdetails($user_id);
        // $row = mysqli_fetch_assoc($this->model("Distributor")->reportdetails($this->$user_id));
        // $data['distribution_no'] = $row['distribution_no'];

        $this->view('distributor/reports/report_pdf',$data);
    }

    public function dealer(){
        if(isset($_POST['start_date'])){
            $start_date = $_POST['start_date'];
        }else{
            $start_date = null;
        }

        if(isset($_POST['end_date'])){
            $end_date = $_POST['end_date'];
        }else{
            $end_date = date('Y-m-d');
        }

        if(isset($_POST['filter'])){
            $order_by = $_POST['filter'];
        }else{
            $order_by = 'soldquantity';
        }
        
        $data = $this->model("Dealer")->getReportInfo($start_date,$end_date,$order_by);
        $row = mysqli_fetch_assoc($this->model('Dealer')->getDealer($this->user_id));
        $data['image'] = $row['image'];
        $data['name'] = $row['first_name'].' '.$row['last_name'];
        $data['date_joined'] = $row['date_joined'];
        $this->view('dealer/reports',$data);
    }

    public function salesdealer($start_date,$end_date,$order_by){
        // $start_date = $_POST['start_date'];
        // $end_date = $_POST['end_date'];
        // $order_by = $_POST['filter'];
        $data = $this->model("Dealer")->getReportInfo($start_date,$end_date,$order_by);
        $row = mysqli_fetch_assoc($this->model('Dealer')->getDealer($this->user_id));
        $data['dealer_id'] = $row['user_id'];
        $data['business_name'] = $row['name'];
        $data['issue_date'] = date('Y-m-d');
        $data['issue_time'] = date('H:i:s');
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
    public function salesCompany(){
        //$conn = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
        $data=[];
        $distID = $_POST["distID"];
        $from = $_POST["from"];
        $to = $_POST["to"];
        $tableArr = $_POST["tableArr"];
        $arr=json_decode($tableArr,true);
        $data['distID']=$distID;
        $data['from']=$from;
        $data['tableArr']=$arr;
        $data['distributorName']=$this->model('Company')->getDistributorName($distID);
        //echo count($arr) ;

        $res =$this->view('company/reports/salesreport',$data);
        //echo $res;
    }

}


?>