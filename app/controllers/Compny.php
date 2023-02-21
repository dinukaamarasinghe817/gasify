<?php
    session_start();
class Compny extends Controller{
    function __construct(){
        if(isset($_POST['productImage '])){
            echo "done";
            die();
        }
        
    }

    function dealer(){
        $data['navigation'] = 'dealer';
        $company_id=$_SESSION['user_id'];
        $company_details = $this->model('Company')->getCompanyImage($company_id);
        $dealer_details = $this->model('Company')->getRegisteredDealers($company_id);
        $row = mysqli_fetch_assoc($company_details);
        $data['image'] = $row['logo'];
        //$row = mysqli_fetch_assoc($dealer_details);
        $data['dealer']=$dealer_details;
        //$data['cc']=$row['account_no'];
        //echo $data['cc'];
            //$data=[];
        $this->view('dashboard/company', $data);
    }
    function distributor(){
        $data['navigation'] = 'distributor';
        $company_id=$_SESSION['user_id'];
        $company_details = $this->model('Company')->getCompanyImage($company_id);
        $distributor_details = $this->model('Company')->getRegisteredDistributors($company_id);
        $row = mysqli_fetch_assoc($company_details);
        $data['image'] = $row['logo'];
        $data['distributor']=$distributor_details;
        $this->view('dashboard/company', $data);
    }function products(){
        $data['navigation'] = 'products';
        $company_id=$_SESSION['user_id'];
        $company_details = $this->model('Company')->getCompanyImage($company_id);
        $product_details = $this->model('Company')->getProductDetails($company_id);
        $data['products']=$product_details;
        $row = mysqli_fetch_assoc($company_details);
        $data['image'] = $row['logo'];
            //$data=[];
        $this->view('dashboard/company', $data);
    }function regproducts(){
        $data['navigation'] = 'regproducts';
        $company_id=$_SESSION['user_id'];
        $company_details = $this->model('Company')->getCompanyImage($company_id);
        $row = mysqli_fetch_assoc($company_details);
        $data['image'] = $row['logo'];
            //$data=[];
        $this->view('dashboard/company', $data);
    }function regDealer(){
        $data['navigation'] = 'regDealer';
        $company_id=$_SESSION['user_id'];
        $company_details = $this->model('Company')->getCompanyImage($company_id);
        //$product_details = $this->model('Company')->getProductDetails($company_id);
        //$data['products']=$product_details;
        $row = mysqli_fetch_assoc($company_details);
        $data['image'] = $row['logo'];
        $this->view('dashboard/company', $data);
    }function regDistributor(){
        $data['navigation'] = 'regDistributor';
        $company_id=$_SESSION['user_id'];
        $company_details = $this->model('Company')->getCompanyImage($company_id);
        //$product_details = $this->model('Company')->getProductDetails($company_id);
        //$data['products']=$product_details;
        $row = mysqli_fetch_assoc($company_details);
        $data['image'] = $row['logo'];
        $this->view('dashboard/company', $data);
    }function updateProducts(){
        $data['navigation'] = 'updateProducts';
        $company_id=$_SESSION['user_id'];
        $company_details = $this->model('Company')->getCompanyImage($company_id);
        $product_details = $this->model('Company')->getProductDetails($company_id);
        //print_r($product_details);
        $data['products']=$product_details;
        $row = mysqli_fetch_assoc($company_details);
        $data['image'] = $row['logo'];
        $this->view('dashboard/company', $data);
    }
    function registerProducts(){
        $lastUpdatedDate = date("Y-m-d");
        $img_name = $_FILES['productImage']['name'];
        $time=time();
        $img_name = $time.$img_name;
        move_uploaded_file($_FILES['productImage']['tmp_name'],$_SERVER["DOCUMENT_ROOT"]."/mvc/public/img/products/".$img_name);
        $data=array('company_id'=>$_SESSION['user_id'],'name'=>$_POST['Productname'],'type'=>$_POST['Producttype'],'unit_price'=>$_POST['unitprice'],'weight'=>$_POST['weight'],'image'=>$img_name,'production_time'=>$_POST['productiontime'],'last_updated_date'=>$lastUpdatedDate,'quantity'=>$_POST['quantity']);
        $this->model('Company')->registerNewProduct($data);
        $this->products();
    }
    function registerDealer(){
        $img_name = $_FILES['productImage']['name'];
        $time=time();
        $img_name = $time.$img_name;
        $data=array();
        move_uploaded_file($_FILES['productImage']['tmp_name'],$_SERVER["DOCUMENT_ROOT"]."/mvc/public/img/people/".$img_name);
        if(strpos($_POST['name']," ")!== false){
            
            $data=array('email'=>$_POST['email'],'password'=>$_POST['password'],'first_name'=>explode(" ",$_POST['name'])[0],'last_name'=>explode(" ",$_POST['name'])[1],'verification_code'=>'testcode','verification_state'=>'verified');
            $this->model('Company')->registerUser($data);
            //print_r($_POST['distributor_id']);
            $dealer_id=$this->model('Company')->getDealerID('distributor1@gasify.com');
            //$data=array('email'=>$_POST['email'],'password'=>$_POST['password'],'first_name'=>explode(" ",$_POST['name'])[0],'last_name'=>explode(" ",$_POST['name'])[1],'verification_code'=>'testcode','verification_state'=>'verified');
            $data=array('dealer_id'=>$dealer_id,'name'=>$_POST['name'],'city'=>$_POST['city'],'street'=>$_POST['street'],'company_id'=>$_SESSION['user_id'],'distributor_id'=>$_POST['distributor_id'],'bank'=>$_POST['bank'],'account_no'=>$_POST['bank_acc'],'merchant_id'=>(int)(strval($_SESSION['user_id']).$_POST['distributor_id'].strval($dealer_id)),'contact_no'=>$_POST['cno'],'image'=>$img_name);
            $this->model('Company')->registerNewDealer($data);
            //echo $data;
        }else{
            $data=array('email'=>$_POST['email'],'password'=>$_POST['password'],'first_name'=>$_POST['name'],'verification_code'=>'testcode','verification_state'=>'verified');
            $this->model('Company')->registerUser($data);
            $dealer_id=$this->model('Company')->getDealerID('distributor1@gasify.com');
            $data=array('dealer_id'=>$dealer_id,'name'=>$_POST['name'],'city'=>$_POST['city'],'street'=>$_POST['street'],'company_id'=>$_SESSION['user_id'],'distributor_id'=>$_POST['distributor_id'],'bank'=>$_POST['bank'],'account_no'=>$_POST['bank_acc'],'merchant_id'=>(int)(strval($_SESSION['user_id']).$_POST['distributor_id'].strval($dealer_id)),'contact_no'=>$_POST['cno'],'image'=>$img_name);
            $this->model('Company')->registerNewDealer($data);
            //print_r ($data);
            
            //print_r($_POST['distributor_id']);
        }
        $this->dealer();
        
        //move_uploaded_file($_FILES['productImage']['tmp_name'],$_SERVER["DOCUMENT_ROOT"]."/mvc/public/img/products/".$img_name);
        //$data=array('company_id'=>$_SESSION['user_id'],'name'=>$_POST['Productname'],'type'=>$_POST['Producttype'],'unit_price'=>$_POST['unitprice'],'weight'=>$_POST['weight'],'image'=>$img_name,'production_time'=>$_POST['productiontime'],'last_updated_date'=>$lastUpdatedDate,'quantity'=>$_POST['quantity']);
        //$data2=array('email'=>$_POST['quantity'],'password'=>$_POST['quantity'],'first_name'=>$_POST['quantity'],'last_name'=>$_POST['quantity'],'type'=>"dealer");
        //$this->model('Company')->registerNewProduct($data);
    }
    function registerDistributor(){
        $img_name = $_FILES['productImage']['name'];
        $time=time();
        $img_name = $time.$img_name;
        $data=array();
        move_uploaded_file($_FILES['productImage']['tmp_name'],$_SERVER["DOCUMENT_ROOT"]."/mvc/public/img/people/".$img_name);
        if(strpos($_POST['name']," ")!== false){
            
            $data=array('email'=>$_POST['email'],'password'=>$_POST['password'],'first_name'=>explode(" ",$_POST['name'])[0],'last_name'=>explode(" ",$_POST['name'])[1],'verification_code'=>'testcode','verification_state'=>'verified');
            $this->model('Company')->registerUser($data);
            //print_r($_POST['distributor_id']);
            $distributor_details=$this->model('Company')->getDealerID($_POST['email']);
            //$data=array('email'=>$_POST['email'],'password'=>$_POST['password'],'first_name'=>explode(" ",$_POST['name'])[0],'last_name'=>explode(" ",$_POST['name'])[1],'verification_code'=>'testcode','verification_state'=>'verified');
            $data=array('distributor_id'=>$distributor_details,'contact_no'=>$_POST['cno'],'company_id'=>$_SESSION['user_id'],'hold_time'=>0,'city'=>$_POST['city'],'street'=>$_POST['street'],'image'=>$img_name);
            $this->model('Company')->registerNewDistributor($data);
            //echo $data;
        }else{
            $data=array('email'=>$_POST['email'],'password'=>$_POST['password'],'first_name'=>$_POST['name'],'verification_code'=>'testcode','verification_state'=>'verified');
            $this->model('Company')->registerUser($data);
            $distributor_details=$this->model('Company')->getDealerID($_POST['email']);
            $data=array('distributor_id'=>$distributor_details,'contact_no'=>$_POST['cno'],'company_id'=>$_SESSION['user_id'],'hold_time'=>0,'city'=>$_POST['city'],'street'=>$_POST['street'],'image'=>$img_name);
            $this->model('Company')->registerNewDistributor($data);
            //print_r ($data);
            
            //print_r($_POST['distributor_id']);
        }
        $this->distributor();
    }
    function updateProduct(){
        $lastUpdatedDate = date("Y-m-d");
        $img_name="";
        if(!($_FILES['productImage']['size'] == 0)){
            $img_name = $_FILES['productImage']['name'];
            $time=time();
            $img_name = $time.$img_name;
            move_uploaded_file($_FILES['productImage']['tmp_name'],$_SERVER["DOCUMENT_ROOT"]."/mvc/public/img/products/".$img_name);
            $data=array('image'=>$img_name);
            $this->model('Company')->updateProduct($data,$_POST['Producttype'],$_SESSION['user_id']);
        
        
        }
        if((isset($_POST['Productname']) && $_POST['Productname'] != "")){
            $data=array('unit_price'=>$_POST['Productname']);
            $this->model('Company')->updateProduct($data,$_POST['Producttype'],$_SESSION['user_id']);
        }
        if((isset($_POST['productiontime']) && $_POST['productiontime'] != "")){
            $data=array('production_time'=>$_POST['productiontime']);
            $this->model('Company')->updateProduct($data,$_POST['Producttype'],$_SESSION['user_id']);
        }
        if((isset($_POST['quantity']) && $_POST['quantity'] != "")){
            $data=array('quantity'=>$_POST['quantity']);
            $this->model('Company')->updateProduct($data,$_POST['Producttype'],$_SESSION['user_id']);
        }

        $this->products();

    }
    function orders(){
        $data['navigation'] = 'orders';
        $company_id=$_SESSION['user_id'];
        $company_details = $this->model('Company')->getCompanyImage($company_id);
        $dealer_details = $this->model('Company')->getRegisteredDealers($company_id);
        $row = mysqli_fetch_assoc($company_details);
        $data['image'] = $row['logo'];
        //$row = mysqli_fetch_assoc($dealer_details);
        $data['dealer']=$dealer_details;
        //$data['cc']=$row['account_no'];
        //echo $data['cc'];
            //$data=[];
        $this->view('dashboard/company', $data);

    }
    function limitquota(){
        $data['navigation'] = 'limitquota';
        $company_id=$_SESSION['user_id'];
        $company_details = $this->model('Company')->getCompanyImage($company_id);
        $dealer_details = $this->model('Company')->getRegisteredDealers($company_id);
        $product_details = $this->model('Company')->getProductDetails($company_id);
        $row = mysqli_fetch_assoc($company_details);
        $data['image'] = $row['logo'];
        //$row = mysqli_fetch_assoc($dealer_details);
        $data['dealer']=$dealer_details;
        $data['prodducts']=$product_details;
        //$data['cc']=$row['account_no'];
        //echo $data['cc'];
            //$data=[];
        $this->view('dashboard/company', $data);

    }
    function setQuota(){
        $conn = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
        $quota = mysqli_real_escape_string($conn,$_POST["quota"]);
        $customer = mysqli_real_escape_string($conn,$_POST["customer"]);
        $company_id=$_SESSION['user_id'];
        $this->model('Company')->setQuota($company_id,$customer,$quota);
        die();
    }
    function resetQuota(){
        $conn = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
        $customer = mysqli_real_escape_string($conn,$_POST["customer"]);
        $company_id=$_SESSION['user_id'];
        $this->model('Company')->resetQuota($company_id,$customer);
        die();
    }
    function analysis(){
        $data['navigation'] = 'analysis';
        $company_id=$_SESSION['user_id'];
        $company_details = $this->model('Company')->getCompanyImage($company_id);
        $row = mysqli_fetch_assoc($company_details);
        $data['image'] = $row['logo'];
        $this->view('dashboard/company', $data);
    }
    function reports(){
        $data['navigation'] = 'reports';
        $company_id=$_SESSION['user_id'];
        $company_details = $this->model('Company')->getCompanyImage($company_id);
        $row = mysqli_fetch_assoc($company_details);
        $data['image'] = $row['logo'];
        $this->view('dashboard/company', $data);
    }
    public function companyReports(){
        $data['navigation'] = 'reportsCompany';

        $this->view('dashboard/company',$data);
    }

}
?>
