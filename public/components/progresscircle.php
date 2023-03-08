<?php
class PercentageCircle{
    function __construct($percentage,$index){
        echo '<div class="skill">
                    <div class="outer">
                        <div class="inner">
                            <div class="number number'.$index.'" data-num="'.$percentage.'">

                            </div>
                        </div>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="110px" height="110px">
                        <defs>
                            <linearGradient id="GradientColor">
                                <stop offset="0%" stop-color="#e91e63" />
                                <stop offset="100%" stop-color="#673ab7" />
                            </linearGradient>
                        </defs>
                        <circle cx="55" cy="55" r="50" stroke-linecap="round" class="circle'.$index.'"/>
                    </svg>
                </div>';

        // js part
        echo "<script>
        var numbers = document.querySelectorAll('.number');
        var svgEl = document.querySelectorAll('svg circle');
        var counters = Array(numbers.length);
        var intervals = Array(counters.length);
        counters.fill(0);
        
        numbers.forEach((number, index) => {
            var value = parseFloat(number.dataset.num);
            var step = parseFloat(value/1000*20);
            intervals[index] = setInterval(() => {
                if(counters[index] >= parseFloat(number.dataset.num)){
                    clearInterval(intervals[index]);
                }else{
                    counters[index] += step;
                    if(counters[index] > value){
                        counters[index] = value;
                    }
                    number.innerHTML = counters[index].toFixed(1) + \"%\";
                    svgEl[index].style.strokeDashoffset = Math.floor(472 - (315 * parseFloat(number.dataset.num / 100)));
                }
            }, 5);
        });
        </script>";
    }
}
class Quota{
    function __construct($product_id,$product_weight,$total_cyl,$remaining_cyl){
        $percentage = $remaining_cyl*100/$total_cyl;
        echo '<div class="skill">
                    <div class="outer">
                        <div class="inner">
                            <div class="number number'.$product_id.'" data-num="'.$percentage.'" data-total="'.$total_cyl.'" data-remain="'.$remaining_cyl.'">
                            
                            </div>
                        </div>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="110px" height="110px">
                        <defs>
                            <linearGradient id="GradientColor">
                                <stop offset="0%" stop-color="#e91e63" />
                                <stop offset="100%" stop-color="#673ab7" />
                            </linearGradient>
                        </defs>
                        <circle cx="55" cy="55" r="50" stroke-linecap="round" class="circle'.$product_id.'"/>
                    </svg>
                </div>';

        // js part
        echo "<script>
        var numbers = document.querySelectorAll('.number');
        var svgEl = document.querySelectorAll('svg circle');
        var counters = Array(numbers.length);
        var intervals = Array(counters.length);
        counters.fill(0);
        
        numbers.forEach((number, index) => {
            var value = parseFloat(number.dataset.num);
            var step = parseFloat(value/1000*20);
            intervals[index] = setInterval(() => {
                if(counters[index] >= parseFloat(number.dataset.remain)){
                    clearInterval(intervals[index]);
                }else{
                    counters[index] += 1;
                    if(counters[index] > number.dataset.remain){
                        counters[index] = number.dataset.remain;
                    }
                    number.innerHTML = counters[index] + \" \ \" + number.dataset.total;
                    svgEl[index].style.strokeDashoffset = Math.floor(472 - (315 * parseFloat(number.dataset.num / 100)));
                }
            }, 5);
        });
        </script>";
    }
}
?>