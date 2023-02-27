<?php
$header = new Header("distributor_reports");
$sidebar = new Navigation('distributor',$data['navigation']);

$user_id = $_SESSION['user_id'];
?>

<section class="body">
    <?php 
    $bodyheader = new BodyHeader($data);
    ?>

    <section class="body-content">
        <div class="split right">
        
            <h2>Reports</h2>

            <div class="main">

                <div class="header">
                    <h2>Summary of Past Distributions</h2>
                </div>
        
                <div class="middle">
                <?php echo'
                    <form action ="'.BASEURL.'/reports/distributor" method="POST">
                        <select id="period" name="option" onchange="this.form.submit()" class="dropdowndate">';
                       
                            if($data['option'] == 'today') {
                                echo '
                                <option value="today" selected>To day</option>
                                <option value="30day" >Last 30 days</option>';
                            }else {
                                echo '
                                <option value="today">To day</option>
                                <option value="30day" selected>Last 30 days</option>';
                            }
                        
                        echo '
                        </select>
                    </form>';
                        ?>
                    
                        <!-- <select id="period" onchange="updatechart()" class="dropdowndate">
                            <option value="today" selected>Last 7 days</option>
                            <option  value="month">Last 30 days</option>
                            <option  value="3months">Last 3 months</option>
                        </select> -->
                    <!-- </form> -->

                    <?php
                    $records = $data['distributions'];
                    
                    $output = '<div class="repbox">
                        <table class="styled-table">
                        <thead>
                            <tr>
                                <th>Distributed Date</th>
                                <th>Distribution ID</th>
                                <th>Dealer ID</th>
                                <th>Total Amount</th> 
                            </tr>
                        </thead>
                        <tbody>';
                    foreach($records as $record) {
                        $row1 = $record['completedinfo'];
                        $capacities = $record['capacities'];

                            $date = $row1['place_date'];
                            $distribution_num = $row1['po_id'];
                            $dealer_id = $row1['dealer_id'];

                        $output .= '
                            <tr>
                                <td>'. $date.'</td>
                                <td>'.$distribution_num.'</td>
                                <td>'.$dealer_id.'</td>
                                <td>10 000.00</td>
                                <td>
                                    <button class="btn" onclick = "document.location.href=\''.BASEURL.'/reports/distributor_pdf/'.$distribution_num.'\'">Generate PDF</button>
                                </td>
                               
                            </tr>';
                    }
                    $output .= '
                    </tbody>
                    </table>
                    </div>
                    ';
                    echo $output;
                    ?>
                   
                </div>
            </div>
        </div>
    </section>
</section>

<?php
$footer = new Footer();
?>