<?php
ob_start();

// Conexão com o servidor MySQL
require_once '../db_con.php';

$sql = 'UPDATE usuarios SET ativo=1 WHERE id='.$_GET['id'] ;


if(mysqli_query($con,$sql)){
    //echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
    //echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './');});</script>";
    header("Location: ./index.php"); exit;
}
else {
    $_SESSION['ALERTA'] = "Falha ao atualizar status.";
    //echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
    //echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './');});</script>";
    header("Location: ./index.php"); exit;
}     

ob_end_flush();
?> 