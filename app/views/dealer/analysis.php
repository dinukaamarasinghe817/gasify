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
    <div class="content-data">
        <?php
        $charts = $data['charts'];
        for($i=0; $i<count($charts); $i++){
            $chart = $charts[i];
            $ch = new Chart($chart['type'],$chart['chart'],$i);
        }
        ?>
    </div>
</section>

<?php
$footer = new Footer("dealer");
?>