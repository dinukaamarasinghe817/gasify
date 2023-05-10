<?php
$header = new Header("customer/customer_viewproducts");
$sidebar = new Navigation('customer',$data['navigation']);
?>

<section class="body">
    <?php
        // call the default header for yout interface
        $bodyheader = new BodyHeader($data);
    ?>

    <div class="under_topbar">
        <div class="title">
           <h3>Products</h3>
        </div>
        <div class="middle">
        <?php

            $products = $data['products'];

            //check if there are any refill cylinder products available in company 
            $r_cylinder_count = 0;
            foreach($products as $product){
                if($product['type'] == 'cylinder'){
                    $r_cylinder_count = $r_cylinder_count + 1;
                }
            }

            //check if there are any accessories available in company 
            $accessory_count = 0;
            foreach($products as $product){
                if($product['type'] == 'accessory'){
                    $accessory_count = $accessory_count + 1;
                }
            }

        //if there are refill cylinder products available in company
        if($r_cylinder_count > 0){
            echo '<div class="gas_cylinder">
                    <div class="subtitle">
                        <h4>Re-Fill Cylinders</h4>
                    </div>
                    <div class="product_list">';
            foreach($products as $product){
                if($product['type']=="cylinder"){
                    echo '
                            <div class="product_card">
                                <div class="product_img"><img src="'.BASEURL.'/public/img/products/'.$product['image'].'" alt=""></div>
                                <div class="product_details">
                                    <div class="brand_name">'.$product['c_name'].'</div>
                                    <div class="name"><h5>'.$product['weight'].'Kg '.$product['p_name'].'</h5></div>
                                    <div class="price"><h4>Rs.'.number_format($product['unit_price']).'.00</h4></div>
                                </div> 
                            </div>
                        ';
                }
            }

        }

            echo '</div>
            </div>';


        //if there are accessory products available in company
        if($accessory_count > 0){    
            echo '<div class="accessories">
                    <div class="subtitle">
                        <h4>Accessories</h4>
                    </div>
                    <div class="product_list">';
                
            foreach($products as $product){
                if($product['type']=="accessory"){
                    echo '
                            <div class="product_card">
                                <div class="product_img"><img src="'.BASEURL.'/public/img/products/'.$product['image'].'" alt=""></div>
                                <div class="product_details">
                                    <div class="brand_name">'.$product['c_name'].'</div>
                                    <div class="name"><h5>'.$product['p_name'].'</h5></div>
                                    <div class="price"><h4>Rs.'.number_format($product['unit_price']).'.00</h4></div>
                                </div> 
                            </div>
                        ';
                }
            } 
        
        }
            echo '</div>
            </div>';      
        ?>
        </div>
    </div>


</section>