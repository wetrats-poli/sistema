<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
    <link rel="stylesheet" href="../common/stylesheets/bootstrap.css">
    <link rel="stylesheet" href="../common/stylesheets/bootstrap4.css">
    <link rel="stylesheet" href="../common/stylesheets/animate.css">
    <link rel="stylesheet" href="../common/stylesheets/style.css">
    <link rel="stylesheet" href="../common/stylesheets/style1.css">
    <link rel="icon" type="image/png" href="../common/images/favicon-32x32.png" sizes="32x32" />
    <title>Wetrats - Alterar Senha</title>
</head>

<body>
<div id="page">
  <nav class="fh5co-nav" id="menu-list" role="navigation">
      <div id="menu"></div>
  </nav>
  <div class="container-fluid" style="padding-top:60px;">
    <div class="row">
      <form method="post" action="alterar_senha.php" class="col-12">

      <?php 
      
      session_start();
      $id_usuario = $_SESSION['ID'];
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
      
        <h1>Alterar senha</h1>
        <p>Preencha os campos abaixo para alterar sua senha.</p>
        <hr>
        <div class="container_form_senha">
        <div class="row form-group">
          <div class="col-12">
            <label for="senha"><b>Nova senha</b></label>
            <input class="form-control" type="password" placeholder="Digite sua nova senha..." name="senha" required>
          </div>
        </div>

        <div class="row form-group">
          <div class="col-12">
            <label for="confirmacao"><b>Confirmação de senha</b></label>
            <input class="form-control" type="password" placeholder="Digite novamente sua nova senha..." name="confirmacao" required>
          </div>
        </div>

        <div class="row" style="margin-top:15px;">
          <div class="form-group col-3">
            <a href="./index.php"><button type="button" class="btn btn-primary">Cancelar</button></a>
          </div>
          <div class="form-group col-3">
            <button type="submit" class="btn btn-primary"name="alterar_senha" value="1" >Alterar</button>
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
</script>
</body>
</html>
<?php

if(isset($_POST['alterar_senha'])){
    $senha = $_POST['senha'];
    if ($senha == $_POST['confirmacao']){
        //redefinição da senha
        $hash = password_hash($senha,PASSWORD_DEFAULT);
        $sql= "UPDATE usuarios SET senha ="."'$hash'"." WHERE id = $id_usuario " ;
        $con = mysqli_connect("auth-db213.hstgr.io", "u418844475_wtr", "Wetrats2019", "u418844475_wtr");
        if (!mysqli_query($con, $sql)) {
            $_SESSION['ALERTA'] = mysqli_error($con);
            echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
            echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './alterar_senha.php');});</script>";
            //header("Location: ./alterar_senha.php") ; exit;            
        }
        else{
            $_SESSION['MSG'] = "Senha alterada com sucesso!";
            echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
            echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', '../perfil/');});</script>";
            //header("Location: ./index.php") ; exit;
        }

    }
    else {
        $_SESSION['ALERTA'] = "Senha e confirmação de senha diferentes";
        echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
            echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './alterar_senha.php');});</script>";
        //header("Location: ./alterar_senha.php") ; exit;
    }
}
?>