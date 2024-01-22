<html lang="pt-BR">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
    <link rel="stylesheet" href="../common/stylesheets/bootstrap.css">
    <link rel="stylesheet" href="../common/stylesheets/bootstrap4.css">
    <link rel="stylesheet" href="../common/stylesheets/animate.css">
    <link rel="stylesheet" href="../common/stylesheets/style.css">
    <link rel="stylesheet" href="../common/stylesheets/style1.css">
    <link rel="icon" type="image/png" href="../common/images/favicon-32x32.png" sizes="32x32" />
    <title>Wetrats - Editar Perfil</title>
</head>
<?php
  session_start();
    
   // Verifica se existe ID da sessão
   if(!isset($_SESSION['ID'])){

    //Destrói a sessão por segurança
    session_destroy();

    //Redireciona para o login
    header("Location: ../index.php"); exit;
  }
  
  $id_usuario = $_SESSION['ID'];
  $nivel_usuario = $_SESSION['NIVEL'];

  if(($nivel_usuario=="3")&(strlen($_GET['id']>0))){
    $id_usuario = $_GET['id'];
    $post="index.php?id=".$id_usuario;
  }
  else $post="index.php";
  
  // Conexão com o servidor MySQL
  require_once '../db_con.php';

  // Busca das informações referentes ao usuário que será editado
  $sql =  "SELECT id, nome, sexo, apelido, aniversario, email, celular, RG, NUSP, endereco, foto, nivel, ativo FROM usuarios WHERE id = $id_usuario ";
  $perfil = mysqli_query($con, $sql);
  
  while ($p = mysqli_fetch_array($perfil)){
    $nome = $p['nome'];
    $sexo = $p['sexo'];
    $apelido =$p['apelido'];
    $aniversario= $p['aniversario'];
    $email = $p['email'];
    $celular = $p['celular'];
    $RG= $p['RG'];
    $NUSP = $p['NUSP'];
    $endereco = $p['endereco'];
    $nivel = $p['nivel'];
    $id = $p['id'];
    $foto = $p['foto'];
    $ativo = $p['ativo'];
    

  }

?>  


<body>
<div id="page">
  <nav class="fh5co-nav" id="menu-list" role="navigation">
      <div id="menu"></div>
  </nav>
  <div id="menus"></div>

  <div class="container-fluid" style="padding-top:60px;">
    <div class="row">
      <form method="post" action=<?php echo $post ?> enctype="multipart/form-data" class="col-md-12">
      
      <?php
      

      //Mensagem de alerta
      if (isset($_SESSION['ALERTA'])){
        echo '<div class="alert alert-danger" role="alert">'.$_SESSION['ALERTA'].'</div>';
        unset($_SESSION['ALERTA']);
      }
      //Mensagens de sucesso
      if (isset($_SESSION['MSG'])){
        echo '<div class="alert alert-success" role="alert">'.$_SESSION['MSG'].'</div>';
        unset($_SESSION['MSG']);
      }
    ?> 
        
        <h1>Edição de usuário</h1>
        <p>Altere os campos abaixo que desejar para editar seu perfil.</p>
        <hr>
        <div class="container_form_perfil">
         <div class="row form-group">
          <div class="col-md-6">
            <label for="foto"><b>Foto de perfil:</b></label>
            <input class="form-control" type="file" placeholder="Selecione uma foto" name="foto"  accept="image/*" >
          </div>
        </div> 

        <div class="row form-group">
          <div class="col-md-6">
            <label for="Nome"><b>Nome Completo</b></label>
            <input class="form-control" type="text" placeholder="Digite seu nome e sobrenome..." name="nome" value = "<?php echo $nome ?>" ; required>
          </div>

          <?php
            if($_SESSION['NIVEL'] != 2){
              echo '<div class="col-md-3">
                <label for="apelido"><b>Apelido</b></label>
                <input class="form-control" type="text" placeholder="Digite o nome como deseja ser visto..." name="apelido" value ="'.$apelido.'" required>
              </div>';
            }
          ?>
          
          <div class="col-md-3">
            <label for="Data de Nascimento"><b>Data de Nascimento</b></label>
            <input class="form-control" type="date" name="aniversario" placeholder="DD/MM/AAAA" value = "<?php echo $aniversario ?>" required>
          </div>
        </div>

        <div class="row form-group">
          <div class="col-md-6">
            <label for="email"><b>Email</b></label>
            <input class="form-control" type="text" placeholder="Digite seu Email..." name="email" value = "<?php echo $email ?>" required>
          </div>
    
          <div class="col-md-6">
            <label for="celular"><b>Celular</b></label>
            <input class="form-control" type="text" placeholder="Digite seu número de celular..." name="celular" value = "<?php echo $celular ?>" required>
          </div>
        </div>

        <div class="row form-group">
          <div class="col-md-6">
            <label for="RG"><b>RG</b></label>
            <input class="form-control" type="text" placeholder="Digite seu RG..." name="RG" value = "<?php echo $RG ?>" required>
          </div>
          <?php
            if ($_SESSION['NIVEL'] != 2){
              echo '<div class="col-md-6">
                      <label for="Número USP"><b>Número USP</b></label>
                      <input class="form-control" type="text" placeholder="Digite seu Número USP..." name="NUSP" value = "'.$NUSP.'" required>
                    </div>
                  </div>
        
                  <div class="row form-group">
                    <div class="col-md-6">
                      <label for="Endereço"><b>Endereço</b></label>
                      <input class="form-control" type="text" placeholder="Digite seu endereço..." name="endereco" value ="'.$endereco.'" required>
                    </div>';
            }  
          ?>        
        <?php 
        if ($nivel_usuario == 3) {
            if($nivel == 1){
          echo '<div  class="col-md-6" style="margin-top:4em;">
            <div class="col-md-3">
              <div class="custom-control custom-radio custom-control-inline">
                <input class="custom-control-input" type="radio" name="nivel" id="n1" value="1" checked> 
                <label for="n1" class="custom-control-label" style="padding-left:10px;">Atleta</label> 
              </div>
            </div>
            <div class="col-md-3">
              <div class="custom-control custom-radio custom-control-inline">
                <input class="custom-control-input" type="radio" name="nivel" id="n2" value="2"> 
                <label for="n2" class="custom-control-label" style="padding-left:10px;">Técnico</label> 
              </div>
            </div>
            <div class="col-md-3">
              <div class="custom-control custom-radio custom-control-inline">
                <input class="custom-control-input" type="radio" name="nivel" id="n3" value="3"> 
                <label for="n3" class="custom-control-label" style="padding-left:10px;">DM</label> 
              </div>
            </div>
          </div>' ;
            }
            if($nivel == 2){
                echo '<div  class="col-md-6" style="margin-top:4em;">
                  <div class="col-md-3">
                    <div class="custom-control custom-radio custom-control-inline">
                      <input class="custom-control-input" type="radio" name="nivel" id="n1" value="1"> 
                      <label for="n1" class="custom-control-label" style="padding-left:10px;">Atleta</label> 
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="custom-control custom-radio custom-control-inline">
                      <input class="custom-control-input" type="radio" name="nivel" id="n2" value="2" checked> 
                      <label for="n2" class="custom-control-label" style="padding-left:10px;">Técnico</label> 
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="custom-control custom-radio custom-control-inline">
                      <input class="custom-control-input" type="radio" name="nivel" id="n3" value="3"> 
                      <label for="n3" class="custom-control-label" style="padding-left:10px;">DM</label> 
                    </div>
                  </div>
                </div>' ;
            }
            if($nivel == 3){
                    echo '<div  class="col-md-6" style="margin-top:4em;">
                      <div class="col-md-3">
                        <div class="custom-control custom-radio custom-control-inline">
                          <input class="custom-control-input" type="radio" name="nivel" id="n1" value="1"> 
                          <label for="n1" class="custom-control-label" style="padding-left:10px;">Atleta</label> 
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="custom-control custom-radio custom-control-inline">
                          <input class="custom-control-input" type="radio" name="nivel" id="n2" value="2"> 
                          <label for="n2" class="custom-control-label" style="padding-left:10px;">Técnico</label> 
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="custom-control custom-radio custom-control-inline">
                          <input class="custom-control-input" type="radio" name="nivel" id="n3" value="3" checked> 
                          <label for="n3" class="custom-control-label" style="padding-left:10px;">DM</label> 
                        </div>
                      </div>
                    </div>' ;
            }
        
        if($_SESSION['NIVEL']=='3') echo '
        </div>
        <div class="row">
           <div class="form-group col-3 offset-3" style="display:flex; align-items: center;">
            <a href="../equipe/index.php"><button type="button" class="btn btn-primary">Cancelar</button></a>
           </div>';
        }?>
          <div class="form-group col-3 <?php if($_SESSION['NIVEL']!='3') echo 'offset-2';?>" style="display:flex; align-items: center;">
            <button type="submit" class="btn btn-primary">Editar</button>
          </div>
        </div>
      </div>

      </div>
    </form>
  </div>
</div>

<!-- jQuery -->
<script src="../common/js/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../common/js/bootstrap.min.js"></script>
<!-- Placeholder -->
<script src="../common/js/jquery.placeholder.min.js"></script>
<!-- Waypoints -->
<script src="../common/js/jquery.waypoints.min.js"></script>
<!-- Main JS -->
<script src="../common/js/main.js"></script>
<script>
    $("#menu").load("../common/menu/menu.html #menu_");
    $("#menus").load("../common/menu/menu.html #side_menu");
</script>
</body>
</html>

<?php

// Extrai as informações preenchidas no formulário
if ($_POST){

  $erro = False;


  if($erro != True){
  
    $nome = $_POST['nome'];
    $apelido = $_POST['apelido'];
    $aniversario = $_POST['aniversario'];
    $email = $_POST['email'];
    $celular = $_POST['celular'];
    $RG = $_POST['RG'];
    $NUSP = $_POST['NUSP'];
    $endereco = $_POST['endereco'];
      if($nivel_usuario == 3){
          $nivel = $_POST['nivel'];
      }
  
    // upload da foto de perfil
    if (isset($_FILES['foto'])){
      $file = $_FILES['foto']['name'];
      $ext = explode(".", $file);
      $extensao = end($ext);
      if (strlen($extensao) > 0) { //verifica se não esta gravando um arquivo vazio 
        $novo_nome = "perfil"."$id_usuario".".".$extensao;
        $diretorio = "../common/uploads/fotosdeperfil/";
        move_uploaded_file ($_FILES['foto']['tmp_name'], $diretorio.$novo_nome);
        $sql = "UPDATE usuarios SET nome = '$nome' , apelido = '$apelido' , aniversario = '$aniversario' , email = '$email' ,  celular = '$celular', RG = '$RG', NUSP = '$NUSP', endereco = '$endereco', foto = '$novo_nome', nivel= '$nivel', perfil=1 WHERE id = $id_usuario ";
      }
      else {
        $sql = "UPDATE usuarios SET nome = '$nome' , apelido = '$apelido' , aniversario = '$aniversario' , email = '$email' ,  celular = '$celular', RG = '$RG', NUSP = '$NUSP', endereco = '$endereco', nivel= '$nivel', perfil=1 WHERE id = $id_usuario ";
      }
        // Grava no banco de dados
        
        if (mysqli_query($con,$sql)){
          $_SESSION['MSG'] = "Seu perfil foi atualizado com sucesso!";
          if($_SESSION['ID']==$id_usuario){//caso seja o proprio usuario atualizando seu perfil
            $_SESSION['NOME'] = $nome;
            $_SESSION['APELIDO'] = $apelido;
            echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
            echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', '../perfil/');});</script>";
            //header("Location: ../perfil/index.php"); exit;
          } else {
          $_SESSION['MSG'] = "O perfil de: ".$nome." foi atualizado com sucesso!";
          echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
          echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', '../equipe/');});</script>";
          //header("Location: ../equipe/index.php"); exit;
          }
        }
       
        else{
          $_SESSION['ALERTA'] = "Falha ao atualizar perfil";
          echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
          echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './'".$post."');});</script>";
          //header("Location: ./".$post); exit;
        }  
      }   
        
    else{ // Grava no banco de dados sem a foto
        $sql = "UPDATE usuarios SET nome = '$nome' , apelido = '$apelido', aniversario = '$aniversario' , email = '$email' , celular = '$celular', RG = '$RG', NUSP = '$NUSP', endereco = '$endereco', nivel= '$nivel', perfil=1 WHERE id = $id_usuario ";
        $atualizar_perfil = mysqli_query($con,$sql);
        if ($atualizar_perfil >= '1'){
          $_SESSION['MSG'] = "Seu perfil foi atualizado com sucesso!";
          if($_SESSION['ID']==$id_usuario){//caso seja o proprio usuario atualizando seu perfil
            $_SESSION['NOME'] = $nome;
            $_SESSION['APELIDO'] = $apelido;
            echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
            echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', '../perfil/');});</script>";
            //header("Location: ../perfil/index.php"); exit();
          } else{
          $_SESSION['MSG'] = "O perfil de: ".$nome." foi atualizado com sucesso!";
          echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
          echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', '../equipe/');});</script>";
          //header("Location: ../equipe/index.php"); exit;
          }
        }     
        else {
          $_SESSION['ALERTA'] = "Falha ao atualizar perfil";
          echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
          echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './'".$post."');});</script>";
          //header("Location: ./".$post); exit;        
          }
    }
   }
  else {
      $_SESSION['ALERTA'] = "Falha ao atualizar perfil";
      echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
      echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './'".$post."');});</script>";
      //header("Location: ./".$post); exit;
    }
  }
?>