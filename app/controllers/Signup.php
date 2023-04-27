<?php
    session_start();
    // if (isset($_SESSION['user_id']) && isset($_SESSION['role'])) {
    //     $role = $_SESSION['role'];
    //     header('Location: ' . BASEURL . '/dashboard/'.$role);
    // }
    class Signup extends Controller{

        public function __construct(){
            // echo "this is the signin controller";
        }

        public function user(){
            $this->view('signup/users');
        }

        public function verifyemail($dealer_id,$token){
            if($this->model('User')->verifyemail($dealer_id,$token)){
                header("Location: ".BASEURL."/signin/user/6");
            }else{
                header("Location: ".BASEURL."/signin/user/8");
            }

        }

        public function dealer($error=null){
            $company_id = $_SESSION['user_id']; // company_id should be taken from session
            // prduct breakdown
            $data = $this->model("Dealer")->dealerSignupForm($company_id);

            // if any errors to be printed
            $data['error'] = $error;
            if($error != null){
                switch($error){
                    case '1':
                        $data['toast'] = ['type' => 'error', 'message' =>'fill all the fields'];
                        break;
                    case '2':
                        $data['toast'] = ['type' => 'error', 'message' =>'Invalid email'];
                        break;
                    case '3':
                        $data['toast'] = ['type' => 'error', 'message' =>'Email already exists'];
                        break;
                    case '4':
                        $data['toast'] = ['type' => 'error', 'message' =>'Passwords do not match'];
                        break;
                    case '5':
                        $data['toast'] = ['type' => 'error', 'message' =>'password should at least 8 characters long and include atleast one uppercase, lowercase, number and a special character'];
                        break;
                    case '6':
                        $data['toast'] = ['type' => 'error', 'message' =>'Select a city'];
                        break;
                    case '7':
                        $data['toast'] = ['type' => 'error', 'message' =>'Invalid capacity'];
                        break;
                    case '8':
                        $data['toast'] = ['type' => 'error', 'message' =>'Select a distributor'];
                        break;
                    case '9':
                        $data['toast'] = ['type' => 'error', 'message' =>'Server Error, please try again'];
                        break;
                    case '10':
                        $data['toast'] = ['type' => 'error', 'message' =>'Invalid image type'];
                        break;
                }
            }
            // load the view with product breakdown, distributor breakdown and error messages
            $this->view('signup/dealer', $data);
        }

        public function dealersignup(){

            // take post inputs
            $data = [];
            // $company_id = $_SESSION['user_id']; // user who register a dealer
            $company_id = 2;
            $name = $_POST['name'];
            $first_name = $_POST['fname']; //
            $last_name = $_POST['lname']; //
            $email = $_POST['email'];
            if(isset($_POST['city']) ? $city = $_POST['city'] : $city = -1);
            $street = $_POST['street'];
            if(isset($_POST['distributor']) ? $distributor_id = (int)$_POST['distributor'] : $distributor_id = -1);
            $contact_no = $_POST['contactno'];
            if(isset($_POST['bank']) ? $bank = $_POST['bank'] : $bank = -1);
            $account_no = $_POST['account_no'];
            // $merchant_id = $_POST['merchant_id'];
            $merchant_id = '';
            $password = $_POST['password'];
            $confirmpassword = $_POST['confirmpassword'];
            $image_name = '';$tmp_name = '';
            if(isset($_FILES['image']['size']) && $_FILES['image']['size'] > 0){ 
                $image_name = $_FILES['image']['name'];
                $tmp_name = $_FILES['image']['tmp_name'];
            }
            // capacity should be taken as product breakdown
            $capacity = array();
            $isvalidqty = false;
            $result = $this->model("Dealer")->getProducts($company_id);
            $records = mysqli_num_rows($result);
            for($i = 0; $i < $records; $i++){
                $product = mysqli_fetch_assoc($result); // this is a query
                $product_id = $product['product_id'];
                $qty = $_POST["$product_id"];
                if($qty != 0){
                    $isvalidqty = true;
                }
                $capacity[$i] = array($product['product_id'],$qty);
            }
            
            // password hashing
            $data = $this->model("User")->dealerSignup($name,$first_name,$last_name,$email,
            $city,$street,$company_id,$distributor_id,$contact_no,$bank,$account_no,$merchant_id,
            $password,$confirmpassword,$image_name,$tmp_name,$capacity,$isvalidqty);
            

            if(isset($data['error'])){
                $error = $data['error'];
                header("Location: ".BASEURL."/signup/dealer/$error");
            }else{
                header("Location: ".BASEURL."/signin/user");
            }

            
        }


        public function customer($error=null){
            // if any errors to be printed
            $data['error'] = $error;
            if($error != null){
                switch($error){
                    case '1':
                        $data['toast'] = ['type' => 'error', 'message' =>'fill all the fields'];
                        break;
                    case '2':
                        $data['toast'] = ['type' => 'error', 'message' =>'Invalid email'];
                        break;
                    case '3':
                        $data['toast'] = ['type' => 'error', 'message' =>'Email already exists'];
                        break;
                    case '4':
                        $data['toast'] = ['type' => 'error', 'message' =>'Passwords do not match'];
                        break;
                    case '5':
                        $data['toast'] = ['type' => 'error', 'message' =>'password should at least 8 characters long and include atleast one uppercase, lowercase, number and a special character'];
                        break;
                    case '6':
                        $data['toast'] = ['type' => 'error', 'message' =>'Select a city'];
                        break;
                    case '7':
                        $data['toast'] = ['type' => 'error', 'message' =>'Select customer type'];
                        break;
                    case '8':
                        $data['toast'] = ['type' => 'error', 'message' =>'Server Error, please try again'];
                        break;
                    case '9':
                        $data['toast'] = ['type' => 'error', 'message' =>'Invalid image type'];
                        break;
                    case '10':
                        $data['toast'] = ['type' => 'error', 'message' =>'Invalid ebill number'];
                        break;
                    case '11':
                        $data['toast'] = ['type' => 'error', 'message' =>'Ebill number already exists'];
                        break;
                }
            }
            // load the view with error messages
            $this->view('signup/customer', $data);
        }


        public function customersignup(){

            // take post inputs
            $data = [];
            $first_name = $_POST['fname']; 
            $last_name = $_POST['lname']; 
            $email = $_POST['email'];
            if(isset($_POST['city']) ? $city = $_POST['city'] : $city = -1);
            $street = $_POST['street'];
            $contact_no = $_POST['contactno'];
            $ebill_no = $_POST['ebill'];
            if(isset($_POST['cus_type']) ? $type = $_POST['cus_type'] : $type = -1);
            $password = $_POST['password'];
            $confirmpassword = $_POST['confirmpassword'];
            $image_name = '';
            $tmp_name = '';
            if(isset($_FILES['image']['size']) && $_FILES['image']['size'] > 0){ 
                $image_name = $_FILES['image']['name'];
                $tmp_name = $_FILES['image']['tmp_name'];
            }
            
            // password hashing
            $data = $this->model("User")->CustomerSignup($first_name,$last_name,$email,
            $city,$street,$contact_no,$ebill_no,$type,$password,$confirmpassword,$image_name,$tmp_name);
            if(isset($data['error'])){
                $error = $data['error'];
                header("Location: ".BASEURL."/signup/customer/$error");
            }else{
                header("Location: ".BASEURL."/signin/user");
            }

        
        }
        public function company(){
            $this->view('signup/company');
        }
        public function deliveryperson(){
            $this->view('signup/deliveryperson');
        }
        public function companySignUp(){
            $data = [];
            $data['companyname']=$_POST['Companyname'];
            $data['fname'] = $_POST['fname']; 
            $data['lname'] = $_POST['lname']; 
            $data['email'] = $_POST['email'];
            $data['city'] = $_POST['city'];
            $data['street'] = $_POST['street'];
            $data['password'] = $_POST['password'];
            $image_name = '';
            $tmp_name = '';
            /*if(isset($_FILES['image']['size']) && $_FILES['image']['size'] > 0){ 
                $image_name = $_FILES['image']['name'];
                $tmp_name = $_FILES['image']['tmp_name'];
            }*/
            
            // password hashing
            $data = $this->model("User")->CompanySignup($data);
            /*if(isset($data['error'])){
                $error = $data['error'];
                header("Location: ".BASEURL."/signup/customer/$error");
            }else{
                header("Location: ".BASEURL."/signin/user");
            }*/
        }

        public function distributor($error=null) {
            $company_id = $_SESSION['user_id']; // company_id should be taken from session
            // $company_id=2;
            $data = $this->model("Distributor")->distributorSignupForm($company_id);

            $data['error'] = $error;
            if($error != null){
                switch($error){
                    case '1':
                        $data['toast'] = ['type' => 'error', 'message' =>'fill all the fields'];
                        break;
                    case '2':
                        $data['toast'] = ['type' => 'error', 'message' =>'Invalid email'];
                        break;
                    case '3':
                        $data['toast'] = ['type' => 'error', 'message' =>'Email already exists'];
                        break;
                    case '4':
                        $data['toast'] = ['type' => 'error', 'message' =>'Passwords do not match'];
                        break;
                    case '5':
                        $data['toast'] = ['type' => 'error', 'message' =>'password should at least 8 characters long and include atleast one uppercase, lowercase, number and a special character'];
                        break;
                    case '6':
                        $data['toast'] = ['type' => 'error', 'message' =>'Select a city'];
                        break;
                    case '7':
                        $data['toast'] = ['type' => 'error', 'message' =>'Invalid capacity'];
                        break;
                    // case '8':
                    //     $data['toast'] = ['type' => 'error', 'message' =>'Select a distributor'];
                    //     break;
                    case '9':
                        $data['toast'] = ['type' => 'error', 'message' =>'Server Error, please try again'];
                        break;
                    case '10':
                        $data['toast'] = ['type' => 'error', 'message' =>'Invalid image type'];
                        break;
                }
            }
              $this->view('signup/distributor', $data);
        }

        public function distributorsignup() {
            // take post inputs
            $data = [];
            $company_id=2;
            $first_name = $_POST['fname'];
            $last_name = $_POST['lname'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $confirmpassword = $_POST['confirmpassword'];
            $contact = $_POST['contact'];
            if(isset($_POST['city']) ? $city = $_POST['city'] : $city = -1);
            $street = $_POST['street'];
            $image_name = '';$tmp_name = '';
            if(isset($_FILES['image']['size']) && $_FILES['image']['size'] > 0){ 
                $image_name = $_FILES['image']['name'];
                $tmp_name = $_FILES['image']['tmp_name'];
            }

             // capacity should be taken as product breakdown
            $capacity = array();
            $isvalidqty = false;
            $result = $this->model("Distributor")->getProducts($company_id);
            $records = mysqli_num_rows($result);
            for($i = 0; $i < $records; $i++){
                $product = mysqli_fetch_assoc($result); // this is a query
                $product_id = $product['product_id'];
                $qty = $_POST["$product_id"];
                if($qty != 0){
                    $isvalidqty = true;
                }
                $capacity[$i] = array($product['product_id'],$qty);
            }


            // password hashing
            $data = $this->model("User")->distributorSignup($first_name,$last_name,$email,
            $city,$street,$contact,$password,$confirmpassword,$image_name,$tmp_name,
            $capacity,$isvalidqty);


            if(isset($data['error'])) {
                $error = $data['error'];
                header("Location: ".BASEURL."/signup/distributor/$error");
            }else{
                header("Location: ".BASEURL."/signin/user");
            }

        }
        public function DeliverySignup(){
            $data = [];
            $data['fname'] = $_POST['fname']; 
            $data['lname'] = $_POST['lname']; 
            $data['email'] = $_POST['email'];
            $data['cno'] = $_POST['cno'];
            $data['city'] = $_POST['city'];
            $data['street'] = $_POST['street'];
            $data['password'] = $_POST['password'];
            $data['vehicletype'] = $_POST['vehicletype'];
            $data['vno'] = $_POST['vno'];
            $data['weight'] = $_POST['weight'];
            $data['costperkm'] = $_POST['costperkm'];
            $image_name = '';
            $tmp_name = '';
            /*if(isset($_FILES['image']['size']) && $_FILES['image']['size'] > 0){ 
                $image_name = $_FILES['image']['name'];
                $tmp_name = $_FILES['image']['tmp_name'];
            }*/
            
            // password hashing
            $data = $this->model("User")->DeliverySignup($data);
        }



    }
?>