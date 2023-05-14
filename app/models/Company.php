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
        $data['company'] = array();
        if(mysqli_num_rows($result)>0){
            $info = array();
            while($row = mysqli_fetch_assoc($result)){
                array_push($info,['name'=>$row['name'], 'email'=>$row['email'], 'address'=>$row['address']]);
            }
            $data['company'] = $info;
        }
        return $data['company'];
    }
    public function getAllProducts(){
        $sql = "SELECT c.name AS company_name,
        p.name AS name,
        p.weight AS weight,
        p.image AS image,
        p.unit_price AS unit_price,
        IFNULL(r.soldcount,0) AS soldcount FROM product p INNER JOIN company c ON p.company_id = c.company_id
        LEFT JOIN (SELECT SUM(quantity) as soldcount,product_id FROM reservation_include GROUP BY product_id) r
        ON p.product_id = r.product_id;";
        $result = $this->Query($sql);
        return $result;
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
                array_push($info,['product_id'=>$row['product_id'], 'name'=>$row['name'], 'type'=>$row['type'], 'unit_price'=>$row['unit_price'],'weight'=>$row['weight'],'production_time'=>$row['production_time'],'last_updated_date'=>$row['last_updated_date'],'quantity'=>$row['quantity'],'cylinder_limit'=>$row['cylinder_limit'],'image'=>$row['image']]);
            }
            return $info;
        }else{
            return null;
        }

    }
    public function getRegisteredDistributors($company_id){
        $result = $this->Query("SELECT CONCAT(users.first_name,' ',users.last_name) AS name,distributor.contact_no,distributor.hold_time,distributor.city,distributor.street FROM users INNER JOIN distributor ON users.user_id=distributor.distributor_id AND distributor.company_id=$company_id;");
        if(mysqli_num_rows($result)>0){
            $info = array();
            while($row = mysqli_fetch_assoc($result)){
                array_push($info,['name'=>$row['name'],'contact_no'=>$row['contact_no'], 'hold_time'=>$row['hold_time'], 'city'=>$row['city'], 'street'=>$row['street']]);
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
        $company_id = $_SESSION['user_id'];
        $this->insert("product",$data);
        //  sasangi 
        //take the product table minimum weight product to insert it to quota table and customer quota table
        $result1 = $this->Query("SELECT product_id, MIN(weight) as min_weight FROM product WHERE type='cylinder' AND company_id=$company_id");
        $row1 = mysqli_fetch_assoc($result1);
        
        if(mysqli_num_rows($result1)!=0){
            $min_weight = $row1['min_weight'];
            $product_id = $row1['product_id'];

            $this->update("quota",['monthly_limit' => $min_weight],'company_id=' .$company_id,'monthly_limit<='.$min_weight);
            $this->update("customer_quota",['remaining_amount' => $min_weight],'company_id=' .$company_id,'remainig_amount='.'0');
        
        }
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
        if(isset($data['quantity'])){
            $qty=intval($data['quantity']);
            //print_r($data['quantity']);
            $this->Query("UPDATE product SET quantity=quantity+$qty WHERE product_id=$productID");
        }else{
            $this->update("product",$data,"company_id=".$companyID." AND product_id=".$productID);
        }
        //$this->update("product",$data,"company_id=".$companyID." AND product_id=".$productID);
    }
    //update quota and customer_quota table when updated the quota limit
    public function setQuota($companyID,$customer,$quota){
        //take the previous quota monthly limit 
        $query1 = $this->Query("SELECT * FROM quota WHERE company_id = $companyID AND customer_type='$customer'");
        $row1 = mysqli_fetch_assoc($query1);
        $old_monthly_limit = intval($row1['monthly_limit']);

        //all relavant customer type customers remaing_quota_limit
        $query2 = $this->Query("SELECT * FROM customer_quota WHERE company_id = $companyID AND customer_type= '$customer'");
        //print_r($old_monthly_limit);
        while($row2 = mysqli_fetch_assoc($query2)){
            $customer_id = $row2['customer_id'];
            $old_remaining_amount = intval($row2['remaining_amount']);
            $used_quota =$old_monthly_limit-$old_remaining_amount;
            $new_remaining_amount = intval($quota) - $used_quota;
            
            //company set new quota limit as zero
            if($quota == 0){
                $new_remaining_amount = 0;
            }
            if($new_remaining_amount <= 0){
                $new_remaining_amount = 0;
            }  
            //update new remaining amount after update new monthly limit in quota table
            $this ->update('customer_quota',['remaining_amount'=>$new_remaining_amount],'customer_id= '.$customer_id.' AND company_id='.$companyID.'');
        }

        //update quota table with new quota monthly limit
        $this->Query("UPDATE quota SET monthly_limit=$quota WHERE (company_id=$companyID AND customer_type='$customer')");
    }
    public function resetQuota($companyID,$customer,$state){
        $this->Query("UPDATE quota SET state='$state' WHERE (company_id=$companyID AND customer_type='$customer');");
    }
    public function getStockReqDetails($company_id){
        $result=$this->Query("SELECT users.first_name,users.last_name,stock_request.place_date,stock_request.place_time,stock_request.stock_req_id,stock_request.distributor_id,stock_include.product_id,stock_include.quantity,stock_include.unit_price FROM users INNER JOIN stock_request ON users.user_id=stock_request.distributor_id AND stock_request.company_id=$company_id INNER JOIN stock_include ON stock_include.stock_req_id=stock_request.stock_req_id AND stock_request.stock_req_state='pending';");
        if(mysqli_num_rows($result)>0){
            $info = array();
            while($row = mysqli_fetch_assoc($result)){
                array_push($info,['first_name'=>$row['first_name'], 'last_name'=>$row['last_name'], 'place_date'=>$row['place_date'], 'place_time'=>$row['place_time'], 'stock_req_id'=>$row['stock_req_id'], 'distributor_id'=>$row['distributor_id'], 'product_id'=>$row['product_id'], 'quantity'=>$row['quantity'], 'unit_price'=>$row['unit_price']]);
            }
            return $info;
        }else{
            return null;
        }
        
        
        
        
        return $result;
    }
    public function issueOrder($orderID){
        $this->Query("UPDATE stock_request SET stock_req_state='completed' WHERE stock_req_id=$orderID");
    }
    public function getIssuedStockReqDetails($company_id){
        $result=$this->Query("SELECT users.first_name,users.last_name,stock_request.place_date,stock_request.place_time,stock_request.stock_req_id,stock_request.distributor_id,stock_include.product_id,stock_include.quantity,stock_include.unit_price FROM users INNER JOIN stock_request ON users.user_id=stock_request.distributor_id AND stock_request.company_id=$company_id INNER JOIN stock_include ON stock_include.stock_req_id=stock_request.stock_req_id AND stock_request.stock_req_state='completed';");
        if(mysqli_num_rows($result)>0){
            $info = array();
            while($row = mysqli_fetch_assoc($result)){
                array_push($info,['first_name'=>$row['first_name'], 'last_name'=>$row['last_name'], 'place_date'=>$row['place_date'], 'place_time'=>$row['place_time'], 'stock_req_id'=>$row['stock_req_id'], 'distributor_id'=>$row['distributor_id'], 'product_id'=>$row['product_id'], 'quantity'=>$row['quantity'], 'unit_price'=>$row['unit_price']]);
            }
            return $info;
        }
        //return $result;
    }
    public function delayOrder($orderID){
        $this->Query("UPDATE stock_request SET stock_req_state='delayed' WHERE stock_req_id=$orderID");
    }
    public function getDelayedStockReqDetails($company_id){
        $result=$this->Query("SELECT users.first_name,users.last_name,stock_request.place_date,stock_request.place_time,stock_request.stock_req_id,stock_request.distributor_id,stock_include.product_id,stock_include.quantity,stock_include.unit_price FROM users INNER JOIN stock_request ON users.user_id=stock_request.distributor_id AND stock_request.company_id=$company_id INNER JOIN stock_include ON stock_include.stock_req_id=stock_request.stock_req_id AND stock_request.stock_req_state='delayed';");
        if(mysqli_num_rows($result)>0){
            $info = array();
            while($row = mysqli_fetch_assoc($result)){
                array_push($info,['first_name'=>$row['first_name'], 'last_name'=>$row['last_name'], 'place_date'=>$row['place_date'], 'place_time'=>$row['place_time'], 'stock_req_id'=>$row['stock_req_id'], 'distributor_id'=>$row['distributor_id'], 'product_id'=>$row['product_id'], 'quantity'=>$row['quantity'], 'unit_price'=>$row['unit_price']]);
            }
            return $info;
        }
        //return $result;
    }
    public function getProductCount($company_id){
        $result=$this->Query("SELECT COUNT(product.product_id) as count FROM product WHERE product.company_id=$company_id");
        if(mysqli_num_rows($result)>0){
            $info = array();
            while($row = mysqli_fetch_assoc($result)){
                array_push($info,['count'=>$row['count']]);
            }
            return $info;
        }
    }
    public function getPendingReqCount($company_id){
        $result=$this->Query("SELECT COUNT(stock_request.stock_req_id) as count FROM stock_request WHERE stock_request.company_id=$company_id AND stock_request.stock_req_state='pending';");
        if(mysqli_num_rows($result)>0){
            $info = array();
            while($row = mysqli_fetch_assoc($result)){
                array_push($info,['count'=>$row['count']]);
            }
            return $info;
        }
    }
    public function getDistributorCount($company_id){
        $result=$this->Query("SELECT COUNT(distributor.distributor_id) AS count FROM distributor INNER JOIN users ON distributor.distributor_id=users.user_id AND distributor.company_id=$company_id;");
        if(mysqli_num_rows($result)>0){
            $info = array();
            while($row = mysqli_fetch_assoc($result)){
                array_push($info,['count'=>$row['count']]);
            }
            return $info;
        }
    }
    public function getDealerCount($company_id){
        $result=$this->Query("SELECT COUNT(dealer.dealer_id) AS count FROM dealer INNER JOIN users ON dealer.dealer_id=users.user_id AND dealer.company_id=$company_id;");
        if(mysqli_num_rows($result)>0){
            $info = array();
            while($row = mysqli_fetch_assoc($result)){
                array_push($info,['count'=>$row['count']]);
            }
            return $info;
        }
    }
    public function reduceStock($key,$qty){
        $this->Query("UPDATE product SET quantity=quantity-$qty WHERE product_id=$key;");
    }
    public function getQuotaDetails($company_id){
        $result=$this->Query("SELECT * FROM `quota` WHERE company_id=$company_id");
        if(mysqli_num_rows($result)>0){
            $info = array();
            while($row = mysqli_fetch_assoc($result)){
                array_push($info,['customer_type'=>$row['customer_type'],'monthly_limit'=>$row['monthly_limit'],'state'=>$row['state']]);
            }
            return $info;
        }

    }
    public function getDistributorNamesOnly($company_id){
        $result=$this->Query("SELECT CONCAT(users.first_name,' ',users.last_name)AS names,distributor.distributor_id AS id FROM users INNER JOIN distributor ON users.user_id=distributor.distributor_id AND distributor.company_id=$company_id");
        if(mysqli_num_rows($result)>0){
            $info = array();
            while($row = mysqli_fetch_assoc($result)){
                array_push($info,['names'=>$row['names'],'id'=>$row['id']]);
            }
            return $info;
        }
    
    }
    public function getOrderDates($ID){
        $result=$this->Query("SELECT users.date_joined AS joinedDate FROM users WHERE users.user_id=$ID");
        if(mysqli_num_rows($result)>0){
            $info = array();
            while($row = mysqli_fetch_assoc($result)){
                array_push($info,['joinedDate'=>$row['joinedDate']]);
            }
            return $info;
        }
    }
    public function getProductsForAnalysis($company_id,$distributorID,$yearFrom,$yearTo){
        $result=$this->Query("SELECT users.first_name,users.last_name,stock_request.place_date,stock_request.place_time,stock_request.stock_req_id,stock_request.distributor_id,stock_include.product_id,stock_include.quantity,stock_include.unit_price FROM users INNER JOIN stock_request ON users.user_id=stock_request.distributor_id AND stock_request.company_id=$company_id INNER JOIN stock_include ON stock_include.stock_req_id=stock_request.stock_req_id AND stock_request.distributor_id=$distributorID AND stock_request.stock_req_state='completed' AND YEAR(stock_request.place_date) BETWEEN $yearFrom AND $yearTo ;");
        if(mysqli_num_rows($result)>0){
            $info = array();
            while($row = mysqli_fetch_assoc($result)){
                array_push($info,['first_name'=>$row['first_name'], 'last_name'=>$row['last_name'], 'place_date'=>$row['place_date'], 'place_time'=>$row['place_time'], 'stock_req_id'=>$row['stock_req_id'], 'distributor_id'=>$row['distributor_id'], 'product_id'=>$row['product_id'], 'quantity'=>$row['quantity'], 'unit_price'=>$row['unit_price']]);
            }
            return $info;
        }
        //return $result;
    }
    public function getDistributorName($distributorID){
        $result=$this->Query("SELECT CONCAT(users.first_name,' ',users.last_name) AS name FROM users WHERE users.user_id=$distributorID");
        if(mysqli_num_rows($result)>0){
            $info = array();
            while($row = mysqli_fetch_assoc($result)){
                array_push($info,['name'=>$row['name']]);
            }
            return $info;
        }
    }
    public function getDateJoined($distributorID){
        $result=$this->Query("SELECT date_joined AS date FROM users WHERE users.user_id=$distributorID");
        if(mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_assoc($result)){
                return explode("-",$row['date']);
            }
        }
    }
    public function getDistributorID($orderID){
        $result = $this->Query("SELECT stock_request.distributor_id FROM stock_request WHERE stock_request.stock_req_id=$orderID");
        if(mysqli_num_rows($result)>0){
            $info = "";
            while($row = mysqli_fetch_assoc($result)){
                $info=$row['distributor_id'];
            }
            return $info;
        }
    }
    public function addStockToDistributor($distributorID,$productID,$qty){
        $this->Query("UPDATE distributor_keep SET distributor_keep.quantity=quantity+$qty WHERE distributor_keep.product_id=$productID AND distributor_keep.distributor_id=$distributorID");
    }
    public function getLowestProductWeight($companyID){
        $result=$this->Query("SELECT weight FROM product WHERE company_id=$companyID AND type='Cylinder' ORDER BY weight ASC LIMIT 1;");
        if(mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_assoc($result)){
                $info=$row['weight'];
            }
            return $info;
        }else{
            return 0;
        }
    }
    public function getProductNamesOnly($companyID){
        $result=$this->Query("SELECT product.product_id,product.name FROM product WHERE product.company_id=$companyID;");
        if(mysqli_num_rows($result)>0){
            $info = array();
            while($row = mysqli_fetch_assoc($result)){
                $info+=array(intval($row['product_id'])=>$row['name']);
                //array_push($info,[intval($row['product_id'])=>$row['name']]);
            }
            return $info;
        }else{
            return 0;
        }
    }
}