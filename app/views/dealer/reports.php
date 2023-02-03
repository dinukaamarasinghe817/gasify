<?php
$header = new Header("dealer",$data);
$sidebar = new Navigation('dealer','reports');
?>

<section class="body">
    <?php
        // call the default header for yout interface
        $bodyheader = new BodyHeader($data);
        // call whatever the component you need to show
        // $bodycontent = new ProfileHTML($data);
    ?>
    <div class="body-content">
        <h2>Sales Report</h2>
        <form action="" class="filters">
                <div class="input half"><label>From</label><input type="date" name="start_date" value="'.$row['street'].'"></div>
                <div class="input half"><label>To</label><input type="date" name="end_date" value="'.$row['street'].'"></div>
                <div class="input half"><label>Filter by</label>
                    <select id="city" class="dropdowndate" name="filter" class="half">';
                        <option value="'.$city.'" selected >Sold Quantity</option>
                        <option value="'.$city.'">Total Amount</option>
                    </select>
                </div>
        </form>
        <div class="content-data reports">
            <!-- <div class="chart">

            </div> -->
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Product Name</th>
                        <th>Sold Quantity</th>
                        <th>Total amount</th>
                        <th>Percentage</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $rows = array();
                    foreach ($rows as $row){
                        echo 
                        '<tr>
                            <td><img class="littleproduct" src="'.BASEURL.'/public/img/products/2.3kglitro.png"></td>
                            <td>Buddy</td>
                            <td>10</td>
                            <td>10000</td>
                            <td>10%</td>
                        </tr>';
                    }
                    echo 
                        '<tr>
                            <td><img class="littleproduct" src="'.BASEURL.'/public/img/products/2.3kglitro.png"></td>
                            <td>Buddy</td>
                            <td>10</td>
                            <td>10000</td>
                            <td>10%</td>
                        </tr>
                        <tr>
                            <td><img class="littleproduct" src="'.BASEURL.'/public/img/products/5kglitro.png"></td>
                            <td>Budget</td>
                            <td>5</td>
                            <td>12000</td>
                            <td>18%</td>
                        </tr>';
                    ?>
                </tbody>
            </table>
            <a class="anchor-button" href="<?php echo BASEURL ?>/reports/salesdealer">Generate PDF</a>
        </div>
    </div>
</section>

<?php
$footer = new Footer("dealer");
?>