<?php
$header = new Header("vehicles");
$sidebar = new Navigation('distributor',$data['navigation']);
?>

<section class="body">
    <?php 
    // call the default header for your interface
    $bodyheader = new BodyHeader($data);
    // $bodycontent = new Body('vehicles_comp', $data);
    ?>

    <section class="body-content">
        <h2>Vehicles</h2> <br>

        <?php 
          $result = new Vehicles_Comp("update");
        ?>

        <div class="main2">
            <table class="table1">
                <tr>
                    <th>Vehicle Number</th>
                    <th></th>
                </tr>

                <tr>
                    <td>WE1234</td>
                    <td><button class="btn3">Select</button></td>
                </tr>

                <tr>
                    <td>GH7889</td>
                    <td><button class="btn3">Select</button></td>
                </tr>

                <tr>
                    <td>SD4450</td>
                    <td><button class="btn3">Select</button></td>
                </tr>

                <tr>
                    <td>JH1120</td>
                    <td><button class="btn3">Select</button></td>
                </tr>

                <tr>
                    <td>CV5660</td>
                    <td><button class="btn3">Select</button></td>
                </tr>
            </table>

        </div>

    </section>
</section>

<?php
$footer = new Footer();
?>

