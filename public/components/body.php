<?php

class Body{

    public function __construct($user, $data = null){
        $this->$user($data);
    }

    function dealerdashboard($data){
        echo '<section class="body-content">
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
                                    <h1>12</h1>
                                    <p>Orders Recieved</p>
                                </div>
                                <div class="tile">
                                    <h1>12</h1>
                                    <p>Orders Recieved</p>
                                </div>
                            </div>
                            <div class="chart">

                            </div>
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
    }
    function companydashboard($data){
        echo 
        '<section class="body-content">
            <div class="Top" id="Top">
            <div class="Col_1" id="Col_1">
                <div class="Title_1">
                <div class="ChartTitle">Revenue(LKR Millions)</div><br>
                <div class="ChartTitle">Last five months</div>
                </div>
                <div class="Content_1"></div>
            </div>
            <div class="Col_2" id="Col_2">
                <div class="Title_2">
                <div class="ChartTitle">Today</div>
                </div>
                <div class="Content_2" id="Content_2"></div>
            
            </div>
            <div class="Col_3" id="Col_3">
                <div class="Title_3">
                <div class="ChartTitle">Current stock</div>
                </div>
                <div class="Content_3" id="Content_3"></div>
                </div>
            </div>
            <div class="DistributorTableHeadings" id="DistributorTableHeadings">
                <div class="Distributor_table_name" id="Distributor_table_name">
                    <div class="distibutor_title">Distributor</div>
                </div>
                <div class="tableTitles" id="tableTitles">
                    <div class="distributor_name" id="col">Name</div>
                    <div class="distributor_location" id="col">Location</div>
                    <div class="distributor_contactno" id="col">Contact no</div>
                    <div class="distributor_email" id="col" style="font-size: 12pt">Email</div>
                </div>       
            </div> 
            <div class="DistributorTable" id="DistributorTable">

            </div> 
            <div class="DealerTableHeadings" id="DealerTableHeadings">
                <div class="Dealer_table_name" id=\"Dealer_table_name\">
                    <div class="distibutor_title">Dealer</div>
                    </div>
                    <div class="tableTitles" id="tableTitles">
                    <div class="Dealer_name" id="col">Name</div>
                    <div class="Dealer_location" id="col">Location</div>
                    <div class="Dealer_contactno" id="col">Contact no</div>
                    <div class="Dealer_email" id="col" style="font-size: 12pt">Email</div>
                    <div class="Dealer_accountno" id="col">Account no</div>
                    <div class="Dealer_capacity" id="col">Capacity</div>
                </div>
            </div>  
            <div class="DealerTable" id="DealerTable"></div>
        </section>';
        /*echo '<section class="body-content">
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
                        <h1>12</h1>
                        <p>Orders Recieved</p>
                    </div>
                    <div class="tile">
                        <h1>12</h1>
                        <p>Orders Recieved</p>
                    </div>
                </div>
                <div class="chart">

                </div>
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
    </section>';*/
    }
    function companyDealers($data){
        echo 
        '<section class="body-content">
            <div class="Distributor_table_name" id="Distributor_table_name">
            <div class="DealerTableTopics" onClick="loadDistributorTableTopics()">Registered Dealers</div>
            <div class="DealerTableTopics" onClick="loadDistributorRegistrationForm()">Register New Dealer</div>
            </div>
            <div class="dealerTableTitles" id="dealerTableTitles">
            <div class="dealer_name" id="dealer_col" style="width:15%">Name</div>
            <div class="dealer_location" id="dealer_col"style="width:15%">Location</div>
            <div class="dealer_contactno" id="dealer_col"style="width:18%">Contact no</div>
            <div class="dealer_email" id="dealer_col" style="font-size: 12pt"style="width:28%">Email</div>
            <div class="dealer_capacity" id="dealer_col"style="width:30%">Hold time</div>
            </div>
            <div class="DealerTables" id="DealerTables">';
            
                if(isset($data["dealer"])){
                    $result = $data["dealer"];
                    $dealer = "";
                    while($row = mysqli_fetch_assoc($result)){
                        $dealer.='';
                        //$name = $row["name"];
                        //$qty = $row["quantity"];
                        $dealer .=   '<div class="dealer_tableHead_row" id="dealer_tableHead_row" style="background-color: #85B6E2;height:10%">
                                        <div class="dealer_name" id="col">'.$row['name']. '</div>
                                        <div class="dealer_location" id="col">'.$row['city'].$row['street'].'</div>
                                        <div class="dealer_contactno" id="col">'.$row['contact_no'].'</div>
                                        <div class="dealer_accountno" id="col">'.$row['account_no'].'</div>
                                        <div class="dealer_capacity" id="col">'.$row['bank'].'</div>
                                        </div>';                    
                    }
                    echo $dealer;

                }
            
            
            
            
            
            echo ' 
        </section>';
    }
    function companyDistributors($data){
        echo 
        '<section class="body-content">
            <div class="Distributor_table_name" id="Distributor_table_name">
                <div class="DealerTableTopics" onClick="loadDistributorTableTopics()">Registered Distributors</div>
                <div class="DealerTableTopics" onClick="loadDistributorRegistrationForm()">Register New Distributor</div>
            </div>
            <div class="dealerTableTitles" id="dealerTableTitles">
                <div class="dealer_name" id="dealer_col" style="width:15%">Name</div>
                <div class="dealer_location" id="dealer_col"style="width:15%">Location</div>
                <div class="dealer_contactno" id="dealer_col"style="width:18%">Contact no</div>
                <div class="dealer_email" id="dealer_col" style="font-size: 12pt"style="width:28%">Email</div>
                <div class="dealer_capacity" id="dealer_col"style="width:30%">Hold time</div>
            </div>
            <div class="DealerTables" id="DealerTables"></div>
        </section>';
    }
    function companyProducts($data){
        echo 
        '<section class="body-content">
             <div class="Distributor_table_name" id="Distributor_table_name">
                 <a href="../Compny/products" style="width:32.33%" ><div class="ProductTableTopics"onClick="location.href = "../Compny/dealer"">Current Products</div></a>
                 <a href="../Compny/regproducts" style="width:32.33%" ><div class="ProductTableTopics" onClick="loadProductRegistrationForm()" style="background-color:#cda6e4">Register New Product</div></a>
                 <a href="../Compny/dealer" style="width:32.33%" ><div class="ProductTableTopics" onClick="loadProductUpdateForm()" style="background-color:#deb4f8">Update Product</div></a>
             </div>
             <div class="productTableTitles" id="productTableTitles">
                 <div class="product_id" id="product_col">Product ID</div>
                 <div class="product_name" id="product_col">Name</div>
                 <div class="product_type" id="product_col">Type</div>
                 <div class="product_unit_price" id="product_col" style="font-size: 12pt">Unit price</div>
                 <div class="product_weight" id="product_col" style="width:20%">Weight</div>
                 <div class="product_prod_time" id="product_col" style="width:20%">Prod.time</div>
                 <div class="product_lastUpdated" id="product_col">Last updated</div>
                 <div class="product_lastUpdated" id="product_col">Qty</div>
             </div>
             <div class="DealerTables" id="DealerTables"></div>
        </section>';
    }
    function companyRegProducts($data){
        echo 
        '<section class="body-content">
            <div class="Distributor_table_name" id="Distributor_table_name">
                 <a href="../Compny/products" style="width:32.33%" ><div class="ProductTableTopics"onClick="location.href = "../Compny/dealer"">Current Products</div></a>
                 <a href="../Compny/regproducts" style="width:32.33%" ><div class="ProductTableTopics" onClick="loadProductRegistrationForm()" style="background-color:#cda6e4">Register New Product</div></a>
                 <a href="../Compny/dealer" style="width:32.33%" ><div class="ProductTableTopics" onClick="loadProductUpdateForm()" style="background-color:#deb4f8">Update Product</div></a>
             </div>
            <div class="DealerTables" id="DealerTables" style="display:flex">
                <div class="left">
                <form action="#" method="POST" id="productRegistrationForm" class="productRegistrationForm">
                <div class="product_reg_row">
                <input type="text" class="registerProduct" name="Productname" placeholder="Enter product name" style="margin-bottom:3%;border:3px solid #deb4f8" required>
                <select name="Producttype" id="Producttype" class="registerProduct" style="margin-bottom:3%;border:3px solid #deb4f8">
                <option value="cylinder">Cylinder</option>
                <option value="support">Support</option>
                </select>
                </div>
                <div class="product_reg_row">
                <input type="text" class="registerProduct" name="unitprice" placeholder="Enter price" style="margin-bottom:3%;border:3px solid #deb4f8" required> <br>
                <input type="text" class="registerProduct" name="weight" placeholder="Enter weight" style="margin-bottom:3%;border:3px solid #deb4f8" required> <br>
                </div>
                <div class="product_reg_row">
                <input type="text" class="registerProduct" name="productiontime" placeholder="Enter production time" style="margin-bottom:3%;border:3px solid #deb4f8" required> <br>
                <input type="text" class="registerProduct" name="quantity" placeholder="Enter quantity" style="margin-bottom:3%;border:3px solid #deb4f8;font-family:poppins" required > <br>
                </div>
                <div class="product_reg_row">
                <input type="file" class="registerProduct" name="productImage" id="productImage" style="margin-bottom:3%;border:3px solid #deb4f8" onchange="showProductImage(this)" required> <br>
                </div>
                <div class="product_reg_row">
                <input type="submit" name="Sign In" value="Add product" class="submitRegisterProduct" onClick="addProducts()" style="width:65%">
                </div>
                </form></div><div class="right">
                <div style="height:10vh"></div>
                <label>Preview</label>
                <div class="productPreview" id="productPreview"><img id="ff" style="width:100%;height:100%;border-radius:100%;outline:none">
                </div></div>
                
                
                
            
            
            
            
            
            </div>




        </section>';
    }
    function deliverydashboard($data){
        echo
        '<section class="body-content">
            <div class="Top" id="Top">
            <div class="Col_1" id="Col_1">
                <div class="Title_1">
                <div class="ChartTitle">Previous week</div><br>
                </div>
                <div class="Content_1"></div>
            </div>
            <div class="Col_2" id="Col_2">
                <div class="Title_2">
                <div class="ChartTitle">Today</div>
                </div>
                <div class="Content_2" id="Content_2"></div>
            
            </div>
            <div class="Col_3" id="Col_3">
                <div class="Title_3">
                <div class="ChartTitle">My Vehicle</div>
                </div>
                <div class="Content_3" id="Content_3"></div>
                </div>
            </div>
            <div class="DistributorTableHeadings" id="DistributorTableHeadings">
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
            <div class="DealerTable" id="DealerTable"></div>
        </section>';
    }
    function gasdeliveries($data){
        echo
        '<section class="body-content">
            <div class="Distributor_table_name" id="Distributor_table_name">
            <a href="../Delvery/deliveries" style="width:48.5%;height:100%" class="deliveries_link" ><div class="DealerTableTopics" style="width:100%;height:100%">Pool</div></a>
            <a href="../Delvery/currentdeliveries" style="width:48.5%";height:100%  class="deliveries_link"><div class="DealerTableTopics" onClick="loadCurrentDeliveries()" style="width:100%;height:100%" >Current deliveries</div></a>
            </div>
            <div class="dealerTableTitles" id="dealerTableTitles">
            <div class="distributor_name" id="col" style=\"width:23%\">Name</div>
            <div class="distributor_location" id="col" style="width:20%">Location</div>
            <div class="distributor_contactno" id="col" style="width:15%">Contact no</div>
            <div class="distributor_contactno" id="col" style="width:15%">Placed date</div>
            <div class="distributor_contactno" id="col" style="width:15%">Placed time</div>
            </div>
        <div class="DealerTables" id="DealerTables"></div>
        </section>';
    }   
    function currentgasdeliveries($data){
        echo
        '<section class="body-content">
         <div class="Distributor_table_name" id="Distributor_table_name">
         <a href="../Delvery/deliveries" style="width:48.5%;height:100%" class="deliveries_link" ><div class="DealerTableTopics" onClick="loadDeliveryTableTopics()" style="width:100%;height:100%">Pool</div></a>
         <a href="../Delvery/currentdeliveries" style="width:48.5%";height:100%  class="deliveries_link"><div class="DealerTableTopics" onClick="loadCurrentDeliveries()" id="temp" style="width:100%;height:100%">Current deliveries</div></a>
         </div>
         <div class="dealerTableTitles" id="dealerTableTitles" style="box-sizing:border-box">
        <div class="distributor_name" id="col" style="width:20%">Name</div>
        <div class="distributor_location" id="col" style="width:25%">Location</div>
        <div class="distributor_contactno" id="col" style="width:15%">Contact no</div>
        </div>
        <div class="DealerTables" id="DealerTables"></div>
        </section>';
    }
}