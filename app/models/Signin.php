<?php

class Signin extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    // public function RegisterDealer($firstname,$lastname,$username,$password,$usertype)

    // {
    //     //hashing the password
    //     $password = password_hash($password, PASSWORD_DEFAULT);
    //     $this->insert('user', ['FirstName' => $firstname,'LastName' => $lastname,'Username' => $username, 'Password' => $password, 'UserType' => $usertype]);
    //     //return last id
    //     return $this->lastInsertId();
    // } 

    public function addDealer($name,$email,$hashed_pwd,$city,$street,$contact_no,$acc_no,$image = NULL, $company_id, $distributor_id){
        if($image == NULL){
            $result = $this->insert('dealer', ['name'=> $name, 'email'=> $email, 'cur_pwd'=> $hashed_pwd, 'city'=> $city, 'street'=> $street, 'contact_no'=> $contact_no, 'banc_acc'=> $acc_no, 'company_id'=> $company_id, 'distributor_id'=> $distributor_id]);

        }else{
            $result = $this->insert('dealer', ['name'=> $name, 'email'=> $email, 'cur_pwd'=> $hashed_pwd, 'city'=> $city, 'street'=> $street, 'contact_no'=> $contact_no, 'banc_acc'=> $acc_no, 'image'=> $image, 'company_id'=> $company_id, 'distributor_id'=> $distributor_id]);

        }
        return $result;
    }
    
    
}