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
    public function companies(){
        $data['company'] = 5;
        return $data;
    }
    public function distributors(){
        $data['company'] = 5;
        return $data;
    }
    public function dealers(){
        $data['company'] = 5;
        return $data;
    }
    public function deliveries(){
        $data['company'] = 5;
        return $data;
    }
    public function customers(){
        $data['customers'] = $this->Query("SELECT * FROM users u INNER JOIN customer c ON u.user_id = c.customer_id");
        return $data;
    }

    public function getanalysis($user_id,$start_date,$end_date){
        //chart 1
        $data['charts'] = array();
        $chart['type'] = 'line';
        $chart['labels'] = array('Buddy','Budget','Regualr','Commercial');
        $chart['vector'] = array(7,10,2,5);
        $chart['main'] = 'Based on Product';
        $chart['y'] = 'Number of sold items';
        $chart['color'] = 'rgba(245, 215, 39, 0.8)';
        array_push($data['charts'],$chart);

        //chart 2
        $chart['type'] = 'pie';
        $chart['labels'] = array('Homagama','Maharagma','Kesbewa','Colombo','Moratuwa');
        $chart['vector'] = array(7,10,12,5,7,8,3);
        $chart['main'] = 'Based on the city';
        $chart['y'] = 'Number of Orders';
        $chart['color'] = '[
            "rgb(255, 99, 132)",
            "rgb(54, 162, 235)",
            "rgb(205, 199, 102)",
            "rgb(45, 126, 253)",
            "rgb(54, 122, 15)"
            ]';
        array_push($data['charts'],$chart);

        //chart 3
        // $chart['type'] = 'doughnut';
        // $chart['labels'] = array('Delivery','Pickup');
        // $chart['vector'] = array(60,40);
        // $chart['main'] = 'Based on Collecting Method';
        // $chart['y'] = 'Number of orders';
        // $chart['color'] = '[
        //     "rgb(205, 99, 132)",
        //     "rgb(54, 162, 235)"
        //     ]';
        // array_push($data['charts'],$chart);

        //chart 4
        $chart['type'] = 'bar';
        $chart['labels'] = array('Domestic','LargeScale','SmallScale');
        $chart['vector'] = array(22,65,45);
        $chart['main'] = 'Based on Customer Type';
        $chart['y'] = 'Number of Orders';
        $chart['color'] = 'rgba(48, 39, 245, 0.8)';
        array_push($data['charts'],$chart);
        //chart 4
        $chart['type'] = 'bar';
        $chart['labels'] = array('Domestic','LargeScale','SmallScale');
        $chart['vector'] = array(22,65,45);
        $chart['main'] = 'Based on Customer Type';
        $chart['y'] = 'Number of Orders';
        $chart['color'] = 'rgba(48, 39, 245, 0.8)';
        array_push($data['charts'],$chart);
        
        return $data;
    }

    public function getReportInfo($start_date,$to_date,$order_by){

    }

    public function dashboard($user_id,$option){
        // variable data
        $today = date('Y-m-d');
        if($option == 'today'){
            $start_date = $today;
            $end_date = $today;
        }else{
            $start_date = date('Y-m-d', strtotime('-30 days'));
            $end_date = date('Y-m-d', strtotime('-1 days'));
        }

        $sql = "SELECT p.product_id, SUM(r.quantity) as quantity, p.name as name
        FROM reservation_include r INNER JOIN product p 
        ON r.product_id = p.product_id WHERE order_id IN 
            (SELECT order_id FROM reservation 
            WHERE place_date >= '$start_date' AND place_date <= '$end_date' AND order_state = 'Completed') 
        GROUP BY product_id";

        // chart details
        $products = $this->Query($sql);
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
        return $data;
    }
}