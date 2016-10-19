<?php
//$con = new mysqli("localhost", "fumbleca_adm", "fumblecaadm001","fumbleca_fw_bolao")  or die (mysql_error());
try {
    $con = new PDO( 'mysql:host=localhost;dbname=fumbleca_fw_bolao', 'fumbleca_adm', 'fumblecaadm001' );
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}