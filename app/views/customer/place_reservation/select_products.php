<?php
$header = new Header("customer/customer_select_products");
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
        <div class="title">
           <h3>Products</h3>
        </div>
        <!-- <div class="middle"> -->
        <?php

            $products = $data['products'];
            echo '
                <div class="gas_cylinder">
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
                                <div class="increment_box">
                                    <div class="minus" onclick="changeqty('.$product['p_id'].','.$product['unit_price'].',minus); return false;">-</div>
                                    <input type="text" name="qty" id="'.$product['p_id'].'" value="0" class="num" >
                                    <div class = "plus" onclick="changeqty('.$product['p_id'].','.$product['unit_price'].',plus); return false;">+</div>
                                </div>
                                <div class="subtotal_part"><p>Subtotal :  </p><h4 class="subtotal" id="sub'.$product['p_id'].'"> Rs. 0.00 </h4></div>
                            </div>
                        ';
                }
            }

            echo '</div>';
            
           
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
                                <div class="increment_box">
                                    <div class="minus"  onclick="changeqty('.$product['p_id'].','.$product['unit_price'].',minus); return false;">-</div>
                                    <input type="text" name="qty" id="'.$product['p_id'].'" value="0" class="num">
                                    <div class="plus"  onclick="changeqty('.$product['p_id'].','.$product['unit_price'].',plus); return false;">+</div>
                                </div>
                                <div class="subtotal_part"><p>Subtotal :  </p><h4 class="subtotal" id="sub'.$product['p_id'].'"> Rs. 0.00 </h4></div>
                            </div>
                        ';
                }
            } 
            echo '</div>
            </div>';      
        ?>
            <!-- <div class="total"> -->
                <!-- <p>sub totals : </p><h3 class="total">" "</h3> -->
            <!-- </div> -->
            <div class="total"> 
                <p>Total Amount : </p><h3 class="amount"> Rs. 0.00</h3>
            </div>

            <div class="bottom">
            <a href="<?php echo BASEURL; ?>/Orders/select_payment_method" class="btn">Next</a>
        </div>
        
    </div>
    


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
        
                subtotal.innerHTML = "Rs." + (inputvalue*unitprice).toLocaleString('en-US') + ".00";

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
            
                    subtotal.innerHTML = "Rs." + (inputvalue*unitprice).toLocaleString('en-US') + ".00";

                    let total = document.querySelector('.total .amount');

                     let totalvalue = get_total();
                     total.innerHTML = "Rs. "+totalvalue +".00";
                }
                
            }

            
            
        }

        function get_total(){
            let total = 0.00;
            let subtotals = document.querySelectorAll('.subtotal');
            for(let i = 0; i < subtotals.length; i++){
                // console.log(subtotals[i]);
                let sub = subtotals[i].innerHTML;
                // console.log(sub);
                sub = sub.substring(3);
                sub = parseFloat(sub.replace(/,/g, ''));
                console.log(sub);
                total += sub;
            }
            return total.toLocaleString('en-US');
        }

    


  

    
   

</script>