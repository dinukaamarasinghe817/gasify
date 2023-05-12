<?php

// echo "All sell products report view is here";

$header = new Header("distributor_reports");
$sidebar = new Navigation('distributor',$data['navigation']);

$user_id = $_SESSION['user_id'];

?>


<section class="body">
    <?php 
    $bodyheader = new BodyHeader($data);
    ?>

    <section class="body-content">
        <div class="split right">
        
            <h2>Reports</h2>

            <!-- <div class="main"> -->
                <div class="top-panel">
                    <ul>
                        <li>
                            <a href="<?php echo BASEURL ?>/reports/distributor" class="pastdistributions"><b>Summary of Past Distributions</b></a>
                        </li>
                        <li>
                            <a href="<?php echo BASEURL ?>/reports/allsellproducts" class="allsold active"><b>Summary of Sold Products</b></a>
                        </li>
                        <li>
                            <a href="<?php echo BASEURL ?>/reports/allrequestedproducts" class="allrequested"><b>Summary of Requested Products</b></a>
                        </li>
                    </ul>
                </div>
        
                <div class="middle">
                    <?php echo'
                    <form action ="'.BASEURL.'/reports/allsellproducts" method="POST">
                    
                        <select id="period" name="option" onchange="this.form.submit()" class="dropdowndate">';
                       
                            if($data['option'] == 'today') {
                                echo '
                                <option value="today" selected>To day</option>
                                <option value="7day">Last 7 days</option>
                                <option value="30day">Last 30 days</option>';

                            }elseif($data['option'] == '7day'){
                                echo '
                                <option value="today">To day</option>
                                <option value="7day"  selected>Last 7 days</option>
                                <option value="30day">Last 30 days</option>';
                            
                            }else {
                                echo '
                                <option value="today">To day</option>
                                <option value="7day">Last 7 days</option>
                                <option value="30day" selected>Last 30 days</option>';
                            }
                        
                        echo '
                        </select>
                    </form>
                </div>';
                    ?>

                    <?php
                    $records = $data['allproductsquantity'];
                    
                    $output = '
                    <div class="repbox">
                        <table class="styled-table">
                            <thead>
                                <tr>
                                    <th>Product ID</th>
                                    <th>Product Name</th>
                                    <th>Weight</th>
                                    <th>Sold Quantity</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>';
                        $total = 0;
                        if(count($records)>0) {
                            foreach($records as $record) {
                                $row1 = $record['quantites'];
                                    $product_id = $row1['product_id'];
                                    $name = $row1['name'];
                                    $quantity = $row1['quantity'];
                                    $weight = $row1['weight'];
                                    $unit_price = $row1['unit_price'];
                                    $subtotal = $unit_price * $quantity;

                                $output .= '
                                <tr>
                                    <td>'.$product_id.'</td>
                                    <td>'.$name.'</td>
                                    <td>'.$weight.' Kg</td>
                                    <td>'.$quantity.'</td>                                                                     
                                    <td>Rs. '.number_format($subtotal,2).'</td>                                                                     
                                </tr>';
                                $total += $subtotal;
                            }
                            $output .= '
                                <tr>
                                    <td><b>Total Income</b></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><b>Rs. '.number_format($total,2).'</b></td>
                                </tr>
                                </tbody></table>';
                        }else {
                            $output .= '</table>';
                            $output .= '<p class="nofoundtxt">No records found</p>';
                        }

                    $output .= '</div>';                    
                    echo $output;
                    ?>
                   
                </div>
            <!-- </div> -->
        </div>
    </section>
</section>


<?php
$footer = new Footer();
?>