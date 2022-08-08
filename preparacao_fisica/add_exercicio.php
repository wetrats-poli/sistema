<?php
ob_start();

session_start();

// Conexão com o servidor MySQL
$link = mysqli_connect("auth-db213.hostinger.com.br", "u418844475_wtr", "wetrats2019", "u418844475_wtr");
if(isset($_POST['id_treino'])){
    $sql = "INSERT INTO series_academia (id_treino,ordem,exercicio,n_series,repeticoes,intensidade, intervalo) 
    VALUES (".$_POST['id_treino'].",".$_POST['ordem'].",'".$_POST['exercicio']."'
    ,".$_POST['n_series'].",'".$_POST['repeticoes']."','"
    .$_POST['intensidade']."','".$_POST['intervalo']."')";


    if(mysqli_query($link, $sql)){
        $sql2="UPDATE treinos_academia SET n_exercicios=".$_POST['ordem']." WHERE id=".$_POST['id_treino'];
        if(mysqli_query($link,$sql2)){
            $_SESSION['MSG']="<strong>".$_POST['exercicio']."</strong> incluído(a) com sucesso!";
            header("Location: ./visualizar_treino.php?id_treino=".$_POST['id_treino']); exit;
        }
        else{
            $_SESSION['ALERTA']="Falha ao adicionar exercício.";
            header("Location: ./visualizar_treino.php?id_treino=".$_POST['id_treino']); exit;
        }
    }
    else{
        $_SESSION['ALERTA']="Falha ao adicionar exercício.";
        header("Location: ./visualizar_treino.php?id_treino=".$_POST['id_treino']); exit;
    }
}

?> 