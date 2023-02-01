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
           <h3>Payment Method</h3>
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

                <li>
                    <div class="order_item">
                        <img src="<?php echo BASEURL; ?>/public/img/products/12.5kglitro.png" alt="">
                        <div>
                            <h3>Regular Gas Cylinder</h3>
                            <p>12 .5 kg</p>
                        </div>
                        <p>Unit Price<br>Rs 4500.00</p>
                        <div><p>Quntity</p><h2>x 3</h2></div>
                        <p>Subtotal<br>Rs 13,500.00</p>
                        <!-- <svg width="30" height="30" viewBox="0 0 854 976" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M365.987 0C298.889 0 243.991 54.898 243.991 121.996H121.996C54.898 121.996 0 176.894 0 243.991H853.97C853.97 176.894 799.071 121.996 731.974 121.996H609.978C609.978 54.898 555.08 0 487.983 0H365.987ZM121.996 365.987V952.786C121.996 966.205 131.755 975.965 145.175 975.965H710.015C723.434 975.965 733.194 966.205 733.194 952.786V365.987H611.198V792.972C611.198 827.13 584.359 853.969 550.2 853.969C516.042 853.969 489.203 827.13 489.203 792.972V365.987H367.207V792.972C367.207 827.13 340.368 853.969 306.209 853.969C272.05 853.969 245.211 827.13 245.211 792.972V365.987H123.216H121.996Z" fill="#FF4D4D"/>
                        </svg> -->
                    </div>
                </li>

                




                <li>
                    <div class="poitem">
                        <!-- <a href = "'.BASEURL.'/stock/dealer/pohistory" ><button class="btn" onclick>Back</button></a> -->
                        <div class="total">
                            <div><h3>Total </h3></div>
                            <div><h3>Rs. 13,500.00</h3></div>
                        </div>
                    </div>
                </li>
            </ul>

            


        </div>
        <div class="bottom">
            <div><h2>Select Payment Method:</h2></div>
            <div class="p_methods">
                <div class="btn"><button><a href="'.BASEURL.'/Orders/select_brand_city_dealer"">
                    <svg width="40" height="40" viewBox="0 0 152 122" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M139.333 96.5833V111.833H12.666V96.5833C12.666 93.7875 15.516 91.5 18.9993 91.5H132.999C136.483 91.5 139.333 93.7875 139.333 96.5833Z" fill="#FC7949" stroke="#FC7949" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M44.334 55.9165H31.6673V91.4999H44.334V55.9165ZM69.6673 55.9165H57.0006V91.4999H69.6673V55.9165ZM95.0006 55.9165H82.334V91.4999H95.0006V55.9165ZM120.334 55.9165H107.667V91.4999H120.334V55.9165ZM145.667 115.646H6.33398C3.73732 115.646 1.58398 113.917 1.58398 111.833C1.58398 109.749 3.73732 108.021 6.33398 108.021H145.667C148.264 108.021 150.417 109.749 150.417 111.833C150.417 113.917 148.264 115.646 145.667 115.646ZM135.344 29.229L78.344 10.929C77.0773 10.5224 74.924 10.5224 73.6573 10.929L16.6573 29.229C14.4407 29.9407 12.6673 32.0249 12.6673 33.9565V50.8332C12.6673 53.629 15.5173 55.9165 19.0007 55.9165H133.001C136.484 55.9165 139.334 53.629 139.334 50.8332V33.9565C139.334 32.0249 137.561 29.9407 135.344 29.229ZM76.0006 43.2082C70.744 43.2082 66.5006 39.8024 66.5006 35.5832C66.5006 31.364 70.744 27.9582 76.0006 27.9582C81.2573 27.9582 85.5006 31.364 85.5006 35.5832C85.5006 39.8024 81.2573 43.2082 76.0006 43.2082Z" fill="#FC7949"/>
                    </svg>Credit Card</a></button>
                </div>

                <div class="btn"><button><a href="'.BASEURL.'/Orders/select_brand_city_dealer"">
                    <svg width="40" height="40" viewBox="0 0 152 122" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M139.333 96.5833V111.833H12.666V96.5833C12.666 93.7875 15.516 91.5 18.9993 91.5H132.999C136.483 91.5 139.333 93.7875 139.333 96.5833Z" fill="#FC7949" stroke="#FC7949" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M44.334 55.9165H31.6673V91.4999H44.334V55.9165ZM69.6673 55.9165H57.0006V91.4999H69.6673V55.9165ZM95.0006 55.9165H82.334V91.4999H95.0006V55.9165ZM120.334 55.9165H107.667V91.4999H120.334V55.9165ZM145.667 115.646H6.33398C3.73732 115.646 1.58398 113.917 1.58398 111.833C1.58398 109.749 3.73732 108.021 6.33398 108.021H145.667C148.264 108.021 150.417 109.749 150.417 111.833C150.417 113.917 148.264 115.646 145.667 115.646ZM135.344 29.229L78.344 10.929C77.0773 10.5224 74.924 10.5224 73.6573 10.929L16.6573 29.229C14.4407 29.9407 12.6673 32.0249 12.6673 33.9565V50.8332C12.6673 53.629 15.5173 55.9165 19.0007 55.9165H133.001C136.484 55.9165 139.334 53.629 139.334 50.8332V33.9565C139.334 32.0249 137.561 29.9407 135.344 29.229ZM76.0006 43.2082C70.744 43.2082 66.5006 39.8024 66.5006 35.5832C66.5006 31.364 70.744 27.9582 76.0006 27.9582C81.2573 27.9582 85.5006 31.364 85.5006 35.5832C85.5006 39.8024 81.2573 43.2082 76.0006 43.2082Z" fill="#FC7949"/>
                    </svg>Credit Card</a></button>
                </div>


            </div>
        </div>
        

        <!-- <div class="bottom">
            <a href="<?php echo BASEURL; ?>/Products/select_products/2" class="btn">Next</a>
        </div> -->

</section>