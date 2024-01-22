<html lang="pt-BR">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
    <link rel="stylesheet" href="../common/stylesheets/bootstrap.css">
    <link rel="stylesheet" href="../common/stylesheets/bootstrap4.css">
    <link rel="stylesheet" href="../common/stylesheets/animate.css">
    <link rel="stylesheet" href="../common/stylesheets/style.css">
    <link rel="stylesheet" href="../common/stylesheets/style1.css">
    <link rel="icon" type="image/png" href="../common/images/favicon-32x32.png" sizes="32x32" />
    <title>Wetrats - Competições</title>
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

if ($nivel_usuario != 3){
    $_SESSION['ALERTA']= "Acesso não permitido!"; 
    header("Location: ../index.php"); exit;
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
      <form method="post" enctype="multipart/form-data" action="upload_resultado.php" class="col col-md-12">

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

        <h1>Upload de Resultado</h1>
        <p>Selecione a competição e o arquivo contendo o resultado geral.</p>
        <hr>

        <div class="container_form_senha">
        <div class="row form-group">
            <div class="col-12">
                <label for="competicao"><b>Competição:</b></label>
                <select class="form-control"  name="competicao">
                <?php

                // Conexão com o servidor MySQL
                require_once '../db_con.php';

                //busca pelos nomes das competicoes cadastrados no sistema e ativas
                $sql = "SELECT id , evento FROM competicoes ORDER BY data DESC ";
                $resultado = mysqli_query($con,$sql);
                while($row = mysqli_fetch_assoc($resultado)){
                    $evento = $row['evento'] ;
                    $eventoid = $row['id'];
                    echo '<option value ="'.$evento.'">'.$evento.'</option>' ;
                }

                ?>
                </select>
            </div>
        </div>


        <div class="row form-group">
        <div class="col-12">
                <label for="resultado"><b>Resultado:</b></label>
                <input class="form-control" type="file" placeholder="Selecione um arquivo" name="resultado" accept="application/pdf"  >
        </div>
        </div>             
        

        <div class="row" style="margin-top:15px;">
          <div class="form-group col-3">
            <a href="./index.php"><button type="button" class="btn btn-primary">Cancelar</button></a>
          </div>
          <div class="form-group col-3">
            <button type="submit" class="btn btn-primary">Enviar</button>
          </div>
        </div>
      </div>
    </form>
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
<?php
if ($_POST){
  //seleciona a competição
  $competicao = $_POST['competicao']; 


  //tratamento do arquivo a ser upado
  if (isset ($_FILES['resultado'])){
  $file = $_FILES['resultado']['name'];
  $ext = explode(".", $file);
  $extensao = end($ext);
  if (strlen($extensao) > 0) { //verifica se não esta gravando um arquivo vazio 
    $novo_nome = "$competicao"."."."$extensao";
    $diretorio = "../common/uploads/resultados/";
    if(!move_uploaded_file ($_FILES['resultado']['tmp_name'], $diretorio."$novo_nome")){
        $_SESSION['ALERTA'] = "Falha no upload do arquivo!" ;
        echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
        echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './upload_resultado.php');});</script>";
        //header("Location: ./upload_resultado.php"); exit;
    }
  }
}

  $sql = "UPDATE competicoes SET resultado='$novo_nome' WHERE evento='$competicao' ";
  if (!mysqli_query($con,$sql))
  {
    $_SESSION['ALERTA']= mysqli_error($con);
    echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
    echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './upload_resultado.php');});</script>";
    //header("Location: ./upload_resultado.php"); exit;
  }
  else {
      $_SESSION['MSG'] = "Resultado da competição: "."'$competicao'".", incluído com sucesso." ;
      echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
      echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './upload_resultado.php');});</script>";
      //header("Location: ./upload_resultado.php"); exit;

  }
}

?>
