<?php
$header = new Header("customer/customer_support");
$sidebar = new Navigation('customer',$data['navigation']);
?>

<section class="body">
    <?php
        // call the default header for yout interface
        $bodyheader = new BodyHeader($data);
        $profile_image = BASEURL.'/public/img/profile/'.$data['image'];
        // call whatever the component you need to show
        // $bodycontent = new Body('addreview', $data);
        
    ?>
       
    <div class="under_topbar">
        <div class="subtitle">
           <h3>Customer Support</h3>
        </div>
    
        <div class="middle">
            <!-- message box -->
            <div class="msg_box">
                <div class="wrapper">
                    <section class="chat-area">
                        
                        <div class="chat-box">
                            <?php 
                                $customer_id = $_SESSION['user_id'];
                                $messages = $data['messages'];
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
                                            <img src="'.BASEURL.'/public/img/people/company.png" alt="">
                                            <div class="details">
                                                <p>'.$message['description'].'</p>
                                                <h6>'.$message['time'].'</h6>
                                            </div>
                                            </div>';
                                    }
                                }   
                                
                                
                                // $recieved_messages = $data['recieved_messages'];
                                // foreach ($recieved_messages as $recieved_message ) {
                                    
                                // } 
                                

                                
                            ?>
                            

                            


                            

                            <!-- <div class="chat incoming">
                                <img src="<?php echo BASEURL; ?>/public/img/people/company.png" alt="">
                                <div class="details">
                                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit.</p>
                                    <h6>23:00</h6>
                                </div>
                            </div>

                            <div class="chat outgoing">
                                <div class="details">
                                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit.</p>
                                    <h6>23:15</h6>
                                </div>
                                <img src="<?php echo $profile_image ?>" alt="">
                            </div> -->

                            

                        </div>

                        <form action="<?php echo BASEURL; ?>/Support/customer_send_message" method="post" class="typing-area" autocomplete="off">
                            <input type="text" class="input-field" name="message" placeholder="Type a message here...">
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
                <!-- <div class="title"><h3>Contact Us</h3></div> -->
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
                    <div class="call_us">
                        <div class="icon">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.62 8.752C15.4158 8.752 15.2199 8.67088 15.0755 8.52647C14.9311 8.38207 14.85 8.18622 14.85 7.982C14.85 7.612 14.48 6.842 13.86 6.172C13.25 5.522 12.58 5.142 12.02 5.142C11.8158 5.142 11.6199 5.06088 11.4755 4.91647C11.3311 4.77207 11.25 4.57622 11.25 4.372C11.25 3.952 11.6 3.602 12.02 3.602C13.02 3.602 14.07 4.142 14.99 5.112C15.85 6.022 16.4 7.152 16.4 7.972C16.4 8.402 16.05 8.752 15.62 8.752ZM19.23 8.75C19.0258 8.75 18.8299 8.66888 18.6855 8.52447C18.5411 8.38007 18.46 8.18422 18.46 7.98C18.46 4.43 15.57 1.55 12.03 1.55C11.8258 1.55 11.6299 1.46888 11.4855 1.32447C11.3411 1.18007 11.26 0.984217 11.26 0.78C11.26 0.36 11.6 0 12.02 0C16.42 0 20 3.58 20 7.98C20 8.4 19.65 8.75 19.23 8.75ZM9.05 12.95L7.2 14.8C6.81 15.19 6.19 15.19 5.79 14.81C5.68 14.7 5.57 14.6 5.46 14.49C4.44877 13.472 3.5161 12.3789 2.67 11.22C1.85 10.08 1.19 8.94 0.71 7.81C0.24 6.67 0 5.58 0 4.54C0 3.86 0.12 3.21 0.36 2.61C0.6 2 0.98 1.44 1.51 0.94C2.15 0.31 2.85 0 3.59 0C3.87 0 4.15 0.0600001 4.4 0.18C4.66 0.3 4.89 0.48 5.07 0.74L7.39 4.01C7.57 4.26 7.7 4.49 7.79 4.71C7.88 4.92 7.93 5.13 7.93 5.32C7.93 5.56 7.86 5.8 7.72 6.03C7.59 6.26 7.4 6.5 7.16 6.74L6.4 7.53C6.29 7.64 6.24 7.77 6.24 7.93C6.24 8.01 6.25 8.08 6.27 8.16C6.3 8.24 6.33 8.3 6.35 8.36C6.53 8.69 6.84 9.12 7.28 9.64C7.73 10.16 8.21 10.69 8.73 11.22C8.83 11.32 8.94 11.42 9.04 11.52C9.44 11.91 9.45 12.55 9.05 12.95ZM19.97 16.33C19.9687 16.7074 19.8833 17.0798 19.72 17.42C19.55 17.78 19.33 18.12 19.04 18.44C18.55 18.98 18.01 19.37 17.4 19.62C17.39 19.62 17.38 19.63 17.37 19.63C16.78 19.87 16.14 20 15.45 20C14.43 20 13.34 19.76 12.19 19.27C11.04 18.78 9.89 18.12 8.75 17.29C8.36 17 7.97 16.71 7.6 16.4L10.87 13.13C11.15 13.34 11.4 13.5 11.61 13.61C11.66 13.63 11.72 13.66 11.79 13.69C11.87 13.72 11.95 13.73 12.04 13.73C12.21 13.73 12.34 13.67 12.45 13.56L13.21 12.81C13.46 12.56 13.7 12.37 13.93 12.25C14.16 12.11 14.39 12.04 14.64 12.04C14.83 12.04 15.03 12.08 15.25 12.17C15.47 12.26 15.7 12.39 15.95 12.56L19.26 14.91C19.52 15.09 19.7 15.3 19.81 15.55C19.91 15.8 19.97 16.05 19.97 16.33Z" fill="#FC7949"/>
                            </svg>
                        </div>
                        <div class="option_details">
                            <h3>Call Us</h3>
                            <p>Call our hotline.<br> <strong>Hotline : 011-33763892 / 0777565656</strong></p>
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
                            <p>Send your emails.<br> <strong>Email Address : customerservice@gasify.com</strong></p>
                        </div>
                    </div>
                </div>
                
            </div>
            
        </div>
    </div>
    

</section>

<script>
    // const form = document.querySelector(".typing-area"),
    // inputField = form.querySelector(".input-field"),
    // sendBtn = form.querySelector("button"),
    // chatBox = document.querySelector(".chat-area");

    // ;

    // sendBtn.onclick = () => {
    //     event.preventDefault();
    //         // var formData = new FormData();
    //         let xhr = new XMLHttpRequest(); //new xml object
    //         var url = 'http://localhost/mvc/Support/customer_send_message';
    //         console.log(url);
    //         xhr.open('POST', url , true);
    //         xhr.onload = ()=>{
    //             if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
    //                  inputField.value = "";
    //             }
    //         }
    //         let formData = new FormData(form);

    //         xhr.send(formData);

    // }

    // setInterval(()=>{
    //     let xhr = new XMLHttpRequest(); //new xml object
    //         var url = 'http://localhost/mvc/Support/customer_support';
    //         console.log(url);
    //         xhr.open('POST', url , true);
    //         xhr.onload = ()=>{
    //             if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
    //                  let data = xhr.response;
    //                  chatBox.innerHTML = data;
    //             }
    //         }
    //         let formData = new FormData(form);

    //         xhr.send(formData);

    // })

    
</script>