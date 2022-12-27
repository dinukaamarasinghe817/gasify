<?php
$header = new Header("dealer");
$sidebar = new Navigation('dealer',$data['navigation']);
?>

<section class="body">
    <?php
        // call the default header for yout interface
        $bodyheader = new BodyHeader($data);
        // call whatever the component you need to show
        // $bodycontent = new Body('dealerstock', $data);
        $output = '<section class="body-content">
                            <div class="top-panel">
                                <ul>
                                    <li>
                                        <a href="#" class="current active" onclick="stockclicked(); return false;">Current Stock</a>
                                    </li>
                                    <li>
                                        <a href="#" class="purchase" onclick="purchaseclicked(); return false;">Purchase Order</a>
                                    </li>
                                    <li>
                                        <a href="#" class="history" onclick="historyclicked(); return false;">Order History</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="content-data">
                                <table>
                                    <tr>
                                        <th>Product ID</th>
                                        <th>Name</th>
                                        <th>Weight</th>
                                        <th>Unit Price</th>
                                        <th>Quantity</th>
                                    </tr>';

            if(mysqli_num_rows($data['current_stock']) > 0){
                
                while($row = mysqli_fetch_assoc($data['current_stock'])){
                    // dynamic html
                    $output .= '<tr>
                                    <td>'.$row['product_id'].'</td>
                                    <td>'.$row['product_name'].'</td>
                                    <td>'.$row['product_weight'].' Kg</td>
                                    <td>Rs. '.$row['unit_price'].'</td>
                                    <td>'.$row['quantity'].'</td>
                                </tr>';
                }

            }
        $output .= '</table></div></section>'; // static html
        echo $output;
    ?>
</section>

<?php
$footer = new Footer();
?>