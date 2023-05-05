<?php
    class Ajax extends Controller{
        public function __construct(){
            
        }

        public function index(){
            // $data['error'] = 'input all fields';
            // if($data['error']){
            //     echo $data['error'];
            // }else{
            //     $this->view('',$data);
            // }
            // $swap_var = array(
            //     "{RECIEVER_NAME}"=>"Dinuka Amarasinghe",
            //     "{VERIFICATION_URL}"=>BASEURL,
            //     "{RECIEVER_EMAIL}" => "dealer1@gasify.com",
            //     "{RECIEVER_PASSWORD}" => "1234567"
            //     );
            
            // $from = 'admin@gasify.com';
            // $to = 'dealer1@gasify.com';
            // $subject = 'Template Testing';
            // $body = file_get_contents('./emailTemplates/verify.php');
            // foreach(array_keys($swap_var) as $key){
            //     if(strlen($key) > 2 && trim($key) != ""){
            //         $body = str_replace($key,$swap_var[$key],$body);
            //     }
            // }
            // $mail = new Mail($from,$to,NULL,$subject,$body);
            // $mail->send();
            // echo 'success';
            echo randomString();
        }

        public function vehicle(){
            $data = $this->model('Distributor')->eligibleVechicles(49);
            var_dump($data);
        }

        public function just(){
            $stripeKey = 'hello world';
            echo $stripeKey;
            echo '<br>';
            echo encryptStripeKey($stripeKey);
            echo '<br>';
            echo decryptStripeKey(encryptStripeKey($stripeKey));
        }
    }
?>