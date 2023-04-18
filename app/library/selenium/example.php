<?php
/*
Copyright 2011 3e software house & interactive agency

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

     http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
*/


require_once "phpwebdriver/WebDriver.php";

$webdriver = new WebDriver("localhost", "4444");
$webdriver->connect("firefox");                            
$webdriver->get("https://payment.ceb.lk/instantpay");
$element = $webdriver->findElementBy(LocatorStrategy::id, "account_no");
if ($element) {
    $element->sendKeys(array("4614167004" ) );
    $button = $webdriver->findElementBy(LocatorStrategy::id, "btnSubmit");
    $button->click();
}
$element2 = $webdriver->findElementBy(LocatorStrategy::id, "email");
if($element2){
echo "found";
}else{
echo "notfound";
}
/*$webdriver->close();*/

?>