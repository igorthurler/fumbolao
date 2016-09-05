<?php
//$con = new mysqli("localhost", "root", "root","fw_bolao")  or die (mysql_error());
try {
    $con = new PDO( 'mysql:host=localhost;dbname=fw_bolao', 'root', '' );
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
