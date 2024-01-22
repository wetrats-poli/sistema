<?php 

    date_default_timezone_set('America/Sao_Paulo');
    $hoje=date("Y-m-d");

    include '../preparacao_fisica/prog_semanas.php';
    $semana = acha_semana($hoje);

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


    require_once '../db_con.php';
    
    $sql = "SELECT id FROM treinos WHERE data='".$hoje."'";
    $id_treino = mysqli_fetch_assoc(mysqli_query($con, $sql));

    $ses = (int)$_GET['ses'];
    $descs = (int)$_GET['descs'];

    if($descs != 0){
        $ratio = $ses / $descs;
    }
    else{
        $ratio = 0;
    }

    $sql2 = "INSERT INTO pse_nova (id_atleta, id_treino, ses, descs, ratio, dia_semana, semana) VALUES (".$_GET['ID'].", ".$id_treino['id'].", ".$ses.", ".$descs.", ".$ratio.", ".$dia_semana.", ".$semana.")";
    if(mysqli_query($con, $sql2)) print(json_encode(array("OK")));

    
?>