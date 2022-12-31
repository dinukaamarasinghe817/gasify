<?php

class StockHTML{

    public function __construct($user, $data = null){
        $this->$user($data);
    }

    public function dealercurrentstock($data){
        $output = '
                                <table>
                                    <tr>
                                        <th>Product ID</th>
                                        <th>Name</th>
                                        <th>Weight</th>
                                        <th>Unit Price</th>
                                        <th>Quantity</th>
                                    </tr>';

            if(mysqli_num_rows($data['current_stock']) > 0){
                
                while($row = mysqli_fetch_assoc($data['current_stock'])){
                    // dynamic html
                    $output .= '<tr>
                                    <td>'.$row['product_id'].'</td>
                                    <td>'.$row['product_name'].'</td>
                                    <td>'.$row['product_weight'].' Kg</td>
                                    <td>Rs. '.$row['unit_price'].'</td>
                                    <td>'.$row['quantity'].'</td>
                                </tr>';
                }

            }
        $output .= '</table>'; // static html
        echo $output;
    }

    public function dealerpurchaseorder($data){
        $output = '
                    <div class="error-txt">
                        Insufficient storage
                    </div>
                    <form action="'.BASEURL.'/stock/dealerpoplace" target="_blank" class="po" method="post" onsubmit="pobuttonclicked(); return false;">
                    <table class="po">
                        <tr>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>';

                    
                        if(mysqli_num_rows($data['purchaseorder']) > 0){
                            $product_array = array();
                            $j = 0;

                            while($row = mysqli_fetch_assoc($data['purchaseorder'])){
                                $product_id = $row['product_id'];
                                $product_array[$j] = $product_id;
                                $j++;
                                // dynamic html
                                $output .= '<tr class="data'.$row['product_id'].'">
                                                <td>'.$row['product_id'].'</td>
                                                <td>'.$row['name'].'</td>
                                                <td><input type="number" name="'.$row['product_id'].'" min=0 onchange="changeqty('.$row['product_id'].','.$row['unit_price'].'); return false;"></td>
                                                <td class="subtotal">Rs. 0.00</td>
                                            </tr>'; // change subtotal manually when input changes.
                                
                            }

                            $_SESSION["productarray"] = $product_array;

                            $output .= '<tr class="total">
                                            <td></td>
                                            <td></td>
                                            <td>Total</td>
                                            <td class="amount">Rs. 0.00</td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><Button  type="submit">Submit</Button></td>
                                        </tr>'; // static html
                        }
                    
                    $output .= '</table>
                                </form>';
                    echo $output;
    }

    public function dealerpohistory($data){
        // get the dealer's stock information
        // $query2 = $this->Query("SELECT * FROM purchase_order WHERE  dealer_id = '{$unique_id}' ORDER BY po_id DESC");
        // $purchase_orders = array();
        $results = $data['pohistory'];
        $output = '<table class="history">
                            <tr>
                                <th>Purchase Order ID</th>
                                <th>Includes</th>
                                <th>Purchase Order State</th>
                                <th>Place Date</th>
                                <th>Place Time</th>
                            </tr>';
        if(count($results) > 0){
            foreach($results as $result){
                $row2 = $result['purchase_order'];
                $poitems = $result['products'];
                $output .= '<tr>
                                <td>'.$row2['po_id'].'</td>
                                <td>';
                
                $output .= '<table class = "innertable">
                                <tr>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                </tr>';
                foreach($poitems as $row3){
                    $output .= '<tr>
                                    <td>'.$row3['name'].'</td>
                                    <td>'.$row3['quantity'].'</td>  
                                </tr>';
                }
                $time = $row2['place_time']; 
                $time = date('h:i a', strtotime($time));                
                $output .=      '</table></td>
                                <td>'.$row2['po_state'].'</td>
                                <td>'.$row2['place_date'].'</td>
                                <td>'.$time.'</td>
                            </tr>';
                
            }
            $output .= '</table>';
        }else{
            $output .= '</table>'; // static html
            $output .= '<p style="text-align: center; width: 100%;">no records found</p>';
        }
        echo $output;
        // if(mysqli_num_rows($query2) > 0){
        //     while($row2 = mysqli_fetch_assoc($query2)){
        //             // $output .= '<tr>
        //             //                 <td>'.$row2['po_id'].'</td>
        //             //                 <td>';
                    
        //             // $output .= '<table class = "innertable">
        //             //                 <tr>
        //             //                 <th>Product Name</th>
        //             //                 <th>Quantity</th>
        //             //                 </tr>';
                    
        //             $sql = "SELECT pi.product_id AS product_id, pi.quantity AS quantity, pr.name AS name 
        //                     FROM purchase_include pi 
        //                     INNER JOIN product pr 
        //                     ON pi.product_id = pr.product_id 
        //                     WHERE pi.po_id = '{$row2['po_id']}'";
        //             $result3 = $this->Query($sql);
        //             $products = array();
        //             if(mysqli_num_rows($result3)>0){
        //                 while($row3 = mysqli_fetch_assoc($result3)){
        //                     // $output .= $row3['name'].' - '.$row3['quantity'].'<br>';
        //                     array_push($products, $row3);
        //                     $output .= '<tr>
        //                                     <td>'.$row3['name'].'</td>
        //                                     <td>'.$row3['quantity'].'</td>  
        //                                 </tr>';
        //                 }
        //                 array_push($purchase_orders, ['purchase_order' => $row2, 'products' => $products]);
        //             }else{
        //                 // $output .= 'unsuccess';
        //             }

        //             $output .= '</table>';
                                    
        //             $output .=      '</td>
        //                             <td>'.$row2['po_state'].'</td>
        //                             <td>'.$row2['place_date'].'</td>
        //                             <td>'.$row2['place_time'].'</td>
        //                         </tr>'; // change subtotal manually when input changes.
        //         // }
        //     }

        //     // $_SESSION["productarray"] = $product_array;

        //     $output .= '</table>'; // static html
        // }else{
        //     $output .= '</table>'; // static html
        //     $output .= '<p style="text-align: center; width: 100%;">no records found</p>';
        //     // echo $output;
        // }
        // echo $output;
    }

}