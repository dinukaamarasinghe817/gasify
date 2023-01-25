<?php
    $header = new Header("login");
    if(isset($data['toast'])){
        $error = new Prompt('toast',$data['toast']);
        echo '<script>
            showToast();
        </script>';
    }
?>
    <div class="container">
        <div class="wrapper">
            <div class="logo">
                <img src="<?php echo BASEURL; ?>/public/img/login.png" alt="company logo">
            </div>
            <div class="form">
                <?php $var = new ForgotPWD($data['variant'],$data);?>
            </div>
        </div>
    </div>
<?php
$footer = new Footer("signin");
?>