<?php
// AuthorizeLogin();
session_start();
// if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
//     header('Location: ' . BASEURL . '/home');
// }
class Vehicles extends Controller{
    function __construct(){
        parent::__construct();
    }

    public function distributor(){
        $user_id = $_SESSION['user_id'];
        $data['navigation'] = 'vehicles';
        // profile picture & notifications
        $distributor_details = $this->model('Distributor')->getDistributorImage($user_id);
        $row = mysqli_fetch_assoc($distributor_details);
        $data['image'] = $row['image'];

        // body data
        $data['vehicles'] = $this->model('Distributor')->getVehicleInfo($user_id);

        $this->view('distributor/add_vehicles', $data);

    }

    public function addvehicle() {
        $number=$_POST['vehiclenum'];
        $type = $_POST['type'];
        $fuelCon = $_POST['consumption'];

        $capacity = array();
        $user_id = $_SESSION['user_id'];
        $result =  $this->model('Distributor')->getVehicleInfo($user_id);

        $records = mysqli_num_rows($result);
        $isvalidqty = false;
        for($i = 0; $i < $records; $i++){
            $product = mysqli_fetch_assoc($result);
            $product_id = $product['product_id'];
            $qty = $_POST["$product_id"];
            if($qty != 0){
                $isvalidqty = true;
            }
            $capacity[$i] = array($product['product_id'],$qty);
        }

        if(!empty($number) && !empty($type) && !empty($fuelCon)) {
            $existance = $this->model('Distributor')->vehicleExistance($number);
            if(mysqli_num_rows($existance) > 0 ) { //if vehicle number already exists
                echo "$number - This vehicle number already added";

            }else { 
                $user_id = $_SESSION['user_id'];
                $addvehicle = $this->model('Distributor')->distributorVehicle($user_id, $number, $type, $fuelCon);
                // $query2 = mysqli_query($addvehicle);

                // $query4;

                for($i=0; $i<count($capacity); $i++) {
                    $product = $capacity[$i][0];
                    $qty = $capacity[$i][1];
                    // $sql2 = "INSERT INTO distributor_capacity(distributor_id, product_id, capacity) values ($distributor_id, $product, $qty);"; 
                    // $sql4 = mysqli_query($conn,"INSERT INTO distributor_vehicle_capacity(distributor_id, vehicle_no, product_id, capacity) VALUES('{$_id}', '{$number}', '{$product}','{$qty}');");
                    // $query4 = mysqli_query($conn,$sql2);
                    $vehiclecapacity = $this->model('Distributor')->vehicleCapacity($user_id, $number, $product, $qty);
                }
            
                // if($sql2 && $sql4) {
                if($addvehicle && $vehiclecapacity) {
                    //if data inserted
                    $ifdatainserted = $this->model('Distributor')->ifDataInserted($number);
                    if(mysqli_num_rows($ifdatainserted) > 0) {
                        $row = mysqli_fetch_assoc($ifdatainserted);
                        $_SESSION['user_id'] = $row['distributor_id'];
                        echo "success";
                    }
                }else {
                    echo "Something went wrong!";
                }
            }
        }else {
            echo "All input fields are required!";
        }
    }

    public function viewvehicle() {
        $user_id = $_SESSION['user_id'];

        // echo "Your Distributor ID - $user_id".'<br><br>';
        // echo "Your Vehicles' Details : ";


        $vehicle =  $this->model('Distributor')->viewvehicle($user_id);

        if(mysqli_num_rows($vehicle)>0) {
            while($row2 = mysqli_fetch_assoc($vehicle)) {
                $vehicle_no = $row2['vehicle_no'];

                $productdetails =  $this->model('Distributor')->productdetails($distributor_id, $vehicle_no);

            }

        }


    }

}