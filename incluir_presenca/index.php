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
  $apelido_usuario= $_SESSION['APELIDO'];
  $nivel_usuario = $_SESSION['NIVEL'];

  $data_treino = $_GET['data'];

  $id_treino = $_GET['id'];

  $link="index.php?id=".$id_treino.'&data='.$data_treino ;

  // Conexão com o servidor MySQL
  $con = mysqli_connect("auth-db213.hstgr.io", "u418844475_wtr", "Wetrats2019", "u418844475_wtr");

  $sql = "SELECT id_atleta FROM `presencas` WHERE id_treino=".$id_treino.";" ;
  $resultado = mysqli_query($con,$sql);
  $presentes = array();
  while($row=mysqli_fetch_assoc($resultado)){
    $presentes[]=$row['id_atleta'];
  }

  $execucao = array();
  $ced_aquec = array();
  $ced_princ = array();
  $comportamento = array();
  $negativo = array();

  $sql = "SELECT id_atleta, execucao, ced_aquec, ced_princ, comportamento, justificativa, outro_horario, feedback, negativo FROM `pontuacaoX` WHERE id_treino=".$id_treino.";" ;
  $resultado = mysqli_query($con,$sql);
  $execucao = array();
  while($row=mysqli_fetch_assoc($resultado)){
    if($row['execucao']!= null)$execucao[]=$row['id_atleta'];
    if($row['ced_aquec']!= null)$ced_aquec[]=$row['id_atleta'];
    if($row['ced_princ']!= null)$ced_princ[]=$row['id_atleta'];
    if($row['comportamento']!= null)$comportamento[]=$row['id_atleta'];
    if($row['justificativa']!= null)$justificativa[]=$row['id_atleta'];
    if($row['outro_horario']!= null)$outro_horario[]=$row['id_atleta'];
    if($row['feedback']!= null)$feedback[]=$row['id_atleta'];
    if($row['negativo']!= null)$negativo[]=$row['id_atleta'];  
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
      <form method="post" action=<?php echo $link;?> class="col-md-12">

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
      
        <h1>Inclusão de presença no treino</h1>
        <p>Escolha a data do treino e selecione os atletas que estiveram presentes.</p>
        <hr>
        
        
        <div class="container_adicionar_presenca">
          <div class="row">
          <div class="col-12">
          
          <h2>Feminino</h2>
          <div>
          <table class= "tabela_addpresenca">
            <thead>
              <tr>
              <th>Nome</th>
              <th>Presença</th>
              <th>Executou tudo? (1.0)</th>
              <th>C&D Aquecimento (1.0)</th>
              <th>C&D Principal (1.5)</th>
              <th>Comportamento (1.5)</th>
              <th>Justificativa (1.0)</th>
              <th>Outro horário (1.5)</th>
              <th>Feedback (1.5) </th> 
              <th>Ponto Negativo (-5)</th>
              </tr>
            </thead>
            <tbody>

            
          </div>
          <?php

              // Conexão com o servidor MySQL
              $con = mysqli_connect("auth-db213.hstgr.io", "u418844475_wtr", "Wetrats2019", "u418844475_wtr");

              //busca pelos nomes dos atletas cadastrados no sistema e ativos
              $sql = "SELECT id, apelido, email FROM usuarios WHERE sexo ='F' AND ativo='1' ORDER BY apelido  ";
              $resultado = mysqli_query($con,$sql);
              while($row = mysqli_fetch_assoc($resultado)){
                echo '
                <tr>
                  <td>'.$row['apelido'].'</td>
                  <td><input type="checkbox" name="presencas[]" id='.$row["id"].' value="'.$row["id"].'"'; if (in_array($row['id'],$presentes)) echo "checked"; echo '></td>
                  <td><input type="checkbox" name="execucao[]" id=exec'.$row["id"].' value="'.$row["id"].'"'; if (in_array($row['id'],$execucao)) echo "checked"; echo '></td>
                  <td><input type="checkbox" name="ced_aquec[]" id=ced_aquec'.$row["id"].' value="'.$row["id"].'"'; if (in_array($row['id'],$ced_aquec)) echo "checked"; echo '></td>
                  <td><input type="checkbox" name="ced_princ[]" id=ced_princ'.$row["id"].' value="'.$row["id"].'"'; if (in_array($row['id'],$ced_princ)) echo "checked"; echo '></td>
                  <td><input type="checkbox" name="comportamento[]" id=comportamento'.$row["id"].' value="'.$row["id"].'"'; if (in_array($row['id'],$comportamento)) echo "checked"; echo '></td>
                  <td><input type="checkbox" name="justificativa[]" id=justificativa'.$row["id"].' value="'.$row["id"].'"'; if (in_array($row['id'],$justificativa)) echo "checked"; echo '></td>
                  <td><input type="checkbox" name="outro_horario[]" id=outro_horario'.$row["id"].' value="'.$row["id"].'"'; if (in_array($row['id'],$outro_horario)) echo "checked"; echo '></td>
                  <td><input type="checkbox" name="feedback[]" id=feedback'.$row["id"].' value="'.$row["id"].'"'; if (in_array($row['id'],$feedback)) echo "checked"; echo '></td>
                  <td><input type="checkbox" name="negativo[]" id=negativo'.$row["id"].' value="'.$row["id"].'"'; if (in_array($row['id'],$negativo)) echo "checked"; echo '></td>
                </tr>' ;
                $emails[$row["id"]] = $row['email'];
                $apelidos[$row["id"]] = $row['apelido'];
              }
          ?>
          </tbody>
          </table>
          </div>
          
          <script language="JavaScript">
                  function toggle_presencas(){
                  checkboxes = document.getElementsByName('presencas[]');
                  for (var i=0; i<checkboxes.length;i++){
                      checkboxes[i].checked = true;
                    }
                  }
                  function toggle_execucao(){
                  checkboxes = document.getElementsByName('execucao[]');
                  for (var i=0; i<checkboxes.length;i++){
                      checkboxes[i].checked = true;
                    }
                  }
                  function toggle_ced_aquec(){
                  checkboxes = document.getElementsByName('ced_aquec[]');
                  for (var i=0; i<checkboxes.length;i++){
                      checkboxes[i].checked = true;
                    }
                  }
                  function toggle_ced_princ(){
                  checkboxes = document.getElementsByName('ced_princ[]');
                  for (var i=0; i<checkboxes.length;i++){
                      checkboxes[i].checked = true;
                    }
                  }
                  function toggle_comportamento(){
                  checkboxes = document.getElementsByName('comportamento[]');
                  for (var i=0; i<checkboxes.length;i++){
                      checkboxes[i].checked = true;
                    }
                  }

                  function toggle_justificativa(){
                  checkboxes = document.getElementsByName('justificativa[]');
                  for (var i=0; i<checkboxes.length;i++){
                      checkboxes[i].checked = true;
                    }
                  }

                  function toggle_outro_horario(){
                  checkboxes = document.getElementsByName('outro_horario[]');
                  for (var i=0; i<checkboxes.length;i++){
                      checkboxes[i].checked = true;
                    }
                  }

                  function toggle_feedback(){
                  checkboxes = document.getElementsByName('feedback[]');
                  for (var i=0; i<checkboxes.length;i++){
                      checkboxes[i].checked = true;
                    }
                  }
                  function toggle_negativo(){
                  checkboxes = document.getElementsByName('negativo[]');
                  for (var i=0; i<checkboxes.length;i++){
                      checkboxes[i].checked = true;
                    }
                  }
          </script>
          
          <div style="padding: 10px;"></div>
          <h2>Masculino</h2>
          
          <table class= "tabela_addpresenca">
            <thead>
              <tr>
              <th>Nome</th>
              <th>Presença</th>
              <th>Executou tudo? (1.0)</th>
              <th>C&D Aquecimento (1.0)</th>
              <th>C&D Principal (1.5)</th>
              <th>Comportamento (1.5)</th>
              <th>Justificativa (1.0)</th>
              <th>Outro horário (1.5)</th>
              <th>Feedback (1.5)</th> 
              <th>Ponto Negativo (-5)</th>
              </tr>
            </thead>
            <tbody>

            
          <?php

              // Conexão com o servidor MySQL
              $con = mysqli_connect("auth-db213.hstgr.io", "u418844475_wtr", "Wetrats2019", "u418844475_wtr");

              //busca pelos nomes dos atletas cadastrados no sistema e ativos
              $sql = "SELECT id, apelido, email FROM usuarios WHERE sexo ='M' AND ativo='1' ORDER BY apelido  ";
              $resultado = mysqli_query($con,$sql);
              while($row = mysqli_fetch_assoc($resultado)){
                echo '
                <tr>
                  <td>'.$row['apelido'].'</td>
                  <td><input type="checkbox" name="presencas[]" id='.$row["id"].' value="'.$row["id"].'"'; if (in_array($row['id'],$presentes)) echo "checked"; echo '></td>
                  <td><input type="checkbox" name="execucao[]" id=exec'.$row["id"].' value="'.$row["id"].'"'; if (in_array($row['id'],$execucao)) echo "checked"; echo '></td>
                  <td><input type="checkbox" name="ced_aquec[]" id=ced_aquec'.$row["id"].' value="'.$row["id"].'"'; if (in_array($row['id'],$ced_aquec)) echo "checked"; echo '></td>
                  <td><input type="checkbox" name="ced_princ[]" id=ced_princ'.$row["id"].' value="'.$row["id"].'"'; if (in_array($row['id'],$ced_princ)) echo "checked"; echo '></td>
                  <td><input type="checkbox" name="comportamento[]" id=comportamento'.$row["id"].' value="'.$row["id"].'"'; if (in_array($row['id'],$comportamento)) echo "checked"; echo '></td>
                  <td><input type="checkbox" name="justificativa[]" id=justificativa'.$row["id"].' value="'.$row["id"].'"'; if (in_array($row['id'],$justificativa)) echo "checked"; echo '></td>
                  <td><input type="checkbox" name="outro_horario[]" id=outro_horario'.$row["id"].' value="'.$row["id"].'"'; if (in_array($row['id'],$outro_horario)) echo "checked"; echo '></td>
                  <td><input type="checkbox" name="feedback[]" id=feedback'.$row["id"].' value="'.$row["id"].'"'; if (in_array($row['id'],$feedback)) echo "checked"; echo '></td>
                  <td><input type="checkbox" name="negativo[]" id=negativo'.$row["id"].' value="'.$row["id"].'"'; if (in_array($row['id'],$negativo)) echo "checked"; echo '></td>
                </tr>' ;
                $emails[$row["id"]] = $row['email'];
                $apelidos[$row["id"]] = $row['apelido'];
              }
          ?>
          </tbody>
          </table>
          <div style="padding:10px;"></div>
          </div>
        </div>
        </div>
        <div class="row" style="padding: 10px; padding-left: 95px;">
          <div class="form-group col-12">
            <label for="duracao">Qual foi a duração do treino?<input type="text" name="duracao" id="duracao" style="margin-left: 10px;" required></label>
          </div>
        </div>
        <div class="row" style="padding: 10px;">
          <div class="form-group col-6">
            <a href="../treinos/index.php"><button type="button" class="btn btn-primary">Cancelar</button></a>
          </div>
          <div class="form-group col-6">
            <button type="submit" class="btn btn-primary" name="finalizado" value="1">Enviar</button>
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

    // Conexão com o servidor MySQL
    $con = mysqli_connect("auth-db213.hstgr.io", "u418844475_wtr", "Wetrats2019", "u418844475_wtr");

    $data = $_GET['data'];

    include '../preparacao_fisica/prog_semanas.php';
    date_default_timezone_set('America/Sao_Paulo');
    //$hoje=date("Y-m-d");
    $semana = acha_semana($data);

    if(date('l', strtotime($data)) == "Monday"){
        $dia_semana = 1;
    }elseif (date('l', strtotime($data)) == "Tuesday") {
        $dia_semana = 2;
    }elseif (date('l', strtotime($data)) == "Wednesday") {
        $dia_semana = 3;
    }elseif (date('l', strtotime($data)) == "Thursday") {
        $dia_semana = 4;
    }elseif (date('l', strtotime($data)) == "Friday") {
        $dia_semana = 5;
    }elseif (date('l', strtotime($data)) == "Saturday") {
        $dia_semana = 6;
    }elseif (date('l', strtotime($data)) == "Sunday") {
        $dia_semana = 7;
    }

    $id_treino = $_GET['id'];

    $sql = "DELETE FROM `presencas` WHERE id_treino=".$id_treino;
    if (mysqli_query($con,$sql)){

        $ids_atletas = $_POST['presencas'] ;
        $sql = "INSERT INTO presencas (id_treino, id_atleta) VALUES ";
        $sql2= "INSERT INTO duracao_agua (id_atleta, duracao, dia_semana, semana) VALUES ";
        foreach ($ids_atletas as $i){
            $sql .= "(".$id_treino.",".$i." )," ;
            $sql2 .= "(".$i.",".$_POST['duracao'].",".$dia_semana.",".$semana."),";
        }
        $sql = substr($sql, 0, -1);
        $sql .= ";" ;
        $sql2 = substr($sql2, 0, -1);
        $sql2 .= ";" ;

        if($_SESSION['ID'] == 32){
          mysqli_query($con, $sql2);
        }
    
        if (!mysqli_query($con,$sql)){
            $_SESSION['ALERTA'] .= "Error description: ".mysqli_error($con);
            echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
            echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', '../incluir_presenca/'".$link."');});</script>";
            //header("Location: ../incluir_presenca/".$link); exit;
        } 
        else {
          $_SESSION['MSG'] = "A presença do dia ".date_format($data,"d/m/Y")." foi incluída com sucesso.";
          
          $sql = "DELETE FROM `pontuacaoX` WHERE id_treino=".$id_treino;
          if (mysqli_query($con,$sql)){
            $ids_atletas = $_POST['presencas'];
            foreach($_POST['justificativa'] as $faltou){
              if(!in_array($faltou, $_POST['presencas']))$ids_atletas[]= $faltou;
            };
            $sql = "INSERT INTO pontuacaoX (id_treino, id_atleta, execucao, ced_aquec, ced_princ, comportamento, justificativa, outro_horario, feedback, negativo) VALUES ";
            foreach ($ids_atletas as $i){
                $sql .= "(".$id_treino.",".$i;
                if(in_array($i, $_POST['execucao'])) $sql.= ",1"; else $sql.= " ,NULL";
                if(in_array($i, $_POST['ced_aquec'])) $sql.= ",1"; else $sql.= " ,NULL";
                if(in_array($i, $_POST['ced_princ'])) $sql.= ",1"; else $sql.= " ,NULL";
                if(in_array($i, $_POST['comportamento'])) $sql.= ",1"; else $sql.= " ,NULL";
                if(in_array($i, $_POST['justificativa'])) $sql.= ",1"; else $sql.= " ,NULL";
                if(in_array($i, $_POST['outro_horario'])) $sql.= ",1"; else $sql.= " ,NULL";
                if(in_array($i, $_POST['feedback'])) $sql.= ",1"; else $sql.= " ,NULL";
                if(in_array($i, $_POST['negativo'])) $sql.= ",1"; else $sql.= " ,NULL";
                $sql.= " )," ;
            }
            $sql = substr($sql, 0, -1);
            $sql .= ";" ;

            if (mysqli_query($con,$sql)){
              $_SESSION['MSG'] = "A presença e pontuação do dia ".date_format($data,"d/m/Y")." foi incluída com sucesso.<br>";
            echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
            echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', '../treinos');});</script>";
            //header("Location: ../treinos/index.php"); exit;
          }else{
            $_SESSION['ALERTA'] .= "Error description: ".mysqli_error($con);
            echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
            echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', '../incluir_presenca/'".$link."');});</script>";
            //header("Location: ../incluir_presenca/".$link); exit;
          }
        
        }

        else {
          $_SESSION['ALERTA'] .= "Error description: ".mysqli_error($con);
          echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
          echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', '../incluir_presenca/'".$link."');});</script>";
          //header("Location: ../incluir_presenca/".$link); exit;
        }    
      }
    }
}
    
?>