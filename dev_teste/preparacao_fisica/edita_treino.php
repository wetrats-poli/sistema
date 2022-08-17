<?php
$link = mysqli_connect("auth-db213.hstgr.io", "u418844475_wtr", "wetrats2019", "u418844475_wtr");

session_start();

    $id_treino=$_GET['id'];

    $sql= 'UPDATE treinos_academia SET 
            nome="'.$_POST['nome'].'",
            grupo="'.$_POST['grupo'].'", 
            tipo="'.$_POST['tipo'].'", 
            n_exercicios='.$_POST['n_exercicios'].', 
            periodo="'.$_POST['periodo'].'", 
            etapa="'.$_POST['etapa'].'", 
            data_inicio="'.$_POST['data_inicio'].'",
            data_termino="'.$_POST['data_termino'].'",
            legenda="'.$_POST['legenda'].'"
            WHERE id='.$id_treino.';';  
    if(mysqli_query($link, $sql)){
        $_SESSION['MSG']= "Treino atualizado!";
        header('Location: visualizar_treino.php?id_treino='.$_GET['id']);
    }
    else{
        $_SESSION['ALERTA']= $sql;
        header('Location: visualizar_treino.php?id_treino='.$_GET['id']);
        
    }

    

?>