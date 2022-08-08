<?php
ob_start();
session_start();

// Conexão com o servidor MySQL
$con = mysqli_connect("auth-db213.hostinger.com.br", "u418844475_wtr", "wetrats2019", "u418844475_wtr");

$sql = 'DELETE from `treinos_academia` WHERE id="'.$_GET['id'].'"' ;
$sql2= 'DELETE from `series_academia` WHERE id_treino="'.$_GET['id'].'"';
if ($_SESSION['NIVEL']=="2"){
    if(mysqli_query($con,$sql)){
        mysqli_query($con,$sql2);
        $_SESSION['ALERTA'] = "Treino excluído com sucesso.";
        header("Location: ./gerenciar_grupos.php"); exit;
        //echo '<meta http-equiv="refresh" content="0;URL=http://www.wetrats.com.br/financeiro/detalhes.php?id='.$_GET['id_devedor'].'">';
    }
    else {
        $_SESSION['ALERTA'] = "Falha ao excluir treino.";
        header("Location: ./gerenciar_grupos.php"); exit;
    }
}
else{
    header("Location: ../index.php"); exit;
}  

ob_end_flush();
?>