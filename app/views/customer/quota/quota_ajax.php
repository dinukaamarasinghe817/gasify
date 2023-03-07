
<?php

    $percentage = $data['percentage'];                     
    echo '<div id="progress_bar"> '.$percentage.'';
        $progresscircle = new PercentageCircle($percentage,6);
    echo '</div>';






?>