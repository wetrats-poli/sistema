<?php
ob_start();

// Conexão com o servidor MySQL
$con = mysqli_connect("srv976.hstgr.io", "u418844475_wtr", "Wetrats2019", "u418844475_wtr");

$sql = 'DELETE FROM `projetoiusp` WHERE `id`='.$_GET['id'].';';

if(mysqli_query($con,$sql)){
    $_SESSION['ALERTA'] = "Ponto excluído com sucesso.";
    //echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
    //echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './');});</script>";
    header("Location: ./index.php?id=".$_GET['id_atleta']); exit;
}
else {
    $_SESSION['ALERTA'] = "Falha ao excluir ponto.";
    //echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
    //echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './');});</script>";
    header("Location: ./index.php?id=".$_GET['id_atleta']); exit;
} 

ob_end_flush();
?> 