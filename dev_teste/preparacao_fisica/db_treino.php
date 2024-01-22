<?php
    session_start();

    $id = (int)$_SESSION['ID'];

    require_once '../db_con.php';


    $pse = (int)$_POST['ses'];
    $min = (int)$_POST['time'];

    $sql = 'INSERT INTO pse_academia (id_atleta, pse, duracao) VALUE ('.$id.', '.$pse.', '.$min.')';

    mysqli_query($con, $sql);

    $_SESSION['MSG'] = "Treino Finalizado com Sucesso!";
    //header('Location: ../perfil/');
    
    
?>