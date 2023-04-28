<?php

class Admin extends Model
{

    public function __construct()
    {
        parent::__construct();
    }
    public function getAdmin($user_id){
        $data = [];
        $result = $this->Query("SELECT * FROM users u INNER JOIN admin a ON u.user_id = a.admin_id WHERE a.admin_id = $user_id");
        return $result;
    }

    // public function gever(){
    //     $distance = getDistance("No:43, Lional Jayasinghe Mawatha, Godagama", "Akarawita Patumaga, Homagama");
    //     if ($distance) {
    //         echo "The distance between the two addresses is " . $distance . " km.";
    //     } else {
    //         echo "Error calculating distance.";
    //     }
    // }
    
    public function companies($option){
        $data['option'] = $option;
        if($option == 'stock'){ $option = 'quantity'; }
        elseif($option == 'distributor'){$option = 'distributor_count'; }
        elseif($option == 'dealer'){$option = 'dealer_count'; }
        $sql = "SELECT c.company_id as user_id,
        c.name as name,
        COUNT(DISTINCT(di.distributor_id)) as distributor_count,
        COUNT(DISTINCT(d.dealer_id)) as dealer_count,
        p.quantity as quantity
        FROM company c LEFT JOIN 
        (SELECT company_id,SUM(quantity*weight) as quantity FROM product GROUP BY company_id)
         p ON c.company_id = p.company_id
        LEFT JOIN distributor di ON di.company_id = c.company_id
        LEFT JOIN dealer d ON d.company_id = c.company_id 
        GROUP BY c.company_id ORDER BY $option DESC";
        $data['companies'] = $this->Query($sql);
        return $data;
    }
    public function distributors($option1,$option2){
        $data['option1'] = $option1;
        $data['option2'] = $option2;
        $sql = "SELECT d.distributor_id as user_id,
        CONCAT(u.first_name,' ',u.last_name) as name,
        d.city as city,
        c.name as company,
        COUNT(DISTINCT(v.vehicle_no)) as vehicle_count,
        IFNULL(SUM(dk.quantity*p.weight),0) as quantity
        FROM distributor d INNER JOIN users u ON d.distributor_id = u.user_id
        LEFT JOIN company c ON d.company_id = c.company_id
        LEFT JOIN distributor_keep dk ON dk.distributor_id = d.distributor_id
        LEFT JOIN product p ON dk.product_id = p.product_id
        LEFT JOIN distributor_vehicle v ON d.distributor_id = v.distributor_id";
        if($option1 != 'all' && $option2 != 'all'){
            $sql .= " WHERE d.city = '$option1' AND c.company_id = $option2";
        }else if($option1 != 'all'){
            $sql .= " WHERE d.city = '$option1'";
        }else if($option2 != 'all'){
            $sql .= " WHERE c.company_id = $option2";
        }
        $sql .= " GROUP BY d.distributor_id";
        $data['distributors'] = $this->Query($sql);
        $data['companies'] = $this->read('company');
        return $data;
    }
    public function dealers($option1,$option2){
        $data['option1'] = $option1;
        $data['option2'] = $option2;
        $sql = "SELECT d.dealer_id as user_id,
        CONCAT(u.first_name,' ',u.last_name) as name,
        d.city as city,
        c.name as company,
        IFNULL(COUNT(DISTINCT(r.order_id)),0) as orders_count,
        IFNULL(SUM(dk.quantity*p.weight),0) as quantity
        FROM dealer d INNER JOIN users u ON d.dealer_id = u.user_id
        LEFT JOIN company c ON d.company_id = c.company_id
        LEFT JOIN dealer_keep dk ON dk.dealer_id = d.dealer_id
        LEFT JOIN product p ON dk.product_id = p.product_id
        LEFT JOIN (SELECT * FROM reservation WHERE order_state = 'Completed') r ON d.dealer_id = r.dealer_id";
        if($option1 != 'all' && $option2 != 'all'){
            $sql .= " WHERE d.city = '$option1' AND c.company_id = $option2";
        }else if($option1 != 'all'){
            $sql .= " WHERE d.city = '$option1'";
        }else if($option2 != 'all'){
            $sql .= " WHERE c.company_id = $option2";
        }
        $sql .= " GROUP BY d.dealer_id";
        $data['dealers'] = $this->Query($sql);
        $data['companies'] = $this->read('company');
        return $data;
    }
    public function deliveries($option){
        $data['option'] = $option;
        $sql = "SELECT d.delivery_id as user_id,
        CONCAT(u.first_name,' ',u.last_name) as name,
        d.city as city,
        IFNULL(COUNT(DISTINCT(r.order_id)),0) as orders_count
        FROM delivery_person d INNER JOIN users u ON d.delivery_id = u.user_id
        LEFT JOIN (SELECT * FROM reservation WHERE order_state = 'Completed') r ON d.delivery_id = r.delivery_id";
        if($option != 'all'){
            $sql .= " WHERE d.city = '$option'";
        }
        $sql .= " GROUP BY d.delivery_id";
        $data['delivery_people'] = $this->Query($sql);
        return $data;
    }
    public function deliverycharges($mindist=null){
        if($mindist != null){
            foreach($mindist as $key => $value){
                $this->update('delivery_charge',['charge_per_kg' => $value],"min_distance = $key");
            }
            $data['toast'] = ['type' => 'success', 'message' => 'Successfully updated delivery charges!'];
        }
        $data['delivery_charges'] = $this->read('delivery_charge');
        return $data;
    }
    public function customers($option){
        $data['option'] = $option;
        $sql = "SELECT u.user_id,CONCAT(u.first_name,' ',u.last_name) AS name,
        c.street AS address,
        c.city AS city,
        c.contact_no AS contact_no,
        COUNT(DISTINCT(CONCAT(YEAR(r.place_date),'-',MONTH(r.place_date)))) AS months,
        IFNULL(SUM(ri.quantity*p.weight),0) as quantity
        FROM users u INNER JOIN customer c ON u.user_id = c.customer_id
        LEFT JOIN (SELECT * FROM reservation WHERE order_state = 'Completed') r ON c.customer_id = r.customer_id
        LEFT JOIN reservation_include ri ON r.order_id = ri.order_id
        LEFT JOIN product p ON ri.product_id = p.product_id";
        if($option != 'all'){
            $sql .= " WHERE c.city = '$option'";
        }
        $sql .= " GROUP BY u.user_id";
        $data['customers'] = $this->Query($sql);
        return $data;
    }

    public function getanalysis($user_id,$start_date,$end_date,$company){
        $row = mysqli_fetch_assoc($this->read('users',"user_id = $user_id"));
        $data['date_joined'] = $row['date_joined'];
        if($start_date == null){
            $start_date = $row['date_joined'];
        }

        $data['charts'] = array();

        //chart 1 sold quantity of each product based on their weight
        $products = array();
        $query1 = $this->read('product',$company == 'all' ? '' : "company_id = $company");
        while($row = mysqli_fetch_assoc($query1)){
            $products[$row['weight']] = 0;
        }
        $optional = ''; // if the company is given only show records belongs to that company
        if($company != 'all'){
            $optional = "dealer_id IN (SELECT dealer_id FROM dealer WHERE company_id = $company) AND ";
        }
        $query1 = $this->read('reservation',
        $optional."place_date >= '$start_date' AND place_date <= '$end_date' AND (order_state != 'pending' AND order_state != 'canceled')");
        while($row = mysqli_fetch_assoc($query1)){
            $order_id = $row['order_id'];
            $query2 = $this->read('reservation_include',"order_id = $order_id");
            while($row2 = mysqli_fetch_assoc($query2)){
                $pinfo = mysqli_fetch_assoc($this->read('product',"product_id = ".$row2['product_id']));
                $products[$pinfo['weight']] += $row2['quantity'];
            }
        }
        $chart['labels'] = array();
        $chart['vector'] = array();
        foreach($products as $id => $quantity){
            // $row = mysqli_fetch_assoc($this->read('product',"product_id = $id"));
            array_push($chart['labels'], $id." Kg");
            array_push($chart['vector'], $quantity);
        }
        $chart['type'] = 'bar';
        $chart['main'] = 'Based on Product';
        $chart['y'] = 'Number of sold items';
        $chart['color'] = 'rgba(245, 215, 39, 0.8)';
        array_push($data['charts'],$chart);

        //chart 2 gas consumption grouped by city
        $optional = "";
        if($company != 'all'){
            $optional = "dealer_id IN (SELECT dealer_id FROM dealer WHERE company_id = $company) AND";
        }
        $chart['type'] = 'pie';
        $chart['labels'] = array();
        $chart['vector'] = array();
        $sql = "SELECT
        re.total_revenue,
        IF(SUM(ri.quantity*ri.unit_price)/total_revenue > 0.1, d.city, 'Other') AS city,
        SUM(ri.quantity*ri.unit_price) AS revenue,
        ROUND(SUM(ri.quantity*ri.unit_price)/total_revenue * 100) AS percentage
        FROM (SELECT * FROM reservation WHERE ".$optional." order_state != 'Pending' AND order_state != 'Canceled') r INNER JOIN dealer d ON r.dealer_id = d.dealer_id
        INNER JOIN reservation_include ri ON r.order_id = ri.order_id
        CROSS JOIN (SELECT SUM(re.quantity*re.unit_price) AS total_revenue FROM reservation rn INNER JOIN reservation_include re ON rn.order_id = re.order_id WHERE rn.order_state != 'Pending' AND rn.order_state != 'Canceled') re
        GROUP BY city ORDER BY revenue DESC";
        $query1 = $this->Query($sql);
        while($row = mysqli_fetch_assoc($query1)){
            array_push($chart['labels'], $row['city']);
            array_push($chart['vector'], $row['percentage']);
        }
        $chart['main'] = 'Based on the city';
        $chart['y'] = 'Percentage (%)';
        $chart['color'] = '[
            "rgb(255, 99, 132)",
            "rgb(54, 162, 235)",
            "rgb(205, 199, 102)",
            "rgb(45, 126, 253)",
            "rgb(54, 122, 15)"
            ]';
        array_push($data['charts'],$chart);

        //chart 3 order count based on collecting method (pickup or delivery)
        $optional = ''; // if the company is given only show records belongs to that company
        if($company != 'all'){
            $optional = "dealer_id IN (SELECT dealer_id FROM dealer WHERE company_id = $company) AND ";
        }
        $deliverymode = array("Delivery"=>0,"Pickup"=>0);
        $query1 = $this->read('reservation',
        $optional."place_date >= '$start_date' AND place_date <= '$end_date' AND (order_state != 'pending' AND order_state != 'canceled')");
        while($row = mysqli_fetch_assoc($query1)){
            $deliverymode[$row['collecting_method']]++;
        }
        $chart['type'] = 'doughnut';
        $chart['labels'] = array_keys($deliverymode);
        $chart['vector'] = array_values($deliverymode);
        $chart['main'] = 'Based on Collecting Method';
        $chart['y'] = 'Number of orders';
        $chart['color'] = '[
            "rgb(205, 99, 132)",
            "rgb(54, 162, 235)"
            ]';
        array_push($data['charts'],$chart);

        //chart 4 order count based on customer type (domestic, small scale business, large scale business)
        $usertype = array("Domestic"=>0, "CommercialLarge"=>0, "CommercialSmall"=>0);
        $query1 = $this->read('reservation',
        $optional."place_date >= '$start_date' AND place_date <= '$end_date' AND (order_state != 'pending' OR order_state != 'canceled')");
        while($row = mysqli_fetch_assoc($query1)){
            $customer_id = $row['customer_id'];
            $row2 = mysqli_fetch_assoc($this->read('customer',"customer_id = $customer_id"));
            $usertype[$row2['type']]++;
        }
        $chart['type'] = 'bar';
        $chart['labels'] = array_keys($usertype);
        $chart['vector'] = array_values($usertype);
        $chart['main'] = 'Based on Customer Type';
        $chart['y'] = 'Number of Orders';
        $chart['color'] = 'rgba(48, 39, 245, 0.8)';
        array_push($data['charts'],$chart);
        
        // find all companies to show in the filter
        $data['companies'] = $this->read('company');
        $data['company'] = $company;
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        return $data;
    }

    public function getReportInfo($start_date,$to_date,$order_by){

    }

    public function dashboard($user_id,$option,$option2){
        // variable data
        date_default_timezone_set("Asia/Colombo");
        $today = date('Y-m-d');$start_date='';$end_date='';
        if($option == 'today'){
            $start_date = $today;
            $end_date = $today;
        }else{
            $start_date = date('Y-m-d', strtotime('-30 days'));
            $end_date = date('Y-m-d', strtotime('-1 days'));
        }

        $row1 = mysqli_fetch_assoc($this->Query('SELECT COUNT(*) as users FROM customer'));
        $data['customers_count'] = $row1['users'];
        $row1 = mysqli_fetch_assoc($this->Query('SELECT COUNT(*) as users FROM dealer'));
        $data['dealers_count'] = $row1['users'];
        $row1 = mysqli_fetch_assoc($this->Query('SELECT COUNT(*) as users FROM distributor'));
        $data['distributors_count'] = $row1['users'];
        $row1 = mysqli_fetch_assoc($this->Query('SELECT COUNT(*) as users FROM delivery_person'));
        $data['delivery_count'] = $row1['users'];
        $row1 = mysqli_fetch_assoc($this->Query('SELECT COUNT(*) as users FROM company'));
        $data['company_count'] = $row1['users'];
        $data['companies'] = $this->Query('SELECT * FROM company');

        // recent reviews
        $sql = "SELECT CONCAT(c.first_name, ' ', c.last_name) AS customer_name,
        cu.image as image,
        re.review_type as review_type,
        re.date as date,
        re.time as time,
        CONCAT(d.first_name,' ',d.last_name) AS dealer_name,
        r.dealer_id AS dealer_id,
        r.delivery_id AS delivery_id,
        CONCAT(de.first_name,' ',de.last_name) AS delivery_name,
        re.message as message FROM
        review re INNER JOIN reservation r ON re.order_id = r.order_id
        INNER JOIN users c ON r.customer_id = c.user_id
        INNER JOIN customer cu ON r.customer_id = cu.customer_id
        INNER JOIN users d ON r.dealer_id = d.user_id
        LEFT JOIN users de ON r.delivery_id = de.user_id
        ORDER BY date DESC,time DESC,re.order_id DESC LIMIT 10";
        $data['reviews'] = $this->Query($sql);

        // chart details
        $sql = "SELECT p.product_id, SUM(r.quantity) as quantity, p.name as name
        FROM reservation_include r INNER JOIN product p 
        ON r.product_id = p.product_id WHERE ";
        if($option2 != 'all') $sql .= "p.company_id = $option2 AND ";
        $sql .= "order_id IN 
            (SELECT order_id FROM reservation 
            WHERE place_date >= '{$start_date}' AND place_date <= '{$end_date}') 
        GROUP BY product_id";

        $chart['y'] = 'Sold Quantity';
        $chart['color'] = 'rgba(255, 159, 64, 0.5)';
        // $chart['color'] = '[
        //     "rgb(255, 99, 132)",
        //     "rgb(54, 162, 235)",
        //     "rgb(54, 122, 15)"
        //   ]';
        $chart['labels'] = array();$chart['vector'] = array();
        $products = $this->Query($sql);
        foreach($products as $product){
            array_push($chart['labels'],$product['name']);
            array_push($chart['vector'],$product['quantity']);
        }
        $data['chart'] = $chart;

        $data['option1'] = $option;
        $data['option2'] = $option2;
        return $data;
    }

    public function getPaymentVerifications($tab){
        $data['activetab'] = $tab;
        if($tab == 'regular'){
            $sql = "SELECT r.order_id AS order_id,
            r.place_date AS place_date,
            r.place_time AS place_time,
            CONCAT(c.first_name,' ',c.last_name) AS customer_name,
            d.user_id AS dealer_id,
            CONCAT(d.first_name,' ',d.last_name) AS dealer_name,
            de.bank AS bank,
            de.account_no AS account_no,
            SUM(ri.quantity*ri.unit_price) AS amount,
            r.pay_slip AS pay_slip
            FROM (SELECT * FROM reservation WHERE payment_method = 'Bank Deposit' and payment_verification = 'pending') r INNER JOIN users c ON r.customer_id = c.user_id
            INNER JOIN users d ON r.dealer_id = d.user_id
            INNER JOIN dealer de ON r.dealer_id = de.dealer_id
            INNER JOIN reservation_include ri ON r.order_id = ri.order_id
            GROUP BY r.order_id ORDER BY order_id ASC";
        }else{
            $sql = "SELECT r.order_id AS order_id,
            r.refund_date AS place_date,
            r.refund_time AS place_time,
            CONCAT(c.first_name,' ',c.last_name) AS customer_name,
            d.user_id AS dealer_id,
            CONCAT(d.first_name,' ',d.last_name) AS dealer_name,
            r.bank AS bank,
            r.acc_no AS account_no,
            SUM(ri.quantity*ri.unit_price) AS amount,
            r.refund_payslip AS pay_slip
            FROM (SELECT * FROM reservation WHERE order_state = 'Canceled' and refund_verification = 'pending' and payment_verification = 'verified') r INNER JOIN users c ON r.customer_id = c.user_id
            INNER JOIN users d ON r.dealer_id = d.user_id
            INNER JOIN dealer de ON r.dealer_id = de.dealer_id
            INNER JOIN reservation_include ri ON r.order_id = ri.order_id
            GROUP BY r.order_id ORDER BY place_date ASC,place_time ASC";
        }
        $data['payments'] = $this->Query($sql);
        $data['verification'] = '';
        return $data;
    }

    public function validatepaymentsubmit($validity,$tab,$order_id){
        if($tab == 'regular'){
            if($validity){
                $this->update('reservation',['payment_verification'=>'verified'],"order_id = $order_id");
            }else{
                $this->update('reservation',['payment_verification'=>'rejected'],"order_id = $order_id");
                // handle the bouncing of rejected and pending 
                // send a notification to user
                $row = mysqli_fetch_assoc($this->read('reservation',"order_id = $order_id"));
                $user_id = $row['customer_id'];
                $customer = mysqli_fetch_assoc($this->read('users',"user_id = $user_id"));
                $user_name = $customer['first_name'].' '.$customer['last_name'];
                $type = "Payment Verification failed";
                $message = "Hi, $user_name, Your payment slip for the Order ID : $order_id was rejected. Please visit your recent orders and make the payment again or contact us via support section.";
                $this->insert('notification',['user_id'=>$row['customer_id'],'type'=>$type,'message'=>$message,'date'=>date(),'time'=>time(),'state'=>'delivered']);
                // send an email
                $mail = new Mail('admin@gasify.com',$customer['email'],$user_name,$type,$message,$link=null);
                $mail->send();
            }
        }else{
            if($validity){
                $this->update('reservation',['refund_verification'=>'verified'],"order_id = $order_id");
            }else{
                $this->update('reservation',['refund_verification'=>'rejected'],"order_id = $order_id");
                // handle the bouncing of rejected and pending 
                // send a notification to user
                $row = mysqli_fetch_assoc($this->read('reservation',"order_id = $order_id"));
                $user_id = $row['dealer_id'];
                $customer = mysqli_fetch_assoc($this->read('users',"user_id = $user_id"));
                $user_name = $customer['first_name'].' '.$customer['last_name'];
                $type = "Refund Verification failed";
                $message = "Hi, $user_name, Your payment slip for the Order ID : $order_id was rejected. Please visit your canceled orders and make the payment again or contact us via support section.";
                $this->insert('notification',['user_id'=>$row['customer_id'],'type'=>$type,'message'=>$message,'date'=>date(),'time'=>time(),'state'=>'delivered']);
                // send an email
                $mail = new Mail('admin@gasify.com',$customer['email'],$user_name,$type,$message,$link=null);
                $mail->send();
            }
        }
    }

    public function takebackup(){
        date_default_timezone_set("Asia/Colombo");
        $datetime = date('Ymd');

        $filename = dirname(getcwd()).DIRECTORY_SEPERATOR.'app'.DIRECTORY_SEPERATOR.'backup'.DIRECTORY_SEPERATOR.DB_NAME . '-' . $datetime . '.sql';
        echo $filename;
        $hostname = DB_HOST;
        $database = DB_NAME;
        $username = DB_USER;
        $password = DB_PASSWORD;
        // Execute the mysqldump command
        $command = "mysqldump --opt -h $hostname -u $username -p$password $database > $filename";
        system($command);
        echo "success";
    }

    public function restorebackup(){
        $datetime = $_POST['date'];
        // Set the backup filename
        $filename = dirname(getcwd()).DIRECTORY_SEPERATOR.'app'.DIRECTORY_SEPERATOR.'backup'.DIRECTORY_SEPERATOR.DB_NAME . '-' . $datetime . '.sql';
        $hostname = DB_HOST;
        $database = DB_NAME;
        $username = DB_USER;
        $password = DB_PASSWORD;

        // Execute the mysql command to restore the database
        $command = "mysql -h $hostname -u $username -p$password $database < $filename";
        system($command);

        // Output a message to the user
        echo "success";
    }
}