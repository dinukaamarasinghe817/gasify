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
                    <a href="../dealers/distributor_dealers" class="dealers"><b>Allocated Dealers' Details</b></a>
                </li>
            </ul>
        </div>

        <div class="middle">
            <div class="accordion new">
     
                <!-- <div class="box"> -->
                    <?php
                    $dealers = $data['dealers'];
                    foreach($dealers as $dealer) {
                        $row1 = $dealer['dealerinfo'];
                        $capacities = $dealer['capacities'];

                        $output = '<div class="box">
                        <div class="labelbgn">';
                                    // $image = BASEURL.'/public/img/profile/'.$data['image'];
                                    $image = BASEURL.'/public/img/profile/'.$row1['image'];
                                    // $output1 = '
                                    //         <img src="'.$image.'" alt="" class="dealerimg"> ';
                                    //         echo $output1;
                                  
                                    $dealer_id = $row1['dealer_id'];
                                    $dealer_name = $row1['name'];

                                    // echo '<br>'."Dealer User ID - $dealer_id".'<br>'; 
                                    $output .='
                                    
                                   
                                    <div class="label"><img src="'.$image.'" alt="" class="dealerimg"> </div>
                                    <div class="label">Dealer ID :  '.$dealer_id.'  </div>
                                    <div class="label">Dealer Name :  '.$dealer_name.'  </div>';

                                
                                    // $dealer_name = $row1['name'];
                                    // echo "Dealer Name - $dealer_name".'<br>';

                                    $output .= ' 
                                        <svg class="img" width="30" height="16" viewBox="0 0 35 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M17.7514 15.8985C17.1825 15.8993 16.6312 15.7201 16.1932 15.3918L1.58692 4.38418C1.08977 4.01049 0.777187 3.47366 0.717923 2.89179C0.65866 2.30991 0.857574 1.73066 1.27091 1.28145C1.68424 0.832243 2.27813 0.54988 2.92193 0.496478C3.56574 0.443076 4.20671 0.623009 4.70385 0.996694L17.7522 10.8596L30.8036 1.35865C31.0527 1.17596 31.3392 1.03958 31.6468 0.957326C31.9545 0.875077 32.277 0.848587 32.596 0.87938C32.915 0.910173 33.2242 0.99764 33.5057 1.13676C33.7872 1.27587 34.0356 1.46389 34.2364 1.69001C34.4594 1.91635 34.6282 2.18184 34.7323 2.46986C34.8365 2.75788 34.8737 3.06221 34.8416 3.3638C34.8096 3.66538 34.709 3.95772 34.5461 4.2225C34.3832 4.48727 34.1616 4.71878 33.8951 4.90251L19.2853 15.525C18.8346 15.8011 18.2945 15.9326 17.7514 15.8985Z" fill="#a66bf9"/>
                                        </svg>
                        </div>';

                        $output .= '
                        <div class="content">
                        Dealer Details : 
                        
                        <hr>
                        <table>
                            <thead>
                                <tr>
                                    <th>Email Address</th>
                                    <th>'.$row1['email'].'</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Contact Number </td>
                                    <td>'.$row1['contact_no'].'</td>
                                </tr>
                                <tr>
                                    <td>City</td>
                                    <td>'.$row1['city'].'</td>
                                </tr>
                                <tr>
                                    <td>Dealer Capacity</td>
                                    <td>
                                        <table class="table2">
                                            <tr>
                                                <th>Product</th>
                                                <th>Capacity</th>
                                            </tr>';

                                foreach($capacities as $capacity) {
                                    $row3 = $capacity;
                                    $output .= '
                                                <tr>
                                                    <td>'.$row3['product_name'].'</td>
                                                    <td>'.$row3['capacity'].'</td>
                                                </tr>';
                                }
                            
                        $output .= ' </table> </td>      
                                <tr>
                                    <td>Bank Account Number</td>
                                    <td>'.$row1['account_no'].'</td>
                                </tr>
                                <tr>
                                    <td>Bank</td>
                                    <td>'.$row1['bank'].'</td>
                                </tr>
                               
                            </tbody>
                        </table>
                        </div>
                        </div>';
                        
                        echo $output;
                    }
                    // $output .= '</table>';
                    // echo $output;
                    ?>
                </div>

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