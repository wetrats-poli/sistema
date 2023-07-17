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
    $con = mysqli_connect("auth-db213.hstgr.io", "u418844475_wtr", "Wetrats2019", "u418844475_wtr");
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

        <div class="row form-group">
        <div class="col-6">
                <label for="foto"><b>Treino:</b></label>
                <input class="form-control" type="file" placeholder="Selecione uma foto" name="foto" value="<?php echo $foto?>" accept="image/*" >
                <textarea class="form-control" type="text" rows="5" placeholder="Ou digite aqui..." name="treino"  ><?php echo $treino?></textarea>
        </div>

        <div class="col-6">
          <div class="row form-group">
              <div class="col-2">
                <label for="A1"><b>A1:</b></label>
                <input class="form-control" type="number" placeholder="A1..." name="A1" value=<?php echo $A1?> required>
              </div>
              <div class="col-2">
                <label for="A2"><b>A2:</b></label>
                <input class="form-control" type="number" placeholder="A2..." name="A2" value=<?php echo $A2?> required>
              </div>
              <div class="col-2">
                <label for="A3"><b>A3:</b></label>
                <input class="form-control" type="number" placeholder="A3..." name="A3" value=<?php echo $A3?> required>
              </div>
              <div class="col-2">
                <label for="AN"><b>AN:</b></label>
                <input class="form-control" type="number" placeholder="AN..." name="AN" value=<?php echo $AN?> required>
              </div>
              <div class="col-2">
                <label for="FO"><b>FO:</b></label>
                <input class="form-control" type="number" placeholder="FO..." name="FO" value=<?php echo $FO?> required>
              </div>

          </div>

                <label for="total"><b>Metragem total:</b></label>
                <input class="form-control" type="number" placeholder="Metragem..." name="total" value=<?php echo $total?> required>
        </div>
        </div>  
        </div>  
            
                
                
        <div class="row" style="padding-left:20px;padding-top:20px;">
            <h2>Série controle</h2>
            <hr>
        </div>
        
        <div class="row form-group">    
            <div class="col-sm-6 col-md-6">
                <label for="serie_controle"><b>Descrição:</b></label>
                <input class="form-control" type="text" placeholder="Insira uma descrição para a série ..." name="serie_controle" value="<?php echo $serie?>">
            </div>

            <div class="col-sm-6 col-md-6">
                <label for="tipo"><b>Tipo:</b></label>
                <select class="form-control"  name="tipo">
                    <option value=" " <?php if($tipo==" ") echo 'selected'?>> </option>
                    <option value ="BT" <?php if($tipo=="BT") echo 'selected'?>>BT</option>
                    <option value ="Tiro" <?php if($tipo=="Tiro") echo 'selected'?>>Tiro</option>
                    <option value ="Melhor media">Melhor média</option>
                    <!--<option value ="Intervalada">Intervalada</option>-->
                </select>
            </div>
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
  if (isset ($_FILES['foto'])){
    $file = $_FILES['foto']['name'];
    $ext = explode(".", $file);
    $extensao = end($ext);
    if (strlen($extensao) > 0) { //verifica se não esta gravando um arquivo vazio 
        $novo_nome = "treino"."$data"."."."$extensao";
        $diretorio = "../common/uploads/treinos/";
        move_uploaded_file ($_FILES['foto']['tmp_name'], $diretorio.$novo_nome);
    }
    else {
        $novo_nome = $_SESSION['foto'];
    }
} 

  else {
    $novo_nome = $_SESSION['foto'];
  }

  $tabela = "treinos";
  if($_SESSION['ID']==81){
    $tabela = "treinos_17";
  }
  //conexao e envio de informaçoes ao banco de dados
  $con = mysqli_connect("auth-db213.hstgr.io", "u418844475_wtr", "Wetrats2019", "u418844475_wtr");
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
      echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
      echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './');});</script>";
      //header("Location: ./index.php"); exit; 
  } 
} 

?> 
