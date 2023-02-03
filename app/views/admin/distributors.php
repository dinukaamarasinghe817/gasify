<?php
$header = new Header("admin",$data);
$sidebar = new Navigation('admin','distributors');
?>

<section class="body">
    <?php
        // call the default header for yout interface
        $bodyheader = new BodyHeader($data);
        // call whatever the component you need to show
        // $bodycontent = new ProfileHTML($data);
    ?>
    <div class="body-content">
                <form action="" class="filters">
                    <div class="input half select"><label>Filter By City</label>
                        <select id="period" name="option" onchange="this.form.submit()" class="dropdowndate">
                            <?php
                                $cities = CITIES;
                                echo '<option  value="none" selected hidden>Select a city</option>';
                                foreach($cities as $city){
                                    echo '<option  value="'.$city.'">'.$city.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="input half select"><label>Filter By Company</label>
                        <select id="period" name="option" onchange="this.form.submit()" class="dropdowndate">
                            <option  value="none" selected hidden>Select a company</option>
                            <option  value="30day" >Litro</option>
                            <option  value="30day" >Laugfs</option>
                        </select>
                    </div>
                </form>
                <div class="content-data">
                    <table class="styled-table">
                        <thead>
                            <tr>
                                <th>Distributor ID</th>
                                <th>Name</th>
                                <th>City</th>
                                <th>Company</th>
                                <th>No of vehicles</th>
                                <th>Current Gas stock</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            echo '<tr>
                                    <td>3</td>
                                    <td>Kamal Satharasinghe</td>
                                    <td>Homagama</td>
                                    <td>Litro</td>
                                    <td>5</td>
                                    <td>5000 Kg</td>
                                    <td><a class="anchor-button" href="'.BASEURL.'/profile/preview/distributor/26/profile/admin/distributorprofile" >View Profile</a></td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>Kamal Satharasinghe</td>
                                    <td>Homagama</td>
                                    <td>Litro</td>
                                    <td>5</td>
                                    <td>5000 Kg</td>
                                    <td><a class="anchor-button" href="'.BASEURL.'/profile/preview/distributor/26/profile/admin/distributorprofile" >View Profile</a></td>
                                </tr>';
                            ?>
                        </tbody>
                    </table>
                </div>
    </div>
</section>

<?php
$footer = new Footer("admin");
?>