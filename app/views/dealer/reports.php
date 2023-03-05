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
        $max_date = date('Y-m-d');
    ?>
    <div class="body-content">
        <h2>Sales Report</h2>
        <form action="<?php echo BASEURL;?>/reports/dealer" class="filters" method="POST">
            <div class="input half start"><label>From</label><input type="date" onchange="this.form.submit()" name="start_date" value="<?php echo $data['start_date']?>" max="<?php echo $data['end_date']?>"  min="<?php echo $data['date_joined'] ?>"></div>
            <div class="input half end"><label>To</label><input type="date" onchange="this.form.submit()" name="end_date" value="<?php echo $data['end_date']?>" max="<?php echo $max_date;?>" min="<?php echo $data['start_date'] ?>"></div>
            <div class="input half"><label>Order by</label>
                <select id="city" class="dropdowndate" name="filter" class="half" onchange="this.form.submit()">';
                    <?php
                        if($data['filter'] == 'soldquantity'){
                            echo '<option value="soldquantity" selected >Sold Quantity</option>
                            <option value="totalearnings">Total Amount</option>';
                        }else{
                            echo '<option value="soldquantity">Sold Quantity</option>
                            <option value="totalearnings" selected>Total Amount</option>';
                        }
                    ?>
                    
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
                        <th>Total Earnings</th>
                        <th>Percentage</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $rows = $data['tabledata'];
                    foreach ($rows as $row){
                        echo 
                        '<tr>
                            <td><img class="littleproduct" src="'.BASEURL.'/public/img/products/'.$row['image'].'"></td>
                            <td>'.$row['name'].'</td>
                            <td>'.number_format($row['sold_quantity']).'</td>
                            <td>Rs.'.number_format($row['total_earnings'],2).'</td>
                            <td>'; 
                            $pc = new PercentageCircle($row['percentage'],$row['id']);
                            echo '</td>
                        </tr>';
                    }
                    ?>
                </tbody>
            </table>
            <br>
            <form class="pdfform" action="<?php echo BASEURL ?>/reports/salesdealer/<?php echo $data['start_date']?>/<?php echo $data['end_date']?>/<?php echo $data['filter']?>" method="POST">
                <button class="btn-red">Generate PDF</button>
            </form>
            <!-- <a class="anchor-button" href="/reports/salesdealer/">Generate PDF</a> -->
        </div>
    </div>
</section>

<?php
$footer = new Footer("dealer");
?>