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
        $today = date('Y-m-d');
            if($option == 'today'){
                $start_date = $today;
                $end_date = $today;
            }else{
                $start_date = date('Y-m-d', strtotime('-30 days'));
                $end_date = date('Y-m-d', strtotime('-1 days'));
            }
            $sql = "SELECT p.product_id, SUM(pi.quantity) as quantity, p.name as name
            FROM purchase_include pi INNER JOIN product p 
            ON pi.product_id = p.product_id WHERE po_id IN 
                (SELECT po_id FROM purchase_order 
                WHERE place_date >= '$start_date' AND place_date <= '$end_date' AND distributor_id = $distributor_id AND po_state != 'Pending') 
            GROUP BY product_id";

            //chart details
            $products = $this->Query($sql);
            $chart['y'] = 'Distributed Quantity';
            $chart['color'] = 'rgba(255, 159, 64, 0.5)';
            $chart['labels'] = array();$chart['vector'] = array();
            $products = $this->Query($sql);
            foreach($products as $product){
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
    // public function updatevehicle($vehicle_no, $user_id, $new_capacity) {
    public function updatevehicle($user_id, $vehicle_no) {
        // $vehicle_no = $_POST['vehicle_no'];

        $products = array();
        $query1 =  $this->Query("SELECT DISTINCT p.name AS product_name, p.product_id as product_id, v.capacity as capacity FROM distributor_vehicle_capacity v INNER JOIN product p ON v.product_id = p.product_id WHERE v.distributor_id = '{$user_id}' and v.vehicle_no = '{$vehicle_no}'");
        // $query1 = $this->Query("SELECT DISTINCT v.fuel_consumption as fuel, c.capacity as capacity, c.product_id as product_id from distributor_vehicle_capacity c inner join distributor_vehicle v on v.vehicle_bo = c.vehicle_no where v.distributor_id = '{$user_id}' and c.distributor_id = '{$user_id}'");
        
        if(mysqli_num_rows($query1)>0) {
            while($row1 = mysqli_fetch_assoc($query1)) {
                // $number = $row1['vehicle_no'];
                // $name = $row1['product_name'];
                // $capacities = array();
                // $capacity = $row1['capacity'];


                // array_push($products,['productinfo'=>$row1 ]);   
                // $newdata = array();
                // $query2 =  $this->Query("UPDATE distributor_vehicle_capacity SET capacity = $new_capacity WHERE distributor_id = $user_id AND vehicle_no = '$vehicle_no'");
                // if(mysqli_num_rows($query2)>0) {
                    // while($row2 = mysqli_fetch_assoc($query2)) {
                        // array_push($newdata, $row2);
                    // }
                // }
                // array_push($products,['productinfo'=>$row1, 'newcapacities'=>$newdata ]); 
                // array_push($products,['productinfo'=>$row1, 'capacities'=>$capacities]);   
                array_push($products,$row1);   

            }
        }
        $query2 = $this->read("distributor_vehicle", "vehicle_no = '$vehicle_no' and distributor_id = '$user_id'");
        $row2 = mysqli_fetch_assoc($query2);

        // array_push($products,['productinfo'=>$row1 ]);   
        // $query2 =  $this->Query("UPDATE distributor_vehicle_capacity SET capacity = $new_capacity WHERE distributor_id = $distributor_id AND vehicle_no = '$vehicle_id'");
        return ['fuel_consumption'=> $row2['fuel_consumption'],'vehicle_no'=> $vehicle_no, 'products'=> $products];



        // $result = $this->update('users', array('fuel'=>$data['fuel']), "distributor_id = $user_id AND vehicle_no = $vehicle_no");
        // if($result) {
        //     $row = mysqli_fetch_assoc($this->read('distributor',"distributor_id = $user_id"));
        //     $result = $this->read('product',"company_id = ".$row['company_id']);
        //     $capacity = array();
        //     while($row = mysqli_fetch_assoc($result)){
        //         if(isset($_POST[$row['product_id']])){
        //             $quantity = $_POST[$row['product_id']];
        //             array_push($capacity,['product_id' => $row['product_id'], 'quantity' => $quantity]);
        //         }
        //     }
        //     foreach($capacity as $cap){
        //         $this->update('distributor_capacity',array('capacity'=>$cap['quantity']),"distributor_id = $user_id AND product_id = ".$cap['product_id']);
        //     }
           

        // }
        // return $data;

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

        $query1 = $this->Query("SELECT stock_req_id, place_date from stock_request where distributor_id='{$user_id}' and stock_req_state='pending' order by (place_date) ASC;");
        if(mysqli_num_rows($query1)>0) {
            while($row1 = mysqli_fetch_assoc($query1)) {
                $order_id = $row1['stock_req_id'];
                $date = $row1['place_date'];

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

        $query1 = $this->Query("SELECT stock_req_id, place_date from stock_request where distributor_id='{$user_id}' and stock_req_state='completed' order by (place_date) ASC;");
        if(mysqli_num_rows($query1)>0) {
            while($row1 = mysqli_fetch_assoc($query1)) {
                $order_id = $row1['stock_req_id'];
                $date = $row1['place_date'];

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

        $query1 = $this->Query("SELECT stock_req_id, place_date from stock_request where distributor_id='{$user_id}' and stock_req_state='accepted' order by (place_date) ASC;");
        if(mysqli_num_rows($query1)>0) {
            while($row1 = mysqli_fetch_assoc($query1)) {
                $order_id = $row1['stock_req_id'];
                $date = $row1['place_date'];

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
    public function countReceivedOrders($user_id) {
        $count = array();
        $query1 = $this->Query("SELECT count(stock_req_id) as receviedOrders from stock_request where distributor_id='{$user_id}'");
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

        $query1 = $this->Query("SELECT po_id, dealer_id, place_date from purchase_order where distributor_id = '{$user_id}' and po_state='pending' order by (place_date) ASC; ");
        if(mysqli_num_rows($query1)>0) {
            while($row1 = mysqli_fetch_assoc($query1)) {
                $order_id = $row1['po_id'];
                $dealer_id = $row1['dealer_id'];
                $date = $row1['place_date'];

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
    public function sumpendingdistirbutions($user_id) {
        $count = array();
        // $query1 = $this->Query("SELECT count()")
        $query1 = $this->Query("SELECT count(po_id) as numofpendis from purchase_order where distributor_id = '{$user_id}' and po_state='pending'; ");
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

        $query1 = $this->Query("SELECT po_id, dealer_id, place_date from purchase_order where distributor_id = '{$user_id}' and po_state='completed' order by (place_date) ASC; ");
        if(mysqli_num_rows($query1)>0) {
            while($row1 = mysqli_fetch_assoc($query1)) {
                $order_id = $row1['po_id'];
                $dealer_id = $row1['dealer_id'];
                $date = $row1['place_date'];

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

    public function phurchaseOrders($user_id) {
        $stock = array();

        // $query1 = $this->Query("SELECT DISTINCT  p.name as name, d.quantity as quantity FROM distributor_keep d inner join product p on d.product_id=p.product_id where d.distributor_id= $user_id");
        $query1 = $this->Query("SELECT name FROM  product  where company_id = '2';");
        if(mysqli_num_rows($query1)>0) {
            while($row1 = mysqli_fetch_assoc($query1)) {
                // $product_id = $row1['product_id'];
                $product_name = $row1['name'];
                // $quantity = $row1['quantity'];

                array_push($stock, ['stockinfo'=> $row1]);
            }
        }
        return $stock;
    }

   
    
}

