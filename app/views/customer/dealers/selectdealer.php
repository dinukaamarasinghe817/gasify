<?php
$header = new Header("customer/selectdealer");
$sidebar = new Navigation('customer',$data['navigation']);
?>

<section class="body">
    <?php
        // call the default header for yout interface
        $bodyheader = new BodyHeader($data);
        // call whatever the component you need to show
        // $bodycontent = new Body('allmyreservation', $data);
        
    ?>

    <div class="under_topbar">
        <div class="subtitle">
            <h3>Kavindu Stores</h3>
            

        </div>

        <div class="top_details">
            <div class="profile_pic">
                <img src= "<?php echo BASEURL ; ?>/public/img/people/dealer.png" alt="">
            </div>
            <div class="detail_table">
                <table>
                    <!-- <tr id="first_row"><th>Dealer</th><th>Street</th><th>Contact No</th><th></th></tr> -->
                    <tr><td><strong>Name</strong></td><td>Kavindu Stores</td></tr>
                    <tr><td><strong>E-mail</strong></td><td>kavindustores@gasify.com</td></tr>
                    <tr><td><strong>Address</strong></td><td>Main street , Boralesgamuwa</td></tr>
                    <tr><td><strong>Contact No</strong></td><td>0777461522</td></tr>
                    <tr><td><strong>Registered Company</strong></td><td>Litro</td></tr>
                </table>
            </div>
        </div>

      

        <div class="product_table">
            <table>
                <tr id="first_row"><th>Product</th><th>Availability</th></tr>
                <tr><td>2.3 kg cylinder</td><td id="available"><svg width="30" height="30" viewBox="0 0 1391 1391" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M695.182 0C311.094 0 0 311.094 0 695.182C0 1079.27 311.094 1390.36 695.182 1390.36C1079.27 1390.36 1390.36 1079.27 1390.36 695.182C1390.36 311.094 1079.27 0 695.182 0ZM1042.77 309.356L1167.91 434.489L608.284 994.11L309.356 695.182L434.489 570.049L608.284 743.845L1042.77 309.356Z" fill="#0BA011"/>
                        </svg>
                </td></tr>
                <tr><td>5 kg cylinder</td><td id="available"><svg width="30" height="30" viewBox="0 0 1391 1391" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M695.182 0C311.094 0 0 311.094 0 695.182C0 1079.27 311.094 1390.36 695.182 1390.36C1079.27 1390.36 1390.36 1079.27 1390.36 695.182C1390.36 311.094 1079.27 0 695.182 0ZM1042.77 309.356L1167.91 434.489L608.284 994.11L309.356 695.182L434.489 570.049L608.284 743.845L1042.77 309.356Z" fill="#0BA011"/>
                    </svg>
                </td></tr>
                <tr><td>12.5 kg cylinder</td><td id="available"><svg width="30" height="30" viewBox="0 0 1391 1391" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M695.182 0C311.094 0 0 311.094 0 695.182C0 1079.27 311.094 1390.36 695.182 1390.36C1079.27 1390.36 1390.36 1079.27 1390.36 695.182C1390.36 311.094 1079.27 0 695.182 0ZM1042.77 309.356L1167.91 434.489L608.284 994.11L309.356 695.182L434.489 570.049L608.284 743.845L1042.77 309.356Z" fill="#0BA011"/>
                    </svg>
                </td></tr>
                <tr><td>37.5 kg cylinder</td><td id="available"><svg width="30" height="30" viewBox="0 0 1391 1391" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M695.182 0C311.094 0 0 311.094 0 695.182C0 1079.27 311.094 1390.36 695.182 1390.36C1079.27 1390.36 1390.36 1079.27 1390.36 695.182C1390.36 311.094 1079.27 0 695.182 0ZM1042.77 309.356L1167.91 434.489L608.284 994.11L309.356 695.182L434.489 570.049L608.284 743.845L1042.77 309.356Z" fill="#0BA011"/>
                    </svg>
                </td></tr>
                <tr><td>Regulator</td><td id="unavailable"><svg width="30" height="30" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16.1894 31.3166C24.5961 31.3166 31.4111 24.5016 31.4111 16.0949C31.4111 7.68826 24.5961 0.873291 16.1894 0.873291C7.78274 0.873291 0.967773 7.68826 0.967773 16.0949C0.967773 24.5016 7.78274 31.3166 16.1894 31.3166Z" fill="#FF4D4D"/>
                    <path d="M20.756 11.5286L11.623 20.6616" stroke="white" stroke-width="3.04433" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M11.623 11.5286L20.756 20.6616" stroke="white" stroke-width="3.04433" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </td></tr>
                <tr><td>Rubber Hose</td><td id="available"><svg width="30" height="30" viewBox="0 0 1391 1391" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M695.182 0C311.094 0 0 311.094 0 695.182C0 1079.27 311.094 1390.36 695.182 1390.36C1079.27 1390.36 1390.36 1079.27 1390.36 695.182C1390.36 311.094 1079.27 0 695.182 0ZM1042.77 309.356L1167.91 434.489L608.284 994.11L309.356 695.182L434.489 570.049L608.284 743.845L1042.77 309.356Z" fill="#0BA011"/>
                    </svg>
                </td></tr>
                <tr><td>Accesory Pack</td><td id="unavailable"><svg width="30" height="30" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16.1894 31.3166C24.5961 31.3166 31.4111 24.5016 31.4111 16.0949C31.4111 7.68826 24.5961 0.873291 16.1894 0.873291C7.78274 0.873291 0.967773 7.68826 0.967773 16.0949C0.967773 24.5016 7.78274 31.3166 16.1894 31.3166Z" fill="#FF4D4D"/>
                    <path d="M20.756 11.5286L11.623 20.6616" stroke="white" stroke-width="3.04433" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M11.623 11.5286L20.756 20.6616" stroke="white" stroke-width="3.04433" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </td></tr>
                
            </table>
        </div>

        <div class="bottom">
            <a href="<?php echo BASEURL; ?>/Dealers/customer_dealers" class="btn">Back</a>
        </div>
                

                   
                    
        

        
        
    </div>
    
</section>

<?php
$footer = new Footer();
?>