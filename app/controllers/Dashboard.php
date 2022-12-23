<?php
    session_start();
    if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
        header('Location: ' . BASEURL . '/home');
    }
    class Dashboard extends Controller{
        public function __construct(){
            
        }

        public function dealer($error = null){
            $dealer_id = $_SESSION['user_id'];
            // get the current stock
            $data['stock'] = $this->model('Dealer')->getcurrentstock($dealer_id);
            $dealer_details = $this->model('Dealer')->getDealerImage($dealer_id);
            $row = mysqli_fetch_assoc($dealer_details);
            $data['image'] = $row['image'];
            // get new pending orders
            $result1 = $this->model('Dealer')->getpendigorders($dealer_id);
            $data['pending'] = $result1; // multi dimensional array
            // result1 [
            //     [0] = [
            //         'row' => $row,
            //         'products' => [
            //                             [0] = product1,
            //                             [1] = product2,
            //                             [2] = product3,
            //                         ]
            //         ],
            //     [1] = [
            //         'row' => $row,
            //         'products' => [
            //                             [0] = product1,
            //                             [1] = product2,
            //                             [2] = product3,
            //                         ]
            //             ]
            // ]
            $data['navigation'] = 'dashboard';
            $this->view('dashboard/dealer', $data);
        }
    }
?>