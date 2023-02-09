<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="<?php echo BASEURL; ?>/public/css/usersstyle.css">
</head>
<body>

    <div class="wrapper">

        <div class="topic">
            <h1>Select User Type</h1>
            <p>To continue, please select your user type</p>
        </div>

        <form method="post">
            <select name="language" class="custom-select">
                <!-- <option value="admin"></option> -->
                <option value="company"></option>
                <!-- <option value="distributor"></option> -->
                <option value="customer"></option>
                <!-- <option value="dealer"></option> -->
                <option value="deliveryperson"></option>
            </select>
            
            <button onclick="redirecttouserSignup();">
                Next
                <svg width="25" height="25" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4.22949 19.2158H34.2295" stroke="white" stroke-width="7" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M19.2295 4.21582L34.2295 19.2158L19.2295 34.2158" stroke="white" stroke-width="7" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </form>

    </div>
    
    <script src="<?php echo BASEURL;?>/public/js/usersignup.js"></script>
</body>
</html>