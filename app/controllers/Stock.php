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
        $this->AuthorizeLogin();
        $this->user_id = $_SESSION['user_id'];
    }

    function dealer($param = null, $error = null) {
        $this->AuthorizeUser('dealer');

        // navigation and active tab in body
        $data['navigation'] = 'stock';
        $data['tab'] = $param;
        if($error != null) {$data['toast'] = $error;}
        $data[$data['tab']] = $this->model('Dealer')->dealerStock($this->user_id, $data['tab']);
        $this->view('dealer/stock', $data);
    }

    public function dealerpoplace($param=null){
        $this->AuthorizeUser('dealer');

        $productid = $_SESSION['productarray'];
        $postproducts = [];
        for($i=0; $i<count($productid); $i++){
            $postproducts[$productid[$i]] = $_POST[$productid[$i]];
        }
        $data = $this->model('Dealer')->dealerpoplace($this->user_id, $productid, $postproducts);
        if(isset($data['toast'])){
            $this->dealer("purchaseorder", $data['toast']);
        }else{
            $this->view("/dealer/reports/purchaseorder", $data);
        }
    }

    public function dealerpoinfo($poid=null){
        $this->AuthorizeUser('dealer');
        
        if($poid!= null){
            $data = $this->model('Dealer')->dealerpoinfo($poid);
            return $this->view("dealer/poinfo", $data);
        }
    }
}