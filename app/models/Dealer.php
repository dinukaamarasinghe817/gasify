<?php

class Dealer extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getAllDealers(){  
        $result = $this->Query("SELECT CONCAT(u.first_name,' ',u.last_name) AS name, u.email AS email, CONCAT(d.street,', ',d.city) AS address, d.contact_no AS contact FROM dealer d INNER JOIN users u ON d.dealer_id = u.user_id");
        $data = [];
        if(mysqli_num_rows($result)>0){
            $info = array();
            while($row = mysqli_fetch_assoc($result)){
                array_push($info,['name'=>$row['name'], 'email'=>$row['email'], 'address'=>$row['address'], 'contact'=>$row['contact']]);
            }
            $data['dealer'] = $info;
        }
        return $data['dealer'];
    }

    // public function getDealer($email){
    //     // $sql = "SELECT u.user_id as dealer_id,
    //     //         u.first_name as first_name,
    //     //         u.last_name as last_name,
    //     //         u.email as email,
    //     //         u.password as password,
    //     //         u.verification_code as verification_code,
    //     //         u.verification_state as verification_state
    //     //         d.image as image
    //     //         FROM users u
    //     //         INNER JOIN dealer d
    //     //         ON u.user_id = d.dealer_id";
    //     $result = $this->read('users', "email = '$email' AND type = 'dealer'");
    //     // $result = $this->Query($sql);
    //     return $result;
    // }

    public function getDealer($dealer_id){
        $result = $this->read('dealer', "dealer_id = $dealer_id");
        return $result;
    }

    public function setCapacity($dealer_id, $company_id, $product, $qty){
        $result = $this->insert('dealer_capacity',['dealer_id'=> $dealer_id,'company_id'=> $company_id,'product_id'=>$product,'capacity'=>$qty]);
        return $result;
    }

    public function getcurrentstock($dealer_id){
        // direct query since joins used
        $result = $this->Query("SELECT dealer_keep.quantity as quantity, product.name as name
        FROM dealer_keep INNER JOIN product 
        ON dealer_keep.product_id = product.product_id 
        WHERE dealer_id = '$dealer_id'");
        return $result;
    }

    public function dealerstockofproduct($dealer_id, $product){
        $result = $this->Query("SELECT * FROM dealer_keep WHERE dealer_id = '{$dealer_id}' AND product_id = '{$product}'");
        return $result;
    }

    public function dealerpoofpending($dealer_id){
        $result = $this->Query("SELECT * FROM purchase_order WHERE dealer_id = '{$dealer_id}' AND po_state = 'pending'");
        return $result;
    }

    public function dealerpoincludesofpending($po_id,$product){
        $result = $this->Query("SELECT * FROM purchase_include WHERE po_id = '{$po_id}' AND product_id = '{$product}'");
        return $result;
    }

    public function dealercapofproduct($dealer_id,$product){
        $result = $this->Query("SELECT * FROM dealer_capacity WHERE dealer_id = '{$dealer_id}' AND product_id = '{$product}'");
        return $result;
    }

    public function dealergetproductinfo($product){
        $result = $this->Query("SELECT unit_price FROM product WHERE product_id = '$product'");
        return $result;
    }

    public function dealerpoinclude($po_id,$product,$quantity,$unit_price){
        $result = $this->Query("INSERT INTO purchase_include (po_id, product_id, quantity, unit_price) VALUES ($po_id,'$product',$quantity,$unit_price)");
        return $result;
    }

    public function getPOForm($dealer_id){
        $result = $this->Query("SELECT d.product_id as product_id, p.name as name, p.unit_price as unit_price
        FROM dealer_capacity d INNER JOIN product p
        ON d.product_id = p.product_id 
        WHERE dealer_id = '$dealer_id'");
        return $result;
    }

    public function placePurchaseOrder($dealer_id,$distributor_id,$place_date,$place_time){
        $result = $this->Query("INSERT INTO purchase_order (dealer_id,po_state,distributor_id,place_date,place_time) VALUES ('{$dealer_id}','pending','{$distributor_id}','{$place_date}','{$place_time}');");
        return $result;
    }

    public function getPurchaseInfo($dealer_id){
        $result = $this->Query("SELECT * FROM purchase_order WHERE dealer_id = '{$dealer_id}' ORDER BY place_date DESC, place_time DESC LIMIT 1");
        return $result;
    }

    public function dealerLastPO($dealer_id){
        $result = $this->Query("SELECT * FROM purchase_order WHERE dealer_id = $dealer_id ORDER BY po_id DESC LIMIT 1");
        return $result;
    }

    public function dealerLastPOIncludes($po_id){
        $result = $this->Query("SELECT pi.product_id as product_id,
        p.name as product_name,
        pi.quantity as quantity,
        pi.unit_price as unit_price
        FROM purchase_include pi INNER JOIN product p
        ON pi.product_id = p.product_id
        WHERE po_id = $po_id");
        return $result;
    }
    
    public function getpendigorders($dealer_id){
        $orders = array();
        // $result = $this->read('reservation', "dealer_id = $dealer_id AND order_state = 'pending'");
        $sql = "SELECT r.order_id as order_id,r.customer_id as customer_id, CONCAT(u.first_name,' ',u.last_name) as customer_name 
                FROM reservation r
                INNER JOIN
                customer c
                ON r.customer_id = c.customer_id
                INNER JOIN
                users u
                ON c.customer_id = u.user_id
                WHERE r.dealer_id = $dealer_id
                AND r.order_state = 'pending'";
        $result = $this->Query($sql);
        if(mysqli_num_rows($result) > 0){
            while($row = mysqli_fetch_assoc($result)){
                $products = array();
                $order_id = $row['order_id'];
                // $result2 = $this->read('reservation_include',"order_id = $order_id");
                $sql = "SELECT r.quantity as qty,p.name as product_name
                        FROM reservation_include r
                        INNER JOIN
                        product p
                        ON r.product_id = p.product_id
                        WHERE r.order_id = $order_id";
                $result2 = $this->Query($sql);
                if(mysqli_num_rows($result2) > 0){
                    while($row2 = mysqli_fetch_assoc($result2)){
                        array_push($products, $row2);
                    }
                }
                array_push($orders, ['row' => $row, 'products' => $products]);
            }
        }

        return $orders;
    }

    public function getStockInfo($dealer_id){
        $result = $this->Query("SELECT p.product_id as product_id,p.name as product_name,
        p.weight as product_weight,p.unit_price as unit_price,p.quantity as quantity
        FROM product p INNER JOIN dealer_keep d ON p.product_id = d.product_id WHERE d.dealer_id = $dealer_id");
        return $result;
    }

    public function getPOHistory($dealer_id){
        // get the dealer's stock information
        $query2 = $this->Query("SELECT * FROM purchase_order WHERE  dealer_id = '{$dealer_id}' ORDER BY po_id DESC");
        $purchase_orders = array();
        // $output = '<table class="history">
        //                     <tr>
        //                         <th>Purchase Order ID</th>
        //                         <th>Includes</th>
        //                         <th>Purchase Order State</th>
        //                         <th>Place Date</th>
        //                         <th>Place Time</th>
        //                     </tr>';

        if(mysqli_num_rows($query2) > 0){
            while($row2 = mysqli_fetch_assoc($query2)){
                    // $output .= '<tr>
                    //                 <td>'.$row2['po_id'].'</td>
                    //                 <td>';
                    
                    // $output .= '<table class = "innertable">
                    //                 <tr>
                    //                 <th>Product Name</th>
                    //                 <th>Quantity</th>
                    //                 </tr>';
                    
                    $sql = "SELECT pi.product_id AS product_id, pi.quantity AS quantity, pr.name AS name 
                            FROM purchase_include pi 
                            INNER JOIN product pr 
                            ON pi.product_id = pr.product_id 
                            WHERE pi.po_id = '{$row2['po_id']}'";
                    $result3 = $this->Query($sql);
                    $products = array();
                    if(mysqli_num_rows($result3)>0){
                        while($row3 = mysqli_fetch_assoc($result3)){
                            // $output .= $row3['name'].' - '.$row3['quantity'].'<br>';
                            array_push($products, $row3);
                            // $output .= '<tr>
                            //                 <td>'.$row3['name'].'</td>
                            //                 <td>'.$row3['quantity'].'</td>  
                            //             </tr>';
                        }
                        array_push($purchase_orders, ['purchase_order' => $row2, 'products' => $products]);
                    }else{
                        // $output .= 'unsuccess';
                    }

                    // $output .= '</table>';
                                    
                    // $output .=      '</td>
                    //                 <td>'.$row2['po_state'].'</td>
                    //                 <td>'.$row2['place_date'].'</td>
                    //                 <td>'.$row2['place_time'].'</td>
                    //             </tr>'; // change subtotal manually when input changes.
                // }
            }

            // $_SESSION["productarray"] = $product_array;

            // $output .= '</table>'; // static html
        }else{
            // $output .= '</table>'; // static html
            // $output .= '<p style="text-align: center; width: 100%;">no records found</p>';
            // echo $output;
        }
        // echo $output;
        return $purchase_orders;
    }
}