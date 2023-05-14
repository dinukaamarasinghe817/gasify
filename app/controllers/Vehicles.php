<?php
// AuthorizeLogin();
session_start();
// if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
//     header('Location: ' . BASEURL . '/home');
// }
class Vehicles extends Controller{
    function __construct(){
        parent::__construct();
        $this->AuthorizeLogin();
    }

    // add vehicle interface
    public function distributor($error=null,$success = null){
        $this->AuthorizeUser('distributor');

        $user_id = $_SESSION['user_id'];
        $data['navigation'] = 'vehicles';
        // profile picture & notifications
        $distributor_details = $this->model('Distributor')->getDistributorImage($user_id);
        $row = mysqli_fetch_assoc($distributor_details);
        $data['image'] = $row['image'];

        $data['confirmation'] = '';
        // display success and error messages
        if($error != null){
            $data['toast'] = ['type' => 'error', 'message' => $error];
        }
        if($success != null){
            $data['toast'] = ['type' => 'success', 'message' => $success];
            
        }
        // body data
        $data['vehicles'] = $this->model('Distributor')->getVehicleInfo($user_id);
        $this->view('distributor/add_vehicles', $data);

    }

    // add vehicle
    public function addvehicle() {
        $this->AuthorizeUser('distributor');

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
                $data['error'] =  "$number - This vehicle number already added";

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
                        $data['success'] = "Successsfully added vehicle!";
                    }
                }else {
                    $data['error'] = "Something went wrong!";
                }
            }
        }else {
            $data['error'] = "All input fields are required!";
        }

        if(isset($data['error'])){
            $this->distributor($data['error'],null);
        }else if(isset($data['success'])){
            $this->distributor(null,$data['success']);
        }else{
            $this->distributor();
        }
        

    }
    
    // view vehicles
    public function viewvehicle() {
        $this->AuthorizeUser('distributor');

        $user_id = $_SESSION['user_id'];
        $data['navigation'] = 'vehicles';

        $distributor_details = $this->model('Distributor')->getDistributorImage($user_id);
        $row = mysqli_fetch_assoc($distributor_details);
        $data['image'] = $row['image'];
        
        $data['vehicles'] = $this->model("Distributor")->viewvehicle($user_id);


        $this->view('distributor/view_vehicles', $data);
    }
    
    // update vehicle page (view page)
    public function updateVehiclePage($vehicle_no) {
        $this->AuthorizeUser('distributor');

        $user_id = $_SESSION['user_id'];
       
        $capacity = array();

        $data['navigation'] = 'vehicles';

        $distributor_details = $this->model('Distributor')->getDistributorImage($user_id);
        $row = mysqli_fetch_assoc($distributor_details);
        $data['image'] = $row['image'];

        $data['updateproduct'] = $this->model("Distributor")->updatevehicle($user_id, $vehicle_no);

        $this->view('distributor/updateVehiclePage', $data);
    }

    public function updateVehicle($vehicle_no){
        $this->AuthorizeUser('distributor');

       $this->model("Distributor")->updatingVehicle( $vehicle_no);
       $this->updateVehiclePage($vehicle_no);

    }

    // release a vehicle
    public function releasing($vehicle_no,$success=null) {
        $this->AuthorizeUser('distributor');

        $data['confirmation'] = '';
        if($success != null){
            $data['toast'] = ['type' => 'success', 'message' => $success];
            
        }
        $data['releasevehicle'] = $this->model("Distributor")->releaseVehicle($vehicle_no);
        $this->viewvehicle($data);
    }

    // remove a vehicle
    public function removeVehicle($vehicle_no) {
        $this->AuthorizeUser('distributor');

        $this->model("Distributor")->removeVehicle($vehicle_no);
        $this->viewvehicle();  

    }

    public function updatesinglevehicle($number){
        $this->AuthorizeUser('distributor');
        
        $data = $this->model('Distributor')->updatesinglevehicle($number);
        $this->view('',$data);
    }

}
