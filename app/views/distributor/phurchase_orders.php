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
                <p>Order ID : </p> <br>

                <table>
                    <tr>
                        <th>Item Name</th>
                        <th>Current Stock</th>
                        <th>Quantity</th>
                    </tr>

                    <tr>
                      
                        <?php
                        $output = '';

                        $stocks = $data['currentstock'];
                        foreach($stocks as $stock) {
                            $row1 = $stock['stockinfo'];

                            $output .= '
                                <tr>
                                    <td>
                                        <select id="period" onchange="updatechart()" class="dropdowndate">
                                            <option value="product">'.$row1['name'].'</option>
                                        </select>
                                    </td>

                                    <td>'.$row1['quantity'].'</td>

                                    <td><input type="number" name="capacity" min="0" required></td>
                                </tr>';
                        }
                        $output .= '</table>';
                        echo $output;

                        ?>
                       
                    </tr>

                </table>

                <div class="btnclz">
                    <button class="btn2-1">Place the order</button>
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