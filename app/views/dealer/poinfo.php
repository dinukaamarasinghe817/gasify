<?php
$products = $data['products'];
$total = $data['total'];
echo '<ul>';
foreach ($products as $product){
    echo '<li>
            <div class="poitem">
                <img src="'.BASEURL.'/public/img/products/'.$product['image'].'" alt="">
                <div>
                    <h3>'.$product['name'].'</h3>
                    <p>'.$product['weight'].' Kg</p>
                </div>
                <p>Unit Price<br>Rs . '.$product['unit_price'].'.00</p>
                <div><p>Quntity</p><h2>x '.$product['quantity'].'</h2></div>
            </div>
        </li>';
}
echo '<li>
    <div class="poitem">
        <a href = "'.BASEURL.'/stock/dealer/pohistory" ><button class="btn" onclick>Back</button></a>
        <div class="total">
            <p>Total</p>
            <h3>Rs. '.$total.'.00</h3>
        </div>
    </div>
</li>
</ul>';

?>