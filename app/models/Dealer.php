<?php
// session_start();
class Dealer extends Model
{
    // public $user_id;
    public function __construct()
    {
        parent::__construct();
        // $this->user_id = $_SESSION['user_id'];
    }

    // takes all the dealers
    public function getAllDealers(){ 
        $result = $this->Query("SELECT CONCAT(u.first_name,' ',u.last_name) AS name, u.email AS email, CONCAT(d.street,', ',d.city) AS address, d.contact_no AS contact FROM dealer d INNER JOIN users u ON d.dealer_id = u.user_id");
        $data['dealer'] = array();
        if(mysqli_num_rows($result)>0){
            $info = array();
            while($row = mysqli_fetch_assoc($result)){
                array_push($info,['name'=>$row['name'], 'email'=>$row['email'], 'address'=>$row['address'], 'contact'=>$row['contact']]);
            }
            $data['dealer'] = $info;
        }
        return $data['dealer'];
    }

    // prepare data for the dealer's signup form
    public function dealerSignupForm($company_id){
        $data['productresult'] = $this->read('product', 'company_id = '.$company_id);
        $data['distributorresult'] = $this->Query('SELECT * FROM users u INNER JOIN distributor d ON u.user_id = d.distributor_id AND d.company_id = '.$company_id.' ORDER BY d.city');
        return $data;
    }

    // get the details of the given dealer
    public function getDealer($dealer_id){
        $result = $this->Query("SELECT * FROM users u INNER JOIN dealer d ON u.user_id = d.dealer_id WHERE d.dealer_id = $dealer_id");
        return $result;
    }
    
    // takes all the products of the given company
    public function getProducts($company_id){
        $result = $this->read('product', 'company_id = '.$company_id);
        return $result;
    }
    
    // takes the information needed for the dealer's dashboard
    public function dashboard($dealer_id,$option){
        $data = [];
        // stock information
        $result = $this->Query("SELECT dealer_keep.quantity as quantity, product.name as name
        FROM dealer_keep INNER JOIN product 
        ON dealer_keep.product_id = product.product_id 
        WHERE dealer_id = '$dealer_id'");
        $data['stock'] = $result;

        // pending order information
        $orders = array();
        $sql = "SELECT r.order_id as order_id,r.customer_id as customer_id, CONCAT(u.first_name,' ',u.last_name) as customer_name 
                FROM reservation r
                INNER JOIN
                users u
                ON r.customer_id = u.user_id
                WHERE r.dealer_id = $dealer_id
                AND r.order_state = 'pending'";
        $result = $this->Query($sql);
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                $products = array();
                $order_id = $row['order_id'];
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

        // dispatched orders information
        $orders = array();
        $sql = "SELECT r.order_id as order_id,r.customer_id as customer_id,r.delivery_id as delivery_id, CONCAT(u.first_name,' ',u.last_name) as customer_name, CONCAT(u2.first_name,' ',u2.last_name) as delivery_name 
                FROM reservation r
                INNER JOIN
                users u
                ON r.customer_id = u.user_id
                INNER JOIN
                users u2
                ON r.delivery_id = u2.user_id
                WHERE r.dealer_id = $dealer_id
                AND r.order_state = 'dispatched'";
        $result = $this->Query($sql);
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                $products = array();
                $order_id = $row['order_id'];
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
        $data['dispatched'] = $orders;

        // variable data
        $today = date('Y-m-d');
        if($option == 'today'){
            $start_date = $today;
            $end_date = $today;
        }else{
            $start_date = date('Y-m-d', strtotime('-30 days'));
            $end_date = date('Y-m-d', strtotime('-1 days'));
        }
        $data['total_count'] = mysqli_num_rows($this->read("reservation","dealer_id = $dealer_id AND place_date >= '$start_date' AND place_date <= '$end_date'"));
        $data['pending_count'] = mysqli_num_rows($this->read("reservation","dealer_id = $dealer_id AND place_date <= '$today' AND order_state = 'pending'"));
        $data['canceled_count'] = mysqli_num_rows($this->read("reservation","dealer_id = $dealer_id AND place_date >= '$start_date' AND place_date <= '$end_date' AND order_state = 'canceled'"));
        $sql = "SELECT p.product_id, SUM(r.quantity) as quantity, p.name as name
        FROM reservation_include r INNER JOIN product p 
        ON r.product_id = p.product_id WHERE order_id IN 
            (SELECT order_id FROM reservation 
            WHERE place_date >= '$start_date' AND place_date <= '$end_date' AND dealer_id = $dealer_id AND order_state != 'Pending') 
        GROUP BY product_id";

        // chart details
        $products = $this->Query($sql);
        $chart['y'] = 'Sold Quantity';
        $chart['color'] = 'rgba(255, 159, 64, 0.5)';
        $chart['labels'] = array();$chart['vector'] = array();
        $products = $this->Query($sql);
        foreach($products as $product){
            array_push($chart['labels'],$product['name']);
            array_push($chart['vector'],$product['quantity']);
        }
        $data['chart'] = $chart;

        return $data;
    }

    // dealers purchase order place
    public function dealerpoplace($user_id,$productid, $postproducts){
        $data = [];
        $flag = false;
        $notvalidquantity = true;
        for($i=0; $i<count($productid); $i++){
            if($postproducts[$productid[$i]] != 0){ // check this.
                $notvalidquantity = false;
            };
        }
        if($notvalidquantity){
            $data['toast'] = ['type'=>"error", 'message'=>"Please insert a valid amount of products"];
            return $data;
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
            $result = $this->Query("SELECT * FROM purchase_order WHERE dealer_id = '{$user_id}' AND po_state = 'Pending'");
            if(mysqli_num_rows($result)>0){
                while($row = mysqli_fetch_assoc($result)){
                    $po_id = $row['po_id'];
                    $result2 = $this->Query("SELECT * FROM purchase_include WHERE po_id = '{$po_id}' AND product_id = '{$product}'");
                    while($row2 = mysqli_fetch_assoc($result2)){
                        $pending_stock += $row2['quantity'];
                    }
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
                echo $postproducts[$product].'<br>';
                echo $capacity.'<br>';
                echo $current_stock.'<br>';
                echo $pending_stock;
                $flag = true;
            }
            // post $productid <= capacity - current stock - pending stock
        }

        if($flag){
            // error handling needed.
            $data['toast'] = ['type'=>"error", 'message'=>"Insufficient storage"];
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

        
        $query3 = $this->Query("INSERT INTO purchase_order (dealer_id,po_state,distributor_id,place_date,place_time) VALUES ('{$user_id}','Pending','{$distributor_id}','{$place_date}','{$place_time}');");
        $query4 = $this->Query("SELECT * FROM purchase_order WHERE dealer_id = '{$user_id}' ORDER BY place_date DESC, place_time DESC LIMIT 1");
        $row4 = mysqli_fetch_assoc($query4);
        $po_id = $row4['po_id'];

        for($i=0; $i<count($productid); $i++){
            $product = $productid[$i];
            $quantity = $postproducts[$product];
            $query7 = $this->Query("SELECT unit_price FROM product WHERE product_id = '$product'");
            $row7 = mysqli_fetch_assoc($query7);
            $unit_price = $row7['unit_price'];
            if($quantity > 0){
                $query7 = $this->Query("INSERT INTO purchase_include (po_id, product_id, quantity, unit_price) VALUES ($po_id,'$product',$quantity,$unit_price)");
            }
            
        }

        // rendering the pdf report
        $result = $this->Query("SELECT * FROM purchase_order WHERE dealer_id = $user_id ORDER BY po_id DESC LIMIT 1");
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            $po_id = $row['po_id'];
            $date = $row['place_date'];
            $time = $row['place_time'];

            $products = array();
            $total = 0;

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
    }
    
    // takes the stock information of the given dealer
    public function dealerStock($dealer_id,$tab){
        switch($tab){
            case "currentstock":
                $result = $this->Query("SELECT p.product_id as product_id,p.name as product_name,p.image as image,
                p.weight as product_weight,p.unit_price as unit_price,d.quantity as quantity, d.reorder_flag as reorder_flag
                FROM product p INNER JOIN dealer_keep d ON p.product_id = d.product_id WHERE d.dealer_id = $dealer_id");
                return $result;
                break;
            case "purchaseorder":
                $result = $this->Query("SELECT d.product_id as product_id, p.name as name, p.unit_price as unit_price, p.image as image
                FROM dealer_capacity d INNER JOIN product p
                ON d.product_id = p.product_id 
                WHERE dealer_id = '$dealer_id'");
                return $result;
                break;
            case "pohistory":
                // get the dealer's stock information
                $query2 = $this->Query("SELECT * FROM purchase_order WHERE  dealer_id = '{$dealer_id}' ORDER BY CASE po_state
                WHEN 'pending' THEN 1
                WHEN 'accepted' THEN 2
                WHEN 'completed' THEN 3
                ELSE 4
              END, po_id DESC");
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
    } 
 
    // add the customer order information to reservation and reservation_includes
    public function addtoReservation($customer_id,$dealer_id,$products,$payment_method,$stock_verification,$place_date,$place_time){
        if($payment_method == 'Credit card'){
            $payment_verification = 'verified';
        }else{
            $payment_verification = 'pending';
        }
        // placing the reservation then
        $record = ['customer_id'=>$customer_id,'order_state'=>'Pending', 'stock_verification'=>$stock_verification,'payment_method'=>$payment_method, 'payment_verification'=>$payment_verification,'place_date'=>$place_date,'place_time'=>$place_time,'dealer_id'=>$dealer_id];
        $this->insert('reservation',$record);

        // taking the order_id
        $row = mysqli_fetch_assoc($this->read('reservation',"customer_id = $customer_id AND dealer_id = $dealer_id AND place_date = '$place_date' AND place_time = '$place_time'"));
        $order_id = $row['order_id'];
        
        // put them into the reservation include table
        foreach($products as $product){
            $this->insert('reservation_include',['order_id'=>$order_id, 'product_id'=>$product['product_id'], 'quantity'=>$product['qty'], 'unit_price'=>$product['unit_price']]);
        }

        // order information
        $order = mysqli_fetch_assoc($this->read('reservation',"order_id = $order_id"));
        // customer information
        $customer = mysqli_fetch_assoc($this->read('users',"user_id = $customer_id"));
        
        // sending email notification
        $mailbody = '';
        // get template
        if(strtoupper($order['order_state']) == 'ACCEPTED' && strtoupper($order['collecting_method']) == 'DELIVERY'){
            $mailbody = file_get_contents('./emailTemplates/orderaccepteddelivery.php');
            $state = "accepted";
        }elseif(strtoupper($order['order_state']) == 'ACCEPTED' && strtoupper($order['collecting_method']) == 'PICKUP'){
            $mailbody = file_get_contents('./emailTemplates/orderacceptedpickup.php');
            $state = "accepted";
        }else{
            $state = "placed";
            $mailbody = file_get_contents('./emailTemplates/orderplaced.php');
        }
        // prepare replacements
        $swap_reorder = array(
            "{RECIEVER_NAME}"=> $customer['first_name'].' '.$customer['last_name'],
            "{ORDER_ID}"=> $order_id,
            "{ORDER_LINK}"=> BASEURL.'/orders/customer_myreservation/'.$order_id
        );
        // replace
        foreach(array_keys($swap_reorder) as $key){
            if(strlen($key) > 2 && trim($key) != ""){
                $mailbody = str_replace($key,$swap_reorder[$key],$mailbody);
            }
        }
        // create mail instance
        $mail = new Mail('admin@gasify.com',$customer['email'],$customer['first_name'].' '.$customer['last_name'],"Gasify: Your order has been $state!",$mailbody,$link=null);
        $mail->send();
        return $order_id;
    }

    // handle the customer order by taking session information
    public function customerOrder($customer_id,$dealer_id,$products,$payment_method){
        //collecting previouse reorder flags before updating the dealer keep table
        $prev_flags;
        foreach($products as $product){
            $product_id = $product['product_id'];
            $row = mysqli_fetch_assoc($this->read('dealer_keep',"dealer_id = $dealer_id AND product_id = $product_id"));
            $prev_flags[$product_id] = $row['reorder_flag'];
        }

        date_default_timezone_set("Asia/Colombo");
        $place_date = date('Y-m-d');
        $place_time = date('H:i:s');

        //checking payment method
        if($payment_method == 'Credit card'){
            //checking the availability of the stock
            $ok = true; $stock_ok_flag = 0;
            foreach($products as $product){
                $product_id = $product['product_id'];
                $row = mysqli_fetch_assoc($this->read('dealer_keep',"dealer_id = $dealer_id AND product_id = $product_id"));
                if($product['qty'] > $row['quantity']){
                    $ok = false;
                    break;
                }
            }

            if($ok){
                // order accepted automatically
                $stock_ok_flag = 1;

                // immediately reducing the stock of the dealer first
                foreach($products as $product){
                    $qty = $product['qty'];
                    $product_id = $product['product_id'];
                    $sql = "UPDATE dealer_keep SET quantity = quantity - $qty WHERE dealer_id = $dealer_id AND product_id = $product_id";
                    $this->Query($sql);
                }

                // checking the reorder flags again
                $risk_products = array();
                foreach($products as $product){
                    $product_id = $product['product_id'];
                    $row = mysqli_fetch_assoc($this->read('dealer_keep',"dealer_id = $dealer_id AND product_id = $product_id"));
                    if($prev_flags[$product_id] == 0 && $row['reorder_flag'] == 1){
                        array_push($risk_products,[$product_id => '']);
                    }
                }

                // send notifications on risk products
                if(count($risk_products) > 0){
                    foreach($risk_products as $product_id => $value){
                        $row = mysqli_fetch_assoc($this->read('product',"product_id = $product_id"));
                        $risk_products[$product_id] = $row['name'];
                    }

                    $message = "Hey seems like you have a low stock on the following products :";
                    $mailproducts = "";
                    foreach($risk_products as $product_id => $value){
                        // take product image, ro-level, current stock
                        $sql = "SELECT p.image AS image, dk.reorder_level AS threshold, dk.quantity AS quantity FROM dealer_keep dk INNER JOIN product p ON dk.product_id = p.product_id WHERE dk.dealer_id = $dealer_id AND dk.product_id = $product_id";
                        $prow = mysqli_fetch_assoc($this->Query($sql));
                        // prepare replacements
                        $swap_products = array(
                            "{PRODUCT_IMG}"=>$prow['image'], 
                            "{THRESHOLD}"=>$prow['threshold'],
                            "{CURRENT_STOCK}"=>$prow['quantity']);
                        $prow = file_get_contents('./emailTemplates/reorderproduct.php');
                        // replace
                        foreach(array_keys($swap_products) as $key){
                            if(strlen($key) > 2 && trim($key) != ""){
                                $prow = str_replace($key,$swap_products[$key],$prow);
                            }
                        }
                        $message .= " $value,";
                        $mailproducts .= $prow;
                    }
                    $message = rtrim($message,',');
                    $message .= " please hurry up and place a purchase order. Otherwise you will not be having enough stock to sell.";
                    $this->insert('notifications',['user_id' => $dealer_id, 'date'=>$place_date, 'time'=>$place_time, 'type'=> 'Re-order Level Alert', 'message' => $message, 'state'=>'delivered']);
                    
                    // send a mail as well
                    $q = mysqli_fetch_assoc($this->read('users',"user_id = $dealer_id"));
                    // prepare replacements
                    $swap_reorder = array(
                        "{RECIEVER_NAME}"=> $q['first_name'].' '.$q['last_name'],
                        "{STOCK_LINK}"=> BASERURL.'/stock/dealer/currentstock',
                        "{PRODUCT_DETAILS}"=>$mailproducts
                    );
                    // template
                    $mailbody = file_get_contents('./emailTemplates/reorderlevel.php');
                    // replace
                    foreach(array_keys($swap_reorder) as $key){
                        if(strlen($key) > 2 && trim($key) != ""){
                            $mailbody = str_replace($key,$swap_reorder[$key],$mailbody);
                        }
                    }

                    $mail = new Mail('admin@gasify.com',$q['email'],$q['first_name'].' '.$q['last_name'],'Gasify: Re-Order Alert',$mailbody,$link=null);
                    $mail->send();
                }

                // placing the reservation then
                return $this->addtoReservation($customer_id,$dealer_id,$products,$payment_method,$stock_ok_flag,$place_date,$place_time);
                
                
            }else{
                // order is pending due to low stock but place the reservation
                return $this->addtoReservation($customer_id,$dealer_id,$products,$payment_method,0,$place_date,$place_time);
                // should handle the reduction of stock when the dealer gets a new stock
                // consider customer orders on fcfs
            }
        }else{
            // payment method payslip
            //checking the availability of the stock
            $ok = true; $stock_ok_flag = 0;
            foreach($products as $product){
                $product_id = $product['product_id'];
                $row = mysqli_fetch_assoc($this->read('dealer_keep',"dealer_id = $dealer_id AND product_id = $product_id"));
                if($product['qty'] > $row['quantity']){
                    $ok = false;
                    break;
                }
            }

            if($ok){
                // order accepted automatically
                $stock_ok_flag = 1;

                // immediately reducing the stock of the dealer first
                foreach($products as $product){
                    $qty = $product['qty'];
                    $product_id = $product['product_id'];
                    $sql = "UPDATE dealer_keep SET quantity = quantity - $qty WHERE dealer_id = $dealer_id AND product_id = $product_id";
                    $this->Query($sql);
                }

                // checking the reorder flags again
                $risk_products = array();
                foreach($products as $product){
                    $product_id = $product['product_id'];
                    $row = mysqli_fetch_assoc($this->read('dealer_keep',"dealer_id = $dealer_id AND product_id = $product_id"));
                    if($prev_flags[$product_id] == 0 && $row['reorder_flag'] == 1){
                        array_push($risk_products,[$product_id => '']);
                    }
                }

                // send notifications on risk products
                if(count($risk_products) > 0){
                    foreach($risk_products as $product_id => $value){
                        $row = mysqli_fetch_assoc($this->read('product',"product_id = $product_id"));
                        $risk_products[$product_id] = $row['name'];
                    }

                    $message = "Hey seems like you have a low stock on the following products :";
                    $mailproducts = "";
                    foreach($risk_products as $product_id => $value){
                        // take product image, ro-level, current stock
                        $sql = "SELECT p.image AS image, dk.reorder_level AS threshold, dk.quantity AS quantity FROM dealer_keep dk INNER JOIN product p ON dk.product_id = p.product_id WHERE dk.dealer_id = $dealer_id AND dk.product_id = $product_id";
                        $prow = mysqli_fetch_assoc($this->Query($sql));
                        // prepare replacements
                        $swap_products = array(
                            "{PRODUCT_IMG}"=>$prow['image'], 
                            "{THRESHOLD}"=>$prow['threshold'],
                            "{CURRENT_STOCK}"=>$prow['quantity']);
                        $prow = file_get_contents('./emailTemplates/reorderproduct.php');
                        // replace
                        foreach(array_keys($swap_products) as $key){
                            if(strlen($key) > 2 && trim($key) != ""){
                                $prow = str_replace($key,$swap_products[$key],$prow);
                            }
                        }
                        $message .= " $value,";
                        $mailproducts .= $prow;
                    }
                    $message = rtrim($message,',');
                    $message .= " please hurry up and place a purchase order. Otherwise you will not be having enough stock to sell.";
                    $this->insert('notifications',['user_id' => $dealer_id, 'date'=>$place_date, 'time'=>$place_time, 'type'=> 'Re-order Level Alert', 'message' => $message, 'state'=>'delivered']);
                    
                    // send a mail as well
                    $q = mysqli_fetch_assoc($this->read('users',"user_id = $dealer_id"));
                    // prepare replacements
                    $swap_reorder = array(
                        "{RECIEVER_NAME}"=> $q['first_name'].' '.$q['last_name'],
                        "{STOCK_LINK}"=> BASERURL.'/stock/dealer/currentstock',
                        "{PRODUCT_DETAILS}"=>$mailproducts
                    );
                    // template
                    $mailbody = file_get_contents('./emailTemplates/reorderlevel.php');
                    // replace
                    foreach(array_keys($swap_reorder) as $key){
                        if(strlen($key) > 2 && trim($key) != ""){
                            $mailbody = str_replace($key,$swap_reorder[$key],$mailbody);
                        }
                    }

                    $mail = new Mail('admin@gasify.com',$q['email'],$q['first_name'].' '.$q['last_name'],'Gasify: Re-Order Alert',$mailbody,$link=null);
                    $mail->send();
                }

            }
            // placing the reservation payslip need to verify by admin
            $order_id = $this->addtoReservation($customer_id,$dealer_id,$products,$payment_method,$stock_ok_flag,$place_date,$place_time);
            // should handle the reduction of stock when the dealer gets a new stock
            // consider customer orders on fcfs
            
            // update and upload the payslip
            $payslip = $_SESSION['slip_img'];
            $path = getcwd().DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPERATOR.'payslips'.DIRECTORY_SEPARATOR;
            $image = getImageRename($payslip['file_name'],$payslip['temp_name']);
            if(move_uploaded_file($payslip['temp_name'], $path.($image))){
                $this->update('reservation',['pay_slip'=>$image],"order_id = $order_id");
            }
            return $order_id;

        }
    } 

    // takes 6 types of orders (Pending,Accepted,Dispatched,Delivered,Completed,Canceled)
    public function dealerOrders($dealer_id,$tab1,$tab2){
        $tab1 = ucwords($tab1);
        $orders = array();
        $result;

        $sql = "SELECT 
        r.order_id AS order_id,
        r.customer_id AS customer_id,
        r.order_state AS order_state,
        r.payment_method AS payment_method,
        r.pay_slip AS pay_slip,
        r.payment_verification AS payment_verification,
        r.stock_verification AS stock_verification,
        r.collecting_method AS collecting_method,
        r.priority AS priority,
        r.mailed AS mailed,
        r.place_date AS place_date,
        r.place_time AS place_time,
        r.accepted_date AS accepted_date,
        r.accepted_time AS accepted_time,
        r.dealer_id AS dealer_id,
        r.bank AS bank,
        r.acc_no AS acc_no,
        r.refund_date AS refund_date,
        r.refund_time AS refund_time,
        r.refund_verification AS refund_verification,
        r.delivery_id AS delivery_id,
        r.deliver_date AS deliver_date,
        r.deliver_time AS deliver_time,
        r.deliver_charge AS deliver_charge,
        r.cancel_date AS cancel_date,
        u.first_name AS first_name,
        u.last_name AS last_name,
        u.type AS type,
        d.first_name AS delivery_first_name,
        d.last_name AS delivery_last_name
        FROM reservation r INNER JOIN users u
        ON r.customer_id = u.user_id
        LEFT JOIN users d
        ON r.delivery_id = d.user_id
        WHERE r.dealer_id = $dealer_id AND r.order_state = '$tab1'"; 
        if($tab2 != null){
            $sql .= "AND collecting_method = '$tab2'";
        }
        $sql .= " ORDER BY r.order_id ASC";
        $result = $this->Query($sql);

        while($order = mysqli_fetch_assoc($result)){
            $total_amount = 0;
            $id = $order['order_id'];
            $products = array();
            $result2 = $this->Query("SELECT p.product_id AS product_id,
            p.name AS name,
            r.unit_price AS unit_price,
            r.quantity AS quantity FROM reservation_include r INNER JOIN product p ON r.product_id = p.product_id WHERE r.order_id = $id");
            $stockverification = 'available';
            while($product = mysqli_fetch_assoc($result2)){
                // to check the stock availability
                $productid = $product['product_id'];
                $result3 = $this->read('dealer_keep',"dealer_id = $dealer_id and product_id = $productid");
                if($result3){
                    $row = mysqli_fetch_assoc($result3);
                    if($row['quantity'] < $product['quantity']){
                        $stockverification = 'notavailable';
                    }
                }
                array_push($products, $product);
                $total_amount += $product['unit_price']*$product['quantity'];
            }

            if($order['stock_verification'] == 1){
                $stockverification = 'available';
            }else{
                $stockverification = 'notavailable';
            }


            // get the reviews for the order
            $reviews = $this->read('review',"order_id = $id AND review_type = 'Dealer'","date DESC, time DESC");
            array_push($orders, ['order'=>$order, 'products'=>$products, 'reviews'=>$reviews, 'payment'=>$order['payment_verification'], 'stock'=>$stockverification, 'total_amount'=>$total_amount]);
        }
        return $orders;
    }

    // notify the customer when order is issued via an Email
    public function dealerNofifycustomer($order_id,$dealer_id,$state){
        // sendig email updates
        $row1 = mysqli_fetch_assoc($this->read('reservation',"order_id = $order_id"));
        $row2 = mysqli_fetch_assoc($this->read('dealer',"dealer_id = $dealer_id"));
        $dealername = $row2['name'];

        $customer_id = $row1['customer_id'];
        $row3 = mysqli_fetch_assoc($this->read('users',"user_id = $customer_id"));
        $row4 = mysqli_fetch_assoc($this->read('customer',"customer_id = $customer_id"));
        $reciepName = $row3['first_name'].' '.$row3['last_name'];
        $from = 'admin@gasify.com';
        $to = $row3['email'];
        $subject = "Gasify: Your order has been $state!";
        if($row1['collecting_method'] == 'Delivery'){
            if($state == 'accepted'){
                $message = "Your recent order at $dealername has been accepted by the dealer and waiting for a delivery. Please stay standby";
            }else if($state == 'completed'){
                $message = "Your recent order at $dealername has been completed. Hope you are satisfy with our service. Thank you for shopping. Stay with us";
            }
        }else{
            if($state == 'accepted'){
                $message = "Your recent order at $dealername has been accepted by the dealer and waiting to be collected. Please visit the store to collect your order.";
            }else if($state == 'completed'){
                $message = "Your recent order at $dealername has been completed. Hope you are satisfy with our service. Thank you for shopping. Stay with us";
            }
        }
        // get template
        $mailbody = file_get_contents('./emailTemplates/orderdelivered.php');
        // prepare replacements
        $swap_reorder = array(
            "{RECIEVER_NAME}"=> $reciepName,
            "{ORDER_ID}"=> $order_id,
            "{ORDER_LINK}"=> BASEURL.'/orders/confirmCompleteOrder/'.$order_id
        );
        // replace
        foreach(array_keys($swap_reorder) as $key){
            if(strlen($key) > 2 && trim($key) != ""){
                $mailbody = str_replace($key,$swap_reorder[$key],$mailbody);
            }
        }
        //Create an instance; passing `true` enables exceptions
        $mail = new Mail($from,$to,$reciepName,$subject,$mailbody);
        $data = $mail->send();

        date_default_timezone_set("Asia/Colombo");
        $time = date('H:i');
        $date = date('Y-m-d');
        // sending notification now done by the trigger
        // $this->insert('notifications',['user_id' => $customer_id,'date'=> $date,'time'=> $time,'type' => 'Order Status','message' => $message,'state' => 'delivered']);
    }

    // updated system never use this. the order acceptance was automated
    public function dealerAcceptOrder($order_id){
        $user_id = $_SESSION['user_id'];
        $result = $this->read('reservation_include',"order_id = $order_id");
        while($row = mysqli_fetch_assoc($result)){
            $product_id = $row['product_id'];
            $product_quantity = $row['quantity'];
            $this->Query("UPDATE dealer_keep SET quantity = quantity - $product_quantity WHERE product_id = $product_id AND dealer_id = $dealer_id");
        }
        $this->update('reservation',['order_state' => 'Accepted'],"order_id = $order_id");
        $this->dealerNofifycustomer($order_id,$user_id,'accepted');
        
    } 

    // Dealer issuing a pickup or a prioritized delivery type order
    public function dealerIssueOrder($order_id){
        $user_id = $_SESSION['user_id'];
        $this->update('reservation',['order_state' => "Delivered"],"order_id = $order_id");
        $this->dealerNofifycustomer($order_id,$user_id,'completed');
    } 

    // Refunding payment slip submit
    public function dealersubmitpayslipOrder($order_id){
        $image_name = '';$tmp_name = '';
        if(isset($_FILES['payslip']['size']) && $_FILES['payslip']['size'] > 0){ 
            $image_name = $_FILES['payslip']['name'];
            $tmp_name = $_FILES['payslip']['tmp_name'];
        }
        $image = getImageRename($image_name,$tmp_name);
        $path = getcwd().DIRECTORY_SEPARATOR.'img'.DIRECTORY_SEPERATOR.'payslips'.DIRECTORY_SEPARATOR;
        if(move_uploaded_file($tmp_name, $path.($image))){
            $this->update('reservation',['refund_verification'=>'pending','refund_payslip'=>"$image"],"order_id = $order_id");
            $data['toast'] = ['type'=>'success', 'message'=>'You have successfully uploaded payslip for verification'];
        }else{
            $data['toast'] = ['type'=>'error', 'message'=>'couldn\'t upload, try again'];
        }
        return $data;
    } 

    // shows old po details
    public function dealerpoinfo($poid){
        $sql = "SELECT pi.product_id AS product_id, pi.quantity AS quantity, pr.name AS name ,pi.unit_price AS unit_price,pr.weight AS weight,pr.image AS image
                    FROM purchase_include pi 
                    INNER JOIN product pr 
                    ON pi.product_id = pr.product_id 
                    WHERE pi.po_id = $poid";
        $result = $this->Query($sql);
        $total = 0;
        $products = array();
        if(mysqli_num_rows($result)>0){
            while($row = mysqli_fetch_assoc($result)){
                array_push($products, $row);
                $total += $row['quantity']*$row['unit_price'];
            }
        }
        $data['products'] = $products;
        $data['total'] = $total;
        return $data;
    } 

    // takes the delivery perople within the city and the associations
    public function getdeliverypeople($option,$user_id){
        $row = mysqli_fetch_assoc($this->read('dealer','dealer_id = '.$user_id));
        $city = $row['city'];
        if($option = 'all'){
            $sql = "SELECT u.first_name AS first_name,
            u.last_name AS last_name,
            de.image AS image,
            u.user_id AS user_id,
            de.contact_no AS contact_no
            FROM delivery_person de INNER JOIN users u
            ON de.delivery_id = u.user_id
            WHERE de.city = '$city'";
        }else{
            $sql = "SELECT u.first_name AS first_name,
            u.last_name AS last_name,
            de.image AS image,
            u.user_id AS user_id,
            de.contact_no AS contact_no
            FROM delivery_person de INNER JOIN users u
            ON de.delivery_id = u.user_id
            WHERE de.delivery_id IN 
            (SELECT delivery_id FROM reservation WHERE dealer_id = $user_id AND order_state = 'Dispatched')";
        }
        $data['query'] = $this->Query($sql);
        return $data;
    } 

    // get dealer's analysis information
    public function getanalysis($user_id,$start_date,$end_date){
        if($start_date == null){
            $row = mysqli_fetch_assoc($this->read('users',"user_id = $user_id"));
            $start_date = $row['date_joined'];
        }

        $data['charts'] = array();
        //chart 1
        $products = array();
        $query1 = $this->read('dealer_capacity',"dealer_id = $user_id");
        while($row = mysqli_fetch_assoc($query1)){
            $products[$row['product_id']] = 0;
        }
        $query1 = $this->read('reservation',
        "dealer_id = $user_id AND place_date >= '$start_date' AND place_date <= '$end_date' AND (order_state != 'pending' AND order_state != 'canceled')");
        while($row = mysqli_fetch_assoc($query1)){
            $order_id = $row['order_id'];
            $query2 = $this->read('reservation_include',"order_id = $order_id");
            while($row2 = mysqli_fetch_assoc($query2)){
                $products[$row2['product_id']] += $row2['quantity'];
            }
        }
        $chart['labels'] = array();
        $chart['vector'] = array();
        foreach($products as $id => $quantity){
            $row = mysqli_fetch_assoc($this->read('product',"product_id = $id"));
            array_push($chart['labels'], $row['name']);
            array_push($chart['vector'], $quantity);
        }
        $chart['type'] = 'bar';
        $chart['main'] = 'Based on Product';
        $chart['y'] = 'Number of sold items';
        $chart['color'] = 'rgba(245, 215, 39, 0.8)';
        array_push($data['charts'],$chart);

        //chart 2,3
        $days = array("Mon"=>0,"Tue"=>0,"Wed"=>0,"Thu"=>0,"Fri"=>0,"Sat"=>0,"Sun"=>0);
        $deliverymode = array("Delivery"=>0,"Pickup"=>0);
        $query1 = $this->read('reservation',
        "dealer_id = $user_id AND place_date >= '$start_date' AND place_date <= '$end_date' AND (order_state != 'pending' AND order_state != 'canceled')");
        while($row = mysqli_fetch_assoc($query1)){
            $day = date('D', strtotime($row['place_date']));
            $days[$day]++;
            $deliverymode[$row['collecting_method']]++;
        }
        $chart['type'] = 'line';
        $chart['labels'] = array_keys($days);
        $chart['vector'] = array_values($days);
        $chart['main'] = 'Based on the day';
        $chart['y'] = 'Number of Orders';
        $chart['color'] = 'rgba(242, 71, 235, 0.8)';
        array_push($data['charts'],$chart);

        //chart 3
        $chart['type'] = 'doughnut';
        $chart['labels'] = array_keys($deliverymode);
        $chart['vector'] = array_values($deliverymode);
        $chart['main'] = 'Based on Collecting Method';
        $chart['y'] = 'Number of orders';
        $chart['color'] = '[
            "rgb(255, 99, 132)",
            "rgb(54, 162, 235)",
            "rgb(54, 122, 15)"
            ]';
        array_push($data['charts'],$chart);

        //chart 4
        $usertype = array("Domestic"=>0, "CommercialLarge"=>0, "CommercialSmall"=>0);
        $query1 = $this->read('reservation',
        "dealer_id = $user_id AND place_date >= '$start_date' AND place_date <= '$end_date' AND (order_state != 'pending' OR order_state != 'canceled')");
        while($row = mysqli_fetch_assoc($query1)){
            $customer_id = $row['customer_id'];
            $row2 = mysqli_fetch_assoc($this->read('customer',"customer_id = $customer_id"));
            $usertype[$row2['type']]++;
        }
        $chart['type'] = 'bar';
        $chart['labels'] = array_keys($usertype);
        $chart['vector'] = array_values($usertype);
        $chart['main'] = 'Based on Customer Type';
        $chart['y'] = 'Number of Orders';
        $chart['color'] = 'rgba(48, 39, 245, 0.8)';
        array_push($data['charts'],$chart);
        
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        return $data;
    } 

    // Dealer's sales report information
    public function getReportInfo($start_date,$end_date,$order_by){
        $user_id = $_SESSION["user_id"];
        if($start_date == null){
            $row = mysqli_fetch_assoc($this->read('users',"user_id = $user_id"));
            $start_date = $row['date_joined'];
        }
        $productsquantity = array();
        $productsearnings = array();
        $query1 = $this->read('reservation',
        "dealer_id = $user_id AND place_date >= '$start_date' AND place_date <= '$end_date' AND (order_state != 'pending' OR order_state != 'canceled')");
        while($row = mysqli_fetch_assoc($query1)){
            $order_id = $row["order_id"];
            $query2 = $this->read('reservation_include',"order_id = $order_id");
            while($row2 = mysqli_fetch_assoc($query2)){
                if(isset($productsquantity[$row2['product_id']])){
                    $productsquantity[$row2['product_id']] += $row2['quantity'];
                    $productsearnings[$row2['product_id']] += $row2['unit_price']*$row2['quantity'];
                }else{
                    $productsquantity[$row2['product_id']] = $row2['quantity'];
                    $productsearnings[$row2['product_id']] = $row2['unit_price']*$row2['quantity'];
                }
            }
        }

        $percentage = array();
        if($order_by == 'soldquantity'){
            $total = 0;
            foreach($productsquantity as $key => $value){
                $total += $value;
            }
            foreach($productsquantity as $key => $value){
                $percentage[$key] = round(($value/$total)*100, 2);
            }
        }else{
            $total = 0;
            foreach($productsearnings as $key => $value){
                $total += $value;
            }
            foreach($productsearnings as $key => $value){
                $percentage[$key] = round(($value/$total)*100, 2);
            }
        }

        $tabledata = array();
        foreach($productsquantity as $key => $value){
            $row = mysqli_fetch_assoc($this->read('product',"product_id = $key"));
            array_push($tabledata,['id'=>$key,'image'=>$row['image'],'name'=>$row['name'],'sold_quantity'=>$value,'total_earnings'=>$productsearnings[$key],'percentage'=>$percentage[$key]]);
        }
        usort($tabledata,'cmp');
        $data['tabledata'] = $tabledata;
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['filter'] = $order_by;
        return $data;
    } 

    // accepted orders which not being picked by a delivery person having a latency of 30 or more
    // customers gets an email to change to pickup or double the price and deliver or stay same
    public function sendMailonLateDelivery(){
        date_default_timezone_set("Asia/Colombo");

        $query1 = $this->read('reservation',"order_state = 'Accepted' AND collecting_method = 'Delivery' AND mailed = 0");
        while($row1 = mysqli_fetch_assoc($query1)){
            $date = $row1['accepted_date'];
            $time = $row1['accepted_time'];
            $accepted_time = strtotime($date.' '.$time);
            $current_time = time();
            $difference = round(($current_time - $accepted_time)/60);

            if($difference > DELIVERY_DELAY_TIME){
                // then send an email
                $customer = mysqli_fetch_assoc($this->read('users',"user_id = ".$row1['customer_id']));
                $from = 'admin@gasify.com';
                $to = $customer['email'];
                $reciepName = $customer['first_name'].' '.$customer['last_name'];
                $subject = "Gasify: Your order might get delayed";
                $mailbody = file_get_contents('./emailTemplates/changecolmethod.php');

                // prepare replacements
                $swap_variables = array(
                    "{RECEIVER_NAME}"=> $reciepName,
                    "{ORDER_ID}"=> $row1['order_id'],
                    "{CURRENT_DELIVERY_CHARGE}" => $row1['deliver_charge'],
                    "{SWITCH_TO_PICKUP}"=> BASEURL.'/orders/actiontodelay/switch/'.$row1['order_id'],
                    "{DOUBLE_AND_DELIVER}"=> BASEURL.'/orders/actiontodelay/double/'.$row1['order_id'],
                    "{WAIT}"=> BASEURL.'/orders/actiontodelay/wait/'.$row1['order_id']
                );
                // replace
                foreach(array_keys($swap_variables) as $key){
                    if(strlen($key) > 2 && trim($key) != ""){
                        $mailbody = str_replace($key,$swap_variables[$key],$mailbody);
                    }
                }

                $mail = new Mail($from,$to,$reciepName,$subject,$mailbody,$link=null);
                $data = $mail->send();
                $toast = $data['toast'];
                if($toast['type'] == 'success'){
                    // update the mailed to 1
                    $this->update('reservation',['mailed'=>1],"order_id = ".$row1['order_id']);
                }
            }
        }

        return 1;
    } 

    // perform the acction taken by the customer on the order for delivery latency
    public function actiontodelay($mode,$order_id){
        $data = [];
        $query = $this->read('reservation',"order_id = $order_id AND responded_to_mail = 0");
        if(mysqli_num_rows($query) > 0){
            if(strtoupper($mode) == 'SWITCH'){
                $this->update('reservation',['collecting_method'=>'Pickup','deliver_charge'=>0],"order_id = ".$order_id);
            }elseif(strtoupper($mode) == 'DOUBLE'){
                $order = mysqli_fetch_assoc($this->read('reservation',"order_id = ".$order_id));
                $newcharge = $order['deliver_charge']*2;
                $this->update('reservation',['priority'=>1,'deliver_charge'=>$newcharge],"order_id = ".$order_id);
            }
            $data['error'] = '2';
            $this->update('reservation',['responded_to_mail'=>1],"order_id = $order_id");
        }else{
            $data['error'] = '3';
        }
        return $data;
    }

    // describes first come first serve order acceptance when the po receives
    public function fcfsonPOcomplete($distribution_id){
        // take dealer information
        $dealer = mysqli_fetch_assoc($this->read('purchase_order',"po_id = ".$distribution_id));
        $dealer_id = $dealer['dealer_id'];
        // take order information
        $query = $this->read('reservation',"dealer_id = $dealer_id AND stock_verification = 0","place_date ASC, place_time ASC");
        while($row = mysqli_fetch_assoc($query)){
            // take the order includes
            $query2 = $this->read('reservation_include',"order_id = ".$row['order_id']);
            $flag = true; // assuming the order can be accept
            while($row2 = mysqli_fetch_assoc($query2)){
                $query3 = $this->read('dealer_keep',"dealer_id = $dealer_id AND product_id = ".$row2['product_id']);
                if(mysqli_num_rows($query3) > 0){
                    $row3 = mysqli_fetch_assoc($query3);
                    if($row2['quantity'] > $row3['quantity']){
                        // not having enough stock for the order
                        $flag = false;
                    }
                }else{
                    // no stock at all
                    $flag = false;
                }
            }

            // check if order actually can be processed
            if($flag){
                $query2 = $this->read('reservation_include',"order_id = ".$row['order_id']);
                while($row2 = mysqli_fetch_assoc($query2)){
                    $query3 = $this->read('dealer_keep',"dealer_id = $dealer_id AND product_id = ".$row2['product_id']);
                    if(mysqli_num_rows($query3) > 0){
                        $row3 = mysqli_fetch_assoc($query3);
                        $this->update('dealer_keep',['quantity'=>$row3['quantity']-$row2['quantity']],"dealer_id = $dealer_id AND product_id = ".$row2['product_id']);
                    }
                }

                // then change that order's stock_verification to 1
                $this->update('reservation',['stock_verification'=>1],"order_id = ".$row['order_id']);
                $verifyacceptance = mysqli_fetch_assoc($this->read('reservation',"order_id = ".$row['order_id']));
                if(strtoupper($verifyacceptance['order_state']) == 'ACCEPTED') {
                    // then send a mail to the customer
                    $user_id = $verifyacceptance['customer_id'];
                    $customer = mysqli_fetch_assoc($this->read('users',"user_id = $user_id"));
                    $user_name = $customer['first_name'].' '.$customer['last_name'];
                    $subject = "Gasify: Order has been accpeted!";
                    // get template
                    if(strtoupper($verifyacceptance['collecting_method']) == 'PICKUP'){
                        $mailbody = file_get_contents('./emailTemplates/orderacceptedpickup.php');
                    }else{
                        $mailbody = file_get_contents('./emailTemplates/orderaccepteddelivery.php');
                    }
                    // prepare replacements
                    $swap_variables = array(
                        "{RECIEVER_NAME}"=> $user_name,
                        "{ORDER_ID}"=> $order_id,
                        "{ORDER_LINK}"=> BASEURL.'/orders/customer_myreservation/'.$order_id
                    );
                    // replace
                    foreach(array_keys($swap_variables) as $key){
                        if(strlen($key) > 2 && trim($key) != ""){
                            $mailbody = str_replace($key,$swap_variables[$key],$mailbody);
                        }
                    }
                    $mail = new Mail('admin@gasify.com',$customer['email'],$user_name,$subject,$mailbody,$link=null);
                    $mail->send();
                }
                
            }
        }
    }

}

function cmp($a, $b) {
    return $b['percentage'] - $a['percentage'];
}