<?php

    session_start();
    require_once '../db_con.php';
    
    function montaTreinos(){
        $sql = "SELECT `data`, `treino`, `id`, CASE WHEN (SELECT COUNT(*) FROM `presencas` WHERE id_treino=`id` AND id_atleta=".$_SESSION['ID'].")>0 THEN 1 ELSE 0 END AS `presenca` FROM `treinos`";
        $res = mysqli_query($con, $sql);
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
        $sql = "SELECT `data`, `evento`, `resultado` FROM `competicoes`";
        $res = mysqli_query($con, $sql);
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
        $sql = "SELECT `data`, `nome`, `tipo` FROM `calendario`";
        $res = mysqli_query($con, $sql);
        $arrayRetorno = array();
        while($vet = mysqli_fetch_array($res)){
            $arrayRetorno[$vet[0]] = array($vet[2] => $vet[1]);
        }
        return $arrayRetorno;
    }

    function montaEventosPessoais($id){
        $sql = "SELECT `data`, `nome` FROM `eventos_pessoais` WHERE `id_usuario` = '$id'";
        $res = mysqli_query($con, $sql);
        $arrayRetorno = array();
        while($vet = mysqli_fetch_array($res)){
            $arrayRetorno[$vet[0]] = $vet[1];
        }
        return $arrayRetorno;
    }
?>