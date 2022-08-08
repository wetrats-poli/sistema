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
        <!--?php
        
        // create a new cURL resource
        $ch = curl_init();
        $headers = array(
          'authority' => 'voting.playbuzz.com',
          'origin' => 'https://www.revistabeat.com.br',
          'user-agent' => 'Mozilla/5.0 (Linux; Android 5.0; SM-G900P Build/LRX21T) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.108 Mobile Safari/537.36',
          'accept' => '*/*',
          'sec-fetch-site' => 'cross-site',
          'sec-fetch-mode' => 'cors',
          'referer' => 'https://www.revistabeat.com.br/2019/12/12/beat-de-ouro-2019/',
          'accept-encoding' => 'gzip, deflate, br',
          'accept-language' => 'pt-BR,pt;q=0.9,en-US;q=0.8,en;q=0.7',
          'if-none-match' => 'W/^\^f6-FSzEWPkcOt35Yjt7SMKyod3JNwI^\^'
      );
        // set URL and other appropriate options
        curl_setopt($ch, CURLOPT_URL, 'https://voting.playbuzz.com/poll/4ac71c00-0613-4bfa-aed3-50c8efebc9eb/12a80d55-6d5f-430c-bf45-d68e9f562063?questionId=12a80d55-6d5f-430c-bf45-d68e9f562063');
        curl_setopt($ch, CURLOPT_HEADER, $headers);
        ob_start();
        // grab URL and pass it to the browser
        curl_exec($ch);
        $resposta = ob_get_clean();
        //$resposta=json_decode($resposta, true);
        //$total=count($resposta);
        $resposta = explode('"results":',$resposta)[1];
        $resposta=substr($resposta,0,-1);
        $resposta = json_decode($resposta,true);
        $ayumi=$resposta['e28189de-6282-4dad-9465-012cd70e16b5'];
        $cha=$resposta['80625d79-bc79-4b8e-a9c9-c733e3721c71'];
        echo "<br>Ayumi:".$ayumi."<br>";
        echo "Cha:".$cha;
        $con = mysqli_connect("auth-db213.hostinger.com.br", "u418844475_wtr", "wetrats2019", "u418844475_wtr");
        $sql =  "INSERT INTO beat(cha,ayumi) VALUES (".$cha.",".$ayumi.")";
        mysqli_query($con,$sql);
        
        // close cURL resource, and free up system resources
        curl_close($ch);
    
        ?--> 
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