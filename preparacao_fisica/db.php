<?php

    $link = mysqli_connect("auth-db213.hstgr.io", "u418844475_wtr", "Wetrats2019", "u418844475_wtr");
    
    $nome = $_POST['nome'];
    $ids = $_POST['atl'];
    foreach ($ids as $id_atleta) {
        $sql = "INSERT INTO grupos_preparacao (nome, id_atleta) VALUES ('$nome', $id_atleta)";
        mysqli_query($link, $sql);
    }   

    header('Location: gerenciar_grupos.php');

?>