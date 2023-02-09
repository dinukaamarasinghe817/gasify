<?php
$header = new Header("distributor");
$sidebar = new Navigation('distributor',$data['navigation']);
?>

<section class="body">
    <?php 
    $bodyheader = new BodyHeader($data);
    ?>

    <section class="body-content">

    <div class="split right">
        
        <h1>Gas Orders</h1>

        <?php 
        //   $result = new GasOrders_Comp("place");
        ?>

        <div class="top">
            <ul>
                <li>
                    <a href="../orders/distributor" class="place"><b>Place an Order</b></a>
                </li>
                <li>
                    <a href="../orders/distributor_currentstock" class="stock"><b>Current Stock</b></a>
                    <!-- <a href="#" class="stock"><b>Current Stock</b></a> -->
                </li>
                <!-- <li>
                    <a href="../orders/distributor" class="place"><b>Place an Order</b></a>
                </li> -->
                <li>
                    <a href="../orders/dis_placed_pending" class="placedlist"><b>Placed Order List</b></a>
                    <!-- <a href="#" class="placedlist"><b>Placed Order List</b></a> -->
                </li>
            </ul>
        </div>

        <div>
            <div class="middle">
                <p>Order ID : 27 </p> <br>

                <table class="styled-table">
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <!-- <th>Current Stock</th> -->
                            <th>Quantity</th>
                            <th>Subtotal (Rs.)</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <?php
                            $output = '';

                            $stocks = $data['currentstock'];
                            foreach($stocks as $stock) {
                                $row1 = $stock['stockinfo'];

                                $output .= '
                                    <tr>
                                        <td>'.$row1['name'].'</td>
                                    
                                        <td><input type="number" name="capacity" min="0" value="5" required></td>
                                        <td>3200.00</td>
                                    </tr>';
                            }
                            $output .= '</table>

                            <table class="styled-table">
                                <tbody>
                                    <tr>
                                        <td class="second1">Total Amount </td>
                                        <td class="second2">9400.00</td>
                                    </tr>
                                </tbody>
                            </table>';
                            echo $output;
                            ?>
                        </tr>
                    </tbody>
                </table>

                <div class="btnclz">
                    <!-- <button class="btn2-1" type="submit" name="submit">Place the order</button> -->
                    <a href="<?php echo BASEURL?>/orders/distributor"><button class="btn2-1" type="submit" name="submit"><b>Place the Order</b></button>
                    <button class="btn2-2">Cancel</button>
                </div>
                
            </div>
        </div>
    </div>
    </section>
</section>

<?php
$footer = new Footer();
?>