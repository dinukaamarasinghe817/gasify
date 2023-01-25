<?php

class ForgotPWD{

    public function __construct($name, $data = null){
        $this->$name($data);
    }

    public function reset($data){
        echo '<form action="'.BASEURL.'/signin/resetpassword" method="post">
        <h1>Password Reset</h1>
        <div class="info">
        <input name="email" type="email" placeholder="Email Address" required><br>
        </div>
        <button type="submit" name="submit">Send Password Reset Link</button><br>
    </form>';
    }

    public function verify($data){
        $token = $data['token'];
        $email = $data['email'];
        echo '<form action="'.BASEURL.'/signin/passwordverifyinput/'.$token.'/'.$email.'" method="post">
        <div class="info">
        <input name="password" type="password" placeholder="New password" required><br>
        <input name="confirmpassword" type="password" placeholder="Confirm new password" required><br>
        </div>
        <button type="submit" name="submit">Submit</button><br>
    </form>';
    }
}

?>