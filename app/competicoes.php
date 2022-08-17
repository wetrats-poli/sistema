<?php

  // Conexão com o servidor MySQL
  $con = mysqli_connect("auth-db213.hstgr.io", "u418844475_wtr", "wetrats2019", "u418844475_wtr");
    
    

  // Busca no banco de dados
  $sql =  "SELECT evento, data, local,resultado, ativo FROM `competicoes` ORDER BY data DESC";
  $res = mysqli_query($con, $sql);
  
  $futuras=array();
  $passadas=array();
  while ($f = mysqli_fetch_array($res)){
      if($f['ativo']=='1'){
        array_push($futuras, array(
                "evento"=>$f['evento'],
                "data"=>$f['data'],
                "local"=>$f['local'],
                "ativo"=>$f['ativo'],
                "resultado"=>$f['resultado']));
                        
            }
      else array_push($passadas,array(
                "evento"=>$f['evento'],
                "data"=>$f['data'],
                "local"=>$f['local'],
                "ativo"=>$f['ativo'],
                "resultado"=>$f['resultado']));
    }
    
    if(sizeof($passadas)>1){                
        print(json_encode(array($futuras,$passadas)));
    }
                
    else{
            print(json_encode(array("ERRO")));
        }
    
    $con->close();
    


//end

?> 