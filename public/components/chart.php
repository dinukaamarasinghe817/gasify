<?php

class Chart{

    public function __construct($type,$data = null,$index=null){
        echo '<script src="'.BASEURL.'/public/js/chart.umd.js"></script>';
        $this->$type($data,$index);
    }

    public function bar($data,$index){
        $max = max($data['vector']) +1;
        echo '<canvas id="bargraph'.$index.'" ></canvas>
        <script>
        let ctx'.$index.' = document.getElementById("bargraph'.$index.'")
        new Chart(ctx'.$index.', {
            type: "bar",
            data: {
                
            labels: '.phpArrtoJs($data['labels']).',
            datasets: [{
                label: "'.$data['y'].'",
                data: '.phpArrtoJs($data['vector']).',
                backgroundColor: "'.$data['color'].'"
            }]
            },
            options: {
                scales: {
                    y: {
                        ticks: {
                            stepSize: 1
                        },
                        suggestedMax: '.$max.'
                    }
                }
            }
        });
        </script>';
    }

    public function line($data,$index){
        $max = max($data['vector'])+1;
        echo '<canvas id="bargraph'.$index.'" ></canvas>
        <script>
        let ctx'.$index.' = document.getElementById("bargraph'.$index.'")
        new Chart(ctx'.$index.', {
            type: "line",
            data: {
                
            labels: '.phpArrtoJs($data['labels']).',
            datasets: [{
                label: "'.$data['y'].'",
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
                        ticks: {
                            stepSize: 1
                        },
                        suggestedMax: '.$max.'
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
        echo '<canvas id="bargraph'.$index.'" class="doughnut"></canvas>
        <script>
        let ctx'.$index.' = document.getElementById("bargraph'.$index.'")
        new Chart(ctx'.$index.', {
            type: "doughnut",
            data: {
                
            labels: '.phpArrtoJs($data['labels']).',
            datasets: [{
                label: "'.$data['y'].'",
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
                },
                maintainAspectRatio: true
            }
        });
        </script>';
    }

    public function pie($data,$index){
        echo '<canvas id="bargraph'.$index.'" class="pie"></canvas>
        <script>
        let ctx'.$index.' = document.getElementById("bargraph'.$index.'")
        new Chart(ctx'.$index.', {
            type: "pie",
            data: {
                
            labels: '.phpArrtoJs($data['labels']).',
            datasets: [{
                label: "'.$data['y'].'",
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
                },
                maintainAspectRatio: true
            }
        });
        </script>';
    }
}

?>