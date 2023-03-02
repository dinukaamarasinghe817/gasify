<?php
$header = new Header("dealer",$data);
$sidebar = new Navigation('dealer','analysis');
?>

<section class="body">
    <?php
        // call the default header for yout interface
        $bodyheader = new BodyHeader($data);
        // call whatever the component you need to show
        // $bodycontent = new ProfileHTML($data);
    ?>
    <div class="body-content">
        <h2>Sales Analysis</h2>
        <form action="<?php echo BASEURL;?>/analysis/dealer" class="filters">
                <div class="input half"><label>From</label><input onchange="refreshcharts()" type="date" name="start_date" value="<?php echo $data['start_date'];?>"></div>
                <div class="input half"><label>To</label><input onchange="refreshcharts()" type="date" name="end_date" value="<?php echo $data['end_date'];?>"></div>
        </form>
        <div class="content-data analysis">
            <?php
            // $charts = $data['charts'];
            // for($i=0; $i<count($charts); $i++){
            //     $chart = $charts[$i];
            //     echo "<div class='chart'>
            //     <h4>".$chart['main']."</h4>";
            //     $ch = new Chart($chart['type'],$chart,$i);
            //     echo "</div>";
            // }
            ?>
        </div>
    </div>
</section>
<script>
    
    function refreshcharts(){
        let form = document.querySelector('.body-content .filters');
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'http://localhost/mvc/analysis/dealerrefresh', true);
        xhr.onload = ()=>{
            if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200){
                let data = xhr.response;
                if(data){
                    data = JSON.parse(data);
                    let charts = data['charts'];
                    let start_date = data['start_date'];
                    let end_date = data['end_date'];

                    let chartsection = document.querySelector('.content-data.analysis');
                    if(charts.length > 0){
                        let temp = ``;
                        for(let i = 0; i < charts.length; i++){
                            let chart = charts[i];
                            temp += `<div class='chart'> <h4>${chart['main']}</h4>`;
                            // temp += `$ch = new Chart(chart['type'],chart,i);`;
                            temp += Chart(${chart['type']},${chart},i);
                            //$ch = new Chart(chart['type'],chart,i);
                            temp += `</div>`;
                        }
                        chartsection.innerHTML = temp;
                    }else{
                        chartsection.innerHTML = `<?php?>`;
                    }
                }
            }
        }
        let formData = new FormData(form);
        xhr.send(formData);
    }
</script>


<?php
$footer = new Footer("dealer");
?>