<?php

class NewOrder{
    public function __construct($data){
        $row = $data['row'];
        $products = $data['products'];
        echo '<div class="box">
                    <div class="label">Order ID : '.$row['order_id'].'
                        <svg class="img" width="30" height="16" viewBox="0 0 35 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.7514 15.8985C17.1825 15.8993 16.6312 15.7201 16.1932 15.3918L1.58692 4.38418C1.08977 4.01049 0.777187 3.47366 0.717923 2.89179C0.65866 2.30991 0.857574 1.73066 1.27091 1.28145C1.68424 0.832243 2.27813 0.54988 2.92193 0.496478C3.56574 0.443076 4.20671 0.623009 4.70385 0.996694L17.7522 10.8596L30.8036 1.35865C31.0527 1.17596 31.3392 1.03958 31.6468 0.957326C31.9545 0.875077 32.277 0.848587 32.596 0.87938C32.915 0.910173 33.2242 0.99764 33.5057 1.13676C33.7872 1.27587 34.0356 1.46389 34.2364 1.69001C34.4594 1.91635 34.6282 2.18184 34.7323 2.46986C34.8365 2.75788 34.8737 3.06221 34.8416 3.3638C34.8096 3.66538 34.709 3.95772 34.5461 4.2225C34.3832 4.48727 34.1616 4.71878 33.8951 4.90251L19.2853 15.525C18.8346 15.8011 18.2945 15.9326 17.7514 15.8985Z" fill="#F9896B"/>
                        </svg>
                    </div>
                    <div class="content">
                        <span><strong>Customer ID :</strong> '.$row['customer_id'].'</span> &nbsp;
                        <span><strong>Customer Name :</strong> '.$row['customer_name'].'</span>
                        <hr>
                        <table>
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>';
                            foreach($products as $product){
                                echo '<tr>
                                        <td>'.$product['product_name'].'</td>
                                        <td>'.$product['qty'].'</td>
                                    </tr>';
                            }
                                
                        echo '</tbody>
                        </table>
                    </div>
                </div>';

        
    }
}