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
                $quota_details = $data['quota_details'];
                if(isset($quota_details)){
                    foreach($quota_details as $quota_detail){
                        $quotas = $quota_detail['quotas'];
                        $products = $quota_detail['products'];
                        $remainings = $quota_detail['remaining'];
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
    
                                $total_weight = $quota['monthly_limit'];
                               
    
                               
                                
    
                               
                                
                                foreach($remainings as $remaining) {
                                   
                                    if($remaining['company_id']==$quota['company_id']){
                                        $remaining_weight = $remaining['remaining_amount'];
                                        // $remaining_cylinders = $remaing_weight/$product['weight'];
        
                                    }
                                
                                }
                                echo  '<div class="one_company">
                                <div class="company_details">
                                    <div class="name">'.$quota['name'].'</div>
                                    <div class="date"><span>Time Period : </span>'.$start_date.' - '.$end_date.'</div>
                                </div>
                                <div class="company_quota" >
                                <div class="quota-bars">
                                
                                <div class="bar">
                                <div class="total_dropdown">
                                    <div class="total">
                                        <span><strong>Total : </strong></span><span id="total_cylinders"> '.$quota['monthly_limit'].'</span><span> &nbsp Cylinders</span> 
                                    </div>
                                    <div>
                                        <select name="product" id="product_dropdown" class="dropdowndate" onchange = "select_product('.$total_weight.','.$remaining_weight.');">';
                                        foreach ($products as $product) {
                                            if($product['company_id']==$quota['company_id']){
                                                $total_cylinders = $total_weight/$product['weight'];
                                                
                    
                                                // echo $total_cylinders;
                                                if($product['weight']== 12.5){
                                                    echo '<option value="'.$product['weight'].'" selected>'.$product['weight'].' Kg '.$product['p_name'].'</option>'; 
                                                }else{
                                                    
                                                    echo '<option value="'.$product['weight'].'">'.$product['weight'].' Kg '.$product['p_name'].'</option>';
                                                }
                                                
                                                
                                            }
    
    
                                        }
                                            // <option value="" selected hidden>12.5kg cylinders</option>
                                            // <option value="">5kg cylinders</option>
                                            // <option value="">2.3kg cylinders</option>
                                            // <option value="">37.5kg cylinders</option>
                                           
                                        echo '</select>
                                    </div>
                                </div>
                                <div class="quota_logo">
                                    <div class="logo">
                                        <img src= " '.BASEURL.'/public/img/profile/'.$quota['logo'].'" alt="">
                                    </div><div id="'.$quota['name'].'">
                                    <div id ="progress_bar">';
                                    
                                    
                                    $percentage = $remaining_weight/$total_weight * 100;
                                    // $progresscircle = new PercentageCircle($percentage,0); 
                                            // $progresscircle = new PercentageCircle($percentage,0);
                                            echo '</div><div class="remaining"><span style="color:#0047AB;"><strong> Remaining : </strong></span><span style="color:#0047AB;"  id = "remaining_cylinders"><strong>'.$remaining_weight.'</strong></span>&nbsp Cylinders<span><strong></strong></span></div></div></div><div class="bottom_details">
                                                <div class="days" >'.$remaingDays.' days more</div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>';
    
                            }
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


        <script>
        
            const total_quota  =  document.getElementById("total_cylinders");
            const remaining_quota  =  document.getElementById("remaining_cylinders");
            const progress_bar = document.getElementById("progress_bar");
            
                function select_product(total_weight,remaining_weight){
                    var product_weight = document.getElementById("product_dropdown").value;   //get product weight

                    product_weight = parseInt(product_weight);
                    total_weight = parseInt(total_weight);    

                    total_cylinders = Math.floor(total_weight/product_weight);  //total cylinders
                    total_quota.innerHTML = total_cylinders;

                    
                    remaining_cylinders = Math.floor(remaining_weight/product_weight);  //total cylinders
                    remaining_quota.innerHTML = remaining_cylinders;
                    
                    percentage = remaining_cylinders/total_cylinders * 100;

                    event.preventDefault();
                    var formData = new FormData();
                    let xhr = new XMLHttpRequest(); //new xml object
                    var url = 'http://localhost/mvc/Orders/selected_product_quota/'+ percentage;
                    console.log(url);
                    xhr.open('POST', url , true);
                    xhr.onload = ()=>{
                        if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
                            let data = xhr.response;
                        if(data){
                            progress_bar.innerHTML = data;
            
                        }
                        }
                    }
                    xhr.send(formData);


                }

            
       
        // var companies = document.querySelectorAll(".name");
        // for(var i=0;i<companies.length;i++){
        //     console.log(companies[i].innerHTML);
        //     var total_weight = document.querySelector("#total_weight").innerText;
        //     console.log(total_weight);
        //     var page = document.querySelector("#" + companies[i]);

        //     select_product(total_weight ,page);
        // }
        

        //     function select_product(total_weight,page){
        //             var product_weight = document.getElementById("product_dropdown").value;
        //             console.log(product_weight);
        //             event.preventDefault();
        //             var formData = new FormData();
        //             let xhr = new XMLHttpRequest(); //new xml object
        //             var url = 'http://localhost/mvc/Orders/selected_product_quota/'+ product_weight + '/' + total_weight ;
        //             console.log(url);
        //             xhr.open('POST', url , true);
        //             xhr.onload = ()=>{
        //                 if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
        //                     let data = xhr.response;
        //                 if(data){
        //                     page.innerHTML = data;
            
        //                 }
        //                 }
        //             }
        //             xhr.send(formData);
                    

              
        //     }



        


    </script>

</section>