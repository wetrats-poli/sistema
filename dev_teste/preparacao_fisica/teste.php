<?php
    session_start();

    // $id = (int)$_SESSION['ID'];

    // $link = mysqli_connect("auth-db213.hstgr.io", "u418844475_wtr", "wetrats2019", "u418844475_wtr");

    // $pse = (int)$_POST['ses'];

    // $sql2 = 'SELECT inicio FROM treinos_em_andamento WHERE id_atleta='.$id;
    // $inicio = mysqli_fetch_assoc(mysqli_query($link, $sql2));

    // $sql3 = 'DELETE FROM treinos_em_andamento WHERE id_atleta='.$id;
    // mysqli_query($link, $sql3);

    date_default_timezone_set('America/Sao_Paulo');
    $init = new DateTime('2019-09-10 17:18:30');
    $sec = $init->diff(new DateTime('2019-09-10 18:20:10'));
    
    $min = $sec->h * 60;
    $min += $sec->i;
    echo $min;

    // $sql = 'INSERT INTO pse_academia (id_atleta, pse, duracao) VALUE ('.$id.', '.$pse.', '.$min.')';

    // mysqli_query($link, $sql);

    // $_SESSION['MSG'] = "Treino Finalizado com Sucesso!";
    // header('Location: ../perfil/');
?>