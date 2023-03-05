<?php
$header = new Header("customer/customer_quota");
$sidebar = new Navigation('customer',$data['navigation']);
?>

<section class="body">
    <?php
        // call the default header for yout interface
        $bodyheader = new BodyHeader($data);
        // call whatever the component you need to show
        // $bodycontent = new Body('addreview', $data);
       
        
    ?>

<div class="under_topbar">
        <div class="subtitle">
           <h3>Quota</h3>
        </div> 

        <div class="middle">
            <div class="content">
            <?php
                $quotas = $data['quota_details'];
                if(isset($quotas)){
                    foreach($quotas as $quota){
                        if($quota['state']== 'ON'){
                            // $current_year = date('y');
                            // $current_month = date('m');
                            $next_month = date('m', strtotime('+1 month'));

                            $start_date = date('Y/m/01');
                            $end_date = date('Y/'.$next_month.'/01');

                            $today = date('Y/m/d');

                            $Date1 = new DateTime($today);
                            $Date2 = new DateTime($end_date);

                            $interval = $Date1->diff($Date2);
                            $remaingDays = $interval->days;

                            $total = $quota['monthly_limit'];
                            $remaining = 15;

                            $percentage = $remaining/$total * 100;


                            
                            echo  '<div class="one_company">
                            <div class="company_details">
                                <div class="name">'.$quota['name'].'</div>
                                <div class="date"><span>Time Period : </span>'.$start_date.' - '.$end_date.'</div>
                            </div>
                            <div class="company_quota">
                            <div class="quota-bars">
                            
                            <div class="bar">
                            <div class="total">
                            <span><strong>Total : </strong></span><span> '.$quota['monthly_limit'].' Kg</span>
                            </div>
                            <div class="quota_logo">
                                <img src= " '.BASEURL.'/public/img/profile/'.$quota['logo'].'" alt="">';
                                        $progresscircle = new PercentageCircle($percentage,0);
                                        echo '</div><div class="bottom_details">
                                            <div class="remaining"><span><strong> Remaining : </strong></span><span>35 kg</span></div>
                                            <div class="days">'.$remaingDays.' days more</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>';

                        }
                    }
                }
                


            ?>
        
           

            <!-- <div class="one_company">
            <div class="company_details">
                <div class="name">Laugfs</div>
                <div class="date"><span>Time Period : </span>01/01/2023 - 01/02/2023</div>
            </div>
            <div class="company_quota">
                <div class="logo"><img src="<?php echo BASEURL;?>/public/img/profile/laufs-removebg-preview.png" alt=""></div>
                <div class="quota-bars">
                    
                    <div class="bar">
                        <div class="total">
                            <span><strong>Total : </strong></span><span> 50 kg</span>
                        </div>
                        <div class="progress-line laugfs">
                            <span></span>
                        </div>
                        <div class="bottom_details">
                            <div class="remaining"><span><strong> Remaining : </strong></span><span>35 kg</span></div>
                            <div class="days">10 days more</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    -->
        </div>
        </div>


</section>