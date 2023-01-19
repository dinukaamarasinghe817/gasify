<?php

class ForgotPWD{

    public function __construct($name, $data = null){
        $this->$name($data);
    }

    public function reset($data){
        echo '<form action="'.BASEURL.'/signin/resetpassword" method="post">
        <h1>Password Reset</h1>
        <div class="error-txt">
            <p></p>
            <a>
            <svg width="25" height="25" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M17.6682 32.2388C25.9525 32.2388 32.6682 25.523 32.6682 17.2388C32.6682 8.9545 25.9525 2.23877 17.6682 2.23877C9.38391 2.23877 2.66818 8.9545 2.66818 17.2388C2.66818 25.523 9.38391 32.2388 17.6682 32.2388Z" stroke="" stroke-width="3.91255" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M22.1682 12.7388L13.1682 21.7388" stroke="" stroke-width="3.91255" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M13.1682 12.7388L22.1682 21.7388" stroke="" stroke-width="3.91255" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            </a>
        </div>
        <div class="info">
        <input name="email" type="email" placeholder="Email Address" required><br>
        </div>
        <button type="submit" name="submit">Send Password Reset Link</button><br>
    </form>';
    }

    public function verify($data){
        
    }
}

?>