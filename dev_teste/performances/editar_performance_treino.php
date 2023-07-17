<html lang="pt-BR">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
    <link rel="stylesheet" href="../common/stylesheets/bootstrap.css">
    <link rel="stylesheet" href="../common/stylesheets/bootstrap4.css">
    <link rel="stylesheet" href="../common/stylesheets/animate.css">
    <link rel="stylesheet" href="../common/stylesheets/style.css">
    <link rel="stylesheet" href="../common/stylesheets/style1.css">
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
  $apelido_usuario= $_SESSION['APELIDO'];
  $nivel_usuario = $_SESSION['NIVEL'];

  //coleta das informações do treino a ser editada a performance
    if(strlen($_GET['id'])>0){
        $id = $_GET['id'];
        $form = "editar_performance_treino.php?id=".$id;
        $con = mysqli_connect("auth-db213.hstgr.io", "u418844475_wtr", "Wetrats2019", "u418844475_wtr");
        $sql= "SELECT id_treino, estilo, metragem, tempo, bracadas, frequencia, intensidade,  resultados_treinos.tipo AS 'tipo', treinos.data AS 'data' , treinos.serie_controle AS 'serie_controle' 
               FROM `resultados_treinos`
               INNER JOIN `treinos` ON resultados_treinos.id_treino = treinos.id 
               WHERE resultados_treinos.id=".$id ;
        
        $resultado = mysqli_query($con,$sql);
        if ($resultado){
            while ($row = mysqli_fetch_assoc($resultado)){
                $data = $row['data'];
                $serie = $row['serie_controle'];
                $tipo = $row['tipo'];
                $id_treino = $row['id_treino'];
                $estilo = $row['estilo'];
                $metragem = $row['metragem'];
                $tempo = $row['tempo'];
                $bracadas = $row['bracadas'];
                $frequencia = $row['frequencia'];
                $intensidade = $row['intensidade'];
            }
        }
    }
?>  


<body>
<div id="page">
  <nav class="fh5co-nav" id="menu-list" role="navigation">
      <div id="menu"></div>
  </nav>
  <div class="container-fluid" style="padding-top:60px;">
    <div class="row">
      <form method="post" action="<?php echo $form ;?>" class="col-12">

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
      <div class="row">
        <div class="section_title light">
            <h1>Edição de performance no treino</h1>
        </div>
      </div>
       
        <p style="color: #000000;">Preencha os campos para editar sua performance no treino.</p>
        <hr>
        
        <?php

        $date=date_create($data);

            echo 
        '
        <div class="container_form">
        <div class="row form-group">
            <div class ="col-12">
            <h1>Treino do dia : '.date_format($date,"d/m/Y").'</h1>
        <p style="color: #000000;">Descrição da série:'."$serie".'</p>' ;
        

            if($tipo == 'Tiro' or $tipo=='Melhor media'){
            $html='
            <div class="col-md-2 col-sm-3">       
                <label for="estilo"><b>Estilo :</b></label>
                    <select class="form-control" name="estilo">
                        <option value="Borboleta"'; if($estilo=='Borboleta') $html .= "selected" ; $html .= '>Borboleta</option>
                        <option value="Costas"'; if($estilo=='Costas') $html .= "selected" ; $html .= ' >Costas</option> 
                        <option value="Peito"'; if($estilo=='Peito') $html .= "selected" ; $html .= ' >Peito</option>
                        <option value="Livre"'; if($estilo=='Livre') $html .= "selected" ; $html .= ' >Livre</option>
                        <option value="Medley"'; if($estilo=='Medley') $html .= "selected" ; $html .= ' >Medley</option>
                    </select>
            </div>

    

            <div class="col-md-2 col-sm-3">       
                <label for="metragem"><b>Metragem :</b></label>
                <input class="form-control" type="number" name="metragem" value="'.$metragem.'" required>
            </div>

            <div class="col-md-2 col-sm-3">       
                <label for="tempo"><b>Tempo :</b></label>
                <input class="form-control" type="text" name="tempo" value='.$tempo.' required>
            </div>

            <div class="col-md-3 col-sm-3">       
                <label for="intensidade"><b>Intensidade do treino :</b></label>
                <input class="form-control" type="number" name="intensidade" value="'.$intensidade.'" required>
            </div>



            ';
            }

            if($tipo == 'BT'){
                $html='
                <div class="col-md-3 col-sm-3">       
                    <label for="estilo"><b>Estilo :</b></label>
                        <select class="form-control" name="estilo">
                            <option value="Borboleta"'; if($estilo=='Borboleta') $html .= "selected" ; $html .= '>Borboleta</option>
                            <option value="Costas"'; if($estilo=='Costas') $html .= "selected" ; $html .= ' >Costas</option> 
                            <option value="Peito"'; if($estilo=='Peito') $html .= "selected" ; $html .= ' >Peito</option>
                            <option value="Livre"'; if($estilo=='Livre') $html .= "selected" ; $html .= ' >Livre</option>
                            <option value="Medley"'; if($estilo=='Medley') $html .= "selected" ; $html .= ' >Medley</option>
                        </select>
                </div>

            <div class="col-md-3 col-sm-3">       
                <label for="metragem"><b>Metragem :</b></label>
                <input class="form-control" type="number" name="metragem" value="'.$metragem.'" required>
            </div>

            <div class="col-md-3 col-sm-3">       
                <label for="bracadas"><b>Braçadas :</b></label>
                <input class="form-control" type="number" step="any" name="bracadas" value="'.$bracadas.'" required>
            </div>

            <div class="col-md-3 col-sm-2">       
                <label for="tempo"><b>Tempo :</b></label>
                <input class="form-control" type="text" name="tempo" value="'.$tempo.'" required>
            </div>


            <div class="col-md-3 col-sm-4">      
                <label for="frequencia"><b>Freq. cardíaca :</b></label>
                <input class="form-control" type="number" name="frequencia" value="'.$frequencia.'" required>
            </div>

            <div class="col-md-3 col-sm-3">       
                <label for="intensidade"><b>Intensidade do treino</b></label>
                <input class="form-control" type="number" name="intensidade" value="'.$intensidade.'" required>
            </div>
            ' ;



          }

          echo $html;
        ?>

        </div>
        </div>
        </div>
        <div class="row" style="padding-top:10px"> 
          <div class="form-group col-3 offset-1">
            <a href="../performances/gerenciar_performances.php"><button type="button" class="btn btn-primary">Cancelar</button></a>
          </div>
          <div class="form-group col-3 offset-4">   
            <button type="submit" class="btn btn-primary" name="finalizado" value="1">Editar</button>
          </div>
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
</script>
</body>
</html>

<?php
if (($_POST['finalizado']=="1")){

    if ($tipo == 'Tiro' or $tipo=='Melhor media'){
        $estilo = $_POST['estilo'];
        $metragem = $_POST['metragem'];
        $tempo = str_replace('"' , '\\"' , $_POST['tempo']); //procedimento pra permitir a inclusao de aspas duplas
        $tempo = str_replace("'" , "\\'" , $tempo); // e simples no texto
        $intensidade = $_POST['intensidade'];
        
        //grava as informações no banco de dados
        $sql = "UPDATE `resultados_treinos` SET estilo="."'".$estilo."', metragem='".$metragem."' , tempo='".$tempo."' , intensidade='".$intensidade."' 
                WHERE id=".$id." ;" ;
        if (!mysqli_query($con,$sql)){
            $_SESSION['ALERTA'] = "Error description: ".mysqli_error($con);
            echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
            echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './editar_performance_treino?id=".$id."');});</script>";
            //header("Location: ./editar_performance_treino?id=".$id.'"' ); exit;
        }
        else {
            $_SESSION['MSG'] = "Performance do(a) ".$tipo." do dia: ".date_format($date,"d/m/Y")." alterada com sucesso." ;
            echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
            echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './gerenciar_performances.php');});</script>";
            //header("Location: ./gerenciar_performances.php" ); exit;
        }
    }

    if ($tipo == 'BT'){
        $estilo = $_POST['estilo'];
        $metragem = $_POST['metragem'];
        $bracadas = $_POST['bracadas'];
        $tempo = str_replace('"' , '\\"' , $_POST['tempo']); //procedimento pra permitir a inclusao de aspas duplas
        $tempo = str_replace("'" , "\\'" , $tempo); // e simples no texto
        $frequencia = $_POST['frequencia'];
        $intensidade = $_POST['intensidade'];
        
        //grava as informações no banco de dados
        $sql = "UPDATE `resultados_treinos` SET estilo="."'".$estilo."', metragem='".$metragem."' , tempo='".$tempo."' , 
                intensidade='".$intensidade."' , bracadas='".$bracadas."' , frequencia='".$frequencia."'
                WHERE id=".$id." ;" ;
        if (!mysqli_query($con,$sql)){
            $_SESSION['ALERTA'] = "Error description: ".mysqli_error($con);
            echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
            echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './editar_performance_treino?id=".$id."');});</script>";
            //header("Location: ./editar_performance_treino?id=".$id.'"' ); exit;
        }
        else {
            $_SESSION['MSG'] = "Performance do BT do dia: ".date_format($date,"d/m/Y")." alterada com sucesso." ;
            echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
            echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './gerenciar_performances.php');});</script>";
            //header("Location: ./gerenciar_performances.php" ); exit;
        }
    }
}

?> 