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
        $result = $this->Query("SELECT * FROM users u INNER JOIN company c ON u.user_id = c.company_id WHERE u.user_id = '$company_id' ");
        // $result = $this->read('company', "company_id = $company_id");
        return $result;
    }
    public function getRegisteredDealers($company_id){
        //$result = $this->read('dealer',"company_id=$company_id");
        $result = $this->read('dealer',"company_id = $company_id");
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
        /*foreach ($data as $key => $value) {
            //print_r($data);
            // $sql .= "$key = '$value', ";
            print_r($data['cmp_id']);
         }*/
        $this->insert("product",$data);
        //print_r($data);

    }
    public function getDealerID($data){
        $result=$this->read('users','email =\''.$data.'\'');
        $row=mysqli_fetch_assoc($result);
        return $row['user_id'];

    }public function registerUser($data){
        $this->insert("users",$data);

    }public function registerNewDealer($data){
        $this->insert("dealer",$data);
    }
    public function registerNewDistributor($data){
        $this->insert("distributor",$data);
    }public function updateProduct($data,$productID,$companyID){
        //print_r("tu");
        $this->update("product",$data,"company_id=".$companyID." AND product_id=".$productID);
    }public function setQuota($companyID,$customer,$quota){
        $this->Query("UPDATE quota SET monthly_limit=$quota WHERE (company_id=$companyID AND customer_type='$customer')");
    }
    public function resetQuota($companyID,$customer){
        $this->Query("UPDATE quota SET monthly_limit=0 WHERE (company_id=$companyID AND customer_type='$customer')");
    }
    public function getStockReqDetails($company_id){
        $result=$this->Query("SELECT users.first_name,users.last_name,stock_request.place_date,stock_request.place_time,stock_request.stock_req_id,stock_request.distributor_id,stock_include.product_id,stock_include.quantity,stock_include.unit_price FROM users INNER JOIN stock_request ON users.user_id=stock_request.distributor_id AND stock_request.company_id=2 INNER JOIN stock_include ON stock_include.stock_req_id=stock_request.stock_req_id;");
        if(mysqli_num_rows($result)>0){
            $info = array();
            while($row = mysqli_fetch_assoc($result)){
                array_push($info,['first_name'=>$row['first_name'], 'last_name'=>$row['last_name'], 'place_date'=>$row['place_date'], 'place_time'=>$row['place_time'], 'stock_req_id'=>$row['stock_req_id'], 'distributor_id'=>$row['distributor_id'], 'product_id'=>$row['product_id'], 'quantity'=>$row['quantity'], 'unit_price'=>$row['unit_price']]);
            }
            return $info;
        }
        
        
        
        
        return $result;
    }
    
}