<?php

class Chart{

    public function __construct($name, $data = null){
        $this->$name($data);
    }

    public function dealerdashboard($data){
        $products = $data['sold_count'];
        $pname = array(); $pqty = array();
        $color = 'rgba(255, 159, 64, 0.5)';
        $main = 'Sold Quantity';
        foreach($products as $product){
            array_push($pname,$product['name']);
            array_push($pqty,$product['quantity']);
        }
        echo '
        <canvas id="bargraph"></canvas>
        
        <script src="'.BASEURL.'/public/js/chart.umd.js"></script>
        <script>
        let ctx = document.getElementById("bargraph");

        '.$this->barchart($main,$pname,$pqty,$color).'
        </script>';
        
    }

    public function barchart($main,$labels,$vector,$color){
        return 'new Chart(ctx, {
            type: "bar",
            data: {
                
            labels: '.phpArrtoJs($labels).',
            datasets: [{
                label: "'.$main.'",
                data: '.phpArrtoJs($vector).',
                backgroundColor: "'.$color.'",
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
        });';
    }
}

?>