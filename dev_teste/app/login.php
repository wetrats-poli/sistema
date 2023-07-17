<?php

  // Conexão com o servidor MySQL
  $con = mysqli_connect("srv976.hstgr.io", "u418844475_wtr", "Wetrats2019", "u418844475_wtr");
    
    $email = $_GET['email'];
    $senha = $_GET['senha'];

  // Validação do usuário
  $sql =  "SELECT id, nome, sexo, apelido, email, senha, nivel , perfil, aniversario,endereco,RG, celular FROM `usuarios` WHERE email='$email' ";
  $res = mysqli_query($con, $sql);
  $achou = False ;
  while ($f = mysqli_fetch_array($res)){
        if($f['senha'] == 123456){
            $achou = True;
            $id=$f['id'];
            $nivel=$f['nivel'];
            $nome=$f['nome'];
        }
        else if ($email ==  $f['email']) {
            $hash = $f['senha'];
            if (password_verify($senha, $hash)) {
                $achou = True;
                $id=$f['id'];
                $nome=$f['nome'];
                $sexo=$f['sexo'];
                $apelido=$f['apelido'];
                $email=$f['email'];
                $senha=$f['senha'];
                $nivel=$f['nivel'];
                $aniversario=$f['aniversario'];
                $endereco=$f['endereco'];
                $RG=$f['RG'];
                $celular=$f['celular'];
                
            }
        }
    }
  
   $login=array();
    if ($achou){
        array_push($login, array("id"=>$id,"nivel"=>$nivel,"nome"=>$nome));
                    
        print(json_encode(array_reverse($login)));
    }
                
    else{
            print(json_encode(array("ERRO")));
        }
    
    $con->close();
    


//end

?>