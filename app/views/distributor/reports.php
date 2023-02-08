<?php
$header = new Header("distributor_reports");
$sidebar = new Navigation('distributor',$data['navigation']);
?>

<section class="body">
    <?php 
    $bodyheader = new BodyHeader($data);
    ?>

    <section class="body-content">
        <div class="split right">
        
            <h1>Reports</h1>

            <div class="main">

                <div class="header">
                    <h2>Summary of Past Distributions</h2>
                </div>
        
                <div class="middle">
                    <select id="period" onchange="updatechart()" class="dropdowndate">
                        <option value="today" selected>Last 7 days</option>
                        <option  value="month">Last 30 days</option>
                        <option  value="3months">Last 3 months</option>
                    </select>

                    <?php
                    $records = $data['distributions'];
                    foreach($records as $record) {
                        $row1 = $record['completedinfo'];
                        $capacities = $record['capacities'];

                        $output = '<div class="repbox">
                        <table class="table1">
                            <tr>
                                <th>Distributed Date</th>
                                <th>Distribution ID</th>
                                <th>Dealer ID</th>
                                <th>Total Amount</th>
                                
                            </tr>';

                            $date = $row1['place_date'];
                            $distribution_num = $row1['po_id'];
                            $dealer_id = $row1['dealer_id'];

                        $output .= '
                            <tr>
                                <td>'. $date.'</td>
                                <td>'.$distribution_num.'</td>
                                <td>'.$dealer_id.'</td>
                                <td>10 000.00</td>
                               
                            </tr>
                        </table>

                        </div>';
                    }
                    echo $output;
                    ?>

                    <div class="beginbtn">
                        <a class="btn" href="<?php echo BASEURL ?>/reports/salesdealer">Generate PDF</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>

<?php
$footer = new Footer();
?>