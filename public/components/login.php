<?php

class Login{

public function __construct(){
    echo '<div class="container">
            <div class="wrapper">
                <div class="logo">
                    <img src="'.BASEURL.'/public/img/login.png" alt="company logo">
                </div>
                <div class="form">
                    <form action="'.BASEURL.'/signin/usersignin" method="post">
                        <h1>Login</h1>
                        
                        <div class="info">
                            <input name="email" type="text" placeholder="Email Address"><br>
                            <input name="password" type="password" placeholder="Password"><br>
                            <p class="forgotpwd" ><a href="'.BASEURL.'/signin/forgetpassword/reset" >Forgot password?</a><br></p>
                        </div>
                        <button type="submit" name="submit">Login</button><br>
                        <p>Not Registered? <a href="'.BASEURL.'/signup/user">Create Account</a></p>
                    </form>
                </div>
            </div>
        </div>';
}

}