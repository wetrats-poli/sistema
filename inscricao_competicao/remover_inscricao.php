<?php
ob_start();

session_start();
if($_SESSION['ID'] == $_GET['atleta_id']){
    // Conexão com o servidor MySQL
    require_once '../db_con.php';

    $sql = "DELETE FROM "."`".$_GET['competicao'].'` WHERE `atleta_id`='.$_GET['atleta_id'];

    if(mysqli_query($con,$sql)){
        $_SESSION['ALERTA'] = "Inscrição excluída com sucesso."; 
        //echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
        //echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './index.php?competicao=".$_GET['competicao']."');});</script>";
        header("Location: ./index.php?competicao=".$_GET['competicao']); exit;
    }
    else {
        $_SESSION['ALERTA'] = "Falha ao excluir inscrição. Contate o DM.";
        //echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
        //echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './index.php?competicao=".$_GET['competicao']."');});</script>";
        header("Location: ./index.php?competicao=".$_GET['competicao']); exit; 
    } 
}

else{
    $_SESSION['ALERTA'] = "Operação não permitida!";
    //echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
    //echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './index.php?competicao=".$_GET['competicao']."');});</script>";
    header("Location: ./index.php?competicao=".$_GET['competicao']); exit; 
} 
?> 