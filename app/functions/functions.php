<?php
$cities = ['Navala','Nugegoda', 'Rajagiriya', 'Angoda', 'Athurugiriya', 'Battaramulla', 'Biyagama', 'Boralesgamuwa', 'Dehiwala', 'Kadawatha', 'Kelaniya', 'Kaduwela', 'Kalubowila', 'Kandana', 'Kesbewa', 'Kiribathgoda', 'Kolonnawa', 'Koswatte', 'Kotikawatta', 'Kottawa', 'Gothatuwa', 'Hokandara', 'Homagama', 'Ja-Ela', 'Maharagama', 'Malabe', 'Moratuwa', 'Mount Lavinia', 'Pannipitiya', 'Pelawatte', 'Peliyagoda', 'Piliyandala', 'Ragama', 'Ratmalana', 'Thalawathugoda', 'Wattala'];
sort($cities);
$banks = ['Bank Of Ceylon', 'Commercial Bank', 'DFCC Bank', 'Hatton National Bank', 'Nation Trust Bank', 'Peoples Bank', 'Sampath Bank', 'Seylan Bank', 'National Saving Bank'];
sort($banks);
$vehicles = ['Car','Van','Mini Truck','Bike','Bicycle','Three Wheel'];
sort($vehicles);
define('CITIES',$cities);
define('BANKS',$banks);
define('VEHICLES',$vehicles);
function createSession($conn, $email, $user){
    $sql = "SELECT * FROM {$user} WHERE email = '{$email}'";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query)>0){
        $row = mysqli_fetch_assoc($query);
        return $row["{$user}_id"];
    }else{
        return NULL;
    }
}

function isPasswordNotStrength($password){
    $upper = preg_match('@[A-Z]@', $password);
    $lower = preg_match('@[a-z]@', $password);
    $number = preg_match('@[0-9]@', $password);
    $specialchar = preg_match('@[^\w]@', $password);

    if(!$upper || !$lower || !$number || !$specialchar){
        return true;
    }else{
        return false;
    }
}

function isEmpty(array $fields){
    foreach( $fields as $field ){
        if(empty($field)){
            return true;
        }
    }
    return false;
}

function isNotValidEmail($email){
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        return false;
    }else{
        return true;
    }
}

// function isUserExist($conn, $email){
//     $sql = "SELECT email FROM (SELECT email FROM admin
//     UNION SELECT email FROM customer
//     UNION SELECT email FROM dealer
//     UNION SELECT email FROM company
//     UNION SELECT email FROM distributor
//     UNION SELECT email FROM delivery_person) temp WHERE temp.email = '{$email}'";
//     $result = mysqli_query($conn, $sql);
//     if(mysqli_num_rows($result) > 0){
//         return true;
//     }else{
//         return false;
//     }
// }

function getImageRename($image_name,$tmp_name){
    $time  = time();
    return $time.$image_name;
}

function getImageExtension($image_name){
    $image_explode = explode('.',$image_name);
    $image_extension = end($image_explode);
    return $image_extension;
}

function isNotValidImageFormat($image_name){
    // all the valid types of images
    $extensions = ['png', 'jpg', 'jpeg', 'PNG', 'JPEG', 'JPG'];
    $image_extension = getImageExtension($image_name);
    if(in_array($image_extension,$extensions)){
        return false;
    }else{
        return true;
    }
}

function randomString(){
    $length = 16 - 4;
    $capital_letters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $simple_letters = "abcdefghijklmnopqrstuvwxyz";
    $digits = "0123456789";
    $special_chars = "@#$";
    $all = $capital_letters.$simple_letters.$digits.$special_chars;

    $string = "";
    $string .= $capital_letters[random_int(0,strlen($capital_letters)-1)];
    $string .= $simple_letters[random_int(0,strlen($simple_letters)-1)];
    $string .= $digits[random_int(0,strlen($digits)-1)];
    $string .= $special_chars[random_int(0,strlen($special_chars)-1)];

    while($length--){
        $string .= $all[random_int(0,strlen($all)-1)];
    }
    
    return $string;
}

function isNotConfirmedpwd($password, $confirmpassword){
    if($password == $confirmpassword){
        return false;
    }else{
        return true;
    }
}

function phpArrtoJs($array){
    $result = '[';
    foreach($array as $elem){
        $result .= '"'.$elem.'",';
    }
    $result = rtrim($result,',');
    $result .= ']';
    return $result;
}

function notificationIcon($type){
    $source = '';
    if($type == 'Re-order Level Alert'){
        $source = 'alert.png';
    }else{
        $source = 'mail.png';
    }
    return '<img src="'.BASEURL.'/public/img/icons/'.$source.'" alt="">';
}

// for electricity bill number verification
require_once('../app/library/selenium/vendor/autoload.php');
use Facebook\WebDriver\Firefox\FirefoxOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\Exception\TimeOutException;
use Facebook\WebDriver\Exception\NoSuchElementException;

function verify_ebill($bill_no){
    // set the return value
    $flag = false;
    // Set the capabilities of the Selenium server
    $options = new FirefoxOptions();
    $options->addArguments(['--headless']);
    $capabilities = DesiredCapabilities::firefox();
    $capabilities->setCapability(FirefoxOptions::CAPABILITY, $options);

    // Set the URL of the Selenium server
    $host = 'http://localhost:4444/wd/hub';

    // Create a new instance of RemoteWebDriver
    $driver = RemoteWebDriver::create($host, $capabilities);

    try{
        // Navigate to website
        $driver->get('https://payment.ceb.lk/instantpay');
        $searchBox = $driver->findElement(WebDriverBy::id('account_no'));
        $searchBox->sendKeys($bill_no);
        $searchBox->submit();

        // Wait for the results page to load
        $driver->wait(2)->until(
            WebDriverExpectedCondition::urlContains('/instantpay/payment/')
        );

        // Check if the ebill has successfully verified in or not
        if (strpos($driver->getCurrentURL(), '/instantpay/payment') !== false) {
            $email = $driver->findElement(WebDriverBy::id('email'));
            if($email){
                $flag = true;
            }
        }

    }catch(TimeOutException $e){
        // 
        try{
            // Navigate to website
            $driver->get('https://lecoapp.leco.lk/OnlineBillPay/Instant_Pay.aspx');
            $searchBox = $driver->findElement(WebDriverBy::id('MainContent_TxtAccount_number'));
            $searchBox->sendKeys($bill_no);
            $btn = $driver->findElement(WebDriverBy::id('MainContent_BtnCheck1'));
            $btn->click();

            // Wait for the results page to load
            $driver->wait(2)->until(
                WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::id('MainContent_BtnPayNow'))
            );
            $button = $driver->findElement(WebDriverBy::id('MainContent_BtnPayNow'));
            if(!empty($button)){
                $flag = true;
                if (strpos($driver->getCurrentURL(), 'aspxerrorpath') !== false) {
                    $flag = false;
                }
            }else{
                $flag = false;
            }
        }catch(NoSuchElementException | TimeOutException $e){
            $flag = false;
        }
    }
    // Close the browser window
    $driver->quit();
    return $flag;
}

// function to calculate the distance between two given addresses
function getDistance($origin, $destination) {
    $url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" . urlencode($origin) . "&destinations=" . urlencode($destination) . "&units=metric&key=".MAPAPI;

    $response = file_get_contents($url);
    $json = json_decode($response, true);

    if ($json['status'] == 'OK') {
        return $json['rows'][0]['elements'][0]['distance']['value'] / 1000;
    } else {
        return false;
    }
}

function userRole(){
    $role = $_SESSION['role'];
    switch($role){
        case 'admin':
            $output = "Administrator";
            break;
        case 'customer':
            $output = "Customer";
            break;
        case 'dealer':
            $output = "Dealer";
            break;
        case 'distributor':
            $output = "Distributor";
            break;
        case 'company':
            $output = "Company";
            break;
        case 'delivery':
            $output = "Delivery";
            break;
    }
    return $output;
}

function deleteFile($file_name,$type){
    $primary_path = BASEURL.'/public/img/'.$type.'/'.$file_name;
    if((strpos($file_name, 'default') === false) && file_exists($primary)){
        unlink($file_path);
    }
}

// Encrypt the Stripe key
function encryptStripeKey($stripeKey) {
    $secretKey = getenv('STRIPE_SECRET_KEY');
    $cipher = "aes-256-cbc";
    $ivlen = openssl_cipher_iv_length($cipher);
    $iv = openssl_random_pseudo_bytes($ivlen);
    $encrypted = openssl_encrypt($stripeKey, $cipher, $secretKey, $options=0, $iv);
    return base64_encode($iv . $encrypted);
}

// Decrypt the Stripe key
function decryptStripeKey($encryptedStripeKey) {
    $secretKey = getenv('STRIPE_SECRET_KEY');
    $cipher = "aes-256-cbc";
    $iv_with_ciphertext = base64_decode($encryptedStripeKey);
    $ivlen = openssl_cipher_iv_length($cipher);
    $iv = substr($iv_with_ciphertext, 0, $ivlen);
    $ciphertext = substr($iv_with_ciphertext, $ivlen);
    $decrypted = openssl_decrypt($ciphertext, $cipher, $secretKey, $options=0, $iv);
    return $decrypted;
}
?>