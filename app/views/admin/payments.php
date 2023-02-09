<?php
$header = new Header("admin",$data);
$sidebar = new Navigation('admin','payments');
?>

<section class="body">
    <?php
        // call the default header for yout interface
        $bodyheader = new BodyHeader($data);
        // call whatever the component you need to show
        // $bodycontent = new ProfileHTML($data);
    ?>
    <div class="body-content">
        <div class="top-panel">
            <ul>
                <?php
                if($data['activetab'] == 'regular') {
                    echo '<li><a href="'.BASEURL.'/orders/validatepayments/regular" class="current active">Regular</a></li>
                    <li><a href="'.BASEURL.'/orders/validatepayments/refund" class="current">Refund</a></li>';
                }else{
                    echo '<li><a href="'.BASEURL.'/orders/validatepayments/regular" class="current">Regular</a></li>
                    <li><a href="'.BASEURL.'/orders/validatepayments/refund" class="current active">Refund</a></li>';
                }
                ?>
            </ul>
        </div>
                <div class="content-data">
                    <ul>
                        <li>
                            <div class="person payment">
                                <div class="payment-header">
                                    <div>
                                        <p><strong>Order ID : </strong>1</p>
                                        <p><strong>Customer Name : </strong>Sasangi Nayanathara</p>
                                    </div>
                                    <div>
                                        <p><strong>Date : </strong>2023/1/2</p>
                                        <p><strong>Time : </strong>09:15 am</p>
                                    </div>
                                    <svg class="img" width="30" height="16" viewBox="0 0 35 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M17.7514 15.8985C17.1825 15.8993 16.6312 15.7201 16.1932 15.3918L1.58692 4.38418C1.08977 4.01049 0.777187 3.47366 0.717923 2.89179C0.65866 2.30991 0.857574 1.73066 1.27091 1.28145C1.68424 0.832243 2.27813 0.54988 2.92193 0.496478C3.56574 0.443076 4.20671 0.623009 4.70385 0.996694L17.7522 10.8596L30.8036 1.35865C31.0527 1.17596 31.3392 1.03958 31.6468 0.957326C31.9545 0.875077 32.277 0.848587 32.596 0.87938C32.915 0.910173 33.2242 0.99764 33.5057 1.13676C33.7872 1.27587 34.0356 1.46389 34.2364 1.69001C34.4594 1.91635 34.6282 2.18184 34.7323 2.46986C34.8365 2.75788 34.8737 3.06221 34.8416 3.3638C34.8096 3.66538 34.709 3.95772 34.5461 4.2225C34.3832 4.48727 34.1616 4.71878 33.8951 4.90251L19.2853 15.525C18.8346 15.8011 18.2945 15.9326 17.7514 15.8985Z" fill="#3E8CFF"/>
                                    </svg>
                                </div>
                                <div class="payment-body">
                                    <div>
                                        <div>
                                            <p><strong>Dealer ID : </strong>6</p>
                                            <p><strong>Dealer Name : </strong>6</p>
                                        </div>
                                        <div>
                                            <p><strong>Dealer's Bank : </strong>Commercial Bank</p>
                                            <p><strong>Dealer's Acc Number : </strong>1010457986</p>
                                        </div>
                                    </div>
                                    <p><strong>Total amount : </strong>Rs.5000.00</p>
                                    <div>
                                        <a class="yellow" href="http://localhost/mvc/public/img/payslips/payslip.pdf" target="_top" Download>Download pay slip</a>
                                        <button class="btn-blue">Valid</button>
                                        <button class="btn-blue red">Invalid</button>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="person payment">
                                <div class="payment-header">
                                    <div>
                                        <p><strong>Order ID : </strong>1</p>
                                        <p><strong>Customer Name : </strong>Sasangi Nayanathara</p>
                                    </div>
                                    <div>
                                        <p><strong>Date : </strong>2023/1/2</p>
                                        <p><strong>Time : </strong>09:15 am</p>
                                    </div>
                                    <svg class="img" width="30" height="16" viewBox="0 0 35 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M17.7514 15.8985C17.1825 15.8993 16.6312 15.7201 16.1932 15.3918L1.58692 4.38418C1.08977 4.01049 0.777187 3.47366 0.717923 2.89179C0.65866 2.30991 0.857574 1.73066 1.27091 1.28145C1.68424 0.832243 2.27813 0.54988 2.92193 0.496478C3.56574 0.443076 4.20671 0.623009 4.70385 0.996694L17.7522 10.8596L30.8036 1.35865C31.0527 1.17596 31.3392 1.03958 31.6468 0.957326C31.9545 0.875077 32.277 0.848587 32.596 0.87938C32.915 0.910173 33.2242 0.99764 33.5057 1.13676C33.7872 1.27587 34.0356 1.46389 34.2364 1.69001C34.4594 1.91635 34.6282 2.18184 34.7323 2.46986C34.8365 2.75788 34.8737 3.06221 34.8416 3.3638C34.8096 3.66538 34.709 3.95772 34.5461 4.2225C34.3832 4.48727 34.1616 4.71878 33.8951 4.90251L19.2853 15.525C18.8346 15.8011 18.2945 15.9326 17.7514 15.8985Z" fill="#3E8CFF"/>
                                    </svg>
                                </div>
                                <div class="payment-body">
                                    <div>
                                        <div>
                                            <p><strong>Dealer ID : </strong>6</p>
                                            <p><strong>Dealer Name : </strong>6</p>
                                        </div>
                                        <div>
                                            <p><strong>Dealer's Bank : </strong>Commercial Bank</p>
                                            <p><strong>Dealer's Acc Number : </strong>1010457986</p>
                                        </div>
                                    </div>
                                    <p><strong>Total amount : </strong>Rs.5000.00</p>
                                    <div>
                                        <a class="yellow" href="http://localhost/mvc/public/img/payslips/payslip.pdf" target="_top" Download>Download pay slip</a>
                                        <button class="btn-blue">Valid</button>
                                        <button class="btn-blue red">Invalid</button>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
    </div>
</section>
<script>
    let accordion = document.querySelectorAll(".payment-header .img");
    let accordionbody = document.querySelectorAll(".payment-body");
    for(i=0; i<accordion.length; i++) {
        let j = i;
        accordion[i].addEventListener("click", function(){
            console.log(accordionbody[j]);
            console.log(j);
            accordionbody[j].classList.toggle("active");
            this.classList.toggle("active");
            console.log('rotated agian');
        })
    }
</script>

<?php
$footer = new Footer("admin");
?>