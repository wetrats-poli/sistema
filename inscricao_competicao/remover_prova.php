<?php
ob_start();
session_start();

if(($_SESSION['ID'] == $_GET['atleta_id'])or($_SESSION['NIVEL']=="3")){
    // Conexão com o servidor MySQL
    $con = mysqli_connect("auth-db213.hstgr.io", "u418844475_wtr", "wetrats2019", "u418844475_wtr");

    $sql = "UPDATE "."`".$_GET['competicao'].'` SET '.$_GET['prova'].'= NULL WHERE `atleta_id`='.$_GET['atleta_id'];

    $prova=str_replace("_"," ",$_GET['prova']);
    if(mysqli_query($con,$sql)){
        $_SESSION['ALERTA'] = "Prova:$prova excluída com sucesso."; 
        //echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
        //echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './index.php?competicao=".$_GET['competicao']."');});</script>";
        header("Location: ./index.php?competicao=".$_GET['competicao']); exit;
    }
    else {
        $_SESSION['ALERTA'] = "Falha ao excluir a prova. Contate o DM.";
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

ob_end_flush();
?> 