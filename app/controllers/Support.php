<?php
session_start();
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header('Location: ' . BASEURL . '/home');
}

class Support extends Controller{
    function __construct(){
        parent::__construct();
    }


    public function customer_support(){

        $customer_id = $_SESSION['user_id'];
        $data['navigation'] = 'help';
       

        $customer_details = $this->model('Customer')->getCustomerImage($customer_id);
        $row = mysqli_fetch_assoc($customer_details);
        $data['image'] = $row['image'];
        $admin = $this->model('Customer')->getAdminId();
        $data['admin'] =  mysqli_fetch_assoc($admin);
        $admin_id = $data['admin']['user_id'];
        
        $data['messages'] = $this->model('Customer')->getMessages($customer_id,$admin_id);
    
        // $data['recieved_messages'] = $this->model('Customer')->getRecievedMessages($customer_id);

        // $data['products']= $this ->model('Customer')->getCompanyProducts($company_id);
        $this->view('customer/help/support',$data);
    }

    public function customer_send_message(){
        $customer_id = $_SESSION['user_id'];
        $data['navigation'] = 'help';

        $admin = $this->model('Customer')->getAdminId();
        $row =  mysqli_fetch_assoc($admin);
        $admin_id = $row['user_id'];

        // $admin_id = 9;
        $message = $_POST['message'];

        if(!empty($message)){
            $this->model('Customer')->sendMessage($customer_id, $admin_id, $message);
        }
        
        $this -> customer_support();


        // $data['']$this->model('Customer')->getCustomerSupportDetail($customer_id);

    }

}

?>