<?php
ob_start();

session_start();

// Conexão com o servidor MySQL
$con = mysqli_connect("auth-db213.hostinger.com.br", "u418844475_wtr", "wetrats2019", "u418844475_wtr");

$sql = 'UPDATE `financeiro` SET status="P" WHERE id_devedor='.$_GET['id'] ;

if ($_SESSION['NIVEL']=="3"){
    if(mysqli_query($con,$sql)){
        $_SESSION['MSG'] = "Dívidas zeradas!";
        //echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
        //echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './detalhes.php?id='".$_GET["id_devedor"]."');});</script>";
        header("Location: ./detalhes.php?id=".$_GET['id']); exit;
    }
    else {
        $_SESSION['ALERTA'] = "Falha ao atualizar status.";
        //echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
        //echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './detalhes.php?id='".$_GET["id_devedor"]."');});</script>";
        header("Location: ./detalhes.php?id=".$_GET['id']); exit;
    }
}
else{
    //echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
    //echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', '../');});</script>";
    header("Location: ../index.php"); exit;
}  

ob_end_flush();
?> 