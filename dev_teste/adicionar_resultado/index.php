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
    <title>Wetrats - Resultados</title>
</head>
<?php
    //Inicia uma sessão
    // Verifica se existe ID da sessão
    if(!isset($_SESSION['ID'])){
    //Destrói a sessão por segurança
    session_destroy();
    //Redireciona para o login
    header("Location: ../index.php"); exit;
    }
  $id_usuario = $_SESSION['ID'];
  $apelido_usuario= $_SESSION['APELIDO'];
  $nivel_usuario = $_SESSION['NIVEL'];
  $sexo_usuario = $_SESSION['SEXO'];
  $_SESSION['competicao']=$_GET['competicao'];
?>  


<body>
<div id="page">
  <nav class="fh5co-nav" id="menu-list" role="navigation">
      <div id="menu"></div>
  </nav>
  <div id="menus"></div>

  <div class="container-fluid" style="padding-top:60px;" >
    <div class="row">
      <form method="post" action="index.php" class="col-md-12">

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
      
        <h1>Inclusão de resultado individual</h1>
        <p>Seleciona a competicao ou a data e insira o seu tempo na prova em que deseja se inscrever. <br>
        PS.: a separação dos minutos, segundos e centésimos deve ser realizada da seguinte forma: Min'Seg"Cent(Minutos e segundos separados por aspas simples e segundos e centésimos separados por aspas duplas)</p>
        <hr>
        
        <div class="row form-group">
            <div class="col-md-6">
                <label for="competicao"><b>Competição:</b></label>
                <select class="form-control"  name="competicao">
                    <option value=" "> </option>
                <?php

                // Conexão com o servidor MySQL
                $con = mysqli_connect("srv976.hstgr.io", "u418844475_wtr", "Wetrats2019", "u418844475_wtr");

                //busca pelos nomes das competicoes cadastrados no sistema e ativas
                $sql = "SELECT id,evento, data FROM competicoes ORDER BY data ";
                $resultado = mysqli_query($con,$sql);
                while($row = mysqli_fetch_assoc($resultado)){
                    $id_evento=$row['id'] ;
                    $evento = $row['evento'] ;
                    $data = $row['data'];
                    $html = '<option value ="'.$id_evento.'_'.$data.'"';
                    if(isset($_POST['ok'])) {
                        $html .="selected";
                    }
                    $html .='>'.$evento.'</option>' ;
                    echo $html ;
                }

                ?>
                </select>
            </div>
        </div>

        <div class="row form-group">
            <div class="col col-md-6">
                <label for="data"><b>Data:</b></label>
                <input class="form-control" type="date" placeholder="Insira a data..." name="data" >
            </div>
        </div>

        <div class="col-md-2">       
                <label for="estilo"><b>Estilo :</b></label>
                    <select class="form-control" name="estilo">
                        <option value="Borboleta" >Borboleta</option>
                        <option value="Costas" >Costas</option> 
                        <option value="Peito" >Peito</option>
                        <option value="Livre" >Livre</option>
                        <option value="Medley" >Medley</option>
                    </select>
            </div>

            <div class="col-md-2">       
                <label for="metragem"><b>Metragem :</b></label>
                <input class="form-control" type="number" name="metragem" required>
            </div>

            <div class="col-md-2">       
                <label for="tempo"><b>Tempo :</b></label>
                <input class="form-control" type="text" name="tempo" required>
            </div>

        
        
        <div class="row">
          <div class="form-group col-md-2 col-md-push-3">
          <a href="../performances/index.php"><button type="button" class="btn btn-primary">Cancelar</button></a>
          </div>
          <div class="form-group col-md-2 col-md-push-6"> 
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

    $competicao = $_POST['competicao'];
    if (strlen($competicao)>1){
        $string= explode("_",$competicao);
        $evento=$string[0];
        $data=$string[1];
    }
    else{
        $evento=-1;
        $data= $_POST['data'];
    }
    $estilo = $_POST['estilo'];
    $metragem = $_POST['metragem'];
    $tempo = str_replace('"' , '\\"' , $_POST['tempo']); //procedimento pra permitir a inclusao de aspas duplas
    $tempo = str_replace("'" , "\\'" , $tempo); // e simples no texto

    // Conexão com o servidor MySQL
    $con = mysqli_connect("srv976.hstgr.io", "u418844475_wtr", "Wetrats2019", "u418844475_wtr");
    
    // Grava as informações no banco de dados
    $sql = "INSERT INTO resultados_competicoes (id_atleta, sexo, id_competicao, data, estilo, metragem,tempo) 
    VALUES ("."'$id_usuario'".","."'$sexo_usuario'".","."'$evento'".","."'$data'".","."'$estilo'".","."'$metragem'".", '".$tempo."')";
    if (!mysqli_query($con,$sql)){
        echo("Error description: " . mysqli_error($con));
        echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
        echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './');});</script>";
        //header("Location: ./index.php"); exit; 
    }
    else {
        $date=date_create($data);
        $tempo = str_replace("\\" ,"" ,  $tempo); 
        $_SESSION['MSG'] = "Seu resultado na prova: ".$metragem." ".$estilo." com o tempo de:".$tempo." em ".date_format($date,"d/m/y")." ; foi incluído com sucesso." ;
        echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
        echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './');});</script>";
        //header("Location: ./index.php"); exit;
    }
}
?>