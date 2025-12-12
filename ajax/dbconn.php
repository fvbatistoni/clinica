<?php
if(is_file('../ee-config.php')==true){
    include '../ee-config.php';
} else {
    include '../../ee-config.php';
}

$username  = DB_USER;
$password  = DB_PASSWORD;
$result = 0;
try {
    $dbconn = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.'', $username, $password);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
