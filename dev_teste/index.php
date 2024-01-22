<?php
  
  session_start();
  
?>

<html lang="pt-BR">
<head>
  <meta charset = "utf-8" >
  <meta content="width=device-width, initial-scale=1" name="viewport" />
  <link rel="stylesheet" type="text/css" href="./common/stylesheets/style1.css">
  <link rel="stylesheet" href="./common/stylesheets/bootstrap.css">
  <link rel="stylesheet" href="./common/stylesheets/animate.css">
  <link rel="stylesheet" href="./common/stylesheets/style.css">
  <link rel="icon" type="image/png" href="../common/images/favicon-32x32.png" sizes="32x32" />
  <title>Wetrats</title>
</head>

<body style="background-color: rgb(15, 15, 54) !important;">
<div class="container" style="background-color: rgb(15, 15, 54);background-image:url(./common/images/WetRat.png); background-size:cover; background-position-y: 40%; width:100%; height:100%;" data-stellar-background-ratio="1">
  <div class="row">
    <div class="form-pos">
      <form action="validacao.php" method="post" class="fh5co-form animate-box" data-animate-effect="fadeInLeft"
      style="background-color: rgba(255,187,0, 0.9); border: 0;">
    
        <h2>Login</h2>

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
        session_destroy();
        ?>
    
        <div class="form-group">
          <label for="email"><b>E-mail</b></label>
          <input type="text" placeholder="Digite seu email..." name="email" required>
        </div>
        <div class="form-group">
          <label for="senha"><b>Senha</b></label>
          <input type="password" placeholder="Digite sua senha..." name="senha" required>
        </div>
        <!--div class="form-group">
          <label for="remember"><input type="checkbox" id="remember"> Lembrar Nome de Usuário</label>
        </div--> 
        <div class="form-group col-md-7 col-sm-7">
            <p><a href="./esqueceu_a_senha.php">Esqueceu a Senha?</a></p>
          </div>
          
        <div class="form-group col-md-push-4 col-sm-push-4">
          <input type="submit" value="Entrar" class="btn btn-primary">
        </div>
      </form>
    </div>
  </div>
</div>

<!-- jQuery -->
<script src="./common/js/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="./common/js/bootstrap.min.js"></script>
<!-- Placeholder -->
<script src="./common/js/jquery.placeholder.min.js"></script>
<!-- Waypoints -->
<script src="./common/js/jquery.waypoints.min.js"></script>
<!-- Main JS -->
<script src="./common/js/main.js"></script>
</body>
</html>