<?php
    // if(isset($data['toast'])){
    //     $error = new Prompt('toast',$data['toast']);
    //     echo '<script>
    //         showToast();
    //     </script>';
    // }
    $header = new Header("login",$data);
?>
<script>
    function CompanySignUp(){
        var idArr = ["companyname","fname","lname","email","password","confirmpassword","city","street","image"]
        var isOk=true;
        for (let index = 0; index < idArr.length; index++) {
            if(idArr[index]=="city"){
                if(document.getElementById(idArr[index]).value==-1){
                    isOk=false;
                    document.getElementById("addresserr").innerHTML="Enter address";
                }else{
                    document.getElementById("addresserr").innerHTML="";
                }
            }else if(idArr[index]=="email"){
                var regex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
                var email=document.getElementById("email").value;
                if(email.match(regex)){
                    document.getElementById("emailerr").innerHTML="";
                }else{
                    isOk=false;
                    document.getElementById("emailerr").innerHTML="Invalid email";
                }

            }
            else if(idArr[index]=="password" || idArr[index]=="confirmpassword"){
                if((document.getElementById("password").value.length==0 || document.getElementById("confirmpassword").value.length==0) ||(document.getElementById("password").value !=document.getElementById("confirmpassword").value) ){
                    isOk=false;
                    document.getElementById("passworderr").innerHTML="Check password";
                }else{
                    let parameters = {
                        count : false,
                        letters : false,
                        numbers : false,
                        special : false
                    }
                    let password = document.getElementById("password").value;
                    parameters.letters = (/[A-Za-z]+/.test(password))?true:false;
                    parameters.numbers = (/[0-9]+/.test(password))?true:false;
                    parameters.special = (/[!\”$%&/()=?@~`\\.\’;:+=^*_-]+/.test(password))?true:false;
                    parameters.count = (password.length > 7)?true:false;
                    let exists = Object.values(parameters).includes(false);
                    if(exists){
                        document.getElementById("passworderr").innerHTML="password should at least 8 characters long and include atleast one uppercase, lowercase, number and a special character";
                        isOk=false;
                    }else{
                        document.getElementById("passworderr").innerHTML="";
                    }

                }

            }else if (idArr[index] == "image") {
                let allowedExtensions = ['image/jpeg', 'image/jpg', 'image/png'];
                if(document.getElementById("image").value != "") {
                    let type = document.getElementById('image').files[0].type;
                    if (allowedExtensions.indexOf(type) > -1) {
                    document.getElementById("imageerr").innerHTML = "";
                    } else {
                        isOk = false;
                        document.getElementById("imageerr").innerHTML = "Invalid image type";
                    }
                }
                
            }else{
                if(document.getElementById(idArr[index]).value.length==0){
                    isOk=false;
                    if(idArr[index]=="companyname"){
                        document.getElementById("companynameerr").innerText="Enter company name";
                    }else if(idArr[index]=="fname"){
                        document.getElementById("fnameerr").innerHTML="Enter first name";
                    }else if(idArr[index]=="lname"){
                        document.getElementById("lnameerr").innerHTML="Enter last name";
                    }else if(idArr[index]=="email"){
                        document.getElementById("emailerr").innerHTML="Enter email";
                    }else if(idArr[index]=="street"){
                        document.getElementById("addresserr").innerHTML="Enter address";
                    }
                    
                }else{
                    if(idArr[index]=="companyname"){
                        document.getElementById("companynameerr").innerText="";
                    }else if(idArr[index]=="fname"){
                        document.getElementById("fnameerr").innerHTML="";
                    }else if(idArr[index]=="lname"){
                        document.getElementById("lnameerr").innerHTML="";
                    }else if(idArr[index]=="email"){
                        document.getElementById("emailerr").innerHTML="";
                    }else if(idArr[index]=="street"){
                        document.getElementById("addresserr").innerHTML="";
                    } 
                }
            }
            //console.log(idArr[index]+"---->"+document.getElementById(idArr[index]).value)
            //const element = idArr[index];
            
        }
        if(isOk){
            document.getElementById("companySignUp").submit();
        }
        /*if(document.getElementById("confirmPassword").value==document.getElementById("password").value){
            
        }*/
    }

</script>
    <div class="container">
        <div class="wrapper">
            <div class="logo">
                <img src="<?php echo BASEURL; ?>/public/img/login.png" alt="company logo">
            </div>
            <div class="form" >
                <form action="<?php echo BASEURL;?>/signup/companySignUp" method="post" enctype="multipart/form-data" id="companySignUp" class="companySignUp">
                    <h1>Signup</h1>
                        <p></p>
                        <a>
                        <svg width="25" height="25" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.6682 32.2388C25.9525 32.2388 32.6682 25.523 32.6682 17.2388C32.6682 8.9545 25.9525 2.23877 17.6682 2.23877C9.38391 2.23877 2.66818 8.9545 2.66818 17.2388C2.66818 25.523 9.38391 32.2388 17.6682 32.2388Z" stroke="" stroke-width="3.91255" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M22.1682 12.7388L13.1682 21.7388" stroke="" stroke-width="3.91255" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M13.1682 12.7388L22.1682 21.7388" stroke="" stroke-width="3.91255" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        </a>
                    <div style="margin-bottom:0%">
                        
                        <div class="info">
                            <label for="" class="part">Company Info</label>
                            <div class="address owner">
                                <input name="Companyname" type="text" placeholder="Company name" id="companyname"required>
                            </div>
                            <div id="companynameerr" style="width:90%;margin-right:0px;text-align:center;color:red;font-size:smaller"></div>
                            <div class="address password">
                                <input name="fname" class="half" type="text" placeholder="First name" style="width:42.5%;margin-right:0px" id="fname"required><br>
                                <input name="lname" class="half" type="text" placeholder="Last name" style="width:42.5%;margin-right:0px;margin-left:5%" id="lname" required><br>
                            </div>
                            <div class="address password">
                                <div id="fnameerr" style="width:42.5%;margin-right:0px;text-align:center;color:red;font-size:smaller"></div>
                                <div id="lnameerr" style="width:42.5%;margin-right:0px;margin-left:5%;text-align:center;color:red;font-size:smaller"></div>
                            </div>
                            <input name="email" type="email" placeholder="Email address" id="email" required><br>
                            <div id="emailerr" style="width:90%;margin-right:0px;text-align:center;color:red;font-size:smaller"></div>

                            <div class="address password">
                                <input name="password" class="half" type="password" placeholder="Password" style="width:42.5%;margin-right:0px" id="password" required><br>
                                <input name="confirmpassword" class="half" type="password" placeholder="Confirm password" style="width:42.5%;margin-right:0px;margin-left:5%" id="confirmpassword" required><br>
                            </div>
                            <div id="passworderr" style="width:90%;margin-right:0px;text-align:center;color:red;font-size:smaller"></div>
                            <div class="address">
                                    <select id="city" name="city" class="half" data-dropup-auto="false" style="width:42.5%;margin-right:0px">
                                        <option  value="-1" selected disabled hidden>Select your city</option>
                                        <?php 
                                            // include_once '../../model/functions/functions.php';
                                            foreach (CITIES as $city){
                                                echo "<option value=$city>$city</option>";
                                            }
                                        ?>
                                    </select>
                                <input name="street" id="street" class="half" type="text" placeholder="Street" style="width:42.5%;margin-right:0px;margin-left:5%" required>
                            </div>
                            <div id="addresserr" style="width:90%;margin-right:0px;text-align:center;color:red;font-size:smaller"></div>
                            <label for="image">
                                <svg width="20" height="20" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M29.0299 2.44482H5.69661C3.85567 2.44482 2.36328 3.93721 2.36328 5.77816V29.1115C2.36328 30.9524 3.85567 32.4448 5.69661 32.4448H29.0299C30.8709 32.4448 32.3633 30.9524 32.3633 29.1115V5.77816C32.3633 3.93721 30.8709 2.44482 29.0299 2.44482Z" stroke="black"  stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M11.5303 14.1113C12.911 14.1113 14.0303 12.992 14.0303 11.6113C14.0303 10.2306 12.911 9.11133 11.5303 9.11133C10.1496 9.11133 9.03027 10.2306 9.03027 11.6113C9.03027 12.992 10.1496 14.1113 11.5303 14.1113Z" stroke="black"  stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M32.363 22.4447L24.0296 14.1113L5.69629 32.4447" stroke="black"  stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                &nbsp; Upload your photo
                            </label>
                            <input name="image" id="image" type="file" value="Upload Company logo">
                            <div class="address password">
                            <div id="imageerr" style="width:90%;margin-right:0px;text-align:center;color:red;font-size:smaller"></div>
                            </div>
                        </div>
                    </div>
                    <input type="button" name="Sign Up" value="Sign Up" class="submit" onClick="CompanySignUp()" style="background-color: var(--button-blue);font-family: 'Poppins', sans-serif;font-size:1.1em;color:white;cursor:pointer"><br>
                    <p>Already Registered? <a href="<?php echo BASEURL;?>/signin/user" style="font-family: 'Poppins', sans-serif">Login now</a></p>
                </form>
            </div>
        </div>
    </div>
    
<?php
$footer = new Footer("signin");
?>
