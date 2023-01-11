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
        //$product_details = $this->model('Company')->getProductDetails($company_id);
        //$data['products']=$product_details;
        $row = mysqli_fetch_assoc($company_details);
        $data['image'] = $row['logo'];
        $this->view('dashboard/company', $data);
    }
    function registerProducts(){
        $data=array();
        $name=$_POST['Productname'];
        $type=$_POST['Producttype'];
        $price=$_POST['Producttype'];
        $weight=$_POST['weight'];
        $productiontime=$_POST['productiontime'];
        $quantity=$_POST['quantity'];
        $lastUpdatedDate = date("Y-m-d");
        $img_name = $_FILES['productImage']['name'];
        $time=time();
        $img_name = $time.$img_name;
        move_uploaded_file($_FILES['productImage']['tmp_name'],$_SERVER["DOCUMENT_ROOT"]."/mvc/public/img/products/".$img_name);
        array_push($data,['cmp_id'=>$_SESSION['user_id'],'name'=>$_POST['Productname'],'type'=>$_POST['Producttype'],'price'=>$_POST['unitprice'],'weight'=>$_POST['weight'],'img_name'=>$img_name,'productiontime'=>$_POST['productiontime'],'lastUpdatedDate'=>$lastUpdatedDate,'quantity'=>$_POST['quantity']]);
        $this->model('Company')->registerNewProduct($data);
        
        
        //print_r($_SERVER["DOCUMENT_ROOT"]) ;
    }
}
?>
