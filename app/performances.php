<?php

    // Conexão com o servidor MySQL
    $con = mysqli_connect("srv976.hstgr.io", "u418844475_wtr", "Wetrats2019", "u418844475_wtr");
    
    $id = $_GET['id'];
    $nome_atleta= $_GET['nome'];
    $tipo= $_GET['tipo'];
    $estilo= $_GET['estilo'];
    $metragem = $_GET['metragem'];
    $prova = strval($metragem)." ".$estilo;

    if($tipo=="Tiro"){
    $provasof=array();
    $provasx=array();
    $sql =  "SELECT  treinos.data AS 'data' , tempo, 'Treino' AS competicao , 'Outros' AS 'categoria' FROM resultados_treinos
                INNER JOIN `treinos` ON resultados_treinos.id_treino= treinos.id  
                WHERE resultados_treinos.tipo='Tiro' AND id_atleta=".$id." AND estilo="."'".$estilo."' AND metragem='".$metragem."' 
                UNION ALL 
                SELECT data , tempo, competicao, 'Oficial' AS 'categoria' FROM `ranking` 
                WHERE nome_atleta ='".$nome_atleta."' AND prova='".$prova."'
                UNION ALL
                SELECT data , tempo, evento AS 'competicao' , 'Outros' AS 'categoria' FROM `resultados_pessoais` 
                WHERE id_atleta=".$id ." AND estilo="."'".$estilo."' AND metragem=".$metragem." 
                ORDER BY `data` ASC ;" ;
        
        $resultado = mysqli_query($con, $sql);
        
        $i=0;
        $datas= array();
        $tempos= array();
        $eventos= array();
        $categoria= array();
        while ($res = mysqli_fetch_assoc($resultado)){
            $datas[$i] = $res['data'];
            $tempo = 0.0 ;
            $tmp=str_replace("..",'"',$res['tempo']);
            $tmp=str_replace(".","'",$tmp);
            $eventos[$i]= $res['competicao']." - ".$tmp;
            if (substr_count($tmp , "'")>0){
                $minutos = explode("'",$tmp);
                $tempo += (60 * floatval($minutos[0]));
                $resto = str_replace('"','.',$minutos[1]);
                $tempo += floatval($resto);
            }
            else {
                $resto = str_replace('"','.',$tmp);
                $tempo += floatval($resto);
            }
            $tempos[$i] = $tempo;

            if ($res['categoria'] =='Outros'){
                $categoria[$i]= '1';
                array_push($provasx, [$res['data'],$tempo,$res['competicao']]);
            }
            else{ 
                $categoria[$i]= 'null';
                array_push($provasof, [$res['data'],$tempo,$res['competicao']]);
            }
            $i+=1;
        }
                
    $provas=[$provasof,$provasx] ;        
    }
        if(sizeof($provasof)>=1 | sizeof($provas)>=1){                
        print(json_encode(array_reverse($provas)));
    }
                
    else{
            print(json_encode(array("ERRO")));
        }
    
    $con->close();
?>