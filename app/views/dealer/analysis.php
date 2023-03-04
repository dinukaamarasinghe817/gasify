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
        $max_date = date('Y-m-d');
    ?>
    <div class="body-content">
        <h2>Sales Analysis</h2>
        <form action="<?php echo BASEURL;?>/analysis/dealer" class="filters" method="POST">
                <div class="input half start"><label>From</label><input type="date" onchange="this.form.submit()" name="start_date" value="<?php echo $data['start_date']?>" max="<?php echo $data['end_date']?>"  min="<?php echo $data['date_joined'] ?>"></div>
                <div class="input half end"><label>To</label><input type="date" onchange="this.form.submit()" name="end_date" value="<?php echo $data['end_date']?>" max="<?php echo $max_date;?>" min="<?php echo $data['start_date'] ?>"></div>
        </form>
        <div class="content-data analysis">
            <?php
            $charts = $data['charts'];
            for($i=0; $i<count($charts); $i++){
                $chart = $charts[$i];
                echo "<div class='chart'>
                <h4>".$chart['main']."</h4>";
                $ch = new Chart($chart['type'],$chart,$i);
                echo "</div>";
            }
            ?>
        </div>
    </div>
</section>
<script>

    const form = document.querySelector('form');
    form.onsubmit(e){
        e.preventDefault();
    }
</script>


<?php
$footer = new Footer("dealer");
?>