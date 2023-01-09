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
    }//

    public function dealerSignupForm($company_id){
        $data['productresult'] = $this->read('product', 'company_id = '.$company_id);
        $data['distributorresult'] = $this->read('distributor', "company_id = $company_id", "city");
        return $data;
    }//

    public function getDealer($dealer_id){
        $result = $this->read('dealer', "dealer_id = $dealer_id");
        return $result;
    }//
    
    public function getProducts($company_id){
        $result = $this->read('product', 'company_id = '.$company_id);
        return $result;
    }//
    
    public function dashboard($dealer_id){
        $data = [];
        // direct query since joins used
        $result = $this->Query("SELECT dealer_keep.quantity as quantity, product.name as name
        FROM dealer_keep INNER JOIN product 
        ON dealer_keep.product_id = product.product_id 
        WHERE dealer_id = '$dealer_id'");
        $data['stock'] = $result;


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
        $data['pending'] = $orders;
        return $data;
    }//

    public function dealerpoplace($user_id,$productid, $postproducts){
        $data = [];
        $flag = false;
        for($i=0; $i<count($productid); $i++){
            if($postproducts[$productid[$i]] == null){
                $data['error'] = "Please insert a valid amount of products";
                return $data;
            };
        }
        for($i=0; $i<count($productid); $i++){
            $product = $productid[$i];
            // take current stock
            $current_stock = 0;
            $result = $this->Query("SELECT * FROM dealer_keep WHERE dealer_id = '{$user_id}' AND product_id = '{$product}'");
            if(mysqli_num_rows($result)>0){
                $row = mysqli_fetch_assoc($result);
                $current_stock = $row['quantity'];
            }
            // take previously ordered but still pending amount
            $pending_stock = 0;
            $result = $this->Query("SELECT * FROM purchase_order WHERE dealer_id = '{$user_id}' AND po_state = 'pending'");
            if(mysqli_num_rows($result)>0){
                while($row = mysqli_fetch_assoc($result)){
                    $po_id = $row['po_id'];
                    $result = $this->Query("SELECT * FROM purchase_include WHERE po_id = '{$po_id}' AND product_id = '{$product}'");
                    $row2 = mysqli_fetch_assoc($result);
                    $pending_stock += $row2['quantity'];
                }
            }

            // take capacity
            $capacity = 0;
            $result = $this->Query("SELECT * FROM dealer_capacity WHERE dealer_id = '{$user_id}' AND product_id = '{$product}'");
            if(mysqli_num_rows($result)>0){
                $row = mysqli_fetch_assoc($result);
                $capacity = $row['capacity'];
            }
            if($postproducts[$product] > ($capacity - $current_stock - $pending_stock)){
                $flag = true;
            }
            // post $productid <= capacity - current stock - pending stock
        }

        if($flag){
            // error handling needed.
            $data['error'] = "Insufficient storage";
            return $data;
            // exit();
        }

        // get distributor and company information
        $query1 = $this->getDealer($user_id);
        $row1 = mysqli_fetch_assoc($query1);
        $company_id = $row1['company_id'];
        $distributor_id = $row1['distributor_id'];
        $business_name = $row1['name'];

        date_default_timezone_set("Asia/Colombo");
        $place_time = date('H:i');
        $place_date = date('Y-m-d');

        
        $query3 = $this->Query("INSERT INTO purchase_order (dealer_id,po_state,distributor_id,place_date,place_time) VALUES ('{$user_id}','pending','{$distributor_id}','{$place_date}','{$place_time}');");
        $query4 = $this->Query("SELECT * FROM purchase_order WHERE dealer_id = '{$user_id}' ORDER BY place_date DESC, place_time DESC LIMIT 1");
        $row4 = mysqli_fetch_assoc($query4);
        $po_id = $row4['po_id'];

        for($i=0; $i<count($productid); $i++){
            $product = $productid[$i];
            $quantity = $postproducts[$product];
            $query7 = $this->Query("SELECT unit_price FROM product WHERE product_id = '$product'");
            $row7 = mysqli_fetch_assoc($query7);
            $unit_price = $row7['unit_price'];
            $query7 = $this->Query("INSERT INTO purchase_include (po_id, product_id, quantity, unit_price) VALUES ($po_id,'$product',$quantity,$unit_price)");
            // if($query5){
            //     echo "success";
            // }
        }
        // echo "success";

        // rendering the pdf report
        // $result = mysqli_query($conn,"SELECT * FROM purchase_order WHERE dealer_id = $dealer_id ORDER BY po_id DESC LIMIT 1");
        $result = $this->Query("SELECT * FROM purchase_order WHERE dealer_id = $user_id ORDER BY po_id DESC LIMIT 1");
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            $po_id = $row['po_id'];
            $date = $row['place_date'];
            $time = $row['place_time'];

            $products = array();
            $total = 0;

            // $result = mysqli_query($conn,"SELECT pi.product_id as product_id,
            // p.name as product_name,
            // pi.quantity as quantity,
            // pi.unit_price as unit_price
            // FROM purchase_include pi INNER JOIN product p
            // ON pi.product_id = p.product_id
            // WHERE po_id = $po_id");
            $result = $this->Query("SELECT pi.product_id as product_id,
            p.name as product_name,
            pi.quantity as quantity,
            pi.unit_price as unit_price
            FROM purchase_include pi INNER JOIN product p
            ON pi.product_id = p.product_id
            WHERE po_id = $po_id");
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    array_push($products, ['product_id' => $row['product_id'], 'product_name' => $row['product_name'], 'quantity' => $row['quantity'], 'unit_price' => $row['unit_price'], 'subtotal' => $row['unit_price']*$row['quantity']]);
                    $total += $row['unit_price']*$row['quantity'];
                }
            }

            $data = ['po_id'=>$po_id, 'dealer_id'=>$user_id, 'business_name'=>$business_name, 'distributor_id'=>$distributor_id, 'date'=>$date, 'time'=>$time, 'products'=>$products, 'total'=>$total];
        }
        return $data;
    }//
    
    public function dealerStock($dealer_id,$tab){
        switch($tab){
            case "currentstock":
                $result = $this->Query("SELECT p.product_id as product_id,p.name as product_name,
                p.weight as product_weight,p.unit_price as unit_price,p.quantity as quantity
                FROM product p INNER JOIN dealer_keep d ON p.product_id = d.product_id WHERE d.dealer_id = $dealer_id");
                return $result;
                break;
            case "purchaseorder":
                $result = $this->Query("SELECT d.product_id as product_id, p.name as name, p.unit_price as unit_price
                FROM dealer_capacity d INNER JOIN product p
                ON d.product_id = p.product_id 
                WHERE dealer_id = '$dealer_id'");
                return $result;
                break;
            case "pohistory":
                // get the dealer's stock information
                $query2 = $this->Query("SELECT * FROM purchase_order WHERE  dealer_id = '{$dealer_id}' ORDER BY po_id DESC");
                $purchase_orders = array();

                if(mysqli_num_rows($query2) > 0){
                    while($row2 = mysqli_fetch_assoc($query2)){
                            
                            $sql = "SELECT pi.product_id AS product_id, pi.quantity AS quantity, pr.name AS name 
                                    FROM purchase_include pi 
                                    INNER JOIN product pr 
                                    ON pi.product_id = pr.product_id 
                                    WHERE pi.po_id = '{$row2['po_id']}'";
                            $result3 = $this->Query($sql);
                            $products = array();
                            if(mysqli_num_rows($result3)>0){
                                while($row3 = mysqli_fetch_assoc($result3)){
                                    array_push($products, $row3);
                                }
                                array_push($purchase_orders, ['purchase_order' => $row2, 'products' => $products]);
                            }
                    }
                }
                return $purchase_orders;
                break;
        }
    }//

    public function dealerOrders($dealer_id,$tab1,$tab2){
        $orders = array();
        $result = $this->read("reservation","dealer_id = $dealer_id and order_state = '$tab1' and collecting_method = '$tab2'","order_id ASC");
        while($order = mysqli_fetch_assoc($result)){
            $id = $order['order_id'];
            $products = array();
            $result2 = $this->read("reservation_include","order_id = $id");
            while($product = mysqli_fetch_assoc($result2)){
                array_push($products, $product);
            }
            array_push($orders, ['order'=>$order, 'products'=>$products]);
        }
        return $orders;
    }//
}