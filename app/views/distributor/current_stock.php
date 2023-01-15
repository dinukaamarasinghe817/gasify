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
            <h1>Gas Orders</h1>

            <div class="top">
                <ul>
                    <li>
                        <a href="../orders/distributor" class="place"><b>Place an Order</b></a>
                    </li>
                    <li>
                        <a href="../orders/distributor_currentstock" class="stock"><b>Current Stock</b></a>
                    </li>
                    <li>
                        <a href="../orders/dis_placed_pending" class="placedlist"><b>Placed Order List</b></a>
                    </li>
                </ul>
            </div>

            <div>
                <div class="middle">
                    <?php
                        echo "Your Distributor ID : $user_id";

                        $output = '<table>
                                    <tr>
                                        <th>Item ID</th>
                                        <th>Item Name</th>
                                        <th>Quantity</th>
                                    </tr>';
                        
                        $stocks = $data['currentstock'];
                        foreach($stocks as $stock) {
                            $row1 = $stock['stockinfo'];
                        
                        $output .= '<tr>
                                        <td>'.$row1['product_id'].'</td>
                                        <td>'.$row1['name'].'</td>
                                        <td>'.$row1['quantity'].'</td>                        
                                    </tr>';

                        }

                        $output .= '</table>';
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

