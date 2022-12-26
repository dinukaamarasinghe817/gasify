<?php

class Chart{

    public function __construct($name, $data = null){
        $this->$name($data);
    }

    public function dealerordersanalytic($data){
        echo '
        <canvas id="bargraph"></canvas>
        
        <script src="'.BASEURL.'/public/js/chart.umd.js"></script>
        <script>
        let ctx = document.getElementById("bargraph");

        new Chart(ctx, {
            type: "bar",
            data: {
            labels: ["Buddy", "Budget", "Regular", "Commercial", "Regulator"],
            datasets: [{
                label: "Sold Quantity",
                data: [7, 10, 2, 5, 6],
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
        </script>
        '; 
    }
}

?>