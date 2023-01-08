<?php
class Prompt{
    function __construct($type,$data){
        $this->$type($data);
    }

    public function verification($data){
        echo '<div class="verification">
                <h1>Verification Status</h1>
                <div class="box">
                    <div>
                        <h2>Stock</h2>
                        <p>pending</p>
                    </div>
                    <img src="'.BASEURL.'/public/img/icons/accept.png" alt="">
                </div>
                <div class="box">
                    <div>
                        <h2>Payment</h2>
                        <p>pending</p>
                    </div>
                    <img src="'.BASEURL.'/public/img/icons/pending.png" alt="">
                </div>
                <button onclick="viewinfo(); return false;">OK</button>
            </div>';
    }
}
?>