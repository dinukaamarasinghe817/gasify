<?php
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\Exception;
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
                $reciepName = $row['first_name'].' '.$row['last_name'];
                $from = 'admin@gasify.com';
                $to = $row['email'];
                $subject = 'Gasify: Reset Password';
                $message = 'You are receiving this email because you requested to reset your password.';
                $link = BASEURL."/signin/passwordverify/$token/$email";
                // sendResetLink($name, $row['email'], $token);
                //Create an instance; passing `true` enables exceptions
                $mail = new Mail($from,$to,$reciepName,$subject,$message,$link);
                $data = $mail->send();
                return $data;
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
    // function sendResetLink($name,$email,$token){
    //     //Create an instance; passing `true` enables exceptions
    //     $mail = new PHPMailer(true);
    
    //     try {
    //         //Server settings
    //         $mail->isSMTP();                                            //Send using SMTP
    //         $mail->Host       = 'localhost';                     //Set the SMTP server to send through
    //         $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    //         $mail->Username   = 'admin@gasify.com';                     //SMTP username
    //         $mail->Password   = '1234567';                               //SMTP password
    //         $mail->Port       = 25;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
    //         //Recipients
    //         $mail->setFrom('admin@gasify.com', "Gasify (Pvt.Ltd.)");    //Add a recipient
    //         $mail->addAddress($email);
            
    //         //message
    //         $message = "
    //         <h2>Hello $name,</h2>
    //         <h3>You are receiving this email because you requested to reset your password.</h3>
    //         <br/><br/>
    //         <a href='http://localhost/gasify/view/Dealer/login_with_link.php?token=$token&email=$email'>Click Here</a>
    //         ";
    //         //Content
    //         $mail->isHTML(true);                                  //Set email format to HTML
    //         $mail->Subject = 'Gasify: Reset Password';
    //         $mail->Body    = $message;
    
    //         $result = $mail->send();
    //     } catch (Exception $e) {
    //         $data['toast'] = ['type' => 'error', 'message' => "phpmailer server error"];
    //         return $data;
    //     }
    // }

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

    public function getprofile($role,$user_id,$tab,$mode){
        // role is the type of user
        // tab is which tab we want
        // mode is either 'preview' or 'edit'
        $func = 'get'.$role.'profile';
        return $this->$func($user_id,$tab,$mode);
    }

    public function setprofile($role,$user_id,$tab,$data){
        $func = 'set'.$role.'profile';
        return $this->$func($user_id,$tab,$data);
    }

    public function setdealerprofile($user_id,$tab,$data){
        if($tab == 'profile'){
            $result1 = $this->update('users',array('first_name'=>$data['first_name'],'last_name'=>$data['last_name']),"user_id = $user_id");
            // image type validity jpg png jpeg
            if(isset($data['image_name']) && isNotValidImageFormat($data['image_name'])){
                $data['toast'] = '1';
                return $data;
            }

            if(isset($data['image_name'])){
                $data['image'] = getImageRename($data['image_name'],$data['tmp_name']);
                $path = getcwd().DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPERATOR.'profile'.DIRECTORY_SEPARATOR;
                echo $data['image']."\n";
                if(move_uploaded_file($data['tmp_name'], $path.($data['image']))){
                    echo "image uploaded\n";
                    $result2 = $this->update('dealer',array('name'=>$data['name'],'city'=>$data['city'],'street'=>$data['street'],'contact_no'=>$data['contact_no'],'image'=>$data['image']),"dealer_id = $user_id");
                    // echo "hello\n";
                }else{
                    $data['toast'] = '2';
                    return $data;
                    // echo "image not uploaded\n";
                }
            }else{
                $result2 = $this->update('dealer',array('name'=>$data['name'],'city'=>$data['city'],'street'=>$data['street'],'contact_no'=>$data['contact_no']),"dealer_id = $user_id");
            }
            if($result1 && $result2){
                $data['toast'] = '3';
            }else{
                $data['toast'] = '4';
            }

        }else if($tab == 'bank'){
            $result = $this->update('dealer',array('bank'=>$data['bank'],'account_no'=>$data['account_no'],'merchant_id'=>$data['merchant_id']),"dealer_id = $user_id");
            if($result){
                $data['toast'] = '3';
            }else{
                $data['toast'] = '4';
            }

        }else if($tab == 'security'){
            $data['toast'] = $this->updatepassword($user_id,$data);

        }else if($tab == 'capacity'){
            $row = mysqli_fetch_assoc($this->read('dealer',"dealer_id = $user_id"));
            $result = $this->read('product',"company_id = ".$row['company_id']);
            $capacity = array();
            while($row = mysqli_fetch_assoc($result)){
                if(isset($_POST[$row['product_id']])){
                    $quantity = $_POST[$row['product_id']];
                    array_push($capacity,['product_id' => $row['product_id'], 'quantity' => $quantity]);
                }
            }
            foreach($capacity as $cap){
                $this->update('dealer_capacity',array('capacity'=>$cap['quantity']),"dealer_id = $user_id AND product_id = ".$cap['product_id']);
            }
            $data['toast'] = '3';
        }
        return $data;
    }

    public function setdistributorprofile($user_id,$tab,$data){
        if($tab == 'profile'){
            $result1 = $this->update('users',array('first_name'=>$data['first_name'],'last_name'=>$data['last_name']),"user_id = $user_id");
            // image type validity jpg png jpeg
            if(isset($data['image_name']) && isNotValidImageFormat($data['image_name'])){
                $data['toast'] = '1';
                return $data;
            }

            if(isset($data['image_name'])){
                $data['image'] = getImageRename($data['image_name'],$data['tmp_name']);
                $path = getcwd().DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPERATOR.'profile'.DIRECTORY_SEPARATOR;
                echo $data['image']."\n";
                if(move_uploaded_file($data['tmp_name'], $path.($data['image']))){
                    // echo "image uploaded\n";
                    $result2 = $this->update('distributor',array('city'=>$data['city'],'street'=>$data['street'],'contact_no'=>$data['contact_no'],'image'=>$data['image'],'hold_time'=>$data['hold_time']),"distributor_id = $user_id");
                    // echo "hello\n";
                }else{
                    $data['toast'] = '2';
                    return $data;
                    // echo "image not uploaded\n";
                }
            }else{
                $result2 = $this->update('distributor',array('city'=>$data['city'],'street'=>$data['street'],'contact_no'=>$data['contact_no'],'hold_time'=>$data['hold_time']),"distributor_id = $user_id");
            }
            if($result1 && $result2){
                $data['toast'] = '3';
            }else{
                $data['toast'] = '4';
            }

        }else if($tab == 'security'){
            $data['toast'] = $this->updatepassword($user_id,$data);

        }else if($tab == 'capacity'){
            $row = mysqli_fetch_assoc($this->read('distributor',"distributor_id = $user_id"));
            $result = $this->read('product',"company_id = ".$row['company_id']);
            $capacity = array();
            while($row = mysqli_fetch_assoc($result)){
                if(isset($_POST[$row['product_id']])){
                    $quantity = $_POST[$row['product_id']];
                    array_push($capacity,['product_id' => $row['product_id'], 'quantity' => $quantity]);
                }
            }
            foreach($capacity as $cap){
                $this->update('distributor_capacity',array('capacity'=>$cap['quantity']),"distributor_id = $user_id AND product_id = ".$cap['product_id']);
            }
            $data['toast'] = '3';
        }
        return $data;
    }

    public function setcompanyprofile($user_id,$tab,$data){
        if($tab == 'profile'){
            $result1 = $this->update('users',array('first_name'=>$data['first_name'],'last_name'=>$data['last_name']),"user_id = $user_id");
            // image type validity jpg png jpeg
            if(isset($data['image_name']) && isNotValidImageFormat($data['image_name'])){
                $data['toast'] = '1';
                return $data;
            }

            if(isset($data['image_name'])){
                $data['image'] = getImageRename($data['image_name'],$data['tmp_name']);
                $path = getcwd().DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPERATOR.'profile'.DIRECTORY_SEPARATOR;
                echo $data['image']."\n";
                if(move_uploaded_file($data['tmp_name'], $path.($data['image']))){
                    // echo "image uploaded\n";
                    $result2 = $this->update('company',array('city'=>$data['city'],'street'=>$data['street'],'logo'=>$data['image'],'name'=>$data['company_name']),"company_id = $user_id");
                    // echo "hello\n";
                }else{
                    $data['toast'] = '2';
                    return $data;
                    // echo "image not uploaded\n";
                }
            }else{
                $result2 = $this->update('company',array('city'=>$data['city'],'street'=>$data['street'],'name'=>$data['company_name']),"company_id = $user_id");
            }
            if($result1 && $result2){
                $data['toast'] = '3';
            }else{
                $data['toast'] = '4';
            }

        }else if($tab == 'security'){
            $data['toast'] = $this->updatepassword($user_id,$data);

        }
        return $data;
    }

    public function setdeliveryprofile($user_id,$tab,$data){
        if($tab == 'profile'){
            $result1 = $this->update('users',array('first_name'=>$data['first_name'],'last_name'=>$data['last_name']),"user_id = $user_id");
            // image type validity jpg png jpeg
            if(isset($data['image_name']) && isNotValidImageFormat($data['image_name'])){
                $data['toast'] = '1';
                return $data;
            }

            if(isset($data['image_name'])){
                $data['image'] = getImageRename($data['image_name'],$data['tmp_name']);
                $path = getcwd().DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPERATOR.'profile'.DIRECTORY_SEPARATOR;
                // echo $data['image']."\n";
                if(move_uploaded_file($data['tmp_name'], $path.($data['image']))){
                    // echo "image uploaded\n";
                    $result2 = $this->update('delivery_person',array('city'=>$data['city'],'street'=>$data['street'],'image'=>$data['image'],'vehicle_type'=>$data['vehicle_type'],'vehicle_no'=>$data['vehicle_no'],'weight_limit'=>$data['weight_limit'],'cost_per_km'=>$data['cost_per_km']),"delivery_id = $user_id");
                    // echo "hello\n";
                }else{
                    $data['toast'] = '2';
                    return $data;
                    // echo "image not uploaded\n";
                }
            }else{
                $result2 = $this->update('delivery_person',array('city'=>$data['city'],'street'=>$data['street'],'vehicle_type'=>$data['vehicle_type'],'vehicle_no'=>$data['vehicle_no'],'weight_limit'=>$data['weight_limit'],'cost_per_km'=>$data['cost_per_km']),"delivery_id = $user_id");
            }
            if($result1 && $result2){
                $data['toast'] = '3';
            }else{
                $data['toast'] = '4';
            }

        }else if($tab == 'security'){
            $data['toast'] = $this->updatepassword($user_id,$data);

        }
        return $data;
    }

    public function setcustomerprofile($user_id,$tab,$data){
        if($tab == 'profile'){
            $result1 = $this->update('users',array('first_name'=>$data['first_name'],'last_name'=>$data['last_name']),"user_id = $user_id");
            // image type validity jpg png jpeg
            if(isset($data['image_name']) && isNotValidImageFormat($data['image_name'])){
                $data['toast'] = '1';
                return $data;
            }

            if(isset($data['image_name'])){
                $data['image'] = getImageRename($data['image_name'],$data['tmp_name']);
                $path = getcwd().DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPERATOR.'profile'.DIRECTORY_SEPARATOR;
                echo $data['image']."\n";
                if(move_uploaded_file($data['tmp_name'], $path.($data['image']))){
                    echo "image uploaded\n";
                    $result2 = $this->update('customer',array('city'=>$data['city'],'street'=>$data['street'],'contact_no'=>$data['contact_no'],'image'=>$data['image'],'type'=>$data['type']),"customer_id = $user_id");
                    // echo "hello\n";
                }else{
                    $data['toast'] = '2';
                    return $data;
                    // echo "image not uploaded\n";
                }
            }else{
                $result2 = $this->update('customer',array('city'=>$data['city'],'street'=>$data['street'],'contact_no'=>$data['contact_no'],'type'=>$data['type']),"customer_id = $user_id");
            }
            if($result1 && $result2){
                $data['toast'] = '3';
            }else{
                $data['toast'] = '4';
            }

        }else if($tab == 'security'){
            $data['toast'] = $this->updatepassword($user_id,$data);

        }
        return $data;
    }

    public function updatepassword($user_id,$data){
        $chashed_password = '';
        // is it current password
        $query = $this->read('users',"user_id = $user_id");
        if(mysqli_num_rows($query) > 0){
            $row = mysqli_fetch_assoc($query);
            $chashed_password = $row['password'];
            if(!password_verify($data['current_password'], $row['password'])){
                return '5';
            }else if(password_verify($data['new_password'], $row['password'])){
                return '6';
            }
        }

        // is it an old password
        $query = $this->read('old_passwords',"user_id = $user_id");
        if(mysqli_num_rows($query) > 0){
            while($row = mysqli_fetch_assoc($query)){
                if(password_verify($data['current_password'], $row['old_password'])){
                    return '9';
                }
            }
        }

        // password confirmed
        if(isNotConfirmedpwd($data['new_password'], $data['confirm_password'])){
            return '7';
        }

        // password strength
        if(isPasswordNotStrength($data['new_password'])){
            return '8';
        }
        $data['new_password'] = password_hash($data['new_password'],PASSWORD_DEFAULT);
        $result1 = $this->insert('old_passwords',array('user_id' => $user_id, 'old_password' => $chashed_password));
        $result2 = $this->update('users',array('password'=>$data['new_password']),"user_id = $user_id");
        if($result1 && $result2){
            return '3';
        }else{
            return '4';
        }
    }

    public function getdealerprofile($user_id,$tab,$mode){
        $data = [];
        if($mode == 'edit'){
            if($tab == 'profile'){
                $sql = "SELECT u.email AS email,
                u.user_id AS user_id,
                u.first_name AS first_name,
                u.last_name AS last_name,
                d.city AS city,
                d.street AS street,
                d.name AS store_name,
                c.name AS company,
                CONCAT(di.first_name,' ',di.last_name) AS distributor,
                d.contact_no AS contact_no,
                d.image AS image FROM users u INNER JOIN dealer d
                ON u.user_id = d.dealer_id
                INNER JOIN company c
                ON d.company_id = c.company_id
                INNER JOIN users di
                ON d.distributor_id = di.user_id
                WHERE u.user_id = $user_id";
                $data['query'] = $this->Query($sql);
            }else if($tab == 'bank'){
                $sql = "SELECT * FROM dealer d INNER JOIN users u ON d.dealer_id = u.user_id WHERE d.dealer_id = $user_id";
                $data['query'] = $this->Query($sql);
            }else if($tab == 'security'){
                $sql = "SELECT * FROM dealer d INNER JOIN users u ON d.dealer_id = u.user_id WHERE d.dealer_id = $user_id";
                $data['query'] = $this->Query($sql);
            }else if($tab == 'capacity'){
                $sql = "SELECT dc.capacity AS capacity,
                p.name AS product_name,
                p.product_id AS product_id,
                u.first_name AS first_name,
                u.last_name AS last_name,
                p.image AS product_image,
                u.email AS email,
                u.user_id AS user_id,
                d.image AS image FROM users u INNER JOIN dealer d ON u.user_id = d.dealer_id INNER JOIN company c ON d.company_id = c.company_id INNER JOIN product p ON c.company_id = p.company_id RIGHT JOIN dealer_capacity dc ON d.dealer_id = dc.dealer_id AND p.product_id = dc.product_id WHERE d.dealer_id = $user_id";
                $data['query'] = $this->Query($sql);
            }
        }else{
            if($tab == 'profile'){
                $sql = "SELECT u.email AS email,
                u.user_id AS user_id,
                u.first_name AS first_name,
                u.last_name AS last_name,
                d.city AS city,
                d.street AS street,
                d.name AS store_name,
                c.name AS company,
                CONCAT(di.first_name,' ',di.last_name) AS distributor,
                d.contact_no AS contact_no,
                d.image AS image FROM users u INNER JOIN dealer d
                ON u.user_id = d.dealer_id
                INNER JOIN company c
                ON d.company_id = c.company_id
                INNER JOIN users di
                ON d.distributor_id = di.user_id
                WHERE u.user_id = $user_id";
                $data['query'] = $this->Query($sql);
            }else if($tab == 'bank'){
                $sql = "SELECT * FROM dealer d INNER JOIN users u ON d.dealer_id = u.user_id WHERE d.dealer_id = $user_id";
                $data['query'] = $this->Query($sql);
            }else if($tab == 'stock'){
                $sql = "SELECT dk.quantity AS quantity,
                p.name AS product_name,
                p.product_id AS product_id,
                u.first_name AS first_name,
                u.last_name AS last_name,
                p.image AS product_image,
                u.email AS email,
                u.user_id AS user_id,
                d.image AS image FROM users u INNER JOIN dealer d 
                ON u.user_id = d.dealer_id INNER JOIN company c 
                ON d.company_id = c.company_id INNER JOIN product p 
                ON c.company_id = p.company_id RIGHT JOIN dealer_keep dk 
                ON d.dealer_id = dk.dealer_id AND p.product_id = dk.product_id WHERE d.dealer_id = $user_id";
                $data['query'] = $this->Query($sql);
            }
        }
        return $data;
    }

    public function getdistributorprofile($user_id,$tab,$mode){
        $data = [];
        if($mode == 'edit'){
            if($tab == 'profile'){
                $sql = "SELECT u.email AS email,
                u.user_id AS user_id,
                u.first_name AS first_name,
                u.last_name AS last_name,
                d.city AS city,
                d.street AS street,
                c.name AS company,
                d.contact_no AS contact_no,
                d.hold_time AS hold_time,
                d.image AS image FROM users u INNER JOIN distributor d
                ON u.user_id = d.distributor_id
                INNER JOIN company c
                ON d.company_id = c.company_id
                WHERE u.user_id = $user_id";
                $data['query'] = $this->Query($sql);
            }else if($tab == 'security'){
                $sql = "SELECT * FROM distributor d INNER JOIN users u ON d.distributor_id = u.user_id WHERE d.distributor_id = $user_id";
                $data['query'] = $this->Query($sql);
            }else if($tab == 'capacity'){
                $sql = "SELECT dc.capacity AS capacity,
                p.name AS product_name,
                p.product_id AS product_id,
                u.first_name AS first_name,
                u.last_name AS last_name,
                p.image AS product_image,
                u.email AS email,
                u.user_id AS user_id,
                d.image AS image FROM users u INNER JOIN distributor d 
                ON u.user_id = d.distributor_id INNER JOIN company c 
                ON d.company_id = c.company_id INNER JOIN product p 
                ON c.company_id = p.company_id RIGHT JOIN distributor_capacity dc 
                ON d.distributor_id = dc.distributor_id AND p.product_id = dc.product_id WHERE d.distributor_id = $user_id";
                $data['query'] = $this->Query($sql);
            }
        }else{
            if($tab == 'profile'){
                $sql = "SELECT u.email AS email,
                u.user_id AS user_id,
                u.first_name AS first_name,
                u.last_name AS last_name,
                d.city AS city,
                d.street AS street,
                c.name AS company,
                d.hold_time AS hold_time,
                d.contact_no AS contact_no,
                d.image AS image FROM users u INNER JOIN distributor d
                ON u.user_id = d.distributor_id
                INNER JOIN company c
                ON d.company_id = c.company_id
                WHERE u.user_id = $user_id";
                $data['query'] = $this->Query($sql);
            }else if($tab == 'stock'){
                $sql = "SELECT dk.quantity AS quantity,
                p.name AS product_name,
                p.product_id AS product_id,
                u.first_name AS first_name,
                u.last_name AS last_name,
                p.image AS product_image,
                u.email AS email,
                u.user_id AS user_id,
                d.image AS image FROM users u INNER JOIN distributor d 
                ON u.user_id = d.distributor_id INNER JOIN company c 
                ON d.company_id = c.company_id INNER JOIN product p 
                ON c.company_id = p.company_id RIGHT JOIN distributor_keep dk 
                ON d.distributor_id = dk.distributor_id AND p.product_id = dk.product_id WHERE d.distributor_id = $user_id";
                $data['query'] = $this->Query($sql);
            }
        }
        return $data;
    }

    public function getcompanyprofile($user_id,$tab,$mode){
        $data = [];
        if($mode == 'edit'){
            if($tab == 'profile'){
                $sql = "SELECT u.email AS email,
                u.user_id AS user_id,
                u.first_name AS first_name,
                u.last_name AS last_name,
                c.city AS city,
                c.street AS street,
                c.name AS name,
                c.logo AS logo
                FROM users u INNER JOIN company c
                ON u.user_id = c.company_id
                WHERE u.user_id = $user_id";
                $data['query'] = $this->Query($sql);
            }else if($tab == 'security'){
                $sql = "SELECT * FROM company c INNER JOIN users u ON c.company_id = u.user_id WHERE c.company_id = $user_id";
                $data['query'] = $this->Query($sql);
            }
        }else{
            if($tab == 'profile'){
                $sql = "SELECT u.email AS email,
                u.user_id AS user_id,
                u.first_name AS first_name,
                u.last_name AS last_name,
                c.city AS city,
                c.street AS street,
                c.name AS name,
                c.logo AS logo
                FROM users u INNER JOIN company c
                ON u.user_id = c.company_id
                WHERE u.user_id = $user_id";
                $data['query'] = $this->Query($sql);
            }
        }
        return $data;
    }

    public function getdeliveryprofile($user_id,$tab,$mode){
        $data = [];
        if($mode == 'edit'){
            if($tab == 'profile'){
                $sql = "SELECT u.email AS email,
                u.user_id AS user_id,
                u.first_name AS first_name,
                u.last_name AS last_name,
                d.city AS city,
                d.street AS street,
                d.image AS image,
                d.vehicle_no AS vehicle_no,
                d.vehicle_type AS vehicle_type,
                d.weight_limit AS weight_limit,
                d.cost_per_km AS cost_per_km
                FROM users u INNER JOIN delivery_person d
                ON u.user_id = d.delivery_id
                WHERE u.user_id = $user_id";
                $data['query'] = $this->Query($sql);
            }else if($tab == 'security'){
                $sql = "SELECT * FROM delivery_person d INNER JOIN users u ON d.delivery_id = u.user_id WHERE d.delivery_id = $user_id";
                $data['query'] = $this->Query($sql);
            }
        }else{
            if($tab == 'profile'){
                $sql = "SELECT u.email AS email,
                u.user_id AS user_id,
                u.first_name AS first_name,
                u.last_name AS last_name,
                d.city AS city,
                d.street AS street,
                d.image AS image,
                d.vehicle_no AS vehicle_no,
                d.vehicle_type AS vehicle_type,
                d.weight_limit AS weight_limit,
                d.cost_per_km AS cost_per_km
                FROM users u INNER JOIN delivery_person d
                ON u.user_id = d.delivery_id
                WHERE u.user_id = $user_id";
                $data['query'] = $this->Query($sql);
            }
        }
        return $data;
    }

    public function getcustomerprofile($user_id,$tab,$mode){
        $data = [];
        if($mode == 'edit'){
            if($tab == 'profile'){
                $sql = "SELECT u.email AS email,
                u.user_id AS user_id,
                u.first_name AS first_name,
                u.last_name AS last_name,
                c.city AS city,
                c.street AS street,
                c.contact_no AS contact_no,
                c.type AS type,
                c.image AS image FROM users u INNER JOIN customer c
                ON u.user_id = c.customer_id
                WHERE u.user_id = $user_id";
                $data['query'] = $this->Query($sql);
            }else if($tab == 'security'){
                $sql = "SELECT * FROM customer c INNER JOIN users u ON c.customer_id = u.user_id WHERE c.customer_id = $user_id";
                $data['query'] = $this->Query($sql);
            }
        }else{
            if($tab == 'profile'){
                $sql = "SELECT u.email AS email,
                u.user_id AS user_id,
                u.first_name AS first_name,
                u.last_name AS last_name,
                c.city AS city,
                c.street AS street,
                c.name AS company,
                c.contact_no AS contact_no,
                c.type AS type,
                c.image AS image FROM users u INNER JOIN customer c
                ON u.user_id = c.customer_id
                WHERE u.user_id = $user_id";
                $data['query'] = $this->Query($sql);
            }
        }
        return $data;
    }

}
?>