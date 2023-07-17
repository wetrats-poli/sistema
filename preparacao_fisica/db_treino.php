<?php
    session_start();

    $id = (int)$_SESSION['ID'];

    $link = mysqli_connect("srv976.hstgr.io", "u418844475_wtr", "Wetrats2019", "u418844475_wtr");


    $pse = (int)$_POST['ses'];
    $min = (int)$_POST['time'];

    $sql = 'INSERT INTO pse_academia (id_atleta, pse, duracao) VALUE ('.$id.', '.$pse.', '.$min.')';

    mysqli_query($link, $sql);

    $_SESSION['MSG'] = "Treino Finalizado com Sucesso!";
    //header('Location: ../perfil/');
    
    
?>