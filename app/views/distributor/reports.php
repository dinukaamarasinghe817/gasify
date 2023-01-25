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

                    <!-- <div class="beginbtn">
                        <button class="btn"><b>Generate pdf file</b></button>
                    </div> -->

                    <table>
                        <tr>
                            <th>Distributed Date</th>
                            <th>Distribution ID</th>
                            <th>Dealer ID</th>
                            <th>Total Price (Rs. )</th>
                            <th></th>
                        </tr>

                        <tr>
                            <td>2022.09.20</td>
                            <td>4</td>
                            <td>5</td>
                            <td>50000.00</td>
                            <td><button class="inside">Select</button></td>
                        </tr>

                        <tr>
                            <td>2022.09.22</td>
                            <td>3</td>
                            <td>6</td>
                            <td>25000.00</td>
                            <td><button class="inside">Select</button></td>
                        </tr>

                        <tr>
                            <td>2022.08.20</td>
                            <td>2</td>
                            <td>5</td>
                            <td>53000.00</td>
                            <td><button class="inside">Select</button></td>
                        </tr>

                        <tr>
                            <td>2022.08.02</td>
                            <td>1</td>
                            <td>9</td>
                            <td>20000.00</td>
                            <td><button class="inside">Select</button></td>
                        </tr> 

                    </table>

                    <div class="beginbtn">
                        <button class="btn"><b>Generate pdf file</b></button>
                    </div>


                </div>
            </div>
        </div>
    </section>
</section>

<?php
$footer = new Footer();
?>