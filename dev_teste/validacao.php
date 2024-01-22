<?php
 //Inicia uma sessão
  session_start();
    
  // Verifica se houve POST e se o usuário ou a senha é(são) vazio(s)
  if (!empty($_POST) AND (empty($_POST['email']) OR empty($_POST['senha']))) {
      header("Location: index.php"); exit;
  }

  // Conexão com o servidor MySQL
  require_once './db_con.php';
  $email = $_POST['email'];
  $senha = $_POST['senha'];

  // Validação do usuário
  $sql =  "SELECT id, nome, sexo, apelido, email, senha, nivel , perfil FROM `usuarios` WHERE email='$email' ";
  $res = mysqli_query($con, $sql);
  $achou = False ;
  

  while ($f = mysqli_fetch_array($res))
    {
        if($f['senha'] == 123456){
            $_SESSION['ID'] = $f['id'];
            $_SESSION['NOME'] = $f['nome'];
            $_SESSION['APELIDO'] = $f['apelido'];
            $_SESSION['NIVEL'] = $f['nivel'];
            $_SESSION['SEXO'] = $f['sexo'];
            $achou = True;
            
            //Redireciona o usuário
            if($f['perfil']==1){
                header("Location: ../perfil/"); exit;
            }
            else{
                $_SESSION['MSG'] = "Bem-vindo! Neste primeiro acesso, por favor complete o seu perfil!";
                header("Location: ./edicao_usuario/"); exit;
            }  
        } else if ($email ==  $f['email']) {
            $hash = $f['senha'];
            if (password_verify($senha, $hash)) {
                //Salva os dados na sessão

                $_SESSION['ID'] = $f['id'];
                $_SESSION['NOME'] = $f['nome'];
                $_SESSION['APELIDO'] = $f['apelido'];
                $_SESSION['NIVEL'] = $f['nivel'];
                $_SESSION['SEXO'] = $f['sexo'];
                $achou = True;
                
                //Redireciona o usuário
                if($f['perfil']==1){
                    header("Location: ../perfil/"); exit;
                }
                else{
                    $_SESSION['MSG'] = "Bem-vindo! Neste primeiro acesso, por favor complete o seu perfil!";
                    header("Location: ./edicao_usuario/"); exit;
                }
            }
        }
    }
    
    if (!$achou) {
    //Usuário não encontrado
    $_SESSION['ALERTA'] = "Login Inválido!"; 
    header("Location: ./index.php"); exit;
    }
?>