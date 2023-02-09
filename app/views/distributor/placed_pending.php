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
                <ul>
                    <li>
                        <a href="<?php echo BASEURL ?>/orders/dis_placed_pending" class="pending"><b>Pending Gas Orders</b><a>
                    </li>
                    <li>
                        <a href="<?php echo BASEURL ?>/orders/dis_placed_accepted" class="accepted"><b>Accepted Gas Orders</b><a>
                    </li>
                    <li>
                        <a href="<?php echo BASEURL ?>/orders/dis_placed_completed" class="completed"><b>Completed Gas Orders</b><a>
                    </li>

                </ul>

                <div class="accordion new">

                    <!-- <div class="box"> -->
                        <?php
                            $pendingorders = $data['pendingorders'];
                            foreach($pendingorders as $pendingorder) {
                                $row1 = $pendingorder['pendinginfo'];
                                $capacities = $pendingorder['capacities'];

                                $output = '<div class="box">
                                <div class="labelbgn">';
                                    $order_id = $row1['stock_req_id'];
                                    $output .='
                                    <div class="label">Pending Purchase Order ID :  '.$order_id.'  </div>
                                    <div class="label">Total Amount : Rs. 230 000.00 </div>
                                    <div class="label">
                                        <button class="inside" onclick = "document.location.href=\''.BASEURL.'/orders/suitableVehicleList\'">Assign Vehicle</button>
                                    </div>

                                    <svg class="img" width="30" height="16" viewBox="0 0 35 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M17.7514 15.8985C17.1825 15.8993 16.6312 15.7201 16.1932 15.3918L1.58692 4.38418C1.08977 4.01049 0.777187 3.47366 0.717923 2.89179C0.65866 2.30991 0.857574 1.73066 1.27091 1.28145C1.68424 0.832243 2.27813 0.54988 2.92193 0.496478C3.56574 0.443076 4.20671 0.623009 4.70385 0.996694L17.7522 10.8596L30.8036 1.35865C31.0527 1.17596 31.3392 1.03958 31.6468 0.957326C31.9545 0.875077 32.277 0.848587 32.596 0.87938C32.915 0.910173 33.2242 0.99764 33.5057 1.13676C33.7872 1.27587 34.0356 1.46389 34.2364 1.69001C34.4594 1.91635 34.6282 2.18184 34.7323 2.46986C34.8365 2.75788 34.8737 3.06221 34.8416 3.3638C34.8096 3.66538 34.709 3.95772 34.5461 4.2225C34.3832 4.48727 34.1616 4.71878 33.8951 4.90251L19.2853 15.525C18.8346 15.8011 18.2945 15.9326 17.7514 15.8985Z" fill="#9c6109"/>
                                    </svg>
                                </div>';
                                
                                $output .= '
                                <div class="content">';
                                    $date = $row1['place_date'];
                                    $output .='
                                    <span><strong>Placed Date : '.$date.' </strong></span><br><br>
                                    <span><strong>Pending Phurchase Order Details :</strong></span>
                                    <hr>
                                    <table class="styled-table">
                                        <thead>
                                            <tr>
                                                <th>Item ID</th>
                                                <th>Unit Price</th>
                                                <th>Quantity</th>
                                            </tr>
                                        </thead>

                                        <tbody>';
                                        foreach($capacities as $capacity) {
                                            $row2 = $capacity;
                                            $output .= '
                                                <tr>
                                                    <td>'.$row2['product_id'].'</td>
                                                    <td>'.$row2['unit_price'].'</td>
                                                    <td>'.$row2['quantity'].'</td>
                                                </tr>';
                                        }
                                        $output .='
                                        </tbody>
                                    </table>
                                </div> 
                            </div>';
                            echo $output;

                            }
                            // echo $output;
                        ?>
                    <!-- </div> -->
                </div>
            </div>
        </div>
    </section>
</section>

<script>
    let accordion = document.querySelectorAll('.accordion .box');
    for(i=0; i<accordion.length; i++) {
        accordion[i].addEventListener('click', function(){
            this.classList.toggle('active')
        })
    }
</script>

<?php
$footer = new Footer();
?>


