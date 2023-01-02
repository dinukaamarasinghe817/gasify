<?php
$header = new Header("distributor");
$sidebar = new Navigation('distributor',$data['navigation']);
?>

<section class="body">
    <?php 
    $bodyheader = new BodyHeader($data);
    ?>

    <section class="body-content">
        <div class="split-right">
            <h1>Dealers</h1>

            <div class="top">
                <ul>
                    <li><a href="../dealers/distributor_dealers" class="dealers"><b>Allocated Dealers' Details</b></a></li>
                </ul>
            </div>

            <div class="middle">
                <table>
                    <tr>
                        <th>Dealer ID</th>
                        <th>Dealer Name</th>
                        <th></th>
                    </tr>

                    <tr>
                        <td>01</td>
                        <td>John Fernando</td>
                        <th><button class="inside">Select</button></th>
                    </tr>

                    <tr>
                        <td>02</td>
                        <td>Grelly Fernando</td>
                        <th><button class="inside">Select</button></th>
                    </tr>

                    <tr>
                        <td>03</td>
                        <td>Fred Driyan</td>
                        <th><button class="inside">Select</button></th>
                    </tr>

                    <tr>
                        <td>04</td>
                        <td>Carry Deo</td>
                        <th><button class="inside">Select</button></th>
                    </tr>
                </table>
            </div>
        </div>

    </section>
</section>

<?php
$footer = new Footer();
?>