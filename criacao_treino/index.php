<html lang="pt-BR">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
    <link rel="stylesheet" href="../common/stylesheets/bootstrap.css">
    <link rel="stylesheet" href="../common/stylesheets/bootstrap4.css">
    <link rel="stylesheet" href="../common/stylesheets/animate.css">
    <link rel="stylesheet" href="../common/stylesheets/style.css">
    <link rel="stylesheet" href="../common/stylesheets/style1.css">
    <link rel="icon" type="image/png" href="../common/images/favicon-32x32.png" sizes="32x32" />
    <title>Wetrats - Treino</title>
</head>
<?php 
//Inicia uma sessão
session_start();
require_once '../treinos/grupos.php';
    
// Verifica se existe ID da sessão
if(!isset($_SESSION['ID'])){

//Destrói a sessão por segurança
session_destroy();

//Redireciona para o login
header("Location: ../index.php"); exit;
}

$id_usuario = $_SESSION['ID'];
$nivel_usuario = $_SESSION['NIVEL'];

if ($nivel_usuario!='2'){
    $_SESSION['ALERTA']= "Acesso não permitido!"; 
    header("Location: ../index.html"); exit;
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
      <form method="post" enctype="multipart/form-data" action="index.php" class="col col-md-12">

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

        <h1>Novo Treino</h1>
        <p>Preencha os campos abaixo para enviar um novo treino.</p>
        <hr>

        <div class="container_form">
        <div class="row form-group">
        <div class="col col-md-6">
            <label for="data"><b>Data:</b></label>
            <input class="form-control" type="date" placeholder="Insira a data..." name="data"  required>
        </div>
        </div>

        <?php
        bloco_treino_grupo('', 'Grupo 1', array('A1' => 0, 'A2' => 0, 'A3' => 0, 'AN' => 0, 'FO' => 0), true);
        // O treinador das 17h usa outra tabela e não tem Grupo 2
        if ($id_usuario != 81) {
        ?>
        <hr style="border-top:4px solid #0f0f36; margin-top:30px;">
        <p>Opcional: preencha apenas se houver um segundo treino neste dia.</p>
        <?php
        bloco_treino_grupo('_g2', 'Grupo 2', array('A1' => 0, 'A2' => 0, 'A3' => 0, 'AN' => 0, 'FO' => 0), false);
        }
        ?>
      </div>                 
        

        <div class="row" style="padding-top:20px;">
            <div class="form-group col-3 offset-6">
            <a href="../treinos/index.php"><button type="button" class="btn btn-primary">Cancelar</button></a>
            </div>
            <div class="form-group col-3">
                <button type="submit" class="btn btn-primary">Criar</button>
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
  //extrai as informações enviadas
  $data = $_POST['data'];
  $treino = $_POST['treino'];
  $treino = str_replace('"' , 's' , $_POST['treino']); //procedimento pra permitir a inclusao de aspas duplas
  $treino = str_replace("'" , "min" , $treino); // e simples no texto
  $serie_controle = $_POST['serie_controle'];
  $tipo = $_POST['tipo'];
  $total = $_POST['total'];
  $A1 = $_POST['A1'];
  $A2 = $_POST['A2'];
  $A3 = $_POST['A3'];
  $AN = $_POST['AN'];
  $FO = $_POST['FO'];

  date_default_timezone_set('America/Sao_Paulo');
  $hoje=date($data);

  include '../preparacao_fisica/prog_semanas.php';
  $semana_atual = acha_semana($hoje);

  if(date('l', strtotime($hoje)) == "Monday"){
      $dia_s = 1;
  }elseif (date('l', strtotime($hoje)) == "Tuesday") {
      $dia_s = 2;
  }elseif (date('l', strtotime($hoje)) == "Wednesday") {
      $dia_s = 3;
  }elseif (date('l', strtotime($hoje)) == "Thursday") {
      $dia_s = 4;
  }elseif (date('l', strtotime($hoje)) == "Friday") {
      $dia_s = 5;
  }elseif (date('l', strtotime($hoje)) == "Saturday") {
      $dia_s = 6;
  }elseif (date('l', strtotime($hoje)) == "Sunday") {
      $dia_s = 7;
  }



  //tratamento da foto do treino a ser upada
  $novo_nome = salva_foto_treino('foto', $data, '');
  if ($novo_nome === null) $novo_nome = '';
  
  //conexao e envio de informaçoes ao banco de dados
  require_once '../db_con.php';
  $tabela ="treinos";
  //Se for o treinador das 17
  if($_SESSION['ID']==81){
    $tabela = "treinos_17";
  }
  $sql = "INSERT INTO ".$tabela." (data,nome_foto,treino,serie_controle,tipo, total,A1,A2,A3,AN,FO, dia_semana, semana) VALUES ("."'$data'".","."'$novo_nome'".","."'$treino'".","."'$serie_controle'".","."'$tipo'".",".$total.",".$A1.",".$A2.",".$A3.",".$AN.",".$FO.",".$dia_s.",".$semana_atual.")";
  $sql2 = "SELECT id FROM treinos ORDER BY id DESC limit 1";
 
  if (!mysqli_query($con,$sql)){
    $_SESSION['ALERTA']= mysqli_error($con);
    $_SESSION['ALERTA'].="Contate o DM." ;
    echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
    echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './');});</script>";
    //header("Location: ./index.php"); exit;
  }
  else {
      $id_novo = mysqli_insert_id($con);
      if($_SESSION['ID']!=81){
        //se não for o treinador das 17
        $query_id=mysqli_query($con, $sql2);
        $id = mysqli_fetch_assoc($query_id);    
        $sql3 = "INSERT INTO pse (id_treino, resp_s, ses, resp_d, descs) VALUE (".$id['id'].", 0, 0, 0, 0)";
        $pse_query = mysqli_query($con, $sql3);
      }
      $_SESSION['MSG'] = "Treino do dia ".date_format(date_create($data),"d/m/Y")." incluído com sucesso." ;
      //treino opcional do Grupo 2
      if($_SESSION['ID']!=81 && grupo2_preenchido()){
        if (!salva_grupo2($con, $id_novo, $data)){
          $_SESSION['ALERTA'] = "O treino do Grupo 1 foi salvo, mas não foi possível salvar o do Grupo 2. Contate o DM.";
        }
      }
      echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
      echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', '../treinos/');});</script>";
      //header("Location: ../treinos/index.php"); exit;
  }
}

?>
