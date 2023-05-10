<?php
    session_start();
class Compny extends Controller{
    function __construct(){
        $this->AuthorizeLogin();
        if(isset($_POST['productImage '])){
            echo "done";
            die();
        }
        
    }

    function dealer($error=null){
        $this->AuthorizeUser('company');

        if($error!=null){
            switch($error){
                case '1':
                    $data['toast'] = ['type' => 'success', 'message' =>'Successfully created user account!'];
                    break;
            }
        }
        $data['navigation'] = 'dealer';
        $company_id=$_SESSION['user_id'];
        $company_details = $this->model('Company')->getCompanyImage($company_id);
        $user_id=mysqli_fetch_assoc($company_details);
        $data['name']=$user_id['first_name'].' '.$user_id['last_name'];
        $dealer_details = $this->model('Company')->getRegisteredDealers($company_id);
        $row = mysqli_fetch_assoc($company_details);
        $data['image'] = $user_id['logo'];
        //$row = mysqli_fetch_assoc($dealer_details);
        $data['dealer']=$dealer_details;
        //$data['cc']=$row['account_no'];
        //echo $data['cc'];
            //$data=[];
        $this->view('dashboard/company', $data);
    }
    function distributor($error=null){
        $this->AuthorizeUser('company');

        if($error!=null){
            switch($error){
                case '1':
                    $data['toast'] = ['type' => 'success', 'message' =>'Successfully created user account!'];
                    break;
            }
        }
        $data['navigation'] = 'distributor';
        $company_id=$_SESSION['user_id'];
        $company_details = $this->model('Company')->getCompanyImage($company_id);
        $user_id=mysqli_fetch_assoc($company_details);
        $data['name']=$user_id['first_name'].' '.$user_id['last_name'];
        $distributor_details = $this->model('Company')->getRegisteredDistributors($company_id);
        $row = mysqli_fetch_assoc($company_details);
        $data['image'] = $user_id['logo'];
        $data['distributor']=$distributor_details;
        $this->view('dashboard/company', $data);
    }function products($error=null){
        $this->AuthorizeUser('company');

        $data['navigation'] = 'products';
        $company_id=$_SESSION['user_id'];
        $company_details = $this->model('Company')->getCompanyImage($company_id);
        $user_id=mysqli_fetch_assoc($company_details);
        $data['name']=$user_id['first_name'].' '.$user_id['last_name'];
        $product_details = $this->model('Company')->getProductDetails($company_id);
        $data['products']=$product_details;
        $row = mysqli_fetch_assoc($company_details);
        $data['image'] = $user_id['logo'];
        if($error=='updateSuccessful'){
            $data['toast'] = ['type' => 'success', 'message' => "Product updated successfully"];
        }else if($error=='registeredSuccessful'){
            $data['toast'] = ['type' => 'success', 'message' => "Product registered successfully"];
        }
        
            //$data=[];
        $this->view('dashboard/company', $data);
    }function regproducts(){
        $this->AuthorizeUser('company');

        $data['navigation'] = 'regproducts';
        $company_id=$_SESSION['user_id'];
        $company_details = $this->model('Company')->getCompanyImage($company_id);
        $user_id=mysqli_fetch_assoc($company_details);
        $data['name']=$user_id['first_name'].' '.$user_id['last_name'];
        $row = mysqli_fetch_assoc($company_details);
        $data['image'] = $user_id['logo'];
            //$data=[];
        $this->view('dashboard/company', $data);
    }function regDealer(){
        $this->AuthorizeUser('company');

        $data['navigation'] = 'regDealer';
        $company_id=$_SESSION['user_id'];
        $company_details = $this->model('Company')->getCompanyImage($company_id);
        $user_id=mysqli_fetch_assoc($company_details);
        $data['name']=$user_id['first_name'].' '.$user_id['last_name'];
        //$product_details = $this->model('Company')->getProductDetails($company_id);
        //$data['products']=$product_details;
        $row = mysqli_fetch_assoc($company_details);
        $data['image'] = $user_id['logo'];
        $this->view('dashboard/company', $data);
    }function regDistributor(){
        $this->AuthorizeUser('company');

        $data['navigation'] = 'regDistributor';
        $company_id=$_SESSION['user_id'];
        $company_details = $this->model('Company')->getCompanyImage($company_id);
        $user_id=mysqli_fetch_assoc($company_details);
        $data['name']=$user_id['first_name'].' '.$user_id['last_name'];
        //$product_details = $this->model('Company')->getProductDetails($company_id);
        //$data['products']=$product_details;
        $row = mysqli_fetch_assoc($company_details);
        $data['image'] = $user_id['logo'];
        $this->view('dashboard/company', $data);
    }function updateProducts(){
        $this->AuthorizeUser('company');

        $data['navigation'] = 'updateProducts';
        $company_id=$_SESSION['user_id'];
        $company_details = $this->model('Company')->getCompanyImage($company_id);
        $user_id=mysqli_fetch_assoc($company_details);
        $data['name']=$user_id['first_name'].' '.$user_id['last_name'];
        $product_details = $this->model('Company')->getProductDetails($company_id);
        //print_r($product_details);
        $data['products']=$product_details;
        $row = mysqli_fetch_assoc($company_details);
        $data['image'] = $user_id['logo'];
        $this->view('dashboard/company', $data);
    }
    function registerProducts(){
        $this->AuthorizeUser('company');

        $lastUpdatedDate = date("Y-m-d");
        $img_name = $_FILES['productImage']['name'];
        $time=time();
        $img_name = $time.$img_name;
        move_uploaded_file($_FILES['productImage']['tmp_name'],$_SERVER["DOCUMENT_ROOT"]."/mvc/public/img/products/".$img_name);
        $data=array('company_id'=>$_SESSION['user_id'],'name'=>$_POST['Productname'],'type'=>$_POST['Producttype'],'unit_price'=>$_POST['unitprice'],'weight'=>$_POST['weight'],'image'=>$img_name,'production_time'=>$_POST['productiontime'],'last_updated_date'=>$lastUpdatedDate,'quantity'=>$_POST['quantity'],'cylinder_limit'=>$_POST['threshold']);
        $this->model('Company')->registerNewProduct($data);
        $this->products('registeredSuccessful');
    }
    function registerDealer(){
        $this->AuthorizeUser('company');

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
        $this->AuthorizeUser('company');

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
        $this->AuthorizeUser('company');

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
        if((isset($_POST['threshold']) && $_POST['threshold'] != "")){
            $data=array('cylinder_limit'=>$_POST['threshold']);
            $this->model('Company')->updateProduct($data,$_POST['Producttype'],$_SESSION['user_id']);
        }

        $this->products('updateSuccessful');

    }
    function orders($error=null){
        $this->AuthorizeUser('company');

        $data['navigation'] = 'orders';
        $company_id=$_SESSION['user_id'];
        $company_details = $this->model('Company')->getCompanyImage($company_id);
        $dealer_details = $this->model('Company')->getRegisteredDealers($company_id);
        $user_id=mysqli_fetch_assoc($company_details);
        $data['name']=$user_id['first_name'].' '.$user_id['last_name'];
        $order_details=$this->model('Company')->getStockReqDetails($company_id);
        $product_details = $this->model('Company')->getProductDetails($company_id);
        $row = mysqli_fetch_assoc($company_details);
        $data['image'] = $user_id['logo'];
        //$row = mysqli_fetch_assoc($dealer_details);
        $data['dealer']=$dealer_details;
        $data['order_details']=$order_details;
        $data['product_details']=$product_details;
        //$data['cc']=$row['account_no'];
        //echo $data['cc'];
        if($error=='issuedSucessfully'){
            $data['toast'] = ['type' => 'success', 'message' => "Order issued successfully"];
        }else if($error=='delayedSucessfully'){
            $data['toast'] = ['type' => 'success', 'message' => "Order delayed successfully"];
        }
        $this->view('dashboard/company', $data);

    }
    function limitquota($error=null){
        $this->AuthorizeUser('company');

        $data['navigation'] = 'limitquota';
        $company_id=$_SESSION['user_id'];
        $company_details = $this->model('Company')->getCompanyImage($company_id);
        $user_id=mysqli_fetch_assoc($company_details);
        $data['name']=$user_id['first_name'].' '.$user_id['last_name'];
        $product_details = $this->model('Company')->getQuotaDetails($company_id);
        $row = mysqli_fetch_assoc($company_details);
        $data['image'] = $user_id['logo'];
        //$row = mysqli_fetch_assoc($dealer_details);
        $data['quotaDetails']=$product_details;
        //$data['cc']=$row['account_no'];
        //echo $data['cc'];
        if($error=='quotaChanged'){
            $data['toast'] = ['type' => 'success', 'message' => "Quota changed successfully"];
        }else if($error=='quotaoff'){
            $data['toast'] = ['type' => 'success', 'message' => "Quota turned off successfully"];
        }else if($error=='quotaon'){
            $data['toast'] = ['type' => 'success', 'message' => "Quota turned on successfully"];
        }
        $this->view('dashboard/company', $data);

    }
    function setQuota(){
        $this->AuthorizeUser('company');

        $conn = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
        $quota = mysqli_real_escape_string($conn,$_POST["quota"]);
        $customer = mysqli_real_escape_string($conn,$_POST["customer"]);
        $company_id=$_SESSION['user_id'];
        $this->model('Company')->setQuota($company_id,$customer,$quota);
        //echo $r;
    }
    function resetQuota(){
        $this->AuthorizeUser('company');

        $conn = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
        $customer = mysqli_real_escape_string($conn,$_POST["customer"]);
        $state = mysqli_real_escape_string($conn,$_POST["state"]);
        $company_id=$_SESSION['user_id'];
        $this->model('Company')->resetQuota($company_id,$customer,$state);
        die();
    }
    function analysis(){
        $this->AuthorizeUser('company');

        $data['navigation'] = 'analysis';
        $company_id=$_SESSION['user_id'];
        $company_details = $this->model('Company')->getCompanyImage($company_id);
        $user_id=mysqli_fetch_assoc($company_details);
        $data['name']=$user_id['first_name'].' '.$user_id['last_name'];
        $distributor_details = $this->model('Company')->getDistributorNamesOnly($company_id);
        $row = mysqli_fetch_assoc($company_details);
        $data['image'] = $user_id['logo'];
        $data['distNames'] = $distributor_details;
        $this->view('dashboard/company', $data);
    }
    function reports(){
        $this->AuthorizeUser('company');

        $data['navigation'] = 'reports';
        $company_id=$_SESSION['user_id'];
        $company_details = $this->model('Company')->getCompanyImage($company_id);
        $user_id=mysqli_fetch_assoc($company_details);
        $data['name']=$user_id['first_name'].' '.$user_id['last_name'];
        $distributor_details = $this->model('Company')->getDistributorNamesOnly($company_id);
        $data['distNames'] = $distributor_details;
        $row = mysqli_fetch_assoc($company_details);
        $data['image'] = $user_id['logo'];
        $this->view('dashboard/company', $data);
    }
    public function companyReports(){
        $this->AuthorizeUser('company');

        $data['navigation'] = 'reportsCompany';
        $conn = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
        $company_id=$_SESSION['user_id'];
        $company_details = $this->model('Company')->getCompanyImage($company_id);
        $user_id=mysqli_fetch_assoc($company_details);
        $data['name']=$user_id['first_name'].' '.$user_id['last_name'];
        $distributorID=mysqli_real_escape_string($conn,$_POST["distNames"]);
        $yearFrom=mysqli_real_escape_string($conn,$_POST['yearFrom']);
        $monthFrom=mysqli_real_escape_string($conn,$_POST['monthFrom']);
        $yearTo=mysqli_real_escape_string($conn,$_POST['yearTo']);
        $monthTo=mysqli_real_escape_string($conn,$_POST['monthTo']);
        $order_details=$this->model('Company')->getProductsForAnalysis($company_id,$distributorID,$yearFrom,$yearTo);
        $product_details = $this->model('Company')->getProductDetails($company_id);
        $productArr=array();
        $revenueArr=array();
        $barChart=array();
        $barChart['dates']=array();
        $barChart['values']=array();
        $distributor_details = $this->model('Company')->getDistributorNamesOnly($company_id);
        $dateJoined = $this->model('Company')->getDateJoined($distributorID);
        $currentDate=explode("-",date('Y-m-d'));
        $fromYearAndMonth = explode("-",strval($yearFrom).'-'.strval($monthFrom));
        $toYearAndMonth=explode("-",strval($yearTo).'-'.strval($monthTo));
        $data['joineddate']=$dateJoined;
        $data['currentdate']=$currentDate;
        $data['fromyearandmonth']=$fromYearAndMonth;
        $data['toyearandmonth']=$toYearAndMonth;
        $data['distnames']=$distributor_details;
        $data['currentdistributor']=$distributorID;
        if(isset($order_details)){
            $processedOrders=array();
            $processedDates=array();
            $tempDates=array();
            $tempOrderCount=array();
            $orderCount=0;
            foreach ($order_details as $row){
                //print_r($row);
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
            //print_r($tempDates);
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
            }
            
            foreach($barChart['dates'] as $dates){
                foreach($order_details as $row){
                    $date=explode("-",$row['place_date']);
                    $dateMonth=$date[0].'-'.$date[1];
                    if($dates==$dateMonth){
                        if(array_key_exists((int)$row['product_id'],$productArr)){
                            $newQty=(int)$row['quantity']+(int)$productArr[$row['product_id']][1]; 
                            unset($productArr[(int)$row['product_id']]);
                            $productArr+=array((int)$row['product_id']=>array((int)$row['unit_price'],$newQty));
                            if(array_key_exists($dates,$revenueArr)){
                                $newRevenue=(int)$row['quantity']*(int)$row['unit_price']+$revenueArr[$dates];
                                unset($revenueArr[$dates]);
                                $revenueArr+=array($dates=>$newRevenue);
                            }else{
                                $revenueArr+=array($dates=>(int)$row['quantity']*(int)$row['unit_price']);
                            }
                        }else{
                            $productArr+=array((int)$row['product_id']=>array((int)$row['unit_price'],(int)$row['quantity']));
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
            foreach($product_details as $row){
                if(array_key_exists($row['product_id'],$productArr)){
                    $temp=$productArr[$row['product_id']];
                    unset($productArr[$row['product_id']]);
                    $productArr+=array($row['name']=>$temp);
                }
            }    
        }
        $data['products']=$productArr;
        $data['distributorName']=$this->model('Company')->getDistributorName($distributorID);
        $date['fromDate']=$yearFrom.'-'.$monthFrom;
        $date['toDate']=$yearTo.'-'.$monthTo;
        $distributor_details = $this->model('Company')->getDistributorNamesOnly($company_id);
        $data['distNames'] = $distributor_details;
        $company_id=$_SESSION['user_id'];
        $distributor_details = $this->model('Company')->getDistributorNamesOnly($company_id);
        $row = mysqli_fetch_assoc($company_details);
        $data['image'] = $user_id['logo'];
        $data['distNames'] = $distributor_details;
        $this->view('dashboard/company',$data);
    }
    public function issuedOrders(){
        $this->AuthorizeUser('company');

        $data['navigation'] = 'issuedorders';
        $company_id=$_SESSION['user_id'];
        $company_details = $this->model('Company')->getCompanyImage($company_id);
        $user_id=mysqli_fetch_assoc($company_details);
        $data['name']=$user_id['first_name'].' '.$user_id['last_name'];
        $order_details=$this->model('Company')->getIssuedStockReqDetails($company_id);
        $product_details = $this->model('Company')->getProductDetails($company_id);
        $row = mysqli_fetch_assoc($company_details);
        $data['image'] = $user_id['logo'];
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
        $this->AuthorizeUser('company');

        $data['navigation'] = 'delayedorders';
        $company_id=$_SESSION['user_id'];
        $company_details = $this->model('Company')->getCompanyImage($company_id);
        $user_id=mysqli_fetch_assoc($company_details);
        $data['name']=$user_id['first_name'].' '.$user_id['last_name'];
        $order_details=$this->model('Company')->getDelayedStockReqDetails($company_id);
        $product_details = $this->model('Company')->getProductDetails($company_id);
        $row = mysqli_fetch_assoc($company_details);
        $data['image'] = $user_id['logo'];
        //$row = mysqli_fetch_assoc($dealer_details);
        $data['order_details']=$order_details;
        $data['product_details']=$product_details;
        //$data['cc']=$row['account_no'];
        //echo $data['cc'];
            //$data=[];
        $this->view('dashboard/company', $data);
    }
    public function issueOrder(){
        $this->AuthorizeUser('company');

        $conn = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
        $orderID = mysqli_real_escape_string($conn,$_POST["orderID"]);
        $key = mysqli_real_escape_string($conn,$_POST["key"]);
        $qty = mysqli_real_escape_string($conn,$_POST[$key]);
        $company_id=$_SESSION['user_id'];
        $distributorID = $this->model('Company')->getDistributorID($orderID);
        $this->model('Company')->issueOrder($orderID);
        $this->model('Company')->reduceStock($key,$qty);
        $this->model('Company')->addStockToDistributor($distributorID,$key,$qty);
    }
    public function delayOrder(){
        $this->AuthorizeUser('company');

        $conn = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
        $orderID = mysqli_real_escape_string($conn,$_POST["orderID"]);
        $company_id=$_SESSION['user_id'];
        $this->model('Company')->delayOrder($orderID);
        die();
    }
    public function ProductCount(){
        $this->AuthorizeUser('company');

        $product_count = $this->model('Company')->getProductCount($_SESSION['user_id']);
        echo json_encode($product_count);
    }
    public function getDateRange(){
        $this->AuthorizeUser('company');

        $conn = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
        $ID = mysqli_real_escape_string($conn,$_POST["ID"]);
        $dates = $this->model('Company')->getOrderDates($ID);
        echo json_encode($dates);
    }
    public function getCharts(){
        $this->AuthorizeUser('company');

        $conn = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
        $company_id=$_SESSION['user_id'];
        $distributorID=mysqli_real_escape_string($conn,$_POST["distNames"]);
        $distributor_details = $this->model('Company')->getDistributorNamesOnly($company_id);
        $yearFrom=mysqli_real_escape_string($conn,$_POST['yearFrom']);
        $monthFrom=mysqli_real_escape_string($conn,$_POST['monthFrom']);
        $yearTo=mysqli_real_escape_string($conn,$_POST['yearTo']);
        $monthTo=mysqli_real_escape_string($conn,$_POST['monthTo']);
        $order_details=$this->model('Company')->getProductsForAnalysis($company_id,$distributorID,$yearFrom,$yearTo);
        $product_details = $this->model('Company')->getProductDetails($company_id);
        $dateJoined = $this->model('Company')->getDateJoined($distributorID);
        $currentDate=explode("-",date('Y-m-d'));
        $fromYearAndMonth = explode("-",strval($yearFrom).'-'.strval($monthFrom));
        $toYearAndMonth=explode("-",strval($yearTo).'-'.strval($monthTo));
        $data['joineddate']=$dateJoined;
        $data['currentdate']=$currentDate;
        $data['fromyearandmonth']=$fromYearAndMonth;
        $data['toyearandmonth']=$toYearAndMonth;
        $data['distnames']=$distributor_details;
        $data['currentdistributor']=$distributorID;
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
        $user_id=mysqli_fetch_assoc($company_details);
        $data['name']=$user_id['first_name'].' '.$user_id['last_name']; 
        $distributor_details = $this->model('Company')->getDistributorNamesOnly($company_id);
        $row = mysqli_fetch_assoc($company_details);
        $data['image'] = $user_id['logo'];
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
    function redirectToOrdersFromIssued(){
        $this->AuthorizeUser('company');

        $this->orders('issuedSucessfully');
    }
    function redirectToOrdersFromDelayed(){
        $this->AuthorizeUser('company');

        $this->orders('delayedSucessfully');
    }function redirectToLimitQuotaFromSetQuota(){
        $this->AuthorizeUser('company');

        $this->limitquota('quotaChanged');
    }function redirectToLimitQuotaFromQuotaStateOff(){
        $this->AuthorizeUser('company');

        $this->limitquota('quotaoff');
    }function redirectToLimitQuotaFromQuotaStateOn(){
        $this->AuthorizeUser('company');
        
        $this->limitquota('quotaon');
    }

}
?>
