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
                                <option value="7day">Last 7 days</option>
                                <option value="30day">Last 30 days</option>';

                            }elseif($data['option'] == '7day'){
                                echo '
                                <option value="today">To day</option>
                                <option value="7day"  selected>Last 7 days</option>
                                <option value="30day">Last 30 days</option>';
                            
                            }else {
                                echo '
                                <option value="today">To day</option>
                                <option value="7day">Last 7 days</option>
                                <option value="30day" selected>Last 30 days</option>';
                            }
                        
                        echo '
                        </select>
                    </form>
                </div>';
                    ?>

                    <?php
                    $records = $data['distributions'];
                    
                    $output = '
                    <div class="repbox">
                        <table class="styled-table">
                        <thead>
                            <tr>
                                <th>Distribution ID</th>
                                <th>Dealer ID</th>
                                <th>Distributed Date</th>
                                <th>Distributed Time</th>
                            </tr>
                        </thead>
                        <tbody>';
                    
                        if(count($records)>0) {
                            foreach($records as $record) {
                                $row1 = $record['completedinfo'];
                                $capacities = $record['capacities'];

                                    $date = $row1['place_date'];
                                    $time = $row1['place_time'];
                                    $distribution_num = $row1['po_id'];
                                    $dealer_id = $row1['dealer_id'];

                                $output .= '
                                    <tr>
                                        <td>'.$distribution_num.'</td>
                                        <td>'.$dealer_id.'</td>
                                        <td>'. $date.'</td>
                                        <td>'. $time.'</td>
                                        <td>
                                            <button class="btn" onclick = "document.location.href=\''.BASEURL.'/reports/distributor_pdf/'.$distribution_num.'\'">Generate PDF</button>
                                        </td>                                                                      
                                    </tr>';
                            }
                            $output .= '
                            </tbody></table>';
                        }else {
                            $output .= '</table>';
                            $output .= '<p class="nofoundtxt">No records found</p>';
                        }

                    $output .= '</div>';
                    
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