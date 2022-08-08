<?php
$link = mysqli_connect("auth-db213.hostinger.com.br", "u418844475_wtr", "wetrats2019", "u418844475_wtr");

session_start();

if($_GET['ordem']==0){
    $de_cima= $_GET['posicao']+1;
    $sql1= "UPDATE series_academia SET ordem=".$_GET['posicao']." 
            WHERE id_treino=".$_GET['id_treino']." 
            AND ordem=".$de_cima.";";
    $sql2= "UPDATE series_academia SET ordem=".$de_cima." 
            WHERE id=".$_GET['id']." ;";
    if(mysqli_query($link, $sql1)){
        echo "entrou";
        if(mysqli_query($link,$sql2)){
        header('Location: visualizar_treino.php?id_treino='.$_GET['id_treino']);
        }
        else{
            $_SESSION['ALERTA']= $sql;
            header('Location: visualizar_treino.php?id_treino='.$_GET['id_treino']);
        }
    }
    else{
        $_SESSION['ALERTA']= $sql;
        header('Location: visualizar_treino.php?id_treino='.$_GET['id_treino']);
    }
}

if($_GET['ordem']==1){
    echo "entrou";
    $de_baixo= $_GET['posicao']-1;
    $sql1= "UPDATE series_academia SET ordem=".$_GET['posicao']." 
            WHERE id_treino=".$_GET['id_treino']." 
            AND ordem=".$de_baixo.";";
    $sql2= "UPDATE series_academia SET ordem=".$de_baixo." 
            WHERE id=".$_GET['id']." ;";
    if(mysqli_query($link, $sql1)){
        if(mysqli_query($link,$sql2))
        header('Location: visualizar_treino.php?id_treino='.$_GET['id_treino']);
    }
}
if($_GET['ordem']==null){
    $id_serie=$_GET['id'];

    $sql= 'UPDATE series_academia SET 
            exercicio="'.$_POST['exercicio'].'", 
            n_series='.$_POST['n_series'].', 
            repeticoes="'.$_POST['repeticoes'].'", 
            intensidade="'.$_POST['intensidade'].'", 
            intervalo="'.$_POST['intervalo'].'",
            link="'.$_POST['link'].'"
            WHERE id='.$id_serie.';';  
    if(mysqli_query($link, $sql)){
        $_SESSION['MSG']= "Série: <strong>".$_POST['exercicio']."</strong> atualizada!";
        header('Location: visualizar_treino.php?id_treino='.$_GET['id_treino']);
    }
    else{
        $_SESSION['ALERTA']= $sql;
        header('Location: visualizar_treino.php?id_treino='.$_GET['id_treino']);
        
    }
}
    

?>