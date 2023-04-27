<?php
$header = new Header("admin",$data);
$sidebar = new Navigation('admin','analysis');
?>

<section class="body">
    <?php
        // call the default header for yout interface
        $bodyheader = new BodyHeader($data);
        // call whatever the component you need to show
        // $bodycontent = new ProfileHTML($data);
    ?>
    <div class="body-content">
        <h2>Sales Analysis</h2>
        <form action="<?php echo BASEURL;?>/analysis/admin" class="filters" method="POST">
                <div class="input half start"><label>From</label><input type="date" onchange="this.form.submit()" name="start_date" value="<?php echo $data['start_date']?>" max="<?php echo $data['end_date']?>"  min="<?php echo $data['date_joined'] ?>"></div>
                <div class="input half end"><label>To</label><input type="date" onchange="this.form.submit()" name="end_date" value="<?php echo $data['end_date']?>" max="<?php echo $max_date;?>" min="<?php echo $data['start_date'] ?>"></div>
                <div class="input half select"><label>Filter By Company</label>
                    <select id="period" name="company" onchange="this.form.submit()" class="dropdowndate">
                        <option  value="all" selected >All</option>
                        <?php
                            $companies = $data['companies'];
                            while($row = mysqli_fetch_assoc($companies)){
                                if($row['company_id'] == $data['company']){
                                    echo '<option value="'.$row['company_id'].'" selected>'.$row['name'].'</option>';
                                }else{
                                    echo '<option value="'.$row['company_id'].'">'.$row['name'].'</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
        </form>
        <div class="content-data analysis">
            <?php
            $charts = $data['charts'];
            for($i=0; $i<count($charts); $i++){
                $chart = $charts[$i];
                echo "<div class='chart'>
                <h4>".$chart['main']."</h4>";
                $flag = false;
                foreach($chart['vector'] as $value){
                    if($value != 0){
                        $flag = true;
                    }
                }
                if($flag && count($chart['vector']) != 0){
                    $ch = new Chart($chart['type'],$chart,$i);
                }else{
                    echo "<img class='placeholderimg' src='".BASEURL."/public/img/placeholders/2.png'>";
                }
                echo "</div>";
            }
            ?>
        </div>
    </div>
</section>
<script>
    const form = document.querySelector('form');
    form.onsubmit(e){
        e.preventDefault();
    }
</script>
<?php
$footer = new Footer("admin");
?>