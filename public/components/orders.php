<?php

class Order{
    function __construct($tuple,$active1,$active2){
        $order = $tuple['order'];
        $products = $tuple['products'];
        if(isset($tuple['payment']) && isset($tuple['stock'])){
            $payment = $tuple['payment'];
            $stock = $tuple['stock'];
        }
        $totalamount = $tuple['total_amount'];
        echo '<li>
                <div class="order">
                    <div class="head">
                        <div class="details">
                            <div><strong>Order ID : </strong>'.$order['order_id'].'<br><strong>Total amount : </strong>Rs.'.$totalamount.'</div>
                            <div><strong>Date : </strong>'.$order['place_date'].'<br><strong>Time : </strong>'.$order['place_time'].'</div>
                        </div>';
                        if($active1 == 'pending' && !($payment == 'verified' && $stock == 'available')){
                            echo '<button onclick="orderverification(\''.$payment.'\',\''.$stock.'\'); return false;" class="btn gray">Info</button>';
                        }else if($active1 == 'pending'){
                            echo '<button onclick="location.href = \''.BASEURL.'/orders/dealeraccept/'.$order['order_id'].'\'" class="btn">Accept</button>';
                        }else if($active1 == 'accepted' && $active2 == 'pickup'){
                            // pick up orders
                            echo '<button onclick="location.href = \''.BASEURL.'/orders/dealerissue/'.$order['order_id'].'\'" class="btn">Issue</button>';
                        }else if($active1 == 'accepted' && $active2 == 'delivery' && $order['priority'] == 1){
                            // priritized orders
                            echo '<button onclick="location.href = \''.BASEURL.'/orders/dealerissue/'.$order['order_id'].'\'" class="btn">Issue</button>';
                        }else if($active1 == 'canceled' && $order['refund_verification'] == 'verified'){
                            echo '<button class="btn transparent">Refunded</button>';
                        }else if($active1 == 'canceled' && $order['refund_verification'] == 'pending'){
                            echo '<button class="btn transparent">Pending</button>';
                        }else if($active1 == 'canceled'){
                            $forewardlink = BASEURL.'/orders/dealerrefund/'.$order['order_id'];
                            $backwardlink = 'dealerprompt();';
                            $formlink = BASEURL.'/orders/dealersubmitpayslip/'.$order['order_id'];
                            echo '<button onclick="dealerprompt(\'orderrefund\',\''.$forewardlink.'\',\''.$backwardlink.'\',\''.$formlink.'\')" class="btn">Refund</button>';
                        }
                        echo '
                            <svg width="22" height="22" viewBox="0 0 36 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 3L17.9551 17.9551L32.9102 3" stroke="#FCFCFC" stroke-opacity="0.97" stroke-width="6.98504" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                    </div>
                    <div class="info">
                        <div><p><strong>Customer ID : </strong>'.$order['customer_id'].'</p><p><strong>Customer Name : </strong>'.$order['first_name'].' '.$order['last_name'].'</p></div><br>';
                        if($active2 != 'delivery' && ($active1 == 'dispatched' || $active1 == 'delivered' || $active1 == 'completed')){
                            echo '<div><p><strong>Delivery ID : </strong>'.$order['delivery_id'].'</p><p><strong>Delivery Name : </strong>'.$order['delivery_first_name'].' '.$order['delivery_last_name'].'</p></div><br>';
                        }
                    echo '<table class="styled-table">
                            <thead>
                            <tr>
                                <th>Product ID</th>
                                <th>Product Name</th>
                                <th>Unit Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                            </tr>
                            </thead>
                            <tbody>';
                            foreach($products as $product){
                                echo '<tr>
                                    <td>'.$product['product_id'].'</td>
                                    <td>'.$product['name'].'</td>
                                    <td>Rs.'.$product['unit_price'].'</td>
                                    <td>'.$product['quantity'].'</td>
                                    <td>Rs.'.$product['unit_price']*$product['quantity'].'</td>
                                </tr>';
                            }
                    echo   '<tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><strong>Total</strong></td>
                                <td><strong>Rs.'.$totalamount.'</strong></td>
                            </tr>
                            </tbody></table>';

                            if(mysqli_num_rows($tuple['reviews']) > 0){
                                echo "<h3 class='reviewhead'>Reviews</h3>";
                                while($review = mysqli_fetch_assoc($tuple['reviews'])){
                                    $time = date('Y, M j, h:i a',strtotime($review['date'].' '.$review['time']));
                                    echo '<div class="review">
                                    <p>'.$review['message'].'</p>
                                    <p class="gray">'.$time.'</p>
                                    </div>';
                                }
                            }
                        echo '
                    </div>
                </div>
            </li>';
    }
}

class OrdersHTML{
    function __construct($active1,$active2,$data){
        $func = $active1.''.$active2;
        
        echo '<section class="body-content">
                <div class="top-panel">
                    <ul>';
                    if($active1 == 'pending'){
                        echo '<li><a href="'.BASEURL.'/orders/dealer/pending" class="current active">Pending</a></li>';
                    }else{
                        echo '<li><a href="'.BASEURL.'/orders/dealer/pending" class="current">Pending</a></li>';
                    }
                    if($active1 == 'accepted'){
                        echo '<li><a href="'.BASEURL.'/orders/dealer/accepted/pickup" class="current active">Accepted</a></li>';
                    }else{
                        echo '<li><a href="'.BASEURL.'/orders/dealer/accepted/pickup" class="current">Accepted</a></li>';
                    }
                    if($active1 == 'dispatched'){
                        echo '<li><a href="'.BASEURL.'/orders/dealer/dispatched" class="current active">Dispatched</a></li>';
                    }else{
                        echo '<li><a href="'.BASEURL.'/orders/dealer/dispatched" class="current">Dispatched</a></li>';
                    }
                    if($active1 == 'delivered'){
                        echo '<li><a href="'.BASEURL.'/orders/dealer/delivered" class="current active">Delivered</a></li>';
                    }else{
                        echo '<li><a href="'.BASEURL.'/orders/dealer/delivered" class="current">Delivered</a></li>';
                    }
                    if($active1 == 'completed'){
                        echo '<li><a href="'.BASEURL.'/orders/dealer/completed" class="current active">Completed</a></li>';
                    }else{
                        echo '<li><a href="'.BASEURL.'/orders/dealer/completed" class="current">Completed</a></li>';
                    }
                    if($active1 == 'canceled'){
                        echo '<li><a href="'.BASEURL.'/orders/dealer/canceled" class="current active">Canceled</a></li>';
                    }else{
                        echo '<li><a href="'.BASEURL.'/orders/dealer/canceled" class="current">Canceled</a></li>';
                    }
                    echo '</ul>';
        if($active2 != null){
                echo '<ul>';
                        if($active2 == 'pickup'){
                            echo '<li><a href="'.BASEURL.'/orders/dealer/'.$active1.'/pickup" class="current sub1 active">Pickup</a></li>';
                        }else{
                            echo '<li><a href="'.BASEURL.'/orders/dealer/'.$active1.'/pickup" class="current sub1">Pickup</a></li>';
                        }
                        if($active2 == 'delivery'){
                            echo '<li><a href="'.BASEURL.'/orders/dealer/'.$active1.'/delivery" class="current sub1 active">Delivery</a></li>';
                        }else{
                            echo '<li><a href="'.BASEURL.'/orders/dealer/'.$active1.'/delivery" class="current sub1">Delivery</a></li>';
                        }
                echo '</ul>';
        }
        echo '</div>';
        $this->func($active1,$active2,$data);
        echo '</section>';
    }

    public function func($active1,$active2,$data){
        echo '<div class="content-data">';
                    // <div class="search-bar">
                    //     <input type="text" class="ticker-input" placeholder="Type to search" autocomplete="off">
                    //     <button class="btn btn-primary" type="submit">
                    //         <svg width="23" height="24" viewBox="0 0 23 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    //             <path d="M10.5417 19C14.7759 19 18.2083 15.4183 18.2083 11C18.2083 6.58172 14.7759 3 10.5417 3C6.30748 3 2.875 6.58172 2.875 11C2.875 15.4183 6.30748 19 10.5417 19Z" stroke="#FFF8F3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    //             <path d="M20.1248 20.9999L15.9561 16.6499" stroke="#FFF8F3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    //         </svg>
                    //         <p>Search</p>
                    //     </button>
                    // </div>
                    $orders = $data['orders'];
                if(count($orders) > 0){
                    echo '<ul>';
                        
                        foreach($orders as $tuple){
                            $o = new Order($tuple,$active1,$active2);
                        }
                    echo '</ul>';
                }else{
                    echo '<div class="noorders">
                        <img src="'.BASEURL.'/public/img/placeholders/noorders.png" alt="">
                        <p class="gray-text">You currently dont have any '.$active1.' orders</p>
                      </div>';  
                }
                echo '</div>';
    }
}

?>