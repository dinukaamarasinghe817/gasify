<?php
$header = new Header("customer_support");
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
        <div class="subtitle">
           <h3>Customer Support</h3>
        </div>
    </div>

    <?php
       echo '<div class="wrapper">
        <section class="chat-area">
            
            <div class="chat-box">
                <div class="chat outgoing">
                    <div class="details">
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit.</p>
                    </div>
                </div>

                <div class="chat incoming">
                    <img src="Asset 7@4x.png" alt="">
                    <div class="details">
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit.</p>
                    </div>
                </div>


                <div class="chat outgoing">
                    <div class="details">
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit.</p>
                    </div>
                </div>

                <div class="chat incoming">
                    <img src="Asset 7@4x.png" alt="">
                    <div class="details">
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit.</p>
                    </div>
                </div>


                <div class="chat outgoing">
                    <div class="details">
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit.</p>
                    </div>
                </div>

                <div class="chat incoming">
                    <img src="Asset 7@4x.png" alt="">
                    <div class="details">
                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit.</p>
                    </div>
                </div>
            </div>

            <form action="#" class="typing-area">
                <input type="text" placeholder="Type a message here...">
                <button><i class="fa-telegram-plane"></i></button>
            </form>
            
        </section>
    </div>';
    ?>

</section>