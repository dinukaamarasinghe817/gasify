<?php

class Body{

    public function __construct($user, $data = null){
        $this->$user($data);
    }

    function dealerdashboard($data){
        echo '<section class="body-content dashboard">
                    <div class="body-left">
                        <div class="variable">
                            <div class="topic">
                                <h3>Analytic Overview</h3>
                                <!-- drop down component -->
                                <form action="'.BASEURL.'/dashboard/dealer" method="post">
                                    <select id="period" name="option" onchange="this.form.submit()" class="dropdowndate">';
                                        if($data['option'] == 'today') {
                                            echo '<option value="today" selected>To day</option>
                                            <option  value="30day">Last 30 days</option>';
                                        }else{
                                            echo '<option value="today" >To day</option>
                                            <option  value="30day" selected>Last 30 days</option>';
                                        }
                                    echo '</select>
                                </form>
                            </div>
                            <div class="tiles">
                                <div class="tile">
                                    <h1>'.sprintf("%02d",$data['total_count']).'</h1>
                                    <p>Orders Recieved</p>
                                </div>
                                <div class="tile">
                                    <h1>'.sprintf("%02d",$data['pending_count']).'</h1>
                                    <p>Pending Orders</p>
                                </div>
                                <div class="tile">
                                    <h1>'.sprintf("%02d",$data['canceled_count']).'</h1>
                                    <p>Canceled Orders</p>
                                </div>
                            </div>
                            <div class="topic"><h3>Product Sale</h3></div>
                            <div class="chart">';
                                $chart = $data['chart'];
                                if(count($chart['labels']) > 0){
                                    $chart = new Chart('bar',$chart,1);
                                }else{
                                    echo "<img src = ".BASEURL."/public/img/placeholders/2.png>";
                                }
                        echo    '</div>
                        </div>
                        <table class="styled-table">
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Current Stock</th>
                                </tr>
                            </thead>
                            <tbody>';
                                
                                    if(isset($data["stock"])){
                                        $result = $data["stock"];
                                        $stock = "";
                                        while($row = mysqli_fetch_assoc($result)){
                                            $name = $row["name"];
                                            $qty = $row["quantity"];
                                            $stock .=   '<tr>
                                                            <td>'.$name.'</td>
                                                            <td>'.$qty.'</td>
                                                        </tr>';
                                        
                                        }
                                        echo $stock;

                                    }
                                
                            echo '</tbody>
                        </table>
                    </div>
                    <div class="body-right">
                        <div class="accordion new">
                            <h3>New Orders</h3>';
                            
                                if(isset($data["pending"]) && !empty($data["pending"])){
                                    $results = $data["pending"];
                                    foreach($results as $result){
                                        $newpending = new NewOrder('pending',$result);
                                    }
                                }else{
                                    echo "<img src = ".BASEURL."/public/img/placeholders/1.png>";
                                }
                                
                            
                        echo '</div>
                        <div class="accordion dispatched">
                            <h3>Dispatched Orders</h3>';
                            if(isset($data["dispatched"]) && !empty($data["dispatched"])){
                                $results = $data["dispatched"];
                                foreach($results as $result){
                                    $newpending = new NewOrder('dispatched',$result);
                                }
                            }else{
                                echo "<img src = ".BASEURL."/public/img/placeholders/1.png>";
                            }
                    echo    '</div>
                        <script>
                            let accordion = document.querySelectorAll(".accordion .box");
                            for(i=0; i<accordion.length; i++) {
                                accordion[i].addEventListener("click", function(){
                                    this.classList.toggle("active")
                                })
                            }
                        </script>
                    </div>
                </section>';
            // js
            // echo '<script>
            //         let accordion = document.querySelectorAll(".accordion .box");
            //         for(i=0; i<accordion.length; i++) {
            //             accordion[i].addEventListener("click", function(){
            //                 this.classList.toggle("active")
            //             })
            //         }
            //     </script>';
    }
    public function dealerstock($data){
        $stockheader = '<ul>';
        if($data['tab'] == "currentstock"){
            $stockheader .= '<li><a href="'.BASEURL.'/stock/dealer/currentstock" class="current active" onclick="stockclicked(); return false;">Current Stock</a></li>';
        }else{
            $stockheader .= '<li><a href="'.BASEURL.'/stock/dealer/currentstock" class="current" onclick="stockclicked(); return false;">Current Stock</a></li>';
        }
        if($data['tab'] == "purchaseorder"){
            $stockheader .= '<li><a href="'.BASEURL.'/stock/dealer/purchaseorder" class="current active" onclick="purchaseclicked(); return false;">Purchase Order</a></li>';
        }else{
            $stockheader .= '<li><a href="'.BASEURL.'/stock/dealer/purchaseorder" class="current" onclick="purchaseclicked(); return false;">Purchase Order</a></li>';
        }
        if($data['tab'] == "pohistory"){
            $stockheader .= '<li><a href="'.BASEURL.'/stock/dealer/pohistory" class="current active" onclick="historyclicked(); return false;">Order History</a></li>';
        }else{
            $stockheader .= '<li><a href="'.BASEURL.'/stock/dealer/pohistory" class="current" onclick="historyclicked(); return false;">Order History</a></li>';
        }
        $stockheader .= '</ul>';
        echo '<section class="body-content">';
        echo "<form action='' class='filters' method='post'>";
        $search = new Search(($data['tab'] == "currentstock" || $data['tab'] == "currentstock") ? [1] : [1,2,3]);
        echo "</form>";
        echo '<div class="top-panel">
            '.$stockheader.'
        </div>
        <div class="content-data">';
        $stock = new StockHTML('dealer'.$data['tab'],$data);
        echo '</div></section>';
    }

    //customer dashboard
    function customerdashboard($data){
        echo '<div class="under_topbar">
        <div class="top_image">
            <div class="image">
                <img src="../img/customer_dashboard/dashboardimg.jpg" alt="">
            </div>
            <div class="text">
                <div class="logo">
                    <svg width="50" height="80" viewBox="0 0 57 82" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                        <rect width="57" height="81.7527" fill="url(#pattern0)"/>
                        <defs>
                        <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
                        <use xlink:href="#image0_188_675" transform="translate(0 -0.0615054) scale(0.00763359 0.00532233)"/>
                        </pattern>
                        <image id="image0_188_675" width="131" height="211" xlink:href="data:image/png;base64,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"/>
                        </defs>
                    </svg>
                    <h1><strong>Gasify</strong></h1>     
                </div>
                <div class="any_brand"><h3><strong>ANY BRAND,ANY PLACE,ANY TIME</strong></h3></div>
                <div class="pay"><h1><strong>NOW PAY & RESERVE</strong></h1></div>
                <div class="para"> <p>Your gas cylinder in smart way......</p></div>
                <div class="btn"><button><a href="'.BASEURL.'/Orders/select_brand_city_dealer""><svg width="50" height="30" viewBox="0 0 36 27" fill="black" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.91898 0.00888084C1.32213 0.101743 0.787668 0.421359 0.433159 0.897418C0.0786496 1.37348 -0.0668626 1.96698 0.0286329 2.54737C0.124128 3.12775 0.452809 3.64748 0.942369 3.99221C1.43193 4.33695 2.04227 4.47844 2.63911 4.38558H9.39036L9.79543 5.47976L11.6408 10.9506L13.4861 16.4215C13.6661 16.9905 14.4313 17.5157 15.0164 17.5157H30.7693C31.3994 17.5157 32.1195 16.9905 32.2996 16.4215L35.9452 5.47976C36.1253 4.91079 35.8552 4.38558 35.2251 4.38558H15.2414L13.5311 1.23436C13.349 0.872664 13.0677 0.566869 12.7183 0.350647C12.3688 0.134424 11.9649 0.0161615 11.5508 0.00888084L2.5491 0.00888084C2.41435 -0.00296028 2.27877 -0.00296028 2.14402 0.00888084C2.05409 0.00362406 1.96391 0.00362406 1.87397 0.00888084L1.91898 0.00888084ZM16.1416 21.8924C14.8814 21.8924 13.8912 22.8553 13.8912 24.0807C13.8912 25.3062 14.8814 26.2691 16.1416 26.2691C17.4018 26.2691 18.392 25.3062 18.392 24.0807C18.392 22.8553 17.4018 21.8924 16.1416 21.8924ZM29.6441 21.8924C28.3839 21.8924 27.3937 22.8553 27.3937 24.0807C27.3937 25.3062 28.3839 26.2691 29.6441 26.2691C30.9043 26.2691 31.8945 25.3062 31.8945 24.0807C31.8945 22.8553 30.9043 21.8924 29.6441 21.8924Z" fill=""/>
                    </svg>Place Reservation</a></button>
                </div>
            
            </div></div>';

            echo '<div class="middle">
                <div class="brand">
                <div class="brand_title"> <h3>Our Brands</h3></div>
                <div class="brand_img">';

            if(isset($data["brand"])){
                $result = $data["brand"];
                $brand = "";
                while($row = mysqli_fetch_assoc($result)){
                    $company_name = $row["name"];
                    $logo = $row["logo"];
                    $image = BASEURL.'/public/img/profile/'.$logo;
                    $brand .=   '<a href ="'.BASEURL.'/Products/view_company_products/'.$row["company_id"].'"><div >
                                <img src="'.$image.'" alt="" class="litro">
                                <h3>'.$company_name.'</h3>
                                </div></a>'; 
                
                }
                echo $brand.' </div>
                </div>';
               
            }

            echo '<div class="recent_order">';

            if(isset($data['orders'])){
                echo '  <div class="order_title"> <h3>Recent Orders</h3></div>';

                $orders = $data['orders'];
                if(count($orders) > 0){
                    foreach($orders as $order){
                    $row1 = $order['order'];
                        $products = $order['products'];
                        echo '  <div class="dropdown">
                        <div class="label">
                            <div><span><strong>Order ID:</strong></span><span>'.$row1['order_id'].'</span></div>
                            <div class="icon"><svg class="img" width="20" height="10" viewBox="0 0 35 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17.7514 15.8985C17.1825 15.8993 16.6312 15.7201 16.1932 15.3918L1.58692 4.38418C1.08977 4.01049 0.777187 3.47366 0.717923 2.89179C0.65866 2.30991 0.857574 1.73066 1.27091 1.28145C1.68424 0.832243 2.27813 0.54988 2.92193 0.496478C3.56574 0.443076 4.20671 0.623009 4.70385 0.996694L17.7522 10.8596L30.8036 1.35865C31.0527 1.17596 31.3392 1.03958 31.6468 0.957326C31.9545 0.875077 32.277 0.848587 32.596 0.87938C32.915 0.910173 33.2242 0.99764 33.5057 1.13676C33.7872 1.27587 34.0356 1.46389 34.2364 1.69001C34.4594 1.91635 34.6282 2.18184 34.7323 2.46986C34.8365 2.75788 34.8737 3.06221 34.8416 3.3638C34.8096 3.66538 34.709 3.95772 34.5461 4.2225C34.3832 4.48727 34.1616 4.71878 33.8951 4.90251L19.2853 15.525C18.8346 15.8011 18.2945 15.9326 17.7514 15.8985Z" fill="#F9896B"/>
                                </svg>
                            </div>
                        </div>
                        <div class="content">
                            <span><strong>Placed Date:</strong></span><span> '.$row1['place_date'].'</span><br>
                            <span><strong>Status:</strong></span><span> '.$row1['order_state'].'</span><br>';
                        echo '<span><strong>Total Amount:</strong></span><span> Rs.'.number_format($order['total_amount']).'.00</span>
                        <table>
                        <tr><th>Brand</th><th>Item</th> <th>Quantity</th></tr>';
                        foreach($products as $product){
                            echo '<tr><td>'.$product['company_name'].'</td><td>'.$product['product_name'].'</td><td>'.$product['quantity'].'</td></tr>';


                        }
                        echo '</table></div></div>';
                    }
                
                }else{
                    echo '<div class="dropdown"><center><img src="../img/placeholders/1.png" alt=""></center></div>';
                }
        

            }
            echo '</div>
                </div>';


            echo '<div class="bottom">
            <div class="product_title"><h3>Popular Products</h3></div>
            <div class="cards">';

            if(isset($data['popular_products'])){
                $popular_products = $data['popular_products'];

                foreach($popular_products as $popular_product){
                    echo '<div class="product_card">
                             <div class="product_img"><img src="'.BASEURL.'/public/img/products/'.$popular_product['image'].'" alt=""></div>
                             <div class="product_details">
                                <div class="brand_name">'.$popular_product['c_name'].'</div>
                                <div class="name"><h5>'.$popular_product['weight'].'Kg '.$popular_product['p_name'].'</h5></div>
                                <div class = price_count>
                                    <div class="price"><h4>Rs.'.number_format($popular_product['unit_price']).'.00</h4></div>
                                    <div class="p_count"><h4>Units Sold : '.$popular_product['p_count'].'</h4></div>
                                </div>
                            </div>
                        </div>';
                }
            }

            // echo '</div> 
            // </div>'; 
    }

  /*
  
    function distributordashboard($data){
        echo '<section class="body-content dashboard">
                    <div class="body-left">

                        <div class="variable">
                            <div class="topic">
                                <h3>Analytic Overview</h3>
                                <!-- drop down component -->
                                <form action="'.BASEURL.'/dashboard/distributor" method="POST">
                                    <select id="period" name="option" onchange="this.form.submit()" class="dropdowndate">';
                                        if($data['option'] == 'today') {
                                            echo '<option value="today" selected>To day</option>
                                            <option  value="30day">Last 30 days</option>';
                                        }else{
                                            echo '<option value="today" >To day</option>
                                            <option  value="30day" selected>Last 30 days</option>';
                                        }

                                    echo'
                                    </select>
                                </form>
                            </div>

                            <div class="box1">
                               <div class="box2">
                                    <h1>'.sprintf("%02d", $data['pending_count']).'</h1>
                                    <p>Pending Distributions</p>
                                </div>

                               <div class="box2">
                                    <h1>'.sprintf("%02d", $data['total_received']).'</h1>
                                    <p>Received Orders</p>
                                </div>
                            </div>';    
                                    
                            echo '
                            <div class="chart">';
                            $chart = $data['chart'];
                            if(count($chart['labels']) > 0){
                                $chart = new Chart('bar',$chart,1);
                            }else{
                                echo "<img src = ".BASEURL."/public/img/placeholders/2.png class='chartimg'>";
                            }
                            echo  '</div>

                        </div>
                    </div>';   
              
                    echo '
                    <div class="body-right">
                        <div class="accordion new">
                                <h3>New Purchase Orders</h3>';

                                $pendingorders = $data['pending_distributions'];
                                foreach($pendingorders as $pendingorder) {
                                    $row2 = $pendingorder['pendinginfo'];
                                    $capacities = $pendingorder['capacities'];

                                    $output1 = '
                                    <div class="box">';
                                        $order_id = $row2['po_id'];
                                        $output1 .= '
                                            <div class="label">Phurchase Order ID : '.$order_id.'
                                                <svg class="img" width="30" height="16" viewBox="0 0 35 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M17.7514 15.8985C17.1825 15.8993 16.6312 15.7201 16.1932 15.3918L1.58692 4.38418C1.08977 4.01049 0.777187 3.47366 0.717923 2.89179C0.65866 2.30991 0.857574 1.73066 1.27091 1.28145C1.68424 0.832243 2.27813 0.54988 2.92193 0.496478C3.56574 0.443076 4.20671 0.623009 4.70385 0.996694L17.7522 10.8596L30.8036 1.35865C31.0527 1.17596 31.3392 1.03958 31.6468 0.957326C31.9545 0.875077 32.277 0.848587 32.596 0.87938C32.915 0.910173 33.2242 0.99764 33.5057 1.13676C33.7872 1.27587 34.0356 1.46389 34.2364 1.69001C34.4594 1.91635 34.6282 2.18184 34.7323 2.46986C34.8365 2.75788 34.8737 3.06221 34.8416 3.3638C34.8096 3.66538 34.709 3.95772 34.5461 4.2225C34.3832 4.48727 34.1616 4.71878 33.8951 4.90251L19.2853 15.525C18.8346 15.8011 18.2945 15.9326 17.7514 15.8985Z" fill="#9c6109"/>
                                                </svg>
                                            </div>';

                                        $date = $row2['place_date'];
                                        $dealer_id = $row2['dealer_id'];

                                        $output1 .= '
                                        <div class="content">
                                            <span><strong>Dealer ID : </strong> '.$dealer_id.'</span>&nbsp<br>
                                            <span><strong>Placed Date : </strong> '.$date.'</span>
                                            <hr>
                                            <table class="styled-table">
                                                <thread>
                                                    <tr>
                                                        <th>Item ID</th>
                                                        <th>Quantity</th>
                                                    </tr>
                                                </thread>

                                                <tbody>';
                                                foreach($capacities as $capacity) {
                                                    $row3 = $capacity;
                                                    $output1 .= '
                                                        <tr>
                                                            <td>'.$row3['product_id'].'</td>
                                                            <td>'.$row3['quantity'].'</td>
                                                        </tr>';  
                                                }
                                                $output1 .= '
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>';
                                    echo $output1;  
                                }
                            echo '
                            </div>';
                            $output = '
                            <div class="box3">
                                <h3>Current Stock</h3>
    
                                    <div class="content1">
                                        <table class="styled-table">
                                            <thead>
                                                <tr>
                                                    <th>Product Name</th>
                                                    <th>Current Stock</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                                            
                                            if(isset($data["current_stock"])) {
                                        
                                                $result = $data['current_stock'];
                                                // echo count($result);

                                                $stock = "";
                                                // echo count($stock);
                                                while($row = mysqli_fetch_assoc($result)) {
                                                    // echo count($row);
                                                    
                                                    $name = $row["name"];
                                                    $qty = $row['quantity'];
                                                    $stock .= 
                                                    '<tr>
                                                        <td>'.$name.'</td>
                                                        <td>'.$qty.'</td>
                                                    </tr>';
                                                    
                                                }
                                                echo $stock;
                                            }
                                            echo '
                                            </tbody>
                                        </table>
                                    </div>
                            </div>';        
                    echo '</div>';
        echo '</section>';                         
    }

    */

    
    function distributordashboard($data){
        echo '<section class="body-content dashboard">
                    <div class="body-left">

                        <div class="variable">
                            <div class="topic">
                                <h3>Analytic Overview</h3>
                                <!-- drop down component -->
                                <form action="'.BASEURL.'/dashboard/distributor" method="POST">
                                    <select id="period" name="option" onchange="this.form.submit()" class="dropdowndate">';
                                        if($data['option'] == 'today') {
                                            echo '<option value="today" selected>To day</option>
                                            <option  value="30day">Last 30 days</option>';
                                        }else{
                                            echo '<option value="today" >To day</option>
                                            <option  value="30day" selected>Last 30 days</option>';
                                        }

                                    echo'
                                    </select>
                                </form>
                            </div>

                            <div class="box1">
                               <div class="box2">';
                                    $pendingcount = $data['count_pending_distributions'];
                                    echo '
                                        <p class="p1"><b>'.$pendingcount.'</b></p>
                                        <p>pending distributions</p>
                                </div>';

                                echo '
                                <div class="box2">';
                                    $receivedCount = $data['count_received_gasorders'];
                                    echo '
                                        <p class="p1"><b>'.$receivedCount.'</b></p>
                                        <p>received orders</p>
                                </div>
                            </div>';
                                    
                            echo '
                            <div class="chart">';
                            $chart = $data['chart'];
                            if(count($chart['labels']) > 0){
                                $chart = new Chart('bar',$chart,1);
                            }else{
                                echo "<img src = ".BASEURL."/public/img/placeholders/2.png class='chartimg'>";
                            }
                            echo  '</div>

                        </div>
                    </div>';   
              
                    echo '
                    <div class="body-right">
                        <div class="accordion new">
                                <h3>New Pending Orders</h3>';

                                $pendingorders = $data['pending_distributions'];
                                foreach($pendingorders as $pendingorder) {
                                    $row2 = $pendingorder['pendinginfo'];
                                    $capacities = $pendingorder['capacities'];

                                    $output1 = '
                                    <div class="box">';
                                        $order_id = $row2['po_id'];
                                        $output1 .= '
                                            <div class="label">Pending Order ID : '.$order_id.'
                                                <svg class="img" width="30" height="16" viewBox="0 0 35 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M17.7514 15.8985C17.1825 15.8993 16.6312 15.7201 16.1932 15.3918L1.58692 4.38418C1.08977 4.01049 0.777187 3.47366 0.717923 2.89179C0.65866 2.30991 0.857574 1.73066 1.27091 1.28145C1.68424 0.832243 2.27813 0.54988 2.92193 0.496478C3.56574 0.443076 4.20671 0.623009 4.70385 0.996694L17.7522 10.8596L30.8036 1.35865C31.0527 1.17596 31.3392 1.03958 31.6468 0.957326C31.9545 0.875077 32.277 0.848587 32.596 0.87938C32.915 0.910173 33.2242 0.99764 33.5057 1.13676C33.7872 1.27587 34.0356 1.46389 34.2364 1.69001C34.4594 1.91635 34.6282 2.18184 34.7323 2.46986C34.8365 2.75788 34.8737 3.06221 34.8416 3.3638C34.8096 3.66538 34.709 3.95772 34.5461 4.2225C34.3832 4.48727 34.1616 4.71878 33.8951 4.90251L19.2853 15.525C18.8346 15.8011 18.2945 15.9326 17.7514 15.8985Z" fill="#9c6109"/>
                                                </svg>
                                            </div>';

                                        $date = $row2['place_date'];
                                        $dealer_id = $row2['dealer_id'];

                                        $output1 .= '
                                        <div class="content">
                                            <span><strong>Dealer ID : </strong> '.$dealer_id.'</span>&nbsp<br>
                                            <span><strong>Placed Date : </strong> '.$date.'</span>
                                            <hr>
                                            <table class="styled-table">
                                                <thread>
                                                    <tr>
                                                        <th>Item ID</th>
                                                        <th>Quantity</th>
                                                        <th>Subtotal (Rs.)</th>
                                                    </tr>
                                                </thread>

                                                <tbody>';
                                                
                                                $total =0;
                                                foreach($capacities as $capacity) {
                                                    $row3 = $capacity;
                                                    $unit_price = $row3['unit_price'];
                                                    $quantity = $row3['quantity'];
                                                    $subtotal = $unit_price * $quantity;

                                                    $output1 .= '
                                                        <tr>
                                                            <td>'.$row3['product_id'].'</td>
                                                            <td>'.$row3['quantity'].'</td>
                                                            <td>'.number_format($subtotal,2).'</td>
                                                        </tr>'; 
                                                        $total += $subtotal;           
                                                }
                                                $output1 .= '
                                                <tr>
                                                    <td><b>Total Amount (Rs.)</b></td>
                                                    <td></td>
                                                    <td><b>'.number_format($total,2).'</b></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>';
                                    echo $output1;  
                                }
                            echo '
                            </div>';
                            $output = '
                            <div class="box3">
                                <h3>Current Stock</h3>
    
                                    <div class="content1">
                                        <table class="styled-table">
                                        <thead>
                                            <tr>
                                                <th>Product Name</th>
                                                <th>Current Stock</th>
                                            </tr>
                                        </thead>
                                        <tbody>';     
                                    
                                    $stocks = $data['currentstock'];
                                    foreach($stocks as $stock) {
                                        $row1 = $stock['stockinfo'];
    
                                        $output .= '
                                        <tr>
                                            <td>'.$row1['name'].'</td>
                                            <td>'.$row1['quantity'].'</td> 
                                        </tr>';
                                    }
                                        $output .= '</tbody></table>
                                    </div>
                                </div>';
                                        echo $output;
                    echo '</div>';
        echo '</section>';                         
    }
    





    function admindashboard($data){
        echo '<section class="body-content">
        <div class="tiles one">
            <div class="tile">
                <h1>'.$data['customers_count'].'</h1>
                <p>Customers</p>
            </div>
            <div class="tile">
                <h1>'.$data['dealers_count'].'</h1>
                <p>Dealers</p>
            </div>
            <div class="tile">
                <h1>'.$data['delivery_count'].'</h1>
                <p>Delivery People</p>
            </div>
            <div class="tile">
                <h1>'.$data['distributors_count'].'</h1>
                <p>Distributors</p>
            </div>
            <div class="tile">
                <h1>'.$data['company_count'].'</h1>
                <p>Companies</p>
            </div>
        </div>
        <div class="graph">
            <div class="variable">
                <div class="topic">
                    <h2>Analytic Overview</h2>
                    <!-- drop down component -->
                    <form action="'.BASEURL.'/dashboard/admin" method="post">
                        <label>Company</label>
                        <select id="period" onchange="this.form.submit()" class="dropdowndate" name="option2">';
                        $companies = $data['companies'];
                        if($data['option2'] == 'all'){
                            echo "<option value='all' selected>All</option>";
                        }else{
                            echo "<option value='all' >All</option>";
                        }
                        while($row = mysqli_fetch_assoc($companies)){
                            if($data['option2'] == $row['company_id']){
                                echo "<option value='".$row['company_id']."' selected>".$row['name']."</option>";
                            }else{
                                echo "<option value='".$row['company_id']."' >".$row['name']."</option>";
                            }
                        }
                        echo '</select>
                        <select id="period" onchange="this.form.submit()" class="dropdowndate" name="option1">';
                            if($data['option1'] == 'today'){
                                echo '<option value="today" selected>To day</option>
                                <option  value="30day">Last 30 days</option>';
                            }else{
                                echo '<option value="today">To day</option>
                                <option  value="30day" selected>Last 30 days</option>';
                            }
                        echo '</select>
                    </form>
                </div>
                <div class="chart">';
                $chart = $data['chart'];
                // var_dump($chart);
                if(count($chart['labels']) > 0){
                    $chart = new Chart('bar',$chart,1);
                }else{
                    echo "<img src = ".BASEURL."/public/img/placeholders/2.png>";
                }
                echo '</div>
            </div>
            <div class="reviews">
                <h2>Recent Reviews</h2>
                <div class="contents">';
                    $reviews = $data['reviews'];
                    while($review = mysqli_fetch_assoc($reviews)){
                        echo '<div class="review">
                        <img src="'.BASEURL.'/img/profile/'.$review['image'].'" alt="">
                        <div class="review-info">
                            <div class="name-time">
                                <h3>'.$review['customer_name'].'</h3>
                                <span>'.date('F j, Y, g:i A', strtotime($review['date'].' '.$review['time'])).'</span>
                            </div>
                            <p>'.$review['message'].'</p>';
                            if($review['review_type'] == 'Dealer'){
                                echo '<p><strong>Dealer : </strong><a href="'.BASEURL.'/profile/preview/dealer/'.$review['dealer_id'].'/profile/admin/dealerprofile" style="color: #1672fc"><strong>'.$review['dealer_name'].'</strong></a></p>';
                            }else{
                                echo '<p><strong>Delivery : </strong><a href="'.BASEURL.'/profile/preview/delivery/'.$review['delivery_id'].'/profile/admin/deliveryprofile" style="color: #1672fc"><strong>'.$review['delivery_name'].'</strong></a></p>';
                            }
                        echo '</div>
                    </div>';
                    }
                echo '</div>
            </div>
        </div>
    </section>';
    }
    function companydashboard($data){
        echo 
        '<section class="body-content">';
        $prod=$data['products'];
        $reqCount=$data['reqCount'];
        $distCount=$data['distCount'];
        $dealerCount=$data['dealerCount'];
        foreach($prod as $row){
            $prod=$row['count'];
        }
        foreach($reqCount as $row){
            $reqCount=$row['count'];
        }
        foreach($distCount as $row){
            $distCount=$row['count'];
        }
        foreach($dealerCount as $row){
            $dealerCount=$row['count'];
        }
        
            echo'<div class="Top" id="Top">
                <div class="card">
                    <div class="cmValue">'.$reqCount.'</div>
                    <div class="cmTitle">Pending Requests</div>
                </div>
                <div class="card">
                    <div class="cmValue">'.$prod.'</div>
                    <div class="cmTitle">Products</div>
                </div>
                <div class="card">
                    <div class="cmValue">'.$distCount.'</div>
                    <div class="cmTitle">Distributors</div>
                </div>
                <div class="card">
                    <div class="cmValue">'.$dealerCount.'</div>
                    <div class="cmTitle">Dealers</div>
                </div>
            </div>';
            echo'
            <div class="tabletitles">
            <div class="productTableTitle" style="font-size:1.17em">Products (low stock)</div>
            <div class="recentRequestTableTitle" style="font-size:1.17em">Recent Orders</div>
            </div>
            <div class="tables">
                    <div class="productTable">';
                    if(isset($data['lowStock']) && count($data['lowStock'])>0){
                        echo'<table class="styled-table" style="width:45%">
                            <thead>
                                <tr>
                                    <th class="tdLeft">Product name</th>
                                    <th class="tdRight">Quantity</th>
                                </tr>
                            </thead>
                            <tbody style="overflow-y:auto;height:100px" >';
                            $tag="";
                            //print_r($data['lowStock']);
                            foreach($data['lowStock'] as $row){
                                $tag.=' <tr>
                                    <td class="tdLeft">'.$row['name'].'</td>
                                    <td class="tdRight">'.$row['quantity'].'</td>
                                </tr>';
                                    
                            }
                            echo $tag;              
                            echo '</tbody>      
                        </table>';
                    }else{
                        echo'<img src="../img/placeholders/2.png" alt="">';
                    }
            echo'</div>';
            if (isset($data['order_details'])){
                echo'<div class="recentRequestTable" style="overflow-y: auto; align-items: center;align-content: center;">';
                    echo'<table class="styled-table" style="margin-left:5%">
                    <thead>
                        <tr>
                            <th style="z-index:2">Distributor name</th>
                            <th style="z-index:2" class="tdCenter">Products</th>
                        </tr>
                    </thead>
                    <tbody style="overflow-y:auto;height:100px">';
                    $result = $data["order_details"];
                    $product_array=$data['product_details'];
                    $orders='';
                    $processedOrders=array();
                    $orderID='';
                    $distName='';
                    $placedDate='';
                    $placedTime='';
                    $orderArray=array();
                    foreach ($result as $row){
                        
                        
                        foreach($result as $row2){
                            $orderID=$row['stock_req_id'];
                            $distName=$row['first_name'].' '.$row['last_name'];
                            if(!in_array($orderID,$processedOrders)){
                                $info=array();
                                foreach($result as $row3){
                                    if($row3['stock_req_id']==$orderID){
                                        $info+=array($row3['product_id']=>$row3['quantity']);
                                        //array_push($info,[$row2['product_id']=>$row2['quantity']]);
                                    }
                                }
                                array_push($orderArray,[$distName=>$info]);
                                array_push($processedOrders,$orderID);
                            }
                        }
                        
                    }
                    $orders='';
                    foreach($orderArray as $key=>$value ){
                        foreach($value as $key_2=>$value_2){
                            $orders.='<tr>
                                    <td class="tdCenter">'.$key_2.'</td>
                                    <td class="tdCenter">
                                        <table class="requestProducts" style="margin-top:1%;width:100%">
                                            <thead>
                                                <tr>
                                                    <th style="z-index:1">Product ID </th>
                                                    <th style="z-index:1">Quantity</th>
                                                </tr>
                                            </thead>
                                        <tbody style="overflow-y:auto;height:100px">';
                            foreach($value_2 as $key_3=>$value_3){
                                $orders.='<tr>
                                            <td class="tdCenter">'.$key_3.'</td>
                                            <td class="tdRight">'.$value_3.'</td>
                                        </tr>';
                                }
                            }
                            $orders.='</tbody></table></td></tr>';
                    }
                    echo $orders;
                    echo'</div>';
                    echo '</div></section>';
                }else{
                    echo'<div class="recentRequestTable" style="height: 50%;" >';
                    echo'<img src="../img/placeholders/2.png" >';
                    echo'</div>';
                    echo '</div></section>';
                }
    
    }
    function companyDealers($data){
        echo 
        '
        <script>
            function dealerSignup(){
                location.href = \'http://localhost/mvc/signup/dealer\';
            }
        </script>
        
        <section class="body-content">
            <div class="Distributor_table_name" id="Distributor_table_name" style="margin:0;margin-left:-1.5%">
            <a href="../Compny/dealer" style="width:97%" ><div class="DealerTableTopics" onClick="loadDistributorTableTopics()" style="width:100%;height:100%;background-color:#d8ca30;color:white">Registered Dealers</div></a>
            </div>
            <div style="width:97%;height:10%;display:flex;align-items:center;align-content:center;border-left-style:solid;border-right-style:solid;box-sizing:border-box;border-color:var(--navmenu-orange-dark);">
                <div class="dealerAddButton" onClick="dealerSignup()">
                    <div style="color:white;width:40%;display:flex;align-items:center;align-content:center;justify-content:center;font-size:2em">+</div> 
                    <div style="color:white;font-size:1.5em">Add</div>   
                </div>
            
            </div>';
            
            if (isset($data["dealer"])) {
                echo '<div class="DealerTables" id="DealerTables" style="margin:0">
                <table class="styled-table">
                        <thead >
                        <tr>
                            <th>Name</th>
                            <th>Location</th>
                            <th>Contact no</th>
                            <th>Bank account</th>
                            <th>Bank</th>
                        </tr>
                        </thead>
                        <tbody style="overflow-y:auto;height:100px">';
                            $result = $data["dealer"];
                            $dealer = "";
                            foreach ($result as $row) {
                                $dealer .=  '<tr>
                                <td>'.$row['name']. '</td>
                                <td>'.$row['city'].'</td>
                                <td>'.$row['contact_no'].'</td>
                                <td>'.$row['account_no'].'</td>
                                <td>'.$row['bank'].'</td>
                                </tr>';
                            }
                                echo $dealer;
                                echo '</tbody>      
                            </table>';
            }else{
                echo '<div class="DealerTables" id="DealerTables" style="margin:0;display:flex;justify-content:center">';
                echo'<img src="../img/placeholders/2.png" style="width: 40%;height: 70%;">';
            }       
    }
    function companyDistributors($data){
        echo '
            <script>
                function dealerSignup(){
                    location.href = \'http://localhost/mvc/signup/distributor\';
                }
            </script>
        <section class="body-content">
            <div class="Distributor_table_name" id="Distributor_table_name" style="margin:0;margin-left:-1.5%">
                <a href="../Compny/distributor" style="width:97%" ><div class="DealerTableTopics" onClick="loadDistributorTableTopics()"style="width:100%;height:100%;background-color:#d8ca30;color:white">Registered Distributors</div></a>
            </div>
            <div style="width:97%;height:10%;display:flex;align-items:center;align-content:center;border-left-style:solid;border-right-style:solid;box-sizing:border-box;border-color:var(--navmenu-orange-dark);">
                <div class="dealerAddButton" onClick="dealerSignup()">
                    <div style="color:white;width:40%;display:flex;align-items:center;align-content:center;justify-content:center;font-size:2em">+</div> 
                    <div style="color:white;font-size:1.5em">Add</div>   
                </div>
            
            </div>';
            if (isset($data["distributor"])) {
            echo'<div class="DealerTables" id="DealerTables" style="margin:0">';
                echo '<table class="styled-table">
                <thead style="background-color:#dbb1f9">
                    <tr>
                        <th>Name</th>
                        <th>City</th>
                        <th>Street</th>
                        <th>Contact no</th>
                        <th>Hold time</th>
                    </tr>
                </thead>
                <tbody style="overflow-y:auto;height:100px">';
                        $result = $data["distributor"];
                        $distributor = "";
                        foreach ($result as $row) {
                            $distributor .=  '<tr>
                                            <td>'.$row['name']. '</td>
                                            <td>'.$row['city'].'</td>
                                            <td>'.$row['street'].'</td>
                                            <td>'.$row['contact_no'].'</td>
                                            <td>'.$row['hold_time'].'</td>
                                        </tr>';
                        }
                        echo $distributor;       
                echo '</tbody>      
            </table>';
        }else{
            echo '<div class="DealerTables" id="DealerTables" style="margin:0;display:flex;justify-content:center">';
            echo'<img src="../img/placeholders/2.png" style="width: 40%;height: 70%;">';
        }
            
            
            
            
            
            
            
            
            /*if(isset($data["distributor"])){
                $result = $data["distributor"];
                $distributor = "";
                foreach($result as $row){
                    //print_r($data) ;
                    $distributor .=   '<div class="dealer_tableHead_row" id="dealer_tableHead_row" style="background-color: #d8ca30;height:10%">
                                    <div class="dealer_name" id="col" style="margin-top:1%">Sample</div>
                                    <div class="dealer_location" id="col" style="margin-top:1%">'.$row['city'].'</div>
                                    <div class="dealer_contactno" id="col" style="margin-top:1%">'.$row['street'].'</div>
                                    <div class="dealer_accountno" id="col" style="margin-top:1%">'.$row['contact_no'].'</div>
                                    <div class="dealer_capacity" id="col" style="margin-top:1%">'.$row['hold_time'].'</div>
                                    </div>';             
                }
                echo $distributor;
            }*/
            echo '</div>
        </section>';
    }
    function companyProducts($data){
        echo 
        '<section class="body-content">
             <div class="Distributor_table_name" id="Distributor_table_name" style="margin:0;margin-left:-1.3%">
                 <a href="../Compny/products" style="width:32.33%" ><div class="ProductTableTopics"onClick="location.href = "../Compny/dealer" style="background-color:#d8ca30;color:white">Current Products</div></a>
                 <a href="../Compny/regproducts" style="width:32.33%" ><div class="ProductTableTopics" onClick="loadProductRegistrationForm()" style="background-color:#fff">Register New Product</div></a>
                 <a href="../Compny/updateProducts" style="width:32.33%" ><div class="ProductTableTopics" onClick="loadProductUpdateForm()" style="background-color:#fff">Update Product</div></a>
             </div>';
             if (isset($data["products"])) {
             echo'<div class="DealerTables" id="DealerTables" style="margin:0;width: 97.4%;height:80%"">';
                echo '<table class="styled-table" style="margin-top:0.3%">
                        <thead>
                            <tr>
                                <th class="tdLeft">Product</th>
                                <th class="tdLeft">Name</th>
                                <th class="tdLeft">Type</th>
                                <th class="tdRight">Unit Price (Rs)</th>
                                <th class="tdRight">Weight (KG)</th>
                                <th class="tdRight">Production Time</th>
                                <th class="tdRight">Last Updated</th>
                                <th class="tdRight">Quantity</th>
                            </tr>
                        </thead>
                        <tbody style="overflow-y:auto;height:100px">';
                            if (isset($data["products"])) {
                                $result = $data["products"];
                                $products = "";
                                foreach ($result as $row) {
                                    $products .=  '<tr>
                                                    <td class="tdLeft"><img class="littleproduct" src="http://localhost/mvc/public/img/products/'.$row['image'].'"></td>
                                                    <td class="tdLeft">'.$row['name'].'</td>
                                                    <td class="tdLeft">'.$row['type'].'</td>
                                                    <td class="tdRight">'.number_format($row['unit_price'],2).'</td>
                                                    <td class="tdRight">'.$row['weight'].'</td>
                                                    <td class="tdRight">'.$row['production_time']. '</td>
                                                    <td class="tdRight">'.$row['last_updated_date'].'</td>
                                                    <td class="tdRight">'.$row['quantity'].'</td>
                                                </tr>';
                                }
                                echo $products;
                            }       
                                                echo '</tbody>      
                                            </table>';   
                                    echo '</div>
                                </section>';
            }else{
                echo '<div class="DealerTables" id="DealerTables" style="margin:0;display:flex;justify-content:center">';
                echo'<img src="../img/placeholders/2.png" style="width: 40%;height: 70%;">';
                echo '</div></section>';
            }
    }
    function companyRegProducts($data){
        echo 
        '<section class="body-content">
            <div class="Distributor_table_name" id="Distributor_table_name"  style="margin:0;margin-left:-1.3%">
                 <a href="../Compny/products" style="width:32.33%" ><div class="ProductTableTopics"onClick="location.href = "../Compny/dealer" style="background-color:#fff">Current Products</div></a>
                 <a href="../Compny/regproducts" style="width:32.33%" ><div class="ProductTableTopics" onClick="loadProductRegistrationForm()" style="background-color:#d8ca30;color:white">Register New Product</div></a>
                 <a href="../Compny/updateProducts" style="width:32.33%" ><div class="ProductTableTopics" onClick="loadProductUpdateForm()" style="background-color:#fff">Update Product</div></a>
             </div>
            <div class="DealerTables" id="DealerTables" style="display:flex;margin:0;width: 97.4%;height:80%"">
                <div class="left">
                    <form action="'. BASEURL.'/Compny/registerProducts" enctype="multipart/form-data" method="POST" id="productRegistrationForm" class="productRegistrationForm">
                        <div class="product_reg_row">
                            <input id="prodName" type="text" class="registerProduct" name="Productname" placeholder="Enter product name" style="margin-bottom:3%;border:3px solid #d8ca30" >
                            <select name="Producttype" id="Producttype" class="registerProduct" style="margin-bottom:3%;border:3px solid #d8ca30">
                                <option value="-1" selected disabled hidden>Select product type</option> 
                                <option value="cylinder">Cylinder</option>
                                <option value="accessory">Accessory</option>
                            </select>
                        </div>
                        <div class="product_reg_row" style="margin-left:6%">
                                <div id="prodNameerr" style="width:32.5%;margin-right:0px;text-align:left;color:red;font-size:smaller"></div>
                                <div id="Producttypeerr" style="width:32.5%;margin-left:5%;margin-right:0px;text-align:left;color:red;font-size:smaller"></div>
                        </div>
                        <div class="product_reg_row">
                            <input id="unitPrice" type="text" class="registerProduct" name="unitprice" placeholder="Enter price" style="margin-bottom:3%;border:3px solid #d8ca30" > <br>
                            <input id="weight" type="text" class="registerProduct" name="weight" placeholder="Enter weight" style="margin-bottom:3%;border:3px solid #d8ca30" > <br>
                        </div>
                        <div class="product_reg_row" style="margin-left:6%">
                                <div id="unitPriceerr" style="width:32.5%;margin-right:0px;text-align:left;color:red;font-size:smaller"></div>
                                <div id="weighterr" style="width:32.5%;margin-left:5%;margin-right:0px;text-align:left;color:red;font-size:smaller"></div>
                        </div>
                        <div class="product_reg_row">
                            <input id="productionTime" type="text" class="registerProduct" name="productiontime" placeholder="Enter production time" style="margin-bottom:3%;border:3px solid #d8ca30" > <br>
                            <input id="quantity" type="text" class="registerProduct" name="quantity" placeholder="Enter quantity" style="margin-bottom:3%;border:3px solid #d8ca30;font-family:poppins"  > <br>
                        </div>
                        <div class="product_reg_row" style="margin-left:6%">
                                <div id="productionTimeerr" style="width:32.5%;margin-right:0px;text-align:left;color:red;font-size:smaller"></div>
                                <div id="quantityerr" style="width:32.5%;margin-left:5%;margin-right:0px;text-align:left;color:red;font-size:smaller"></div>
                        </div>
                        <div class="product_reg_row">
                            <input id="threshold" type="text" class="registerProduct" name="threshold" placeholder="Minimum threshold" style="margin-bottom:3%;border:3px solid #d8ca30;font-family:poppins"  > <br>
                            <input type="file" class="registerProduct" name="productImage" id="productImage" style="margin-bottom:3%;border:3px solid #d8ca30" onchange="showImage(this)" > <br>
                        </div>
                        <div class="product_reg_row" style="margin-left:6%">
                                <div id="thresholderr" style="width:32.5%;margin-right:0px;text-align:left;color:red;font-size:smaller"></div>
                                <div id="productImageerr" style="width:32.5%;margin-left:5%;margin-right:0px;text-align:left;color:red;font-size:smaller"></div>
                        </div>
                        <div class="product_reg_row">
                            <input type="submit" name="Sign In" value="Add product" class="submitRegisterProduct" onClick="addProducts()" style="width:65%">
                        </div>
                    </form>
                </div>
            <div class="right">
                <div style="height:18vh"></div>';
                /*<label>Preview</label>*/
                echo'<div class="productPreview" id="productPreview"><img id="ff" style="width:100%;height:100%;border-radius: 10px;outline:none">
                </div></div>
            </div>
        </section>';
    }
    function deliverydashboard($data){
        echo
        ' <section class="body-content">
                <div class="Top" id="Top">
                    <div class="card">
                        <div class="cmValue">'.$data['dispatched_count'].'</div>
                        <div class="cmTitle">Ongoing Deliveries</div>
                    </div>
                    <div class="card">
                        <div class="cmValue">'.$data['completed_count'].'</div>
                        <div class="cmTitle">Orders Delivered Today</div>
                    </div>
                    <div class="card">
                        <div class="cmValue">'.$data['review_count'].'</div>';
                        if($data['review_count']>1 ||$data['review_count']==0 ){
                            echo'<div class="cmTitle">Reviews</div>';
                        }else{
                            echo'<div class="cmTitle">Review</div>';
                        }
                    echo'    
                    </div>
                    <div class="card">
                        <div class="cmValue" style="font-size:3vw">LKR.'.number_format($data['revenue'],2).'</div>
                        <div class="cmTitle">Earned Today</div>
                    </div>
                </div>
                <div class="bottom">
                    <div class="vehicleCard">
                        <div class="vehicleTitle" style="width:100%;height:10%">My Vehicle</div>
                        <div class="vehicleNo" style="width:100%;height:50%">'.$data['vehicle_no'].'</div>
                        <div class="btm" style="display:flex;justify-content: space-between">
                            <div class="vehicleProp">'.$data['weight_limit'].'KG</div>
                            <div class="vehicleProp">Rs.'.$data['cost_per_km'].'/KM</div>
                        </div>
                    </div>
                    <div class="salesChart">';
                        echo '<img src="';echo BASEURL.'/public/img/delivery/del.png"';echo' width="65%" height="100%" ">';
                        
                    echo '   
                    </div>
                </div>
        </section>';
        /*'<section class="body-content">
            <div class="Top" id="Top">
            <div class="Col_1" id="Col_1">
                <div class="Title_1">
                <div class="ChartTitle">Previous</div><br>
                </div>
                <div class="Content_1"></div>
            </div>
            <div class="Col_2" id="Col_2">
                <div class="Title_2">
                <div class="ChartTitle">Today</div>
                </div>
                <div class="Content_3" id="Content_3">';
                echo '<div class="Content_3_row" id="Content_3_row"><div class="data_title" style="margin-left: 4%;">Completed Orders</div><div class="data_value" style="margin-right: 10%;">6</div></div>';
                echo '<div class="Content_3_row" id="Content_3_row"><div class="data_title" style="margin-left: 4%;"> Ongoing  Orders</div><div class="data_value" style="margin-right: 10%;">1</div></div>';
                
                
                echo'</div>
            
            </div>
            <div class="Col_3" id="Col_3">
                <div class="Title_3">
                <div class="ChartTitle">My Vehicle</div>
                </div>
                <div class="Content_3" id="Content_3">';
                    echo '<div class="Content_3_row" id="Content_3_row"><div class="data_title" style="margin-left: 4%;">Vehicle no</div><div class="data_value" style="margin-right: 10%;">'.$data['vehicle_no'].'</div></div>';
                    echo '<div class="Content_3_row" id="Content_3_row"><div class="data_title" style="margin-left: 4%;">Vehicle type</div><div class="data_value" style="margin-right: 10%;">'. $data['vehicle_type'].'</div></div>';
                    echo '<div class="Content_3_row" id="Content_3_row"><div class="data_title" style="margin-left: 4%;">Weight limit</div><div class="data_value" style="margin-right: 10%;">'.$data['weight_limit'].'</div></div>';
                    echo '<div class="Content_3_row" id="Content_3_row"><div class="data_title" style="margin-left: 4%;">Cost per KM</div><div class="data_value" style="margin-right: 10%;">'.$data['cost_per_km'].'</div></div>';
                
                
                '</div>
                </div>
            </div>'*/
            /*<div class="DistributorTableHeadings" id="DistributorTableHeadings">
                <div class="Distributor_table_name" id="Distributor_table_name">
                    <div class="distibutor_title">Current Deliveries</div>
                </div>
                <div class="tableTitles" id="tableTitles">
                    <div class="distributor_name" id="col"style="width:25%;margin-top:1%">Customer</div>
                    <div class="distributor_contactno" id="col"style="width:25%;margin-top:1%">Destination</div>
                    <div class="distributor_location" id="col"style="width:25%;margin-top:1%">Contact no</div>
                </div>       
            </div> 
            <div class="DistributorTable" id="DistributorTable">

            </div> 
            <div class="DealerTableHeadings" id="DealerTableHeadings">
                <div class="Dealer_table_name" id=\"Dealer_table_name\">
                    <div class="distibutor_title">Available Deliveries</div>
                    </div>
                    <div class="tableTitles" id="tableTitles">
                    <div class="Dealer_name" id="col" style="width:25%;margin-top:1%">Name</div>
                    <div class="Dealer_contactno" id="col"style="width:20%;margin-top:1%">Destination</div>
                    <div class="Dealer_location" id="col"style="width:22%;margin-top:1%">Contact no</div>
                    <div class="Dealer_email" id="col" style="width:20%;margin-top:1%">Placed date</div>
                    </div>
                </div>
            </div>  
            <div class="DealerTable" id="DealerTable"></div>*/
        echo'</section>';
    }
    function gasdeliveries($data){
        $redValue=45+ (((255-45)/100)*(($data['total_weight']/$data['weight_limit'])*100));
        $blueValue=119- (((119)/100)*(($data['total_weight']/$data['weight_limit'])*100));
        $greenValue=188- (((188-51)/100)*(($data['total_weight']/$data['weight_limit'])*100));
        echo
        '<section class="body-content">
            <div class="Distributor_table_name" id="Distributor_table_name" style="margin:0;margin-left:-1.5%">
            <a href="../Delvery/deliveries" style="width:48.5%;height:100%" class="deliveries_link" ><div class="DealerTableTopics" style="width:100%;height:100%;color:white">Pool</div></a>
            <a href="../Delvery/currentdeliveries" style="width:48.5%";height:100%  class="deliveries_link"><div class="DealerTableTopics" onClick="loadCurrentDeliveries()" style="width:100%;height:100%;color:black;" >Current deliveries</div></a>
            </div>';
            if(isset($data["pool"])){
            echo'<div  class="bar" style="width:97%;height:7%;display:flex;align-items: center;border-left-style:solid;border-right-style:solid;border-color: #2d77bc;box-sizing:border-box">
            <div class="currentContainer">
                <label style="color:white;margin-right:2%">Total capacity : </label>
                <label style="color:white">'.$data['weight_limit'].'KG</label>
            </div>
            <div class="remainingContainer">
                <label style="color:white;margin-right:2%">Remaining capacity : </label>
                <label style="color:white;">'.$data['weight_limit']-$data['total_weight'].'KG</label>
            </div>
            <div class="container">
                <div class="progress-bar__container" style="overflow: hidden"">
                    <div class="cprogress" id="cprogress" onClick="fillProgress()" style="width:'.(($data['total_weight']/$data['weight_limit'])*100).'%;background-color:rgb('.$redValue.','.$blueValue.','.$greenValue.')"></div>';
                    if(number_format(($data['total_weight']/$data['weight_limit'])*100,2)<41){
                        echo'<label style="color:rgb('.$redValue.','.$blueValue.','.$greenValue.')" class="progress-text">'.number_format(($data['total_weight']/$data['weight_limit'])*100,2).'%</label>';
                    }else if(number_format(($data['total_weight']/$data['weight_limit'])*100,2)>52){
                        echo'<label style="white" class="progress-text">'.number_format(($data['total_weight']/$data['weight_limit'])*100,2).'%</label>';
                    }else{
                        echo'<label style="black" class="progress-text">'.number_format(($data['total_weight']/$data['weight_limit'])*100,2).'%</label>';
                    }
                    echo'
                </div>
            </div>         
         </div>
        <div class="DealerTables" id="DealerTables" style="margin:0;height:80%">';
        echo '<table class="styled-table" style="margin-top:0.3%">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Address</th>
                                <th>Contact no</th>
                                <th>Placed date</th>
                                <th>Placed time</th>
                                <th>Distance</th>
                                <th>Charge</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                                <tbody style="overflow-y:auto;height:100%">';
        if(isset($data["pool"])) {
            $result=$data['pool'];
            $pool = "";
            /*$pool .=  '<button class="collapsible" ">
                                    <div class="orderColumn">Name</div>
                                    <div class="orderColumn">Address</div>
                                    <div class="orderColumn">Contact no</div>
                                    <div class="orderColumn">Placed date</div>
                                    <div class="orderColumn">Placed time</div>
                                    <div class="orderColumn">Distance</div>
                                    <div class="orderColumn">Charge</div>
                                    <div class="orderColumn"></div></div>
                                    <label></label>
                                </button>';*/
            $processedOrders=array();
            $Count=1;
            foreach ($result as $row) {
                
                if(!(in_array($row['order_id'], $processedOrders))) {
                    $weight=0;
                    $charge=0;
                    $products=array();
                    foreach($result as $row2) {
                        if($row['order_id']==$row2['order_id']) {
                            $weight+=$row2['quantity']*$row2['weight'];
                            array_push($products,array($row2['image'],$row2['name'],$row2['quantity']));
                        }
                    }
                    foreach($data['charges'] as $row3) {
                        if(intval($row3['min_distance'])<=getDistance($row['city'].','.$row['street'], $row['dcity'].','.$row['dstreet']) && $row3['max_distance']>=intval(getDistance($row['city'].','.$row['street'], $row['dcity'].','.$row['dstreet']))) {
                            $charge=$row3['charge_per_kg'];
                        }
                    }

                    array_push($processedOrders, $row['order_id']);
                    $pool .=  '<tr>
                            <td>'.$row['order_id'].'</td>
                            <td>'.$row['first_name'].' '.$row['last_name'].'</td>
                            <td>'.$row['street'].','.$row['city'].'</td>
                            <td>'.$row['contact_no'].'</td>
                            <td>'.$row['place_date'].'</td>
                            <td>'.$row['place_time'].'</td>
                            <td>'.getDistance($row['city'].','.$row['street'], $row['dcity'].','.$row['dstreet']).'KM</td>
                            <td>Rs.'.number_format($weight * $charge,2).'</td>
                            <td><div class="accept_btn" id="col" onClick="takeJob('.$row['order_id'].')" style="width:103%;margin:auto;display:flex;align-items:center;align-content:center;justify-content:center" key="data[index].order_id "><a  style="color:white" >Accept</a></div></td>
                            <td><img onclick="collapse(this,'.$Count.')" class="littleproduct" src="http://localhost/mvc/public/img/icons/down.png"></td>
                            </tr><tr style="display:none" id="'.$Count.'row">
                            <td colspan="10">
                            <div class="content" id="'.$Count.'"style="display:flex;justify-content:center">';
                                $pool.="<table class=\"styled-table\" style=\"margin-top:0.3%;width:50%\">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th class=\"tdRight\">Quantity</th>
                                    </tr>
                                </thead>
                                        <tbody style=\"overflow-y:auto;height:100%\">";
                            foreach($products as $prow){
                                $pool.='<tr>
                                    <td><img class="littleproduct" src="http://localhost/mvc/public/img/products/'.$prow[0].'"></td>
                                    <td>'.$prow[1].'</td>
                                    <td class="tdRight">'.$prow[2].'</td>
                                </tr>';
                            }
                                $pool.='</tbody></table>
                            </div>
                            </td>
                            </tr>';
                    $Count+=1;
                }
            }
            echo $pool;
            echo'</div></section>';
            }
        }else{
            echo'<div  class="bar" style="width:97%;height:7%;display:flex;align-items: center;border-left-style:solid;border-right-style:solid;border-color: #2d77bc;box-sizing:border-box">
            <div class="currentContainer">
                <label style="color:white;margin-right:2%">Total capacity : </label>
                <label style="color:white">'.$data['weight_limit'].'KG</label>
            </div>
            <div class="remainingContainer">
                <label style="color:white;margin-right:2%">Remaining capacity : </label>
                <label style="color:white;">'.$data['weight_limit']-$data['total_weight'].'KG</label>
            </div>
            <div class="container">
                <div class="progress-bar__container" style="overflow: hidden"">
                    <div class="cprogress" id="cprogress" onClick="fillProgress()" style="width:'.(($data['total_weight']/$data['weight_limit'])*100).'%;background-color:rgb('.$redValue.','.$blueValue.','.$greenValue.')"></div>';
                    if(number_format(($data['total_weight']/$data['weight_limit'])*100,2)<41){
                        echo'<label style="color:rgb('.$redValue.','.$blueValue.','.$greenValue.')" class="progress-text">'.number_format(($data['total_weight']/$data['weight_limit'])*100,2).'%</label>';
                    }else if(number_format(($data['total_weight']/$data['weight_limit'])*100,2)>52){
                        echo'<label style="white" class="progress-text">'.number_format(($data['total_weight']/$data['weight_limit'])*100,2).'%</label>';
                    }else{
                        echo'<label style="black" class="progress-text">'.number_format(($data['total_weight']/$data['weight_limit'])*100,2).'%</label>';
                    }
                    echo'
                </div>
            </div>         
         </div>';
            echo '<div class="DealerTables" id="DealerTables" style="margin:0;display:flex;justify-content:center;align-items:center">';
                echo'<img src="../img/placeholders/2.png" style="width: 40%;height: 70%;">';
                echo '</div></section>';
        }
    }   
    function currentgasdeliveries($data){
        $redValue=45+ (((255-45)/100)*(($data['total_weight']/$data['weight_limit'])*100));
        $blueValue=119- (((119)/100)*(($data['total_weight']/$data['weight_limit'])*100));
        $greenValue=188- (((188-51)/100)*(($data['total_weight']/$data['weight_limit'])*100));
        echo'
        <section class="body-content">
         <div class="Distributor_table_name" id="Distributor_table_name" style="margin:0;margin-left:-1.5%">
         <a href="../Delvery/deliveries" style="width:48.5%;height:100%" class="deliveries_link" ><div class="DealerTableTopics" onClick="loadDeliveryTableTopics()" style="width:100%;height:100%;color:black;background-color:white;box-sizing: border-box;border:3px solid #2d77bc;">Pool</div></a>
         <a href="../Delvery/currentdeliveries" style="width:48.5%";height:100%  class="deliveries_link"><div class="DealerTableTopics" onClick="loadCurrentDeliveries()" id="temp" style="width:100%;height:100%;color:white;background-color:#2d77bc">Current deliveries</div></a>
         </div>';
         if(isset($data["current"])){
         echo'<div  class="bar" style="width:97%;height:7%;display:flex;align-items: center;border-left-style:solid;border-right-style:solid;border-color: #2d77bc;box-sizing:border-box">
            <div class="currentContainer">
                <label style="color:white;margin-right:2%">Total capacity : </label>
                <label style="color:white">'.$data['weight_limit'].'KG</label>
            </div>
            <div class="remainingContainer">
                <label style="color:white;margin-right:2%">Remaining capacity : </label>
                <label style="color:white;">'.$data['weight_limit']-$data['total_weight'].'KG</label>
            </div>
            <div class="container">
                <div class="progress-bar__container" style="overflow: hidden">
                    <div class="cprogress" id="cprogress" onClick="fillProgress()" style="width:'.(($data['total_weight']/$data['weight_limit'])*100).'%;background-color:rgb('.$redValue.','.$blueValue.','.$greenValue.')"></div>';
                    if(number_format(($data['total_weight']/$data['weight_limit'])*100,2)<41){
                        echo'<label style="color:rgb('.$redValue.','.$blueValue.','.$greenValue.')" class="progress-text">'.number_format(($data['total_weight']/$data['weight_limit'])*100,2).'%</label>';
                    }else if(number_format(($data['total_weight']/$data['weight_limit'])*100,2)>52){
                        echo'<label style="white" class="progress-text">'.number_format(($data['total_weight']/$data['weight_limit'])*100,2).'%</label>';
                    }else{
                        echo'<label style="black" class="progress-text">'.number_format(($data['total_weight']/$data['weight_limit'])*100,2).'%</label>';
                    }
                    echo'
                </div>
            </div>
         </div>
        <div class="DealerTables" id="DealerTables" style="margin:0;height:80%">
        ';
        echo '<table class="styled-table" style="margin-top:0.3%">
                    <thead style="background-color:#dbb1f9">
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Address</th>
                            <th>Contact no</th>
                            <th>Placed date</th>
                            <th>Placed time</th>
                            <th>Distance</th>
                            <th>Charge</th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                <tbody style="overflow-y:auto;height:100%">';
        if (isset($data["current"])) {
            $result=$data['current'];
            $pool = "";
            $processedOrders=array();
            $Count=0;
            foreach ($result as $row) {
                //print_r($row);
                if(!(in_array($row['order_id'],$processedOrders))){
                    //print_r($row['order_id']);
                    array_push($processedOrders,$row['order_id']);
                    $weight=0;
                    $charge=0;
                    $products=array();
                    foreach($result as $row2){
                        if($row['order_id']==$row2['order_id']){
                            $weight+=$row2['quantity']*$row2['weight'];
                            array_push($products,array($row2['image'],$row2['name'],$row2['quantity']));
                            //$weight+=intval($row2['quantity']*floatval($row2['weight']));
                        }
                    }
                    foreach($data['charges'] as $row3){
                        if(intval($row3['min_distance'])<=getDistance($row['city'].','.$row['street'], $row['dcity'].','.$row['dstreet']) && $row3['max_distance']>=intval(getDistance($row['city'].','.$row['street'], $row['dcity'].','.$row['dstreet'])) ){
                            $charge=$row3['charge_per_kg'];
                        }
                    }
                    $pool .=  '<tr>
                            <td>'.$row['order_id'].'</td>
                            <td>'.$row['first_name'].' '.$row['last_name'].'</td>
                            <td>'.$row['street'].','.$row['city'].'</td>
                            <td>'.$row['contact_no'].'</td>
                            <td>'.$row['place_date'].'</td>
                            <td>'.$row['place_time'].'</td>
                            <td>'.getDistance($row['city'].','.$row['street'], $row['dcity'].','.$row['dstreet']).'KM</td>
                            <td>Rs.'.number_format($weight * $charge,2).'</td>
                            <td><div class="accept_btn" id="accept_btn" onClick="deliverJob('.$row['order_id'].','.number_format($charge*$weight,2).')" style="width:100%;height:100%;margin:auto;color:white" key="data[index].order_id ">Delivered</div></td>';
                            $str_time = $row['place_time'];
                            $time = date('H:i:s');
                            sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
                            $placedTime = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
                            sscanf($time, "%d:%d:%d", $hours, $minutes, $seconds);
                            $currentTime = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
                            if(($currentTime-$placedTime)<=900){
                                $pool.='<td><div class="delete_btn" id="delete_btn" onClick="cancelJob('.$row['order_id'].')" style="width:100%;height:100%;margin:auto" key="data[index].order_id ">Cancel</div></td>';
                            }else{
                                $pool.='<td><div class="delete_btn" id="delete_btn" onClick="cancelJob('.$row['order_id'].')" style="width:100%;height:100%;margin:auto;background-color:transparent" key="data[index].order_id "></div></td>';
                            }
                            $pool.='<td><img onclick="collapse(this,'.$Count.')" class="littleproduct" src="http://localhost/mvc/public/img/icons/down.png"></td>
                            </tr><tr style="display:none" id="'.$Count.'row">
                            <td colspan="11">
                            <div class="content" id="'.$Count.'"style="display:flex;justify-content:center">';
                                $pool.="<table class=\"styled-table\" style=\"margin-top:0.3%;width:30%\">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th  class=\"tdRight\">Quantity</th>
                                    </tr>
                                </thead>
                                        <tbody style=\"overflow-y:auto;height:100%\">";
                            foreach($products as $prow){
                                $pool.='<tr>
                                    <td><img class="littleproduct" src="http://localhost/mvc/public/img/products/'.$prow[0].'"></td>
                                    <td>'.$prow[1].'</td>
                                    <td  class="tdRight">'.$prow[2].'</td>
                                </tr>';
                            }
                                $pool.='</tbody></table>
                            </div>
                            </td>
                            </tr>';
                    $Count+=1;
                }
            }
            echo $pool;
            echo'</div>';
            echo'</section>';
        }
            
        }else{
            echo'<div  class="bar" style="width:97%;height:7%;display:flex;align-items: center;border-left-style:solid;border-right-style:solid;border-color: #2d77bc;box-sizing:border-box">
            <div class="currentContainer">
                <label style="color:white;margin-right:2%">Total capacity : </label>
                <label style="color:white">'.$data['weight_limit'].'KG</label>
            </div>
            <div class="remainingContainer">
                <label style="color:white;margin-right:2%">Remaining capacity : </label>
                <label style="color:white;">'.$data['weight_limit']-$data['total_weight'].'KG</label>
            </div>
            <div class="container">
                <div class="progress-bar__container" style="overflow: hidden"">
                    <div class="cprogress" id="cprogress" onClick="fillProgress()" style="width:'.(($data['total_weight']/$data['weight_limit'])*100).'%;background-color:rgb('.$redValue.','.$blueValue.','.$greenValue.')"></div>';
                    if(number_format(($data['total_weight']/$data['weight_limit'])*100,2)<41){
                        echo'<label style="color:rgb('.$redValue.','.$blueValue.','.$greenValue.')" class="progress-text">'.number_format(($data['total_weight']/$data['weight_limit'])*100,2).'%</label>';
                    }else if(number_format(($data['total_weight']/$data['weight_limit'])*100,2)>52){
                        echo'<label style="white" class="progress-text">'.number_format(($data['total_weight']/$data['weight_limit'])*100,2).'%</label>';
                    }else{
                        echo'<label style="black" class="progress-text">'.number_format(($data['total_weight']/$data['weight_limit'])*100,2).'%</label>';
                    }
                    echo'
                </div>
            </div>         
         </div>';
            echo '<div class="DealerTables" id="DealerTables" style="margin:0;display:flex;justify-content:center;align-items:center">';
                echo'<img src="../img/placeholders/2.png" style="width: 40%;height: 70%;">';
                echo '</div></section>';
        }
    }
    function companyRegDealer($data){
        echo 
        '<section class="body-content">
            <div class="Distributor_table_name" id="Distributor_table_name" style="margin:0;margin-left:-1.5%">
                 <a href="../Compny/dealer" style="width:48.5%" ><div class="DealerTableTopics" onClick="loadDistributorTableTopics()" style="width:100%;height:100%">Registered Dealers</div></a>
                 <a href="../Compny/regDealer" style="width:48.5%" ><div class="DealerTableTopics" onClick="loadDistributorRegistrationForm()" style="width:100%;height:100%;background-color:#d8ca30;color:white">Register New Dealer</div></a>
                 
             </div>
            <div class="DealerTables" id="DealerTables" style="display:flex;height:90%;margin:0">
                <div class="left">
                <form action="'. BASEURL.'/Compny/registerDealer" enctype="multipart/form-data" method="POST" id="productRegistrationForm" class="productRegistrationForm">
                <div class="product_reg_row">
                <input type="text" class="registerProduct" name="name" placeholder="Firstname    Lastname" style="margin-bottom:2%;border:3px solid #d8ca30" >
                <input type="text" class="registerProduct" name="cno" placeholder="Enter contact no" style="margin-bottom:2%;border:3px solid #d8ca30" > <br>
                </div>
                <div class="product_reg_row">
                    <input type="text" class="registerProduct" name="email" placeholder="Enter email" style="margin-bottom:2%;border:3px solid #d8ca30;width:65%" >
                </div>
                <div class="product_reg_row">
                <input type="text" class="registerProduct" name="password" placeholder="Enter password" style="margin-bottom:2%;border:3px solid #d8ca30" >
                <input type="text" class="registerProduct" name="confirmpswd" placeholder="Confirm password" style="margin-bottom:2%;border:3px solid #d8ca30" > <br>
                </div>
                <div class="product_reg_row">
                <input type="text" class="registerProduct" name="city" placeholder="Enter city" style="margin-bottom:2%;border:3px solid #d8ca30" > <br>
                <input type="text" class="registerProduct" name="street" placeholder="Enter street" style="margin-bottom:2%;border:3px solid #d8ca30" > <br>
                </div>
                <div class="product_reg_row">
                <select name="distributor_id" id="Producttype" class="registerProduct" style="margin-bottom:2%;border:3px solid #d8ca30">
                <option value="3">Kavish Ltd</option>
                <option value="11">JT Agencies</option>
                </select>
                <input type="text" class="registerProduct" name="merchantid" placeholder="Enter merchant ID" style="margin-bottom:2%;border:3px solid #d8ca30;font-family:poppins"  > <br>
                </div>
                <div class="product_reg_row">
                <input type="text" class="registerProduct" name="bank" placeholder="Enter bank" style="margin-bottom:2%;border:3px solid #d8ca30" > <br>
                <input type="text" class="registerProduct" name="bank_acc" placeholder="Enter bank account no" style="margin-bottom:2%;border:3px solid #d8ca30;font-family:poppins"  > <br>
                </div>
                <div class="product_reg_row">
                <input type="file" class="registerProduct" name="productImage" id="productImage" style="margin-bottom:2%;border:3px solid #d8ca30" onchange="showImage(this)" > <br>
                </div>
                <div class="product_reg_row">
                <input type="submit" name="Sign In" value="Register Dealer" class="submitRegisterProduct" onClick="addProducts()" style="width:65%">
                </div>
                </form></div><div class="right">
                <div style="height:10vh"></div>
                <label>Preview</label>
                <div class="productPreview" id="productPreview"><img id="ff" style="width:100%;height:100%;border-radius:100%;outline:none">
                </div></div>
            </div>
        </section>';
    }
    function companyRegDistributor($data){
        echo 
        '<section class="body-content">
            <div class="Distributor_table_name" id="Distributor_table_name" style="margin:0;margin-left:-1.5%">
                 <a href="../Compny/distributor" style="width:48.5%" ><div class="DealerTableTopics" onClick="loadDistributorTableTopics()" style="width:100%;height:100%">Registered Distributors</div></a>
                 <a href="../Compny/regDistributor" style="width:48.5%" ><div class="DealerTableTopics" onClick="loadDistributorRegistrationForm()" style="width:100%;height:100%;background-color:#d8ca30;color:white">Register New Distributor</div></a>
                 
             </div>
            <div class="DealerTables" id="DealerTables" style="display:flex;height:80%;margin:0">
                <div class="left">
                <form action="'. BASEURL.'/Compny/registerDistributor" enctype="multipart/form-data" method="POST" id="productRegistrationForm" class="productRegistrationForm">
                <div class="product_reg_row">
                <input type="text" class="registerProduct" name="name" placeholder="Firstname    Lastname" style="margin-bottom:2%;border:3px solid #d8ca30" >
                <input type="text" class="registerProduct" name="cno" placeholder="Enter contact no" style="margin-bottom:2%;border:3px solid #d8ca30" > <br>
                </div>
                <div class="product_reg_row">
                    <input type="text" class="registerProduct" name="email" placeholder="Enter email" style="margin-bottom:2%;border:3px solid #d8ca30;width:65%" >
                </div>
                <div class="product_reg_row">
                <input type="text" class="registerProduct" name="password" placeholder="Enter password" style="margin-bottom:2%;border:3px solid #d8ca30" >
                <input type="text" class="registerProduct" name="confirmpswd" placeholder="Confirm password" style="margin-bottom:2%;border:3px solid #d8ca30" > <br>
                </div>
                <div class="product_reg_row">
                <input type="text" class="registerProduct" name="city" placeholder="Enter city" style="margin-bottom:2%;border:3px solid #d8ca30" > <br>
                <input type="text" class="registerProduct" name="street" placeholder="Enter street" style="margin-bottom:2%;border:3px solid #d8ca30" > <br>
                </div>
                <div class="product_reg_row">
                <input type="file" class="registerProduct" name="productImage" id="productImage" style="margin-bottom:3%;border:3px solid #d8ca30" onchange="showImage(this)" required> <br>
                </div>
                <div class="product_reg_row">
                <input type="submit" name="Sign In" value="Register Distributor" class="submitRegisterProduct" onClick="addProducts()" style="width:65%">
                </div>
                </form></div><div class="right">
                <div style="height:10vh"></div>
                <label>Preview</label>
                <div class="productPreview" id="productPreview"><img id="ff" style="width:100%;height:100%;border-radius:100%;outline:none">
                </div></div>
            </div>
        </section>';

    }
    function companyUpdateProducts($data){
        echo 
        '<section class="body-content">
            <div class="Distributor_table_name" id="Distributor_table_name" style="margin:0;margin-left:-1.3%">
                 <a href="../Compny/products" style="width:32.33%" ><div class="ProductTableTopics"onClick="location.href = "../Compny/dealer" style="background-color:#fff">Current Products</div></a>
                 <a href="../Compny/regproducts" style="width:32.33%" ><div class="ProductTableTopics" onClick="loadProductRegistrationForm()" style="background-color:#fff">Register New Product</div></a>
                 <a href="../Compny/updateProducts" style="width:32.33%" ><div class="ProductTableTopics" onClick="loadProductUpdateForm()" style="background-color:#d8ca30;color:white">Update Product</div></a>
             </div>';
             if (isset($data["products"])) {
            echo'<div class="DealerTables" id="DealerTables" style="display:flex;margin:0;width: 97.4%;height:80%">
                <div class="left">
                <form action="'. BASEURL.'/Compny/updateProduct" enctype="multipart/form-data" method="POST" id="productUpdateForm" class="productRegistrationForm">
                <div class="product_reg_row">
                <select name="Producttype" id="Producttype" class="registerProduct" style="margin-bottom:3%;border:3px solid #d8ca30">';
                $result=$data['products'];
                //echo $result;
                foreach($result as $results){
                    echo '<option value='.$results['product_id'].'>'.$results['name'].'</option>';
                }echo
                '</select>
                <input type="text" class="registerProduct" name="Productname" placeholder="Enter new price" style="margin-bottom:3%;border:3px solid #d8ca30">
                </div>
                <div class="product_reg_row">
                <input type="text" class="registerProduct" name="productiontime" placeholder="Enter production time" style="margin-bottom:3%;border:3px solid #d8ca30"> <br>
                <input type="text" class="registerProduct" name="quantity" placeholder="Enter quantity" style="margin-bottom:3%;border:3px solid #d8ca30;font-family:poppins"> <br>
                </div>
                <div class="product_reg_row">
                <input type="text" class="registerProduct" name="threshold" placeholder="Minimum threshold" style="margin-bottom:3%;border:3px solid #d8ca30;font-family:poppins" required > <br>
                <input type="file" class="registerProduct" name="productImage" id="productImage" style="margin-bottom:3%;border:3px solid #d8ca30" onchange="showImage(this)" > <br>
                </div>
                <div class="product_reg_row">
                <input type="button" name="Sign In" value="Update product" class="submitRegisterProduct" onClick="updateProducts()" style="width:65%">
                </div>
                </form></div><div class="right">
                <div style="height:18vh"></div>
                <div class="productPreview" id="productPreview"><img id="ff" style="width:100%;height:100%;border-radius:100%;outline:none">
                </div></div>
            </div>
        </section>';
        }else{
            echo '<div class="DealerTables" id="DealerTables" style="margin:0;display:flex;justify-content:center">';
            echo'<img src="../img/placeholders/2.png" style="width: 40%;height: 70%;">';
            echo '</div></section>';
        }
    }
    function companyOrders($data){
        echo 
        '<section class="body-content">
            <div class="Distributor_table_name" id="Distributor_table_name" style="margin:0;margin-left:-1.5%">
            <a href="../Compny/orders" style="width:24.25%" ><div class="DealerTableTopics" style="width:100%;height:100%;background-color:#d8ca30;color:white;border-right:0px">Gas Orders</div></a>
            <a href="../Compny/issuedOrders" style="width:24.25%" ><div class="DealerTableTopics"  style="width:100%;height:100%;border-right:0px">Issued Orders</div></a>
            <a href="../Compny/delayedOrders" style="width:24.25%" ><div class="DealerTableTopics"  style="width:100%;height:100%;border-right:0px">Delayed Orders</div></a>
            <a href="../Compny/limitquota" style="width:24.25%" ><div class="DealerTableTopics"  style="width:100%;height:100%">Limit Quota</div></a>
            </div>';
            if (isset($data['order_details'])){
                echo'<div class="DealerTables" id="DealerTables" style="height:80%;margin:0">';
                $result = $data["order_details"];
                $product_array=$data['product_details'];
                $orders='';
                $processedOrders=array();
                $orderID='';
                $distName='';
                $placedDate='';
                $placedTime='';
                
                
                
                //$encodedArray=json_encode($productIDlist);
                foreach ($result as $row) {
                    $orderID=$row['stock_req_id'];
                    $imgIndex=1;
                    $imgCount=0;
                    $distName=$row['first_name'].' '.$row['last_name'];
                    $placedDate=$row['place_date'];
                    $placedTime=$row['place_time'];
                    $productIDlist='';
                    $isEnabled=true;
                    foreach($result as $row_1){
                        if($row_1['stock_req_id']==$orderID){
                            $productIDlist.=$row_1['product_id'].' ';
                            $imgCount+=1;
                        }
                        
                    }
                    if(!in_array($orderID,$processedOrders)){
                    $orders .=  '<div class="orderCard" >
                    <div class="orderRow">
                        <div class="orderColumn"><label style="margin-left: 2%;">Order ID :</label>'.$orderID.'</div>
                        <div class="orderColumn"><label style="margin-left: 2%;">Distributor Name :</label>'.$distName.'</div>
                    </div>
                    <div class="orderRow">
                        <div class="orderColumn"><label style="margin-left: 2%;">Placed Date :</label>'.$placedDate.'</div>
                        <div class="orderColumn"><label style="margin-left: 2%;">Placed Time :</label>'.$placedTime.'</div>
                    </div>
                    <div class="orderTbl">
                        <table class="styled-table">
                            <thead>
                                <tr>
                                    <th>Product name</th>
                                    <th style="text-align:center">Unit price (Rs.)</th>
                                    <th style="text-align:center">Quantity</th>
                                    <th style="text-align:center">Status</th>
                                    <th style="text-align:end">Total (Rs.)</th>
                                </tr>
                            </thead>
                            <tbody style="display:legacy">';
                    $total=0;
                    foreach ($result as $row_2) {
                        if ($row_2['stock_req_id']==$orderID) {
                            foreach ($product_array as $row_3) {
                                if($row_3['product_id']==$row_2['product_id']){
                                $orders.='<tr style="height:1%">
                                <td>'.$row_3['name'].'</td>
                                    <td style="text-align:center">'.number_format($row_2['unit_price'],2).'</td>
                                    <td style="text-align:center"><input type="number" class="qtyInput" value="'.$row_2['quantity'].'" id="'.$orderID.$imgIndex."1".'" key="'.$row_3['product_id'].'"';
                                    if($row_2['quantity']<=$row_3['quantity']){
                                        $orders.='disabled></td>';
                                        $orders.='<td style="text-align:center"><img src='.BASEURL.'/public/icons/check.png'.' width="32px" height="32px" id="'.$orderID.$imgIndex."2".'" class="stateImg"></td>';
                                    }else{
                                        $isEnabled=false;
                                        $orders.=' oninput="changeOrderDetails('.$imgIndex.','.$imgCount.','.$orderID.','.$row_2['product_id'].','.$row_2['unit_price'].','.$row_3['quantity'].','.$row_2['stock_req_id'].',\''.$productIDlist.'\')"></td>';
                                        //$orders.=' oninput="changeOrderDetails(\''.$productIDlist.'\')"></td>';
                                        $orders.='<td style="text-align:center"><img src='.BASEURL.'/public/icons/warning.png'.' width="32px" height="32px" title="Current Stock is '.$row_3['quantity'].' Cylinders" id="'.$orderID.$imgIndex."2".'" class="stateImg"></td>';
                                    }
                                    
                                    $orders.='<td id="'.$orderID.$row_2['product_id']."3".'" value='.$row_2['unit_price']*$row_2['quantity'].' style="text-align:end">'.number_format($row_2['unit_price']*$row_2['quantity'],2).'</td>
                                </tr>';
                                $total+=$row_2['unit_price']*$row_2['quantity'];
                                $imgIndex+=1;
                                }
                            }
                        }

                    }
                    array_push($processedOrders,$orderID);
                    $orders.='</tbody>      
                    </table>
                    
                    </div>
                    <div class="orderRow" style="height:8%">
                        <div class="orderColumn" style="display:flex;"><div style="min-width:46%;color:white;background-color:var(--table-header);margin-left:1%;height:100%;display:flex;align-items:center;justify-content:center;border-radius:10px" ><label style="color:white"> Net Total (Rs):</label><label style="color:white" id="'.$orderID.'total" value='.$total.'>'.' '.number_format($total,2).'</label></div></div>
                    </div>
                        <div class="orderRow" style="margin-top:1%">';
                        if($isEnabled){
                            $orders.='<div class="orderButtons" onClick="issueOrder(this)" key="'.$orderID.'" id="'.$orderID.'issue" style="background-color:dodgerblue"><label>Issue</label></div>';
                        }else{
                            $orders.='<div class="orderButtons" onClick="issueOrder(this)" key="'.$orderID.'" id="'.$orderID.'issue" style="pointer-events:none"><label>Issue</label></div>';
                        }
                        $orders.='
                            <div class="orderButtons" onClick="delayOrder(this)" key="'.$orderID.'"><label>Delay</label></div>
                        </div>
                    </div>';
                    }
                }
                echo $orders;
                echo '</div></section>';
            }else{
                echo '<div class="DealerTables" id="DealerTables" style="margin:0;display:flex;justify-content:center">';
                echo'<img src="../img/placeholders/2.png" style="width: 40%;height: 70%;">';
                echo '</div></section>';
            }
    }
    function companyLimitQuota($data){
        echo 
        '<section class="body-content">
            <div class="Distributor_table_name" id="Distributor_table_name" style="margin:0;margin-left:-1.5%">
            <a href="../Compny/orders" style="width:24.25%" ><div class="DealerTableTopics" style="width:100%;height:100%;border-right:0px">Gas Orders</div></a>
            <a href="../Compny/issuedOrders" style="width:24.25%" ><div class="DealerTableTopics"  style="width:100%;height:100%;border-right:0px">Issued Orders</div></a>
            <a href="../Compny/delayedOrders" style="width:24.25%" ><div class="DealerTableTopics"  style="width:100%;height:100%;border-right:0px">Delayed Orders</div></a>
            <a href="../Compny/limitquota" style="width:24.25%" ><div class="DealerTableTopics"  style="width:100%;height:100%;background-color:#d8ca30;color:white">Limit Quota</div></a>
            </div>';
            echo'<div class="DealerTables" id="DealerTables" style="height:80%;margin:0">';
            if (isset($data['quotaDetails'])) { 
                $quota='';
                $result = $data["quotaDetails"];
                foreach ($result as $row) {
                    $quota.='
                        <div class="poductQuota">
                            <div class="productQuotaName" style="font-size: large"><lable>'.$row['customer_type'].'</lable></div>
                            <div class="productQuotaCurrent" style="font-size:large"><lable>Current :</lable><label>'.$row['monthly_limit'].'KG</label></div>';
                            if($row['state']=="ON"){
                                $quota.='<div class="productQuotaNew"><input type="text" placeholder="Enter new quota" class="newQuota" id="'.strtolower($row['customer_type']).'" style="width:70%"></div>
                                <div class="productQuotaResetCurrent" onClick="setQuota(this)" key="'.$row['customer_type'].'"><div class="quotaButtons" ><label>Set Quota</label></div></div>';
                            }else{
                                $quota.='<div class="productQuotaNew"><input type="text" placeholder="Enter new quota" class="newQuota" id="'.strtolower($row['customer_type']).'" style="width:70%" disabled></div>
                                <div class="productQuotaResetCurrent"  key="'.$row['customer_type'].'"><div class="quotaButtons" style="pointer-events:none"><label>Set Quota</label></div></div>';
                            }
                            
                            $quota.='
                            <div class="productQuotaSetNew">
                            <label class="switch">';
                                if($row['state']=="ON"){
                                    $quota.='<input type="checkbox" oninput="resetQuota(this)" key='.$row['customer_type'].' checked>';

                                }else{
                                    $quota.='<input type="checkbox" oninput="resetQuota(this)"key='.$row['customer_type'].'>';
                                }
                                $quota.='
                                <span class="slider round"></span>
                            </label>
                            </div>     
                        </div>';

                }
                echo $quota;
            }else{
                echo '<div class="DealerTables" id="DealerTables" style="margin:0;display:flex;justify-content:center">';
                echo'<img src="../img/placeholders/2.png" style="width: 40%;height: 70%;">';
                echo '</div>';
            }
        echo ' 
        </section>';
    }
    function viewReviews($data){
        echo
        '<section class="body-content">
         <div class="Distributor_table_name" id="Distributor_table_name" style="margin:0;margin-left:-1.5%">
         <a href="../Delvery/reviews" style="width:97%;height:100%" class="deliveries_link" ><div class="DealerTableTopics" onClick="loadDeliveryTableTopics()" style="width:100%;height:100%;color:white">Reviews</div></a>
         </div>';
        if(isset($data['reviews'])){
            echo'<div class="DealerTables" id="DealerTables" style="height:80%;margin:0">';
            $reviews=$data['reviews'];
            $tag='';
            foreach($reviews as $row){
                $tag.='<div class="reviewRow" >
                <div class="orderIDRow"><div>Order ID :'.$row['order_id'].'</div></div>
                    <div class="messageRow">'.$row['message'].'</div>
                    <div class="dateTimeRow">
                        <div class="reviewTime">Time -'.$row['time'].'</div>
                        <div class="reviewDate">Date -'.$row['date'].'</div> 
                    </div>        
                </div>';
            }
            echo $tag;
            echo'</div></section>';
        }else{
            echo '<div class="DealerTables" id="DealerTables" style="margin:0;display:flex;justify-content:center;align-items:center">';
                echo'<img src="../img/placeholders/2.png" style="width: 40%;height: 70%;">';
                echo '</div></section>';
        }
        
        /*echo '
        <div class="reviewRow" >
            <div class="orderIDRow"><div>Order ID : </div></div>
            <div class="messageRow">Delivered fast!.Great service.Thumbs up</div>
            <div class="dateTimeRow">
                <div class="reviewTime">04:23PM</div>
                <div class="reviewDate">2023/01/18</div> 
            </div>        
        </div>';*/

       
    }

    function notifications($data){
        echo '<section class="body-content">
        <div class="content-data notifications">
            <h2>Notifications</h2>
            <ul>';
                
                    if(mysqli_num_rows($data['notifications']) > 0){
                        while($notification = mysqli_fetch_assoc($data['notifications'])){
                            echo '<li>
                                    <div class="notification">
                                        '.notificationIcon($notification['type']).'
                                        <div>
                                        <h2>'.$notification['type'].'</h2>
                                        <p>'.$notification['message'].'</p>
                                        <p class="time gray">'.date('F j, Y, g:i A', strtotime($notification['date'].' '.$notification['time'])).'</p>
                                        </div>
                                    </div>
                                </li>';
                        }
                    }else{
                        echo '<div class="no-notifications">
                            <img src="'.BASEURL.'/public/img/placeholders/nonotifications.png" alt="">
                            <h3>No notifications yet</h3>
                            <p class="gray">Stay tuned! notifications about your activity will show up here.</p>
                        </div>';
                    }
                
                // <li>
                //     <div class="notification">
                //         <h2>Re-Order level alert</h2>
                //         <p>You're runnig low stock on the following products. Hurry up and place a new purchase order. Products : (Buddy, Budget)</p>
                //     </div>
                // </li>
                // <li>
                //     <div class="notification">
                //         <h2>Re-Order level alert</h2>
                //         <p>You're runnig low stock on the following products. Hurry up and place a new purchase order. Products : (Buddy, Budget)</p>
                //     </div>
                // </li>
            echo '</ul>
                </div>
        </section>
        </section>';
    }
    function companyAnalysis($data){    
        echo
        '<section class="body-content">
            <div class="Distributor_table_name" id="Distributor_table_name" style="margin:0;margin-left:-1.5%">
            <a href="../Compny/analysis" style="width:97%" ><div class="DealerTableTopics" style="width:100%;height:100%;background-color:#d8ca30;color:white">Analysis</div></a>
            </div>';
            echo'<div class="DealerTables" id="DealerTables" style="height:90%;margin:0;">
                <div class="selectBoxes" style="width:100%;height:10%;display:flex;flex-direction:row;margin-top:1%">
                <form action="'. BASEURL.'/Compny/getCharts" enctype="multipart/form-data" method="POST" style="display:flex;flex-direction:row;width:100%">
                    <div class="selectBox" style="width:20%;height:100%;background-color:white;margin-right:2%;margin-left:5%">';
                        if(isset($data['distNames']) && isset($data['currentdistributor'])){
                            $result=$data['distNames'];
                            echo'<select name="distNames" id="distNames" onchange="addYearsToSelectBoxes(this)">
                            <option value="" disabled >Select distributor</option>';
                            $tag='';
                            foreach ($result as $row) {
                                if($row['id']==$data['currentdistributor']){
                                    $tag.='<option value="'.$row['id'].'"selected>'.$row['names'].'</option>';
                                }else{
                                    $tag.='<option value="'.$row['id'].'">'.$row['names'].'</option>';
                                }
                            }
                            $tag.='</select></div>';
                            echo $tag;
                        }else if(isset($data['distNames'])){
                            $result=$data['distNames'];
                            echo'<select name="distNames" id="distNames" onchange="addYearsToSelectBoxes(this)">
                            <option value="" disabled selected>Select distributor</option>';
                            $tag='';
                            foreach ($result as $row) {
                                $tag.='<option value="'.$row['id'].'">'.$row['names'].'</option>';
                                
                            }
                            $tag.='</select></div>';
                            echo $tag;
                        }
                        echo'<div class="selectBox" style="width:40%;height:100%;background-color:white;margin-right:2%;align-content:center;align-items:center;justify-content:center;display:flex">
                                From<select name="yearFrom" id="yearFrom" style="margin-left:1%" onchange="addMonthsToSelectBoxes(this)">';
                                    if(isset($data['joineddate'])){
                                        echo'<option value="" disabled >Year</option>';
                                        $tag='';
                                        for ($i=intval($data['joineddate'][0]); $i < intval($data['currentdate'][0])+1; $i++) { 
                                            if(intval($data['fromyearandmonth'][0])==$i){
                                                $tag.='<option value="'.$i.'"selected>'.$i.'</option>';
                                            }else{
                                                $tag.='<option value="'.$i.'">'.$i.'</option>';
                                            }
                                            //$tag.='<option value="'.$i.'">'.$i.'</option>';
                                        }
                                        $tag.='</select>';
                                        echo $tag;

                                    }else{
                                        echo'<option value="" disabled selected>Year</option></select>';
                                    }
                                echo'<select name="monthFrom" id="monthFrom">';
                                if(isset($data['currentdate'])){
                                    echo'<option value="" disabled >Month</option>';
                                    $tag='';
                                    $to=0;
                                    if(intval($data['fromyearandmonth'][0])==intval($data['currentdate'][0])){
                                        $to=intval($data['currentdate'][1])+1;
                                    }else{
                                        $to=13;
                                    }
                                    for ($i=(intval($data['joineddate'][0])==intval($data['fromyearandmonth'][0]))?intval($data['joineddate'][1]):1; $i <$to ; $i++) { 
                                        if($i==$data['fromyearandmonth'][1]){
                                            $tag.='<option value="'.$i.'"selected>'.$i.'</option>';
                                        }else{
                                            $tag.='<option value="'.$i.'">'.$i.'</option>';
                                        }
                                    }
                                    $tag.='</select>';
                                    echo $tag;

                                }else{
                                    echo'<option value="" disabled selected>Month</option>
                                    </select>';
                                }
                            echo'
                            </div>
                            <div class="selectBox" style="width:40%;height:100%;background-color:white;margin-right:2%;align-content:center;align-items:center;justify-content:center;display:flex">
                                To <select name="yearTo" id="yearTo" style="margin-left:1%" onchange="addMonthsToSelectBoxes(this)">';
                                if(isset($data['toyearandmonth'])){
                                    echo'<option value="" disabled >Year</option>';
                                    $tag='';
                                        for ($i=intval($data['joineddate'][0]); $i < intval($data['currentdate'][0])+1; $i++) { 
                                            if(intval($data['toyearandmonth'][0])==$i){
                                                $tag.='<option value="'.$i.'"selected>'.$i.'</option>';
                                            }else{
                                                $tag.='<option value="'.$i.'">'.$i.'</option>';
                                            }
                                            //$tag.='<option value="'.$i.'">'.$i.'</option>';
                                        }
                                        $tag.='</select>';
                                        echo $tag;

                                    }else{
                                        echo'<option value="" disabled selected>Year</option></select>';
                                    }
                                
                                echo'
                                <select name="monthTo" id="monthTo">';
                                    if(isset($data['currentdate'])){
                                        echo'<option value="" disabled >Month</option>';
                                        $tag='';
                                        $to=0;
                                        if(intval($data['toyearandmonth'][0])==intval($data['currentdate'][0])){
                                            $to=intval($data['currentdate'][1])+1;
                                        }else{
                                            $to=13;
                                        }
                                        for ($i=(intval($data['joineddate'][0])==intval($data['toyearandmonth'][0]))?intval($data['joineddate'][1]):1; $i <$to ; $i++) { 
                                            if($i==$data['toyearandmonth'][1]){
                                                $tag.='<option value="'.$i.'"selected>'.$i.'</option>';
                                            }else{
                                                $tag.='<option value="'.$i.'">'.$i.'</option>';
                                            }
                                        }
                                        $tag.='</select>';
                                        echo $tag;

                                    }else{
                                        echo'<option value="" disabled selected>Month</option>
                                        </select>';
                                    }
                                echo'</select>
                            </div>
                            <div class="selectBox" style="width:40%;height:100%;background-color:white;margin-right:2%;align-content:center;align-items:center;justify-content:center;display:flex" onClick="showCharts()">
                                <input type="submit" name="sub" value="View" style="font-family:poppins" class="getAnalysisButton">
                            </div></form>';                                     
                    //echo'</div>';
                    echo'
                </div>
                <div class="AnalysisContainer" style="display:flex;width:100%;height:90%">
                    <div class="leftAnalysis" style="width:50%;height:100%">';
                    if(isset($data['barChart'])){
                        echo'<h4 style="margin-left:5%">Total Deliveries</h4>';
                    }
                    
                        echo'<div class="barChart" id="barChart" style="width:100%;display:flex;align-content:center;align-items:center;justify-content:center">';
                            if(isset($data['barChart'])){
                                
                                $chart['vector']=$data['barChart']['values'];
                                $chart['labels']=$data['barChart']['dates'];
                                $chart['color']=$data['barColor'];
                                $chart['y']='Deliveries';
                                $chart = new Chart('bar',$chart,1);
                            }
                            
                        echo'</div>';
                        if(isset($data['lineChart'])){
                            echo'<h4 style="margin-left:5%">Total Revenue</h4>';
                        }
                        
                        echo'<div class="lineChart" style="width:100%;display:flex;align-content:center;align-items:center;justify-content:center">';
                           if(isset($data['lineChart'])){
                                $chart_3['vector']=$data['lineChart']['values'];
                                $chart_3['labels']=$data['lineChart']['names'];
                                $chart_3['color']="rgba(30, 105, 176, 1)";
                                $chart_3['y']='Revenue';
                                $chart_3 = new Chart('line',$chart_3,4);     
                           }
                                    
                        echo'</div>
                    </div>';
                    if(isset($data['lineChart'])){
                        echo'<h4 style="margin-left:5%">Sold stock</h4>';
                    }
                    
                    echo'<div class="rightAnalysis" style="margin-top:1%;width:50%;height:100%;display:flex;align-content:center;align-items:center;justify-content:center">';
                            if(isset($data['doughNut'])){
                                $chart_2['vector']=$data['doughNut']['values'];
                                $chart_2['labels']=$data['doughNut']['products'];
                                $chart_2['color']=$data['doughnutColors'];
                                $chart_2['y']='Stock sold';
                                $chart_2['main']="fgdff";
                                $chart_2 = new Chart('doughnut',$chart_2,3);
                            }
                    
                    
                    
                    echo'</div>
                
                
                </div>
                
            </div>';     
        echo ' 
        </section>';
    }
    function companyReports($data){
        $arr = json_encode($data);
        echo 
        '<section class="body-content" >
            <div class="Distributor_table_name" id="Distributor_table_name" style="margin:0;margin-left:-1.5%">
            <a href="../Compny/reports" style="width:97%" ><div class="DealerTableTopics" style="width:100%;height:100%;background-color:#d8ca30;color:white">Reports</div></a>
            </div>';
            echo'<div class="DealerTables" id="DealerTables" style="height:80%;margin:0">';
            echo'<div class="selectBoxes" style="width:100%;height:10%;display:flex;flex-direction:row;margin-top:1%">
                <form action="'. BASEURL.'/Compny/companyReports" enctype="multipart/form-data" method="POST" style="display:flex;flex-direction:row;width:100%">
                <div class="selectBox" style="width:20%;height:100%;background-color:white;margin-right:2%;margin-left:5%">';
                if(isset($data['distNames']) && isset($data['currentdistributor'])){
                    $result=$data['distNames'];
                    echo'<select name="distNames" id="distNames" onchange="addYearsToSelectBoxes(this)">
                    <option value="" disabled >Select distributor</option>';
                    $tag='';
                    foreach ($result as $row) {
                        if($row['id']==$data['currentdistributor']){
                            $tag.='<option value="'.$row['id'].'" key="'.$row['names'].'" selected>'.$row['names'].'</option>';
                        }else{
                            $tag.='<option value="'.$row['id'].'" key="'.$row['names'].'">'.$row['names'].'</option>';
                        }
                    }
                    $tag.='</select></div>';
                    echo $tag;
                }else if(isset($data['distNames'])){
                    $result=$data['distNames'];
                    echo'<select name="distNames" id="distNames" onchange="addYearsToSelectBoxes(this)">
                    <option value="" disabled selected>Select distributor</option>';
                    $tag='';
                    foreach ($result as $row) {
                        $tag.='<option value="'.$row['id'].'" key="'.$row['names'].'">'.$row['names'].'</option>';
                        
                    }
                    $tag.='</select></div>';
                    echo $tag;
                }
                echo'<div class="selectBox" style="width:40%;height:100%;background-color:white;margin-right:2%;align-content:center;align-items:center;justify-content:center;display:flex">
                        From<select name="yearFrom" id="yearFrom" style="margin-left:1%" onchange="addMonthsToSelectBoxes(this)">';
                            if(isset($data['joineddate'])){
                                echo'<option value="" disabled >Year</option>';
                                $tag='';
                                for ($i=intval($data['joineddate'][0]); $i < intval($data['currentdate'][0])+1; $i++) { 
                                    if(intval($data['fromyearandmonth'][0])==$i){
                                        $tag.='<option value="'.$i.'"selected>'.$i.'</option>';
                                    }else{
                                        $tag.='<option value="'.$i.'">'.$i.'</option>';
                                    }
                                    //$tag.='<option value="'.$i.'">'.$i.'</option>';
                                }
                                $tag.='</select>';
                                echo $tag;

                            }else{
                                echo'<option value="" disabled selected>Year</option></select>';
                            }
                        echo'<select name="monthFrom" id="monthFrom">';
                        if(isset($data['currentdate'])){
                            echo'<option value="" disabled >Month</option>';
                            $tag='';
                            $to=0;
                            if(intval($data['fromyearandmonth'][0])==intval($data['currentdate'][0])){
                                $to=intval($data['currentdate'][1])+1;
                            }else{
                                $to=13;
                            }
                            for ($i=(intval($data['joineddate'][0])==intval($data['fromyearandmonth'][0]))?intval($data['joineddate'][1]):1; $i <$to ; $i++) { 
                                if($i==$data['fromyearandmonth'][1]){
                                    $tag.='<option value="'.$i.'"selected>'.$i.'</option>';
                                }else{
                                    $tag.='<option value="'.$i.'">'.$i.'</option>';
                                }
                            }
                            $tag.='</select>';
                            echo $tag;

                        }else{
                            echo'<option value="" disabled selected>Month</option>
                            </select>';
                        }
                    echo'
                    </div>
                    <div class="selectBox" style="width:40%;height:100%;background-color:white;margin-right:2%;align-content:center;align-items:center;justify-content:center;display:flex">
                        To <select name="yearTo" id="yearTo" style="margin-left:1%" onchange="addMonthsToSelectBoxes(this)">';
                        if(isset($data['toyearandmonth'])){
                            echo'<option value="" disabled >Year</option>';
                            $tag='';
                                for ($i=intval($data['joineddate'][0]); $i < intval($data['currentdate'][0])+1; $i++) { 
                                    if(intval($data['toyearandmonth'][0])==$i){
                                        $tag.='<option value="'.$i.'"selected>'.$i.'</option>';
                                    }else{
                                        $tag.='<option value="'.$i.'">'.$i.'</option>';
                                    }
                                    //$tag.='<option value="'.$i.'">'.$i.'</option>';
                                }
                                $tag.='</select>';
                                echo $tag;

                            }else{
                                echo'<option value="" disabled selected>Year</option></select>';
                            }
                        
                        echo'
                        <select name="monthTo" id="monthTo">';
                            if(isset($data['currentdate'])){
                                echo'<option value="" disabled >Month</option>';
                                $tag='';
                                $to=0;
                                if(intval($data['toyearandmonth'][0])==intval($data['currentdate'][0])){
                                    $to=intval($data['currentdate'][1])+1;
                                }else{
                                    $to=13;
                                }
                                for ($i=(intval($data['joineddate'][0])==intval($data['toyearandmonth'][0]))?intval($data['joineddate'][1]):1; $i <$to ; $i++) { 
                                    if($i==$data['toyearandmonth'][1]){
                                        $tag.='<option value="'.$i.'"selected>'.$i.'</option>';
                                    }else{
                                        $tag.='<option value="'.$i.'">'.$i.'</option>';
                                    }
                                }
                                $tag.='</select>';
                                echo $tag;

                            }else{
                                echo'<option value="" disabled selected>Month</option>
                                </select>';
                            }
                        echo'</select>
                    </div>
                    <div class="selectBox" style="width:40%;height:100%;background-color:white;margin-right:2%;align-content:center;align-items:center;justify-content:center;display:flex" onClick="showCharts()">
                        <input type="submit" name="sub" value="View" class="getAnalysisButton">
                    </div></form>';                                     
            //echo'</div>';
                    echo'
                </div>
            <table class="styled-table" id="reporttable">
                <thead>
                    <tr>
                        <th>Product name</th>
                        <th style="text-align:center">Unit price (Rs.)</th>
                        <th style="text-align:center">Quantity</th>
                        <th style="text-align:right">Total (Rs.)</th>
                    </tr>
                </thead>';
                if(isset($data['products'])){
                    echo'<tbody>';
                    //print_r($data['products']) ;
                    $result=$data['products'];
                    $tag="";
                    $sum=0;
                    foreach($result as $key=>$value){
                        $tag.='<tr>
                        <td >'.$key.'</td>
                        <td style="text-align:center">'.$value[0].'</td>
                        <td style="text-align:center">'.$value[1].'</td>
                        <td style="text-align:right" >'.number_format($value[0]*$value[1],2).'</td>
                        </tr>';
                        $sum+=$value[0]*$value[1];
                    }
                    $tag.='<tr>
                    <td ></td>
                    <td ></td>
                    <td ></td>
                    <td style="text-align:right" >'.number_format($sum,2).'</td>
                    </tr>';
                    echo $tag;
                    echo'</tbody>';

                }    
            echo '</table>';
            echo'</div>'; 
            echo'<div style="display:flex;align-items:center;align-content:center;justify-content:center;margin-top:-5%">';
            echo'<div style="height:130%;width:20%;display:flex;align-items:center;align-content:center;justify-content:center;border-radius:10px;color:white;" onClick="submitReport()" class="generatePDF">';
            //echo'<a href="../Reports/salesCompany">Generate PDF</a></div>';
            echo'Generate Report</div>';
            
            echo'</div>';
           
        echo'</section>';
    }
    function reportsCompany(){
        $pdf = new FPDF('P','mm','A4');
        $pdf->SetAutoPageBreak(true,10);
        $pdf->SetMargins(23,24,23);
        $pdf->AddPage();
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(0,5,'Gasify (Pvt,Ltd)',0,1,'C');
        $pdf->SetFont('Times', 'B', 16);
        $pdf->Cell(0,5,'Sales Report',0,1,'C');
        $pdf->Ln(20);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(30,5,'Dealer ID',0,0,'l');
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(90,5,": {dealer_id}",0,0,'l');
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(20,5,'Time',0,0,'l');
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(0,5,": {time}",0,1,'l');
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(30,5,'Business Name',0,0,'l');
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(90,5,": {business_name}",0,0,'l');
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(20,5,'Date',0,0,'l');
        $pdf->SetFont('Times', '', 12);
        $pdf->Cell(0,5,": {date}",0,1,'l');
        $pdf->Ln(10);
        $pdf->SetFont('Times', 'B', 12);
        $pdf->Cell(25,5,'Product ID',0,0,'L');
        $pdf->Cell(30,5,'Product Name',0,0,'L');
        $pdf->Cell(38,5,'Sold Quantity',0,0,'C');
        $pdf->Cell(38,5,'Total Amount (Rs)',0,0,'R');
        $pdf->Cell(33,5,'Percentage',0,0,'R');
        $pdf->Ln();
        $pdf->Ln();
        $pdf->SetFont('Times', '', 12);
        $x = $pdf->GetX();
        $y = $pdf->GetY();
        $pdf->Line($x, $y, $x+165, $y);
        $pdf->Ln();
        $pdf->Cell(60,5,'Total',0,0,'R');
        $pdf->Ln();
        $x = $pdf->GetX();
        $y = $pdf->GetY();
        $pdf->Line($x, $y, $x+165, $y);
        $pdf->Ln(1);
        $x = $pdf->GetX();
        $y = $pdf->GetY();
        $pdf->Line($x, $y, $x+165, $y);
        $pdf->Output();

    }
    function deliveryReports($data){
        echo 
        '<section class="body-content">
            <div class="Distributor_table_name" id="Distributor_table_name" style="margin:0;margin-left:-1.5%">
            <a href="../Compny/analysis" style="width:97%" ><div class="DealerTableTopics" style="width:100%;height:100%;background-color:#2d77bc;color:white">Analysis</div></a>
            </div>';
            echo'<div class="DealerTables" id="DealerTables" style="height:90%;margin:0; display:flex; flex-direction:row;">
            
                <div class="analysis_top" style="flex-direction:column;">
                    <div class="graph" style="width:500px; padding:20px;">
                        <h4>Last Week</h4>';
                        $chart['vector']=[12,18,23,15,17];
                        $chart['labels']=['Mon','Tue','Wed','Thu','Fri'];
                        $chart['color']="rgba(30, 105, 176, 1)";
                        $chart['y']='Deliveries-Last week';
                        $chart = new Chart('bar',$chart,1);                    
                    echo'</div>
                    <div class="graph" style="width:500px; padding:20px;">
                    <h4>Last Week Revenue</h4>';
                        $chart_3['vector']=[5500,3250,4800,4130,3900];
                        $chart_3['labels']=['Mon','Tue','Wed','Thu','Fri'];
                        $chart_3['color']="rgba(30, 105, 176, 1)";
                        $chart_3['y']='Revenue-Last week(Rs)';
                        $chart_3 = new Chart('line',$chart_3,4);                    
                    echo'</div>
                </div>
                <div class="analysis_bottom">
                    <div class="graph" style="height: 70vh; padding:20px; width:500px;">
                        <h4>Last Month</h4>';
                            $chart_2['vector']=array(20,80);
                            $chart_2['labels']=array('Canceled','Delivered');
                            $chart_2['color']='["red","rgba(30, 105, 176, 1)","rgba(23, 45, 89, 1)"]';
                            $chart_2['y']='Last month deliveries';
                            $chart_2['main']="fgdff";
                            $chart_2 = new Chart('doughnut',$chart_2,3);
                    echo'</div>
     
                </div>  
            </div>';     
        echo ' 
        </section>';
    }
    function issuedOrdersCompany($data){
        echo 
        '<section class="body-content">
            <div class="Distributor_table_name" id="Distributor_table_name" style="margin:0;margin-left:-1.5%">
            <a href="../Compny/orders" style="width:24.25%" ><div class="DealerTableTopics" style="width:100%;height:100%">Gas Orders</div></a>
            <a href="../Compny/issuedOrders" style="width:24.25%" ><div class="DealerTableTopics"  style="width:100%;height:100%;border-right:0px;background-color:#d8ca30;color:white">Issued Orders</div></a>
            <a href="../Compny/delayedOrders" style="width:24.25%" ><div class="DealerTableTopics"  style="width:100%;height:100%;border-right:0px">Delayed Orders</div></a>
            <a href="../Compny/limitquota" style="width:24.25%" ><div class="DealerTableTopics"  style="width:100%;height:100%">Limit Quota</div></a>
            </div>';
            if (isset($data['order_details'])){
                echo'<div class="DealerTables" id="DealerTables" style="height:80%;margin:0">';
                $result = $data["order_details"];
                $product_array=$data['product_details'];
                $orders='';
                $processedOrders=array();
                $orderID='';
                $distName='';
                $placedDate='';
                $placedTime='';
                foreach ($result as $row) {
                    $orderID=$row['stock_req_id'];
                    $imgIndex=1;
                    $imgCount=0;
                    $distName=$row['first_name'].' '.$row['last_name'];
                    $placedDate=$row['place_date'];
                    $placedTime=$row['place_time'];
                    $productIDlist='';
                    $isEnabled=true;
                    foreach($result as $row_1){
                        if($row_1['stock_req_id']==$orderID){
                            $productIDlist.=$row_1['product_id'].' ';
                            $imgCount+=1;
                        }
                        
                    }
                    if(!in_array($orderID,$processedOrders)){
                    $orders .=  '<div class="orderCard" >
                    <div class="orderRow">
                        <div class="orderColumn"><label style="margin-left: 2%;">Order ID :</label><label id="'.$orderID.'issued" value="'.$orderID.'">'.$orderID.'</label></div>
                        <div class="orderColumn"><label style="margin-left: 2%;">Distributor Name :</label><label id="'.$orderID.'dist" value="'.$distName.'">'.$distName.'</label></div>
                    </div>
                    <div class="orderRow">
                        <div class="orderColumn"><label style="margin-left: 2%;">Placed Date :</label><label id="'.$orderID.'placedDate" value="'.$placedDate.'">'.$placedDate.'</label></div>
                        <div class="orderColumn"><label style="margin-left: 2%;">Placed Time :</label><label id="'.$orderID.'placedTime" value="'.$placedTime.'">'.$placedTime.'</label></div>
                    </div>
                    <div class="orderTbl" style="height:45%">
                        <table class="styled-table" id="'.$orderID.'table">
                            <thead>
                                <tr>
                                    <th>Product name</th>
                                    <th style="text-align:center">Unit price (Rs.)</th>
                                    <th style="text-align:center">Quantity</th>
                                    <th style="text-align:end">Total (Rs.)</th>
                                </tr>
                            </thead>
                            <tbody style="display:legacy">';
                            $total=0;
                            foreach ($result as $row_2) {
                                if ($row_2['stock_req_id']==$orderID) {
                                    foreach ($product_array as $row_3) {
                                        if($row_3['product_id']==$row_2['product_id']){
                                        $orders.='<tr>
                                        <td>'.$row_3['name'].'</td>
                                            <td style="text-align:center">'.number_format($row_2['unit_price'],2).'</td>
                                            <td style="text-align:center">'.$row_2['quantity'].'</td>';
                                            $orders.='<td id="'.$row_2['product_id']."3".'" style="text-align:end">'.number_format($row_2['unit_price']*$row_2['quantity'],2).'</td>
                                        </tr>';
                                        $total+=$row_2['unit_price']*$row_2['quantity'];
                                        $imgIndex+=1;
                                        }
                                    }
                                }
        
                            }
                    array_push($processedOrders,$orderID);

                    $orders.='</tbody>      
                    </table>
                    </div>';
                    $orders.='<div class="orderRow" style="height:8%">
                        <div class="orderColumn" style="display:flex;"><div style="min-width:46%;color:white;background-color:var(--table-header);margin-left:1%;height:100%;display:flex;align-items:center;justify-content:center;border-radius:10px" ><label style="color:white"> Net Total (Rs):</label><label style="color:white" id="'.$orderID.'total" value='.$total.'>'.' '.number_format($total,2).'</label></div></div>
                    </div>
                    <div class="orderRow" style="height:8%">
                        <div class="orderColumn" style="width:100%;display:flex;align-items:center;justify-content:center"><div class="getAnalysisButton" style="width:20%;display:flex;align-items:center;justify-content:center" onClick="issueReport('.$orderID.')">Generate Report</div></div>
                    </div>
                    </div>';
                    }
                }
                echo $orders;
                echo ' 
                </div>
                </section>';



            }else{
                echo '<div class="DealerTables" id="DealerTables" style="margin:0;display:flex;justify-content:center">';
                echo'<img src="../img/placeholders/2.png" style="width: 40%;height: 70%;">';
                echo '</div></section>';
            }
    }
    function delayOrdersCompany($data){
        echo 
        '<section class="body-content">
            <div class="Distributor_table_name" id="Distributor_table_name" style="margin:0;margin-left:-1.5%">
            <a href="../Compny/orders" style="width:24.25%" ><div class="DealerTableTopics" style="width:100%;height:100%;border-right:0px">Gas Orders</div></a>
            <a href="../Compny/issuedOrders" style="width:24.25%" ><div class="DealerTableTopics"  style="width:100%;height:100%;border-right:0px">Issued Orders</div></a>
            <a href="../Compny/delayedOrders" style="width:24.25%" ><div class="DealerTableTopics"  style="width:100%;height:100%;border-right:0px;background-color:#d8ca30;color:white">Delayed Orders</div></a>
            <a href="../Compny/limitquota" style="width:24.25%" ><div class="DealerTableTopics"  style="width:100%;height:100%">Limit Quota</div></a>
            </div>';
            if (isset($data['order_details'])){
                echo'<div class="DealerTables" id="DealerTables" style="height:80%;margin:0">';
                $result = $data["order_details"];
                $product_array=$data['product_details'];
                $orders='';
                $processedOrders=array();
                $orderID='';
                $distName='';
                $placedDate='';
                $placedTime='';
                foreach ($result as $row) {
                    $orderID=$row['stock_req_id'];
                    $imgIndex=1;
                    $imgCount=0;
                    $distName=$row['first_name'].' '.$row['last_name'];
                    $placedDate=$row['place_date'];
                    $placedTime=$row['place_time'];
                    $productIDlist='';
                    $isEnabled=true;
                    foreach($result as $row_1){
                        if($row_1['stock_req_id']==$orderID){
                            $productIDlist.=$row_1['product_id'].' ';
                            $imgCount+=1;
                        }
                        
                    }
                    if(!in_array($orderID,$processedOrders)){
                    $orders .=  '<div class="orderCard" >
                    <div class="orderRow">
                        <div class="orderColumn"><label style="margin-left: 2%;">Order ID :</label>'.$orderID.'</div>
                        <div class="orderColumn"><label style="margin-left: 2%;">Distributor Name :</label>'.$distName.'</div>
                    </div>
                    <div class="orderRow">
                        <div class="orderColumn"><label style="margin-left: 2%;">Placed Date :</label>'.$placedDate.'</div>
                        <div class="orderColumn"><label style="margin-left: 2%;">Placed Time :</label>'.$placedTime.'</div>
                    </div>
                    <div class="orderTbl">
                        <table class="styled-table">
                            <thead>
                                <tr>
                                    <th>Product name</th>
                                    <th style="text-align:center">Unit price (Rs.)</th>
                                    <th style="text-align:center">Quantity</th>
                                    <th style="text-align:center">Status</th>
                                    <th style="text-align:end">Total (Rs.)</th>
                                </tr>
                            </thead>
                            <tbody style="display:legacy">';
                            $total=0;
                            foreach ($result as $row_2) {
                                if ($row_2['stock_req_id']==$orderID) {
                                    foreach ($product_array as $row_3) {
                                        if($row_3['product_id']==$row_2['product_id']){
                                        $orders.='<tr>
                                        <td>'.$row_3['name'].'</td>
                                            <td style="text-align:center">'.number_format($row_2['unit_price'],2).'</td>
                                            <td style="text-align:center"><input type="number" class="qtyInput" value="'.$row_2['quantity'].'" id="'.$orderID.$imgIndex."1".'" key="'.$row_3['product_id'].'"';
                                            if($row_2['quantity']<$row_3['quantity']){
                                                $orders.='disabled></td>';
                                                $orders.='<td style="text-align:center"><img src='.BASEURL.'/public/icons/check.png'.' width="32px" height="32px" id="'.$orderID.$imgIndex."2".'"></td>';
                                            }else{
                                                $isEnabled=false;
                                                $orders.=' oninput="changeOrderDetails('.$imgIndex.','.$imgCount.','.$orderID.','.$row_2['product_id'].','.$row_2['unit_price'].','.$row_3['quantity'].','.$row_2['stock_req_id'].',\''.$productIDlist.'\')"></td>';
                                                //$orders.=' oninput="changeOrderDetails(\''.$productIDlist.'\')"></td>';
                                                $orders.='<td style="text-align:center"><img src='.BASEURL.'/public/icons/warning.png'.' width="32px" height="32px" title="Current Stock is '.$row_3['quantity'].' Cylinders" id="'.$orderID.$imgIndex."2".'"></td>';
                                            }
                                            
                                            $orders.='<td id="'.$orderID.$row_2['product_id']."3".'" value='.$row_2['unit_price']*$row_2['quantity'].' style="text-align:end">'.number_format($row_2['unit_price']*$row_2['quantity'],2).'</td>
                                        </tr>';
                                        $total+=$row_2['unit_price']*$row_2['quantity'];
                                        $imgIndex+=1;
                                        }
                                    }
                                }
        
                            }
                    array_push($processedOrders,$orderID);

                    $orders.='</tbody>      
                    </table>
                    </div>
                    <div class="orderRow" style="height:8%">
                        <div class="orderColumn" style="display:flex;"><div style="min-width:46%;color:white;background-color:var(--table-header);margin-left:1%;height:100%;display:flex;align-items:center;justify-content:center;border-radius:10px" ><label style="color:white"> Net Total (Rs):</label><label style="color:white" id="'.$orderID.'total" value='.$total.'>'.' '.number_format($total,2).'</label></div></div>
                    </div>
                        <div class="orderRow">';
                    
                        if($isEnabled){
                            $orders.='<div class="orderButtons" style="margin-left:28.5%;background-color:dodgerblue" onClick="issueOrder(this)" key="'.$orderID.'" id="'.$orderID.'issue"><label>Issue</label></div>';
                        }else{
                            $orders.='<div class="orderButtons" style="margin-left:28.5%;pointer-events:none" onClick="issueOrder(this)" key="'.$orderID.'" id="'.$orderID.'issue"><label>Issue</label></div>';
                        }
                         $orders.='   
                        </div>
                    </div>';
                    }
                }
                echo $orders;
                echo ' 
                
                </div>
                </section>';



            }else{
                echo '<div class="DealerTables" id="DealerTables" style="margin:0;display:flex;justify-content:center">';
                echo'<img src="../img/placeholders/2.png" style="width: 40%;height: 70%;">';
                echo '</div></section>';
            }
            
    }
    function deliveryAnalysis($data){
        echo 
        '<section class="body-content">
            <div class="Distributor_table_name" id="Distributor_table_name" style="margin:0;margin-left:-1.5%">
            <a href="../Delvery/analysis" style="width:97%" ><div class="DealerTableTopics" style="width:100%;height:100%;background-color:#2d77bc;color:white">Analysis</div></a>
            </div>';
            echo'<div class="DealerTables" id="DealerTables" style="height:90%;margin:0;">'; 
                echo'<div class="selectBoxes" style="width:100%;height:10%;display:flex;flex-direction:row;margin-top:1%">
                <form action="'. BASEURL.'/Delvery/getCharts" enctype="multipart/form-data" method="POST" style="display:flex;flex-direction:row;width:100%">
                <div class="selectBox" style="width:40%;height:100%;background-color:white;margin-right:2%;align-content:center;align-items:center;justify-content:center;display:flex">
                From<select name="yearFrom" id="yearFrom" style="margin-left:1%" onchange="addMonthsToSelectBoxes(this,'.intval($data['joinedDate'][0]).','.intval($data['joinedDate'][1]).')">';
                    if(isset($data['joinedDate'])){
                        echo'<option value="" disabled selected >Year</option>';
                        $tag='';
                        for ($i=intval($data['joinedDate'][0]); $i < intval($data['currentDate'][0])+1; $i++) { 
                            
                            if($i==intval($data['joinedDate'][0])){
                                $tag.='<option value="'.$i.'" >'.$i.'</option>';
                            }else{
                                $tag.='<option value="'.$i.'" >'.$i.'</option>';
                            }
                                
                            
                            //$tag.='<option value="'.$i.'">'.$i.'</option>';
                        }
                        $tag.='</select>';
                        echo $tag;

                    }else{
                        echo'<option value="" disabled selected>Year</option></select>';
                    }
                echo'<select name="monthFrom" id="monthFrom">';
                if(isset($data['currentdate'])){
                    echo'<option value="" disabled >Month</option>';
                    $tag='';
                    $to=0;
                    if(intval($data['fromyearandmonth'][0])==intval($data['currentdate'][0])){
                        $to=intval($data['currentdate'][1])+1;
                    }else{
                        $to=13;
                    }
                    for ($i=(intval($data['joineddate'][0])==intval($data['fromyearandmonth'][0]))?intval($data['joineddate'][1]):1; $i <$to ; $i++) { 
                        if($i==$data['fromyearandmonth'][1]){
                            $tag.='<option value="'.$i.'"selected>'.$i.'</option>';
                        }else{
                            $tag.='<option value="'.$i.'">'.$i.'</option>';
                        }
                    }
                    $tag.='</select>';
                    echo $tag;

                }else{
                    echo'<option value="" disabled selected>Month</option>
                    </select>';
                }
            echo'
            </div>
            <div class="selectBox" style="width:40%;height:100%;background-color:white;margin-right:2%;align-content:center;align-items:center;justify-content:center;display:flex">
                To <select name="yearTo" id="yearTo" style="margin-left:1%" onchange="addMonthsToSelectBoxes(this,'.intval($data['joinedDate'][0]).','.intval($data['joinedDate'][1]).')">';
                if(isset($data['joinedDate'])){
                    echo'<option value="" disabled selected>Year</option>';
                    $tag='';
                        for ($i=intval($data['joinedDate'][0]); $i < intval($data['currentDate'][0])+1; $i++) { 
                            if($i==intval($data['joinedDate'][0])){
                                $tag.='<option value="'.$i.'" >'.$i.'</option>';
                            }else{
                                $tag.='<option value="'.$i.'" >'.$i.'</option>';
                            }
                            //$tag.='<option value="'.$i.'">'.$i.'</option>';
                        }
                        $tag.='</select>';
                        echo $tag;

                    }else{
                        echo'<option value="" disabled selected>Year</option></select>';
                    }
                
                echo'
                <select name="monthTo" id="monthTo">';
                    if(isset($data['currentdate'])){
                        echo'<option value="" disabled >Month</option>';
                        $tag='';
                        $to=0;
                        if(intval($data['toyearandmonth'][0])==intval($data['currentdate'][0])){
                            $to=intval($data['currentdate'][1])+1;
                        }else{
                            $to=13;
                        }
                        for ($i=(intval($data['joineddate'][0])==intval($data['toyearandmonth'][0]))?intval($data['joineddate'][1]):1; $i <$to ; $i++) { 
                            if($i==$data['toyearandmonth'][1]){
                                $tag.='<option value="'.$i.'"selected>'.$i.'</option>';
                            }else{
                                $tag.='<option value="'.$i.'">'.$i.'</option>';
                            }
                        }
                        $tag.='</select>';
                        echo $tag;

                    }else{
                        echo'<option value="" disabled selected>Month</option>
                        </select>';
                    }
                echo'</select>
            </div>
            <div class="selectBox" style="width:40%;height:100%;background-color:white;margin-right:2%;align-content:center;align-items:center;justify-content:center;display:flex" onClick="showCharts()">
                <input type="submit" name="sub" value="Submit" style="font-family:poppins" class="getAnalysisButton">
            </div></form></div>'; 
            echo'<div class="AnalysisContainer" style="display:flex;width:100%;height:90%">
                    <div class="leftAnalysis" style="width:50%;height:100%">';
                    if(isset($data['barChart'])){
                        echo'<h4 style="margin-left:5%">Total Deliveries</h4>';
                    }
                    
                        echo'<div class="barChart" id="barChart" style="height:50%;width:100%;display:flex;align-content:center;align-items:center;justify-content:center">';
                        if(isset($data['barChart'])){
                                
                            $chart['vector']=$data['barChart']['values'];
                            $chart['labels']=$data['barChart']['dates'];
                            $chart['color']=$data['barColor'];
                            $chart['y']='Deliveries';
                            $chart = new Chart('bar',$chart,1);
                        } 
                            
                        echo'</div>';
                        if(isset($data['lineChart'])){
                            echo'<h4 style="margin-left:5%">Total Revenue</h4>';
                        }
                        
                        echo'<div class="lineChart" style="height:50%;width:100%;display:flex;align-content:center;align-items:center;justify-content:center">';
                        if(isset($data['lineChart'])){
                            $chart_3['vector']=$data['lineChart']['values'];
                            $chart_3['labels']=$data['lineChart']['names'];
                            $chart_3['color']="rgba(30, 105, 176, 1)";
                            $chart_3['y']='Revenue (Rs)';
                            $chart_3 = new Chart('line',$chart_3,4);
                        }
                        
                                    
                        echo'</div>
                    </div>';
                    if(isset($data['doughNut'])){
                        echo'<h4 style="margin-left:5%">Delivered quantity</h4>';
                    }
                    
                    echo'<div class="rightAnalysis" style="margin-top:1%;width:50%;height:100%;display:flex;align-content:center;align-items:center;justify-content:center">';
                    if(isset($data['doughNut'])){
                        $chart_2['vector']=$data['doughNut']['values'];
                        $chart_2['labels']=$data['doughNut']['products'];
                        $chart_2['color']='["red","rgba(30, 105, 176, 1)","rgba(23, 45, 89, 1)"]';
                        $chart_2['y']='Delivered';
                        $chart_2['main']="fgdff";
                        $chart_2 = new Chart('doughnut',$chart_2,3);
                    }
                    
                    
                    
                    
                    echo'</div>
                
                
                </div>';
                

        echo ' 
        </section>';
    }
}
