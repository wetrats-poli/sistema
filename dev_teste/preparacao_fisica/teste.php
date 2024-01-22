<?php
    session_start();

    // $id = (int)$_SESSION['ID'];

    // require_once '../db_con.php';

    // $pse = (int)$_POST['ses'];

    // $sql2 = 'SELECT inicio FROM treinos_em_andamento WHERE id_atleta='.$id;
    // $inicio = mysqli_fetch_assoc(mysqli_query($con, $sql2));

    // $sql3 = 'DELETE FROM treinos_em_andamento WHERE id_atleta='.$id;
    // mysqli_query($con, $sql3);

    date_default_timezone_set('America/Sao_Paulo');
    $init = new DateTime('2019-09-10 17:18:30');
    $sec = $init->diff(new DateTime('2019-09-10 18:20:10'));
    
    $min = $sec->h * 60;
    $min += $sec->i;
    echo $min;

    // $sql = 'INSERT INTO pse_academia (id_atleta, pse, duracao) VALUE ('.$id.', '.$pse.', '.$min.')';

    // mysqli_query($con, $sql);

    // $_SESSION['MSG'] = "Treino Finalizado com Sucesso!";
    // header('Location: ../perfil/');
?>