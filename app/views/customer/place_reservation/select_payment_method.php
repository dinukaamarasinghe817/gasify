<?php
$header = new Header("customer/select_payment_method");
$sidebar = new Navigation('customer',$data['navigation']);
?>

<section class="body">
    <?php
        // call the default header for yout interface
        $bodyheader = new BodyHeader($data);
        
    ?>

    <div class="under_topbar">
        <div class="subtitle">
           <h3>Payments</h3>
        </div> 
        
        <div class="middle">
            <div class="order_detail_table">
                <!-- <div class="order_table_header">
                    <div>Product</div>
                    <div>Name</div>
                    <div>Price</div>
                    <div>Qty</div>
                    <div>Total</div>
                    <div></div>
                </div>
                <div class="order_table_row">
                    <div class="product"><img src="<?php echo BASEURL; ?>/public/img/products/12.5kglitro.png" alt=""></div>
                    <div class="name">
                        <div class="brand"><p>Litro</p></div>
                        <div class="p_name"><p>12.5 kg Regular Gas Cylinder</p></div>
                    </div>
                    <div class="price"><p>Rs. 4,500.00</p3></div>
                    <div class="Qty"><p>2</p></div>
                    <div class="total"><p>Rs. 9,000.00</p></div>
                    <div class="delete">hgwhjgjd</div>
                </div>
                
                
            </div> --> 
             
            <ul>
                <?php
                    if (isset($data['selected_products'])) {

                        $selected_products = $data['selected_products'];
                        $total = 0;
                        foreach ( $selected_products as $selected_product){
                            $quantity = $selected_product['quantity'];
                            $row = $selected_product['product_details'];
                            $total += $quantity*$row['unit_price'];
                            $subtotal = number_format($quantity*$row['unit_price'],2);
                            echo '<li>
                                        <div class="order_item">
                                            <img src="'.BASEURL.'/public/img/products/'.$row['image'].'" alt="">
                                            <div>
                                                <h3>'.$row['name'].'</h3>
                                                <p>'.$row['weight'].' kg</p>
                                            </div>
                                            <p>Unit Price<br>Rs '.number_format($row['unit_price'],2).'</p>
                                            <div><p>Quntity</p><h2>x '.$quantity.'</h2></div>
                                            <p>Subtotal<br>Rs '.$subtotal.'</p>
                                            <!-- <svg width="30" height="30" viewBox="0 0 854 976" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M365.987 0C298.889 0 243.991 54.898 243.991 121.996H121.996C54.898 121.996 0 176.894 0 243.991H853.97C853.97 176.894 799.071 121.996 731.974 121.996H609.978C609.978 54.898 555.08 0 487.983 0H365.987ZM121.996 365.987V952.786C121.996 966.205 131.755 975.965 145.175 975.965H710.015C723.434 975.965 733.194 966.205 733.194 952.786V365.987H611.198V792.972C611.198 827.13 584.359 853.969 550.2 853.969C516.042 853.969 489.203 827.13 489.203 792.972V365.987H367.207V792.972C367.207 827.13 340.368 853.969 306.209 853.969C272.05 853.969 245.211 827.13 245.211 792.972V365.987H123.216H121.996Z" fill="#FF4D4D"/>
                                            </svg> -->
                                        </div>
                                    </li>';

                        }
                        
                        


                    }



            
                ?>
                <!-- <li>
                    <div class="order_item">
                        <img src="/public/img/products/12.5kglitro.png" alt="">
                        <div>
                            <h3>Regular Gas Cylinder</h3>
                            <p>12 .5 kg</p>
                        </div>
                        <p>Unit Price<br>Rs 4500.00</p>
                        <div><p>Quntity</p><h2>x 3</h2></div>
                        <p>Subtotal<br>Rs 13,500.00</p> -->
                        <!-- <svg width="30" height="30" viewBox="0 0 854 976" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M365.987 0C298.889 0 243.991 54.898 243.991 121.996H121.996C54.898 121.996 0 176.894 0 243.991H853.97C853.97 176.894 799.071 121.996 731.974 121.996H609.978C609.978 54.898 555.08 0 487.983 0H365.987ZM121.996 365.987V952.786C121.996 966.205 131.755 975.965 145.175 975.965H710.015C723.434 975.965 733.194 966.205 733.194 952.786V365.987H611.198V792.972C611.198 827.13 584.359 853.969 550.2 853.969C516.042 853.969 489.203 827.13 489.203 792.972V365.987H367.207V792.972C367.207 827.13 340.368 853.969 306.209 853.969C272.05 853.969 245.211 827.13 245.211 792.972V365.987H123.216H121.996Z" fill="#FF4D4D"/>
                        </svg> -->
                    <!-- </div>
                </li> -->

                




                <li>
                    <div class="poitem">
                        <!-- <a href = "'.BASEURL.'/stock/dealer/pohistory" ><button class="btn" onclick>Back</button></a> -->
                        <div class="total">
                            <div><h3>Total </h3></div>
                            <div><h3>Rs. <?php echo number_format($total,2); ?></h3></div>
                        </div>
                    </div>
                </li>
            </ul>

            


        </div>
        <div class="bottom">
            <div><h2>Select Payment Method:</h2></div>
            <div class="bottom_content">
                <div class="bottom_img"><img src="<?php echo BASEURL;?>/public/img/customer/payment_method.png" alt=""></div>
                <div class="p_methods">
                    <!-- <div class="p_btn"><button onclick="location.href = '<?php echo BASEURL; ?>/Orders/payment_gateway'"> -->
                    <!-- <div class="p_btn"><button onclick="paynow(1);"> -->
                        <!-- <svg width="40" height="40" viewBox="0 0 263 176" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8.21875 0C3.61625 0 0 3.22667 0 7.33333V29.3333H263V7.33333C263 3.22667 259.384 0 254.781 0H8.21875ZM0 58.6667V168.667C0 172.773 3.61625 176 8.21875 176H254.781C259.384 176 263 172.773 263 168.667V58.6667H0ZM32.875 117.333H65.75V146.667H32.875V117.333ZM98.625 117.333H131.5V146.667H98.625V117.333Z" fill=""/>
                        </svg>Credit Card</button>
                    </div> -->
                    <div class="p_btn">
                        <?php
                            $keys = $data['dealer_keys'];
                            $card = new Payment('orders/payment_gateway',$data['email'],$total,$keys['pub_key'],$keys['rest_key'],$_SESSION['dealer_id']);
                        ?>
                    </div>

                    <div class="p_btn"><button onclick="location.href = '<?php echo BASEURL; ?>/Orders/bank_slip_upload'">
                        <svg width="40" height="40" viewBox="0 0 152 122" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M139.333 96.5833V111.833H12.666V96.5833C12.666 93.7875 15.516 91.5 18.9993 91.5H132.999C136.483 91.5 139.333 93.7875 139.333 96.5833Z" fill="#FC7949" stroke="#FC7949" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M44.334 55.9165H31.6673V91.4999H44.334V55.9165ZM69.6673 55.9165H57.0006V91.4999H69.6673V55.9165ZM95.0006 55.9165H82.334V91.4999H95.0006V55.9165ZM120.334 55.9165H107.667V91.4999H120.334V55.9165ZM145.667 115.646H6.33398C3.73732 115.646 1.58398 113.917 1.58398 111.833C1.58398 109.749 3.73732 108.021 6.33398 108.021H145.667C148.264 108.021 150.417 109.749 150.417 111.833C150.417 113.917 148.264 115.646 145.667 115.646ZM135.344 29.229L78.344 10.929C77.0773 10.5224 74.924 10.5224 73.6573 10.929L16.6573 29.229C14.4407 29.9407 12.6673 32.0249 12.6673 33.9565V50.8332C12.6673 53.629 15.5173 55.9165 19.0007 55.9165H133.001C136.484 55.9165 139.334 53.629 139.334 50.8332V33.9565C139.334 32.0249 137.561 29.9407 135.344 29.229ZM76.0006 43.2082C70.744 43.2082 66.5006 39.8024 66.5006 35.5832C66.5006 31.364 70.744 27.9582 76.0006 27.9582C81.2573 27.9582 85.5006 31.364 85.5006 35.5832C85.5006 39.8024 81.2573 43.2082 76.0006 43.2082Z" fill=""/>
                        </svg>Bank Deposit</button>
                    </div>

                    

                </div>

            </div>
        </div>
        
        <div class="bottom">
            <a href=" <?php echo BASEURL ;?>/Orders/select_products" class="btn" id="back_btn" >Back</a>
        </div>
        <script>
            function paynow(orderId){
            // Payment completed. It can be a successful failure.
            payhere.onCompleted = function onCompleted(orderId) {
                console.log("Payment completed. OrderID:" + orderId);
                // Note: validate the payment and show success or failure page to the customer
            };

            // Payment window closed
            payhere.onDismissed = function onDismissed() {
                // Note: Prompt user to pay again or show an error page
                console.log("Payment dismissed");
            };

            // Error occurred
            payhere.onError = function onError(error) {
                // Note: show an error page
                console.log("Error:"  + error);
            };

            // Put the payment variables here
            var payment = {
                "sandbox": true,
                "merchant_id": "1220978",    // Replace your Merchant ID
                "merchant_secret": "MzE2OTk4ODg1NTQ2NzE3MjQyMjE1ODE1MTcxOTk0NDA2ODUzODI=",    // Replace your Merchant ID
                "return_url": "undefined",     // Important
                "cancel_url": "undefined",     // Important
                "notify_url": "http://sample.com/notify",
                "order_id": "1",
                "items": "Door bell wireles",
                "amount": "1000.00",
                "currency": "LKR",
                "hash": "45D3CBA93E9F2189BD630ADFE19AA6DC", // *Replace with generated hash retrieved from backend
                "first_name": "Saman",
                "last_name": "Perera",
                "email": "dinukaamarasinghe817@gmail.com",
                "phone": "0714872852",
                "address": "No.1, Galle Road",
                "city": "Colombo",
                "country": "Sri Lanka",
                "delivery_address": "No. 46, Galle road, Kalutara South",
                "delivery_city": "Kalutara",
                "delivery_country": "Sri Lanka",
                "custom_1": "",
                "custom_2": ""
            };

            // Show the payhere.js popup, when "PayHere Pay" is clicked
                payhere.startPayment(payment);
            }
        </script>
    </div>
</section>