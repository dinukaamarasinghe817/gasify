<?php

class Chart{

    public function __construct($name, $data = null){
        $this->$name($data);
    }

    public function dealerdashboard($data){
        $products = $data['sold_count'];
        $pname = array(); $pqty = array();
        foreach($products as $product){
            array_push($pname,$product['name']);
            array_push($pqty,$product['quantity']);
        }
        echo '
        <canvas id="bargraph"></canvas>
        
        <script src="'.BASEURL.'/public/js/chart.umd.js"></script>
        <script>
        let ctx = document.getElementById("bargraph");

        new Chart(ctx, {
            type: "bar",
            data: {
                
            labels: '.phpArrtoJs($pname).',
            datasets: [{
                label: "Sold Quantity",
                data: '.phpArrtoJs($pqty).',
                backgroundColor: "rgba(255, 159, 64, 0.5)",
                borderWidth: 1
            }]
            },
            options: {
            scales: {
                y: {
                beginAtZero: true
                }
            }
            }
        });
        </script>';
        
    }
}

?>