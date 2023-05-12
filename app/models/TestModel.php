<?php

class TestModel extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function test(){
        $dealer_id = 61;
        $risk_products = array('31'=>'Buddy',"32"=>'Budget');
            $mailproducts = "";
            foreach($risk_products as $product_id => $value){
                // take product image, ro-level, current stock
                // echo $product_id;
                $sql = "SELECT p.image AS image, dk.reorder_level AS threshold, dk.quantity AS quantity FROM dealer_keep dk INNER JOIN product p ON dk.product_id = p.product_id WHERE dk.dealer_id = $dealer_id AND dk.product_id = $product_id";
                $prow = mysqli_fetch_assoc($this->Query($sql));
                // prepare replacements
                $swap_products = array(
                    "{PRODUCT_IMG}"=>$prow['image'], 
                    "{THRESHOLD}"=>$prow['threshold'],
                    "{CURRENT_STOCK}"=>$prow['quantity']);
                $prow = file_get_contents('./emailTemplates/reorderproduct.php');
                // replace
                foreach(array_keys($swap_products) as $key){
                    if(strlen($key) > 2 && trim($key) != ""){
                        $prow = str_replace($key,$swap_products[$key],$prow);
                    }
                }
                // $message .= " $value,";
                $mailproducts .= $prow;
            }
            // $message = rtrim($message,',');
            // $message .= " please hurry up and place a purchase order. Otherwise you will not be having enough stock to sell.";
            // $this->insert('notifications',['user_id' => $dealer_id, 'date'=>$place_date, 'time'=>$place_time, 'type'=> 'Re-order Level Alert', 'message' => $message, 'state'=>'delivered']);
            
            // send a mail as well
            $q = mysqli_fetch_assoc($this->read('users',"user_id = $dealer_id"));
            // prepare replacements
            $swap_reorder = array(
                "{RECIEVER_NAME}"=> $q['first_name'].' '.$q['last_name'],
                "{STOCK_LINK}"=> BASEURL.'/stock/dealer/currentstock',
                "{PRODUCT_DETAILS}"=>$mailproducts
            );
            // template
            $mailbody = file_get_contents('./emailTemplates/reorderlevel.php');
            // replace
            foreach(array_keys($swap_reorder) as $key){
                if(strlen($key) > 2 && trim($key) != ""){
                    $mailbody = str_replace($key,$swap_reorder[$key],$mailbody);
                }
            }
            // $q = mysqli_fetch_assoc($this->read('users',"user_id = $customer_id"));
            // $customer_Name = $q['first_name'].' '.$q['last_name'];
            $mail = new Mail('admin@gasify.com',$q['email'],$q['first_name'].' '.$q['last_name'],'Re-Order Alert',$mailbody,$link=null);
            $mail->send();
    }

    public function testpayment(){
        $row = mysqli_fetch_assoc($this->read('dealer',"dealer_id = 61"));
        echo $row['pub_key'];
        echo '<br>';
        echo decryptStripeKey($row['pub_key']);
    }
}
?>