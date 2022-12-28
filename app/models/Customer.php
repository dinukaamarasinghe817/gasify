<?php

class Customer extends Model{

    public function __construct()
    {
        parent::__construct();
    }

    public function getCustomerImage($customer_id){
        $result = $this->read('customer', "customer_id = $customer_id");
        return $result;
    }

    public function getCompanyBrand(){
        $result = $this->Query("SELECT name,logo FROM company");
        return $result;
    }
    
    public function getRecentorders($customer_id){
        $result1 = $this->Query("SELECT order_id,order_state,place_date
            FROM reservation
            WHERE customer_id = '{$customer_id}'
            ORDER BY place_date DESC LIMIT 3");
        
        
        $orders = array();
        if(mysqli_num_rows($result1)>0){
           while($row1 = mysqli_fetch_assoc($result1)){
                $order_id = $row1['order_id'];
                $product = array();

                $result2 = $this->Query("SELECT * FROM reservation_include WHERE order_id = '{$order_id}'");

                while($row2=mysqli_fetch_assoc($result2)){

                    $result3 = $this->Query("SELECT p.name as product_name, c.name as company_name FROM product p INNER JOIN company c ON p.company_id = c.company_id WHERE product_id = '{$row2['product_id']}'"); 
                    $total_amount = 0;
                    if($row3 = mysqli_fetch_assoc($result3)){
                        $quantity = $row3['quantity'];
                        $unit_price = $row3['unit_price'];
                        $amount = $quantity * $unit_price;
                        $total_amount = $total_amount + $amount;
                        array_push($product,$row2,$row3,$total_amount);
                    }

                }

                array_push($orders,['row'=>$row1,'products'=>$product]);

           }
        }

        return $orders;
    }



  

}





?>