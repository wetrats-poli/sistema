<?php

    session_start();
    
    function montaTreinos(){
        $link = mysqli_connect("auth-db213.hostinger.com.br", "u418844475_wtr", "wetrats2019", "u418844475_wtr");
        $sql = "SELECT `data`, `treino`, `id`, CASE WHEN (SELECT COUNT(*) FROM `presencas` WHERE id_treino=`id` AND id_atleta=".$_SESSION['ID'].")>0 THEN 1 ELSE 0 END AS `presenca` FROM `treinos`";
        $res = mysqli_query($link, $sql);
        $arrayRetorno = array();
        while ($vet = mysqli_fetch_array($res)) {
            $vetor=array();
            $vetor[]=$vet[1];
            $vetor[]=$vet[3];
            $arrayRetorno[$vet[0]] = $vetor;
        }
        return $arrayRetorno;
    }

    function montaComp(){
        $link = mysqli_connect("auth-db213.hostinger.com.br", "u418844475_wtr", "wetrats2019", "u418844475_wtr");
        $sql = "SELECT `data`, `evento`, `resultado` FROM `competicoes`";
        $res = mysqli_query($link, $sql);
        $arrayAux = array();
        $arrayAuxRes = array();
        $i = 0;
        while($vet = mysqli_fetch_array($res)){
            $arrayAux[$vet[0]] = $vet[1];
            if($vet[2] != null){
                $arrayAuxRes[$i] = $vet[1];
                $i++;
            }
        }
        
        return array($arrayAux, $arrayAuxRes);
    }
  
    function montaEventos(){
        $link = mysqli_connect("auth-db213.hostinger.com.br", "u418844475_wtr", "wetrats2019", "u418844475_wtr");
        $sql = "SELECT `data`, `nome`, `tipo` FROM `calendario`";
        $res = mysqli_query($link, $sql);
        $arrayRetorno = array();
        while($vet = mysqli_fetch_array($res)){
            $arrayRetorno[$vet[0]] = array($vet[2] => $vet[1]);
        }
        return $arrayRetorno;
    }

    function montaEventosPessoais($id){
        $link = mysqli_connect("auth-db213.hostinger.com.br", "u418844475_wtr", "wetrats2019", "u418844475_wtr");
        $sql = "SELECT `data`, `nome` FROM `eventos_pessoais` WHERE `id_usuario` = '$id'";
        $res = mysqli_query($link, $sql);
        $arrayRetorno = array();
        while($vet = mysqli_fetch_array($res)){
            $arrayRetorno[$vet[0]] = $vet[1];
        }
        return $arrayRetorno;
    }
?>