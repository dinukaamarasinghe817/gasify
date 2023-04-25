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
            
            <div class="middle">
                <?php 
                $output = '';
                    $output .='
                    <form action="'.BASEURL.'/orders/purchase_order" class="po" method="POST" onsubmit="pobuttonclicked(); return false;">
                    <table class="po styled-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Product Name</th>
                                <th>Unit Price(Rs.)</th>
                                <th>Quantity</th>
                                <th>Subtotal(Rs.)</th>
                            </tr>
                        </thead>
                        <tbody>';

                        if(mysqli_num_rows($data['purchaseorder'])>0) {
                            $product_array = array();
                            $j = 0;

                            while($row = mysqli_fetch_assoc($data['purchaseorder'])) {
                                $product_id = $row['product_id'];
                                $product_array[$j] = $product_id;
                                $j++;
                                $unit_price = number_format($row['unit_price']);
                                
                                $output .= '
                                <tr class="data'.$row['product_id'].'">
                                    <td><img class="littleproduct" src="'.BASEURL.'/public/img/products/'.$row['image'].'"></td>
                                    <td>'.$row['name'].'</td>
                                    <td>'.$unit_price.'.00</td>
                                    <td><input type="number" step="1" value=0 name="'.$row['product_id'].'" min=0 onchange="changeqty('.$row['product_id'].','.$row['unit_price'].'); return false;"></td>
                                    <td class="subtotal">0</td>
                                </tr>';
                            }

                            $_SESSION["productarray"] = $product_array;

                            $output .= '
                                <tr class="total">
                                    <td>Total Amount</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="amount">Rs. 0.00</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><Button  type="submit">Submit</Button></td>
                                </tr>';
                        }

                        $output .='
                        </tbody>
                    </table>
                    </form>
                    ';
                    echo $output;
                ?>
                                        
            </div>
            
        </div>
    </section>
</section>

<?php
$footer = new Footer();
?>