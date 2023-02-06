<?php
$header = new Header("dealer",$data);
$sidebar = new Navigation('dealer',$data['navigation']);
?>

<section class="body">
    <?php
        // call the default header for yout interface
        $bodyheader = new BodyHeader($data);
        // call whatever the component you need to show
        $bodycontent = new OrdersHTML($data['tab1'],$data['tab2'],$data);
    ?>
</section>

<script>
    let accordion = document.querySelectorAll(".order .head svg");
    let occororders = document.querySelectorAll(".order .info");
    console.log(occororders);
    for(i=0; i<accordion.length; i++) {
        let j = i;
        accordion[i].addEventListener("click", function(){
            this.parentElement.parentElement.querySelector(".info").classList.toggle("active");
            this.classList.toggle("active");
        })
    }
    let accorinfo = document.querySelectorAll(".order .head .btn");
    for(i=0; i<accorinfo.length; i++) {
        accorinfo[i].addEventListener("click", function(){
            this.parentElement.parentElement.querySelector(".verification").classList.toggle("active")
        })
    }
    function viewinfo(){
        let accorinfo = document.querySelector(".verification");
        accorinfo.classList.toggle("active");
        document.querySelector("body").classList.toggle("blur");
    }
</script>
<?php
$footer = new Footer("dealer");
?>