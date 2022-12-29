<?php
    session_start();
class Delvery extends Controller{
    function __construct(){
        
    }
    function deliveries(){
        $data['navigation'] = 'deliveries';
        $delivery_id=$_SESSION['user_id'];
        $delivery_details = $this->model('Delivery')->getDeliveryImage($delivery_id);
        $row = mysqli_fetch_assoc($delivery_details);
        $data['image'] = $row['image'];
            //$data=[];
        $this->view('dashboard/delivery', $data);
    }
    function currentdeliveries(){
        $data['navigation'] = 'currentgasdeliveries';
        $delivery_id=$_SESSION['user_id'];
        $delivery_details = $this->model('Delivery')->getDeliveryImage($delivery_id);
        $row = mysqli_fetch_assoc($delivery_details);
        $data['image'] = $row['image'];
            //$data=[];
        $this->view('dashboard/delivery', $data);
    }

    
}
?>