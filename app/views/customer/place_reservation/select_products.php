<?php
$header = new Header("customer/customer_select_products",$data);
$sidebar = new Navigation('customer',$data['navigation']);
?>

<section class="body">
    <?php
        // call the default header for yout interface
        $bodyheader = new BodyHeader($data);
        // call whatever the component you need to show
        // $bodycontent = new Body('addreview', $data);
        if(isset($data['toast'])){
            $error = new Prompt('toast',$data['toast']);

        }
        
    ?>

    <div class="under_topbar">
        <div class="title">
           <h3>Products</h3>
        </div>
        <div class="middle">
        <?php

            $company_id = $data['company_id'];
            $city = $data['city'];
            $dealer_id = $data['dealer_id'];

            $products = $data['products'];

            //check if previous selected products are available(in the session)
            if(isset($_SESSION['order_products'])){
                $old_selected_products = $_SESSION['order_products'];
                
                    echo '<form action="'.BASEURL.'/Orders/selected_products/'.$dealer_id.'" method="POST">';
                    
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
                        $total_amount = 0;
                        //if there are refill cylinder products available in company
                        if($r_cylinder_count > 0){
                            echo '
                            <div class="gas_cylinder">
                                <div class="subtitle">
                                    <h4>Re-Fill Cylinders</h4>
                                </div>
                                <div class="product_list">';
                            //check cylinders are available in the session
                            foreach($products as $product){
                                if($product['type']=="cylinder"){
                                    $flag = false;  //flag for identify that product is available in session or not(default not available in session)

                                    foreach($old_selected_products as $old_selected_product){
                                        //if product p_id is in the old_selected_products array(session) then that product in session 
                                        if($old_selected_product['product_id'] == $product['p_id']){
                                            $flag = true;
                                            $old_product_id = $old_selected_product['product_id'];
                                            $old_unit_price = $old_selected_product['unit_price'];
                                            $old_qty = $old_selected_product['qty'];
                                            $old_subtotal= $old_qty*$old_unit_price;
                                            $total_amount += $old_subtotal;
                                        }
                                    }

                                    //display this part for any product which is in the session
                                    if($flag){ 
                                        echo '
                                            <div class="product_card">
                                                <div class="product_img"><img src="'.BASEURL.'/public/img/products/'.$product['image'].'" alt=""></div>
                                                <div class="product_details">
                                                    <div class="brand_name">'.$product['c_name'].'</div>
                                                    <div class="name"><h5>'.$product['weight'].'Kg '.$product['p_name'].'</h5><h4>'.$product['dealer_stock'].' in stock</h4></div>
                                                    <div class="price"><h4>Rs.'.number_format($product['unit_price']).'.00</h4></div>
                                                </div>
                                                <div class="increment_box">
                                                    <div class="minus" onclick="changeqty('.$product['p_id'].','.$product['unit_price'].',minus); return false;">-</div>
                                                    <input type="number" name="'.$product['p_id'].'" id="'.$product['p_id'].'" value="'.$old_qty.'" class="num" readonly>
                                                    <div class = "plus" onclick="changeqty('.$product['p_id'].','.$product['unit_price'].',plus); return false;">+</div>
                                                </div>
                                                <div class="subtotal_part"><p>Subtotal :  </p><h4 class="subtotal" id="sub'.$product['p_id'].'"> Rs. '.number_format($old_subtotal,2).' </h4></div>
                                            </div>
                                        ';
                                    }else{
                                        echo '
                                            <div class="product_card">
                                                <div class="product_img"><img src="'.BASEURL.'/public/img/products/'.$product['image'].'" alt=""></div>
                                                <div class="product_details">
                                                    <div class="brand_name">'.$product['c_name'].'</div>
                                                    <div class="name"><h5>'.$product['weight'].'Kg '.$product['p_name'].'</h5><h4>'.$product['dealer_stock'].' in stock</h4></div>
                                                    <div class="price"><h4>Rs.'.number_format($product['unit_price']).'.00</h4></div>
                                                </div>
                                                <div class="increment_box">
                                                    <div class="minus" onclick="changeqty('.$product['p_id'].','.$product['unit_price'].',minus); return false;">-</div>
                                                    <input type="number" name="'.$product['p_id'].'" id="'.$product['p_id'].'" value="0" class="num" readonly>
                                                    <div class = "plus" onclick="changeqty('.$product['p_id'].','.$product['unit_price'].',plus); return false;">+</div>
                                                </div>
                                                <div class="subtotal_part"><p>Subtotal :  </p><h4 class="subtotal" id="sub'.$product['p_id'].'"> Rs. 0.00 </h4></div>
                                            </div>
                                        ';
                                    }
                                }
                                
                                
                            }

                            echo '</div>';

                        }

                        //if there are accessory products available in company
                        if($accessory_count > 0){
                            echo '<div class="accessories">
                            <div class="subtitle">
                                <h4>Accessories</h4>
                            </div>
                            <div class="product_list">';
                            //check accessories are available in the session
                            foreach($products as $product){
                                if($product['type']=="accessory"){
                                    $flag = false; //flag for identify that product is available in session or not(default not available in session)

                                    foreach($old_selected_products as $old_selected_product){
                                        if($old_selected_product['product_id'] == $product['p_id']){
                                            $flag = true;
                                            $old_product_id = $old_selected_product['product_id'];
                                            $old_unit_price = $old_selected_product['unit_price'];
                                            $old_qty = $old_selected_product['qty'];
                                            $old_subtotal= $old_qty*$old_unit_price;
                                            $total_amount += $old_subtotal;
                                        }
                                    }

                                    if($flag){
                                        echo '
                                            <div class="product_card">
                                                <div class="product_img"><img src="'.BASEURL.'/public/img/products/'.$product['image'].'" alt=""></div>
                                                <div class="product_details">
                                                    <div class="brand_name">'.$product['c_name'].'</div>
                                                    <div class="name"><h5>'.$product['weight'].'Kg '.$product['p_name'].'</h5><h4>'.$product['dealer_stock'].' in stock</h4></div>
                                                    <div class="price"><h4>Rs.'.number_format($product['unit_price']).'.00</h4></div>
                                                </div>
                                                <div class="increment_box">
                                                    <div class="minus" onclick="changeqty('.$product['p_id'].','.$product['unit_price'].',minus); return false;">-</div>
                                                    <input type="number" name="'.$product['p_id'].'" id="'.$product['p_id'].'" value="'.$old_qty.'" class="num" readonly>
                                                    <div class = "plus" onclick="changeqty('.$product['p_id'].','.$product['unit_price'].',plus); return false;">+</div>
                                                </div>
                                                <div class="subtotal_part"><p>Subtotal :  </p><h4 class="subtotal" id="sub'.$product['p_id'].'">Rs. '.number_format($old_subtotal,2).'</h4></div>
                                            </div>
                                        ';
                                    }else{
                                        echo '
                                            <div class="product_card">
                                                <div class="product_img"><img src="'.BASEURL.'/public/img/products/'.$product['image'].'" alt=""></div>
                                                <div class="product_details">
                                                    <div class="brand_name">'.$product['c_name'].'</div>
                                                    <div class="name"><h5>'.$product['weight'].'Kg '.$product['p_name'].'</h5><h4>'.$product['dealer_stock'].' in stock</h4></div>
                                                    <div class="price"><h4>Rs.'.number_format($product['unit_price']).'.00</h4></div>
                                                </div>
                                                <div class="increment_box">
                                                    <div class="minus" onclick="changeqty('.$product['p_id'].','.$product['unit_price'].',minus); return false;">-</div>
                                                    <input type="number" name="'.$product['p_id'].'" id="'.$product['p_id'].'" value="0" class="num" readonly>
                                                    <div class = "plus" onclick="changeqty('.$product['p_id'].','.$product['unit_price'].',plus); return false;">+</div>
                                                </div>
                                                <div class="subtotal_part"><p>Subtotal :  </p><h4 class="subtotal" id="sub'.$product['p_id'].'"> Rs. 0.00 </h4></div>
                                            </div>
                                        ';
                                    }
                                }
                            } 
                            echo '</div>
                            </div>'; 
                    
                        }   
                        //display total        
                        echo '
                    <div class="total"> 
                        <h3>Total Amount : </h3><h3 class="amount"> Rs. '.number_format($total_amount,2).'</h3>
                    </div>

                    <div class="bottom">
                        <a href=" '.BASEURL.'/Orders/select_brand_city_dealer" class="btn" id="back_btn" >Back</a>
                        <!-- <a href="<?php echo BASEURL; ?>/Orders/select_payment_method" class="btn" id="next_btn">Next</a> -->
                        <button type="submit" class="btn" id="next_btn" >Next</button>
                    </div>
                    </form>
                
                </div>';
                   
                
                unset($_SESSION['order_products']);
            } 
            //if session variable is not available display this part
            else{ 

                echo '<form action="'.BASEURL.'/Orders/selected_products/'.$dealer_id.'" method="POST">';
                
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
                        echo '
                        <div class="gas_cylinder">
                            <div class="subtitle">
                                <h4>Re-Fill Cylinders</h4>
                            </div>
                            <div class="product_list">';
                        //display cylinder products in company
                        foreach($products as $product){
                            if($product['type']=="cylinder"){
                                echo '
                                    <div class="product_card">
                                        <div class="product_img"><img src="'.BASEURL.'/public/img/products/'.$product['image'].'" alt=""></div>
                                        <div class="product_details">
                                            <div class="brand_name">'.$product['c_name'].'</div>
                                            <div class="name"><h5>'.$product['weight'].'Kg '.$product['p_name'].'</h5><h4>'.$product['dealer_stock'].' in stock</h4></div>
                                            <div class="price"><h4>Rs.'.number_format($product['unit_price']).'.00</h4></div>
                                        </div>
                                        <div class="increment_box">
                                            <div class="minus" onclick="changeqty('.$product['p_id'].','.$product['unit_price'].',minus); return false;">-</div>
                                            <input type="number" name="'.$product['p_id'].'" id="'.$product['p_id'].'" value="0" class="num" readonly>
                                            <div class = "plus" onclick="changeqty('.$product['p_id'].','.$product['unit_price'].',plus); return false;">+</div>
                                        </div>
                                        <div class="subtotal_part"><p>Subtotal :  </p><h4 class="subtotal" id="sub'.$product['p_id'].'"> Rs. 0.00 </h4></div>
                                    </div>
                                ';
                            }
                        }

                        echo '</div>';

                    }
                    
                    //if there are accessory products available in company
                    if($accessory_count > 0){
                        echo '<div class="accessories">
                        <div class="subtitle">
                            <h4>Accessories</h4>
                        </div>
                        <div class="product_list">';
                        //display accessories in company
                        foreach($products as $product){
                            if($product['type']=="accessory"){
                                echo '
                                        <div class="product_card">
                                            <div class="product_img"><img src="'.BASEURL.'/public/img/products/'.$product['image'].'" alt=""></div>
                                            <div class="product_details">
                                                <div class="brand_name">'.$product['c_name'].'</div>
                                                <div class="name"><h5>'.$product['p_name'].'</h5><h4>'.$product['dealer_stock'].' in stock</h4></div>
                                                <div class="price"><h4>Rs.'.number_format($product['unit_price']).'.00</h4></div>
                                            </div> 
                                            <div class="increment_box">
                                                <div class="minus"  onclick="changeqty('.$product['p_id'].','.$product['unit_price'].',minus); return false;">-</div>
                                                <input type="text" name="'.$product['p_id'].'" id="'.$product['p_id'].'" value="0" class="num" readonly>
                                                <div class="plus"  onclick="changeqty('.$product['p_id'].','.$product['unit_price'].',plus); return false;">+</div>
                                            </div>
                                            <div class="subtotal_part"><p>Subtotal :  </p><h4 class="subtotal" id="sub'.$product['p_id'].'"> Rs. 0.00 </h4></div>
                                        </div>
                                    ';
                            }
                        } 
                        echo '</div>
                        </div>'; 
                    }
 
                    //display the total
                    echo '
                    <div class="total"> 
                        <h3>Total Amount : </h3><h3 class="amount"> Rs. 0.00</h3>
                    </div>

                    <div class="bottom">
                        <a href=" '.BASEURL.'/Orders/select_brand_city_dealer" class="btn" id="back_btn" >Back</a>
                        <!-- <a href="<?php echo BASEURL; ?>/Orders/select_payment_method" class="btn" id="next_btn">Next</a> -->
                        <button type="submit" class="btn" id="next_btn" >Next</button>
                    </div>
                    </form>
                
                </div>';
             } 
        ?>


</section>

<script>
    var plus = document.getElementsByClassName('plus');
    var minus = document.getElementsByClassName('minus');
    // num = document.getElementById('num');

    for(var i=0;i<plus.length;i++){
        var button = plus[i];
        button.addEventListener('click',function(event){
            
            var buttonClicked = event.target;
            // console.log(buttonClicked);
            var input = buttonClicked.parentElement.children[1];
            // console.log(input);
            
            var inputValue = input.value;
            // console.log(inputValue);
            
            var newValue = parseInt(inputValue) + 1;
            // console.log(newValue);
            
            input.value = newValue;
            
        })

    }

    for(var i=0;i<minus.length;i++){
        var button = minus[i];
        button.addEventListener('click',function(event){
            
            var buttonClicked = event.target;
            // console.log(buttonClicked);
            var input = buttonClicked.parentElement.children[1];
            // console.log(input);
            
            var inputValue = input.value;
            // console.log(inputValue);
            var newValue = parseInt(inputValue) - 1;
            // console.log(newValue);
            
            input.value = newValue;

            if(newValue >= 0){
                input.value = newValue;

            }
            else{
                input.value = 0;

            }

        })

    }


    function changeqty(id, unitprice,operation) {
        id = parseInt(id);
        unitprice = parseFloat(unitprice);
        if (operation == plus) {

            let inputstring = `${id}`;
            let input = document.getElementById(inputstring);
            let inputvalue = parseInt(input.value)+1;
        
            let substring = `sub${id}`;
            let subtotal = document.getElementById(substring);
    
            subtotal.innerHTML = "Rs. " + (inputvalue*unitprice).toLocaleString('en-US') + ".00";

            let total = document.querySelector('.total .amount');

                let totalvalue = get_total();
            total.innerHTML = "Rs. "+totalvalue +".00";
        }
        if(operation == minus){
            let inputstring = `${id}`;
            let input = document.getElementById(inputstring);
            if (input.value > 0) {
                let inputvalue = parseInt(input.value)- 1;

                let substring = `sub${id}`;
                let subtotal = document.getElementById(substring);
        
                subtotal.innerHTML = "Rs. " + (inputvalue*unitprice).toLocaleString('en-US') + ".00";

                let total = document.querySelector('.total .amount');
                
                    let totalvalue = get_total();
                    total.innerHTML = "Rs. "+ totalvalue +".00";
            }
            
        }

        
        
    }

    function get_total(){
        let total = 0.00;
        let subtotals = document.querySelectorAll('.subtotal');
        for(let i = 0; i < subtotals.length; i++){
            // console.log(subtotals[i].id);
            let sub = subtotals[i].innerHTML;
            // console.log(sub);
            sub = sub.substring(4);
            sub = parseFloat(sub.replace(/,/g, ''));
            console.log(sub+0.01);
            // console.log(sub);
            total += sub;
        }
        return total.toLocaleString('en-US');
    }

    function move_next(){
        let qty_input = document.querySelectorAll('.qty');
        let total = document.querySelector('.total .amount');
        total_amount = total.innerHTML;
        // var products = {};
        for(let i = 0; i < qty_input.length; i++){
            console.log(qty_input[i].id);

        //     if(qty[i].value != 0){
                // let product_id = qty_input[i].id;
                // let quantity = qty_input[i].value;
                // products.product_id = product_id;
                // products.quantity = quantity;
                // console.log(product_id);
                // console.log(quantity);
            // } 


        }
    }


</script>