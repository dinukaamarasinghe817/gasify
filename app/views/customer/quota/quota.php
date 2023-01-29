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
        
            <div class="one_company">
            <div class="company_details">
                <div class="name">Litro</div>
                <div class="date"><span>Time Period : </span>01/01/2023 - 01/02/2023</div>
            </div>
            <div class="company_quota">
                <div class="logo"><img src= "<?php echo BASEURL;?>/public/img/profile/litro-removebg-preview.png" alt=""></div>
                <div class="quota-bars">
                    
                    <div class="bar">
                        <div class="total">
                            <span><strong>Total : </strong></span><span> 45 kg</span>
                        </div>
                        <div class="progress-line litro">
                            <span></span>
                        </div>
                        <div class="bottom_details">
                            <div class="remaining"><span><strong> Remaining : </strong></span><span>35 kg</span></div>
                            <div class="days">18 days more</div>
                        </div>
                    </div>
                </div>
            </div>
            </div>

            <div class="one_company">
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

        </div>

        

</section>