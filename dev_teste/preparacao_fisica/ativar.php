<?php
ob_start();

// Conexão com o servidor MySQL
$con = mysqli_connect("auth-db213.hstgr.io", "u418844475_wtr", "wetrats2019", "u418844475_wtr");

$sql = 'UPDATE treinos_academia SET status=1 WHERE id='.$_GET['id'] ;


if(mysqli_query($con,$sql)){
    //echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
    //echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './');});</script>";
    header("Location: ./gerenciar_grupos.php"); exit;
}
else {
    $_SESSION['ALERTA'] = "Falha ao atualizar status.";
    //echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
    //echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './');});</script>";
    header("Location: ./gerenciar_grupos.php"); exit;
}     

ob_end_flush();
?> 