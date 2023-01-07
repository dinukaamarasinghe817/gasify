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
        $result = $this->read('distributor', "distributor_id = $distributor_id");
        return $result;
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

    // public function viewvehicle($distributor_id) {
    //     $sql = "SELECT * FROM distributor_vehicle WHERE distributor_id = '{$distributor_id}'";
    //     $sql = $this->Query($sql);
    //     $output = '';

    //     if(mysqli_num_rows($sql)>0) {
    //         while($row2 = mysqli_fetch_assoc($sql)) {
    //             $vehicle_no = $row2['vehicle_no'];

    //             $vehicle = "SELECT DISTINCT d.capacity AS capacity, p.name AS product_name FROM distributor_vehicle_capacity d INNER JOIN product p ON d.product_id = p.product_id WHERE d.distributor_id = '{$distributor_id}' AND d.vehicle_no = '{$vehicle_no}'";
    //             $vehicle = $this->Query($vehicle);


    //             if(mysqli_num_rows($vehicle)>0) {
    //                 $output .= '<tr>
    //                     <td>'.$vehicle_no.'</td>
    //                     <td>'.$row2['type'].'</td>
    //                     <td>
    //                     <table class="table2">
    //                         <tr>
    //                             <th>Product Name</th>
    //                             <th>Capacity</th>
    //                         </tr>';
                    
    //                 while($row3 = mysqli_fetch_assoc($vehicle)) {
    //                     $output .= '
    //                         <tr>
    //                             <td>'.$row3['product_name'].'</td>
    //                             <td>'.$row3['capacity'].'</td>
    //                         </tr>
    //                     ';
    //                 }

    //                 $output .= '</table>
    //                             </td>
    //                             <td>'.$row2['fuel_consumption'].'</td>
    //                             <td>'.$row2['availability'].'</td>
    //                             ';
    //                 if($row2['availability'] == 'No'|| $row2['availability'] == 'NO' || $row2['availability'] == 'no' ){
    //                     $output .= '<td><button class="btn4" style="background-color: B4AAFF;"><b>Release</b></button></td>';
    //                 }else{
    //                     $output .= '<td><button type="button" class="btn4" onclick="deleteVehicle('.$vehicle_no.')" style="background-color: red;"><b>Remove</b></button></td>';
    //                 }

    //                 $output .=  '
    //                         </tr>'; 

    //             }
    //         }
    //     }
        
    // }

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

}