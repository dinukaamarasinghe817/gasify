<?php
$header = new Header("customer/bank_slip_upload",$data);
$sidebar = new Navigation('customer',$data['navigation']);
?>

<section class="body">
    <?php
        // call the default header for yout interface
        $bodyheader = new BodyHeader($data);
        if(isset($data['toast'])){
            $error = new Prompt('toast',$data['toast']);

        }
        
    ?>

    <div class="under_topbar">
        <div class="subtitle">
           <h3>Upload Bank Slip</h3>
        </div> 
        <?php
            if(isset($data['bank_details'])){
                while( $row = mysqli_fetch_assoc($data['bank_details'])){
                    $bank_name = $row['bank'];
                    $acc_no = $row['account_no'];
                    $acc_holder_name = $row['full_name'];

                }
            }
        
        ?>
        
        <div class="bank_details">
                <?php
                    echo "<span><strong>Account Holder's Name :</strong> $acc_holder_name</span>
                          <span><strong>Dealer's Bank Name :</strong> $bank_name</span>
                          <span><strong>Dealer's Bank Account No :</strong> $acc_no</span>";
                ?>
                </div>

                <div class="upload_box">
                    <div class="box_area">
                        <div class="image">
                            <img src="" alt="">
                        </div>
                        <div class="content">
                            <div class="icon">
                                <!-- <i class="fas fa-cloud-upload-alt"></i> -->
                                <svg width="76" height="76" viewBox="0 0 76 76" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M42.75 0C31.255 0 21.185 8.17 19 19C8.55 19 0 27.55 0 38C0 41.515 1.045 44.745 2.66 47.5H23.75L42.75 28.5L61.75 47.5H75.145C75.715 45.98 76 44.46 76 42.75C76 36.575 72.01 30.495 66.5 28.5V23.75C66.5 10.64 55.86 0 42.75 0ZM42.75 42.75L19 66.5H38V71.25C38 72.5098 38.5004 73.718 39.3912 74.6088C40.282 75.4996 41.4902 76 42.75 76C44.0098 76 45.218 75.4996 46.1088 74.6088C46.9996 73.718 47.5 72.5098 47.5 71.25V66.5H66.5L42.75 42.75Z" fill="#F9896B"/>
                                </svg>
                            </div>
                            <div class="text">
                                No file chosen, yet!
                            </div>
                        </div>
                        <div id="cancel-btn">
                        <!-- <i class="fas fa-times"></i> -->
                            <svg width="25" height="25" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17.6682 32.2388C25.9525 32.2388 32.6682 25.523 32.6682 17.2388C32.6682 8.9545 25.9525 2.23877 17.6682 2.23877C9.38391 2.23877 2.66818 8.9545 2.66818 17.2388C2.66818 25.523 9.38391 32.2388 17.6682 32.2388Z" stroke="" stroke-width="3.91255" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M22.1682 12.7388L13.1682 21.7388" stroke="black" stroke-width="3.91255" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M13.1682 12.7388L22.1682 21.7388" stroke="black" stroke-width="3.91255" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div class="file-name">
                            File name here
                        </div>
                    </div>
                    <form action="<?php echo BASEURL?>/Orders/get_bank_slip" method="post" enctype="multipart/form-data">
                        <div class="buttons">
                            <button  id="back_btn" onclick= "document.location.href = '../Orders/select_payment_method';">Back</button>
                            <!-- <button onclick="defaultBtnActive()" id="custom_btn">Choose a file</button> -->
                            <label for="custom_btn" id="custom-btn">Choose File</label>
                            <input id="custom_btn" type="file" accept=".png, .jpg, .jpeg"  name="slip_img" hidden>
                            <!-- <button  id="next_btn" type="submit" onclick="location.href = '<?php echo BASEURL?>/Orders/select_collecting_method'">Submit</button> -->
                            <button  id="next_btn" type="submit" name="submit_btn">Submit</button>
                            
                        </div>
                    </form>
                </div>
      

            </div>


  


        <!-- <div class="bottom">
            <a href="<?php echo BASEURL; ?>/Products/select_products/2" class="btn">Next</a>
        </div> -->
    </div>

    <script>
         const wrapper = document.querySelector(".box_area");
         const fileName = document.querySelector(".file-name");
         const defaultBtn = document.querySelector("#default-btn");
         const customBtn = document.querySelector("#custom_btn");
         const cancelBtn = document.querySelector("#cancel-btn svg");
         const img = document.querySelector(".image img");
         let regExp = /[0-9a-zA-Z\^\&\'\@\{\}\[\]\,\$\=\!\-\#\(\)\.\%\+\~\_ ]+$/;
         function customBtnActive(){
           customBtn.click();
         }
         customBtn.addEventListener("change", function(){
           const file = this.files[0];
           if(file){
               const reader = new FileReader();
               reader.onload = function(){
               const result = reader.result;
               img.src = result;
               wrapper.classList.add("active");
             }
             cancelBtn.addEventListener("click", function(){
               img.src = "";
               wrapper.classList.remove("active");
               customBtn.value = "";

               
             })
             reader.readAsDataURL(file);
           }
           if(this.value){
             let valueStore = this.value.match(regExp);
             fileName.textContent = valueStore;
           }
         });
    </script>
</section>

<?php
$footer = new Footer("customer");
?>