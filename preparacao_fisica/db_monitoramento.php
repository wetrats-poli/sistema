<?php
    include 'prog_semanas.php';

    session_start();

    date_default_timezone_set('America/Sao_Paulo');
    $hoje=date("Y-m-d");

    if(date('l', strtotime($hoje)) == "Monday"){
        $dia_semana = 1;
    }elseif (date('l', strtotime($hoje)) == "Tuesday") {
        $dia_semana = 2;
    }elseif (date('l', strtotime($hoje)) == "Wednesday") {
        $dia_semana = 3;
    }elseif (date('l', strtotime($hoje)) == "Thursday") {
        $dia_semana = 4;
    }elseif (date('l', strtotime($hoje)) == "Friday") {
        $dia_semana = 5;
    }elseif (date('l', strtotime($hoje)) == "Saturday") {
        $dia_semana = 6;
    }elseif (date('l', strtotime($hoje)) == "Sunday") {
        $dia_semana = 7;
    }

    $semana = acha_semana($hoje);


    $link = mysqli_connect("auth-db213.hstgr.io", "u418844475_wtr", "wetrats2019", "u418844475_wtr");

    $tqr = $_POST['tqr'];
    $fdg = $_POST['fdg'];
    $qls = $_POST['qls'];
    $dmg = $_POST['dmg'];
    $etr = $_POST['etr'];
    $hmr = $_POST['hmr'];

    $sql = "INSERT INTO monitoramentos_academia (tqr, fdg, qls, dmg, etr, hmr, semana, dia_semana, id_atleta) VALUE ($tqr, $fdg, $qls, $dmg, $etr, $hmr, $semana, $dia_semana, ".$_SESSION['ID'].")";

    mysqli_query($link, $sql);
    
    $_SESSION['MSG'] = 'Monitoramento Psicométrico Respondido com Sucesso!';
    header('Location: ../perfil/');




?>