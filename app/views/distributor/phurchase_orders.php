<?php
$header = new Header("distributor");
$sidebar = new Navigation('distributor',$data['navigation']);

$user_id = $_SESSION['user_id'];
?>

<section class="body">
    <?php 
    $bodyheader = new BodyHeader($data);
    ?>

    <section class="body-content">

        <div class="split right">
            
            <h2>Gas Orders</h2>

            <div class="top">
                <ul>
                    <li>
                        <a href="<?php echo BASEURL ?>/orders/distributor" class="place"><b>Place an Order</b></a>
                    </li>
                    
                    <li>
                        <a href="<?php echo BASEURL ?>/orders/distributor_currentstock" class="stock"><b>Current Stock</b></a>
                    </li>
                
                    <li>
                        <a href="<?php echo BASEURL ?>/orders/dis_placed_pending" class="placedlist"><b>Placed Order List</b></a>
                    </li>
                </ul>
            </div>

            <div>
                <div class="middle">
                        <?php
                            $output = '
                            <form action="<?php echo BASEURL;?>/orders/placeorder" method="POST" class="po" onsubmit="buttonclicked(); return false;">

                            <table class="styled-table">
                            <thead>
                                <tr>
                                    <th>Item ID</th>
                                    <th>Item Name</th>
                                    <th>Unit Price(Rs.)</th>
                                    <th>Quantity</th>
                                    <th>Subtotal (Rs.)</th>
                                </tr>
                            </thead>

                            <tbody>';

                            $products = $data['productdetails'];
                            foreach($products as $product) {
                                $row1 = $product['productdetails'];

                                $product_id = $row1['product_id'];
                                $name = $row1['name'];
                                $unit_price = $row1['unit_price'];

                                $output .= '
                                <tr>
                                    <td>'.$product_id.'</td>
                                    <td>'. $name.'</td>
                                    <td>'.$unit_price.'</td>
                                    <td><input type="number" placeholder="quantity" min=0></td>
                                    <td><input placeholder="quantity" min=0 value=0></td>
                                    
                                </tr>';

                            }              

                                $output .= '
                                <tr class="total">
                                    <td>Total Amount(Rs.)</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="amount">2,334,560.00</td>
                                </tr>
                                <tr>
                                    <td><button class="btn">Generate PDF</button></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><button type="submit">Submit</button></td>
                                </tr>';

                            
                            $output .= '
                            </tbody></table>
                            </form>';

                            echo $output;

                        ?>                
                </div>
            </div>
        </div>
    </section>
</section>

<?php
$footer = new Footer();
?>