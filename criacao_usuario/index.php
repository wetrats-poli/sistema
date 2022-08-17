<html lang="pt-BR">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
    <link rel="stylesheet" href="../common/stylesheets/bootstrap.css">
    <link rel="stylesheet" href="../common/stylesheets/bootstrap4.css">
    <link rel="stylesheet" href="../common/stylesheets/animate.css">
    <link rel="stylesheet" href="../common/stylesheets/style.css">
    <link rel="stylesheet" href="../common/stylesheets/style1.css">
    <link rel="icon" type="image/png" href="../common/images/favicon-32x32.png" sizes="32x32" />
    <title>Wetrats - Criar Perfil</title>
</head>

<body>
<div id="page">
  <nav class="fh5co-nav" id="menu-list" role="navigation">
      <div id="menu"></div>
  </nav>
  <div id="menus"></div>
  
  <div class="container-fluid" style="padding-top:60px;">
    <div class="row">
      <form method="post" action="index.php" class="col-md-12">

      <?php
      session_start(); 
      
       // Verifica se existe ID da sessão
      if(!isset($_SESSION['ID'])){
        //Destrói a sessão por segurança
        session_destroy();
        //Redireciona para o login
        header("Location: ../index.php"); exit;
        }
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
      
        <h1>Novo usuário</h1>
        <p>Preencha os campos abaixo para criar um novo usuário.</p>
        <hr>
        
        <div class="container_form_perfil">
        <div class="row form-group">
          <div class="col-md-6">
            <label for="Nome"><b>Nome Completo</b></label>
            <input class="form-control" type="text" placeholder="Digite o nome e sobrenome..." name="nome" >
          </div>
          
          <div class="col-md-3">
            <label><b>Sexo:</b></label><br>
            <div class="custom-control custom-radio custom-control-inline">
              <input class="custom-control-input" type="radio" name="sexo" id="s1" value="M"> 
              <label for="s1" class="custom-control-label" style="padding-left:10px;">Masculino</label> 
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input class="custom-control-input" type="radio" name="sexo" id="s2" value="F"> 
              <label for="s2" class="custom-control-label" style="padding-left:10px;">Feminino</label> 
            </div>
          </div>
        </div>

        <div class="row form-group">

          <div class="col-md-6">
            <label for="apelido"><b>Apelido</b></label>
            <input class="form-control" type="text" placeholder="Digite um apelido..." name="apelido">
          </div>
          
          <div class="col-md-6">
            <label for="email"><b>Email</b></label>
            <input class="form-control" type="text" placeholder="Digite seu Email..." name="email" required>
          </div>
        </div>
          
        <div class="row form-group">
            <div class="col-md-4">
                <label for="senha"><b>Senha</b></label>
                <input class="form-control" type="password" placeholder="Digite sua senha..." name="senha" required>
            </div>

          <div class="col-md-4">
            <label for="confirma_senha"><b>Confirmação de senha</b></label>
            <input class="form-control" type="password" placeholder="Digite novamente sua senha..." name="confirma_senha" required>
          </div>
        </div>
          
          
        <div class="row form-group">
          <div  class="col-md-6">
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
          </div>
        
          <div class="form-group col-2 offset-2">
          <a href="../equipe/index.php"><button type="button" class="btn btn-primary">Cancelar</button></a>
          </div>
          <div class="form-group col-2">
            <button type="submit" class="btn btn-primary">Criar</button>
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

if ($_POST){
  //$nome = $_POST['nome'];
  $sexo = $_POST['sexo'];
  
  //$apelido = $_POST['apelido'];
  $email = $_POST['email'];
  $senha = $_POST['senha'];
  if ($senha!= $_POST['confirma_senha']) {
    $_SESSION['ALERTA'] = "Senha e confirmação de senha diferentes!" ;
    echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
    echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './');});</script>";
    //header("Location: ./index.php"); exit;
  }
  //hash de senha
  $hash = password_hash($senha, PASSWORD_DEFAULT);
  $nivel = $_POST['nivel'];
  $con = mysqli_connect("auth-db213.hstgr.io", "u418844475_wtr", "wetrats2019", "u418844475_wtr");
  $sql = "INSERT INTO usuarios (email,sexo,senha,nivel,ativo,perfil) VALUES ("."'$email'".","."'$sexo'".","."'$hash'".","."'$nivel'".", '1', 0)";
  $query = mysqli_query($con,$sql);
  if ($query) {
      $_SESSION['MSG'] = "Usuário criado com sucesso!" ;
      
      //redireciona pra tela de login
      echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
      echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', '../equipe/');});</script>";
      //header("Location: ../equipe/index.php"); exit;
  }
  else{
    $_SESSION['ALERTA'] = mysqli_error($con) ;
    echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
    echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './');});</script>";
    //header("Location: ./index.php"); exit;
    }
  }
?>