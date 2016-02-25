<!-- Copyrights GANESH P BHAT, Technotsav
The following code has been documented for Educational purpose -->

<?php  include("INC/header.php"); ?>
        <div id="content">
        <div id="form">
            <p id = "error">
<?php

// Getting the POST variables

$Passd = $_POST["Password"];
                //  $2y$10$EXPvvAZo4xw8BtLyHIB5kueWeljC6uiyBHU7yJl5B9JJTVI8CauaG

if(isset($Passd)){
    $hash='$2y$10$EXPvvAZo4xw8BtLyHIB5kueWeljC6uiyBHU7yJl5B9JJTVI8CauaG';

if(!password_verify($Passd,$hash)){
    echo "Password is incorrect\n";
    echo "Login again\n";
    exit;
}
    else{
        session_start();
        $a = session_id();
        header("Location:databaseAPanel.php");
    }

}

?>
            </p>
<?php include("INC/footer.php"); ?>
