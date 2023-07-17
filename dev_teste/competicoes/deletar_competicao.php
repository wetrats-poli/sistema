<?php
ob_start();

session_start(); 
// Conexão com o servidor MySQL
$con = mysqli_connect("srv976.hstgr.io", "u418844475_wtr", "Wetrats2019", "u418844475_wtr");
$evento=str_replace("+"," ",$_GET['evento']);
$sql = 'DELETE from competicoes WHERE id="'.$_GET['id'].'"' ;
$sql2 = 'DROP TABLE `'.$evento.'`'; 

if (mysqli_query($con,$sql2)){
    if(mysqli_query($con,$sql)){
        $_SESSION['ALERTA'] = "Competição :".$evento." excluída com sucesso.";
        //echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
        //echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './');});</script>";
        header("Location: ./index.php"); exit;
    }
    else {
        $_SESSION['ALERTA'] = "Falha ao excluir a competição:".mysqli_error($con);
       //echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
        //echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './');});</script>";
        header("Location: ./index.php"); exit;
    }    
}
else {
    $_SESSION['ALERTA'] = "Falha ao excluir a competição:".mysqli_error($con);
    //echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
    //echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './');});</script>";
    header("Location: ./index.php"); exit;
}    

ob_end_flush();
?>