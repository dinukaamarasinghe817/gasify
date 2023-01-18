<?php
// AuthorizeLogin();
session_start();
// if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
//     header('Location: ' . BASEURL . '/home');
// }
class Stock extends Controller{
    public $user_id;
    function __construct(){
        parent::__construct();
        $this->user_id = $_SESSION['user_id'];
    }

    function dealer($param = null, $error = null) {
        // navigation and active tab in body
        $data['navigation'] = 'stock';
        $data['tab'] = $param;
        if($error != null) {$data['toast'] = ['type'=>'error', 'message'=>$error];}
        // profile picture & notifications
        $dealer_details = $this->model('Dealer')->getDealer($this->user_id);
        $row = mysqli_fetch_assoc($dealer_details);
        $data['image'] = $row['image'];
        $data['name'] = $row['first_name'].' '.$row['last_name'];
        $data[$data['tab']] = $this->model('Dealer')->dealerStock($this->user_id, $data['tab']);
        $this->view('dealer/stock', $data);
    }

    public function dealerpoplace($param=null){
        $productid = $_SESSION['productarray'];
        $postproducts = [];
        for($i=0; $i<count($productid); $i++){
            $postproducts[$productid[$i]] = $_POST[$productid[$i]];
        }
        $data = $this->model('Dealer')->dealerpoplace($this->user_id, $productid, $postproducts);
        if(isset($data['error'])){
            $this->dealer("purchaseorder", $data['error']);
        }else{
            $this->view("/dealer/reports/purchaseorder", $data);
        }
    }
}