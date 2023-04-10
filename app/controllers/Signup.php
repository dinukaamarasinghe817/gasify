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
            // if(isset($data['error'])){
            //     $error = $data['error'];
            //     header("Location: ".BASEURL."/signup/dealer/$error");
            //     return;
            // }

            // optional image uploaded
            // if(isset($_FILES['image']['size']) && $_FILES['image']['size'] > 0){ 
            //     $image_name = $_FILES['image']['name'];
            //     $tmp_name = $_FILES['image']['tmp_name'];

            //     // image type validity jpg png jpeg
            //     if(isNotValidImageFormat($image_name)){
            //         $error = 10;
            //         header("Location: ./dealer/$error");
            //         return;
            //     }

            //     $image = getImageRename($image_name,$tmp_name);
            //     $path = getcwd().DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPERATOR.'profile'.DIRECTORY_SEPARATOR;
            //     echo $path;
            //     if(move_uploaded_file($tmp_name, $path.($image))){
            //         //add the dealer to database with image
            //         $query1 = $this->model('Signin')->addDealer($name, $email, $hashed_pwd, $city, $street, $contact_no, $acc_no, $image, $company_id, $distributor_id);
            //         //get dealer_id of newly inserted dealer
            //         $query2 = $this->model('Dealer')->getDealer($email);
            //         $row = mysqli_fetch_assoc($query2);
            //         $dealer_id = $row['dealer_id'];
            //         //$query3;

            //         // set the capacity of the dealer
            //         for($i = 0; $i<count($capacity); $i++){
            //             $product = $capacity[$i][0];
            //             $qty = $capacity[$i][1];
            //             $query3 = $this->model('Dealer')->setCapacity($dealer_id, $company_id, $product, $qty);
            //         }
                    
            //         // if successfully registred and set capacity
            //         if($query1 && $query3){
            //             $_SESSION['user_id'] = $dealer_id;
            //             $_SESSION['role'] = 'dealer';
            //             $data['error'] = "success";
            //         }else{
            //             $error = '9';
            //             header("Location: ./dealer/$error");
            //         }

            //     }
            // }else{

            //     // add the dealer to the database without image
            //     $query1 = $this->model('Signin')->addDealer($name, $email, $hashed_pwd, $city, $street, $contact_no, $acc_no, NULL, $company_id, $distributor_id);
            //     // get the dealer_id from the database
            //     echo $email;
            //     $query2 = $this->model('Dealer')->getDealer($email);
            //     $row = mysqli_fetch_assoc($query2);
            //     $dealer_id = $row['dealer_id'];
            //     echo $dealer_id;
            //     //$query3;
                
            //     // set the capacity
            //     for($i = 0; $i<count($capacity); $i++){
            //         $product = $capacity[$i][0];
            //         $qty = $capacity[$i][1];
            //         // $sql = "INSERT INTO dealer_capacity (dealer_id, company_id, product_id, capacity) VALUES ($dealer_id,1,$product,$qty)";
            //         $query3 = $this->model('Dealer')->setCapacity($dealer_id, $company_id, $product, $qty);
            //     }

            //     if($query1 && $query3){
            //         $_SESSION['user_id'] = $dealer_id;
            //         $_SESSION['role'] = 'dealer';
            //         $data['error'] = "success";
            //     }else{
            //         $error = "9";
            //         header("Location: ./dealer/$error");
            //     }
            // }

            if(isset($data['error'])){
                $error = $data['error'];
                header("Location: ".BASEURL."/signup/dealer/$error");
            }else{
                header("Location: ".BASEURL."/signin/user");
            }

            // header("Location: ../signin/dealer");
        

        // public function companysignup(){
        // }
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



    }
?>