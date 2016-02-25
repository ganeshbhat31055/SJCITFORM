<?php
/**
 * Created by PhpStorm.
 * User: ganesh
 * Date: 25/2/16
 * Time: 5:31 PM
 */
try {
    $db = new PDO("mysql:host=localhost;dbname=Technotsav", "root", "");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec("SET NAMES 'utf8'");
    $win = $_GET['term'];
    $Result = $db->query("SELECT Phone,Name FROM Tech WHERE Phone LIKE '%".$win."%' ORDER BY Phone ASC");
    while ($row = $Result->fetch(PDO::FETCH_ASSOC)) {

        $data[] = $row['Phone'];
    }
    echo json_encode($data);
} catch (Exception $e) {
    echo "<p id=txt>Couldnt connect to database</p>";
    exit;
}
?>