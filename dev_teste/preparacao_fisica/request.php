<?php
    session_start();

    $link = mysqli_connect("auth-db213.hstgr.io", "u418844475_wtr", "wetrats2019", "u418844475_wtr");

    $id = $_SESSION['ID'];
    
    if(isset($_GET['c1'])){
        $c1=$_GET['c1'];
    }
    if(isset($_GET['c2'])){
        $c2=$_GET['c2'];
    }
    if(isset($_GET['c3'])){
        $c3=$_GET['c3'];
    }
    if(isset($_GET['c4'])){
        $c4=$_GET['c4'];
    }
    if(isset($_GET['c5'])){
        $c5=$_GET['c5'];
    }
    if(isset($_GET['c6'])){
        $c6=$_GET['c6'];
    }
    if(isset($_GET['c7'])){
        $c7=$_GET['c7'];
    }
    if(isset($_GET['c8'])){
        $c8=$_GET['c8'];
    }

    $serie=(int)$_GET['id_serie'];
    
    $sql = "INSERT INTO cargas_academia (id_serie, id_atleta, `1`, `2`, `3`, `4`, `5`, `6`, `7`, `8`) VALUE ($serie, $id, '$c1', '$c2', '$c3', '$c4', '$c5', '$c6', '$c7', '$c8')";
    
    mysqli_query($link, $sql);




?>