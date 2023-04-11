<?php
    session_start();
class Compny extends Controller{
    function __construct(){
        if(isset($_POST['productImage '])){
            echo "done";
            die();
        }
        
    }

    function dealer(){
        $data['navigation'] = 'dealer';
        $company_id=$_SESSION['user_id'];
        $company_details = $this->model('Company')->getCompanyImage($company_id);
        $dealer_details = $this->model('Company')->getRegisteredDealers($company_id);
        $row = mysqli_fetch_assoc($company_details);
        $data['image'] = $row['logo'];
        //$row = mysqli_fetch_assoc($dealer_details);
        $data['dealer']=$dealer_details;
        //$data['cc']=$row['account_no'];
        //echo $data['cc'];
            //$data=[];
        $this->view('dashboard/company', $data);
    }
    function distributor(){
        $data['navigation'] = 'distributor';
        $company_id=$_SESSION['user_id'];
        $company_details = $this->model('Company')->getCompanyImage($company_id);
        $distributor_details = $this->model('Company')->getRegisteredDistributors($company_id);
        $row = mysqli_fetch_assoc($company_details);
        $data['image'] = $row['logo'];
        $data['distributor']=$distributor_details;
        $this->view('dashboard/company', $data);
    }function products(){
        $data['navigation'] = 'products';
        $company_id=$_SESSION['user_id'];
        $company_details = $this->model('Company')->getCompanyImage($company_id);
        $product_details = $this->model('Company')->getProductDetails($company_id);
        $data['products']=$product_details;
        $row = mysqli_fetch_assoc($company_details);
        $data['image'] = $row['logo'];
            //$data=[];
        $this->view('dashboard/company', $data);
    }function regproducts(){
        $data['navigation'] = 'regproducts';
        $company_id=$_SESSION['user_id'];
        $company_details = $this->model('Company')->getCompanyImage($company_id);
        $row = mysqli_fetch_assoc($company_details);
        $data['image'] = $row['logo'];
            //$data=[];
        $this->view('dashboard/company', $data);
    }function regDealer(){
        $data['navigation'] = 'regDealer';
        $company_id=$_SESSION['user_id'];
        $company_details = $this->model('Company')->getCompanyImage($company_id);
        //$product_details = $this->model('Company')->getProductDetails($company_id);
        //$data['products']=$product_details;
        $row = mysqli_fetch_assoc($company_details);
        $data['image'] = $row['logo'];
        $this->view('dashboard/company', $data);
    }function regDistributor(){
        $data['navigation'] = 'regDistributor';
        $company_id=$_SESSION['user_id'];
        $company_details = $this->model('Company')->getCompanyImage($company_id);
        //$product_details = $this->model('Company')->getProductDetails($company_id);
        //$data['products']=$product_details;
        $row = mysqli_fetch_assoc($company_details);
        $data['image'] = $row['logo'];
        $this->view('dashboard/company', $data);
    }function updateProducts(){
        $data['navigation'] = 'updateProducts';
        $company_id=$_SESSION['user_id'];
        $company_details = $this->model('Company')->getCompanyImage($company_id);
        $product_details = $this->model('Company')->getProductDetails($company_id);
        //print_r($product_details);
        $data['products']=$product_details;
        $row = mysqli_fetch_assoc($company_details);
        $data['image'] = $row['logo'];
        $this->view('dashboard/company', $data);
    }
    function registerProducts(){
        $lastUpdatedDate = date("Y-m-d");
        $img_name = $_FILES['productImage']['name'];
        $time=time();
        $img_name = $time.$img_name;
        move_uploaded_file($_FILES['productImage']['tmp_name'],$_SERVER["DOCUMENT_ROOT"]."/mvc/public/img/products/".$img_name);
        $data=array('company_id'=>$_SESSION['user_id'],'name'=>$_POST['Productname'],'type'=>$_POST['Producttype'],'unit_price'=>$_POST['unitprice'],'weight'=>$_POST['weight'],'image'=>$img_name,'production_time'=>$_POST['productiontime'],'last_updated_date'=>$lastUpdatedDate,'quantity'=>$_POST['quantity']);
        $this->model('Company')->registerNewProduct($data);
        $this->products();
    }
    function registerDealer(){
        $img_name = $_FILES['productImage']['name'];
        $time=time();
        $img_name = $time.$img_name;
        $data=array();
        move_uploaded_file($_FILES['productImage']['tmp_name'],$_SERVER["DOCUMENT_ROOT"]."/mvc/public/img/people/".$img_name);
        if(strpos($_POST['name']," ")!== false){
            
            $data=array('email'=>$_POST['email'],'password'=>$_POST['password'],'first_name'=>explode(" ",$_POST['name'])[0],'last_name'=>explode(" ",$_POST['name'])[1],'verification_code'=>'testcode','verification_state'=>'verified');
            $this->model('Company')->registerUser($data);
            //print_r($_POST['distributor_id']);
            $dealer_id=$this->model('Company')->getDealerID('distributor1@gasify.com');
            //$data=array('email'=>$_POST['email'],'password'=>$_POST['password'],'first_name'=>explode(" ",$_POST['name'])[0],'last_name'=>explode(" ",$_POST['name'])[1],'verification_code'=>'testcode','verification_state'=>'verified');
            $data=array('dealer_id'=>$dealer_id,'name'=>$_POST['name'],'city'=>$_POST['city'],'street'=>$_POST['street'],'company_id'=>$_SESSION['user_id'],'distributor_id'=>$_POST['distributor_id'],'bank'=>$_POST['bank'],'account_no'=>$_POST['bank_acc'],'merchant_id'=>(int)(strval($_SESSION['user_id']).$_POST['distributor_id'].strval($dealer_id)),'contact_no'=>$_POST['cno'],'image'=>$img_name);
            $this->model('Company')->registerNewDealer($data);
            //echo $data;
        }else{
            $data=array('email'=>$_POST['email'],'password'=>$_POST['password'],'first_name'=>$_POST['name'],'verification_code'=>'testcode','verification_state'=>'verified');
            $this->model('Company')->registerUser($data);
            $dealer_id=$this->model('Company')->getDealerID('distributor1@gasify.com');
            $data=array('dealer_id'=>$dealer_id,'name'=>$_POST['name'],'city'=>$_POST['city'],'street'=>$_POST['street'],'company_id'=>$_SESSION['user_id'],'distributor_id'=>$_POST['distributor_id'],'bank'=>$_POST['bank'],'account_no'=>$_POST['bank_acc'],'merchant_id'=>(int)(strval($_SESSION['user_id']).$_POST['distributor_id'].strval($dealer_id)),'contact_no'=>$_POST['cno'],'image'=>$img_name);
            $this->model('Company')->registerNewDealer($data);
            //print_r ($data);
            
            //print_r($_POST['distributor_id']);
        }
        $this->dealer();
        
        //move_uploaded_file($_FILES['productImage']['tmp_name'],$_SERVER["DOCUMENT_ROOT"]."/mvc/public/img/products/".$img_name);
        //$data=array('company_id'=>$_SESSION['user_id'],'name'=>$_POST['Productname'],'type'=>$_POST['Producttype'],'unit_price'=>$_POST['unitprice'],'weight'=>$_POST['weight'],'image'=>$img_name,'production_time'=>$_POST['productiontime'],'last_updated_date'=>$lastUpdatedDate,'quantity'=>$_POST['quantity']);
        //$data2=array('email'=>$_POST['quantity'],'password'=>$_POST['quantity'],'first_name'=>$_POST['quantity'],'last_name'=>$_POST['quantity'],'type'=>"dealer");
        //$this->model('Company')->registerNewProduct($data);
    }
    function registerDistributor(){
        $img_name = $_FILES['productImage']['name'];
        $time=time();
        $img_name = $time.$img_name;
        $data=array();
        move_uploaded_file($_FILES['productImage']['tmp_name'],$_SERVER["DOCUMENT_ROOT"]."/mvc/public/img/people/".$img_name);
        if(strpos($_POST['name']," ")!== false){
            
            $data=array('email'=>$_POST['email'],'password'=>$_POST['password'],'first_name'=>explode(" ",$_POST['name'])[0],'last_name'=>explode(" ",$_POST['name'])[1],'verification_code'=>'testcode','verification_state'=>'verified');
            $this->model('Company')->registerUser($data);
            //print_r($_POST['distributor_id']);
            $distributor_details=$this->model('Company')->getDealerID($_POST['email']);
            //$data=array('email'=>$_POST['email'],'password'=>$_POST['password'],'first_name'=>explode(" ",$_POST['name'])[0],'last_name'=>explode(" ",$_POST['name'])[1],'verification_code'=>'testcode','verification_state'=>'verified');
            $data=array('distributor_id'=>$distributor_details,'contact_no'=>$_POST['cno'],'company_id'=>$_SESSION['user_id'],'hold_time'=>0,'city'=>$_POST['city'],'street'=>$_POST['street'],'image'=>$img_name);
            $this->model('Company')->registerNewDistributor($data);
            //echo $data;
        }else{
            $data=array('email'=>$_POST['email'],'password'=>$_POST['password'],'first_name'=>$_POST['name'],'verification_code'=>'testcode','verification_state'=>'verified');
            $this->model('Company')->registerUser($data);
            $distributor_details=$this->model('Company')->getDealerID($_POST['email']);
            $data=array('distributor_id'=>$distributor_details,'contact_no'=>$_POST['cno'],'company_id'=>$_SESSION['user_id'],'hold_time'=>0,'city'=>$_POST['city'],'street'=>$_POST['street'],'image'=>$img_name);
            $this->model('Company')->registerNewDistributor($data);
            //print_r ($data);
            
            //print_r($_POST['distributor_id']);
        }
        $this->distributor();
    }
    function updateProduct(){
        $lastUpdatedDate = date("Y-m-d");
        $img_name="";
        if(!($_FILES['productImage']['size'] == 0)){
            $img_name = $_FILES['productImage']['name'];
            $time=time();
            $img_name = $time.$img_name;
            move_uploaded_file($_FILES['productImage']['tmp_name'],$_SERVER["DOCUMENT_ROOT"]."/mvc/public/img/products/".$img_name);
            $data=array('image'=>$img_name);
            $this->model('Company')->updateProduct($data,$_POST['Producttype'],$_SESSION['user_id']);
        
        
        }
        if((isset($_POST['Productname']) && $_POST['Productname'] != "")){
            $data=array('unit_price'=>$_POST['Productname']);
            $this->model('Company')->updateProduct($data,$_POST['Producttype'],$_SESSION['user_id']);
        }
        if((isset($_POST['productiontime']) && $_POST['productiontime'] != "")){
            $data=array('production_time'=>$_POST['productiontime']);
            $this->model('Company')->updateProduct($data,$_POST['Producttype'],$_SESSION['user_id']);
        }
        if((isset($_POST['quantity']) && $_POST['quantity'] != "")){
            $data=array('quantity'=>$_POST['quantity']);
            $this->model('Company')->updateProduct($data,$_POST['Producttype'],$_SESSION['user_id']);
        }

        $this->products();

    }
    function orders(){
        $data['navigation'] = 'orders';
        $company_id=$_SESSION['user_id'];
        $company_details = $this->model('Company')->getCompanyImage($company_id);
        $dealer_details = $this->model('Company')->getRegisteredDealers($company_id);
        $order_details=$this->model('Company')->getStockReqDetails($company_id);
        $product_details = $this->model('Company')->getProductDetails($company_id);
        $row = mysqli_fetch_assoc($company_details);
        $data['image'] = $row['logo'];
        //$row = mysqli_fetch_assoc($dealer_details);
        $data['dealer']=$dealer_details;
        $data['order_details']=$order_details;
        $data['product_details']=$product_details;
        //$data['cc']=$row['account_no'];
        //echo $data['cc'];
            //$data=[];
        $this->view('dashboard/company', $data);

    }
    function limitquota(){
        $data['navigation'] = 'limitquota';
        $company_id=$_SESSION['user_id'];
        $company_details = $this->model('Company')->getCompanyImage($company_id);
        $product_details = $this->model('Company')->getQuotaDetails($company_id);
        $row = mysqli_fetch_assoc($company_details);
        $data['image'] = $row['logo'];
        //$row = mysqli_fetch_assoc($dealer_details);
        $data['quotaDetails']=$product_details;
        //$data['cc']=$row['account_no'];
        //echo $data['cc'];
            //$data=[];
        $this->view('dashboard/company', $data);

    }
    function setQuota(){
        $conn = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
        $quota = mysqli_real_escape_string($conn,$_POST["quota"]);
        $customer = mysqli_real_escape_string($conn,$_POST["customer"]);
        $company_id=$_SESSION['user_id'];
        $this->model('Company')->setQuota($company_id,$customer,$quota);
        die();
    }
    function resetQuota(){
        $conn = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
        $customer = mysqli_real_escape_string($conn,$_POST["customer"]);
        $state = mysqli_real_escape_string($conn,$_POST["state"]);
        $company_id=$_SESSION['user_id'];
        $this->model('Company')->resetQuota($company_id,$customer,$state);
        die();
    }
    function analysis(){
        $data['navigation'] = 'analysis';
        $company_id=$_SESSION['user_id'];
        $company_details = $this->model('Company')->getCompanyImage($company_id);
        $distributor_details = $this->model('Company')->getDistributorNamesOnly($company_id);
        $row = mysqli_fetch_assoc($company_details);
        $data['image'] = $row['logo'];
        $data['distNames'] = $distributor_details;
        $this->view('dashboard/company', $data);
    }
    function reports(){
        $data['navigation'] = 'reports';
        $company_id=$_SESSION['user_id'];
        $company_details = $this->model('Company')->getCompanyImage($company_id);
        $row = mysqli_fetch_assoc($company_details);
        $data['image'] = $row['logo'];
        $this->view('dashboard/company', $data);
    }
    public function companyReports(){
        $data['navigation'] = 'reportsCompany';

        $this->view('dashboard/company',$data);
    }
    public function issuedOrders(){
        $data['navigation'] = 'issuedorders';
        $company_id=$_SESSION['user_id'];
        $company_details = $this->model('Company')->getCompanyImage($company_id);
        $order_details=$this->model('Company')->getIssuedStockReqDetails($company_id);
        $product_details = $this->model('Company')->getProductDetails($company_id);
        $row = mysqli_fetch_assoc($company_details);
        $data['image'] = $row['logo'];
        $data['order_details']=$order_details;
        $data['product_details']=$product_details;
        //$row = mysqli_fetch_assoc($dealer_details);
        //$data['dealer']=$dealer_details;
        //$data['cc']=$row['account_no'];
        //echo $data['cc'];
            //$data=[];
        $this->view('dashboard/company', $data);
    }
    public function delayedOrders(){
        $data['navigation'] = 'delayedorders';
        $company_id=$_SESSION['user_id'];
        $company_details = $this->model('Company')->getCompanyImage($company_id);
        $order_details=$this->model('Company')->getDelayedStockReqDetails($company_id);
        $product_details = $this->model('Company')->getProductDetails($company_id);
        $row = mysqli_fetch_assoc($company_details);
        $data['image'] = $row['logo'];
        //$row = mysqli_fetch_assoc($dealer_details);
        $data['order_details']=$order_details;
        $data['product_details']=$product_details;
        //$data['cc']=$row['account_no'];
        //echo $data['cc'];
            //$data=[];
        $this->view('dashboard/company', $data);
    }
    public function issueOrder(){
        $conn = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
        $orderID = mysqli_real_escape_string($conn,$_POST["orderID"]);
        $key = mysqli_real_escape_string($conn,$_POST["key"]);
        $qty = mysqli_real_escape_string($conn,$_POST[$key]);
        $company_id=$_SESSION['user_id'];
        $this->model('Company')->issueOrder($orderID);
        $this->model('Company')->reduceStock($key,$qty);
    }
    public function delayOrder(){
        $conn = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
        $orderID = mysqli_real_escape_string($conn,$_POST["orderID"]);
        $company_id=$_SESSION['user_id'];
        $this->model('Company')->delayOrder($orderID);
        die();
    }
    public function ProductCount(){
        $product_count = $this->model('Company')->getProductCount($_SESSION['user_id']);
        echo json_encode($product_count);
    }
    public function getDateRange(){
        $conn = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
        $ID = mysqli_real_escape_string($conn,$_POST["ID"]);
        $dates = $this->model('Company')->getOrderDates($ID);
        echo json_encode($dates);
    }
    public function getCharts(){
        $conn = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
        $company_id=$_SESSION['user_id'];
        $distributorID=mysqli_real_escape_string($conn,$_POST["distNames"]);
        $yearFrom=mysqli_real_escape_string($conn,$_POST['yearFrom']);
        $monthFrom=mysqli_real_escape_string($conn,$_POST['monthFrom']);
        $yearTo=mysqli_real_escape_string($conn,$_POST['yearTo']);
        $monthTo=mysqli_real_escape_string($conn,$_POST['monthTo']);
        $order_details=$this->model('Company')->getProductsForAnalysis($company_id,$distributorID,$yearFrom,$yearTo);
        $product_details = $this->model('Company')->getProductDetails($company_id);
        $barChart=array();
        $barChart['dates']=array();
        $barChart['values']=array();
        $doughNut=array();
        $doughNut['products']=array();
        $doughNut['values']=array();
        $lineChart=array();
        $lineChart['values']=array();
        $lineChart['names']=array();
        $colors=array("green","rgba(30, 105, 176, 1)","rgba(23, 45, 89, 1)","rgb(255, 128, 0)","rgb(0, 0, 255)","rgb(255, 0, 191)","rgb(102, 204, 255)");
        /*doughnut colors*/
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
        /*bar chart colors*/
        if(isset($order_details)){
            /*Bar chart details Begin*/
            $processedOrders=array();
            $processedDates=array();
            $tempDates=array();
            $tempOrderCount=array();
            $orderCount=0;
            foreach ($order_details as $row){
                $date=explode("-",$row['place_date']);
                $dateMonth=$date[0].'-'.$date[1];
                if(!(in_array($dateMonth,$processedDates))){
                    array_push($processedDates,$dateMonth);
                    foreach ($order_details as $row2){
                        $date_2=explode("-",$row2['place_date']);
                        $dateMonth_2=$date_2[0].'-'.$date_2[1];
                        if($dateMonth_2==$dateMonth){
                            if(!(in_array($row2['stock_req_id'],$processedOrders))){
                                array_push($processedOrders,$row2['stock_req_id']);
                                $orderCount+=1;
                                
                            }
                            
                        }
                    }
                    array_push($tempDates,$dateMonth);
                    array_push($tempOrderCount,$orderCount);
                    $orderCount=0;
                }else{
                    continue;
                }
                
            } 
            foreach($tempDates as $date){
                $yearAndMonth=explode('-',$date);
                if(intval($yearAndMonth[0])==$yearFrom){
                    if(intval($yearAndMonth[1])>=$monthFrom){
                        array_push($barChart['dates'],$date);
                        array_push($barChart['values'],$tempOrderCount[array_search($date,$tempDates)]);
                    }
                }elseif(intval($yearAndMonth[0])==$yearTo){
                    if(intval($yearAndMonth[1])<=$monthTo){
                        array_push($barChart['dates'],$date);
                        array_push($barChart['values'],$tempOrderCount[array_search($date,$tempDates)]);
                    }
                }elseif(intval($yearAndMonth[0])>$yearFrom && intval($yearAndMonth[0])<$yearTo){
                    array_push($barChart['dates'],$date);
                    array_push($barChart['values'],$tempOrderCount[array_search($date,$tempDates)]);         
                }
                //print_r(intval($yearAndMonth[0]));
                //print_r($date.'_______');
            }
            /*Bar chart details End*/
            /*Doughnut chart details begin*/
            $productArr=array();
            //for line chart
            $revenueArr=array();
            foreach($barChart['dates'] as $dates){
                foreach($order_details as $row){
                    $date=explode("-",$row['place_date']);
                    $dateMonth=$date[0].'-'.$date[1];
                    if($dates==$dateMonth){
                        if(array_key_exists((int)$row['product_id'],$productArr)){
                            $newQty=(int)$row['quantity']+(int)$productArr[$row['product_id']]; 
                            unset($productArr[(int)$row['product_id']]);
                            $productArr+=array((int)$row['product_id']=>$newQty);
                            /*For line chart*/
                            if(array_key_exists($dates,$revenueArr)){
                                $newRevenue=(int)$row['quantity']*(int)$row['unit_price']+$revenueArr[$dates];
                                unset($revenueArr[$dates]);
                                $revenueArr+=array($dates=>$newRevenue);
                            }else{
                                $revenueArr+=array($dates=>(int)$row['quantity']*(int)$row['unit_price']);
                            }
                        }else{
                            $productArr+=array((int)$row['product_id']=>(int)$row['quantity']);
                            /*For line chart*/
                            if(array_key_exists($dates,$revenueArr)){
                                $newRevenue=(int)$row['quantity']*(int)$row['unit_price']+$revenueArr[$dates];
                                unset($revenueArr[$dates]);
                                $revenueArr+=array($dates=>$newRevenue);
                            }else{
                                $revenueArr+=array($dates=>(int)$row['quantity']*(int)$row['unit_price']);
                            }
                        }

                    }
                }
            }
            foreach ($productArr as $key => $value) {
                foreach($product_details as $productRow){
                    if((int)$productRow['product_id']==$key){
                        array_push($doughNut['products'],$productRow['name']);
                    }
                }
                array_push($doughNut['values'],$value);
            }
            foreach($revenueArr as $key => $value){
                array_push($lineChart['values'],$value);
                array_push($lineChart['names'],$key);    
            }
            /*Doughnut chart details ends*/          
        }
        $data['barChart']=$barChart;
        $data['doughNut']=$doughNut;
        $data['lineChart']=$lineChart;
        $data['navigation'] = 'analysis';
        $company_id=$_SESSION['user_id'];
        $company_details = $this->model('Company')->getCompanyImage($company_id);
        $distributor_details = $this->model('Company')->getDistributorNamesOnly($company_id);
        $row = mysqli_fetch_assoc($company_details);
        $data['image'] = $row['logo'];
        $data['distNames'] = $distributor_details;
        $this->view('dashboard/company', $data);  
        
        
        
        
        
        
        /*$data['navigation'] = 'analysis';
        $company_id=$_SESSION['user_id'];
        $company_details = $this->model('Company')->getCompanyImage($company_id);
        $distributor_details = $this->model('Company')->getDistributorNamesOnly($company_id);
        $row = mysqli_fetch_assoc($company_details);
        $data['image'] = $row['logo'];
        $data['distNames'] = $distributor_details;
        $this->view('dashboard/company', $data);*/
        //print_r($order_details);
    }

}
?>
