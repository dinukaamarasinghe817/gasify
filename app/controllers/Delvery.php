<?php
    session_start();
class Delvery extends Controller{
    public $user_id;
    function __construct(){
        $this->user_id = $_SESSION['user_id'];
    }
    function deliveries(){
        $data['navigation'] = 'deliveries';
        $delivery_id=$_SESSION['user_id'];
        $delivery_details = $this->model('Delivery')->getDeliveryImage($delivery_id);
        $pool_details=$this->model('Delivery')->getPoolDetails();
        $row = mysqli_fetch_assoc($delivery_details);
        $data['image'] = $row['image'];
        $data['name']=$row['first_name'].' '.$row['last_name'];
        $data['pool']=$pool_details;
            //$data=[];
        $this->view('dashboard/delivery', $data);
    }
    function currentdeliveries(){
        $data['navigation'] = 'currentgasdeliveries';
        $delivery_id=$_SESSION['user_id'];
        $delivery_details = $this->model('Delivery')->getDeliveryImage($delivery_id);
        $current_reliveries=$this->model('Delivery')->getCurrentDeliveries($delivery_id);
        $row = mysqli_fetch_assoc($delivery_details);
        $data['current']=$current_reliveries;
        $data['image'] = $row['image'];
        $data['name']=$row['first_name'].' '.$row['last_name'];
            //$data=[];
        $this->view('dashboard/delivery', $data);
    }
    function acceptDelivery(){
        $orderID = $_POST["orderID"];
        $delivery_id=$_SESSION['user_id'];
        $message=$this->model('Delivery')->acceptDelivery($orderID,$delivery_id);
        echo $message;
    }
    function reviews(){
        $data['navigation'] = 'reviews';
        $delivery_id=$_SESSION['user_id'];
        $delivery_details = $this->model('Delivery')->getDeliveryImage($delivery_id);
        //$current_reliveries=$this->model('Delivery')->getCurrentDeliveries($delivery_id);
        $row = mysqli_fetch_assoc($delivery_details);
        //$data['current']=$current_reliveries;
        $data['image'] = $row['image'];
        $data['name']=$row['first_name'].' '.$row['last_name'];
        $data['reviews']=$this->model('Delivery')->getReviewDetails();
            //$data=[];
        $this->view('dashboard/delivery', $data);
    }

    public function getdeliverypeople($option){
        $data = $this->model("Dealer")->getdeliverypeople($option,$this->user_id);
        $data['navigation'] = 'delivery';
        $data['option'] = $option;
        $this->view('dealer/deliverypeople',$data);
    }
    /*function reports(){
        $data['navigation'] = 'reports';
        $delivery_id=$_SESSION['user_id'];
        $delivery_details = $this->model('Delivery')->getDeliveryImage($delivery_id);
        $joinedDate = $this->model('Delivery')->getRegisteredDate($delivery_id);
        $currentDate=explode("-",date('Y-m-d'));
        //$current_reliveries=$this->model('Delivery')->getCurrentDeliveries($delivery_id);
        $row = mysqli_fetch_assoc($delivery_details);
        $data['name']=$row['first_name'].' '.$row['last_name'];
        //$data['current']=$current_reliveries;
        //echo($joinedDate);
        $data['image'] = $row['image'];
        $data['joinedDate']=$joinedDate;
        $data['currentDate']=$currentDate;
        $this->view('dashboard/delivery', $data);
    }*/
    public function deliveryReports(){
        $data['navigation'] = 'reports';
        $delivery_id=$_SESSION['user_id'];
        $delivery_details = $this->model('Delivery')->getDeliveryImage($delivery_id);
        $joinedDate = $this->model('Delivery')->getRegisteredDate($delivery_id);
        $currentDate=explode("-",date('Y-m-d'));
        $data['joinedDate']=$joinedDate;
        $data['currentDate']=$currentDate;
        //$current_reliveries=$this->model('Delivery')->getCurrentDeliveries($delivery_id);
        $row = mysqli_fetch_assoc($delivery_details);
        $data['name']=$row['first_name'].' '.$row['last_name'];
        //$data['current']=$current_reliveries;
        $data['image'] = $row['image'];
        $this->view('dashboard/delivery',$data);
    }
    function cancelDelivery(){
        $orderID = $_POST["orderID"];
        $message=$this->model('Delivery')->cancelDelivery($orderID);
        return $message;
    }
    function deliverJob(){
        $orderID = $_POST["orderID"];
        $data['date']=date('Y-m-d');
        $message=$this->model('Delivery')->setReservationStateDelivered($orderID,$data['date']);
        return $message;
    }function getCharts(){
        $delivery_id=$_SESSION['user_id'];
        $joinedDate = $this->model('Delivery')->getRegisteredDate($delivery_id);
        $currentDate=explode("-",date('Y-m-d'));
        $data['joinedDate']=$joinedDate;
        $data['currentDate']=$currentDate;
        $data['navigation'] = 'reports';
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $deliveryID=$_SESSION['user_id'];
        $yearFrom=mysqli_real_escape_string($conn,$_POST['yearFrom']);
        $monthFrom=mysqli_real_escape_string($conn,$_POST['monthFrom']);
        $yearTo=mysqli_real_escape_string($conn,$_POST['yearTo']);
        $monthTo=mysqli_real_escape_string($conn,$_POST['monthTo']);
        $currentDate=explode("-",date('Y-m-d'));
        $deliveredOrders = $this->model('Delivery')->getDeliveredOrders($deliveryID);
        $processedDates=array();
        $orderCount=array();
        $colors=array("green","rgba(30, 105, 176, 1)","rgba(23, 45, 89, 1)","rgb(255, 128, 0)","rgb(0, 0, 255)","rgb(255, 0, 191)","rgb(102, 204, 255)");
        for ($i=0; $i <50 ; $i++) { 
            shuffle($colors);
        }
        $data['doughnutColors']='[';
        foreach($colors as $item){
            $data['doughnutColors'].="\"".$item."\",";
            
        }
        $data['doughnutColors']=rtrim($data['doughnutColors'],",");
        $data['doughnutColors'].="]";
        /*doughnut colors*/
        /*bar chart colors*/
        for ($i=0; $i <50 ; $i++) { 
            $rand_color=array_rand($colors);
        }
        $data['barColor']=$colors[$rand_color];
        foreach($deliveredOrders as $row){
            $date=explode('-',$row);
            if(!(in_array($date[0].'-'.$date[1],$processedDates))){
                $d=$date[0].'-'.$date[1];
                //print_r(intval($date[0]).'--'.$yearFrom.'\n');
                array_push($processedDates,$date[0].'-'.$date[1]);
                if((intval($date[0])==intval($yearFrom)) ){
                    $count=0;//array_push($processedDates,$date[0].'-'.$date[1]);
                    //print_r("gdf");
                    foreach($deliveredOrders as $row2){
                        $date2=explode('-',$row2);
                        if(($date2[0])==intval($date[0])){
                            if(intval($date2[1]==$date[1]) && (intval($date2[1])>=intval($monthFrom))){
                                $count=$count+1;
                                //break;
                            }
    
                        }
    
                    }
                    array_push($orderCount,$count);
                    $orderCount+=array($d=>$count);
                }else if((intval($date[0])==intval($yearTo)) ){
                    $count=0;
                    foreach($deliveredOrders as $row2){
                        $date2=explode('-',$row2);
                        if(($date2[0])==intval($date[0])){
                            if((intval($date2[1])==intval($date[1])) && (intval($date2[1])<=intval($monthTo))){
                                $count=$count+1;
                                //break;
                            }
    
                        }
    
                    }
                    array_push($orderCount,$count);

                }else if((intval($date[0])<intval($yearTo))&& (intval($date[0])>intval($yearFrom))){
                    $count=0;
                    foreach($deliveredOrders as $row2){
                        $date2=explode('-',$row2);
                        if(($date2[0])==intval($date[0])){
                            if((intval($date2[1])==intval($date[1]))){
                                $count=$count+1;
                                //break;
                            }
    
                        }
    
                    }
                    array_push($orderCount,$count);

                }

            }
            
        }
        $barChart=array();
        $barChart['dates']=$processedDates;
        $barChart['values']=$orderCount;
        $data['barChart']=$barChart;
        $this->view('dashboard/delivery', $data);  
        //print_r($processedDates);
        //print_r("---------------------");
        //print_r($orderCount);
    }
}
?>
