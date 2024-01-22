<?php
ob_start();

// Conexão com o servidor MySQL
require_once '../db_con.php';

$sql = 'DELETE FROM `presencas` WHERE `id_treino`='.$_GET['treino'].' AND `id_atleta`='.$_GET['atleta'].';';

if(mysqli_query($con,$sql)){
    $_SESSION['ALERTA'] = "Presença excluída com sucesso.";
    //echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
    //echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './');});</script>";
    header("Location: ./index.php"); exit;
}
else {
    $_SESSION['ALERTA'] = "Falha ao excluir a presença. Contate o DM.";
    //echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
    //echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './');});</script>";
    header("Location: ./index.php"); exit;
} 

ob_end_flush();
?> 