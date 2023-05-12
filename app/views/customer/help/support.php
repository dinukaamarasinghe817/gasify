<?php
$header = new Header("customer/customer_support");
$sidebar = new Navigation('customer',$data['navigation']);
?>

<section class="body">
    <?php
        // call the default header for yout interface
        $bodyheader = new BodyHeader($data);

        $profile_image = BASEURL.'/public/img/profile/'.$data['image']; //customer profile image
        $admin = $data['admin']; //admin user_id
        $admin_image = $admin['image']; //admin profile image
    ?>
       
    <div class="under_topbar">
        <div class="subtitle">
           <h3>Customer Support</h3>
        </div>
    
        <div class="middle">
            <!-- message box -->
            <div class="msg_box" >
                <div class="wrapper">
                    <section class="chat-area">
                        
                        <div class="chat-box" id="chatbox">
                            <?php 
                                $customer_id = $_SESSION['user_id'];
                                $messages = $data['messages'];
                                $count = 0;

                               while($row = mysqli_fetch_assoc($messages)){
                                    $count =  count($row);
                               }

                               if($count == 0){
                                    echo '<div class="empty_msg">Type your message</div>';
                               }else{
                                    foreach ($messages as $message ) {
                                        
                                        if( $message['sender']== $customer_id ) {

                                            echo '<div class="chat outgoing">
                                            <div class="details">
                                                <p>'.$message['description'].'</p>
                                                <h6>'.$message['time'].'</h6>
                                            </div>
                                            <img src="'.$profile_image.'" alt="">
                                            </div>';
                                        }
                                        if($message['reciever']== $customer_id) {

                                            echo '<div class="chat incoming">
                                                <img src="'.BASEURL.'/public/img/profile/'.$admin_image.'" alt="">
                                                <div class="details">
                                                    <p>'.$message['description'].'</p>
                                                    <h6>'.$message['time'].'</h6>
                                                </div>
                                                </div>';
                                        }
                                    } 
                               }
   
                            ?>
                        </div>

                        <form action="<?php echo BASEURL; ?>/Support/customer_send_message" method="post" class="typing-area" autocomplete="off">
                            <textarea name="message" class="input-field" id="" cols="68" rows="1" placeholder="Type a message here..."></textarea>
                            <button type="submit"><svg width="30" height="30" viewBox="0 0 53 43" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M44.4728 13.1615L19.1282 2.93559C2.10354 -3.94543 -4.88399 1.69318 3.64317 15.4313L6.21908 19.5886C6.95928 20.8071 6.95928 22.2168 6.21908 23.4353L3.64317 27.5687C-4.88399 41.3068 2.07393 46.9454 19.1282 40.0644L44.4728 29.8385C55.8424 25.2511 55.8424 17.7489 44.4728 13.1615ZM34.9094 23.2919H18.921C17.707 23.2919 16.7004 22.4796 16.7004 21.5C16.7004 20.5204 17.707 19.7081 18.921 19.7081H34.9094C36.1233 19.7081 37.13 20.5204 37.13 21.5C37.13 22.4796 36.1233 23.2919 34.9094 23.2919Z" fill="#fff"/>
                                    </svg>
                            </button>
                        </form>
                        
                    </section>
                </div>
            </div>

            <!-- help options -->
            <div class="help_options">
                <img src="<?php echo BASEURL; ?>/public/img/customer/help_img.webp" alt="">
                <div class="options">
                    <div class="chat_us">
                        <div class="icon">
                            <svg width="11" height="10" viewBox="0 0 11 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 0V6.53215L1.30643 5.22572H2.61286V1.30643H6.53215V0H0ZM3.91929 2.61286V7.83859H9.14502L10.4514 9.14502V2.61286H3.91929Z" fill="#FC7949"/>
                            </svg>
                        </div>
                        
                        <div class="option_details">
                            <h3>Chat with Us</h3>
                            <p>Type your messages in chat box. </p>
                        </div> 
                    </div>
                    <div class="mail_us">
                        <div class="icon">
                            <svg width="11" height="8" viewBox="0 0 11 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 0V1.30643L5.22572 3.91929L10.4514 1.30643V0H0ZM0 2.61286V7.83859H10.4514V2.61286L5.22572 5.22572L0 2.61286Z" fill="#FC7949"/>
                            </svg>
                        </div>
                        
                        <div class="option_details">
                            <h3>Email Us</h3>
                            <p>Send your emails.<br> <strong>Email Address :  <?php echo $admin['email']; ?></strong></p>
                        </div>
                    </div>
                </div>
                
            </div>
            
        </div>
    </div>
    

</section>

<script>
    const form = document.querySelector(".typing-area"),
    inputField = form.querySelector(".input-field"),
    sendBtn = form.querySelector("button"),
    chatBox = document.querySelector(".chat-box");
    

    form.onsubmit = (e)=>{
        e.preventDefault();
    }

    //click send button then send message to database and scrollbottom and refresh page
    sendBtn.onclick = ()=>{
        let xhr = new XMLHttpRequest();
        xhr.open("POST", 'http://localhost/mvc/Support/customer_send_message/', true);
        xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                scrollToBottom();
                location.reload();
            }
        }
        }
        let formData = new FormData(form);
        xhr.send(formData);
    }
    
    //if chat box visible then scroll to bottom to display recent message
    setInterval(() =>{
        if(!chatBox.classList.contains("active")){
            scrollToBottom();
        }
    }, 1000);

    //function to scroll bottom of chatbox
    function scrollToBottom(){
        chatBox.scrollTo(0,chatBox.scrollHeight);
    }
  
</script>