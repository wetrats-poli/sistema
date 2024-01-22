<?php
ob_start();

// Conexão com o servidor MySQL
require_once '../db_con.php';
$sql_series= "SELECT * FROM series_academia WHERE id_treino=".$_POST['id'];
$query= mysqli_query($con,$sql_series);
$n_series = mysqli_num_rows($query);

$sql_treino = "INSERT INTO treinos_academia(nome,grupo,n_exercicios) VALUES ('Nova Cópia', "."'".$_POST['grupo']."'".",".$n_series.")";
if(mysqli_query($con,$sql_treino)){
    $sql_idtreino="SELECT id FROM treinos_academia ORDER BY id DESC LIMIT 1";
    $id=mysqli_fetch_assoc(mysqli_query($con,$sql_idtreino))['id'];
    echo $id;
    $sql_series="INSERT INTO series_academia (id_treino, ordem, exercicio,n_series,repeticoes,intensidade,intervalo,link) 
                    SELECT "."'".$id."'".", ordem, exercicio,n_series,repeticoes,intensidade,intervalo,link FROM series_academia WHERE id_treino=".$_POST['id'];
                    echo $sql_series;
    if(mysqli_query($con,$sql_series)){
        header("Location: ./gerenciar_grupos.php"); exit;
    }
    header("Location: ./gerenciar_grupos.php"); exit;
}

ob_end_flush();
?> 