<?php

class Company extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getDistributors($company_id){  
        $result = $this->read('distributor', "company_id = $company_id", "city");
        return $result;
    }

    public function getAllCompanies(){  
        $result = $this->Query("SELECT c.name AS name, u.email AS email, CONCAT(c.street,', ',c.city) AS address FROM company c INNER JOIN users u ON c.company_id = u.user_id");
        $data = [];
        if(mysqli_num_rows($result)>0){
            $info = array();
            while($row = mysqli_fetch_assoc($result)){
                array_push($info,['name'=>$row['name'], 'email'=>$row['email'], 'address'=>$row['address']]);
            }
            $data['company'] = $info;
        }
        return $data['company'];
    }
    public function getCompanyImage($company_id){
        $result = $this->read('company', "company_id = $company_id");
        return $result;
    }
    public function getRegisteredDealers($company_id){
        //$result = $this->read('dealer',"company_id=$company_id");
        $result = $this->readJoin("company_id = $company_id");
        //$data=[];
        if(mysqli_num_rows($result)>0){
            $info = array();
            while($row = mysqli_fetch_assoc($result)){
                array_push($info,['name'=>$row['name'], 'city'=>$row['city'], 'bank'=>$row['bank'], 'contact_no'=>$row['contact_no'],'account_no'=>$row['account_no'],'street'=>$row['street']]);
            }
            return $info;
        }
        //return $result;

    }
    public function getProductDetails($company_id){
        $result = $this->read('product', "company_id = $company_id");
        if(mysqli_num_rows($result)>0){
            $info = array();
            while($row = mysqli_fetch_assoc($result)){
                array_push($info,['product_id'=>$row['product_id'], 'name'=>$row['name'], 'type'=>$row['type'], 'unit_price'=>$row['unit_price'],'weight'=>$row['weight'],'production_time'=>$row['production_time'],'last_updated_date'=>$row['last_updated_date'],'quantity'=>$row['quantity']]);
            }
            return $info;
        }

    }
    public function getRegisteredDistributors($company_id){
        $result = $this->read('distributor', "company_id = $company_id");
        if(mysqli_num_rows($result)>0){
            $info = array();
            while($row = mysqli_fetch_assoc($result)){
                array_push($info,['contact_no'=>$row['contact_no'], 'hold_time'=>$row['hold_time'], 'city'=>$row['city'], 'street'=>$row['street']]);
            }
            return $info;
        }
    }
    public function registerNewProduct($data){
        //$result = $this->insert("product",$data);
        print_r($data);

    }
    
    
}