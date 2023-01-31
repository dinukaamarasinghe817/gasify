<?php

class StockHTML{

    public function __construct($user, $data = null){
        $this->$user($data);
    }

    public function dealercurrentstock($data){
        $output = '
                                <table class="styled-table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Name</th>
                                        <th>Weight</th>
                                        <th>Unit Price</th>
                                        <th>Quantity</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    ';

            if(mysqli_num_rows($data['currentstock']) > 0){
                
                while($row = mysqli_fetch_assoc($data['currentstock'])){
                    // dynamic html
                    $output .= '<tr>
                                    <td><img class="littleproduct" src="'.BASEURL.'/public/img/products/'.$row['image'].'"></td>
                                    <td>'.$row['product_name'].'</td>
                                    <td>'.$row['product_weight'].' Kg</td>
                                    <td>Rs. '.$row['unit_price'].'</td>
                                    <td>'.$row['quantity'].'</td>
                                </tr>';
                }

            }
        $output .= '</tbody></table>'; // static html
        echo $output;
    }

    public function dealerpurchaseorder($data){
        $output = '';
        if(isset($data['error'])){
            // $output .= '
            // <div class="error-txt">
            //     <p>'.$data['error'].'</p>
            //     <a onclick="errorclose();">
            //     <svg width="25" height="25" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
            //         <path d="M17.6682 32.2388C25.9525 32.2388 32.6682 25.523 32.6682 17.2388C32.6682 8.9545 25.9525 2.23877 17.6682 2.23877C9.38391 2.23877 2.66818 8.9545 2.66818 17.2388C2.66818 25.523 9.38391 32.2388 17.6682 32.2388Z" stroke="" stroke-width="3.91255" stroke-linecap="round" stroke-linejoin="round"/>
            //         <path d="M22.1682 12.7388L13.1682 21.7388" stroke="" stroke-width="3.91255" stroke-linecap="round" stroke-linejoin="round"/>
            //         <path d="M13.1682 12.7388L22.1682 21.7388" stroke="" stroke-width="3.91255" stroke-linecap="round" stroke-linejoin="round"/>
            //     </svg>
            //     </a>
            // </div>
            // <script src="'.BASEURL.'/public/js/Dealer/signup.js"></script>';
        }
        $output .= '<form action="'.BASEURL.'/stock/dealerpoplace" class="po" method="post" onsubmit="pobuttonclicked(); return false;">
                    <table class="po styled-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                        </tr>
                        </thead>
                        <tbody>
                        ';

                    
                        if(mysqli_num_rows($data['purchaseorder']) > 0){
                            $product_array = array();
                            $j = 0;

                            while($row = mysqli_fetch_assoc($data['purchaseorder'])){
                                $product_id = $row['product_id'];
                                $product_array[$j] = $product_id;
                                $j++;
                                // dynamic html
                                $output .= '<tr class="data'.$row['product_id'].'">
                                                <td><img class="littleproduct" src="'.BASEURL.'/public/img/products/'.$row['image'].'"></td>
                                                <td>'.$row['name'].'</td>
                                                <td><input type="number" step="1" value=0 name="'.$row['product_id'].'" min=0 onchange="changeqty('.$row['product_id'].','.$row['unit_price'].'); return false;"></td>
                                                <td class="subtotal">Rs. 0</td>
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
                    
                    $output .= '</tbody></table>
                                </form>';
                    echo $output;
    }

    public function dealerpohistory($data){
        // get the dealer's stock information
        // $query2 = $this->Query("SELECT * FROM purchase_order WHERE  dealer_id = '{$unique_id}' ORDER BY po_id DESC");
        // $purchase_orders = array();
        $results = $data['pohistory'];
        $output = '<table class="history styled-table">
                        <thead>
                            <tr>
                                <th>Purchase Order ID</th>
                                <th>Purchase Order State</th>
                                <th>Place Date</th>
                                <th>Place Time</th>
                                <th>Products</th>
                            </tr>
                        </thead>
                        <tbody>';
        if(count($results) > 0){
            foreach($results as $result){
                $row2 = $result['purchase_order'];
                $poitems = $result['products'];
                $poid = $row2['po_id'];
                $time = $row2['place_time']; 
                $time = date('h:i a', strtotime($time)); 
                $output .= "<tr>
                                <td>".$row2['po_id']."</td>
                                <td>".$row2['po_state']."</td>
                                <td>".$row2['place_date']."</td>
                                <td>".$time."</td>
                                <td><button onclick='poinfo($poid); return false;'>View</button></td>
                            </tr>";
                
            }
            $output .= '</tbody></table>';
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