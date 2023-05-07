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
        <form action="<?php echo BASEURL;?>/reports/admin" class="filters" method="POST">
                <div class="input half"><label>From</label><input type="date" name="start_date" value="<?=$data['start_date']?>"></div>
                <div class="input half"><label>To</label><input type="date" name="end_date" value="<?=$data['end_date']?>"></div>
                <div class="input half"><label>Filter by</label>
                    <select id="city" class="dropdowndate" name="filter" class="half" onchange="this.form.submit()">';
                        <?php if($data['filter_by'] == 'all') :?>
                            <option value="all" selected >All</option>
                        <?php else : ?>
                            <option value="all"  >All</option>
                        <?php endif; ?>
                        <?php while($row = mysqli_fetch_array($data['companies'])) : ?>
                            <?php if($data['filter_by'] == $row['company_id']) : ?>
                                <option value="<?=$row['company_id']?>" selected ><?=$row['name']?></option>
                            <?php else : ?>
                                <option value="<?=$row['company_id']?>" ><?=$row['name']?></option>
                        <?php endif; endwhile; ?>
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
                        <th>Product</th>
                        <th>Product Name</th>
                        <th class="numbers">Current Stock</th>
                        <th class="numbers">Total Sale</th>
                        <th class="numbers">Total Revenue (Rs.)</th>
                        <th class="numbers">Monthly Sale (Avg)</th>
                        <th>Availability</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $rows = $data['table_info'];
                    foreach ($rows as $row){
                        if($row['availability'] == PHP_INT_MAX){
                            $row['availability'] = 'For enough months';
                        }elseif($row['availability'] == 1){
                            $row['availability'] = $row['availability'].' month';
                        }else{
                            $row['availability'] = $row['availability'].' months';
                        }
                        echo 
                        '<tr>
                            <td>'.$row['company'].'</td>
                            <td><img class="littleproduct" src="'.BASEURL.'/public/img/products/'.$row['product_image'].'"></td>
                            <td>'.$row['product_name'].'</td>
                            <td class="numbers">'.$row['current_stock'].'</td>
                            <td class="numbers">'.$row['total_sale'].'</td>
                            <td class="numbers">'.$row['total_revenue'].'</td>
                            <td class="numbers">'.$row['monthly_sale'].'</td>
                            <td>'.$row['availability'].'</td>
                        </tr>';
                    }
                    ?>
                </tbody>
            </table>
            <form class="pdfform" action="<?=BASEURL ?>/reports/salesadmin/<?=$data['start_date']?>/<?=$data['end_date']?>/<?=$data['filter_by']?>" method="POST">
                <button class="btn-blue">Generate PDF</button>
            </form>
        </div>
    </div>
</section>

<?php
$footer = new Footer("admin");
?>