<?php
$header = new Header("admin",$data);
$sidebar = new Navigation('admin','companies');
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
                    <div class="input half select"><label>Sort By</label>
                        <select id="period" name="option" onchange="this.form.submit()" class="dropdowndate">
                            <option  value="30day" selected>Gas Stock</option>
                            <option  value="30day" selected>Distributor Base</option>
                            <option  value="30day" selected>Dealer Base</option>
                        </select>
                    </div>
                </form>
                <div class="content-data">
                    <table class="styled-table">
                        <thead>
                            <tr>
                                <th>Company ID</th>
                                <th>Name</th>
                                <th>Distributor Base</th>
                                <th>Dealer Base</th>
                                <th>Current Gas stock</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            echo '<tr>
                                    <td>1</td>
                                    <td>Litro</td>
                                    <td>5</td>
                                    <td>5</td>
                                    <td>5000 Kg</td>
                                    <td><a class="anchor-button" href="'.BASEURL.'/profile/preview/company/2/profile/admin/companyprofile" >View Profile</a></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Litro</td>
                                    <td>5</td>
                                    <td>5</td>
                                    <td>5000 Kg</td>
                                    <td><a class="anchor-button" href="'.BASEURL.'/profile/preview/company/2/profile/admin/companyprofile" >View Profile</a></td>
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