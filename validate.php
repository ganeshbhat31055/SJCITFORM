<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    //ini_set('display_errors',1);
    // Getting the POST variables

    $Name = ucwords($_POST["Name"]);
    $USN  =  $_POST["Usn"];
    $Email = $_POST["Email"];
    $Phone = $_POST["Phone"];
    $Event = $_POST["Event"];


    //Connecting to Database
    try{
        $db=new PDO("mysql:host=localhost;dbname=Technotsav","root","");
        $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $db->exec("SET NAMES 'utf8'");
    } catch(Exception $e)
    {
        echo "<p id=txt>Couldn't connect to database</p>";
        exit;
    }



    // Checking the Data validation
    if(trim($Name)==NULL){
        echo "<p class='txt5'>Name is not valid or empty</p>";
        exit;
    }
    else {
        $re1='(\\d)';	# Any Single Digit 1
        $re2='([a-z]|[A-Z])';	# Any Single Word Character (Not Whitespace) 1
        $re3='([a-z]|[A-Z])';	# Any Single Word Character (Not Whitespace) 2
        $re4='(\\d)';	# Any Single Digit 2
        $re5='(\\d)';	# Any Single Digit 3
        $re6='([a-z]|[A-Z])';	# Any Single Word Character (Not Whitespace) 3
        $re7='([a-z]|[A-Z])';	# Any Single Word Character (Not Whitespace) 4
        $re8='(\\d)';	# Any Single Digit 4
        $re9='(\\d)';	# Any Single Digit 5
        $re10='(\\d)';	# Any Single Digit 6

        if (!($c=preg_match_all ("/".$re1.$re2.$re3.$re4.$re5.$re6.$re7.$re8.$re9.$re10."/is", $USN, $matches)))
        {
            echo "<p class='txt5'>USN is not valid</p>";
            exit;

        }else {


            if (filter_var($Email, FILTER_VALIDATE_EMAIL) === false) {

                echo "<p class=txt5>$Email is a not valid email address<p>";

                exit;
            } else {
                try {
                    $EmailR = $db->query("SELECT Email FROM Tech WHERE Email = '$Email'");
                } catch (Exception $e) {
                    echo "<p id=txt>Database Email error</p>";
                    exit;
                }
                if ($EmailR->fetchAll() != NULL) {
                    echo "<p class=txt5>Email already exists\n</p>";

                    exit;
                } else {
                    if (strlen($Phone) != 10) {
                        echo "<p class=txt5>Phone Number has been entered incorrectly</p>";
                        exit;
                    } else {
                        try {
                            $PhoneR = $db->query("SELECT Phone FROM Tech WHERE Phone = '$Phone'");
                        } catch (Exception $e) {
                            echo "<p id=txt>Database Phone error</p>";
                            exit;
                        }

                        if ($PhoneR->fetchAll() != NULL) {
                            echo "<p class=txt5>Somebody has already registered with this phone</p>";
                            exit;
                        } else {
                            try {
                                $results = $db->query("INSERT INTO Tech (Name,Email,Phone,Event,Usn) VALUES ('$Name','$Email','$Phone','$Event','$USN')");
                                $Result = $db->query("SELECT * FROM Tech");
                                $num = $Result->rowCount();
                                echo "$num";
                                $authKey = "99876AfmwXGVvZ4tp566bac1a";
                                //Multiple mobiles numbers separated by comma
                                $mobileNumber = $Phone;
                                //Sender ID,While using route4 sender id should be 6 characters long.
                                $senderId = "TECHFE";

                                //Your message to send, Add URL encoding here.
                                $message = urlencode("Thanks for Registering $Name for $Event Event with PNR : $num . Event rules will be sent to your maildID. Please provide this SMS on the Day of TechFest");

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
                            } catch (Exception $e) {
                                echo "<p id=txt>Database not available</p>";
                                exit;
                            }
                            global $Name;
                            echo "<img id='correct' alt='image not found' src = Done.jpg />";
                            echo "<p class=txt>Thanks for registering $Name,Please provide the SMS during the Event</p>";
                        }
                    }
                }
            }
        }


    }

} ?>