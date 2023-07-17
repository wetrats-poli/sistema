<?php
ob_start();

session_start();

// Conexão com o servidor MySQL
$link = mysqli_connect("srv976.hstgr.io", "u418844475_wtr", "Wetrats2019", "u418844475_wtr");

if(isset($_GET['id'])){
    $sql = "DELETE FROM grupos_preparacao WHERE id_atleta=".$_GET['id'];
    $_SESSION['MSG'] = "Remoção Efetuada com Sucesso.";
} elseif (isset($_GET['nome'])){
    $sql = 'DELETE FROM grupos_preparacao WHERE nome="'.$_GET['nome'].'"';
    $_SESSION['MSG'] = "Grupo Removido com Sucesso.";
}
mysqli_query($link, $sql);

header("Location: ./gerenciar_grupos.php"); exit;

?> 