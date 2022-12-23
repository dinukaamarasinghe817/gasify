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

        public function users($user = 'customer'){
            $data['url'] = BASEURL.'/signin/userssignin';
            if($user == 'admin' || $user == 'company' || $user == 'distributor'|| $user == 'customer' || $user == 'dealer' || $user == 'deliveryperson'){
                $this->view('signin/users', $data);
            }else{
                $this->view('home/index');
            }
        }

        public function userssignin(){
            $user = $_POST['user'];
            if($user == 'admin' || $user == 'company' || $user == 'distributor'|| $user == 'customer' || $user == 'dealer' || $user == 'deliveryperson'){
                $this->view('signin/user');
            }else{
                $this->view('home/index');
            }
        }

        // public function dealer($error = null){
        //     $data = [];

        //     if($error != null){
        //         switch($error){
        //             case '1':
        //                 $data['error'] = 'fill all the fields';
        //                 break;
        //             case '2':
        //                 $data['error'] = 'too many login attempts, recommend reset your password';
        //                 break;
        //             case '3':
        //                 $data['error'] = 'password missmatch';
        //                 break;
        //             case '4':
        //                 $data['error'] = 'invalid email';
        //                 break;
        //         }
                
        //     }
        //     $this->view('signin/dealer', $data);
        // }

        // public function dealersignin(){
        //     session_start();
        //     $email = $_POST['email'];
        //     $password = $_POST['password'];

        //     if(isEmpty(array($email, $password))){
        //         echo "fill all fields";
        //         $error = "1";
        //         header("Location: ./dealer/$error");
        //         return;
        //     }
            
        //     $result = $this->model('Dealer')->getDealer($email);
            
        //     if(mysqli_num_rows($result) > 0){
        //         $row = mysqli_fetch_assoc($result);
        //         if(password_verify($password, $row['password'])){
        //             if(isset($_SESSION['login_attempt'])){
        //                 $_SESSION['login_attempt'] = 0;
        //             }
        //             $dealer_id = $row['user_id'];
        //             $_SESSION['user_id'] = "$dealer_id";
        //             $_SESSION['role'] = 'dealer';
        //             header('Location: '.BASEURL.'/dashboard/dealer');
        //         }else{
        //             if(!isset($_SESSION['login_attempt'])){
        //                 $_SESSION['login_attempt'] = 0;
        //             }
        //             $_SESSION['login_attempt'] += 1;
        //             if($_SESSION['login_attempt'] > 5){
        //                 $error = "2";
        //             }else{
        //                 $error = "3";
        //             }
        //             header("Location: ./dealer/$error");
        //         }
        //     }else{
        //         $error = "4";
        //         header("Location: ./dealer/$error");
        //     }

        // }

        public function user($error = null){
            $data = [];

            if($error != null){
                switch($error){
                    case '1':
                        $data['error'] = 'fill all the fields';
                        break;
                    case '2':
                        $data['error'] = 'too many login attempts, recommend reset your password';
                        break;
                    case '3':
                        $data['error'] = 'password missmatch';
                        break;
                    case '4':
                        $data['error'] = 'invalid email';
                        break;
                }
                
            }
            $this->view('signin/user', $data);
        }

        public function usersignin(){
            // session_start();
            $email = $_POST['email'];
            $password = $_POST['password'];

            if(isEmpty(array($email, $password))){
                echo "fill all fields";
                $error = "1";
                header("Location: ./dealer/$error");
                return;
            }
            
            // $result = $this->model('Dealer')->getDealer($email);
            $result = $this->model('User')->getUser($email);
            
            if(mysqli_num_rows($result) > 0){
                $row = mysqli_fetch_assoc($result);
                if(password_verify($password, $row['password'])){
                    if(isset($_SESSION['login_attempt'])){
                        $_SESSION['login_attempt'] = 0;
                    }
                    $dealer_id = $row['user_id'];
                    $_SESSION['user_id'] = "$dealer_id";
                    $_SESSION['role'] = $row['type'];
                    header('Location: '.BASEURL.'/dashboard/'.$row['type']);
                }else{
                    if(!isset($_SESSION['login_attempt'])){
                        $_SESSION['login_attempt'] = 0;
                    }
                    $_SESSION['login_attempt'] += 1;
                    if($_SESSION['login_attempt'] > 5){
                        $error = "2";
                    }else{
                        $error = "3";
                    }
                    header("Location: ./user/$error");
                }
            }else{
                $error = "4";
                header("Location: ./user/$error");
            }
        }
    }
?>