<html lang="pt-BR">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
    <link rel="stylesheet" href="../common/stylesheets/bootstrap.css">
    <link rel="stylesheet" href="../common/stylesheets/bootstrap4.css">
    <link rel="stylesheet" href="../common/stylesheets/animate.css">
    <link rel="stylesheet" href="../common/stylesheets/style.css">
    <link rel="stylesheet" href="../common/stylesheets/style1.css">
    <link rel="icon" type="image/png" href="../common/images/favicon-32x32.png" sizes="32x32" />
    <title>Wetrats - Financeiro</title>
</head>

<body>
<div id="page">
  <nav class="fh5co-nav" id="menu-list" role="navigation">
      <div id="menu"></div>
  </nav>
  <div id="menus"></div>
  
  <div class="container-fluid" style="padding-top:60px;">
    <div class="row">
      <form method="post" action="index.php" class="col-12">

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

      if ($nivel_usuario != 3){
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

    <h1>Nova Cobrança</h1>
    <p>Preencha os campos abaixo para lançar novas cobranças a um ou mais perfis.</p>
    <hr>
    <div class="row">
    <div class="col-4">
      <div class="container_form_nomes">
        <div class="row">
        <div class="col-12">
          <h3><b>Pessoa(s) a serem cobradas</b></h3>
          <hr>
        </div>
        </div>
        <div class="col-12">
        
        <div class="row">
            <a  href ="#" name="btn" onClick="toggle()">Selecionar Todos</a>
        </div>
        <div class="row">
            <a  href ="#" name="btn" onClick="unToggle()">Deselecionar Todos</a>
        </div>      
    <?php
       //Adiciona automaticamente todos os usuários cadstrados no banco de dados
        require_once './db_con.php';
        //$sql = "SELECT id, nome, apelido, email FROM usuarios WHERE ativo='1' AND nivel!='2' ORDER BY nome  ";
        $sql = "SELECT id, nome, apelido, email, pagante FROM usuarios where nivel!='2' and id!='31' and ativo=1 ORDER BY nome  ";
        $resultado = mysqli_query($con,$sql);
        while($row = mysqli_fetch_assoc($resultado)){
          //echo '<div class="row"><label for="'.$row['id'].'"><input style="margin:5px;" type="checkbox" name="nomes[]" id='.$row["id"].' value='.$row["id"].'>'.$row["nome"].'</label></div>' ;
          if($row["pagante"] == 1){
            echo '<div class="row"><label for="'.$row['id'].'"><input style="margin:5px;" type="checkbox" name="nomes[]" id='.$row["id"].' value='.$row["id"].' checked>'.$row["nome"].'</label></div>' ;
          }else{
             echo '<div class="row"><label for="'.$row['id'].'"><input style="margin:5px;" type="checkbox" name="nomes[]" id='.$row["id"].' value='.$row["id"].'>'.$row["nome"].'</label></div>' ;
          }
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
        function unToggle(){
            checkboxes = document.getElementsByName('nomes[]');
            for (var i=0; i<checkboxes.length;i++){
                checkboxes[i].checked = false;
            }
        }
    </script>
        
      </div>
    </div>
  </div>

    <div class="col-8">
    <div class="container_form_dividas">
      <div class="row form-group">
        <div class="col-8">
        <label for="valor"><b>Valor:</b></label>
        R$
        <input class="form-control" type="number" placeholder="Digite o valor da dívida..." name="valor" step="any" required>
        </div>
      </div>
        
      <div class="row form-group">
        <div class="col-8">
        <label for="descrição"><b>Descrição:</b></label>
        <input class="form-control" type="text" placeholder="Digite uma descrição..." name="descricao" required>
        </div>
      </div>

      <div class="row form-group">
            <div  class=" col-sm-12 col-md-8" style="margin-top:4em;">
              <div class="col-sm-6 col-md-6">
                <div class="custom-control custom-radio custom-control-inline">
                  <input class="custom-control-input" type="radio" name="status" id="n1" value="P"> 
                  <label for="n1" class="custom-control-label" style="padding-left:10px;">Pago</label> 
                </div>
              </div>
              <div class="col-sm-6 col-md-6">
                <div class="custom-control custom-radio custom-control-inline">
                  <input class="custom-control-input" type="radio" name="status" id="n2" value="NP" checked> 
                  <label for="n2" class="custom-control-label" style="padding-left:10px;">Não pago</label> 
                </div>
              </div>
            </div>
        </div>

      <div class="row">
            <div class="form-group col-3 offset-6">
              <a href="../financeiro/index.php"><button type="button" class="btn btn-primary">Cancelar</button></a>
            </div>
            <div class="form-group col-3">
              <button type="submit" class="btn btn-primary" name="divida" value="ok">Criar</button>
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
if($_POST['divida']=='ok'){
  //extrai as informações enviadas
  $ids_cobrados = $_POST['nomes'] ;
  $valor = $_POST['valor'] ;
  $descricao = $_POST['descricao'] ;
  $status = $_POST['status'];
  $data = date("Y-m-d H:i:s");
  $sql = "INSERT INTO financeiro (id_devedor,valor,descricao,status, data_criacao) VALUES ";
  foreach ($ids_cobrados as $i){
    $nome_devedor = $usuarios[$i];
    $sql .= "('".$i."','".$valor."','".$descricao."','".$status."','".$data."' )," ;
  }
  $sql = substr($sql, 0, -1);
  $sql .= ";" ;
  if(!mysqli_query($con,$sql))
  {
    $_SESSION['ALERTA'] .= "Error description: ".mysqli_error($con);
  }
  
  else $_SESSION['MSG'] = "As cobranças foram lançadas com sucesso.";

  //configuraçoes para o envio de emails
  $headers  = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
  $headers .= 'From: contato@wetrats.com.br' ;

  //envia um email para cada usuario que receber o lançamento de uma cobrança
  foreach($ids_cobrados as $i){
      $email_devedor = $emails[$i];
      $apelido_devedor = $apelidos[$i];
      $assunto = "Cobrança:  "."$descricao";
      $mensagem = "<h1 style='color:#242b56; background-color:#ffbb00;'>Olá "."$apelido_devedor"."!</h1> <hr> <br> 
                   <h2>Foi adicionada uma cobrança em seu nome no valor de: R$".number_format($valor,2)."</h2> <br> 
                   <h3>Referente a: "."$descricao"."</h3><br>
                   <hr>
                   <p>Atenciosamente, <br> seus DMs!</p>";
      if(!mail($email_devedor,$assunto,$mensagem,$headers)){
          $_SESSION['ALERTA'] .= "Falha no envio do email para: "."$email_devedor";         
      }
  
  }
  echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
  echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './');});</script>";
  //header("Location: ./index.php");exit;
}
?>