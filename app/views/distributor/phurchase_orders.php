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
                <!-- <p>Order ID :  </p> <br> -->

                <!-- <form action="<?php echo BASEURL;?>/orders/placeorder" method="POST" class="po" onsubmit="buttonclicked(); return false;"> -->
                    <!-- <table class="styled-table">
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>Quantity</th>
                                <th>Subtotal (Rs.)</th>
                            </tr>
                        </thead>
                        <tbody> -->

                        <?php
                        $output .= '
                        <p>Order ID :  </p> <br>

                        <form action="<?php echo BASEURL;?>/orders/placeorder" method="POST" class="po" onsubmit="buttonclicked(); return false;">

                        <table class="styled-table">
                        <thead>
                            <tr>
                                <th>Item Name</th>
                                <th>Quantity</th>
                                <th>Subtotal (Rs.)</th>
                            </tr>
                        </thead>
                        <tbody>
                        ';

                        if(mysqli_num_rows($data['purchaseorder'])>0) {
                            $product_array = array();
                            $j = 0;

                            while($row = mysqli_fetch_assoc($data['purchaseorder'])) {
                                $product_id = $row['product_id'];
                                $product_array[$j] = $product_id;
                                $j++;

                                $output .= '
                                <tr class="data'.$row['product_id'].'">
                                    <td>'.$row['name'].'</td>
                                    <td><input type="number" step="1" value=0 name="'.$row['product_id'].'" min=0 onchange="changeqty('.$row['product_id'].','.$row['unit_price'].'); return false;"></td>
                                    <td class="subtotal">Rs. 0</td>
                                </tr>';
                            }
                            $_SESSION["productarray"] = $product_array;

                            $output .= '
                            <tr class="total">
                                <td></td>
                                <td></td>
                                <td>Total</td>
                                <td class="amount">Rs. 0.00</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><button type="submit">Submit</button></td>
                            </tr>';

                        }
                        $output .= '
                        </tbody></table>
                        </form>';

                        echo $output;

                        ?>

                <!-- <div class="btnclz">
                    <a href="<?php echo BASEURL?>/orders/distributor"><button class="btn2-1" type="submit" name="submit"><b>Place the Order</b></button>
                    <button class="btn2-2">Cancel</button>
                </div> -->
                
            </div>
        </div>
    </div>
    </section>
</section>

<?php
$footer = new Footer();
?>