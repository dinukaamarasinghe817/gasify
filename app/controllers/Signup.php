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

            $company_id = 1; // company_id should be taken from session
            // prduct breakdown
            $productresult = $this->model("Products")->getProducts($company_id);
            $data['productresult'] = $productresult;

            // distributors breakdown
            $distributorresult = $this->model('Company')->getDistributors($company_id);
            $data['distributorresult'] = $distributorresult;

            // if any errors to be printed
            $data['error'] = $error;
            if($error != null){
                switch($error){
                    case '1':
                        $data['error'] = 'fill all the fields';
                        break;
                    case '2':
                        $data['error'] = 'Invalid email';
                        break;
                    case '3':
                        $data['error'] = 'Email already exists';
                        break;
                    case '4':
                        $data['error'] = 'Passwords do not match';
                        break;
                    case '5':
                        $data['error'] = 'password should at least 8 characters long and include atleast one uppercase, lowercase, number and a special character';
                        break;
                    case '6':
                        $data['error'] = 'Select a distributor';
                        break;
                    case '7':
                        $data['error'] = 'Invalid capacity';
                        break;
                    case '8':
                        $data['error'] = 'Select a distributor';
                        break;
                    case '9':
                        $data['error'] = 'Server Error, please try again';
                        break;
                }
            }
            // load the view with product breakdown, distributor breakdown and error messages
            $this->view('signup/dealer', $data);
        }

        public function dealersignup(){

            // take post inputs
            $data = [];
            $company_id = 1;
            $name = $_POST['name'];
            $email = $_POST['email'];
            if(isset($_POST['city']) ? $city = $_POST['city'] : $city = -1);
            $street = $_POST['street'];
            if(isset($_POST['distributor']) ? $distributor_id = (int)$_POST['distributor'] : $distributor_id = -1);
            $contact_no = $_POST['contactno'];
            $acc_no = $_POST['acc_no'];
            $password = $_POST['password'];
            $confirmpassword = $_POST['confirmpassword'];

            // capacity should be taken as product breakdown
            $capacity = array();
            $isvalidqty = false;
            $result = $this->model("Products")->getProducts($company_id);
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
            $hashed_pwd = password_hash($password,PASSWORD_DEFAULT);

            $query2 = $this->model('Dealer')->getDealer($email);
            echo var_dump($query2);
            if(mysqli_num_rows($query2) > 0){
                $row = mysqli_fetch_assoc($query2);
                $dealer_id = $row['dealer_id'];
            }else{
                $dealer_id = NULL;
            }
            
            // check all fields are filled or not
            if(isEmpty(array($name, $email, $password, $confirmpassword, $city, $street, $distributor_id, $contact_no, $acc_no))){
                $data['error'] = '1';
            }

            //check validity of email
            else if(isNotValidEmail($email)){
                $data['error'] = '2';
            }

            //check if user already exists
            else if($dealer_id != NULL){
                $data['error'] = "3";
            }
            
            //check if two passwords matching
            else if(isNotConfirmedpwd($password, $confirmpassword)){
                $data['error'] = "4";
            }
            
            //check the password strength is enough
            else if(isPasswordNotStrength($password)){
                $data['error'] = "5";
            }
            
            //check if distributor assigned
            else if($city == -1){
                $data['error'] = "6";
            }
            
            else if(!$isvalidqty){
                $data['error'] = "7";
            }
            
            //check if distributor assigned
            else if($distributor_id == -1){
                $data['error'] = "8";
            }

            //redirect if any error occured
            if(isset($data['error'])){
                $error = $data['error'];
                header("Location: ./dealer/$error");
                return;
            }

            // optional image uploaded
            if(isset($_FILES['image']['size']) && $_FILES['image']['size'] > 0){ 
                $image_name = $_FILES['image']['name'];
                $tmp_name = $_FILES['image']['tmp_name'];

                // image type validity jpg png jpeg
                if(isNotValidImageFormat($image_name)){
                    $data['error'] = "invalid image type";
                    exit();
                }

                $image = getImageRename($image_name,$tmp_name);
                $path = getcwd().DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPERATOR.'profile'.DIRECTORY_SEPARATOR;
                echo $path;
                if(move_uploaded_file($tmp_name, $path.($image))){
                    //add the dealer to database with image
                    $query1 = $this->model('Signin')->addDealer($name, $email, $hashed_pwd, $city, $street, $contact_no, $acc_no, $image, $company_id, $distributor_id);
                    //get dealer_id of newly inserted dealer
                    $query2 = $this->model('Dealer')->getDealer($email);
                    $row = mysqli_fetch_assoc($query2);
                    $dealer_id = $row['dealer_id'];
                    //$query3;

                    // set the capacity of the dealer
                    for($i = 0; $i<count($capacity); $i++){
                        $product = $capacity[$i][0];
                        $qty = $capacity[$i][1];
                        $query3 = $this->model('Dealer')->setCapacity($dealer_id, $company_id, $product, $qty);
                    }
                    
                    // if successfully registred and set capacity
                    if($query1 && $query3){
                        $_SESSION['user_id'] = $dealer_id;
                        $_SESSION['role'] = 'dealer';
                        $data['error'] = "success";
                    }else{
                        $error = '9';
                        header("Location: ./dealer/$error");
                    }

                }
            }else{

                // add the dealer to the database without image
                $query1 = $this->model('Signin')->addDealer($name, $email, $hashed_pwd, $city, $street, $contact_no, $acc_no, NULL, $company_id, $distributor_id);
                // get the dealer_id from the database
                echo $email;
                $query2 = $this->model('Dealer')->getDealer($email);
                $row = mysqli_fetch_assoc($query2);
                $dealer_id = $row['dealer_id'];
                echo $dealer_id;
                //$query3;
                
                // set the capacity
                for($i = 0; $i<count($capacity); $i++){
                    $product = $capacity[$i][0];
                    $qty = $capacity[$i][1];
                    // $sql = "INSERT INTO dealer_capacity (dealer_id, company_id, product_id, capacity) VALUES ($dealer_id,1,$product,$qty)";
                    $query3 = $this->model('Dealer')->setCapacity($dealer_id, $company_id, $product, $qty);
                }

                if($query1 && $query3){
                    $_SESSION['user_id'] = $dealer_id;
                    $_SESSION['role'] = 'dealer';
                    $data['error'] = "success";
                }else{
                    $error = "9";
                    header("Location: ./dealer/$error");
                }

            }

            // header("Location: ../signin/dealer");
        }
    }
?>