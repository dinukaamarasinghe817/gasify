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

                for($i=0; $i<count($capacity); $i++) {
                    $product = $capacity[$i][0];
                    $qty = $capacity[$i][1];

                    $vehiclecapacity = $this->model('Distributor')->vehicleCapacity($user_id, $number, $product, $qty);
                }
            
                if($addvehicle && $vehiclecapacity) {
                    //if data inserted
                    $ifdatainserted = $this->model('Distributor')->ifDataInserted($number);
                    if(mysqli_num_rows($ifdatainserted) > 0) {
                        $row = mysqli_fetch_assoc($ifdatainserted);
                        $_SESSION['user_id'] = $row['distributor_id'];
                        // echo "success";
                    }
                }else {
                    echo "Something went wrong!";
                }
            }
        }else {
            echo "All input fields are required!";
        }

        $this->distributor();

    }

    public function viewvehicle() {
        $user_id = $_SESSION['user_id'];
        $data['navigation'] = 'vehicles';

        $distributor_details = $this->model('Distributor')->getDistributorImage($user_id);
        $row = mysqli_fetch_assoc($distributor_details);
        $data['image'] = $row['image'];

        $vehicle =  $this->model('Distributor')->viewvehicle($user_id);

        $data['viewvehicles'] = $this->model('Distributor')->viewvehicle($user_id);
        $this->view('distributor/view_vehicles', $data);
    }

    public function updatevehicle() {
        $user_id = $_SESSION['user_id'];
        $data['navigation'] = 'vehicles';

        $distributor_details = $this->model('Distributor')->getDistributorImage($user_id);
        $row = mysqli_fetch_assoc($distributor_details);
        $data['image'] = $row['image'];

        $this->view('distributor/updateVehicle', $data);
    }

}
