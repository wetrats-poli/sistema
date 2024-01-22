<?php
ob_start();

session_start();

// Conexão com o servidor MySQL
require_once '../db_con.php';

if(isset($_GET['id'])){
    $sql = "DELETE FROM grupos_preparacao WHERE id_atleta=".$_GET['id'];
    $_SESSION['MSG'] = "Remoção Efetuada com Sucesso.";
} elseif (isset($_GET['nome'])){
    $sql = 'DELETE FROM grupos_preparacao WHERE nome="'.$_GET['nome'].'"';
    $_SESSION['MSG'] = "Grupo Removido com Sucesso.";
}
mysqli_query($con, $sql);

header("Location: ./gerenciar_grupos.php"); exit;

?> 