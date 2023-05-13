<?php
class Payment{
    public function __construct($link,$customer_email,$amount,$pubkey,$restkey,$dealer_id){
        $total = $amount*100;
        echo '<form action="'.BASEURL.'/'.$link.'" method="POST">
                <input type="text" name="customer_email" value="'.$customer_email.'" hidden>
                <input type="number" name="amount" value="'.$amount.'" step="0.01" hidden>
                <input type="number" name="dealer_id" value="'.$dealer_id.'" hidden>
                <input type="text" name="rest_key" value="'.decryptStripeKey($restkey).'" hidden>
                <script
                    src="https://checkout.stripe.com/checkout.js"
                    class="stripe-button"
                    data-key="'.decryptStripeKey($pubkey).'"
                    data-name="Online Payment"
                    data-description="gasify"
                    data-amount="'.$total.'"
                    data-email="'.$customer_email.'"
                    data-currency="lkr">
                </script>
            </form>';
    }
}

class Charge{
    private $restkey;
    private $token;
    private $description;
    private $amount;

    public function __construct($restkey,$description,$amount){
        $this->restkey = $restkey;
        $this->description = $description;
        $this->amount = $amount*100;
    }

    public function make(){
        $this->token = $_POST['stripeToken'];
        echo $this->restkey;
        \Stripe\Stripe::setApiKey($this->restkey);
        $charge = \Stripe\Charge::create([
            'source' => $this->token,
            'description' => $this->description,
            'amount' => $this->amount,
            'currency' => 'usd',
        ]);

        if($charge){
            return true;
        }else{
            return false;
        }
    }
}
?>