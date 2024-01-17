<?php
    session_start();

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


    $link = mysqli_connect("srv976.hstgr.io", "u418844475_wtr", "Wetrats2019", "u418844475_wtr");
    
    $sql = "SELECT id FROM treinos WHERE data='".$hoje."'";
    $id_treino = mysqli_fetch_assoc(mysqli_query($link, $sql));

    $ses = (int)$_POST['ses'];
    $descs = (int)$_POST['descs'];

    if($descs != 0){
        $ratio = $ses / $descs;
    }
    else{
        $ratio = 0;
    }

    $sql2 = "INSERT INTO pse_2024 (id_atleta, id_treino, ses, descs, ratio, dia_semana, semana) VALUES (".$_SESSION['ID'].", ".$id_treino['id'].", ".$ses.", ".$descs.", ".$ratio.", ".$dia_semana.", ".$semana.")";
    if(!mysqli_query($link, $sql2)){
        $_SESSION['ALERTA'] = "Erro ao enviar PSE! Por favor, verifique sua conexão e envie novamente.";
    }
    else{
        $_SESSION['MSG'] = "PSE Respondida com Sucesso!";
    }

    
    header('Location: ../perfil/');

?>