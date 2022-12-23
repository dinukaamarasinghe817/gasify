<?php

class Products extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getProducts($company_id){
        $result = $this->read('product', 'company_id = '.$company_id);
        return $result;
    } 

    public function addVerificationTeam($id,$mobile,$dob,$email,$gender,$address,$nic){
        $this->insert('VerificationTeam', ['VerificationTeamId'=> $id, 'DateOfBirth'=> $dob, 'NIC'=> $nic, 'Email'=> $email, 'ContactNumber'=> $mobile, 'Address'=> $address, 'Gender'=> $gender]);
        
    }
    
    
}