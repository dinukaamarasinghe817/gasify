<?php
$prompt = new Prompt("verification",$data);
$header = new Header("dealer");
$sidebar = new Navigation('dealer',$data['navigation']);
?>

<section class="body">
    <?php
        // call the default header for yout interface
        $bodyheader = new BodyHeader($data);
        // call whatever the component you need to show
        // $bodycontent = new Orders($data,'accepted','pickup');
    ?>
    <section class="body-content">
        <div class="top-panel">
            <ul>
                <li><a href="#" class="current">Pending</a></li>
                <li><a href="#" class="current active">Accepted</a></li>
                <li><a href="#" class="current">Dispatched</a></li>
                <li><a href="#" class="current">Delivered</a></li>
                <li><a href="#" class="current">Completed</a></li>
                <li><a href="#" class="current">Canceled</a></li>
            </ul>
            <ul>
                <li><a href="#" class="current sub1 active">Pickup</a></li>
                <li><a href="#" class="current sub1">Delivery</a></li>
            </ul>
        </div>
        <div class="content-data">
            <div class="search-bar">
                <input type="text" class="ticker-input" placeholder="Type to search" autocomplete="off">
                <button class="btn btn-primary" type="submit">
                    <svg width="23" height="24" viewBox="0 0 23 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.5417 19C14.7759 19 18.2083 15.4183 18.2083 11C18.2083 6.58172 14.7759 3 10.5417 3C6.30748 3 2.875 6.58172 2.875 11C2.875 15.4183 6.30748 19 10.5417 19Z" stroke="#FFF8F3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M20.1248 20.9999L15.9561 16.6499" stroke="#FFF8F3" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <p>Search</p>
                </button>
            </div>
            <ul>
                <li>
                    <div class="order">
                        <div class="head">
                            <div class="details">
                                <div><strong>Order ID : </strong>12<br><strong>Total amount : </strong>Rs.10,000.00</div>
                                <div><strong>Date : </strong>2022-01-12<br><strong>Time : </strong>09:03:14</div>
                            </div>
                            <button onclick="viewinfo(); return false;" class="btn">Issue</button>
                            <button class="arrow">
                                <svg width="22" height="22" viewBox="0 0 36 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3 3L17.9551 17.9551L32.9102 3" stroke="#FCFCFC" stroke-opacity="0.97" stroke-width="6.98504" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                        <div class="info">
                            <div><p><strong>Customer ID : </strong>24</p><p><strong>Customer Name : </strong>Dinuka Ashan</p></div><br>
                            <table class="order-info">
                                <tr>
                                    <th>Product ID</th>
                                    <th>Product Name</th>
                                    <th>Unit Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>Regular</td>
                                    <td>Rs.1800.00</td>
                                    <td>2</td>
                                    <td>Rs.3600.00</td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>Regular</td>
                                    <td>Rs.1800.00</td>
                                    <td>2</td>
                                    <td>Rs.3600.00</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><strong>Total</strong></td>
                                    <td><strong>Rs.10,600.00</strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </li>
                <li>
                <div class="order">
                    <div class="head">
                        <div class="details">
                            <div><strong>Order ID : </strong>12<br><strong>Total amount : </strong>Rs.10,000.00</div>
                            <div><strong>Date : </strong>2022-01-12<br><strong>Time : </strong>09:03:14</div>
                        </div>
                        <button class="btn">Issue</button>
                        <button class="arrow">
                            <svg width="22" height="22" viewBox="0 0 36 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 3L17.9551 17.9551L32.9102 3" stroke="#FCFCFC" stroke-opacity="0.97" stroke-width="6.98504" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>
                    <div class="info">
                        <div><p><strong>Customer ID : </strong>24</p><p><strong>Customer Name : </strong>Dinuka Ashan</p></div><br>
                        <table>
                            <tr>
                                <th>Product ID</th>
                                <th>Product Name</th>
                                <th>Unit Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>Regular</td>
                                <td>Rs.1800.00</td>
                                <td>2</td>
                                <td>Rs.3600.00</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>Regular</td>
                                <td>Rs.1800.00</td>
                                <td>2</td>
                                <td>Rs.3600.00</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td><strong>Total</strong></td>
                                <td><strong>Rs.10,600.00</strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
                </li>
            </ul>
        </div>
    </section>
</section>

<script>
    let accordion = document.querySelectorAll(".order .head .arrow");
        for(i=0; i<accordion.length; i++) {
            accordion[i].addEventListener("click", function(){
                this.parentElement.parentElement.classList.toggle("active")
            })
        }
        let accorinfo = document.querySelectorAll(".order .head .btn");
        for(i=0; i<accorinfo.length; i++) {
            accorinfo[i].addEventListener("click", function(){
                this.parentElement.parentElement.querySelector(".verification").classList.toggle("active")
            })
        }
        function viewinfo(){
            let accorinfo = document.querySelector(".verification");
            accorinfo.classList.toggle("active");
            document.querySelector("body").classList.toggle("blur");
        }
</script>
<?php
$footer = new Footer("dealer");
?>