<?php
    session_start();
    class Profile extends Controller{
        public $user_id;
        public function __construct(){
            // $this->AuthorizeLogin();
            $this->user_id = $_SESSION['user_id'];
        }

        public function edit($role,$user_id,$tab,$viewfolder,$viewfile,$toast=null){

            $data = $this->model("User")->getprofile($role,$user_id,$tab,'edit');

            switch($toast){
                case '1':
                    $data['toast'] = ['type'=>'error', 'message'=>"invalid image type"];
                    break;
                case '2':
                    $data['toast'] = ['type'=>'error', 'message'=>"image could not be uploaded!"];
                    break;
                case '3':
                    $data['toast'] = ['type'=>'success', 'message'=>"successfully updated!"];
                    break;
                case '4':
                    $data['toast'] = ['type'=>'error', 'message'=>"couldn't update information!"];
                    break;
                case '5':
                    $data['toast'] = ['type' => 'error', 'message' =>"incorrect password!"];
                    break;
                case '6':
                    $data['toast'] = ['type' => 'error', 'message' =>"your new password can't be the same as you current password!"];
                    break;
                case '7':
                    $data['toast'] = ['type' => 'error', 'message' =>"passwords do not match!"];
                    break;
                case '8':
                    $data['toast'] = ['type' => 'error', 'message' =>"password should at least 8 characters long and include atleast one uppercase, lowercase, number and a special character!"];
                    break;
                case '9':
                    $data['toast'] = ['type' => 'error', 'message' =>"password too old, use a different password!"];
                    break;
                default:
                    break;

            }
            // $this->AuthorizeUser($role);
            
            // var_dump($data);
            $data['tab'] = $tab;
            $model = ""; $func = "";

            // for the profile component at the front end
            $data['mode'] = 'edit';
            $data['user'] = $role;
            
            // for body header details of the accessor
            switch($role){
                case 'dealer':
                    $model = "Dealer";
                    $func = "getDealer";
                    break;
                case 'customer':
                    $model = "Customer";
                    $func = "getCustomerImage";
                    break;
                case 'distributor':
                    $model = "Distributor";
                    $func = "getDistributorImage";
                    break;
                case 'delivery':
                    $model = "Delivery";
                    $func = "getDeliveryImage";
                    break;
                case 'company':
                    $model = "Company";
                    $func = "getCompanyImage";
                    break;
                case 'admin':
                    $model = "Admin";
                    $func = "getAdmin";
                    break;
            }
            $row = mysqli_fetch_assoc($this->model($model)->$func($this->user_id));
            // $data['image'] = $row['image'];
            if(isset($row['image'])){$data['image'] = $row['image'];}
            else if(isset($row['logo'])){$data['image'] = $row['logo'];}
            else{}
            $data['name'] = $row['first_name'].' '.$row['last_name'];
            $data['navigation'] = 'dashboard';
            // if($toast != null){
            //     $data['toast'] = $toast;
            // }
            $this->view($viewfolder.'/'.$viewfile,$data);
        }

        public function update($tab){
            $func = 'update'.$_SESSION['role'];
            $user_id = $_SESSION['user_id'];
            $data = $this->$func($tab);
            header("Location: ".BASEURL."/profile/edit/".$_SESSION['role']."/".$user_id."/".$tab."/".$_SESSION['role']."/profile/".$data['toast']);
            // $this->edit($_SESSION['role'],$_SESSION['user_id'],$tab,$_SESSION['role'],'profile',$data['toast']);
        }

        public function preview($role,$user_id,$tab,$viewfolder,$viewfile){
            $data = $this->model("User")->getprofile($role,$user_id,$tab,'preview');
            $data['tab'] = $tab;
            $model = ""; $func = "";

            // for the profile component at the front end
            $data['mode'] = 'preview';
            $data['user'] = $role;
            
            // for body header details of the accessor
            switch($_SESSION['role']){
                case 'dealer':
                    $model = "Dealer";
                    $func = "getDealer";
                    break;
                case 'customer':
                    $model = "Customer";
                    $func = "getCustomerImage";
                    break;
                case 'distributor':
                    $model = "Distributor";
                    $func = "getDistributorImage";
                    break;
                case 'delivery':
                    $model = "Delivery";
                    $func = "getDeliveryImage";
                    break;
                case 'company':
                    $model = "Company";
                    $func = "getCompanyImage";
                    break;
                case 'admin':
                    $model = "Admin";
                    $func = "getAdmin";
                    break;
            }
            $row = mysqli_fetch_assoc($this->model($model)->$func($this->user_id));
            // $data['image'] = $row['image'];
            if(isset($row['image'])){$data['image'] = $row['image'];}
            else if(isset($row['logo'])){$data['image'] = $row['logo'];}
            else{}
            $data['name'] = $row['first_name'].' '.$row['last_name'];
            $data['navigation'] = 'dashboard';
            // if($toast != null){
            //     $data['toast'] = $toast;
            // }
            $data['viewfolder'] = $viewfolder;
            $data['viewfile'] = $viewfile;
            $this->view($viewfolder.'/'.$viewfile,$data);
        }

        public function updatedealer($tab){
            $user_id = $_SESSION['user_id'];
            $role = $_SESSION['role'];
            if($tab == 'profile'){
                $data['first_name'] = $_POST['first_name'];
                $data['last_name'] = $_POST['last_name'];
                $data['name'] = $_POST['name'];
                $data['city'] = $_POST['city'];
                $data['street'] = $_POST['street'];
                $data['contact_no'] = $_POST['contact_no'];
                if(isset($_FILES['image']['size']) && $_FILES['image']['size'] > 0){ 
                    $data['image_name'] = $_FILES['image']['name'];
                    $data['tmp_name'] = $_FILES['image']['tmp_name'];
                }
                // echo "controller";
            }else if($tab == 'bank'){
                $data['bank'] = $_POST['bank'];
                $data['account_no'] = $_POST['account_no'];
                $data['merchant_id'] = $_POST['merchant_id'];
            }else if($tab == 'security'){
                $data['current_password'] = $_POST['current_password'];
                $data['new_password'] = $_POST['new_password'];
                $data['confirm_password'] = $_POST['confirm_password'];
            }else if($tab == 'capacity'){
                $data = [];
            }
            $data = $this->model("User")->setprofile($role,$user_id,$tab,$data);
            return $data;
            
        }

        public function updatedistributor($tab){
            $user_id = $_SESSION['user_id'];
            $role = $_SESSION['role'];
            if($tab == 'profile'){
                $data['first_name'] = $_POST['first_name'];
                $data['last_name'] = $_POST['last_name'];
                $data['city'] = $_POST['city'];
                $data['street'] = $_POST['street'];
                $data['contact_no'] = $_POST['contact_no'];
                $data['hold_time'] = $_POST['hold_time'];
                if(isset($_FILES['image']['size']) && $_FILES['image']['size'] > 0){ 
                    $data['image_name'] = $_FILES['image']['name'];
                    $data['tmp_name'] = $_FILES['image']['tmp_name'];
                }
                // echo "controller";
            }else if($tab == 'security'){
                $data['current_password'] = $_POST['current_password'];
                $data['new_password'] = $_POST['new_password'];
                $data['confirm_password'] = $_POST['confirm_password'];
            }else if($tab == 'capacity'){
                $data = [];
            }
            $data = $this->model("User")->setprofile($role,$user_id,$tab,$data);
            return $data;
            
        }

        public function updatecompany($tab){
            $user_id = $_SESSION['user_id'];
            $role = $_SESSION['role'];
            if($tab == 'profile'){
                $data['first_name'] = $_POST['first_name'];
                $data['last_name'] = $_POST['last_name'];
                $data['city'] = $_POST['city'];
                $data['street'] = $_POST['street'];
                $data['company_name'] = $_POST['company_name'];
                if(isset($_FILES['image']['size']) && $_FILES['image']['size'] > 0){ 
                    $data['image_name'] = $_FILES['image']['name'];
                    $data['tmp_name'] = $_FILES['image']['tmp_name'];
                }
                // echo "controller";
            }else if($tab == 'security'){
                $data['current_password'] = $_POST['current_password'];
                $data['new_password'] = $_POST['new_password'];
                $data['confirm_password'] = $_POST['confirm_password'];
            }
            $data = $this->model("User")->setprofile($role,$user_id,$tab,$data);
            return $data;
            
        }

        public function updatedelivery($tab){
            $user_id = $_SESSION['user_id'];
            $role = $_SESSION['role'];
            if($tab == 'profile'){
                $data['first_name'] = $_POST['first_name'];
                $data['last_name'] = $_POST['last_name'];
                $data['city'] = $_POST['city'];
                $data['street'] = $_POST['street'];
                $data['vehicle_type'] = $_POST['vehicle_type'];
                $data['vehicle_no'] = $_POST['vehicle_no'];
                $data['vehicle_no'] = $_POST['vehicle_no'];
                $data['weight_limit'] = $_POST['weight_limit'];
                $data['cost_per_km'] = $_POST['cost_per_km'];
                if(isset($_FILES['image']['size']) && $_FILES['image']['size'] > 0){ 
                    $data['image_name'] = $_FILES['image']['name'];
                    $data['tmp_name'] = $_FILES['image']['tmp_name'];
                }
                // echo "controller";
            }else if($tab == 'security'){
                $data['current_password'] = $_POST['current_password'];
                $data['new_password'] = $_POST['new_password'];
                $data['confirm_password'] = $_POST['confirm_password'];
            }
            $data = $this->model("User")->setprofile($role,$user_id,$tab,$data);
            return $data;
            
        }

        public function updatecustomer($tab){
            $user_id = $_SESSION['user_id'];
            $role = $_SESSION['role'];
            if($tab == 'profile'){
                $data['first_name'] = $_POST['first_name'];
                $data['last_name'] = $_POST['last_name'];
                $data['name'] = $_POST['name'];
                $data['city'] = $_POST['city'];
                $data['street'] = $_POST['street'];
                $data['contact_no'] = $_POST['contact_no'];
                $data['type'] = $_POST['type'];
                if(isset($_FILES['image']['size']) && $_FILES['image']['size'] > 0){ 
                    $data['image_name'] = $_FILES['image']['name'];
                    $data['tmp_name'] = $_FILES['image']['tmp_name'];
                }
            }else if($tab == 'security'){
                $data['current_password'] = $_POST['current_password'];
                $data['new_password'] = $_POST['new_password'];
                $data['confirm_password'] = $_POST['confirm_password'];
            }
            $data = $this->model("User")->setprofile($role,$user_id,$tab,$data);
            return $data;
            
        }
    }
?>