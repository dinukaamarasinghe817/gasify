<?php

class Chart{

    public function __construct($type,$data = null,$index=null){
        $this->$type($data,$index);
    }

    public function bar($data,$index){
        echo '<canvas id="bargraph'.$index.'"></canvas>
        
        <script src="'.BASEURL.'/public/js/chart.umd.js"></script>
        <script>
        let ctx = document.getElementById("bargraph'.$index.'")
        new Chart(ctx, {
            type: "bar",
            data: {
                
            labels: '.phpArrtoJs($data['labels']).',
            datasets: [{
                label: "'.$data['main'].'",
                data: '.phpArrtoJs($data['vector']).',
                backgroundColor: "'.$data['color'].'",
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

    public function doughnut($data,$index){
        echo '<canvas id="bargraph'.$index.'"></canvas>
        
        <script src="'.BASEURL.'/public/js/chart.umd.js"></script>
        <script>
        let ctx = document.getElementById("bargraph'.$index.'")
        new Chart(ctx, {
            type: "doughnut",
            data: {
                
            labels: '.phpArrtoJs($data['labels']).',
            datasets: [{
                label: "'.$data['main'].'",
                data: '.phpArrtoJs($data['vector']).',
                backgroundColor: '.$data['color'].',
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