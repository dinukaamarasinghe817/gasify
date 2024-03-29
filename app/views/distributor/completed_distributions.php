<?php
$header = new Header("distributor");
$sidebar = new Navigation('distributor', $data['navigation']);
?>

<section class="body">
    <?php
    $bodyHeader =new BodyHeader($data);
    ?>

    <section class="body-content">
        <div class="split right">
            <h2>Completed Gas Distributions</h2>

            <div class="top-panel">
                <ul>
                    <li>
                        <a href="<?php echo BASEURL ?>/gasdistributions/pending_distributions" class="pending"><b>Pending Gas Distributions</b></a>
                    </li>
                    <li class="active">
                        <a href="<?php echo BASEURL ?>/gasdistributions/completed_distributions" class="completed active"><b>Completed Gas Distributions</b></a>
                    </li>
                </ul>
            </div>

            <div class="middle">
                <div class="accordion new">
                    <?php 
                        $completes = $data['completed_distributions'];
                        // if completed distributions are available
                        if(count($completes)>0){ 
                            foreach($completes as $complete) {
                                $row1 = $complete['completedinfo'];
                                $capacities = $complete['capacities'];

                                $output = '<div class="box">
                                    <div class="labelbgn">';
                                    $distribution_id = $row1['po_id'];
                                $output .= ' 
                                        <div class="label">Completed Distribution ID : '.$distribution_id.'  </div>

                                        <svg class="img" width="30" height="16" viewBox="0 0 35 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M17.7514 15.8985C17.1825 15.8993 16.6312 15.7201 16.1932 15.3918L1.58692 4.38418C1.08977 4.01049 0.777187 3.47366 0.717923 2.89179C0.65866 2.30991 0.857574 1.73066 1.27091 1.28145C1.68424 0.832243 2.27813 0.54988 2.92193 0.496478C3.56574 0.443076 4.20671 0.623009 4.70385 0.996694L17.7522 10.8596L30.8036 1.35865C31.0527 1.17596 31.3392 1.03958 31.6468 0.957326C31.9545 0.875077 32.277 0.848587 32.596 0.87938C32.915 0.910173 33.2242 0.99764 33.5057 1.13676C33.7872 1.27587 34.0356 1.46389 34.2364 1.69001C34.4594 1.91635 34.6282 2.18184 34.7323 2.46986C34.8365 2.75788 34.8737 3.06221 34.8416 3.3638C34.8096 3.66538 34.709 3.95772 34.5461 4.2225C34.3832 4.48727 34.1616 4.71878 33.8951 4.90251L19.2853 15.525C18.8346 15.8011 18.2945 15.9326 17.7514 15.8985Z" fill="#9c6109"/>
                                        </svg> 
                                    
                                    </div>';
                                    // get details of completed distribution
                                    $date = $row1['place_date'];
                                    $dealer_id = $row1['dealer_id'];
                                    $time = $row1['place_time'];
                                
                                $output .= '
                                    <div class="content">
                                        <div class="details">
                                            <span><strong>Dealer ID : '.$dealer_id.' </strong></span>
                                            <span><strong>Completed Date : '.$date.' </strong></span>
                                            <span><strong>Completed Time : '.$time.' </strong></span>
                                            
                                        </div>
                                        <hr>

                                        <table class="styled-table">
                                            <thead>
                                                <tr>
                                                    <th>Product ID</th>
                                                    <th>Product Name</th>
                                                    <th>Weight</th>
                                                    <th>Unit Price (Rs.)</th>
                                                    <th>Quantity</th>
                                                    <th>Subtotal (Rs.)</th>
                                                </tr>
                                            </thead>
                                            <tbody>';

                                            $total = 0;
                                            // get product capacity details
                                            foreach($capacities as $capacity) {
                                                $row2 = $capacity;
                                                
                                                $unit_price = $row2['unit_price'];
                                                $quantity = $row2['quantity'];
                                                $subtotal = $unit_price * $quantity; //calculate the subtotals

                                                $output .= '
                                                <tr>
                                                    <td>'.$row2['product_id'].'</td>
                                                    <td>'.$row2['product_name'].'</td>
                                                    <td>'.$row2['weight'].' Kg</td>
                                                    <td>'.number_format($unit_price,2).'</td>
                                                    <td>'.$row2['quantity'].'</td>
                                                    <td>'.number_format($subtotal,2).'</td> 
                                                </tr>';  
                                                $total += $subtotal;
                                                // calculate the total values
                                            }
                                            $output.='
                                                <tr>
                                                    <td><b>Total Amount</b></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td><b>Rs. '.number_format($total,2).'</b></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>';
                                echo $output;                                                
                            }
                            // if completed distributions are not available
                        }else {
                            $output = '';
                            $output = '</table>';
                            $output .= '<p class="nofoundtxt">No records found</p>';
                            echo $output;

                        }                
                    ?>    
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