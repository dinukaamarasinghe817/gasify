<?php
$header = new Header("customer/cancel_reservation",$data);
$sidebar = new Navigation('customer',$data['navigation']);
?>

<section class="body">
    <?php
        // call the default header for yout interface
        $bodyheader = new BodyHeader($data);
        // call whatever the component you need to show
        // $bodycontent = new Body('viewmyreservation', $data);
        if(isset($data['toast'])){
            $error = new Prompt('toast',$data['toast']);

        }
       
    ?>

    <div class="under_topbar">
        <div class="subtitle">
            <h3>Bank Details</h3>
        </div>
        <div class="middle">
        <?php

            $order_id = $data['order_id'];

            echo'<div class="detail_form">
                    <form id="bank_details_form" method="POST"  action="'.BASEURL.'/Orders/refund_bank_details/'.$data['order_id'].'" >
                        
                        <select name="bank" id="bank" class="bankdropdown dropdowndate">
                                    <option value="-1" selected disabled hidden>Select Bank</option>';
                                    foreach (BANKS as $bank){
                                        echo "<option value=$bank id=$bank name='bank'>$bank</option>";
                                        
                                    }
                 echo   '<input name="branch" placeholder="Branch">
                         <input name="Acc_no" placeholder="Account No" onkeyup = "lettersOnly(this)" >
                        <button type="submit" class="submit_btn" onclick ="customerprompt(\'confirmcancellation\',\''.BASEURL.'/Orders/refund_bank_details/'.$order_id.'\',\''.BASEURL.'/Orders/customer_myreservation/'.$order_id.'\'); return false;">Submit</button>
                    </form>
                
                </div>';

        ?>
        <!-- onclick ="customerprompt(\'confirmcancellation\',\''.BASEURL.'/Orders/refund_bank_details/'.$order_id.'\',\''.BASEURL.'/Orders/customer_myreservation/'.$order_id.'\'); return false; -->
        <!-- onclick="customerprompt(\'cancelorder\',\''.BASEURL.'/Orders/customer_allreservations\'); return false;" -->
            <div class="image">
                <img src="<?php echo BASEURL;?>/public/img/customer/refund.png" alt="">
            </div>
        </div>



    </div> 
</section>
<script>
    function lettersOnly(input){
        var regexp = /[^0-9]/g;
        input.value = input.value.replace(regexp,"");

    }
</script>

<?php
$footer = new Footer("customer");
?>