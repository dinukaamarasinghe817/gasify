<?php

class Distributor extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllDistributors(){  
        $result = $this->Query("SELECT CONCAT(u.first_name,' ',u.last_name) AS name, u.email AS email, CONCAT(d.street,', ',d.city) AS address, d.contact_no AS contact FROM distributor d INNER JOIN users u ON d.distributor_id = u.user_id");
        $data = [];
        if(mysqli_num_rows($result)>0){
            $info = array();
            while($row = mysqli_fetch_assoc($result)){
                array_push($info,['name'=>$row['name'], 'email'=>$row['email'], 'address'=>$row['address'], 'contact'=>$row['contact']]);
            }
            $data['distributor'] = $info;
        }
        return $data['distributor'];
    }

    public function getDistributorImage($distributor_id){
        $result = $this->read('distributor', "distributor_id = $distributor_id");
        return $result;
    }
    
    
}