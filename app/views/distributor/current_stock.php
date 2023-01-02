<?php
$header = new Header("distributor_orders");
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
                        <!-- <a href="../distributor/phurchase_orders" class="place"><b>Place an Order</b></a> -->
                        <a href="../orders/distributor" class="place"><b>Place an Order</b></a>
                    </li>
                    <li>
                        <a href="../orders/distributor_currentstock" class="stock"><b>Current Stock</b></a>
                    </li>
                    <li>
                        <!-- <a href="#" class="placedlist"><b>Placed Order List</b></a> -->
                        <a href="../orders/dis_placed_pending" class="placedlist"><b>Placed Order List</b></a>
                    </li>
                </ul>
            </div>

            <div>
                <div class="middle">
                    <p>Distributor ID : 02</p>

                    <table>
                        <tr>
                            <th>Item ID</th>
                            <th>Item Name</th>
                            <th>Quantity</th>
                        </tr>

                        <tr>
                            <td>02</td>
                            <td>Small</td>
                            <td>100</td>
                        </tr>

                        <tr>
                            <td>03</td>
                            <td>Buddy</td>
                            <td>120</td>
                        </tr>

                        <tr>
                            <td>04</td>
                            <td>Budget</td>
                            <td>200</td>
                        </tr>

                        <tr>
                            <td>05</td>
                            <td>Regular</td>
                            <td>50</td>
                        </tr>

                    </table>

                </div>
            </div>

        </div>
    </section>
</section>

<?php
$footer = new Footer();
?>

