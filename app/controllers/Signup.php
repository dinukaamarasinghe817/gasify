<?php
    session_start();
    if (isset($_SESSION['user_id']) && isset($_SESSION['role'])) {
        $role = $_SESSION['role'];
        header('Location: ' . BASEURL . '/dashboard/'.$role);
    }
    class Signup extends Controller{
        public function __construct(){
            // echo "this is the signin controller";
        }

        public function dealer($error=null){

            $company_id = 2; // company_id should be taken from session
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
            $merchant_id = $_POST['merchant_id'];
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

            // header("Location: ../signin/dealer");
        }

        
    }
?>