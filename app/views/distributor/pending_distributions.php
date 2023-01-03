<?php
$header = new Header("distributor");
$sidebar = new Navigation('distributor', $data['navigation']);
?>

<section class="body">
    <?php
    $bodyHeader =new BodyHeader($data);
    ?>
    <section class="body-content">
        <div class="split right">
            <h1>Gas Distributions - Pending</h1>

            <div class="top">
                <ul>
                    <li>
                        <a href="../gasdistributions/pending_distributions" class="pending"><b>Pending Gas Distributions</b></a>
                    </li>
                    <li>
                        <a href="../gasdistributions/completed_distributions" class="completed"><b>Completed Gas Distributions</b></a>
                    </li>
                </ul>
            </div>

            <!-- <p>pending distributions</p> -->

        </div>


    </section>


</section>


<?php
$footer = new Footer();
?>