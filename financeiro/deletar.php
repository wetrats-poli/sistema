<?php
ob_start();
session_start();

// Conexão com o servidor MySQL
$con = mysqli_connect("auth-db213.hstgr.io", "u418844475_wtr", "wetrats2019", "u418844475_wtr");

$sql = 'DELETE from `financeiro` WHERE id="'.$_GET['id'].'"' ;

if ($_SESSION['NIVEL']=="3"){
    if(mysqli_query($con,$sql)){
        $_SESSION['ALERTA'] = "Cobrança excluída com sucesso.";
        header("Location: ./detalhes.php?id=".$_GET['id_devedor']); exit;
        //echo '<meta http-equiv="refresh" content="0;URL=http://www.wetrats.com.br/financeiro/detalhes.php?id='.$_GET['id_devedor'].'">';
    }
    else {
        $_SESSION['ALERTA'] = "Falha ao excluir cobrança.";
        echo '<meta http-equiv="Location" content="./detalhes.php?id='.$_GET['id_devedor'].'">';
    }
}
else{
    header("Location: ../index.php"); exit;
}  

ob_end_flush();
?>