<?php
    session_start();
class Compny extends Controller{
    function __construct(){
        
    }

    function dealer(){
        $data['navigation'] = 'dealer';
        $company_id=$_SESSION['user_id'];
        $company_details = $this->model('Company')->getCompanyImage($company_id);
        $row = mysqli_fetch_assoc($company_details);
        $data['image'] = $row['logo'];
            //$data=[];
        $this->view('dashboard/company', $data);
    }
    function distributor(){
        $data['navigation'] = 'distributor';
        $company_id=$_SESSION['user_id'];
        $company_details = $this->model('Company')->getCompanyImage($company_id);
        $row = mysqli_fetch_assoc($company_details);
        $data['image'] = $row['logo'];
            //$data=[];
        $this->view('dashboard/company', $data);
    }function products(){
        $data['navigation'] = 'products';
        $company_id=$_SESSION['user_id'];
        $company_details = $this->model('Company')->getCompanyImage($company_id);
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
    }
}
?>