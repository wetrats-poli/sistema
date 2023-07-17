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
    <title>Wetrats - Performance</title>
</head>
<?php
 //Inicia uma sessão
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
  if ($nivel_usuario != '3'){
      session_destroy();
      session_start();
      $_SESSION['ALERTA'] = "Área restrita! Acesso negado. ";
      header("Location: ../index.php"); exit;
  }

  if(strlen($_GET['id'])>0){
      $id= $_GET['id'];
      $form="editar_performance.php?id=".$id ;
      // Conexão com o servidor MySQL
      $con = mysqli_connect("srv976.hstgr.io", "u418844475_wtr", "Wetrats2019", "u418844475_wtr");

      //busca das informacoes referentes a tabela de tiros
      $sql = "SELECT  id,nome_atleta, sexo, prova, competicao, data, tempo FROM `ranking` WHERE id=".$id.";" ;
  
      $resultado= mysqli_query($con,$sql);
      $res = mysqli_fetch_assoc($resultado);
          $nome_atleta = $res['nome_atleta'];
          $sexo = $res['sexo'];
          $data = $res['data'];
          $prova = $res['prova'];
          $competicao = $res['competicao'];
          $tempo = $res['tempo'];
  }
  else {
    $_SESSION['ALERTA'] = "Prova inexistente! Consultar banco de dados.";
    echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
    echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './gerenciar_ranking.php');});</script>";
    //header("Location: ./gerenciar_ranking.php"); exit;
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
      <form method="post" action="<?php echo $form;?>" class="col-12">

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
      
        <h1>Edição de resultado oficial</h1>
        <p>Altere as informações que preterir e clique em editar para confirmar a alteração. <br>
        PS.: a separação dos minutos, segundos e centésimos deve ser realizada da seguinte forma: Min'Seg"Cent(Minutos e segundos separados por aspas simples e segundos e centésimos separados por aspas duplas)</p>
        <hr>
        
        <div class="container_form">
        <div class="row form-group">
            <div class="col-6">
                <input class="form-control" name="nome_atleta" placeholder="Ou digite..." value="<?php echo $nome_atleta ;?>">
            </div>

        <div class="col-6">
            <label><b>Sexo:</b></label><br>
            <div class="custom-control custom-radio custom-control-inline">
              <input class="custom-control-input" type="radio" name="sexo" id="s1" value="M" <?php if($sexo == "M") echo "checked"; ?>> 
              <label for="s1" class="custom-control-label" style="padding-left:10px;">Masculino</label> 
            </div>
            <div class="custom-control custom-radio custom-control-inline">
              <input class="custom-control-input" type="radio" name="sexo" id="s2" value="F" <?php if($sexo == "F") echo "checked"; ?>> 
              <label for="s2" class="custom-control-label" style="padding-left:10px;">Feminino</label> 
            </div>
        </div>
        </div>
                
        <div class="row form-group">
            <div class="col-6">        
                <label for="competicao"><b>Competição:</b></label>
                <input class="form-control" name="nome_comp" placeholder="Ou digite..." value="<?php echo $competicao; ?>">
            </div>

            <div class="col-6">
                <label for="data"><b>Data:</b></label>
                <input class="form-control" type="date" name="data" value="<?php echo $data ; ?>" >
            </div>
        </div>

        <div class="row form-group">
            <div class="col-3">       
                <label for="prova"><b>Prova:</b></label>
                <select class="form-control" name="prova">
                    <option value="50 Borboleta" <?php if($prova=="50 Borboleta") echo "selected" ;?> >50m Borboleta</option>
                    <option value="50 Costas" <?php if($prova=="50 Costas") echo "selected" ;?> >50m Costas</option> 
                    <option value="50 Peito" <?php if($prova=="50 Peito") echo "selected" ;?> >50m Peito</option>
                    <option value="50 Livre" <?php if($prova=="50 Livre") echo "selected" ;?> >50m Livre</option>
                    <option value="100 Medley" <?php if($prova=="100 Medley") echo "selected" ;?> >100m Medley</option>
                </select>
            </div>
            
            <div class="col-3">            
                <label for="tempo"><b>Tempo:</b></label>
                <input class="form-control" name="tempo" value=<?php echo $tempo ;?>>
            </div>
        </div> 
            
        
        </div>
    </div>

        
        <div class="row">
          <div class="form-group col-2 col-push-3">
            <a href="./gerenciar_ranking.php"><button type="button" class="btn btn-primary">Cancelar</button></a>
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
    
    $atleta= $_POST['nome_atleta'];
    $sexo = $_POST['sexo'];
    $evento=$_POST['nome_comp'];
    $data= $_POST['data'];
    $prova = $_POST['prova'];
    
    
    $tmp=$_POST['tempo'];
    $tempo = str_replace('"' , '\\"' , $_POST['tempo']); //procedimento pra permitir a inclusao de aspas duplas
    $tempo = str_replace("'" , "\\'" , $tempo); // e simples no tempo

    
    $sql = "UPDATE `ranking` SET nome_atleta='".$atleta."', sexo='".$sexo."', prova='".$prova."', competicao='".$evento."', data='".$data."', tempo='".$tempo."' WHERE id=".$id.";" ; 


    $date=date_create($data);
    $mensagem= "O resultado do(a) atleta:".$atleta."; na prova:".$prova." com o tempo de:".$tmp." em ".date_format($date,"d/m/y")." foi atualizado com sucesso.";

    // Conexão com o servidor MySQL
    $con = mysqli_connect("srv976.hstgr.io", "u418844475_wtr", "Wetrats2019", "u418844475_wtr");
    
    // Grava as informações no banco de dados
    if (!mysqli_query($con,$sql)){
        $_SESSION['ALERTA'] = "Error description: ".mysqli_error($con);
        echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
        echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './".$form."');});</script>";
        //header("Location: ./".$form); exit;
    }
    else { 
        $_SESSION['MSG'] = $mensagem ;
        echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
        echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './gerenciar_ranking.php');});</script>";
        //header("Location: ./gerenciar_ranking.php"); exit;
    }
}
?>