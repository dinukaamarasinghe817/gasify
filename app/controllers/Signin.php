<?php
    session_start();
    if (isset($_SESSION['user_id']) && isset($_SESSION['role'])) {
        $role = $_SESSION['role'];
        header('Location: ' . BASEURL . '/dashboard/'.$role);
    }
    class Signin extends Controller{
        public function __construct(){
            // echo "this is the signin controller";
        }

        public function user($error = null){
            $data = [];

            if($error != null){
                switch($error){
                    case '1':
                        $data['toast'] = ['type'=>"error", 'message'=>"fill all the fields"];
                        break;
                    case '2':
                        $data['toast'] = ['type'=>"error", 'message'=>"too many login attempts, recommend reset your password"];
                        break;
                    case '3':
                        $data['toast'] = ['type'=>"error", 'message'=>"password missmatch"];
                        break;
                    case '4':
                        $data['toast'] = ['type'=>"error", 'message'=>"invalid email"];
                        break;
                    case '5':
                        $data['toast'] = ['type'=>"success", 'message'=>"Please check your email and reset your password"];
                        break;
                }
                
            }
            $this->view('signin/user', $data);
        }

        public function usersignin(){
            // form information
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            // check if user is already registered
            $result = $this->model('User')->getUser($email);
            $data = $this->model('User')->userSignin($email,$password);
            if($data['success']){
                header('Location: '.BASEURL.'/dashboard/'.$_SESSION['role']);
            }else{
                header('Location: '.BASEURL.'/signin/user/'.$data['error']);
            }
        }

        public function forgetpassword($variant,$error=null){
            $data['variant'] = $variant;
            if($error != null){
                $data['toast'] = ['type'=> 'error', 'message' => $error];
            }
            $this->view("signin/forgetpassword",$data);
        }

        public function resetpassword(){
            $email = $_POST['email'];

            $data = $this->model('User')->resetPassword($email);
            if(isset($data['toast'])){
                $toast = $data['toast'];
                if($toast['type'] == 'error'){
                    $data['variant'] = 'reset';
                    $this->view("signin/forgetpassword",$data);
                }else{
                    $this->user('5');
                }
            }
        }

        public function passwordverify($token='',$email='',$data=[]){
            $data['token'] = $token;
            $data['email'] = $email;
            $data['variant'] = 'verify';
            $this->view("signin/forgetpassword",$data);

        }

        public function passwordverifyinput($token='',$email=''){
            $password = $_POST['password'];
            $confirmpassword = $_POST['confirmpassword'];
            $data = $this->model('User')->passwordverify($password,$confirmpassword,$token,$email);
            if(isset($data['toast'])){
                $toast = $data['toast'];
                if($toast['type'] == 'error'){
                    $this->passwordverify($token,$email,$data);
                }else{
                    $this->view('signin/user', $data);
                }
            }
        }
    }
?>