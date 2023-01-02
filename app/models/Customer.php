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
                $products = array();

                // $result2 = $this->Query("SELECT * FROM reservation_include WHERE order_id = '{$order_id}'");
                $result2 = $this->Query("SELECT p.name as product_name, c.name as company_name, r.quantity as quantity, r.unit_price as unit_price 
                FROM reservation_include r 
                INNER JOIN product p ON r.product_id = p.product_id 
                INNER JOIN company c ON p.company_id = c.company_id 
                WHERE r.order_id = '{$order_id}'");

                $total_amount = 0;
                while($row2=mysqli_fetch_assoc($result2)){

                    // $result3 = $this->Query("SELECT p.name as product_name, c.name as company_name FROM product p INNER JOIN company c ON p.company_id = c.company_id WHERE product_id = '{$row2['product_id']}'"); 
                    // if($row3 = mysqli_fetch_assoc($result3)){
                    $quantity = $row2['quantity'];
                    $unit_price = $row2['unit_price'];
                    $amount = $quantity * $unit_price;
                    $total_amount = $total_amount + $amount;
                    array_push($products,$row2);
                    // }

                }

                array_push($orders,['order'=>$row1,'products'=>$products, 'total_amount'=>$total_amount]);

           }
        }

        return $orders;
    }

    public function getAllmyreservations($customer_id){

        $result1 = $this->Query("SELECT order_id,order_state,place_date
            FROM reservation
            WHERE customer_id = '{$customer_id}'
            ORDER BY place_date DESC");
        
               
        $allmyreservations = array();
        if(mysqli_num_rows($result1)>0){
           while($row1 = mysqli_fetch_assoc($result1)){
                $order_id = $row1['order_id'];
                $products = array();

                // $result2 = $this->Query("SELECT * FROM reservation_include WHERE order_id = '{$order_id}'");
                $result2 = $this->Query("SELECT p.name as product_name, c.name as company_name, r.quantity as quantity, r.unit_price as unit_price 
                FROM reservation_include r 
                INNER JOIN product p ON r.product_id = p.product_id 
                INNER JOIN company c ON p.company_id = c.company_id 
                WHERE r.order_id = '{$order_id}'");

                $total_amount = 0;
                while($row2=mysqli_fetch_assoc($result2)){

                    // $result3 = $this->Query("SELECT p.name as product_name, c.name as company_name FROM product p INNER JOIN company c ON p.company_id = c.company_id WHERE product_id = '{$row2['product_id']}'"); 
                    // if($row3 = mysqli_fetch_assoc($result3)){
                    $quantity = $row2['quantity'];
                    $unit_price = $row2['unit_price'];
                    $amount = $quantity * $unit_price;
                    $total_amount = $total_amount + $amount;
                    array_push($products,$row2);
                    // }

                }

                array_push( $allmyreservations,['order'=>$row1,'products'=>$products, 'total_amount'=>$total_amount]);

           }
        }

        return  $allmyreservations;

    }

    public function getMyreservation($order_id,$customer_id){

        $allmyreservations = array();
        $products = array();

        $result1 = $this->Query("SELECT reservation.order_id,reservation.order_state,reservation.place_date,dealer.name
        FROM reservation
        JOIN dealer ON reservation.dealer_id = dealer.dealer_id
        WHERE reservation.customer_id = '{$customer_id}' && reservation.order_id = '{$order_id}'");

        $result2 = $this->Query("SELECT p.name as product_name, p.image as product_image, c.name as company_name, r.quantity as quantity, r.unit_price as unit_price 
                FROM reservation_include r 
                INNER JOIN product p ON r.product_id = p.product_id 
                INNER JOIN company c ON p.company_id = c.company_id 
                WHERE r.order_id = '{$order_id}'");
        
        $total_amount = 0;
        while($row2=mysqli_fetch_assoc($result2)){

            // $result3 = $this->Query("SELECT p.name as product_name, c.name as company_name FROM product p INNER JOIN company c ON p.company_id = c.company_id WHERE product_id = '{$row2['product_id']}'"); 
            // if($row3 = mysqli_fetch_assoc($result3)){
            $quantity = $row2['quantity'];
            $unit_price = $row2['unit_price'];
            $amount = $quantity * $unit_price;
            $total_amount = $total_amount + $amount;
            array_push($products,$row2);
            // }

        }

        array_push( $allmyreservations,['order'=>$order_id,'products'=>$products, 'total_amount'=>$total_amount]);

        return $allmyreservations;
        

    }



  

}





?>