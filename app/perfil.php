<?php

  // Conexão com o servidor MySQL
  $con = mysqli_connect("srv976.hstgr.io", "u418844475_wtr", "Wetrats2019", "u418844475_wtr");
    
    $id = $_GET['id'];
    

  // Validação do usuário
  $sql =  "SELECT id, nome, sexo, apelido, email, senha, nivel , perfil, aniversario,endereco,RG, celular,foto FROM `usuarios` WHERE id='$id' ";
  $res = mysqli_query($con, $sql);
  $achou= False;
  
  while ($f = mysqli_fetch_array($res)){
                $achou = True;
                $nome=$f['nome'];
                $sexo=$f['sexo'];
                $apelido=$f['apelido'];
                $email=$f['email'];
                $senha=$f['senha'];
                $aniversario=$f['aniversario'];
                $endereco=$f['endereco'];
                $RG=$f['RG'];
                $celular=$f['celular'];
                $foto=$f['foto'];
                
            }
  
   $login=array();
    if ($achou){
        array_push($login, array("nome"=>$nome,
        "sexo"=>$sexo,"apelido"=>$apelido,
        "email"=>$email,"senha"=>$senha, "aniversario"=>$aniversario, "endereco"=>$endereco, "RG"=>$RG, "celular"=>$celular, "foto"=>$foto ));
                    
        print(json_encode(array_reverse($login)));
    }
                
    else{
            print(json_encode(array("ERRO")));
        }
    
    $con->close();
    


//end

?> 
 