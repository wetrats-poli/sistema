<?php
ob_start();

session_start();

// Conexão com o servidor MySQL
$con = mysqli_connect("srv976.hstgr.io", "u418844475_wtr", "Wetrats2019", "u418844475_wtr");

$sql = 'UPDATE `financeiro` SET status="NP" WHERE id='.$_GET['id'] ;

if ($_SESSION['NIVEL']=="3"){
    if(mysqli_query($con,$sql)){
        //echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
        //echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './detalhes.php?id='".$_GET["id_devedor"]."');});</script>";
        header("Location: ./detalhes.php?id=".$_GET['id_devedor']); exit;
    }
    else {
        $_SESSION['ALERTA'] = "Falha ao atualizar status.";
        //echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
        //echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './detalhes.php?id='".$_GET["id_devedor"]."');});</script>";
        header("Location: ./detalhes.php?id=".$_GET['id_devedor']); exit;
    }
}
else{
    //echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
    //echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', '../');});</script>";
    header("Location: ../index.php"); exit;
}  

ob_end_flush();
?> 