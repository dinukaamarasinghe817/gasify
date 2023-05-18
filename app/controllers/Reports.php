<?php 
session_start();


class Reports extends Controller{
    private $user_id;
    function __construct() {
        parent::__construct();
        $this->AuthorizeLogin();
        $this->user_id = $_SESSION['user_id'];
    }

    // summary of past distirbutions interface [report1]
    public function distributor() {  
        $this->AuthorizeUser('distributor');

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

    // generate pdf [report1]
    public function distributor_pdf($user_id) {
        $this->AuthorizeUser('distributor');

        $data = [];
        $data['reportdetails'] = $this->model("Distributor")-> reportdetails($user_id);
        $this->view('distributor/reports/report_pdf',$data);
    }

    // all sold products report  [report2]
    public function allsellproducts() {
        $this->AuthorizeUser('distributor');

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

        $data['allproductsquantity'] = $this->model("Distributor")-> AllSellProducts($option);
       
        $data['option'] = $option;
        $this->view('distributor/report2',$data);

    }

    // all requested products  [report3]
    public function allrequestedproducts() {
        $this->AuthorizeUser('distributor');

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

        $data['allproductsquantity'] = $this->model("Distributor")-> AllRequestedProducts($option);
       
        $data['option'] = $option;
        $this->view('distributor/report3',$data);

    }

    /*-------------------------------------------------------------------------------------------------------------------*/

    public function dealer(){
        $this->AuthorizeUser('dealer');

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

        if(isset($_POST['catagory'])){
            $catagory_by = $_POST['catagory'];
        }else{
            $catagory_by = 'all';
        }
        
        $data = $this->model("Dealer")->getReportInfo($start_date,$end_date,$order_by,$catagory_by);
        $row = mysqli_fetch_assoc($this->model('Dealer')->getDealer($this->user_id));
        $data['date_joined'] = $row['date_joined'];
        $this->view('dealer/reports',$data);
    }

    public function salesdealer($start_date,$end_date,$order_by,$catagory_by){
        $this->AuthorizeUser('dealer');

        // $start_date = $_POST['start_date'];
        // $end_date = $_POST['end_date'];
        // $order_by = $_POST['filter'];
        $data = $this->model("Dealer")->getReportInfo($start_date,$end_date,$order_by,$catagory_by);
        $row = mysqli_fetch_assoc($this->model('Dealer')->getDealer($this->user_id));
        $data['dealer_id'] = $row['user_id'];
        $data['business_name'] = $row['name'];
        $data['issue_date'] = date('Y-m-d');
        $data['issue_time'] = date('H:i:s');
        $this->view('dealer/reports/salesreport',$data);
    }
    public function companySales(){
        $this->AuthorizeUser('company');
        $data = [];
        $this->view('company/reports/salesreport',$data);
    }
    public function deliverySales(){
        $this->AuthorizeUser('delivery');
        $data = [];
        $this->view('delivery/reports/salesreport',$data);
    }

    public function admin(){
        $this->AuthorizeUser('admin');
        date_default_timezone_set("Asia/Colombo");
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
            $filter_by = $_POST['filter'];
        }else{
            $filter_by = 'all';
        }
        $data = $this->model("Admin")->getReportInfo($start_date,$end_date,$filter_by);
        $this->view('admin/reports',$data);
    }

    public function salesadmin($start_date,$end_date,$filter_by){
        $this->AuthorizeUser('admin');

        $data = $this->model("Admin")->getReportInfo($start_date,$end_date,$filter_by);
        $this->view('admin/reports/salesreport',$data);
    }
    public function salesCompany(){
        $this->AuthorizeUser('company');
        $company_details = $this->model('Company')->getCompanyImage($_SESSION['user_id']);
        $row = mysqli_fetch_assoc($company_details);
        
        //$conn = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
        $data=[];
        $data['companyName'] = $row['name'];
        $data['companyID']=$row['company_id'];
        $distID = $_POST["distID"];
        $from = $_POST["from"];
        $to = $_POST["to"];
        $tableArr = $_POST["tableArr"];
        $arr=json_decode($tableArr,true);
        $data['distID']=$distID;
        $data['from']=$from;
        $data['to']=$to;
        $data['tableArr']=$arr;
        $distname=$this->model('Company')->getDistributorName($distID);
        $distributor='';
        foreach($distname as $key=>$value){
            $distributor= $value;
        };
        //$data['distname']=$distributor;
        $data['distname']=$distributor['name'] ;

        $res =$this->view('company/reports/salesreport',$data);
        //echo $res;
    }
    public function companySale(){
        $this->AuthorizeUser('company');
        $company_details = $this->model('Company')->getCompanyImage($_SESSION['user_id']);
        $row = mysqli_fetch_assoc($company_details);
        $data=[];
        $orderID= $_POST["orderID"];
        $distID = $_POST["distID"];
        $placedDate = $_POST["placedDate"];
        $placedTime = $_POST["placedTime"];
        $tableArr = $_POST["tableArr"];
        $data['companyName'] = $row['name'];
        $data['companyID']=$row['company_id'];
        $arr=json_decode($tableArr,true);
        $data['orderID']=$orderID;
        $data['distID']=$distID;
        $data['placedDate']=$placedDate;
        $data['placedTime']=$placedTime;
        $data['tableArr']=$arr;
        //echo json_encode($data);
        $this->view('company/reports/purchaseorder',$data);
    }
    public function deliveryPersonDeliveries(){
        $this->AuthorizeUser('delivery');
        $deliveryid = $_SESSION['user_id'];
        //$conn = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
        $data=[];
        $from = $_POST["from"];
        $to = $_POST["to"];
        $revenue=$_POST['revenue'];
        $tableArr = $_POST["tableArr"];
        $arr=json_decode($tableArr,true);
        $data['from']=$from;
        $data['to']=$to;
        $data['revenue']=$revenue;
        $data['tableArr']=$arr;
        $deliverydetails=$this->model('Delivery')->getDeliveryImage($deliveryid);
        $row = mysqli_fetch_assoc($deliverydetails);
        $data['name']=$row['first_name'].' '.$row['last_name'];
        $distributor='';
        //$data['distname']=$distributor;
        //$data['distname']=$distributor['name'] ;
        //echo json_encode($data);
        $res =$this->view('delivery/reports/salesreport',$data);
    }

}


?>