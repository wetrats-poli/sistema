<html lang="pt-BR">
<head>
  <meta charset = "utf-8" >
  <link rel="stylesheet" type="text/css" href="./common/stylesheets/styles.css">
  <link rel="stylesheet" href="./common/stylesheets/bootstrap.css">
	<link rel="stylesheet" href="./common/stylesheets/animate.css">
  <link rel="stylesheet" href="./common/stylesheets/style.css">
  <link rel="icon" type="image/png" href="../common/images/favicon-32x32.png" sizes="32x32" />
  <title>Wetrats</title>
</head>

<body>
<div class="container" style="background-color: rgb(15, 15, 54);background-image:url(./common/images/WetRat.png); background-size:cover; background-position-y: 40%; width:100%; height:100%;" data-stellar-background-ratio="1">
  <div class="row">
    <div class="col-md-4 col-sm-6" style="padding-left: 5%;">
      <form action="esqueceu_a_senha.php" method="post" class="fh5co-form animate-box" data-animate-effect="fadeInLeft"
      style="background-color: rgba(255,187,0, 0.9); border: 0;">
    
        <h2>Esqueceu a senha</h2>
        <p style="color: rgb(0,0,0);">Digite o email utilizado no seu perfil e você receberá um email contendo uma nova senha, caso o email digitado esteja correto.</p>
        <hr>

    <?php
      
      session_start();
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
    
        <div class="form-group">
          <label for="email"><b>E-mail</b></label>
          <input type="text" placeholder="Digite seu email..." name="email" required>
        </div>
          
        <div class="form-group col-md-push-4 col-sm-push-4">
          <input type="submit" value="Enviar email" name="ok" class="btn btn-primary">
        </div>

        <div class="form-group col-md-7 col-sm-7">
            <p><a href="./index.php">Cancelar</a></p>
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
<?php



if (isset($_POST['email'])){
  $email = $_POST['email'];
// Conexão com o servidor MySQL
  $con = mysqli_connect("auth-db213.hostinger.com.br", "u418844475_wtr", "wetrats2019", "u418844475_wtr");
  
  // Validação do usuário
  $sql =  "SELECT apelido FROM usuarios WHERE email= '$email' " ;
  $res = mysqli_query($con, $sql);
  while ($f = mysqli_fetch_array($res)){
    $apelido = $f['apelido'];
  }
  if ($apelido==""){
      $_SESSION['ALERTA'] = "Email inválido." ;
      echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
      echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './esqueceu_a_senha.php');});</script>";
      //header("Location: ./esqueceu_a_senha.php"); exit;
  }
  else{
    $nova_senha = dechex(time()*777777);
    $nova_senha = substr($nova_senha,4);
    $hash = password_hash($nova_senha,PASSWORD_DEFAULT);

    //redefinição da senha
    $sql= "UPDATE usuarios SET senha ="."'$hash'"."WHERE email="."'$email'" ;
    if (!mysqli_query($con, $sql)) {
        $_SESSION['ALERTA'] .= mysqli_error($con);
    }
    else{
    $_SESSION['MSG'].= "Senha redefinida.";
    
    //preparação para o envio do email
    $mensagem = "<h1 style='color:#242b56; background-color:#ffbb00;'>Olá "."$apelido"."!</h1> <hr> <br> 
                 <h2> Sua nova senha é: ".$nova_senha."</h2>
                 <hr>
                 <p> Você já pode fazer seu login com este email cadastrado e esta senha e alterá-la em seguida.";
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: wetrats <contato@wetrats.com.br>' ;

    $envio = mail($email,"Recuperação de senha", $mensagem, $headers);
    if ($envio){
        $_SESSION['MSG'] = "Email enviado para:"."$email";
        echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
        echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './esqueceu_a_senha.php');});</script>";
        //header("Location: ./esqueceu_a_senha.php"); exit;
    }
    else {
        $_SESSION['ALERTA'] .= "Falha no envio do email.Contate o DM.";
        echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
        echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './esqueceu_a_senha.php');});</script>";
        //header("Location: ./esqueceu_a_senha.php"); exit;
    }
    }
}
}

?>