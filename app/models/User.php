<?php

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

}
?>