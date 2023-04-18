<?php

require_once('vendor/autoload.php');

use Facebook\WebDriver\Firefox\FirefoxOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\Exception\TimeOutException;

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
        // Navigate to Google.com
        $driver->get('https://payment.ceb.lk/instantpay');

        // Find the search box by its name attribute
        $searchBox = $driver->findElement(WebDriverBy::id('account_no'));

        // Type a search query
        $searchBox->sendKeys($bill_no);

        // Submit the form by pressing Enter key
        $searchBox->submit();

        // Wait for the results page to load
        $driver->wait(2)->until(
            WebDriverExpectedCondition::urlContains('/instantpay/payment/')
        );

        // Check if the user has successfully logged in or not
        if (strpos($driver->getCurrentURL(), '/payment') !== false) {
            // Find the search box by its name attribute
            $email = $driver->findElement(WebDriverBy::id('email'));
            if($email){
                $flag = true;
            }
        }

    }catch(TimeOutException $e){
        $flag = false;
    }

    // Print the title of the results page
    //echo $driver->getTitle();

    // Close the browser window
    $driver->quit();
    return $flag;
}
?>
