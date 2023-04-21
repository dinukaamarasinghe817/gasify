<?php

class Distributor extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllDistributors(){  
        $result = $this->Query("SELECT CONCAT(u.first_name,' ',u.last_name) AS name, u.email AS email, CONCAT(d.street,', ',d.city) AS address, d.contact_no AS contact FROM distributor d INNER JOIN users u ON d.distributor_id = u.user_id");
        $data = [];
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

        // $result = $this->delete('distributor_vehicle', "vehicle_no = '$vehicle_no' AND distributor_id = '$user_id'");  
        $sql = "DELETE FROM distributor_vehicle WHERE vehicle_no = '{$vehicle_no}' AND distributor_id = '{$user_id}'";
        $result = $this ->Query($sql);
        return $result;
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

    // details of completed distributions for reports (reports)
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
    

    //get details of distribution report

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
    public function distributorplaceorder($user_id, $prodcutid,$postproducts) {
        $data =[];
        $flag = false;
        $notvalidquantity = true;
        for($i=0; $i<count($prodcutid); $i++) {
            if($postproducts[$prodcutid[$i]] != 0) {
                $notvalidquantity = false;
            };
        }
        
        if($notvalidquantity) {
            $data['toast'] = ['type'=>"error", 'message'=>"Please insert a valid amount of products"];
            return $data;
        }
        for($i=0; $i<count($prodcutid); $i++) {
            $product = $prodcutid[$i];

            // take current stock
            $current_stock = 0;
            $result = $this->Query("SELECT * FROM distributor_keep WHERE distributor_id = '{$user_id}' AND product_id = '{$prodcut}'");
            if(mysqli_num_rows($result)>0) {
                $row = mysqli_fetch_assoc($result);
                $current_stock = $row['quantity'];
            }

            // take previously ordered but still pending amount
            $pending_stock =0;
            $result = $this->Query("SELECT * FROM stock_request WHERE distributor_id='{$user_id}' AND po_state = 'pending'");
            if(mysqli_num_rows($result)>0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $req_id = $row['stock_req_id'];
                    $result = $this->Query("SELECT * FROM stock_include WHERE stock_req_id ='{$req_id}' AND product_id = '{$prodcut}'");
                    $row2 = mysqli_fetch_assoc($result);
                    $pending_stock +=$row2['quantity'];
                }
            }

            // take capacity
            $capacity = 0;
            $result = $this->Qeury("SELECT * FROM distributor_capacity WHERE distributor_id = '{$user_id}' AND product_id = '{$prodcut}'");
            if(mysli_num_rows($result)>0) {
                $row = mysqli_fetch_assoc($result);
                $capacity = $row['capacity'];
            }
            if($postproducts[$prodcut] > ($capacity - $current_stock - $pending_stock)) {
                $flag=true;
            }
        }

        // if false 
        if($flag) {
            $data['toast'] = ['type'=>"error", 'message'=>"Insufficient Storage"];
            return $data;
        }

        // get company details
        $query1 = $this->getDistributor($user_id);
        $row1 = mysqli_fetch_assoc($query1);
        $company_id = $row1['company_id'];

        date_default_timezone_set("Asia/Colombo");
        $place_time = date('H:i');
        $place_date = date('Y-m-d');

        $query3 = $this->Query("INSERT INTO stock_request (distributor_id, stock_req_state, company_id, delay_time, place_date, place_time) VALUES ('{$user_id}', 'pending', '{$company_id}', 0, '{$place_date}', '{$place_time}')");
        $query4 = $this->Query("SELECT * FROM stock_request WHERE distributor_id = '{$user_id}' ORDER BY place_date DESC, place_time DESC LIMIT 1");
        $row4 = mysqli_fetch_assoc($query4);
        $req_id = $row4['stock_req_id'];

        for($i=0; $i<count($prodcutid); $i++) {
            $prodcut = $prodcutid[$i];
            $quantity = $postproducts[$prodcut];
            $query5 = $this->Query("SELECT unit_price FROM product WHERE product_id = '$prodcut'");
            $row5 = mysli_fetch_assoc($query5);
            $unit_price = $row5['unit_price'];
            $query5 = $this->Query("INSERT INTO stock_include (stock_req_id, product_id, quantity, unit_price) VALUES ($req_id, '$prodcut', $quantity, $unit_price)");
        }
        return $data;
    }

    public function distributorStock($distributor_id,$tab){
        switch($tab){
            case "currentstock":
                $result = $this->Query("SELECT p.product_id as product_id,p.name as product_name,p.image as image,
                p.weight as product_weight,p.unit_price as unit_price,d.quantity as quantity
                FROM product p INNER JOIN distributor_keep d ON p.product_id = d.product_id WHERE d.distributor_id = $distributor_id");
                return $result;
                break;

            case "purchaseorder":
                $result = $this->Query("SELECT d.product_id as product_id, p.name as name, p.unit_price as unit_price, p.image as image
                FROM distributor_capacity d INNER JOIN product p
                ON d.product_id = p.product_id 
                WHERE distributor_id = '$distributor_id'");
                return $result;
                break;

            case "pohistory":
                // get the distributor's stock information
                $query2 = $this->Query("SELECT * FROM stock_request WHERE  distributor_id = '{$distributor_id}' ORDER BY stock_req_id DESC");
                $purchase_orders = array();

                if(mysqli_num_rows($query2) > 0){
                    while($row2 = mysqli_fetch_assoc($query2)){
                            
                            $sql = "SELECT si.product_id AS product_id, si.quantity AS quantity, pr.name AS name 
                                    FROM stock_include si 
                                    INNER JOIN product pr 
                                    ON si.product_id = pr.product_id 
                                    WHERE si.po_id = '{$row2['stock_req_id']}'";
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


    
}

