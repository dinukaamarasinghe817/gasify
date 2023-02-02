<?php

class Chart{

    public function __construct($type,$data = null,$index=null){
        echo '<script src="'.BASEURL.'/public/js/chart.umd.js"></script>';
        $this->$type($data,$index);
    }

    public function bar($data,$index){
        echo '<canvas id="bargraph'.$index.'" ></canvas>
        <script>
        let ctx'.$index.' = document.getElementById("bargraph'.$index.'")
        new Chart(ctx'.$index.', {
            type: "bar",
            data: {
                
            labels: '.phpArrtoJs($data['labels']).',
            datasets: [{
                label: "'.$data['main'].'",
                data: '.phpArrtoJs($data['vector']).',
                backgroundColor: "'.$data['color'].'"
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

    public function line($data,$index){
        echo '<canvas id="bargraph'.$index.'" ></canvas>
        <script>
        let ctx'.$index.' = document.getElementById("bargraph'.$index.'")
        new Chart(ctx'.$index.', {
            type: "line",
            data: {
                
            labels: '.phpArrtoJs($data['labels']).',
            datasets: [{
                label: "'.$data['main'].'",
                data: '.phpArrtoJs($data['vector']).',
                backgroundColor: "'.$data['color'].'",
                borderWidth: 1,
                pointRadius: 5,
                borderColor: "'.$data['color'].'",
            }]
            },
            options: {
                scales: {
                    y: {
                    beginAtZero: true
                    }
                },
                legend: {
                    display: true,
                    position: "right"
                }
            }
        });
        </script>';
    }

    public function doughnut($data,$index){
        echo '<canvas id="bargraph'.$index.'"></canvas>
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
                plugins: {
                    legend: {
                        display: true,
                        position: "right"
                    }
                }
            }
        });
        </script>';
    }
}

?>