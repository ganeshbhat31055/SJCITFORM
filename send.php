<?php
/**
 * Created by PhpStorm.
 * User: ganesh
 * Date: 25/2/16
 * Time: 8:34 PM
 */
$authKey = "99876AfmwXGVvZ4tp566bac1a";
//Multiple mobiles numbers separated by comma
$mobileNumber = $_POST['Phone'];
//Sender ID,While using route4 sender id should be 6 characters long.
$senderId = "TECHFE";

//Your message to send, Add URL encoding here.
$message = urlencode("Hey Congrats, you have been selected for the 2nd round. Please assemble in ".$_POST['Message']);

//Define route
$route = "4";
//Prepare you post parameters
$postData = array(
    'authkey' => $authKey,
    'mobiles' => $mobileNumber,
    'message' => $message,
    'sender' => $senderId,
    'route' => $route
);

//API URL
$url = "https://control.msg91.com/api/sendhttp.php";

// init the resource
$ch = curl_init();
curl_setopt_array($ch, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $postData
    //,CURLOPT_FOLLOWLOCATION => true
));


//Ignore SSL certificate verification
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


//get response
$output = curl_exec($ch);

//Print error if any
if (curl_errno($ch)) {
    echo 'error:' . curl_error($ch);
}

curl_close($ch);

?>