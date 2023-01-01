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
                                <form action="#">
                                    <select id="period" onchange="updatechart()" class="dropdowndate">
                                        <option value="today" selected>To day</option>
                                        <option  value="30day">Last 30 days</option>
                                    </select>
                                </form>
                            </div>
                            <div class="tiles">
                                <div class="tile">
                                    <h1>12</h1>
                                    <p>Orders Recieved</p>
                                </div>
                                <div class="tile">
                                    <h1>08</h1>
                                    <p>Pending Orders</p>
                                </div>
                                <div class="tile">
                                    <h1>03</h1>
                                    <p>Canceled Orders</p>
                                </div>
                            </div>
                            <div class="chart">';
                                $chart = new Chart("dealerordersanalytic");
                        echo    '</div>
                        </div>
                        <table class="table">
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
                            
                                if(isset($data["pending"])){
                                    $results = $data["pending"];
                                    foreach($results as $result){
                                        $newpending = new NewOrder($result);
                                    }

                                    echo "<script>
                                            let accordion = document.querySelectorAll('.accordion .box');
                                            for(i=0; i<accordion.length; i++) {
                                                accordion[i].addEventListener('click', function(){
                                                    this.classList.toggle('active')
                                                })
                                            }
                                        </script>";
                                }else{
                                    echo "No pending orders";
                                }
                            
                        echo '</div>
                        <div class="accordion dispatched">
                            <h3>Deliveries</h3>
                            <div class="box">
                                <div class="label">Order ID : 1
                                    <svg class="img" width="30" height="16" viewBox="0 0 35 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M17.7514 15.8985C17.1825 15.8993 16.6312 15.7201 16.1932 15.3918L1.58692 4.38418C1.08977 4.01049 0.777187 3.47366 0.717923 2.89179C0.65866 2.30991 0.857574 1.73066 1.27091 1.28145C1.68424 0.832243 2.27813 0.54988 2.92193 0.496478C3.56574 0.443076 4.20671 0.623009 4.70385 0.996694L17.7522 10.8596L30.8036 1.35865C31.0527 1.17596 31.3392 1.03958 31.6468 0.957326C31.9545 0.875077 32.277 0.848587 32.596 0.87938C32.915 0.910173 33.2242 0.99764 33.5057 1.13676C33.7872 1.27587 34.0356 1.46389 34.2364 1.69001C34.4594 1.91635 34.6282 2.18184 34.7323 2.46986C34.8365 2.75788 34.8737 3.06221 34.8416 3.3638C34.8096 3.66538 34.709 3.95772 34.5461 4.2225C34.3832 4.48727 34.1616 4.71878 33.8951 4.90251L19.2853 15.525C18.8346 15.8011 18.2945 15.9326 17.7514 15.8985Z" fill="#F9896B"/>
                                    </svg>
                                </div>
                                <div class="content">
                                    <span><strong>Customer ID :</strong> 11</span> &nbsp;
                                    <span><strong>Customer Name :</strong> Kamal Abeynayake</span><br>
                                    <span><strong>Delivery Person ID :</strong> 11</span> &nbsp;
                                    <span><strong>Delivery Person Name :</strong> Kamal Abeynayake</span>
                                    <hr>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Buddy</td>
                                                <td>1</td>
                                            </tr>
                                            <tr>
                                                <td>Budget</td>
                                                <td>2</td>
                                            </tr>
                                            <tr>
                                                <td>Regular</td>
                                                <td>3</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="box">
                                <div class="label">Order ID : 1
                                    <svg class="img" width="30" height="16" viewBox="0 0 35 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M17.7514 15.8985C17.1825 15.8993 16.6312 15.7201 16.1932 15.3918L1.58692 4.38418C1.08977 4.01049 0.777187 3.47366 0.717923 2.89179C0.65866 2.30991 0.857574 1.73066 1.27091 1.28145C1.68424 0.832243 2.27813 0.54988 2.92193 0.496478C3.56574 0.443076 4.20671 0.623009 4.70385 0.996694L17.7522 10.8596L30.8036 1.35865C31.0527 1.17596 31.3392 1.03958 31.6468 0.957326C31.9545 0.875077 32.277 0.848587 32.596 0.87938C32.915 0.910173 33.2242 0.99764 33.5057 1.13676C33.7872 1.27587 34.0356 1.46389 34.2364 1.69001C34.4594 1.91635 34.6282 2.18184 34.7323 2.46986C34.8365 2.75788 34.8737 3.06221 34.8416 3.3638C34.8096 3.66538 34.709 3.95772 34.5461 4.2225C34.3832 4.48727 34.1616 4.71878 33.8951 4.90251L19.2853 15.525C18.8346 15.8011 18.2945 15.9326 17.7514 15.8985Z" fill="#F9896B"/>
                                    </svg>
                                </div>
                                <div class="content">
                                    <span><strong>Customer ID :</strong> 11</span> &nbsp;
                                    <span><strong>Customer Name :</strong> Kamal Abeynayake</span><br>
                                    <span><strong>Delivery Person ID :</strong> 11</span> &nbsp;
                                    <span><strong>Delivery Person Name :</strong> Kamal Abeynayake</span>
                                    <hr>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Buddy</td>
                                                <td>1</td>
                                            </tr>
                                            <tr>
                                                <td>Budget</td>
                                                <td>2</td>
                                            </tr>
                                            <tr>
                                                <td>Regular</td>
                                                <td>3</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="box">
                                <div class="label">Order ID : 1
                                    <svg class="img" width="30" height="16" viewBox="0 0 35 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M17.7514 15.8985C17.1825 15.8993 16.6312 15.7201 16.1932 15.3918L1.58692 4.38418C1.08977 4.01049 0.777187 3.47366 0.717923 2.89179C0.65866 2.30991 0.857574 1.73066 1.27091 1.28145C1.68424 0.832243 2.27813 0.54988 2.92193 0.496478C3.56574 0.443076 4.20671 0.623009 4.70385 0.996694L17.7522 10.8596L30.8036 1.35865C31.0527 1.17596 31.3392 1.03958 31.6468 0.957326C31.9545 0.875077 32.277 0.848587 32.596 0.87938C32.915 0.910173 33.2242 0.99764 33.5057 1.13676C33.7872 1.27587 34.0356 1.46389 34.2364 1.69001C34.4594 1.91635 34.6282 2.18184 34.7323 2.46986C34.8365 2.75788 34.8737 3.06221 34.8416 3.3638C34.8096 3.66538 34.709 3.95772 34.5461 4.2225C34.3832 4.48727 34.1616 4.71878 33.8951 4.90251L19.2853 15.525C18.8346 15.8011 18.2945 15.9326 17.7514 15.8985Z" fill="#F9896B"/>
                                    </svg>
                                </div>
                                <div class="content">
                                    <span><strong>Customer ID :</strong> 11</span> &nbsp;
                                    <span><strong>Customer Name :</strong> Kamal Abeynayake</span><br>
                                    <span><strong>Delivery Person ID :</strong> 11</span> &nbsp;
                                    <span><strong>Delivery Person Name :</strong> Kamal Abeynayake</span>
                                    <hr>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Buddy</td>
                                                <td>1</td>
                                            </tr>
                                            <tr>
                                                <td>Budget</td>
                                                <td>2</td>
                                            </tr>
                                            <tr>
                                                <td>Regular</td>
                                                <td>3</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
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
        echo '<section class="body-content">
        <div class="top-panel">
            '.$stockheader.'
        </div>
        <div class="content-data">';
        $stock = new StockHTML('dealer'.$data['tab'],$data);
        echo '</div></section>';
    }

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
                <div class="btn"><button><svg width="50" height="30" viewBox="0 0 36 27" fill="black" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.91898 0.00888084C1.32213 0.101743 0.787668 0.421359 0.433159 0.897418C0.0786496 1.37348 -0.0668626 1.96698 0.0286329 2.54737C0.124128 3.12775 0.452809 3.64748 0.942369 3.99221C1.43193 4.33695 2.04227 4.47844 2.63911 4.38558H9.39036L9.79543 5.47976L11.6408 10.9506L13.4861 16.4215C13.6661 16.9905 14.4313 17.5157 15.0164 17.5157H30.7693C31.3994 17.5157 32.1195 16.9905 32.2996 16.4215L35.9452 5.47976C36.1253 4.91079 35.8552 4.38558 35.2251 4.38558H15.2414L13.5311 1.23436C13.349 0.872664 13.0677 0.566869 12.7183 0.350647C12.3688 0.134424 11.9649 0.0161615 11.5508 0.00888084L2.5491 0.00888084C2.41435 -0.00296028 2.27877 -0.00296028 2.14402 0.00888084C2.05409 0.00362406 1.96391 0.00362406 1.87397 0.00888084L1.91898 0.00888084ZM16.1416 21.8924C14.8814 21.8924 13.8912 22.8553 13.8912 24.0807C13.8912 25.3062 14.8814 26.2691 16.1416 26.2691C17.4018 26.2691 18.392 25.3062 18.392 24.0807C18.392 22.8553 17.4018 21.8924 16.1416 21.8924ZM29.6441 21.8924C28.3839 21.8924 27.3937 22.8553 27.3937 24.0807C27.3937 25.3062 28.3839 26.2691 29.6441 26.2691C30.9043 26.2691 31.8945 25.3062 31.8945 24.0807C31.8945 22.8553 30.9043 21.8924 29.6441 21.8924Z" fill=""/>
                    </svg>Place Reservation</button>
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
                    $brand .=   '<div >
                                <img src="'.$image.'" alt="" class="litro">
                                <h3>'.$company_name.'</h3>
                                </div>'; 
                
                }
                echo $brand.' </div>
                </div>';
               
            }


        echo '</div>';
    }

    function distributordashboard($data){
        echo '<section class="body-content dashboard">
                    <div class="body-left">

                        <div class="variable">
                            <div class="topic">
                                <h3>Analytic Overview</h3>
                                <!-- drop down component -->
                                <form action="#">
                                    <select id="period" onchange="updatechart()" class="dropdowndate">
                                        <option value="today" selected>To day</option>
                                        <option  value="30day">Last 30 days</option>
                                    </select>
                                </form>
                            </div>

                            <div class="box1">
                                <div class="box2">
                                    <p class="p1"><b>10</b></p>
                                    <p>pending distributions</p>
                                </div>

                                <div class="box2">
                                    <p class="p1"><b>14</b></p>
                                    <p>received orders</p>
                                </div>
                            </div> 
                        </div>

                        <div class="box3">
                            <h3>Current Stock</h3>

                                <div class="content1">

                                    <div class="tab2">
                                        <p>Buddy :  200</p>
                                    </div>

                                    <div class="tab2">
                                        <p>Budget :  160</p>
                                    </div>

                                    <div class="tab2">
                                        <p>Regular :  100</p>
                                    </div>
                                </div>
                        </div>
                    </div>';

                    echo '
                    <div class="body-right">
                        <div class="accordion new">
                            <h3>New Purchase Orders</h3>
                            <div class="box">
                                <div class="label"> Purchase Order ID : 1
                                    <svg class="img" width="30" height="16" viewBox="0 0 35 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M17.7514 15.8985C17.1825 15.8993 16.6312 15.7201 16.1932 15.3918L1.58692 4.38418C1.08977 4.01049 0.777187 3.47366 0.717923 2.89179C0.65866 2.30991 0.857574 1.73066 1.27091 1.28145C1.68424 0.832243 2.27813 0.54988 2.92193 0.496478C3.56574 0.443076 4.20671 0.623009 4.70385 0.996694L17.7522 10.8596L30.8036 1.35865C31.0527 1.17596 31.3392 1.03958 31.6468 0.957326C31.9545 0.875077 32.277 0.848587 32.596 0.87938C32.915 0.910173 33.2242 0.99764 33.5057 1.13676C33.7872 1.27587 34.0356 1.46389 34.2364 1.69001C34.4594 1.91635 34.6282 2.18184 34.7323 2.46986C34.8365 2.75788 34.8737 3.06221 34.8416 3.3638C34.8096 3.66538 34.709 3.95772 34.5461 4.2225C34.3832 4.48727 34.1616 4.71878 33.8951 4.90251L19.2853 15.525C18.8346 15.8011 18.2945 15.9326 17.7514 15.8985Z" fill="#a66bf9"/>
                                    </svg>
                                </div>
                                <div class="content">
                                    <span><strong>Dealer ID : </strong>16</span> &nbsp;
                                    <span><strong>Dealer Name : </strong>Jerry Perera</span>
                                    <hr>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>Item</th>
                                                    <th>Quantity</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td>Buddy</td>
                                                <td>20</td>
                                            </tr>
                                            <tr>
                                                <td>Regular</td>
                                                <td>50</td>
                                            </tr>
                                            </tbody>
                                        </table>
                            </div>          
                        </div>

                        <div class="box">
                            <div class="label"> Purchase Order ID : 2
                                <svg class="img" width="30" height="16" viewBox="0 0 35 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M17.7514 15.8985C17.1825 15.8993 16.6312 15.7201 16.1932 15.3918L1.58692 4.38418C1.08977 4.01049 0.777187 3.47366 0.717923 2.89179C0.65866 2.30991 0.857574 1.73066 1.27091 1.28145C1.68424 0.832243 2.27813 0.54988 2.92193 0.496478C3.56574 0.443076 4.20671 0.623009 4.70385 0.996694L17.7522 10.8596L30.8036 1.35865C31.0527 1.17596 31.3392 1.03958 31.6468 0.957326C31.9545 0.875077 32.277 0.848587 32.596 0.87938C32.915 0.910173 33.2242 0.99764 33.5057 1.13676C33.7872 1.27587 34.0356 1.46389 34.2364 1.69001C34.4594 1.91635 34.6282 2.18184 34.7323 2.46986C34.8365 2.75788 34.8737 3.06221 34.8416 3.3638C34.8096 3.66538 34.709 3.95772 34.5461 4.2225C34.3832 4.48727 34.1616 4.71878 33.8951 4.90251L19.2853 15.525C18.8346 15.8011 18.2945 15.9326 17.7514 15.8985Z" fill="#a66bf9"/>
                                </svg>
                            </div>
                            <div class="content">
                                <span><strong>Dealer ID : </strong>28</span> &nbsp;
                                <span><strong>Dealer Name : </strong>Swetha Dissanayake</span>
                                <hr>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Buddy</td>
                                            <td>30</td>
                                        </tr>
                                        <tr>
                                            <td>Budget</td>
                                            <td>100</td>
                                        </tr>
                                        <tr>
                                            <td>Regular</td>
                                            <td>50</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>         
                        </div>

                        <div class="box">
                            <div class="label"> Purchase Order ID : 3
                                <svg class="img" width="30" height="16" viewBox="0 0 35 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M17.7514 15.8985C17.1825 15.8993 16.6312 15.7201 16.1932 15.3918L1.58692 4.38418C1.08977 4.01049 0.777187 3.47366 0.717923 2.89179C0.65866 2.30991 0.857574 1.73066 1.27091 1.28145C1.68424 0.832243 2.27813 0.54988 2.92193 0.496478C3.56574 0.443076 4.20671 0.623009 4.70385 0.996694L17.7522 10.8596L30.8036 1.35865C31.0527 1.17596 31.3392 1.03958 31.6468 0.957326C31.9545 0.875077 32.277 0.848587 32.596 0.87938C32.915 0.910173 33.2242 0.99764 33.5057 1.13676C33.7872 1.27587 34.0356 1.46389 34.2364 1.69001C34.4594 1.91635 34.6282 2.18184 34.7323 2.46986C34.8365 2.75788 34.8737 3.06221 34.8416 3.3638C34.8096 3.66538 34.709 3.95772 34.5461 4.2225C34.3832 4.48727 34.1616 4.71878 33.8951 4.90251L19.2853 15.525C18.8346 15.8011 18.2945 15.9326 17.7514 15.8985Z" fill="#a66bf9"/>
                                </svg>
                            </div>
                            <div class="content">
                                <span><strong>Dealer ID : </strong>15</span> &nbsp;
                                <span><strong>Dealer Name : </strong>Saman Gunathilake</span>
                                <hr>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Buddy</td>
                                            <td>50</td>
                                        </tr>
                                        <tr>
                                            <td>Budget</td>
                                            <td>150</td>
                                        </tr>
                                        <tr>
                                            <td>Regular</td>
                                            <td>100</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>       
                        </div>
                    </div>
                    ';

                    echo '</section>';                         
    }

    function admindashboard($data){
        echo '<section class="body-content">
        <div class="tiles one">
            <div class="tile">
                <h1>246</h1>
                <p>Customers</p>
            </div>
            <div class="tile">
                <h1>74</h1>
                <p>Dealers</p>
            </div>
            <div class="tile">
                <h1>53</h1>
                <p>Delivery People</p>
            </div>
            <div class="tile">
                <h1>24</h1>
                <p>Distributors</p>
            </div>
            <div class="tile">
                <h1>2</h1>
                <p>Companies</p>
            </div>
        </div>
        <div class="graph">
            <div class="variable">
                <div class="topic">
                    <h2>Analytic Overview</h2>
                    <!-- drop down component -->
                    <form action="#">
                        <select id="period" onchange="updatechart()" class="dropdowndate">
                            <option value="today" selected>To day</option>
                            <option  value="30day">Last 30 days</option>
                        </select>
                    </form>
                </div>
                <div class="chart">

                </div>
            </div>
            <div class="reviews">
                <h2>Recent Reviews</h2>
                <div class="contents">
                    <div class="review">
                        <img src="css/admin.png" alt="">
                        <div class="review-info">
                            <div class="name-time">
                                <h3>Dinuka Ashan</h3>
                                <span>12:03 p.m</span>
                            </div>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                                Nobis nulla, asperiores animi similique rem totam aliquam, 
                                facilis quibusdam incidunt corrupti provident sit suscipit 
                                sed vel obcaecati modi nisi velit optio?
                            </p>
                        </div>
                    </div>
                    <div class="review">
                        <img src="css/admin.png" alt="">
                        <div class="review-info">
                            <div class="name-time">
                                <h3>Dinuka Ashan</h3>
                                <span>12:03 p.m</span>
                            </div>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                                Nobis nulla, asperiores animi similique rem totam aliquam, 
                                facilis quibusdam incidunt corrupti provident sit suscipit 
                                sed vel obcaecati modi nisi velit optio?
                            </p>
                        </div>
                    </div>
                    <div class="review">
                        <img src="css/admin.png" alt="">
                        <div class="review-info">
                            <div class="name-time">
                                <h3>Dinuka Ashan</h3>
                                <span>12:03 p.m</span>
                            </div>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                                Nobis nulla, asperiores animi similique rem totam aliquam, 
                                facilis quibusdam incidunt corrupti provident sit suscipit 
                                sed vel obcaecati modi nisi velit optio?
                            </p>
                        </div>
                    </div>
                    <div class="review">
                        <img src="css/admin.png" alt="">
                        <div class="review-info">
                            <div class="name-time">
                                <h3>Dinuka Ashan</h3>
                                <span>12:03 p.m</span>
                            </div>
                            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                                Nobis nulla, asperiores animi similique rem totam aliquam, 
                                facilis quibusdam incidunt corrupti provident sit suscipit 
                                sed vel obcaecati modi nisi velit optio?
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>';
    }

}