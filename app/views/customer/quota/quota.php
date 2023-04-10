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
                <form action="<?php echo BASEURL;?>/Orders/customer_quota" method="post" id="quota_form">   
                    <?php
                        $companies_array = $data['companies_array'];
                        if(isset($companies_array)){
                            foreach($companies_array as $company_array){

                                $next_month = date('m', strtotime('+1 month'));  //quota finished month
        
                                $start_date = date('Y/m/01');  //quota start date
                                $end_date = date('Y/'.$next_month.'/01');  //quota end date
    
                                $today = date('Y/m/d');  //today's date
    
                                $Date1 = new DateTime($today);
                                $Date2 = new DateTime($end_date);
    
                                $interval = $Date1->diff($Date2);
                                $remaingDays = $interval->days;     //calculate current days

                                $company_id = $company_array['company_id'];
                                $company_name = $company_array['name'];
                                $company_logo = $company_array['logo'];
                               
                                //if quota is active 
                                if($company_array['quota_state']=='ON'){

                                    $selected_pid = $company_array['selected_pid'];
                                    $total_cylinders = $company_array['total_cyl'];
                                    $remaining_cylinders = $company_array['remaining_cyl'];
                                    
                                    echo  '<div class="one_company">
                                            <div class="company_details">
                                                <div class="name">'.$company_name.'</div>
                                                <div class="date"><span>Time Period : </span>'.$start_date.' - '.$end_date.'</div>
                                            </div>
                                            <div class="company_quota" >
                                                <div class="quota-bars">
                                            
                                                    <div class="bar">
                                                        <div class="total_dropdown">
                                                            <div class="total">
                                                                <span style="color:#0047AB;"><strong>Total : </strong></span><span id="total_cylinders" style="color:#0047AB;"><strong> &nbsp '.$total_cylinders.'</strong></span><span style="color:#0047AB;"><strong> &nbsp Cylinders</strong></span> 
                                                            </div>
                                                            <div>
                                                                <select id="product_dropdown"  name = "'.$company_id.'" class="dropdowndate" onchange = "this.form.submit()">';
                                                                $all_products = $company_array['all_products'];
                                                                foreach ($all_products as $product) {
                                                                    if($product['product_id']==$selected_pid){
                                                                        echo '<option value="'.$product['product_id'].'" selected >'.$product['product_weight'].' Kg '.$product['product_name'].'</option>'; 

                                                                    }else{
                                                                        echo '<option value="'.$product['product_id'].'">'.$product['product_weight'].' Kg '.$product['product_name'].'</option>';
                                                                    }
                                                                }
                                                                    
                                                                echo '</select>
                                                            </div>
                                                        </div>
                                                        <div class="quota_logo">
                                                            <div class="logo">
                                                                <img src= " '.BASEURL.'/public/img/profile/'.$company_logo.'" alt="">
                                                            </div><div id="'.$company_id.'">
                                                            <div id ="progress_bar">';
                                                                //progress circle
                                                                $progresscircle = new Quota($selected_pid,$total_cylinders,$remaining_cylinders); 
                                                    echo '</div><div class="remaining"><span style="color:#0047AB;"><strong> Remaining : </strong></span><span style="color:#0047AB;"  id = "remaining_cylinders"><strong>'.$remaining_cylinders.'</strong></span><span style="color:#0047AB;"><strong>&nbsp Cylinders</strong></span></div></div></div><div class="bottom_details">
                                                            <div class="days" >'.$remaingDays.' days more</div>   
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
                            
                                    
                                }
                                //if qouata is inactivated
                                else{
                                
                                    echo  '<div class="one_company">
                                            <div class="company_details">
                                                <div class="name">'.$company_name.'</div>
                                                <div class="date"><span> &nbsp </span></div>
                                            </div>
                                            <div class="company_quota" >
                                                <div class="quota-bars">
                                            
                                                    <div class="bar">
                                                        <div class="total_dropdown">
                                                            <div class="total">
                                                                <span style="color:#0047AB;"><strong></strong></strong></span><span id="total_cylinders" style="color:#0047AB;"><strong> </strong></span><span style="color:#0047AB;"><strong> &nbsp </strong></span> 
                                                            </div>        
                                                        </div>
                                                        <div class="quota_logo">
                                                            <div class="logo">
                                                                <img src= " '.BASEURL.'/public/img/profile/'.$company_logo.'" alt="">
                                                            </div>
                                                            <div id="'.$company_id.'">
                                                                <div id ="progress_bar">
                                                                </div>
                                                               <div class="remaining"><span style="color:#f20202;"><strong>Quota Disabled!</strong></span></div>
                                                            </div>
                                                        </div> 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';
                
                                    
                                   
                                }
                            }  
                        }
                        


                    ?>
                </form>
            </div>     
    
        </div>
        
    </div>

</section>