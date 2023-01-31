<?php
    session_start();
class Delvery extends Controller{
    public $user_id;
    function __construct(){
        $this->user_id = $_SESSION['user_id'];
    }
    function deliveries(){
        $data['navigation'] = 'deliveries';
        $delivery_id=$_SESSION['user_id'];
        $delivery_details = $this->model('Delivery')->getDeliveryImage($delivery_id);
        $pool_details=$this->model('Delivery')->getPoolDetails();
        $row = mysqli_fetch_assoc($delivery_details);
        $data['image'] = $row['image'];
        $data['pool']=$pool_details;
            //$data=[];
        $this->view('dashboard/delivery', $data);
    }
    function currentdeliveries(){
        $data['navigation'] = 'currentgasdeliveries';
        $delivery_id=$_SESSION['user_id'];
        $delivery_details = $this->model('Delivery')->getDeliveryImage($delivery_id);
        $current_reliveries=$this->model('Delivery')->getCurrentDeliveries($delivery_id);
        $row = mysqli_fetch_assoc($delivery_details);
        $data['current']=$current_reliveries;
        $data['image'] = $row['image'];
            //$data=[];
        $this->view('dashboard/delivery', $data);
    }
    function acceptDelivery(){
        

    }
    function reviews(){
        $data['navigation'] = 'reviews';
        $delivery_id=$_SESSION['user_id'];
        $delivery_details = $this->model('Delivery')->getDeliveryImage($delivery_id);
        //$current_reliveries=$this->model('Delivery')->getCurrentDeliveries($delivery_id);
        $row = mysqli_fetch_assoc($delivery_details);
        //$data['current']=$current_reliveries;
        $data['image'] = $row['image'];
            //$data=[];
        $this->view('dashboard/delivery', $data);
    }

    public function getdeliverypeople($option){
        $data = $this->model("Dealer")->getdeliverypeople($option,$this->user_id);
        $row = mysqli_fetch_assoc($this->model('Dealer')->getDealer($this->user_id));
        $data['image'] = $row['image'];
        $data['name'] = $row['first_name'].' '.$row['last_name'];
        $data['navigation'] = 'delivery';
        $data['option'] = $option;
        $this->view('dealer/deliverpeople',$data);
    }
    
}
?>
