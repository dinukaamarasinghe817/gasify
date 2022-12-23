
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet"> 
    <link rel="stylesheet" href="<?php echo BASEURL; ?>/public/css/dashboard.css">
    <title>Dealer-dashboard</title>
</head>
<body>
    <?php 
    $sidebar = new Navigation($data['navigation']);
    ?>
    <section class="body">
        <?php
            $bodyheader = new BodyHeader();
        ?>
        <section class="body-content">
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
                    <tbody>
                        <?php
                            if(isset($data['stock'])){
                                $result = $data['stock'];
                                $stock = "";
                                while($row = mysqli_fetch_assoc($result)){
                                    $name = $row['name'];
                                    $qty = $row['quantity'];
                                    $stock .=   '<tr>
                                                    <td>'.$name.'</td>
                                                    <td>'.$qty.'</td>
                                                </tr>';
                                
                                }
                                echo $stock;

                            }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="body-right">
                <div class="accordion new">
                    <h3>New Orders</h3>
                    <?php
                        if(isset($data['pending'])){
                            $results = $data['pending'];
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
                        
                    ?>
                    
                </div>
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
        </section>
    </section>
    <!-- <script src="<?php echo BASEURL;?>/public/js/dashboard.js"></script> -->
    <script>
        let accordion = document.querySelectorAll('.accordion .box');
        for(i=0; i<accordion.length; i++) {
            accordion[i].addEventListener('click', function(){
                this.classList.toggle('active')
            })
        }
    </script>
</body>
</html>