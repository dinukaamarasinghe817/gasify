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
        <form action="" class="filters">
                <div class="input half"><label>From</label><input type="date" name="start_date" value="'.$row['street'].'"></div>
                <div class="input half"><label>To</label><input type="date" name="end_date" value="'.$row['street'].'"></div>
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

<?php
$footer = new Footer("dealer");
?>