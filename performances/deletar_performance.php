<?php
ob_start();
 
session_start();

// Conexão com o servidor MySQL
$con = mysqli_connect("auth-db213.hstgr.io", "u418844475_wtr", "Wetrats2019", "u418844475_wtr");

$sql = 'DELETE from resultados_'.$_GET['link'].' WHERE id="'.$_GET['id'].'"' ;

if(mysqli_query($con,$sql)){
    $_SESSION['ALERTA'] = "Performance do dia:".$_GET['data']." excluída com sucesso.";
    //echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
    //echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './gerenciar_performances.php');});</script>";
    header("Location: ./gerenciar_performances.php"); exit;
}

else {
    $_SESSION['ALERTA'] = "Falha ao excluir a performance. Contate o DM.";
    //echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
    //echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './grenciar_performances.php');});</script>";
    header("Location: ./gerenciar_performances.php"); exit;
}    

ob_end_flush();
?>