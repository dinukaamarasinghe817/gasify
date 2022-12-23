<?php

class Dealer extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllDealers(){  
        $result = $this->Query("SELECT CONCAT(u.first_name,' ',u.last_name) AS name, u.email AS email, CONCAT(d.street,', ',d.city) AS address, d.contact_no AS contact FROM dealer d INNER JOIN users u ON d.dealer_id = u.user_id");
        $data = [];
        if(mysqli_num_rows($result)>0){
            $info = array();
            while($row = mysqli_fetch_assoc($result)){
                array_push($info,['name'=>$row['name'], 'email'=>$row['email'], 'address'=>$row['address'], 'contact'=>$row['contact']]);
            }
            $data['dealer'] = $info;
        }
        return $data['dealer'];
    }

    public function getDealer($email){
        // $sql = "SELECT u.user_id as dealer_id,
        //         u.first_name as first_name,
        //         u.last_name as last_name,
        //         u.email as email,
        //         u.password as password,
        //         u.verification_code as verification_code,
        //         u.verification_state as verification_state
        //         d.image as image
        //         FROM users u
        //         INNER JOIN dealer d
        //         ON u.user_id = d.dealer_id";
        $result = $this->read('users', "email = '$email' AND type = 'dealer'");
        // $result = $this->Query($sql);
        return $result;
    }

    public function getDealerImage($dealer_id){
        $result = $this->read('dealer', "dealer_id = $dealer_id");
        return $result;
    }

    public function setCapacity($dealer_id, $company_id, $product, $qty){
        $result = $this->insert('dealer_capacity',['dealer_id'=> $dealer_id,'company_id'=> $company_id,'product_id'=>$product,'capacity'=>$qty]);
        return $result;
    }

    public function getcurrentstock($dealer_id){
        // direct query since joins used
        $result = $this->Query("SELECT dealer_keep.quantity as quantity, product.name as name
        FROM dealer_keep INNER JOIN product 
        ON dealer_keep.product_id = product.product_id 
        WHERE dealer_id = '$dealer_id'");
        return $result;
    }
    
    public function getpendigorders($dealer_id){
        $orders = array();
        // $result = $this->read('reservation', "dealer_id = $dealer_id AND order_state = 'pending'");
        $sql = "SELECT r.order_id as order_id,r.customer_id as customer_id, CONCAT(u.first_name,' ',u.last_name) as customer_name 
                FROM reservation r
                INNER JOIN
                customer c
                ON r.customer_id = c.customer_id
                INNER JOIN
                users u
                ON c.customer_id = u.user_id
                WHERE r.dealer_id = $dealer_id
                AND r.order_state = 'pending'";
        $result = $this->Query($sql);
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                $products = array();
                $order_id = $row['order_id'];
                // $result2 = $this->read('reservation_include',"order_id = $order_id");
                $sql = "SELECT r.quantity as qty,p.name as product_name
                        FROM reservation_include r
                        INNER JOIN
                        product p
                        ON r.product_id = p.product_id
                        WHERE r.order_id = $order_id";
                $result2 = $this->Query($sql);
                if(mysqli_num_rows($result2) > 0){
                    while($row2 = mysqli_fetch_assoc($result2)){
                        array_push($products, $row2);
                    }
                }
                array_push($orders, ['row' => $row, 'products' => $products]);
            }
        }

        return $orders;
    }
}