<!-- Copyright GANESH P BHAT -->
<!-- Fully documented code is available, anybody can download or fork me on Github.com at ganeshbhat31055
Happy Coding -->
<!--Have a feedback? mail me at ganeshpnbhat@gmail.com-->
<?php
include("password_protect.php");
?>

<!DOCTYPE html PUBLIC “-//W3C//DTD XHTML 1.0 Strict//EN”
    “http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd”>
<html xmlns=”http://www.w3.org/1999/xhtml” lang=”en” xml:lang=”en”>
<head>
    <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
    <link href="CSS/main.css" type="text/css" rel="stylesheet"/>
    <link href="CSS/normalize.css" type="text/css" rel="stylesheet"/>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body class="body1">
<div class="header">
    <p id="technotsav" onclick="home()">Technotsav Admin Panel</p>
</div>
<div id="Abutton">
    <form id="event" method="get" action="./databaseAPanel.php">
        <select name="Event" id="branch">
            <option value="All">All</option>
            <option value="Coding">Coding</option>
            <option value="Quiz">Quiz</option>
            <option value="Gaming">Gaming</option>
            <option value="Paper">Paper Presentation</option>
            <option value="Coord">Coordinators</option>
        </select>
        <button id="Download PDF" type="submit" form="event">Download</button>
    </form>
  <button id="Show Co-od" onclick="Show()">Show Co-od</button>
  <button id="Log Out" onclick="Addco()">Add Co-Od</button>
  <button id="Log Out" onclick="Mes()">Message</button>
    <button id="Log Out" onclick="Winmes()">Winner!</button>
  <button id="Log Out" onclick="LogO()">Log Out</button>

</div>
<div>
<?php
if($_SERVER['REQUEST_METHOD']=="POST") {

    if($_POST['Mes'])
    {

        $Message = $_POST['Message'];
        try {
            $db = new PDO("mysql:host=localhost;dbname=Technotsav", "root", "");
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->exec("SET NAMES 'utf8'");
        } catch (Exception $e) {
            echo "<p id=txt>Couldn't connect to database</p>";
            exit;
        }

        $resultp = $db->query("SELECT Phone FROM TechCo");
        $res3 = $resultp->fetchAll(PDO::FETCH_ASSOC);
        $phone;
        foreach ($res3 as $k) {
            global $phone;

            $phone .= $k['Phone'];
            $phone .= ',';
        }


        $authKey = "99876AfmwXGVvZ4tp566bac1a";
        //Multiple mobiles numbers separated by comma
        $mobileNumber = $phone;
        //Sender ID,While using route4 sender id should be 6 characters long.
        $senderId = "TECHCO";

        //Your message to send, Add URL encoding here.
        $message = urlencode($Message);

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


    }elseif(isset($_POST['addCoord'])){

        $Name = ucwords($_POST["Name"]);
        $USN = $_POST["Usn"];
        $Branch = $_POST["Branch"];
        $Phone = $_POST["Phone"];
        $Semester = $_POST["Sem"];

        try {
            $db = new PDO("mysql:host=localhost;dbname=Technotsav", "root", "");
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->exec("SET NAMES 'utf8'");
        } catch (Exception $e) {
            echo "<p id=txt>Couldn't connect to database</p>";
            exit;
        }


        // Checking the Data validation
        if (trim($Name) == NULL) {
            echo "<p class='txt'>Name is not valid or empty</p>";
            exit;
        } else {
            $re1 = '(\\d)';    # Any Single Digit 1
            $re2 = '([a-z]|[A-Z])';    # Any Single Word Character (Not Whitespace) 1
            $re3 = '([a-z]|[A-Z])';    # Any Single Word Character (Not Whitespace) 2
            $re4 = '(\\d)';    # Any Single Digit 2
            $re5 = '(\\d)';    # Any Single Digit 3
            $re6 = '([a-z]|[A-Z])';    # Any Single Word Character (Not Whitespace) 3
            $re7 = '([a-z]|[A-Z])';    # Any Single Word Character (Not Whitespace) 4
            $re8 = '(\\d)';    # Any Single Digit 4
            $re9 = '(\\d)';    # Any Single Digit 5
            $re10 = '(\\d)';    # Any Single Digit 6

            if (!($c = preg_match_all("/" . $re1 . $re2 . $re3 . $re4 . $re5 . $re6 . $re7 . $re8 . $re9 . $re10 . "/is", $USN, $matches))) {
                echo "<p class='txt'>USN is not valid</p>";
                exit;

            } else {
                if (strlen($Phone) != 10) {
                    echo "<p class=txt>Phone Number has been entered incorrectly</p>";
                    exit;
                } else {
                    try {
                        $PhoneR = $db->query("SELECT Phone FROM TechCo WHERE Phone = '$Phone'");
                    } catch (Exception $e) {
                        echo "<p id=txt>Database Phone error</p>";
                        exit;
                    }

                    if ($PhoneR->fetchAll() != NULL) {
                        echo "<p class=txt>Somebody has already registered with this phone</p>";
                        exit;
                    } else {
                        try {
                            $db->query("INSERT INTO TechCo (Name,USN,Phone,Branch,Semester) VALUES ('$Name','$USN','$Phone','$Branch','$Semester')");
                        } catch (Exception $e) {
                            echo "<p id=txt>Database not available</p>";
                            exit;
                        }
                        header("Location:databaseAPanel.php?getm=added");
                    }
                }
            }
        }
    }else{
ini_set('display_errors', 1);

//Connecting to Database
try {
    $db = new PDO("mysql:host=localhost;dbname=Technotsav", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec("SET NAMES 'utf8'");
} catch (Exception $e) {
    echo "<p id=txt>Couldnt connect to database</p>";
    exit;
}
try {
    $Result = $db->query("SELECT * FROM Tech");
} catch (Exception $e) {
    echo "<p id=txt>Database Email error</p>";
    exit;
}
?>
    <table border="3">
        <tr>
            <th id="txt2">S.no</th>
            <th id="txt2">Name</th>
            <th id="txt2">USN</th>
            <th id="txt2">Email</th>
            <th id="txt2">Phone</th>
            <th id="txt2">Event</th>
        </tr>
        <?php
        $res = $Result->fetchAll(PDO::FETCH_ASSOC);
        $i = 1;
        foreach ($res as $k) {
            echo "<tr>";
            echo "<td id=\"txt1\">" . $i . "</td>";
            echo "<td id=\"txt1\">" . $k['Name'] . "</td>";
            echo "<td id=\"txt1\">" . $k['Usn'] . "</td>";
            echo "<td id=\"txt1\">" . $k['Email'] . "</td>";
            echo "<td id=\"txt1\">" . $k['Phone'] . "</td>";
            echo "<td id=\"txt1\">" . $k['Event'] . "</td>";
            echo "</tr>";
            $i++;
        }
        }
}


if($_SERVER['REQUEST_METHOD']== "GET")
{
if(isset($_GET['Event']))
{
        include("./mpdf/mpdf.php");
        if($_GET['Event']=='All'){
            $evnt = '';
            $namepdf = 'Technotsav_All.pdf';
        }elseif($_GET['Event']=='Coding')
        {
            $evnt = "WHERE Event = 'Coding'";
            $namepdf = 'Technotsav_Coding.pdf';
        }
        elseif($_GET['Event']=='Gaming')
        {
            $evnt = "WHERE Event = 'Gaming'";
            $namepdf = 'Technotsav_Gaming.pdf';
        }
        elseif($_GET['Event']=='Quiz')
        {
            $evnt = "WHERE Event = 'Quiz'";
            $namepdf = 'Technotsav_Quiz.pdf';
        }
        elseif($_GET['Event']=='Paper')
        {
            $evnt = "WHERE Event = 'Paper Presentation'";
            $namepdf = 'Technotsav_Paper.pdf';
        } elseif($_GET['Event']=='Coord')
        {
            header("Location:databaseAPanel.php?getm=pdf2");
        }

        $mpdf = new mPDF('utf-8', 'A4-L');
        // Buffer the following html with PHP so we can store it to a variable later

        $html = '<table style="border: 1px solid;width: 100%;text-align: center;color: black"><tr><th style="border: 1px solid;">Present</th><th style="border: 1px solid;">S.no</th><th style="border: 1px solid;">Name</th><th style="border: 1px solid;">USN</th><th  style="border: 1px solid;">Email</th><th style="border: 1px solid;">Phone</th><th style="border: 1px solid;">Event</th></tr>';

        try {
            $db = new PDO("mysql:host=localhost;dbname=Technotsav", "root", "");
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->exec("SET NAMES 'utf8'");
        } catch (Exception $e) {
            echo "<p id=txt>Couldnt connect to database</p>";
            exit;
        }
        try {
            $Result = $db->query("SELECT * FROM Tech $evnt");
        } catch (Exception $e) {
            echo "<p id=txt>Database error</p>";
            exit;
        }

        $res = $Result->fetchAll(PDO::FETCH_ASSOC);
        $i = 1;
        foreach ($res as $k) {
            global $html1;

            $html1 .= '<tr>';
            $html1 .=  '<td style="border: 1px solid;">' . '<form method = "POST" enctype = "multipart/form-data"><input type="checkbox" name="Present" value="Yes"></form>'.'</td>';
            $html1 .=  '<td style="border: 1px solid;">' . $i . '</td>';
            $html1 .=  '<td style="border: 1px solid;">' . $k['Name'] . '</td>';
            $html1 .=  '<td style="border: 1px solid;">' . $k['Usn'] . '</td>';
            $html1 .=  '<td style="border: 1px solid;">' . $k['Email'] . '</td>';
            $html1 .=  '<td style="border: 1px solid;">' . $k['Phone'] . '</td>';
            $html1 .=  '<td style="border: 1px solid;">' . $k['Event'] . '</td>';
            $html1 .=  '</tr>';
            $i++;
        }
        $html1 .= '</table>';
        $html .= $html1;
    header("Content-type:application/pdf");
        $mpdf->WriteHTML($html);
        $mpdf->useActiveForms = true;
        $mpdf->showWatermarkText = true;
        $mpdf->WriteHTML('<watermarktext content="Technotsav 2016" alpha="0.2" />');
        $mpdf->SetProtection(array('copy', 'print','fill-forms','modify','annot-forms','extract','assemble','print-highres'), 'Technotsav', 'Technotsav');
        $mpdf->Output($namepdf, 'D');
        exit;


}

if (isset($_GET["getm"])){

if($_GET["getm"]=='pdf2')
{
    include("./mpdf/mpdf.php");
    $mpdf = new mPDF('utf-8', 'A4-L');
    // Buffer the following html with PHP so we can store it to a variable later

    $html = '<table style="border: 1px solid;width: 100%;text-align: center;color: black"><tr><th style="border: 1px solid;">S.no</th><th style="border: 1px solid;">Name</th><th style="border: 1px solid;">USN</th><th  style="border: 1px solid;">Phone</th><th style="border: 1px solid;">Branch</th><th style="border: 1px solid;">Semester</th></tr>';

    try {
        $db = new PDO("mysql:host=localhost;dbname=Technotsav", "root", "");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->exec("SET NAMES 'utf8'");
    } catch (Exception $e) {
        echo "<p id=txt>Couldnt connect to database</p>";
        exit;
    }
    try {
        $Result = $db->query("SELECT * FROM TechCo");
    } catch (Exception $e) {
        echo "<p id=txt>Database Email error</p>";
        exit;
    }

    $res = $Result->fetchAll(PDO::FETCH_ASSOC);
    $i = 1;
    foreach ($res as $k) {
        global $html1;

        $html1 .= '<tr>';
        $html1 .=  '<td style="border: 1px solid;">' . $i . '</td>';
        $html1 .=  '<td style="border: 1px solid;">' . $k['Name'] . '</td>';
        $html1 .=  '<td style="border: 1px solid;">' . $k['USN'] . '</td>';
        $html1 .=  '<td style="border: 1px solid;">' . $k['Phone'] . '</td>';
        $html1 .=  '<td style="border: 1px solid;">' . $k['Branch'] . '</td>';
        $html1 .=  '<td style="border: 1px solid;">' . $k['Semester'] . '</td>';
        $html1 .=  '</tr>';
        $i++;
    }
    $html1 .= '</table>';
    $html .= $html1;

    $mpdf->WriteHTML($html);
    $mpdf->useActiveForms = true;
    $mpdf->showWatermarkText = true;
    $mpdf->WriteHTML('<watermarktext content="Technotsav 2016" alpha="0.2" />');
    $mpdf->SetProtection(array('copy', 'print','fill-forms','modify','annot-forms','extract','assemble','print-highres'), 'Technotsav', 'Technotsav');
    $mpdf->Output('Coordinator.pdf', 'D');
    exit;
}

    elseif($_GET['getm']=='add')
    {?>

        <div id="content">
        <div id="form">
        <form method="post" action="./databaseAPanel.php " id="addCoord">
            <p id="txt">Name:</p>
            <input id="inp" type="text" name="Name"/>
            <p id="txt">USN:</p>
            <input id="inp" type="text" name="Usn"/>
            <p id="txt">Phone(don't enter country code):</p>
            <input id="inp" alt="Dont enter country code" type="text" name="Phone"/>
            <p id="txt">Branch</p>
            <select name="Branch" id="branch">
                <option value="CSE">CSE</option>
                <option value="CIVIL">CIVIL</option>
                <option value="ECE">ECE</option>
                <option value="ISE">ISE</option>
                <option value="MECH">MECH</option>
                <option value="TCE">TCE</option>
            </select>
            <p id="txt">Semester:</p>
            <select name="Sem" id="sem">
                <option value="2nd">II</option>
                <option value="4th">IV</option>
                <option value="6th">VI</option>
                <option value="8th">VII</option>
            </select>
            <input type="submit" id="Submit" name="Submit"/>
            </form>
            </div>
        </div>
    <?php
    }

    elseif($_GET['getm']=='added')
    {
        echo "<p id=txt>Coordinator added</p>";


    }

    if($_GET['getm']=='show')
    {
        try {
    $db = new PDO("mysql:host=localhost;dbname=Technotsav", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec("SET NAMES 'utf8'");
} catch (Exception $e) {
    echo "<p id=txt>Couldnt connect to database</p>";
    exit;
}
try {
    $Result = $db->query("SELECT * FROM TechCo");
} catch (Exception $e) {
    echo "<p id=txt>Database Email error</p>";
    exit;
}
?>
    <table border="3">
        <tr>
            <th id="txt2">S.no</th>
            <th id="txt2">Name</th>
            <th id="txt2">USN</th>
            <th id="txt2">Phone</th>
            <th id="txt2">Branch</th>
            <th id="txt2">Semester</th>
        </tr>
        <?php
        $res = $Result->fetchAll(PDO::FETCH_ASSOC);
        $i = 1;
        foreach ($res as $k) {
            echo "<tr>";
            echo "<td id=\"txt1\">" . $i . "</td>";
            echo "<td id=\"txt1\">" . $k['Name'] . "</td>";
            echo "<td id=\"txt1\">" . $k['USN'] . "</td>";
            echo "<td id=\"txt1\">" . $k['Phone'] . "</td>";
            echo "<td id=\"txt1\">" . $k['Branch'] . "</td>";
            echo "<td id=\"txt1\">" . $k['Semester'] . "</td>";
            echo "</tr>";
            $i++;
        }?>
        </table>
        <?php


    }



    if($_GET['getm']=='Log')
    {
        header("Location:databaseAPanel.php?logout=1");
    }

        if($_GET['getm']=='mes'){
            ?>


                    <form method="post" action="./databaseAPanel.php" id="Form">
                        <textarea form="Form" cols="35" rows="13" name="Message"></textarea>
                        <input id="msgSub" type="submit" name="Mes"/>
                    </form>


        <?php

        }
        if($_GET['getm']=='home'){

            header("Location:databaseAPanel.php");
        }

        if($_GET['getm']=='win'){
        ?>
            <div id="content">
                <div id="form">
                    <p id="txt">Phone: </p>
                    <input type="text" id="inp"/>
                    <p id="txt">At: </p>
                    <input type="text" id="at"/>
                    <button id="sendW">Send</button>
                </div>
            </div>
        <?php
        }
    }else{
        ini_set('display_errors', 1);

        //Connecting to Database
        try {
            $db = new PDO("mysql:host=localhost;dbname=Technotsav", "root", "");
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->exec("SET NAMES 'utf8'");
        } catch (Exception $e) {
            echo "<p id=txt>Couldnt connect to database</p>";
            exit;
        }
        try {
            $Result = $db->query("SELECT * FROM Tech");
        } catch (Exception $e) {
            echo "<p id=txt>Database Email error</p>";
            exit;
        }
        ?>
        <table border="3">
            <tr>
                <th id="txt2">S.no</th>
                <th id="txt2">Name</th>
                <th id="txt2">USN</th>
                <th id="txt2">Email</th>
                <th id="txt2">Phone</th>
                <th id="txt2">Event</th>
            </tr>
            <?php
            $res = $Result->fetchAll(PDO::FETCH_ASSOC);
            $i = 1;
            foreach ($res as $k) {
                echo "<tr>";
                echo "<td id=\"txt1\">" . $i . "</td>";
                echo "<td id=\"txt1\">" . $k['Name'] . "</td>";
                echo "<td id=\"txt1\">" . $k['Usn'] . "</td>";
                echo "<td id=\"txt1\">" . $k['Email'] . "</td>";
                echo "<td id=\"txt1\">" . $k['Phone'] . "</td>";
                echo "<td id=\"txt1\">" . $k['Event'] . "</td>";
                echo "</tr>";
                $i++;
            }
            ?>
        </table>
        <?php
            }
}

 ?>


    <script>

        function LogO(){
            window.location.href = 'databaseAPanel.php?getm=Log';

        }

        function Show()
        {
            window.location.href = 'databaseAPanel.php?getm=show';
        }

        function Mes()
        {
            window.location.href = 'databaseAPanel.php?getm=mes';
        }

        function Addco()
        {
            window.location.href = 'databaseAPanel.php?getm=add';
        }

        function home(){
            window.location.href  = 'databaseAPanel.php?getm=home';
        }

        function Winmes(){
            window.location.href  = 'databaseAPanel.php?getm=win';
        }


            jQuery("#inp").autocomplete({
                source: "search.php"
            });

            jQuery("#sendW").click(function(){
               var phone =  document.getElementById("inp").value;
                var At = document.getElementById("at").value;
                jQuery.post("send.php",{Phone : phone, Message : At},function(response){
                    alert("Message Sent");
                });
            });




    </script>

 </div>
<?php include("INC/footer.php");?>
