<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
class Mail{
    public $mail = null;
    function __construct($from,$to,$reciepName,$subject,$message,$link=null){
        $this->mail = new PHPMailer(true);
        //Server settings
        $this->mail->isSMTP();                                            //Send using SMTP
        $this->mail->Host       = 'localhost';                     //Set the SMTP server to send through
        $this->mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $this->mail->Username   = 'admin@gasify.com';                     //SMTP username
        $this->mail->Password   = '1234567';                               //SMTP password
        $this->mail->Port       = 25;                                    //TCP port (25) to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $this->mail->setFrom($from, "Gasify (Pvt.Ltd.)");    //Add a recipient
        $this->mail->addAddress($to);
        
        //message
        $body = "
        <h2>Hello $reciepName,</h2>
        <h3>".$message."</h3>
        <br/><br/>";
        if($link != null){
            $body .= "<a href='$link'>Click Here</a>";
        }
        
        //Content
        $this->mail->isHTML(true);                                  //Set email format to HTML
        $this->mail->Subject = $subject;
        $this->mail->Body    = $body;
    }

    public function send($message=null){
        try{
            $result = $this->mail->send();
            $data['toast'] = ['type' => 'success', 'message' => $message];
        }catch(Exception $e){
            $data['toast'] = ['type' => 'error', 'message' =>'phpmailer server error'];
        }
        return $data;
    }
}
?>