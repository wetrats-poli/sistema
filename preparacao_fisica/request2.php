<?php
    session_start();

    $link = mysqli_connect("auth-db213.hstgr.io", "u418844475_wtr", "Wetrats2019", "u418844475_wtr");

    $sql1 = "SET time_zone = 'America/Sao_Paulo'";
    mysqli_query($link, $sql1);
    
    $id=$_SESSION['ID'];

    date_default_timezone_set('America/Sao_Paulo');
    $hoje=new DateTime();
    $init = $hoje->format('Y-m-d H:i:s');

    $sql = "INSERT INTO treinos_em_andamento (id_atleta, inicio) VALUE (".$id.",'".$init."')";

    mysqli_query($link, $sql);
?>    