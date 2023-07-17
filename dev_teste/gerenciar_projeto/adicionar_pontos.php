<html lang="pt-BR">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
    <link rel="stylesheet" href="../common/stylesheets/bootstrap.css">
    <link rel="stylesheet" href="../common/stylesheets/bootstrap4.css">
    <link rel="stylesheet" href="../common/stylesheets/animate.css">
    <link rel="stylesheet" href="../common/stylesheets/style.css">
    <link rel="stylesheet" href="../common/stylesheets/style1.css">
    <link rel="icon" type="image/png" href="../common/images/favicon-32x32.png" sizes="32x32" />
    <title>Wetrats - ProjetoIUSP</title>
</head>

<body>
<div id="page">
  <nav class="fh5co-nav" id="menu-list" role="navigation">
      <div id="menu"></div>
  </nav>
  <div id="menus"></div>
  
  <div class="container-fluid" style="padding-top:60px;">
    <div class="row">
      <form method="post" action="adicionar_pontos.php" class="col-12">

      <?php

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

      if ($nivel_usuario == 1){
        $_SESSION['ALERTA'] = 'Acesso negado!' ;
        header("Location: ../perfil/index.php"); exit;
      }
      //Mensagem de alerta
      if (isset($_SESSION['ALERTA'])){
        if ($_SESSION['ALERTA'] != 'Acesso negado!'){
                echo '<div class="alert alert-danger" role="alert">'.$_SESSION['ALERTA'].'</div>';
                unset($_SESSION['ALERTA']);
        }
      }
      //Mensagens de sucesso
      if (isset($_SESSION['MSG'])){
        echo '<div class="alert alert-success" role="alert">'.$_SESSION['MSG'].'</div>';
        unset($_SESSION['MSG']);
      }
      ?>

    <h1>Adicionar pontos</h1>
    <p>Selecione os campos abaixo para adicionar pontos a um ou mais atletas.</p>
    <hr>
    <div class="row">
    <div class="col-4">
      <div class="container_form_nomes">
        <div class="row">
        <div class="col-12">
          <h3><b>Atletas</b></h3>
          <hr>
        </div>
        </div>
        <div class="col-12">
        
        <div class="row">
        <a  href ="#" name="btn" onClick="toggle()">Selecionar Todos</a>
        </div>      
    <?php
       //Adiciona automaticamente todos os usuários cadstrados no banco de dados
        $conn = mysqli_connect("auth-db213.hstgr.io", "u418844475_wtr", "Wetrats2019", "u418844475_wtr");
        //$sql = "SELECT id, nome, apelido, email FROM usuarios WHERE ativo='1' AND nivel!='2' ORDER BY nome  ";
        $sql = "SELECT id, nome, apelido, email FROM usuarios where nivel!='2' and id!='31' and ativo=1 ORDER BY apelido  ";
        $resultado = mysqli_query($conn,$sql);
        while($row = mysqli_fetch_assoc($resultado)){
          //echo '<div class="row"><label for="'.$row['id'].'"><input style="margin:5px;" type="checkbox" name="nomes[]" id='.$row["id"].' value='.$row["id"].'>'.$row["nome"].'</label></div>' ;
          echo '<div class="row"><label for="'.$row['id'].'"><input style="margin:5px;" type="checkbox" name="nomes[]" id='.$row["id"].' value='.$row["id"].'>'.$row["apelido"].'</label></div>' ;
          $usuarios[$row["id"]] = $row["nome"];
          $apelidos[$row["id"]] = $row["apelido"];
          $emails[$row["id"]] = $row['email'];
        }?>
    <script language="JavaScript">
        function toggle(){
            checkboxes = document.getElementsByName('nomes[]');
            for (var i=0; i<checkboxes.length;i++){
                checkboxes[i].checked = true;
            }
        }
    </script>
        
      </div>
    </div>
  </div>

    <div class="col-8">
    <div class="container_form_dividas">
      <div class="row form-group">
        <div class="col-12">
          <?php
          if($_SESSION['NIVEL'] == 3){
            echo '
              <div class="col-sm-4 col-md-4">
                <div class="custom-control custom-radio custom-control-inline">
                  <input class="custom-control-input" type="radio" name="tipo" id="n1" value="A"> 
                  <label for="n1" class="custom-control-label" style="padding-left:10px;">Academia</label> 
                </div>
              </div>
              <div class="col-sm-4 col-md-4">
                <div class="custom-control custom-radio custom-control-inline">
                  <input class="custom-control-input" type="radio" name="tipo" id="n3" value="C"> 
                  <label for="n3" class="custom-control-label" style="padding-left:10px;">Competição</label> 
                </div>
              </div>
              <div class="col-sm-4 col-md-4">
                <div class="custom-control custom-radio custom-control-inline">
                  <input class="custom-control-input" type="radio" name="tipo" id="n2" value="E" checked> 
                  <label for="n2" class="custom-control-label" style="padding-left:10px;">Extra</label> 
                </div>
              </div>';
          }
          if($_SESSION['NIVEL'] == 2){
              echo '<div class="col-sm-4 col-md-4">
                <div class="custom-control custom-radio custom-control-inline">
                  <input class="custom-control-input" type="radio" name="tipo" id="n2" value="E" checked> 
                  <label for="n2" class="custom-control-label" style="padding-left:10px;">Extra</label> 
                </div>
              </div>';
          }
          ?>
            </div>
        </div>
        </div>
        <hr>
      <div class="row">
            <div class="form-group col-4 offset-3">
              <a href="../gerenciar_projeto/index.php"><button type="button" class="btn btn-primary">Cancelar</button></a>
            </div>
            <div class="form-group col-3">
              <button type="submit" class="btn btn-primary" name="pontos" value="ok">Enviar</button>
            </div>
      </div>
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
if($_POST['pontos']=='ok'){
  //extrai as informações enviadas
  $ids_atletas = $_POST['nomes'] ;
  $tipo = $_POST['tipo'];
  $sql = "INSERT INTO projetoiusp (id_atleta,tipo) VALUES ";
  foreach ($ids_atletas as $i){
    $sql .= "(".$i.",'".$tipo."')," ;
  }
  $sql = substr($sql, 0, -1);
  $sql .= ";" ;
  if(!mysqli_query($conn,$sql)){
    $_SESSION['ALERTA'] .= "Error description: ".mysqli_error($conn);
    echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
    echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './adicionar_pontos.php');});</script>";
  }
  
  else $_SESSION['MSG'] = "Os pontos foram lançados com sucesso.";

  echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
  echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './adicionar_pontos.php');});</script>";
  //header("Location: ./index.php");exit;
}
?>