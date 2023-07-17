<?php

$dns ="mysql:host=localhost;dbname=u418844475_wtr";
$user = 'u418844475_wtr';
$password = 'Wetrats2019';

try{
    $db = new PDO ($dns, $user, $password);
    echo 'connected';
}catch( PDOException $e){
    $error = $e->getMessage();
    echo $error;
}

?>