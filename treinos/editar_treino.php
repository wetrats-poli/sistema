<html lang="pt-BR">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
    <link rel="stylesheet" href="../common/stylesheets/bootstrap.css">
    <link rel="stylesheet" href="../common/stylesheets/bootstrap4.css">
    <link rel="stylesheet" href="../common/stylesheets/animate.css">
    <link rel="stylesheet" href="../common/stylesheets/style.css">
    <link rel="stylesheet" href="../common/stylesheets/style1.css">
    <link rel="icon" type="image/png" href="../common/images/favicon-32x32.png" sizes="32x32" />
    <title>Wetrats - Treinos</title>
</head>
<?php 
//Inicia uma sessão
session_start();
require_once '../db_con.php';
require_once './grupos.php';

// Verifica se existe ID da sessão
if(!isset($_SESSION['ID'])){

//Destrói a sessão por segurança
session_destroy();

//Redireciona para o login
header("Location: ../index.php"); exit;
}

$id_usuario = $_SESSION['ID'];
$nivel_usuario = $_SESSION['NIVEL'];

//coleta das informações do treino a ser editado
if(isset($_GET['id'])) {
    $id_treino = $_GET['id'];
    $_SESSION['id_treino']=$id_treino;
    $tabela = "treinos";
    if($_SESSION['ID']==81){
      $tabela = "treinos_17";
    }
    $sql= "SELECT * FROM ".$tabela." WHERE id=".$id_treino ;
    $resultado = mysqli_query($con,$sql);
    if ($resultado){
        while ($row = mysqli_fetch_assoc($resultado)){
            $data = $row['data'];
            $_SESSION['foto'] = $row['nome_foto'];
            $treino = $row['treino'];
            $serie = $row['serie_controle'];
            $tipo = $row['tipo'];
            $total = $row['total'];
            $A1 = $row['A1'];
            $A2 = $row['A2'];
            $A3 = $row['A3'];
            $AN = $row['AN'];
            $FO = $row['FO'];
        }
    }
    else{
        $_SESSION['ALERTA'] = "Treino inexistente.";
        echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
        echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './');});</script>";
        //header("Location: ./index.php"); exit;
    }
}

//treino opcional do Grupo 2 (o treinador das 17h não tem)
$g2 = (isset($id_treino) && $id_usuario != 81) ? carrega_grupo2($con, $id_treino) : null;

if ($nivel_usuario!="2" and $nivel_usuario!="3"){
    $_SESSION['ALERTA']="Acesso não permitido!"; 
    echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
        echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', '../');});</script>";
    //header("Location: ../index.php"); exit;
}

?>

<body>
<div id="page">
  <nav class="fh5co-nav" id="menu-list" role="navigation">
      <div id="menu"></div>
  </nav>
  <div id="menus"></div>

  <div class="container-fluid" style="padding-top:60px;">
  <div class = "container_form">
    <div class="row">
      <form method="post" enctype="multipart/form-data" action="editar_treino.php" class="col col-md-12">

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
        <!-----FORM------>
        <h1>Edição treino</h1>
        <p>Altere os campos abaixo que desejar para editar o treino existente.</p>
        <hr>


        <div class="row form-group">
        <div class="col col-md-6">
            <label for="data"><b>Data:</b></label>
            <input class="form-control" type="date" placeholder="Insira a data..." name="data" value="<?php echo $data?>" required>
        </div>
        </div>

        <?php
        bloco_treino_grupo('', 'Grupo 1', array('treino' => $treino, 'serie_controle' => $serie, 'tipo' => $tipo, 'total' => $total,
                           'A1' => $A1, 'A2' => $A2, 'A3' => $A3, 'AN' => $AN, 'FO' => $FO), true);
        // O treinador das 17h usa outra tabela e não tem Grupo 2
        if ($id_usuario != 81) {
        ?>
        <hr style="border-top:4px solid #0f0f36; margin-top:30px;">
        <p>Opcional: preencha apenas se houver um segundo treino neste dia.</p>
        <?php
        bloco_treino_grupo('_g2', 'Grupo 2', $g2 ? $g2 : array('A1' => 0, 'A2' => 0, 'A3' => 0, 'AN' => 0, 'FO' => 0), false);
        if ($g2) {
            if (strlen($g2['nome_foto']) > 3) echo '<p>Foto atual do Grupo 2: <a href="../common/uploads/treinos/'.htmlspecialchars($g2['nome_foto']).'"><u>Visualizar</u></a> (enviar uma nova foto substitui a atual)</p>';
            echo '<div class="form-group"><label><input type="checkbox" name="remover_g2" value="1"> <b>Remover o treino do Grupo 2</b></label></div>';
        }
        }
        ?>
        </div>
        

        <div class="row" >
            <div class="form-group col-sm-2 col-sm-push-10 col-md-2 col-md-push-10">
                <a href="../treinos/index.php"><button type="button" class="btn btn-primary">Cancelar</button></a>
            </div>
            <div class="form-group col-sm-2 col-sm-push-7 col-md-2 col-md-push-9">
                <button type="submit" class="btn btn-primary" name="editar_treino" value="<?php echo $id_treino ?>">Editar</button>
            </div>
        </div>
    </form>
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
<?php
if (isset($_POST['editar_treino'])){
  //extrai as informações enviadas
  $data = $_POST['data'] ;
  $treino = $_POST['treino'] ;
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
  $date = date_create($data); 
 

  //tratamento da foto do treino a ser upada
  $novo_nome = salva_foto_treino('foto', $data, '');
  if ($novo_nome === null) $novo_nome = $_SESSION['foto'];

  $tabela = "treinos";
  if($_SESSION['ID']==81){
    $tabela = "treinos_17";
  }
  //conexao e envio de informaçoes ao banco de dados
  $sql = " UPDATE ".$tabela." SET data = '$data' , nome_foto = '$novo_nome' , treino = '$treino' , serie_controle = '$serie_controle' , tipo = '$tipo', total = $total,A1 = $A1,A2=$A2,A3=$A3,AN=$AN,FO=$FO WHERE id=".$_SESSION['id_treino'] ;
  echo $sql;
  if (!mysqli_query($con,$sql)){
    $_SESSION['ALERTA']= mysqli_error($con);
    $_SESSION['ALERTA'].= $sql;
    echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
    echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './');});</script>";
    //header("Location: ./index.php"); exit;
  }
  else {
      $_SESSION['MSG'] = "Treino do dia ".date_format($date,("d/m/Y"))." editado com sucesso." ;
      //treino opcional do Grupo 2
      if($_SESSION['ID']!=81){
        $id_edit = (int)$_SESSION['id_treino'];
        $g2_atual = carrega_grupo2($con, $id_edit);
        if (isset($_POST['remover_g2'])){
          if ($g2_atual) consulta_segura($con, "DELETE FROM treinos_grupo2 WHERE id_treino=".$id_edit);
        }
        elseif (grupo2_preenchido($g2_atual ? $g2_atual['nome_foto'] : '')){
          if (!salva_grupo2($con, $id_edit, $data)){
            $_SESSION['ALERTA'] = "O treino do Grupo 1 foi salvo, mas não foi possível salvar o do Grupo 2. Contate o DM.";
          }
        }
      }
      echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
      echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './');});</script>";
      //header("Location: ./index.php"); exit; 
  } 
} 

?> 
