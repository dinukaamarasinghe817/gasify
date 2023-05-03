<?php

class Distributor extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

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
        // $result = $this->read('distributor', "distributor_id = $distributor_id");
        $result = $this->Query("SELECT * FROM users u INNER JOIN distributor d ON u.user_id = d.distributor_id WHERE u.user_id = $distributor_id");
        return $result;
    }


    public function dashboard($distributor_id,$option){
        $data = [];

        $today = date('Y-m-d');
            if($option == 'today'){
                $start_date = $today;
                $end_date = $today;
            }else{
                $start_date = date('Y-m-d', strtotime('-30 days'));
                $end_date = date('Y-m-d', strtotime('-1 days'));
            }


            // chart
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
        // $result = $this->read('distributor', "distributor_id = $distributor_id");
        $sql = "SELECT p.name AS name, p.product_id AS product_id FROM distributor_capacity d inner join product p on d.product_id=p.product_id where d.distributor_id = '{$distributor_id}'";
        $result = $this->Query($sql);
        return $result;
    }

    // public function vehicleExistance($distributor_id) {
    public function vehicleExistance($number) {
        $sql = "SELECT vehicle_no FROM distributor_vehicle WHERE vehicle_no= '{$number}'";
        $result = $this->Query($sql);
        return $result;
    }

    // insert to distributor_vehicle table
    public function distributorVehicle($user_id, $number, $type, $fuelCon){
        return $this->insert('distributor_vehicle', ['distributor_id'=> $user_id, 'vehicle_no'=> $number, 'type'=>$type, 'fuel_consumption'=> $fuelCon, 'availability'=>"Yes"]);   
    }

    // insert to distributor_vehicle_capacity table
    public function vehicleCapacity($user_id, $number, $product, $qty){
        return $this->insert('distributor_vehicle_capacity', ['distributor_id'=> $user_id, 'vehicle_no'=> $number, 'product_id'=>$product, 'capacity'=> $qty]);   
    }

    public function ifDataInserted($number){
        $sql = "SELECT * FROM distributor_vehicle WHERE vehicle_no='{$number}' ";
        $result = $this->Query($sql);
        return $result;   
    }

    public function viewvehicle($dis_id){
        $vehicles = array();
        $query2= $this->Query("SELECT * FROM distributor_vehicle WHERE distributor_id = '{$dis_id}' ");
            
            if(mysqli_num_rows($query2)>0) {
                while($row2 = mysqli_fetch_assoc($query2)) {
                    $vehicle_no = $row2['vehicle_no'];
                    $vehicle_capacities = array();
                    // get the details from product details
                    // $query3 = mysqli_query($conn, "SELECT * FROM product WHERE company_id = '{$row['company_id']}' and product_id = '{$product_id}'");
                    $query3 =  $this->Query("SELECT DISTINCT d.capacity AS capacity, p.name AS product_name FROM distributor_vehicle_capacity d INNER JOIN product p ON d.product_id = p.product_id WHERE d.distributor_id = '{$dis_id}' AND d.vehicle_no = '{$vehicle_no}'");
    
                    if(mysqli_num_rows($query3)>0) {
                        // $output .= '<tr>
                        //                 <td>'.$row2['vehicle_no'].'</td>
                        //                 <td>'.$row2['type'].'</td>
                        //                 <td>
                        //                 <table class="table2">
                        //                     <tr>
                        //                         <th>Product Name</th>
                        //                         <th>Capacity</th>
                        //                     </tr>';
                                        
                        while($row3 = mysqli_fetch_assoc($query3)){
                            array_push($vehicle_capacities, $row3);
                            // $output .= '
                            //     <tr>
                            //         <td>'.$row3['product_name'].'</td>
                            //         <td>'.$row3['capacity'].'</td>
                            //     </tr>
                            // ';
                        }
    
                        // $output .= '</table>
                        //             </td>
                        //             <td>'.$row2['fuel_consumption'].'</td>
                        //             <td>'.$row2['availability'].'</td>
                        //             ';
                        // if($row2['availability'] == 'No'|| $row2['availability'] == 'NO' || $row2['availability'] == 'no' ){
                        //     $output .= '<td><button class="btn4" style="background-color: B4AAFF;"><b>Release</b></button></td>';
                        // }else{
                        //     $output .= '<td><button type="button" class="btn4" onclick="deleteVehicle('.$vehicle_no.')" style="background-color: red;"><b>Remove</b></button></td>';
                        // }
                        // $output .=  '
                        //         </tr>';                            
                    }
                    array_push($vehicles, ['vehicleinfo'=> $row2, 'capacities' => $vehicle_capacities]);
                }
            }
        return $vehicles;     
    }

    // update vehicle
    public function updatevehicle($user_id, $vehicle_no) {
        $products = array();
        $query1 =  $this->Query("SELECT DISTINCT p.name AS product_name, p.product_id as product_id, v.capacity as capacity FROM distributor_vehicle_capacity v INNER JOIN product p ON v.product_id = p.product_id WHERE v.distributor_id = '{$user_id}' and v.vehicle_no = '{$vehicle_no}'");
        
        if(mysqli_num_rows($query1)>0) {
            while($row1 = mysqli_fetch_assoc($query1)) {
                array_push($products,$row1);   

            }
        }
        $query2 = $this->read("distributor_vehicle", "vehicle_no = '$vehicle_no' and distributor_id = '$user_id'");
        $row2 = mysqli_fetch_assoc($query2);
 
        return ['fuel_consumption'=> $row2['fuel_consumption'],'vehicle_no'=> $vehicle_no, 'products'=> $products];

    }

    public function updatingVehicle($vehicle_no) {
        $fuel = $_POST['fuel'];
        $user_id = $_SESSION['user_id'];

        $query1 =  $this->Query("SELECT DISTINCT p.name AS product_name, p.product_id as product_id, v.capacity as capacity FROM distributor_vehicle_capacity v INNER JOIN product p ON v.product_id = p.product_id WHERE v.distributor_id = '{$user_id}' and v.vehicle_no = '{$vehicle_no}'");
        $products = array();
        while($row1 = mysqli_fetch_assoc($query1)){
            array_push($products, ['id'=> $row1["product_id"], "quantity"=>$_POST[$row1["product_id"]] ]);

        }
        foreach($products as $product) {
            $this->update("distributor_vehicle_capacity", ["capacity"=>$product["quantity"]], "distributor_id= $user_id and vehicle_no = '$vehicle_no' and product_id = ".$product['id']);
            
        }
        $this->update("distributor_vehicle", ["fuel_consumption"=>$fuel], "distributor_id= $user_id and vehicle_no = '$vehicle_no'" );
    }

    // release a vehicle before removing
    public function releaseVehicle($vehicle_no) {
        $user_id = $_SESSION['user_id'];
       
        $query2 = $this->Query("UPDATE distributor_vehicle SET availability ='Yes' WHERE distributor_id = '{$user_id}' AND vehicle_no = '{$vehicle_no}'");
        return $query2;
    }

    // remove e vehicle
    public function removeVehicle($vehicle_no) { 
        $user_id = $_SESSION['user_id'];
        // $data=[];

        // $result = $this->delete('distributor_vehicle', "vehicle_no = '$vehicle_no' AND distributor_id = '$user_id'");  
        $sql = "DELETE FROM distributor_vehicle WHERE vehicle_no = '{$vehicle_no}' AND distributor_id = '{$user_id}'";
        $result = $this ->Query($sql);
        // $data = $this ->Query($sql);

        return $data;
    }

    // view dealers
    public function viewdealers($user_id) {
        $dealers = array();

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
                $query3 =  $this->Query("SELECT DISTINCT d.capacity AS capacity, p.name AS product_name FROM dealer_capacity d INNER JOIN product p ON d.product_id = p.product_id WHERE d.dealer_id = '{$dealer_id}' ");
                // $query3 =  $this->Query("SELECT DISTINCT d.capacity AS capacity, p.name AS product_name FROM dealer_capacity d INNER JOIN product p ON d.product_id = p.product_id  ");
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

    // Distributor - gas order list - Pending Orders
    public function pendingGasOrders($user_id) {
        $pending = array();

        $query1 = $this->Query("SELECT stock_req_id, place_date, place_time from stock_request where distributor_id='{$user_id}' and stock_req_state='pending' order by (place_date) ASC;");
        if(mysqli_num_rows($query1)>0) {
            while($row1 = mysqli_fetch_assoc($query1)) {
                $order_id = $row1['stock_req_id'];
                $date = $row1['place_date'];
                $time = $row1['place_time'];

                $capacities = array();
                $query2 = $this->Query("SELECT DISTINCT i.product_id as product_id, i.quantity as quantity, i.unit_price as unit_price from stock_include i inner join stock_request r on i.stock_req_id = r.stock_req_id where r.distributor_id = '{$user_id}' and r.stock_req_id= '{$order_id}'; ");
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

    // Distributor - gas order list - Completed Orders
    public function completedGasOrders($user_id) {
        $completed = array();

        $query1 = $this->Query("SELECT stock_req_id, place_date, place_time from stock_request where distributor_id='{$user_id}' and stock_req_state='completed' order by (place_date) ASC;");
        if(mysqli_num_rows($query1)>0) {
            while($row1 = mysqli_fetch_assoc($query1)) {
                $order_id = $row1['stock_req_id'];
                $date = $row1['place_date'];
                $time = $row1['place_time'];

                $capacities = array();
                $query2 = $this->Query("SELECT DISTINCT i.product_id as product_id, i.quantity as quantity, i.unit_price as unit_price from stock_include i inner join stock_request r on i.stock_req_id = r.stock_req_id where r.distributor_id = '{$user_id}' and r.stock_req_id= '{$order_id}'; ");
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

    // Distributor - gas order list - accepted Orders
    public function acceptedGasOrders($user_id) {
        $accepted = array();

        $query1 = $this->Query("SELECT stock_req_id, place_date, place_time from stock_request where distributor_id='{$user_id}' and stock_req_state='accepted' order by (place_date) ASC;");
        if(mysqli_num_rows($query1)>0) {
            while($row1 = mysqli_fetch_assoc($query1)) {
                $order_id = $row1['stock_req_id'];
                $date = $row1['place_date'];
                $time = $row1['place_time'];

                $capacities = array();
                $query2 = $this->Query("SELECT DISTINCT i.product_id as product_id, i.quantity as quantity, i.unit_price as unit_price from stock_include i inner join stock_request r on i.stock_req_id = r.stock_req_id where r.distributor_id = '{$user_id}' and r.stock_req_id= '{$order_id}'; ");
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

    // count of received all gas orders
    public function countReceivedOrders($user_id, $option) {
        $today = date('Y-m-d');
        if($option == 'today'){
            $start_date = $today;
            $end_date = $today;
        }else{
            $start_date = date('Y-m-d', strtotime('-30 days'));
            $end_date = date('Y-m-d', strtotime('-1 days'));
        }

        $count = array();
        // $query1 = $this->Query("SELECT count(po_id) as receviedOrders from purchase_order where distributor_id='{$user_id}'");
        $query1 = $this->Query("SELECT count(po_id) AS receviedOrders FROM purchase_order WHERE distributor_id='{$user_id}' AND place_date >= '$start_date' AND place_date <= '$end_date' ");
        
        if(mysqli_num_rows($query1)>0) {
            while($row1 = mysqli_fetch_assoc($query1)) {
                $count = $row1['receviedOrders'];
            }
        }
        return $count;
    }

    // Distributor - gas distributions - pending   
    public function pendingdistributions($user_id) {
        $pending = array();

        $query1 = $this->Query("SELECT po_id, dealer_id, place_date, place_time from purchase_order where distributor_id = '{$user_id}' and po_state='pending' order by (place_date) ASC; ");
        if(mysqli_num_rows($query1)>0) {
            while($row1 = mysqli_fetch_assoc($query1)) {
                $order_id = $row1['po_id'];
                $dealer_id = $row1['dealer_id'];
                $date = $row1['place_date'];
                $time = $row1['place_time'];

                $capacities = array();
                $query2 = $this->Query("SELECT DISTINCT i.product_id as product_id, i.unit_price as unit_price, i.quantity as quantity from purchase_include i inner join purchase_order o on i.po_id = o.po_id where o.distributor_id='{$user_id}' and o.po_id = '{$order_id}'; ") ;
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
        
        $query2 = $this->Query("SELECT i.product_id as product_id, i.quantity as quantity, o.dealer_id as dealer_id
        FROM purchase_order o inner join purchase_include i
        ON o.po_id = i.po_id 
        WHERE o.distributor_id='{$user_id}' AND o.po_id = '{$distribution_id}'");

        if(mysqli_num_rows($query2)>0) {
            while($row2 = mysqli_fetch_assoc($query2)) {
                $dealer_id = $row2['dealer_id'];
                $product_id = $row2['product_id'];
                $o_quantity = $row2['quantity'];

                // update dealer keeping stock according to the order capacities
                $query3 = $this->Query("SELECT product_id, quantity FROM dealer_keep WHERE dealer_id = '{$dealer_id}' AND product_id = '{$product_id}'");
                if(mysqli_num_rows($query3)>0) {
                    $row3 = mysqli_fetch_assoc($query3);
                    $dealer_quantity = $row3['quantity'];
                    $dealer_quantity = $dealer_quantity + $o_quantity;

                    $this->Query("UPDATE dealer_keep SET quantity = '{$dealer_quantity}' WHERE dealer_id = '{$dealer_id}' AND product_id = '{$product_id}'");

                } else {
                    // if dealer keeping is empty
                    $dealer_quantity = $o_quantity;
                    $this->Query("INSERT INTO dealer_keep (dealer_id, product_id, quantity,reorder_level, lead_time, po_counter, reorder_flag) VALUES ('{$dealer_id}', '{$product_id}', '{$dealer_quantity}', NULL, NULL, NULL, NULL)");
                }
                
                // update distributor keeping capacities
                $query4 = $this->Query("SELECT product_id, quantity FROM distributor_keep WHERE distributor_id = '{$user_id}' AND product_id = '{$product_id}'");
                if(mysqli_num_rows($query4)>0) {
                    $row4 = mysqli_fetch_assoc($query4);
                    $distributor_quantity = $row4['quantity'];
                    $distributor_quantity = $distributor_quantity - $o_quantity;

                    if($row4['quantity'] < $o_quantity) {
                        $data['toast'] = ['type'=>"error", 'message'=>"Sorry, Not enough gas stock!"];
                        return $data;
                    }else {
                        $com_date = date('Y-m-d');
                        $com_time = date("H:i:s");

                        $this->Query("UPDATE distributor_keep SET quantity = '{$distributor_quantity}' WHERE distributor_id = '{$user_id}' AND product_id = '{$product_id}'");
                        $this->Query("UPDATE purchase_order SET po_state = 'completed', place_date = '{$com_date}', place_time = '{$com_time}'  WHERE distributor_id = '{$user_id}' AND po_id = '{$distribution_id}' ");
                    }
                }else {
                    $data['toast'] = ['type'=>"error", 'message'=>"Sorry, Gas stock is empty!"];
                    return $data;
                }
            }
        }
        return $data;
    }

    // dashboard -> count of pending distributions
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
        $query1 = $this->Query("SELECT count(po_id) as numofpendis from purchase_order where distributor_id = '{$user_id}' AND po_state='pending' AND place_date >= '$start_date' AND place_date <= '$end_date';");
        if(mysqli_num_rows($query1)>0) {
            while($row1 = mysqli_fetch_assoc($query1)) {
                $count = $row1['numofpendis'];
            }
        }
        return $count;
    }

    // Distributor - gas distributions -completed
    public function completedistributions($user_id) {
        $completed = array();

        $query1 = $this->Query("SELECT po_id, dealer_id, place_date, place_time from purchase_order where distributor_id = '{$user_id}' and po_state='completed' order by (place_date) ASC; ");
        if(mysqli_num_rows($query1)>0) {
            while($row1 = mysqli_fetch_assoc($query1)) {
                $order_id = $row1['po_id'];
                $dealer_id = $row1['dealer_id'];
                $date = $row1['place_date'];
                $time = $row1['place_time'];

                $capacities = array();
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
        $query1 = $this->Query("SELECT po_id, dealer_id, place_date, place_time FROM purchase_order WHERE distributor_id = '{$user_id}' and po_state='completed' AND place_date >= '$start_date' AND place_date <= '$end_date';");

        if(mysqli_num_rows($query1)>0) {
            while($row1 = mysqli_fetch_assoc($query1)) {
                $order_id = $row1['po_id'];
                $dealer_id = $row1['dealer_id'];
                $date = $row1['place_date'];
                $time = $row1['place_time'];

                $capacities = array();
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
    
    //get details of distribution report - past distributions
    public function reportdetails($distribution_no) {
        // $reportdata = array();
        // $query1 = $this->Query("SELECT * from purchase_order where distribution_id = '{$user_id}' and po_state='completed' );
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

        $query1 = $this->Query("SELECT DISTINCT p.product_id as product_id, p.name as name, d.quantity as quantity FROM distributor_keep d inner join product p on d.product_id=p.product_id where d.distributor_id= $user_id");
        if(mysqli_num_rows($query1)>0) {
            while($row1 = mysqli_fetch_assoc($query1)) {
                $product_id = $row1['product_id'];
                $product_name = $row1['name'];
                $quantity = $row1['quantity'];

                array_push($stock, ['stockinfo'=> $row1]);
            }
        }
        return $stock;

    }
    
    public function getDistributor($user_id) {
        $result = $this->Query("SELECT * FROM users u inner join distributor d on u.user_id = d.distributor_id where d.distributor_id =$user_id");
        return $result;
    }

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
                        // print_r($row2['quantity']);
                        $pending_stock += $row2['quantity'];
                        // print_r(is_null($pending_stock));
                        // $pending_stock = $pending_stock + $row2['quantity'];
                    }
                    
                    
                    //print_r(array_keys($row2));
                    //print_r($row['quantity']);
                    // if(mysqli_fetch_assoc($result2)){
                    //     $row2 = mysqli_fetch_assoc($result2);
                    //     print_r($row2);
                    // }
                    //print_r(gettype($row2));
                    //print_r(intval($row2['quantity']));
                    //$pending_stock += intval($row2['quantity']);
                }
            }

            // $pending_stock =0;
            // $result2 = $this->Query("SELECT * FROM stock_request WHERE distributor_id='{$user_id}' AND stock_req_state = 'pending'");
            // if(mysqli_num_rows($result2)>0) {
            //     while($row2 = mysqli_fetch_assoc($result2)) {
            //         $req_id = $row2['stock_req_id'];

            //         $result3 = $this->Query("SELECT * FROM stock_include WHERE stock_req_id ='{$req_id}' AND product_id = '{$product}'");
            //         if(mysqli_num_rows($result3)>0) {
            //             $row3 = mysqli_fetch_assoc($result3);
            //             $pending_stock += $row3['quantity'];
            //         }
            //     }
            // }

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

        $query3 = $this->Query("INSERT INTO stock_request (distributor_id, stock_req_state, company_id, delay_time, place_date, place_time) VALUES ('{$user_id}', 'pending', '{$company_id}', 0, '{$place_date}', '{$place_time}')");
        $query4 = $this->Query("SELECT * FROM stock_request WHERE distributor_id = '{$user_id}' ORDER BY place_date DESC, place_time DESC LIMIT 1");
        $row6 = mysqli_fetch_assoc($query4);
        $req_id = $row6['stock_req_id'];

        for($i=0; $i<count($productid); $i++) {
            $product = $productid[$i];
            $quantity = $postproducts[$product];
            $query5 = $this->Query("SELECT unit_price FROM product WHERE product_id = '$product'");
            $row7 = mysqli_fetch_assoc($query5);
            $unit_price = $row7['unit_price'];
            if($quantity>0) {
                $query5 = $this->Query("INSERT INTO stock_include (stock_req_id, product_id, quantity, unit_price) VALUES ($req_id, '$product', $quantity, $unit_price)");
            }
        }

        // rending the pdf
        $result5 = $this->Query("SELECT * FROM stock_request WHERE distributor_id = '{$user_id}' ORDER BY stock_req_id DESC LIMIT 1");
        if(mysqli_num_rows($result5)>0) {
            $row = mysqli_fetch_assoc($result5);
            $stock_req_id = $row['stock_req_id'];
            $date = $row['place_date'];
            $time = $row['place_time'];

            $products = array();
            $total = 0;

            // stock request include table and product table
            $result6 = $this->Query("SELECT  s.product_id as product_id,
            p.name as product_name,
            s.quantity as quantity,
            s.unit_price as unit_price
            FROM stock_include s INNER JOIN product p
            ON s.product_id = p.product_id
            WHERE stock_req_id = $stock_req_id");
            if(mysqli_num_rows($result6)>0) {
                while($row = mysqli_fetch_assoc($result6)) {
                    array_push($products, ['product_id'=>$row['product_id'], 'product_name'=>$row['product_name'], 'quantity'=>$row['quantity'], 'unit_price'=>$row['unit_price'], 'subtotal'=>$row['unit_price']*$row['quantity']]);
                    $total +=$row['unit_price']*$row['quantity'];
                }
            }

            $data = ['stock_req_id'=>$stock_req_id,'distributor_id'=>$user_id, 'date'=>$date, 'time'=>$time, 'products'=>$products, 'total'=>$total];

        }

        return $data;
    }

    public function distributorstock($user_id) {
        $query1 = $this->getDistributor($user_id);
        $row1 = mysqli_fetch_assoc($query1);
        $company_id = $row1['company_id'];

        $query2 = $this->Query("SELECT product_id, name, unit_price, image
        FROM product 
        WHERE company_id  = $company_id");

        return $query2;
    }
    
    // signup
    public function getProducts($company_id){
        $result = $this->read('product', 'company_id = '.$company_id);     
        return $result;
    }

    public function distributorSignupForm($company_id){
        $data['productresult'] = $this->read('product', 'company_id = '.$company_id);
        // $data['distributorresult'] = $this->read('distributor', "company_id = $company_id", "city");
        return $data;
    }

    public function eligibleVechicles($po_id){
        // init empty array to have eligible vehicles
        $eligible_vehicles = [];
        $query1 = $this->read('distributor_vehicle',"distributor_id = ".$_SESSION['user_id']);
        if(mysqli_num_rows($query1) > 0){
            while($row1 = mysqli_fetch_assoc($query1)){
                // intializing the session for the vehicle
                $_SESSION['eligibility'.$row1['vehicle_no']] = [];
                $query2 = $this->read('distributor_vehicle_capacity',"distributor_id = ".$_SESSION['user_id']." AND vehicle_no = '".$row1['vehicle_no']."'");
                if(mysqli_num_rows($query2) > 0){
                    // push the remainging eligibility into the session (check this not sure)
                    while($row2 = mysqli_fetch_assoc($query2)){
                        $_SESSION['eligibility'.$row1['vehicle_no']][$row2['product_id']] = $row2['remain_eligibility'];
                    }

                    // take product ids of po
                    $query3 = $this->read('purchase_include',"po_id = $po_id");
                    if(mysqli_num_rows($query3) > 0){
                        while($row3 = mysqli_fetch_assoc($query3)){
                            $product_considering = $row3['product_id'];
                            $_SESSION['eligibility'.$row1['vehicle_no']][$product_considering] -= $row3['quantity'];
                            if($_SESSION['eligibility'.$row1['vehicle_no']][$product_considering] < 0){
                                // must go to the next vehicle
                                // destroy the session of the current vehicle
                                unset($_SESSION['eligibility'.$row1['vehicle_no']]);
                                break;
                            }else{
                                $remaining = $_SESSION['eligibility'.$row1['vehicle_no']][$product_considering];
                                // update the session of all products
                                $query4 = $this->read('distributor_vehicle_capacity',"distributor_id = ".$_SESSION['user_id']." AND vehicle_no = '".$row1['vehicle_no']."'");
                                while($row4 = mysqli_fetch_assoc($query4)){
                                    $product_affected = $row4['product_id'];
                                    if($product_affected != $product_considering){
                                        $total_eligibility = $row4['capacity'];
                                        $row5 = mysqli_fetch_assoc($this->read('distributor_vehicle_capacity',"product_id = $product_considering"));
                                        $total_eligibility_considering = $row5['capacity'];
                                        // set the new eligibility of affected products
                                        $_SESSION['eligibility'.$row1['vehicle_no']][$product_affected] = floor($total_eligibility/$total_eligibility_considering)*$remaining;
                                    }
                                }
                            }
                        }

                        // init final remain products array
                        $final_remain_products = [];
                        foreach($_SESSION['eligibility'.$row1['vehicle_no']] as $key => $value){
                            if($value >= 0){
                                // put into remain products
                                $final_remain_products[$key] = $value;
                                // put that vid into a set
                                $cost = getCostforVehicle($po_id,$row1['vehicle_no']);
                                $eligible_vehicles[$row1['vehicle_no']] = $cost;
                            }else{
                                // must go to the next vehicle
                                // destroy the session of the current vehicle
                                unset($_SESSION['eligibility'.$row1['vehicle_no']]);
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
        $row = $this->read('distributor',"distributor_id = $user_id");
        $distributor_address = $row['street'].', '.$row['city'];
        // take dealer id and address
        $row = mysqli_fetch_assoc($this->read('purchase_order',"po_id = $po_id"));
        $dealer_id = $row['dealer_id'];
        $row = $this->read('dealer',"dealer_id = $dealer_id");
        $dealer_address = $row['street'].', '.$row['city'];
        // calculate distance between addresses
        $distance = getDistance($dealer_address,$distributor_address);
        // calculate total weight of the po
        $total_weight = 0;
        $query2 = $this->read('purchase_order',"po_id = $po_id");
        while($row2 = mysqli_fetch_assoc($query2)){
            $row3 = mysqli_fetch_assoc($this->read('product',"product_id = ".$row2['product_id']));
            $total_weight += $row3['weight']*$row2['quantity'];
        }
        // get the cost per km
        $row = $this->read('distributor_vehicle',"distributor_id = $user_id AND vehicle_no = '$vehicle_no'");
        // get the total cost to distribute using given vehicle
        $cost = $row['cost_per_km']*$distance*$total_weight;
        return $cost;
    }

    // reports - get totals of each product from dealer received orders(sell to dealers)

    // reports - get totals of each product to company purchase orders

    // reports - income

    // reprots - expendition
    
}

