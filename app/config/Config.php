<?php

// define('DB_TYPE','mysql');
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_NAME','gasify');
define('DB_PASSWORD','');
define('BASEURL','http://localhost/mvc');
define('DIRECTORY_SEPERATOR','/');
define('DELIVERY_DELAY_TIME',30);
define('DEFAULT_EMAIL_PWD','1234567');
define('STRIPE_SECRET_KEY',')H@McQfTjWnZr4u7x!A%D*G-JaNdRgUk');
define('MAPAPI','AIzaSyDa-fUBgg-U3Q-dEWysF4UH2QtxNZxU-7w');
$conn = mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
define('CONN',$conn);
?>