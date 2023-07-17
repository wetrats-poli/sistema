<?php
    session_start();

    $link = mysqli_connect("srv976.hstgr.io", "u418844475_wtr", "Wetrats2019", "u418844475_wtr");

    $id = $_SESSION['ID'];

    $sql = "INSERT INTO cargas_academia (id_serie, id_atleta, `1`, `2`, `3`, `4`, `5`, `6`, `7`, `8`) VALUES ";
    
    $n_ex = (int)$_POST['n_ex'];
    echo $n_ex;
    for($i=1; $i<=$n_ex; $i++){
        $serie = (int)$_POST['id'.$i];
        $sql .= "(";
        $sql .= $serie;
        $sql .= ", ";
        $sql .= $id;
        $n_sr = (int)$_POST['n_sr'.$i];
        for($j=1; $j<=8; $j++){
            if(isset($_POST['crg_'.$i.'_'.$j])) {$carga = "'".$_POST['crg_'.$i.'_'.$j]."'";}
            else {$carga = 'NULL';}
            $sql .= ", ";
            $sql .= $carga;
        }
        if($i != $n_ex){
            $sql .= "), ";
        } else {
            $sql .= ")";
        }
    }
    echo $sql;


    $pse = (int)$_POST['ses'];
    $min = (int)$_POST['time'];

    $carga_interna = $pse*$min;

    include 'prog_semanas.php';
    date_default_timezone_set('America/Sao_Paulo');
    $hoje=date("Y-m-d");
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

    $sql2 = "INSERT INTO pse_academia (id_atleta, pse, duracao, carga_interna, dia_semana, semana) VALUE ($id, $pse, $min, $carga_interna, $dia_semana, $semana)";

    if(!mysqli_query($link, $sql)){
        $_SESSION['ALERTA'] = "Erro ao enviar treino! Por favor, verifique sua conexão e envie novamente.";
    }
    else{
        mysqli_query($link, $sql2);
        $_SESSION['MSG'] = "Treino Finalizado com Sucesso!";
    }

    header('Location: ../perfil/');
    
?>