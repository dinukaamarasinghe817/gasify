<?php

class Order{
    function __construct($order,$products,$totalamount){
        echo '<li>
                <div class="order">
                    <div class="head">
                        <div class="details">
                            <div><strong>Order ID : </strong>'.$order['order_id'].'<br><strong>Total amount : </strong>Rs.'.$totalamount.'</div>
                            <div><strong>Date : </strong>'.$order['place_date'].'<br><strong>Time : </strong>'.$order['place_time'].'</div>
                        </div>
                        <button onclick="viewinfo(); return false;" class="btn">Issue</button>
                        <button class="arrow">
                            <svg width="22" height="22" viewBox="0 0 36 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 3L17.9551 17.9551L32.9102 3" stroke="#FCFCFC" stroke-opacity="0.97" stroke-width="6.98504" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>
                    <div class="info">
                        <div><p><strong>Customer ID : </strong>'.$order['customer_id'].'</p><p><strong>Customer Name : </strong>'.$order['customer_id'].'</p></div><br>
                        <table class="styled-table">
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
                            </tbody>
                        </table>
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
                        echo '<li><a href="#" class="current active">Pending</a></li>';
                    }else{
                        echo '<li><a href="#" class="current">Pending</a></li>';
                    }
                    if($active1 == 'accepted'){
                        echo '<li><a href="#" class="current active">Accepted</a></li>';
                    }else{
                        echo '<li><a href="#" class="current">Accepted</a></li>';
                    }
                    if($active1 == 'dispatched'){
                        echo '<li><a href="#" class="current active">Dispatched</a></li>';
                    }else{
                        echo '<li><a href="#" class="current">Dispatched</a></li>';
                    }
                    if($active1 == 'delivered'){
                        echo '<li><a href="#" class="current active">Delivered</a></li>';
                    }else{
                        echo '<li><a href="#" class="current">Delivered</a></li>';
                    }
                    if($active1 == 'completed'){
                        echo '<li><a href="#" class="current active">Completed</a></li>';
                    }else{
                        echo '<li><a href="#" class="current">Completed</a></li>';
                    }
                    if($active1 == 'canceled'){
                        echo '<li><a href="#" class="current active">Canceled</a></li>';
                    }else{
                        echo '<li><a href="#" class="current">Canceled</a></li>';
                    }
                    echo '</ul>';
        if($active2 != null){
                echo '<ul>';
                        if($active1 == 'completed'){
                            echo '<li><a href="#" class="current sub1 active">Pickup</a></li>';
                        }else{
                            echo '<li><a href="#" class="current sub1">Pickup</a></li>';
                        }
                        if($active1 == 'canceled'){
                            echo '<li><a href="#" class="current sub1 active">Delivery</a></li>';
                        }else{
                            echo '<li><a href="#" class="current sub1">Delivery</a></li>';
                        }
                echo '</ul>';
        }
        echo '</div>';
        $this->func($active1,$active2,$data);
        echo '</section>';
    }

    public function func($active1,$active2,$data){
        echo '<div class="content-data">
                    <div class="search-bar">
                        <input type="text" class="ticker-input" placeholder="Type to search" autocomplete="off">
                        <button class="btn btn-primary" type="submit">
                            <svg width="23" height="24" viewBox="0 0 23 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.5417 19C14.7759 19 18.2083 15.4183 18.2083 11C18.2083 6.58172 14.7759 3 10.5417 3C6.30748 3 2.875 6.58172 2.875 11C2.875 15.4183 6.30748 19 10.5417 19Z" stroke="#FFF8F3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M20.1248 20.9999L15.9561 16.6499" stroke="#FFF8F3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <p>Search</p>
                        </button>
                    </div>
                    <ul>';
                        $orders = $data['orders'];
                        foreach($orders as $tuple){
                            $o = new Order($tuple['order'], $tuple['products'], $tuple['total_amount']);
                        }
                echo '</ul>
                </div>';
    }
}

?>