<?php
    $header = new Header("login",$data);
    $registration = new Registration('company',$data);
    $footer = new Footer("signin");
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
            console.log("hello");
            document.getElementById("companySignUp").submit();
        }
    }
</script>
