<!-- Replacing part(progress circle) -->
<?php
   $product_id = $data['product_id'];
   $product_weight = $data['product_weight'];
   $total_cylinders = $data['total_cylinders'];
   $remaining_cylinders = $data['remaining_cylinders'];

    echo '<div id="progress_bar"> ';
        $progresscircle = new Quota($product_id,$product_weight,$total_cylinders,$remaining_cylinders);
    echo '</div>';

?>