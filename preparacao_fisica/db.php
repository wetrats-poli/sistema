<?php

    require_once '../db_con.php';
    
    $nome = $_POST['nome'];
    $ids = $_POST['atl'];
    foreach ($ids as $id_atleta) {
        $sql = "INSERT INTO grupos_preparacao (nome, id_atleta) VALUES ('$nome', $id_atleta)";
        mysqli_query($con, $sql);
    }   

    header('Location: gerenciar_grupos.php');

?>