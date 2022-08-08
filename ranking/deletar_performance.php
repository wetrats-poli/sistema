<?php
ob_start();

session_start();

// Conexão com o servidor MySQL
$con = mysqli_connect("auth-db213.hostinger.com.br", "u418844475_wtr", "wetrats2019", "u418844475_wtr");

$sql = 'DELETE FROM `ranking` WHERE id="'.$_GET['id'].'"' ;

if(mysqli_query($con,$sql)){
    $_SESSION['ALERTA'] = "Resultado do atleta:".str_replace("_"," ",$_GET['atleta'])." excluído com sucesso.";
    //echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
    //echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './gerenciar_ranking.php');});</script>";
    header("Location: ./gerenciar_ranking.php"); exit;
}

else {
    $_SESSION['ALERTA'] = "Falha ao excluir resultado. Acesse o banco de dados.";
    //echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
    //echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './gerenciar_ranking.php');});</script>";
    header("Location: ./gerenciar_ranking.php"); exit;
}    

ob_end_flush();
?>