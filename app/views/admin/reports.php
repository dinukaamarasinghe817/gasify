<?php
$header = new Header("admin",$data);
$sidebar = new Navigation('admin','reports');
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
                        <th>Company</th>
                        <th>Product Name</th>
                        <th>Current Stock</th>
                        <th>Monthly Consumption</th>
                        <th>Enough For</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $rows = array();
                    foreach ($rows as $row){
                        echo 
                        '<tr>
                            <td>Litro</td>
                            <td>Buddy</td>
                            <td>1000</td>
                            <td>100</td>
                            <td>5 months</td>
                        </tr>';
                    }
                    echo 
                        '<tr>
                        <td>Litro</td>
                        <td>Buddy</td>
                        <td>1000</td>
                        <td>100</td>
                        <td>5 months</td>
                    </tr>
                    <tr>
                        <td>Litro</td>
                        <td>Buddy</td>
                        <td>1000</td>
                        <td>100</td>
                        <td>5 months</td>
                    </tr>';
                    ?>
                </tbody>
            </table>
            <a class="anchor-button" href="<?php echo BASEURL ?>/reports/salesdealer">Generate PDF</a>
        </div>
    </div>
</section>

<?php
$footer = new Footer("admin");
?>