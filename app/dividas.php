<?php

  // Conexão com o servidor MySQL
  $con = mysqli_connect("auth-db213.hstgr.io", "u418844475_wtr", "wetrats2019", "u418844475_wtr");
    
  $id = $_GET['id'];
    

  // Busca no banco de dados
  $sql =  "SELECT valor, descricao, status, data_criacao, atualizacao FROM `financeiro` WHERE id_devedor='$id' ";
  $res = mysqli_query($con, $sql);
  
  $dividas=array();
  while ($f = mysqli_fetch_array($res)){
      array_push($dividas, array(
                "valor"=>$f['valor'],
                "descricao"=>$f['descricao'],
                "status"=>$f['status'],
                "data_criacao"=>$f['data_criacao'],
                "atualizacao"=>$f['atualizacao']));
                
            }

    if(sizeof($dividas)>1){                
        print(json_encode(array_reverse($dividas)));
    }
                
    else{
            print(json_encode(array("ERRO")));
        }
    
    $con->close();
    


//end

?> 