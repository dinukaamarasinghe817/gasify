<?php

class Distributor extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    // get all distributors from user table
    public function getAllDistributors(){  
        $result = $this->Query("SELECT CONCAT(u.first_name,' ',u.last_name) AS name, u.email AS email, CONCAT(d.street,', ',d.city) AS address, d.contact_no AS contact FROM distributor d INNER JOIN users u ON d.distributor_id = u.user_id");
        $data['distributor'] = array();
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
        $result = $this->Query("SELECT * FROM users u INNER JOIN distributor d ON u.user_id = d.distributor_id WHERE u.user_id = $distributor_id");
        return $result;
    }


    public function dashboard($distributor_id,$option){
        $data = [];

        // date break down
        $today = date('Y-m-d');
            if($option == 'today'){
                $start_date = $today;
                $end_date = $today;
            }else{
                $start_date = date('Y-m-d', strtotime('-30 days'));
                $end_date = date('Y-m-d', strtotime('-1 days'));
            }

            // chart => get quantities of each products in completed gas distributions
            $sql = "SELECT p.product_id, SUM(pi.quantity) as quantity, p.name as name
            FROM purchase_include pi INNER JOIN product p 
            ON pi.product_id = p.product_id WHERE po_id IN 
                (SELECT po_id FROM purchase_order 
                WHERE place_date >= '$start_date' AND place_date <= '$end_date' AND distributor_id = $distributor_id AND po_state != 'pending') 
                GROUP BY product_id";

            //chart details
            $products = $this->Query($sql);
            $chart['y'] = 'Distributed Quantity';
            $chart['color'] = 'rgba(255, 159, 64, 0.5)';
            $chart['labels'] = array();$chart['vector'] = array();
            //$products = $this->Query($sql);
            while($product = mysqli_fetch_assoc($products)){
                array_push($chart['labels'],$product['name']);
                array_push($chart['vector'],$product['quantity']);
            }
            return $chart;
    }
    
    public function getVehicleInfo($distributor_id){
        $sql = "SELECT p.name AS name, p.product_id AS product_id FROM distributor_capacity d inner join product p on d.product_id=p.product_id where d.distributor_id = '{$distributor_id}'";
        $result = $this->Query($sql);
        return $result;
    }

    // get vehicle 
    public function vehicleExistance($number) {
        $sql = "SELECT vehicle_no FROM distributor_vehicle WHERE vehicle_no= '{$number}'";
        $result = $this->Query($sql);
        return $result;
    }

    // insert details to distributor_vehicle table
    public function distributorVehicle($user_id, $number, $type, $fuelCon){
        return $this->insert('distributor_vehicle', ['distributor_id'=> $user_id, 'vehicle_no'=> $number, 'type'=>$type, 'fuel_consumption'=> $fuelCon, 'availability'=>"Yes"]);   
    }

    // insert to distributor_vehicle_capacity table
    public function vehicleCapacity($user_id, $number, $product, $qty){
        return $this->insert('distributor_vehicle_capacity', ['distributor_id'=> $user_id, 'vehicle_no'=> $number, 'product_id'=>$product, 'capacity'=> $qty]);   
    }
    // get vehicle (after inserting)
    public function ifDataInserted($number){
        $sql = "SELECT * FROM distributor_vehicle WHERE vehicle_no='{$number}' ";
        $result = $this->Query($sql);
        return $result;   
    }

    // view vehicle 
    public function viewvehicle($dis_id){
        $vehicles = array();
        // get all vehicles that owned by selected dsitributor
        $query2= $this->Query("SELECT * FROM distributor_vehicle WHERE distributor_id = '{$dis_id}' ");
            
            if(mysqli_num_rows($query2)>0) {
                while($row2 = mysqli_fetch_assoc($query2)) {
                    $vehicle_no = $row2['vehicle_no'];
                    $vehicle_capacities = array();
                    // get the details from product details
                    $query3 =  $this->Query("SELECT DISTINCT d.capacity AS capacity, p.name AS product_name FROM distributor_vehicle_capacity d INNER JOIN product p ON d.product_id = p.product_id WHERE d.distributor_id = '{$dis_id}' AND d.vehicle_no = '{$vehicle_no}'");
    
                    if(mysqli_num_rows($query3)>0) {                                        
                        while($row3 = mysqli_fetch_assoc($query3)){
                            array_push($vehicle_capacities, $row3);
                        }                           
                    }
                    array_push($vehicles, ['vehicleinfo'=> $row2, 'capacities' => $vehicle_capacities]);
                }
            }
        return $vehicles;     
    }

    // update vehicle - only viewing(can not update)
    public function updatevehicle($user_id, $vehicle_no) {
        $products = array();
        // get capacities of each products
        $query1 =  $this->Query("SELECT DISTINCT p.name AS product_name, p.product_id as product_id, v.capacity as capacity FROM distributor_vehicle_capacity v INNER JOIN product p ON v.product_id = p.product_id WHERE v.distributor_id = '{$user_id}' and v.vehicle_no = '{$vehicle_no}'");
        
        if(mysqli_num_rows($query1)>0) {
            while($row1 = mysqli_fetch_assoc($query1)) {
                array_push($products,$row1);   

            }
        }
        // get the vehicle
        $query2 = $this->read("distributor_vehicle", "vehicle_no = '$vehicle_no' and distributor_id = '$user_id'");
        $row2 = mysqli_fetch_assoc($query2);
 
        return ['fuel_consumption'=> $row2['fuel_consumption'],'vehicle_no'=> $vehicle_no, 'products'=> $products];

    }

    // update vehicle - can edit
    public function updatingVehicle($vehicle_no) {
        $fuel = $_POST['fuel'];
        $user_id = $_SESSION['user_id'];

        // get capacities of each products
        $query1 =  $this->Query("SELECT DISTINCT p.name AS product_name, p.product_id as product_id, v.capacity as capacity FROM distributor_vehicle_capacity v INNER JOIN product p ON v.product_id = p.product_id WHERE v.distributor_id = '{$user_id}' and v.vehicle_no = '{$vehicle_no}'");
        $products = array();
        while($row1 = mysqli_fetch_assoc($query1)){
            array_push($products, ['id'=> $row1["product_id"], "quantity"=>$_POST[$row1["product_id"]] ]);

        }
        // update distributor_vehicle_capacity table with quantities of each product
        foreach($products as $product) {
            $this->update("distributor_vehicle_capacity", ["capacity"=>$product["quantity"]], "distributor_id= $user_id and vehicle_no = '$vehicle_no' and product_id = ".$product['id']);
            
        }
        // update distributor_vehicle table with other details
        $this->update("distributor_vehicle", ["fuel_consumption"=>$fuel], "distributor_id= $user_id and vehicle_no = '$vehicle_no'" );
    }

    // release a vehicle before removing
    public function releaseVehicle($vehicle_no) {
        // $user_id = $_SESSION['user_id'];
        // // update the availability as "Yes" of a vehicle
        // $query2 = $this->Query("UPDATE distributor_vehicle SET availability ='Yes' WHERE distributor_id = '{$user_id}' AND vehicle_no = '{$vehicle_no}'");
        // return $query2;

        $user_id = $_SESSION['user_id'];
        $data = [];
        // update the availability as "Yes" of a vehicle
       $this->Query("UPDATE distributor_vehicle SET availability ='Yes' WHERE distributor_id = '{$user_id}' AND vehicle_no = '{$vehicle_no}'");
        // return $query2;
        $data['success'] = ['type' => "success", 'message'=> "Vehicle released"];
    }

    // remove a vehicle
    public function removeVehicle($vehicle_no) { 
        $user_id = $_SESSION['user_id'];
         
        $sql = "DELETE FROM distributor_vehicle WHERE vehicle_no = '{$vehicle_no}' AND distributor_id = '{$user_id}'";
        $result = $this ->Query($sql);
       
        return $result;
    }

    // view dealers
    public function viewdealers($user_id) {
        $dealers = array();

        // get dealer information
        $query1 = $this->Query("SELECT DISTINCT d.dealer_id as dealer_id, d.name as name, d.image as image,  u.email as email, d.contact_no as contact_no, d.city as city, d.account_no as account_no, d.bank as bank FROM users u INNER JOIN dealer d ON u.user_id = d.dealer_id WHERE d.distributor_id='{$user_id}' AND u.type='dealer' ");
        if(mysqli_num_rows($query1)>0) {
            while($row1 = mysqli_fetch_assoc($query1)) {
                $dealer_id = $row1['dealer_id'];
                $email = $row1['email'];
                $dealer_name = $row1['name'];
                $contact = $row1['contact_no'];
                $city = $row1['city'];
                $account_num = $row1['account_no'];
                $bank = $row1['bank'];
                $image = $row1['image'];

                $capacities = array();
                // get dealer capacities
                $query3 =  $this->Query("SELECT DISTINCT d.capacity AS capacity, p.name AS product_name FROM dealer_capacity d INNER JOIN product p ON d.product_id = p.product_id WHERE d.dealer_id = '{$dealer_id}' ");
                if(mysqli_num_rows($query3)>0) {
                    while($row3 = mysqli_fetch_assoc($query3)) {
                        array_push($capacities,$row3);
                    }
                } 
                array_push($dealers, ['dealerinfo'=> $row1, 'capacities'=>$capacities]);    
            }
        }
        return $dealers;
    }

    // Gas orders - Pending Orders
    public function pendingGasOrders($user_id) {
        $pending = array();
        // get purchase order details to company , still in pending state, in date ascending order
        $query1 = $this->Query("SELECT stock_req_id, place_date, place_time from stock_request where distributor_id='{$user_id}' and stock_req_state='pending' order by (place_date) ASC;");
        if(mysqli_num_rows($query1)>0) {
            while($row1 = mysqli_fetch_assoc($query1)) {
                $order_id = $row1['stock_req_id'];
                $date = $row1['place_date'];
                $time = $row1['place_time'];

                $capacities = array();
                // get products quantities 
                $query2 = $this->Query("SELECT DISTINCT i.product_id as product_id, i.quantity as quantity, i.unit_price as unit_price, p.name as product_name,p.weight as weight
                from stock_include i 
                inner join stock_request r on i.stock_req_id = r.stock_req_id 
                inner join product p on i.product_id = p.product_id
                where r.distributor_id = '{$user_id}' and r.stock_req_id= '{$order_id}'; ");
                if(mysqli_num_rows($query2)>0) {
                    while($row2=mysqli_fetch_assoc($query2)) {
                        array_push($capacities, $row2);
                    }
                }
                array_push($pending, ['pendinginfo'=>$row1, 'capacities'=>$capacities]);
            }
        }
        return $pending;
    }

    //Gas orders - Completed Orders
    public function completedGasOrders($user_id) {
        $completed = array();

        // get purchase order details to company ,  completed orders, in date ascending order
        $query1 = $this->Query("SELECT stock_req_id, place_date, place_time from stock_request where distributor_id='{$user_id}' and stock_req_state='completed' order by (place_date) ASC;");
        if(mysqli_num_rows($query1)>0) {
            while($row1 = mysqli_fetch_assoc($query1)) {
                $order_id = $row1['stock_req_id'];
                $date = $row1['place_date'];
                $time = $row1['place_time'];

                $capacities = array();
                // get product quantities
                $query2 = $this->Query("SELECT DISTINCT i.product_id as product_id, i.quantity as quantity, i.unit_price as unit_price, p.name as product_name, p.weight as weight
                from stock_include i 
                inner join stock_request r on i.stock_req_id = r.stock_req_id
                inner join product p on i.product_id = p.product_id
                where r.distributor_id = '{$user_id}' and r.stock_req_id= '{$order_id}'; ");
                if(mysqli_num_rows($query2)>0) {
                    while($row2=mysqli_fetch_assoc($query2)) {
                        array_push($capacities, $row2);
                    }
                }
                array_push($completed, ['completedinfo'=>$row1, 'capacities'=>$capacities]);
            }
        }
        return $completed;
    }

    // Gas orders - company delayed gas oders
    public function acceptedGasOrders($user_id) {
        $accepted = array();
        // get purchase order details to company , company delayed, in date ascending order
        $query1 = $this->Query("SELECT stock_req_id, place_date, place_time from stock_request where distributor_id='{$user_id}' and stock_req_state='delayed' order by (place_date) ASC;");
        if(mysqli_num_rows($query1)>0) {
            while($row1 = mysqli_fetch_assoc($query1)) {
                $order_id = $row1['stock_req_id'];
                $date = $row1['place_date'];
                $time = $row1['place_time'];

                $capacities = array();
                // get quantities of products
                $query2 = $this->Query("SELECT DISTINCT i.product_id as product_id, i.quantity as quantity, i.unit_price as unit_price, p.name as product_name, p.weight as weight
                from stock_include i 
                inner join stock_request r on i.stock_req_id = r.stock_req_id
                inner join product p on i.product_id = p.product_id
                where r.distributor_id = '{$user_id}' and r.stock_req_id= '{$order_id}'; ");
                if(mysqli_num_rows($query2)>0) {
                    while($row2=mysqli_fetch_assoc($query2)) {
                        array_push($capacities, $row2);
                    }
                }
                array_push($accepted, ['acceptedinfo'=>$row1, 'capacities'=>$capacities]);
            }
        }
        return $accepted;
    }

    // count of received all gas orders (dashboard)
    public function countReceivedOrders($user_id, $option) {
        // date breakdown
        $today = date('Y-m-d');
        if($option == 'today'){
            $start_date = $today;
            $end_date = $today;
        }else{
            $start_date = date('Y-m-d', strtotime('-30 days'));
            $end_date = date('Y-m-d', strtotime('-1 days'));
        }

        $count = array();
        // get count of po_id s in purchase_order table
        $query1 = $this->Query("SELECT count(po_id) AS receviedOrders FROM purchase_order WHERE distributor_id='{$user_id}' AND place_date >= '$start_date' AND place_date <= '$end_date' ");
        
        if(mysqli_num_rows($query1)>0) {
            while($row1 = mysqli_fetch_assoc($query1)) {
                $count = $row1['receviedOrders'];
            }
        }
        return $count;
    }

    //Gas distributions - pending   
    public function pendingdistributions($user_id) {
        $pending = array();

        // get details - in pending stat, date ascending order
        $query1 = $this->Query("SELECT po_id, dealer_id, place_date, place_time, vehicle_allocated from purchase_order where distributor_id = '{$user_id}' and po_state='pending' order by (place_date) ASC; ");
        if(mysqli_num_rows($query1)>0) {
            while($row1 = mysqli_fetch_assoc($query1)) {
                $order_id = $row1['po_id'];
                $dealer_id = $row1['dealer_id'];
                $date = $row1['place_date'];
                $time = $row1['place_time'];

                $capacities = array();
                //get product quantities
                $query2 = $this->Query("SELECT DISTINCT i.product_id as product_id, i.unit_price as unit_price, i.quantity as quantity, p.name as product_name, p.weight as weight 
                from purchase_include i 
                inner join purchase_order o on i.po_id = o.po_id
                inner join product p on i.product_id = p.product_id
                where o.distributor_id='{$user_id}' and o.po_id = '{$order_id}'; ") ;

                if(mysqli_num_rows($query2)>0) {
                    while($row2= mysqli_fetch_assoc($query2)) {
                        array_push($capacities, $row2);
                    }
                }
                array_push($pending, ['pendinginfo'=>$row1, 'capacities'=>$capacities]);
            }
        }
        return $pending;
    }

    // pending distribution done => update dealer keeping capacities, update distributor keeping capacities, change the po_state to "completed"
    public function finishpendingdistributions($distribution_id) {
        $user_id = $_SESSION['user_id'];
        $data = [];
        // get dealer purchase order details 
        $query2 = $this->Query("SELECT i.product_id as product_id, i.quantity as quantity, o.dealer_id as dealer_id
        FROM purchase_order o inner join purchase_include i
        ON o.po_id = i.po_id 
        WHERE o.distributor_id='{$user_id}' AND o.po_id = '{$distribution_id}'");

        if(mysqli_num_rows($query2)>0) {
            // first check whether the distributor has the required stock
            // $query3 = $query2;
            $flag = true; // assume stock is available
            while($row2 = mysqli_fetch_assoc($query2)){
                $row3 = mysqli_fetch_assoc($this->read('distributor_keep',"distributor_id = $user_id AND product_id = ".$row2['product_id']));
                if($row3['quantity'] < $row2['quantity']){
                    $flag = false;
                }
            }

            if($flag){
                // reduce stock and add it to the dealer
                $query2 = $this->Query("SELECT i.product_id as product_id, i.quantity as quantity, o.dealer_id as dealer_id
                FROM purchase_order o inner join purchase_include i
                ON o.po_id = i.po_id 
                WHERE o.distributor_id='{$user_id}' AND o.po_id = '{$distribution_id}'");
                // echo $flag;
                while($row2 = mysqli_fetch_assoc($query2)) {
                    // echo 'ok';
                    $dealer_id = $row2['dealer_id'];
                    $product_id = $row2['product_id'];
                    $o_quantity = $row2['quantity']; //requested product quantity

                    // update dealer keeping stock according to the order capacities
                    // get quantities of each product
                    $query3 = $this->Query("SELECT product_id, quantity FROM dealer_keep WHERE dealer_id = '{$dealer_id}' AND product_id = '{$product_id}'");
                    if(mysqli_num_rows($query3)>0) {
                        $row3 = mysqli_fetch_assoc($query3);
                        $dealer_quantity = $row3['quantity'];
                        $dealer_quantity = $dealer_quantity + $o_quantity;

                        $this->Query("UPDATE dealer_keep SET quantity = '{$dealer_quantity}' WHERE dealer_id = '{$dealer_id}' AND product_id = '{$product_id}'");

                    } else {
                        // if dealer current capacity is empty
                        $dealer_quantity = $o_quantity;
                        // $this->Query("INSERT INTO dealer_keep (dealer_id, product_id, quantity,reorder_level, lead_time, po_counter, reorder_flag) VALUES ('{$dealer_id}', '{$product_id}', '{$dealer_quantity}', NULL, NULL, NULL, NULL)");
                        $this->Query("INSERT INTO dealer_keep (dealer_id, product_id, quantity) VALUES ('{$dealer_id}', '{$product_id}', '{$dealer_quantity}'");
                    }
                    
                    // update distributor keeping capacities
                    // get quantities of each product
                    $query4 = $this->Query("SELECT product_id, quantity FROM distributor_keep WHERE distributor_id = '{$user_id}' AND product_id = '{$product_id}'");
                    if(mysqli_num_rows($query4)>0) {
                        $row4 = mysqli_fetch_assoc($query4);
                        $distributor_quantity = $row4['quantity'];
                        $distributor_quantity = $distributor_quantity - $o_quantity;

                        $com_date = date('Y-m-d');
                        $com_time = date("H:i:s");

                        $this->Query("UPDATE distributor_keep SET quantity = '{$distributor_quantity}' WHERE distributor_id = '{$user_id}' AND product_id = '{$product_id}'");
                        $this->Query("UPDATE purchase_order SET po_state = 'Completed', delivered_date = '{$com_date}', delivered_time = '{$com_time}'  WHERE po_id = '{$distribution_id}' ");
                        // echo "success";
                        $data['success'] = ['type'=>"success", 'message'=>"Gas Distribution Successfully Done!"];
                        
                    }else {
                        // if distribtor gas stock is not enough
                        $data['toast'] = ['type'=>"error", 'message'=>"Sorry, Gas Stock is Empty!"];
                        return $data;
                    }
                }
            }else{
                $data['toast'] = ['type'=>"error", 'message'=>'Sorry, not enough gas stock'];
            }
        }
        return $data;
    }

    // dashboard -> count of pending distributions (dashboard)
    public function sumpendingdistirbutions($user_id, $option) {
        $today = date('Y-m-d');
        if($option == 'today'){
            $start_date = $today;
            $end_date = $today;

        }else{
            $start_date = date('Y-m-d', strtotime('-30 days'));
            $end_date = date('Y-m-d', strtotime('-1 days'));
        }

        $count = array();
        // get count of pending dealer purchase order id s 
        $query1 = $this->Query("SELECT count(po_id) as numofpendis from purchase_order where distributor_id = '{$user_id}' AND po_state='pending' AND place_date >= '$start_date' AND place_date <= '$end_date';");
        if(mysqli_num_rows($query1)>0) {
            while($row1 = mysqli_fetch_assoc($query1)) {
                $count = $row1['numofpendis'];
            }
        }
        return $count;
    }

    // Gas distributions - completed
    public function completedistributions($user_id) {
        $completed = array();
        // get details of completed gas distributios
        $query1 = $this->Query("SELECT po_id, dealer_id, place_date, place_time from purchase_order where distributor_id = '{$user_id}' and po_state='completed' order by (place_date) ASC; ");
        if(mysqli_num_rows($query1)>0) {
            while($row1 = mysqli_fetch_assoc($query1)) {
                $order_id = $row1['po_id'];
                $dealer_id = $row1['dealer_id'];
                $date = $row1['place_date'];
                $time = $row1['place_time'];

                $capacities = array();
                // quantities of each products 
                $query2 = $this->Query("SELECT DISTINCT i.product_id as product_id, i.unit_price as unit_price, i.quantity as quantity, p.name as product_name,p.weight as weight
                from purchase_include i 
                inner join purchase_order o on i.po_id = o.po_id 
                inner join product p on i.product_id = p.product_id
                where  o.distributor_id='{$user_id}' and o.po_id = '{$order_id}'; ") ;

                if(mysqli_num_rows($query2)>0) {
                    while($row2= mysqli_fetch_assoc($query2)) {
                        array_push($capacities, $row2);
                    }
                }
                array_push($completed, ['completedinfo'=>$row1, 'capacities'=>$capacities]);
            }
        }
        return $completed;
    }

    // details of completed distributions for reports - report tab interface
    public function reportpastdistributions($user_id, $option) {
        $today = date('Y-m-d');
        if($option == 'today'){
            $start_date = $today;
            $end_date = $today;

        }elseif($option == '7day'){
            $start_date = date('Y-m-d', strtotime('-7 days'));
            $end_date = date('Y-m-d', strtotime('-1 days'));
        
        }else{
            $start_date = date('Y-m-d', strtotime('-30 days'));
            $end_date = date('Y-m-d', strtotime('-1 days'));
        }

        $completed = array();
        // get completed gas distributions' details
        $query1 = $this->Query("SELECT po_id, dealer_id, place_date, place_time FROM purchase_order WHERE distributor_id = '{$user_id}' and po_state='completed' AND place_date >= '$start_date' AND place_date <= '$end_date';");

        if(mysqli_num_rows($query1)>0) {
            while($row1 = mysqli_fetch_assoc($query1)) {
                $order_id = $row1['po_id'];
                $dealer_id = $row1['dealer_id'];
                $date = $row1['place_date'];
                $time = $row1['place_time'];

                $capacities = array();
                // get qunatities of each products.
                $query2 = $this->Query("SELECT DISTINCT i.product_id as product_id, i.unit_price as unit_price, i.quantity as quantity from purchase_include i inner join purchase_order o on i.po_id = o.po_id where o.po_id = '{$order_id}'; ") ;
                if(mysqli_num_rows($query2)>0) {
                    while($row2= mysqli_fetch_assoc($query2)) {
                        array_push($capacities, $row2);
                    }
                }
                array_push($completed, ['completedinfo'=>$row1, 'capacities'=>$capacities]);
            }
        }
        return $completed;
    }
    
    //completed gas distirbution details to pdf 
    public function reportdetails($distribution_no) {
        // get dealer completed purchase order details
        $query1 = $this->Query("SELECT DISTINCT o.po_id as distribution_no, o.dealer_id as dealer_id,
        o.place_date as date, o.place_time as time, o.distributor_id as distributor_id,  CONCAT(u.first_name, ' ', u.last_name) as name
        from purchase_order o INNER JOIN users u 
        ON o.dealer_id = u.user_id 
        WHERE o.po_id = '{$distribution_no}'");

        if(mysqli_num_rows($query1)>0) {
            while($row1 = mysqli_fetch_assoc($query1)) {
                $distribution_no = $row1['distribution_no'];
                $distributor_id = $row1['distributor_id'];
                $dealer_id = $row1['dealer_id'];
                $date = $row1['date'];
                $time = $row1['time'];
                $name = $row1['name'];

                $products = array();
                // get quantities of each products
                $query2 = $this->Query("SELECT DISTINCT i.product_id as product_id, i.unit_price as unit_price, i.quantity as quantity
                FROM purchase_include i INNER JOIN purchase_order o
                ON i.po_id = o.po_id 
                WHERE i.po_id = $distribution_no");
                if(mysqli_num_rows($query2)>0) {
                    while($row2 = mysqli_fetch_assoc($query2)) {
                        array_push($products, $row2);
                    }
                }
               return ['details'=>$row1, 'quantites'=>$products];
            }
           
        }
        return;
    }

    // current stock
    public function currentstock($user_id) {
        $stock = array();
        // distributor current stock of each products
        $query1 = $this->Query("SELECT DISTINCT p.product_id as product_id, p.name as name, p.weight as weight, p.image as image, d.quantity as quantity  FROM distributor_keep d inner join product p on d.product_id=p.product_id where d.distributor_id= $user_id");
        if(mysqli_num_rows($query1)>0) {
            while($row1 = mysqli_fetch_assoc($query1)) {
                $product_id = $row1['product_id'];
                $product_name = $row1['name'];
                $weight = $row1['weight'];
                $image = $row1['image'];
                $quantity = $row1['quantity'];

                array_push($stock, ['stockinfo'=> $row1]);
            }
        }
        return $stock;

    }
    // get distributors from users table
    public function getDistributor($user_id) {
        $result = $this->Query("SELECT * FROM users u inner join distributor d on u.user_id = d.distributor_id where d.distributor_id =$user_id");
        return $result;
    }

    // ------ //
    public function productdetails() {
        $products = array();

        $query1 = $this->Query("SELECT product_id, name, unit_price FROM product WHERE company_id = 2;");
        if(mysqli_num_rows($query1)>0) {
            while($row1 =mysqli_fetch_assoc($query1)) {
                $product_id = $row1['product_id'];
                $name = $row1['name'];
                $unit_price = $row1['unit_price'];

                array_push($products, ['productdetails'=> $row1]);
            }
        }
        return $products;
    }
    //  ----- //

    // distributor purchase order
    public function distributorplaceorder($user_id, $productid,$postproducts) {
        $data =[];
        $flag = false;
        $notvalidquantity = true;
        // validate the quantity of each product
        for($i=0; $i<count($productid); $i++) {
            if($postproducts[$productid[$i]] != 0) {
                $notvalidquantity = false;
            };
        }
        // var_dump($postproducts);
        if($notvalidquantity) {
            $data['toast'] = ['type'=>"error", 'message'=>"Please insert a valid amount of products"];
            return $data;
        }
        for($i=0; $i<count($productid); $i++) {
            $product = $productid[$i];

            // take current stock
            $current_stock = 0;
            $result1 = $this->Query("SELECT * FROM distributor_keep WHERE distributor_id = '{$user_id}' AND product_id = '{$product}'");
            if(mysqli_num_rows($result1)>0) {
                $row1 = mysqli_fetch_assoc($result1);
                $current_stock = $row1['quantity'];
            }

            // take previously ordered but still pending amount
            $pending_stock =0;
            $result = $this->Query("SELECT * FROM stock_request WHERE distributor_id='{$user_id}' AND stock_req_state = 'pending'");
            if(mysqli_num_rows($result)>0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $req_id = $row['stock_req_id'];
                    $result2 = $this->Query("SELECT * FROM stock_include WHERE stock_req_id =$req_id AND product_id = $product");
                    if(mysqli_num_rows($result2)>0){
                        $row2 = mysqli_fetch_assoc($result2);
                        $pending_stock += $row2['quantity'];
                    }
                }
            }

            // take capacity
            $capacity = 0;
            $result4 = $this->Query("SELECT * FROM distributor_capacity WHERE distributor_id = '{$user_id}' AND product_id = '{$product}'");
            if(mysqli_num_rows($result4)>0) {
                $row4 = mysqli_fetch_assoc($result4);
                $capacity = $row4['capacity'];
            }
            if($postproducts[$product] > ($capacity - $current_stock - $pending_stock)) {
                $flag=true;
            }
            // post $productid <= capacity - current stock - pending stock
        }

        // if false 
        if($flag) {
            $data['toast'] = ['type'=>"error", 'message'=>"Insufficient Storage"];
            return $data;
        }

        // get company details
        $query1 = $this->getDistributor($user_id);
        $row5 = mysqli_fetch_assoc($query1);
        $company_id = $row5['company_id'];

        date_default_timezone_set("Asia/Colombo");
        $place_time = date('H:i');
        $place_date = date('Y-m-d');

        // insert order details into stock_request table
        $query3 = $this->Query("INSERT INTO stock_request (distributor_id, stock_req_state, company_id, delay_time, place_date, place_time) VALUES ('{$user_id}', 'pending', '{$company_id}', 0, '{$place_date}', '{$place_time}')");
        // get stock_req_id from stock_request table
        $query4 = $this->Query("SELECT * FROM stock_request WHERE distributor_id = '{$user_id}' ORDER BY place_date DESC, place_time DESC LIMIT 1");
        $row6 = mysqli_fetch_assoc($query4);
        $req_id = $row6['stock_req_id'];

        for($i=0; $i<count($productid); $i++) {
            $product = $productid[$i];
            $quantity = $postproducts[$product];
            $query5 = $this->Query("SELECT unit_price FROM product WHERE product_id = '$product'");
            $row7 = mysqli_fetch_assoc($query5);
            $unit_price = $row7['unit_price'];
            // $weight = $row7['weight'];
            if($quantity>0) {
                // insert quantities of each product into stock_include table 
                $query5 = $this->Query("INSERT INTO stock_include (stock_req_id, product_id, quantity, unit_price) VALUES ($req_id, '$product', $quantity, $unit_price)");
            }
        }

        // rending the pdf
        $result5 = $this->Query("SELECT * FROM stock_request WHERE distributor_id = '{$user_id}' ORDER BY stock_req_id DESC LIMIT 1");
        // LIMIT 1 => used to limit the number of rows returned by the SQL query to just one
        if(mysqli_num_rows($result5)>0) {
            $row = mysqli_fetch_assoc($result5);
            $stock_req_id = $row['stock_req_id'];
            $date = $row['place_date'];
            $time = $row['place_time'];

            $products = array();
            $total = 0;

            // get details for pdf
            $result6 = $this->Query("SELECT  s.product_id as product_id,
            p.name as product_name, p.weight as weight,
            s.quantity as quantity,
            s.unit_price as unit_price
            FROM stock_include s INNER JOIN product p
            ON s.product_id = p.product_id
            WHERE stock_req_id = $stock_req_id");
            if(mysqli_num_rows($result6)>0) {
                while($row = mysqli_fetch_assoc($result6)) {
                    array_push($products, ['product_id'=>$row['product_id'], 'product_name'=>$row['product_name'], 'weight'=>$row['weight'], 'quantity'=>$row['quantity'], 'unit_price'=>$row['unit_price'], 'subtotal'=>$row['unit_price']*$row['quantity']]);
                    $total +=$row['unit_price']*$row['quantity'];
                }
            }

            $data = ['stock_req_id'=>$stock_req_id,'distributor_id'=>$user_id, 'date'=>$date, 'time'=>$time, 'products'=>$products, 'total'=>$total];

        }

        return $data;
    }

    public function distributorstock($user_id) {
        // get distributor details
        $query1 = $this->getDistributor($user_id);
        $row1 = mysqli_fetch_assoc($query1);
        $company_id = $row1['company_id'];

        // get products of company
        $query2 = $this->Query("SELECT product_id, name, unit_price, image, weight
        FROM product 
        WHERE company_id  = $company_id");

        return $query2;
    }
    
    // signup
    // get products of comapny
    public function getProducts($company_id){
        $result = $this->read('product', 'company_id = '.$company_id);     
        return $result;
    }

    // get products of company
    public function distributorSignupForm($company_id){
        $data['productresult'] = $this->read('product', 'company_id = '.$company_id);
        return $data;
    }

    // suitable vehcile list
    public function eligibleVechicles($po_id){
        // init empty array to have eligible vehicles
        $eligible_vehicles = [];
        $final_eligibility = [];
        $query1 = $this->read('distributor_vehicle',"distributor_id = ".$_SESSION['user_id']);
        if(mysqli_num_rows($query1) > 0){
            while($row1 = mysqli_fetch_assoc($query1)){
                // intializing the session for the vehicle
                // session_start();
                $flag = true; // to dissmiss the vehicle when even the po included product can't fit in
                $_SESSION['eligibility'.removeHyphen($row1['vehicle_no'])] = [];
                $query2 = $this->read('distributor_vehicle_capacity',"distributor_id = ".$_SESSION['user_id']." AND vehicle_no = '".$row1['vehicle_no']."'");
                if(mysqli_num_rows($query2) > 0){
                    // push the remainging eligibility into the session (check this not sure)
                    while($row2 = mysqli_fetch_assoc($query2)){
                        $_SESSION['eligibility'.removeHyphen($row1['vehicle_no'])][$row2['product_id']] = $row2['remain_eligibility'];
                    }
                    // var_dump($_SESSION['eligibility'.removeHyphen($row1['vehicle_no'])]);

                    // take product ids of po
                    $query3 = $this->read('purchase_include',"po_id = $po_id");
                    if(mysqli_num_rows($query3) > 0){
                        while($row3 = mysqli_fetch_assoc($query3)){
                            $product_considering = $row3['product_id'];
                            $_SESSION['eligibility'.removeHyphen($row1['vehicle_no'])][$product_considering] -= $row3['quantity'];
                            if($_SESSION['eligibility'.removeHyphen($row1['vehicle_no'])][$product_considering] < 0){
                                // must go to the next vehicle
                                // destroy the session of the current vehicle
                                unset($_SESSION['eligibility'.removeHyphen($row1['vehicle_no'])]);
                                $flag = false;
                                break;
                            }else{
                                $remaining = $_SESSION['eligibility'.removeHyphen($row1['vehicle_no'])][$product_considering];
                                // update the session of all products
                                $query4 = $this->read('distributor_vehicle_capacity',"distributor_id = ".$_SESSION['user_id']." AND vehicle_no = '".$row1['vehicle_no']."'");
                                while($row4 = mysqli_fetch_assoc($query4)){
                                    $product_affected = $row4['product_id'];
                                    if($product_affected != $product_considering){
                                        $total_eligibility = $row4['capacity'];
                                        $row5 = mysqli_fetch_assoc($this->read('distributor_vehicle_capacity',"product_id = $product_considering"));
                                        $total_eligibility_considering = $row5['capacity'];
                                        // set the new eligibility of affected products
                                        $_SESSION['eligibility'.removeHyphen($row1['vehicle_no'])][$product_affected] = floor(($total_eligibility/$total_eligibility_considering)*$remaining);
                                    }
                                }
                            }
                        }

                        // init final remain products array
                        if($flag){
                            $final_remain_products = [];
                            // var_dump($_SESSION['eligibility'.removeHyphen($row1['vehicle_no'])]);
                            foreach($_SESSION['eligibility'.removeHyphen($row1['vehicle_no'])] as $key => $value){
                                if($value >= 0){
                                    // put into remain products
                                    $final_remain_products[$key] = $value;
                                    // put that vid into a set
                                    $cost = $this->getCostforVehicle($po_id,$row1['vehicle_no']);
                                    $eligible_vehicles[$row1['vehicle_no']] = $cost;
                                }else{
                                    // must go to the next vehicle
                                    // destroy the session of the current vehicle
                                    unset($_SESSION['eligibility'.removeHyphen($row1['vehicle_no'])]);
                                    // remove that vehicle from eligible vehicle list
                                    unset($eligible_vehicles[$row1['vehicle_no']]);
                                    // and destroy final remaining products array for that vehicle
                                    $final_remain_products = [];
                                    break;
                                }
                            }

                            if(count($final_remain_products) > 0){
                                $final_eligibility[$row1['vehicle_no']] = $final_remain_products;
                                // make sure to unset after used
                            }
                        }
                    }

                }

                // unset the session for the discussed vehicle
                unset($_SESSION['eligibility'.removeHyphen($row1['vehicle_no'])]);
            }
        }else{
            // have to show that he has no vehicles to distribute
        }

        // order the vehicles based on cost and return them
        asort($eligible_vehicles);
        return ['eligible_vehicles'=>$eligible_vehicles,'final_eligibility'=>$final_eligibility];
    }

    public function getCostforVehicle($po_id,$vehicle_no){
        //take distributor id and address
        $user_id = $_SESSION['user_id'];
        $row = mysqli_fetch_assoc($this->read('distributor',"distributor_id = $user_id"));
        $distributor_address = $row['street'].', '.$row['city'];
        // take dealer id and address
        $row = mysqli_fetch_assoc($this->read('purchase_order',"po_id = $po_id"));
        $dealer_id = $row['dealer_id'];
        $row = mysqli_fetch_assoc($this->read('dealer',"dealer_id = $dealer_id"));
        $dealer_address = $row['street'].', '.$row['city'];
        // calculate distance between addresses
        $distance = getDistance($dealer_address,$distributor_address);
        // calculate total weight of the po
        $total_weight = 0;
        $query2 = $this->read('purchase_include',"po_id = $po_id");
        while($row2 = mysqli_fetch_assoc($query2)){
            $row3 = mysqli_fetch_assoc($this->read('product',"product_id = ".$row2['product_id']));
            $total_weight += $row3['weight']*$row2['quantity'];
        }
        // get the cost per km
        $row = mysqli_fetch_assoc($this->read('distributor_vehicle',"distributor_id = $user_id AND vehicle_no = '$vehicle_no'"));
        // get the total cost to distribute using given vehicle
        $cost = $row['fuel_consumption']*$distance*$total_weight;
        return $cost;
    }

    public function getOnlyEligibleVehicles($po_id){
        // get eligible vehicles for the po
        $nominated_vehicles = $this->eligibleVechicles($po_id);
        $_SESSION['nominated_vehicles'] = $nominated_vehicles;
        $vehicles = $nominated_vehicles['eligible_vehicles'];

        $vehiclesarr = array();

        foreach ($vehicles as $vehicl_no => $cost){
            // get basic information of the vehicle
            $row = mysqli_fetch_assoc($this->read('distributor_vehicle',"vehicle_no = '$vehicl_no'"));
            $vehicle_info = ['vehicle_no' => $row['vehicle_no'],'type' => $row['type'],'fuel_consumption'=>$row['fuel_consumption'],'cost'=>number_format($cost,2)];
            array_push($vehiclesarr,['vehicleinfo' => $vehicle_info, 'capacities' => array()]);
        }

        return $vehiclesarr;
    }

    public function selectedVehicle($po_id,$vehicle_no){
        $nominated_vehicles = $_SESSION['nominated_vehicles'];
        $vehicles = $nominated_vehicles['eligible_vehicles'];
        $final_remain_eligibility = $nominated_vehicles['final_eligibility'];
        $final_eligibility_selected = $final_remain_eligibility[$vehicle_no];

        // update the vehicle remaining capacity
        foreach($final_eligibility_selected as $key => $value){
            $this->update('distributor_vehicle_capacity',['remain_eligibility'=>$value],"vehicle_no = '$vehicle_no' AND product_id = $key");
        }

        // mark the po as vehicle allocated
        $this->update('purchase_order',['vehicle_allocated'=>1],"po_id = $po_id");

        // destroy the session of nominates vehicles
        unset($_SESSION['nominated_vehicles']);
    }

    // reports - get totals of each product from dealer received orders(sell to dealers)
    public function AllSellProducts($option) {
        $user_id = $_SESSION['user_id'];  //distirbutor id

        // $today = date('Y-m-d');
        if($option == 'today'){
            $start_date = date('Y-m-d');
            $end_date = date('Y-m-d');
        }elseif($option == '7day'){
            $start_date = date('Y-m-d', strtotime('-7 days'));
            $end_date = date('Y-m-d', strtotime('-1 days'));        
            // $end_date = date('Y-m-d');        
        }else{
            $start_date = date('Y-m-d', strtotime('-30 days'));
            $end_date = date('Y-m-d', strtotime('-1 days'));
        }

        $product_quantites = array();

        $query1 = $this->Query("SELECT p.product_id, SUM(pi.quantity) as quantity, p.name as name, p.weight, p.unit_price as unit_price
        FROM purchase_include pi INNER JOIN product p 
        ON pi.product_id = p.product_id WHERE po_id IN 
            (SELECT po_id FROM purchase_order 
            WHERE place_date >= '$start_date' AND place_date <= '$end_date' AND distributor_id = $user_id AND po_state != 'pending') 
            GROUP BY product_id");

        if(mysqli_num_rows($query1)>0) {
            while($row1=mysqli_fetch_assoc($query1)) {
                $product_id = $row1['product_id'];
                $product_name = $row1['name'];
                $weight = $row1['weight'];
                $unit_price = $row1['unit_price'];
                $quantity = $row1['quantity'];
                array_push($product_quantites, ['quantites'=>$row1]);
            }
        }
        return $product_quantites;
    }

    // all sell products report details 
    // public function AllSellProductsDetails($start_date, $end_date) {
    // public function AllSellProductsDetails($option) {
    //     $user_id = $_SESSION['user_id'];  //distirbutor id

    //     if($option == 'today'){
    //         $start_date = date('Y-m-d');
    //         $end_date = date('Y-m-d');
    //     }elseif($option == '7day'){
    //         $start_date = date('Y-m-d', strtotime('-7 days'));
    //         $end_date = date('Y-m-d', strtotime('-1 days'));        
    //     }else{
    //         $start_date = date('Y-m-d', strtotime('-30 days'));
    //         $end_date = date('Y-m-d', strtotime('-1 days'));
    //     }

    //     $product_quantites = array();
    //     $query1 = $this->Query("SELECT p.product_id, SUM(pi.quantity) as quantity, p.name as name
    //     FROM purchase_include pi INNER JOIN product p 
    //     ON pi.product_id = p.product_id WHERE po_id IN 
    //         (SELECT po_id FROM purchase_order 
    //         WHERE place_date >= '$start_date' AND place_date <= '$end_date' AND distributor_id = $user_id AND po_state != 'pending') 
    //         GROUP BY product_id");

    //     if(mysqli_num_rows($query1)>0) {
    //         while($row1=mysqli_fetch_assoc($query1)) {
    //             array_push($product_quantites, $row1);
    //         }
    //     }
    //     return ['start'=> $start_date, 'end'=> $end_date, 'quantites'=>$product_quantites];
    // }



    // reports - get totals of each product to company purchase orders
    public function AllRequestedProducts($option) {
        $user_id = $_SESSION['user_id'];  //distirbutor id

        $today = date('Y-m-d');
        if($option == 'today'){
            $start_date = $today;
            $end_date = $today;

        }elseif($option == '7day'){
            $start_date = date('Y-m-d', strtotime('-7 days'));
            $end_date = date('Y-m-d', strtotime('-1 days'));
        
        }else{
            $start_date = date('Y-m-d', strtotime('-30 days'));
            $end_date = date('Y-m-d', strtotime('-1 days'));
        }

        $product_quantites = array();

        $query1 = $this->Query("SELECT p.product_id, SUM(s.quantity) as quantity, p.name as name, p.weight as weight, p.unit_price as unit_price
        FROM stock_include s INNER JOIN product p 
        ON s.product_id = p.product_id WHERE stock_req_id IN 
            (SELECT stock_req_id FROM stock_request 
            WHERE place_date >= '$start_date' AND place_date <= '$end_date' AND distributor_id = $user_id AND stock_req_state = 'completed' ) 
            GROUP BY product_id");

        if(mysqli_num_rows($query1)>0) {
            while($row1=mysqli_fetch_assoc($query1)) {
                $product_id = $row1['product_id'];
                $product_name = $row1['name'];
                $quantity = $row1['quantity'];
                $weight = $row1['weight'];
                $unit_price = $row1['unit_price'];
                array_push($product_quantites,['quantities'=>$row1]);
            }
        }
        return $product_quantites;
        // return ['quantities'=>$product_quantites];
    }


    // reports - income

    // reprots - expendition
    
}

