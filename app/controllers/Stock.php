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

    function dealer($param = null){
        // navigation and active tab in body
        $data['navigation'] = 'stock';
        $data['tab'] = $param;

        // profile picture & notifications
        $dealer_details = $this->model('Dealer')->getDealer($this->user_id);
        $row = mysqli_fetch_assoc($dealer_details);
        $data['image'] = $row['image'];

        // body data
        switch($data['tab']){
            case "currentstock":
                $data['current_stock'] = $this->model('Dealer')->getStockInfo($this->user_id);
                break;
            case "purchaseorder":
                $data['purchaseorder'] = $this->model('Dealer')->getPOForm($this->user_id);
                break;
            case "pohistory":
                $data['pohistory'] = $this->model('Dealer')->getPOHistory($this->user_id);
                break;
        }

        $this->view('dealer/stock', $data);
    }

    public function dealerpoplace($param=null){
        $productid = $_SESSION['productarray'];
        // capacity check
        $flag = false;
        for($i=0; $i<count($productid); $i++){
            $product = $productid[$i];
            // take current stock
            $current_stock = 0;
            $result = $this->model("Dealer")->dealerstockofproduct($this->user_id,$product);
            if(mysqli_num_rows($result)>0){
                $row = mysqli_fetch_assoc($result);
                $current_stock = $row['quantity'];
            }
            // take previously ordered but still pending amount
            $pending_stock = 0;
            $result = $this->model("Dealer")->dealerpoofpending($this->user_id);
            if(mysqli_num_rows($result)>0){
                while($row = mysqli_fetch_assoc($result)){
                    $po_id = $row['po_id'];
                    $result = $this->model("Dealer")->dealerpoincludesofpending($po_id,$product);
                    $row2 = mysqli_fetch_assoc($result);
                    $pending_stock += $row2['quantity'];
                }
            }

            // take capacity
            $capacity = 0;
            $result = $this->model("Dealer")->dealercapofproduct($this->user_id,$product);
            if(mysqli_num_rows($result)>0){
                $row = mysqli_fetch_assoc($result);
                $capacity = $row['capacity'];
            }
            if($_POST[$product] > ($capacity - $current_stock - $pending_stock)){
                $flag = true;
            }
            // post $productid <= capacity - current stock - pending stock
        }

        if($flag){
            // error handling needed.
            echo "Insufficient storage";
            exit();
        }

        // get distributor and company information
        $query1 = $this->model("Dealer")->getDealer($this->user_id);
        $row1 = mysqli_fetch_assoc($query1);
        $company_id = $row1['company_id'];
        $distributor_id = $row1['distributor_id'];
        $business_name = $row1['name'];

        date_default_timezone_set("Asia/Colombo");
        $place_time = date('H:i');
        $place_date = date('Y-m-d');

        
        $query3 = $this->model("Dealer")->placePurchaseOrder($this->user_id,$distributor_id,$place_date,$place_time);
        $query4 = $this->model("Dealer")->getPurchaseInfo($this->user_id);
        $row4 = mysqli_fetch_assoc($query4);
        $po_id = $row4['po_id'];

        for($i=0; $i<count($productid); $i++){
            $product = $productid[$i];
            $quantity = $_POST[$product];
            $query7 = $this->model("Dealer")->dealergetproductinfo($product);
            $row7 = mysqli_fetch_assoc($query7);
            $unit_price = $row7['unit_price'];
            $query7 = $this->model("Dealer")->dealerpoinclude($po_id,$product,$quantity,$unit_price);
            // if($query5){
            //     echo "success";
            // }
        }
        // echo "success";

        // rendering the pdf report
        // $result = mysqli_query($conn,"SELECT * FROM purchase_order WHERE dealer_id = $dealer_id ORDER BY po_id DESC LIMIT 1");
        $result = $this->model("Dealer")->dealerLastPO($this->user_id);
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_assoc($result);
            $po_id = $row['po_id'];
            $date = $row['place_date'];
            $time = $row['place_time'];

            $products = array();
            $total = 0;

            // $result = mysqli_query($conn,"SELECT pi.product_id as product_id,
            // p.name as product_name,
            // pi.quantity as quantity,
            // pi.unit_price as unit_price
            // FROM purchase_include pi INNER JOIN product p
            // ON pi.product_id = p.product_id
            // WHERE po_id = $po_id");
            $result = $this->model("Dealer")->dealerLastPOIncludes($po_id);
            if(mysqli_num_rows($result) > 0){
                while($row = mysqli_fetch_assoc($result)){
                    array_push($products, ['product_id' => $row['product_id'], 'product_name' => $row['product_name'], 'quantity' => $row['quantity'], 'unit_price' => $row['unit_price'], 'subtotal' => $row['unit_price']*$row['quantity']]);
                    $total += $row['unit_price']*$row['quantity'];
                }
            }

            $data = ['po_id'=>$po_id, 'dealer_id'=>$this->user_id, 'business_name'=>$business_name, 'distributor_id'=>$distributor_id, 'date'=>$date, 'time'=>$time, 'products'=>$products, 'total'=>$total];
        }
        $this->view("/dealer/reports/purchaseorder", $data);
    }
}