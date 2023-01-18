<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
class User extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getUser($email){
        $result = $this->read('users', "email = '$email'");
        return $result;
    }
    public function resetPassword($email){
        if(empty($email)){
            $data['toast'] = ['type'=>'error', 'message'=>'Email field empty'];
            return $data;
        }
        
        //Import PHPMailer classes into the global namespace
        //These must be at the top of your script, not inside a function
        
        $sql = "SELECT * FROM users WHERE email = '{$email}'";
        $result = $this->Query($sql);
        if(mysqli_num_rows($result) > 0){
            $token = md5(rand());
            $row = mysqli_fetch_assoc($result);
            $sql = "UPDATE users SET verification_code = '{$token}' WHERE email = '{$email}'";
            $result2 = $this->Query($sql);
        
            if($result2){
                $name = $row['first_name'].' '.$row['last_name'];
                $email = $row['email'];
                // sendResetLink($name, $row['email'], $token);
                //Create an instance; passing `true` enables exceptions
                $mail = new PHPMailer(true);
            
                try {
                    //Server settings
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'localhost';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'admin@gasify.com';                     //SMTP username
                    $mail->Password   = '1234567';                               //SMTP password
                    $mail->Port       = 25;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            
                    //Recipients
                    $mail->setFrom('admin@gasify.com', "Gasify (Pvt.Ltd.)");    //Add a recipient
                    $mail->addAddress($email);
                    
                    //message
                    $message = "
                    <h2>Hello $name,</h2>
                    <h3>You are receiving this email because you requested to reset your password.</h3>
                    <br/><br/>
                    <a href='".BASEURL."/signin/passwordverify/$token/$email'>Click Here</a>
                    ";
                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Gasify: Reset Password';
                    $mail->Body    = $message;
            
                    $result = $mail->send();
                    $data['toast'] = ['type' => 'success', 'message' => 'Please check your email and reset your password'];
                    return $data;
                } catch (Exception $e) {
                    $data['toast'] = ['type' => 'error', 'message' =>'phpmailer server error'];
                    return $data;
                }
            }else{
                $data['toast'] = ['type' => 'error', 'message' => 'Server error'];
                return $data;
            }
        }
        
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            
        }else{
            $data['toast'] = 'Email does not exist';
            return $data;
        }
        
    }
    function sendResetLink($name,$email,$token){
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);
    
        try {
            //Server settings
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'localhost';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'admin@gasify.com';                     //SMTP username
            $mail->Password   = '1234567';                               //SMTP password
            $mail->Port       = 25;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
            //Recipients
            $mail->setFrom('admin@gasify.com', "Gasify (Pvt.Ltd.)");    //Add a recipient
            $mail->addAddress($email);
            
            //message
            $message = "
            <h2>Hello $name,</h2>
            <h3>You are receiving this email because you requested to reset your password.</h3>
            <br/><br/>
            <a href='http://localhost/gasify/view/Dealer/login_with_link.php?token=$token&email=$email'>Click Here</a>
            ";
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Gasify: Reset Password';
            $mail->Body    = $message;
    
            $result = $mail->send();
        } catch (Exception $e) {
            $data['toast'] = ['type' => 'error', 'message' => "phpmailer server error"];
            return $data;
        }
    }

    public function userSignin($email,$password){
        $data['success'] = false;
        
        if(isEmpty(array($email, $password))){
            $data['error'] = "1";
            return $data;
        }

        $result = $this->read('users', "email = '$email'");
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            if(password_verify($password, $row['password'])){
                if(isset($_SESSION['login_attempt'])){
                    $_SESSION['login_attempt'] = 0;
                }
                $user_id = $row['user_id'];
                $_SESSION['user_id'] = "$user_id";
                $_SESSION['role'] = $row['type'];
                $data['success'] = true;
            }else{
                if(!isset($_SESSION['login_attempt'])){
                    $_SESSION['login_attempt'] = 0;
                }
                $_SESSION['login_attempt'] += 1;
                if($_SESSION['login_attempt'] > 5){
                    $data['error'] = "2";
                }else{
                    $data['error'] = "3";
                }
            }
        }else{
            $data['error'] = "4";
        }
        return $data;
    }

    public function dealerSignup($name,$first_name,$last_name,$email,
    $city,$street,$company_id,$distributor_id,$contact_no,$bank,$account_no,$merchant_id,
    $password,$confirmpassword,$image_name,$tmp_name,$capacity,$isvalidqty){
        $data = [];
        $hashed_pwd = password_hash($password,PASSWORD_DEFAULT);
        $query2 = $this->read('users', "email = '$email'");
        if(mysqli_num_rows($query2) > 0){
            $row = mysqli_fetch_assoc($query2);
            $dealer_id = $row['user_id'];
        }else{
            $dealer_id = NULL;
        }
        
        // check all fields are filled or not
        if(isEmpty(array($name,$first_name,$last_name,$email,
        $city,$street,$company_id,$distributor_id,$contact_no,$bank,$account_no,$merchant_id,
        $password,$confirmpassword,$isvalidqty))){
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
            return $data;
        }

        // optional image uploaded
        if(!empty($image_name) && !empty($tmp_name)){

            // image type validity jpg png jpeg
            if(isNotValidImageFormat($image_name)){
                $data['error'] = "invalid image type";
                exit();
            }

            $image = getImageRename($image_name,$tmp_name);
            $path = getcwd().DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPERATOR.'profile'.DIRECTORY_SEPARATOR;
            // echo $path;
            if(move_uploaded_file($tmp_name, $path.($image))){
                //add the dealer to database with image
                $query1 = $this->insert('users',['email'=>$email,'password'=>$hashed_pwd,'first_name'=>$first_name,'last_name'=>$last_name,'type'=>'dealer','verification_code'=>'','verification_state'=>'verified']);
                //get dealer_id of newly inserted dealer
                $query2 = $this->read('users', "email = '$email'");
                $row = mysqli_fetch_assoc($query2);
                $dealer_id = $row['user_id'];
                $query1 = $this->insert('dealer', ['dealer_id'=>$dealer_id,'name'=> $name, 'city'=> $city, 'street'=> $street, 'company_id'=> $company_id, 'distributor_id'=> $distributor_id, 'bank'=> $bank, 'account_no'=>$account_no, 'merchant_id'=> $merchant_id, 'contact_no'=>$contact_no, 'image'=>$image]);
                $query3;

                // set the capacity of the dealer
                for($i = 0; $i<count($capacity); $i++){
                    $product = $capacity[$i][0];
                    $qty = $capacity[$i][1];
                    $query3 = $this->insert('dealer_capacity',['dealer_id'=> $dealer_id,'product_id'=>$product,'capacity'=>$qty]);
                }
                
                // if successfully registred and set capacity
                if($query1 && $query3){
                    $_SESSION['user_id'] = $dealer_id;
                    $_SESSION['role'] = 'dealer';
                    $data['error'] = "success";
                }else{
                    $data['error'] = "9";
                    return $data;
                }

            }
        }else{

            //add the dealer to database with image
            $query1 = $this->insert('users',['email'=>$email,'password'=>$hashed_pwd,'first_name'=>$first_name,'last_name'=>$last_name,'type'=>'dealer','verification_code'=>'','verification_state'=>'verified']);
            //get dealer_id of newly inserted dealer
            $query2 = $this->read('users', "email = '$email'");
            $row = mysqli_fetch_assoc($query2);
            $dealer_id = $row['user_id'];
            $query1 = $this->insert('dealer', ['dealer_id'=>$dealer_id,'name'=> $name, 'city'=> $city, 'street'=> $street, 'company_id'=> $company_id, 'distributor_id'=> $distributor_id, 'bank'=> $bank, 'account_no'=>$account_no, 'merchant_id'=> $merchant_id, 'contact_no'=>$contact_no]);
            $query3;
            
            // set the capacity
            $data['hel'] = count($capacity);
            for($i = 0; $i<count($capacity); $i++){
                $product = $capacity[$i][0];
                $qty = $capacity[$i][1];
                // $sql = "INSERT INTO dealer_capacity (dealer_id, company_id, product_id, capacity) VALUES ($dealer_id,1,$product,$qty)";
                $query3 = $this->insert('dealer_capacity',['dealer_id'=> $dealer_id,'product_id'=>$product,'capacity'=>$qty]);
            }

            if($query1 && $query3){
                $_SESSION['user_id'] = $dealer_id;
                $_SESSION['role'] = 'dealer';
                // $data['error'] = "success";
            }else{
                $data['error'] = "9";
                return $data;
            }

        }
    }

    public function isUserExist($email){
        $result = $this->getUser($email);
        if(mysqli_num_rows($result) > 0){
            return true;
        }else{
            return false;
        }
    }

    public function isAnOldPassword($email, $password){
        $result = $this->read('users',"email = '$email'");
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            $user_id = $row['user_id'];
            $result = $this->read('old_passwords',"user_id = $user_id");
            $flag = false;
            while($row = mysqli_fetch_assoc($result)){
                if(password_verify($password, $row['old_password'])){
                    $flag = true;
                }
            }
            return $flag;
        }
        return false;
    }

    public function isCurrentPassword($email, $password){
        $result = $this->read('users',"email = '$email'");
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            if(password_verify($password, $row['password'])){
                return true;
            }
        }
        return false;
    }

    public function passwordverify($password,$confirmpassword,$token,$email){
        // password hashing
        $hashed_pwd = password_hash($password,PASSWORD_DEFAULT);
        $data = [];
        // check all fields are filled or not
        if(isEmpty(array($password, $confirmpassword))){
            $data['toast'] = ['type'=>'error', 'message'=>"fill all the fields"];

        }else if(empty($email)){
            $data['toast'] = ['type'=>'error', 'message'=>"email is empty"];

        }else if(empty($token)){
            $data['toast'] = ['type'=>'error', 'message'=>"verification token is empty"];

        }else if(isNotValidEmail($email)){
            $data['toast'] = ['type'=>'error', 'message'=>"Invalid email"];

        }else if(!($this->isUserExist($email))){
            $data['toast'] = ['type'=>'error', 'message'=>"Email does not exists"];

        }else if(isNotConfirmedpwd($password, $confirmpassword)){
            $data['toast'] = ['type'=>'error', 'message'=>"Passwords do not match"];

        }else if($this->isAnOldPassword($email, $password)){
            $data['toast'] = ['type'=>'error', 'message'=>"Your password is too old, try a different one"];

        }else if($this->isCurrentPassword($email, $password)){
            $data['toast'] = ['type'=>'error', 'message'=>"Your new password can't be the same as your current one"];

        }else if(isPasswordNotStrength($password)){
            $data['toast'] = ['type'=>'error', 'message'=>"password should at least 8 characters long and include atleast one uppercase, lowercase, number and a special character"];

        }

        if(isset($data['toast'])){
            return $data;
        }

        $sql = "SELECT verification_code FROM users WHERE email = '{$email}' LIMIT 1";
        $query = $this->Query($sql);
        if(mysqli_num_rows($query)>0){
            $row1 = mysqli_fetch_assoc($query);
            if($token == $row1['verification_code']){
                $sql = "SELECT * FROM users WHERE email = '{$email}' LIMIT 1";
                $query = $this->Query($sql);
                if(mysqli_num_rows($query)>0){
                    $row2 = mysqli_fetch_assoc($query);
                    $user_id = $row2['user_id'];
                    $old_password = $row2['password'];
                    $sql = "INSERT INTO old_passwords(user_id, old_password) VALUES('{$user_id}','{$old_password}')";
                    $query = $this->Query($sql);
                    if($query){
                        $sql = "UPDATE users SET password = '$hashed_pwd' WHERE email = '$email' LIMIT 1";
                        $query = $this->Query($sql);
                        if($query){
                            if(isset($_SESSION['unique_id'])){
                                unset($_SESSION['unique_id']);
                            }
                            if(isset($_SESSION['role'])){
                                unset($_SESSION['role']);
                            }
                            $data['toast'] = ['type'=>'success', 'message'=>"You've successfully update your password"];
                            return $data;
                        }else{
                            $data['toast'] = ['type'=>'error', 'message'=>"server Error! try again!"];
                            return $data;
                        }
                    }
                }

            }else{
                $data['toast'] = ['type'=>'error', 'message'=>"Invalid token passed"];
                return $data;
            }
        }
    }

}
?>