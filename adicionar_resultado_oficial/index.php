<html lang="pt-BR">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
    <link rel="stylesheet" href="../common/stylesheets/bootstrap.css">
    <link rel="stylesheet" href="../common/stylesheets/bootstrap4.css">
    <link rel="stylesheet" href="../common/stylesheets/animate.css">
    <link rel="stylesheet" href="../common/stylesheets/style.css">
    <link rel="stylesheet" href="../common/stylesheets/style1.css">
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../common/stylesheets/build.css">
    <link rel="icon" type="image/png" href="../common/images/favicon-32x32.png" sizes="32x32" />
    <title>Wetrats - Resultado</title>

</head>
<?php
 //Inicia uma sessão
  session_start();
  $id_usuario = $_SESSION['ID'];
  $nivel_usuario = $_SESSION['NIVEL'];    
  // Verifica se existe ID da sessão
  if(!isset($_SESSION['ID'])){
  //Destrói a sessão por segurança
  session_destroy();
  //Redireciona para o login
  header("Location: ../index.php"); exit;
  }
  if ($nivel_usuario != '3'){
      session_destroy();
      session_start();
      $_SESSION['ALERTA'] = "Área restrita! Acesso negado. ";
      header("Location: ../index.php"); exit;
  }
?>  


<body>
<div id="page">
  <nav class="fh5co-nav" id="menu-list" role="navigation">
      <div id="menu"></div>
  </nav>
  <div id="menus"></div>

  <div class="container-fluid" style="padding-top:60px;" >
    <div class="row">
      <form method="post" action="index.php" class="col-12">

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
      
        <h1>Inclusão de Resultado Oficial</h1>
        <p>Selecione o atleta ou digite o seu nome, a prova, a competição e o tempo. <br>
        PS.: a separação dos minutos, segundos e centésimos deve ser realizada da seguinte forma: Min'Seg"Cent(Minutos e segundos separados por aspas simples e segundos e centésimos separados por aspas duplas)</p>
        <hr>
        
        <div class="container_form">
        <div class="row form-group">
            <div class="col-6">
                
                <label for="atleta"><b>Atleta:</b></label>
                <select class="form-control"  name="atleta">
                    <option value=" "> </option>
                <?php

                // Conexão com o servidor MySQL
                $con = mysqli_connect("auth-db213.hostinger.com.br", "u418844475_wtr", "wetrats2019", "u418844475_wtr");

                //busca pelos nomes das competicoes cadastrados no sistema e ativas
                $sql = "SELECT nome FROM usuarios ORDER BY nome ";
                $resultado = mysqli_query($con,$sql);
                while($row = mysqli_fetch_assoc($resultado)){
                    $nome = $row['nome'];
                    $html = '<option value ="'.$nome.'"';
                    if (isset($_POST['atleta'])){
                      if ($_POST['atleta']== $nome){
                        $html.= " selected";
                      }
                    }
                    $html .='>'.$nome.'</option>' ;
                    echo $html ;
                }

                ?>
                </select>
                <input class="form-control" name="nome_atleta" placeholder="Ou digite..." value="<?php if(isset($_POST['nome_atleta'])) echo $_POST['nome_atleta']; ?>">
            </div>

        <div class="col-6">
            <label><b>Sexo:</b></label><br>
            <div class="custom-control custom-radio custom-control-inline">
              <input class="custom-control-input" type="radio" name="sexo" id="s1" value="M" <?php if($_POST['sexo'] == "M") echo "checked"; ?>> 
              <label for="s1" class="custom-control-label" style="padding-left:10px;">Masculino</label> 
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input class="custom-control-input" type="radio" name="sexo" id="s2" value="F" <?php if($_POST['sexo'] == "F") echo "checked"; ?>> 
              <label for="s2" class="custom-control-label" style="padding-left:10px;">Feminino</label> 
            </div>
        </div>
        </div>
                
        <div class="row form-group">
            <div class="col-6">        
                <label for="competicao"><b>Competição:</b></label>
                <select class="form-control"  name="competicao">
                    <option value=" "> </option>
                <?php

                // Conexão com o servidor MySQL
                $con = mysqli_connect("auth-db213.hostinger.com.br", "u418844475_wtr", "wetrats2019", "u418844475_wtr");

                //busca pelos nomes das competicoes cadastrados no sistema e ativas
                $sql = "SELECT evento, data FROM competicoes ORDER BY data ";
                $resultado = mysqli_query($con,$sql);
                while($row = mysqli_fetch_assoc($resultado)){
                    $evento = $row['evento'] ;
                    $data = $row['data'];
                    $html = '<option value ="'.$evento.'_'.$data.'"';
                    if (isset($_POST['competicao'])){
                      if ($_POST['competicao']== $evento.'_'.$data){
                        $html.= " selected";
                      }
                    }
                    $html .='>'.$evento.'</option>' ;
                    echo $html ;
                }

                ?>
                </select>
                <input class="form-control" name="nome_comp" placeholder="Ou digite..." value="<?php if (isset($_POST['nome_comp'])) echo $_POST['nome_comp']; ?>">
            </div>

            <div class="col-6">
                <label for="data"><b>Data:</b></label>
                <input class="form-control" type="date" placeholder="Insira a data APENAS se não a competição foi digitada manualmente..." name="data" value="<?php if (isset($_POST['data'])) echo $_POST['data']; ?>" >
            </div>
        </div>

        </div>

        <!-- formulario para inserçao das provas -->
        <div class="container_form" style="margin-top:40px;">
            
                <h1>Provas</h1>
                <p>Digite o número de provas a serem inseridas e clique em "Ok!" para adicionar os campos.</p>
    
                <div class="row form-group">
                    <div class="col-3">
                        <label for="nprovas"><b>Número de Provas:</b></label>
                        <input class="form-control" type="number" placeholder="Nº de provas..." name="nprovas" value="<?php if(isset($_POST['nprovas'])) echo $_POST['nprovas']; ?>"required>
                    </div>

                    <div class="col-2" style="margin-top:3em;">
                        <button type="submit" class="btn btn-primary" name="ok" value = "ok">Ok!</button>
                    </div>
                </div>
                <?php 
                if (isset($_POST['ok'])){
                   $nprovas=$_POST['nprovas'];
                    $i = 1;
                    while ($i<= $nprovas){
                        echo 
                        '
                        <div class="row form-group">
                          <div class="col-3">       
                              <label for=prova'.$i.'><b>Prova '.$i.':</b></label>
                              <select class="form-control" name="prova'.$i.'">
                                  <option value="50 Borboleta" >50m Borboleta</option>
                                  <option value="50 Costas" >50m Costas</option> 
                                  <option value="50 Peito" >50m Peito</option>
                                  <option value="50 Livre" >50m Livre</option>
                                  <option value="100 Medley" >100m Medley</option>
                              </select>
                          </div>
                          <div class="col-3">
                            <label for=tempo'.$i.'><b>Tempo:</b></label>
                            <input class="form-control" name="tempo'.$i.'">
                          </div>
                        </div>' ;
                        $i +=1 ;
                    }
                }
                ?>
            </div>
        </div>

        
        <div class="row">
          <div class="form-group col-2 col-push-3">
          <a href="../ranking/index.php"><button type="button" class="btn btn-primary">Cancelar</button></a>
          </div>
          <div class="form-group col-2 col-push-6"> 
            <button type="submit" class="btn btn-primary" name="finalizado" value="1">Enviar</button>
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
if (($_POST['finalizado']=="1")){
    
    $atleta= $_POST['atleta'];
    if (strlen($atleta)<=1){
        $atleta= $_POST['nome_atleta'];
    }

    $sexo = $_POST['sexo'];

    $competicao = $_POST['competicao'];
    if (strlen($competicao)>1){
        $string= explode("_",$competicao);
        $evento=$string[0];
        $data=$string[1];
    }
    else{
        $evento=$_POST['nome_comp'];
        $data= $_POST['data'];
    }

    $tempo = str_replace('"' , '\\"' , $_POST['tempo']); //procedimento pra permitir a inclusao de aspas duplas
    $tempo = str_replace("'" , "\\'" , $tempo); // e simples no tempo

    //preparação do sql e da mensagem de sucesso
    $mensagem= "O resultado do(a) atleta:".$atleta;
    $sql = "INSERT INTO `ranking` (nome_atleta, sexo, prova, competicao, data, tempo) VALUES "; 
    $nprovas=$_POST['nprovas'];
    $i=1;
    while($i<= $nprovas){
      $prova_i = "prova".$i;
      $prova = $_POST[$prova_i];
      $tempo_i = "tempo".$i;
      $tempo = str_replace('"' , '\\"' , $_POST[$tempo_i]); //procedimento pra permitir a inclusao de aspas duplas
      $tempo = str_replace("'" , "\\'" , $tempo); // e simples no tempo
      $sql.= "("."'$atleta'".","."'$sexo'".","."'$prova'".","."'$evento'".","."'$data'".","."'$tempo'".") ,";
      if($i==1) $mensagem .= " na prova:".$prova." com o tempo de:".str_replace("\\" ,"" ,  $tempo)."; \n";
      else $mensagem .= " e na prova:".$prova." com o tempo de:".str_replace("\\" ,"" ,  $tempo)."; \n";
      $i += 1;
    }

    $sql = substr($sql, 0, -1);
    $sql .= ";" ;

    $date=date_create($data);
    $mensagem .= " em ".date_format($date,"d/m/y")." foi incluído com sucesso.";

    // Conexão com o servidor MySQL
    $con = mysqli_connect("auth-db213.hostinger.com.br", "u418844475_wtr", "wetrats2019", "u418844475_wtr");
    
    // Grava as informações no banco de dados
    if (!mysqli_query($con,$sql)){
        echo("Error description: " . mysqli_error($con));
        echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
        echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './');});</script>";
        //header("Location: ./index.php"); exit;
    }
    else { 
        $_SESSION['MSG'] = $mensagem ;
        echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
        echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './gerenciar_ranking.php');});</script>";
        //header("Location: ./gerenciar_ranking.php"); exit;
    }
}
?>