<?php
ob_start();

session_start();
// Conexão com o servidor MySQL
$con = mysqli_connect("auth-db213.hostinger.com.br", "u418844475_wtr", "wetrats2019", "u418844475_wtr");

$tabela = "treinos";
if($_SESSION['ID']==81){
    $tabela = "treinos_17";
}


$sql = 'DELETE from '.$tabela.' WHERE id="'.$_GET['id'].'"' ;
$sql2 = 'DELETE from presencas WHERE id_treino="'.$_GET['id'].'"';
$sql3 = 'DELETE from pse WHERE id_treino="'.$_GET['id'].'"';

if($_SESSION['ID']!=81){
    if (mysqli_query($con,$sql2)){
        if(mysqli_query($con,$sql)){
            mysqli_query($con,$sql3);
            $_SESSION['ALERTA'] = "Treino do dia:".$_GET['data']." excluído com sucesso.";
            //echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
            //echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './');});</script>";
            header("Location: ./index.php"); exit;
        }
        else {
            $_SESSION['ALERTA'] = "Falha ao excluir o treino. Contate o DM.";
            //echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
            //echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './');});</script>";
            header("Location: ./index.php"); exit;
        }    
    }
    else {
        $_SESSION['ALERTA'] = "Falha ao excluir o treino. Contate o DM.";
        //echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
        //echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './');});</script>";
        header("Location: ./index.php"); exit;
    }
}
else{
    if(mysqli_query($con,$sql)){
        $_SESSION['ALERTA'] = "Treino do dia:".$_GET['data']." excluído com sucesso.";
        //echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
        //echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './');});</script>";
        header("Location: ./index.php"); exit;
    }
    else {
        $_SESSION['ALERTA'] = "Falha ao excluir o treino. Contate o DM.";
        //echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
        //echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './');});</script>";
        header("Location: ./index.php"); exit;
    }    

}    

ob_end_flush();
?>