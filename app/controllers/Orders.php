<?php

class Orders extends Controller{
    function __construct(){
        parent::__construct();
    }

    function dealer(){
        $data['navigation'] = 'orders';
        $dealer_details = $this->model('Dealer')->getDealerImage($dealer_id);
        $row = mysqli_fetch_assoc($dealer_details);
        $data['image'] = $row['image'];
        $this->view('dashboard/dealer', $data);
    }
}
?>