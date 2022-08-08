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

  //coleta das informações do treino a ser incluida performance
    if(strlen($_GET['id'])>0) {
        $id_treino = $_GET['id'];
        $form = "index.php?id=".$id_treino;
        $con = mysqli_connect("auth-db213.hostinger.com.br", "u418844475_wtr", "wetrats2019", "u418844475_wtr");
        $sql= "SELECT data , serie_controle , tipo FROM `treinos` WHERE id=".$id_treino ;
        $resultado = mysqli_query($con,$sql);
        if ($resultado){
            while ($row = mysqli_fetch_assoc($resultado)){
                $data = $row['data'];
                $serie = $row['serie_controle'];
                $tipo = $row['tipo'];
            }
        }
        else{
            $_SESSION['ALERTA'] = "Treino inexistente.";
            echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
            echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './');});</script>";
            //header("Location: ./index.php"); exit;
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
      <form method="post" action="<?php echo $post; ?>" class="col-12">

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
            <h1>Inclusão de performance no treino</h1>
        </div>
      </div>
    
      <p style="color: #000000;">Preencha os campos para incluir sua performance no treino.</p>
      <hr>
      
      <div class="row form-group">
        <?php

        $date=date_create($data);

            echo 
        '<div class="col-3">
        <div class="container_form">
        <div class="row form-group">
            
            <h1>Treino do dia : '.date_format($date,"d/m/Y").'</h1>
            <p style="color: #000000;">Descrição da série:'."$serie".'</p>
        </div>
        </div>
        </div>
        
        <div class="col-9">
            <div class="container_form">' ;
            if ($nivel_usuario=="2"){
                $html='<div class="row form-group">
                        <div class="col-auto">
                            <label>Atleta:</label>
                            <select name="atleta">';
                
                $sql="SELECT id,nome FROM `usuarios` WHERE ativo=1 ORDER BY nome ;";
                $resultado = mysqli_query($con,$sql);
                while($row=mysqli_fetch_assoc($resultado)){
                    $html.='<option value="'.$row['id']."_".$row['nome'].'"';
                    if ($_POST['atleta'] == $row['id']."_".$row['nome']) $html .= 'selected';
                    $html.= '>'.$row['nome'].'</option>';
                }
                $html.='        </select>
                        </div>
                      </div>';
                echo $html;
            }
        

            if($tipo == 'Tiro' or $tipo=="Melhor media"){
            echo '
            
            <div class="row form-group">
            <div class="col-4">       
                <label for="estilo"><b>Estilo :</b></label>
                    <select class="form-control" name="estilo">
                        <option value="Borboleta" >Borboleta</option>
                        <option value="Costas" >Costas</option> 
                        <option value="Peito" >Peito</option>
                        <option value="Livre" >Livre</option>
                        <option value="Medley" >Medley</option>
                    </select>
            </div>

            <div class="col-4">       
                <label for="metragem"><b>Metragem :</b></label>
                <input class="form-control" type="number" name="metragem" required>
            </div>

            <div class="col-4">       
                <label for="tempo"><b>Tempo :</b></label>
                <input class="form-control" type="text" name="tempo" required>
            </div>

            <div class="col-4">       
                <label for="intensidade"><b>Intensidade do treino :</b></label>
                <input class="form-control" type="number" name="intensidade" required>
            </div>

            </div>
            </div>
            </div>
            ';
            }

            if($tipo == 'BT'){
            echo '
            <div class="row form-group">
            <div class="col-4">           
                <label for="estilo"><b>Estilo :</b></label>
                    <select class="form-control" name="estilo">
                        <option value="Livre" >Livre</option>
                        <option value="Borbo" >Borboleta</option>
                        <option value="Costas" >Costas</option> 
                        <option value="Peito" >Peito</option>
                        <option value="Medley" >Medley</option>
                    </select>
            </div>

            <div class="col-4">       
                <label for="metragem"><b>Metragem :</b></label>
                <input class="form-control" type="number" name="metragem" value="50" required>
            </div>

            <div class="col-4">       
                <label for="bracadas"><b>Braçadas :</b></label>
                <input class="form-control" type="number" step="any" name="bracadas" required>
            </div>

            <div class="col-4">       
                <label for="tempo"><b>Tempo :</b></label>
                <input class="form-control" type="text" name="tempo" required>
            </div>
        


            <div class="col-4">       
                <label for="frequencia"><b>Freq. cardíaca:</b></label>
                <input class="form-control" type="number" name="frequencia" required>
            </div>

            <div class="col-4">       
                <label for="intensidade"><b>Intensidade do treino :</b></label>
                <input class="form-control" type="number" name="intensidade" required>
            </div>

            </div>
            </div>
            </div>

            ' ;

          }
        ?>

        </div>
        
        <div class="row" style="margin-top:20px"> 
          <div class="form-group col-3 offset-6">
            <a href="../treinos/index.php"><button type="button" class="btn btn-primary">Cancelar</button></a>
          </div>
          <div class="form-group col-3">   
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
</script>
</body>
</html>

<?php
if (($_POST['finalizado']=="1")){
    // Conexão com o servidor MySQL
    $con = mysqli_connect("auth-db213.hostinger.com.br", "u418844475_wtr", "wetrats2019", "u418844475_wtr");

    // Busca das informações referentes ao treino
    $sql =  "SELECT  data , tipo FROM treinos WHERE id=".$id_treino ;
    $resultado = mysqli_query($con, $sql);

    while ($treino = mysqli_fetch_array($resultado)){
        $tipo = $treino['tipo'];
        $data = $treino['data'];
    }
    if ($nivel_usuario=="2"){
        $atleta = explode("_" , $_POST['atleta']);
        $id_usuario=$atleta[0];
        $nome_atleta=$atleta[1];
    }

    if ($tipo == 'Tiro' or $tipo== 'Melhor media'){
        $estilo = $_POST['estilo'];
        $metragem = $_POST['metragem'];
        $tempo = str_replace('"' , '\\"' , $_POST['tempo']); //procedimento pra permitir a inclusao de aspas duplas
        $tempo = str_replace("'" , "\\'" , $tempo); // e simples no texto
        $intensidade = $_POST['intensidade'];
        
        //grava as informações no banco de dados
        $sql = "INSERT INTO resultados_treinos (id_treino, id_atleta, tipo, estilo, metragem,tempo, intensidade) 
        VALUES (".$id_treino.","."'$id_usuario'".","."'$tipo'".","."'$estilo'".","."'$metragem'".","."'$tempo'".","."'$intensidade'".")";
        if (!mysqli_query($con,$sql)){
            if ($nivel_usuario=="2"){
                $_SESSION['ALERTA'] = "Error description: " . mysqli_error($con);
                echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
                echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', '../adicionar_performance_treino/index.php?id=".$id_treino."');});</script>";
                //header("Location: ../adicionar_performance_treino/index.php?id=".$id_treino); exit;
            }
            else{
                $_SESSION['ALERTA'] = "Error description: " . mysqli_error($con);
                echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
                echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', '../adicionar_performance_treino/index.php?id=".$id_treino."');});</script>";
                //header("Location: ../adicionar_performance_treino/index.php?id=".$id_treino); exit;
            }
        }
        else {
            if ($nivel_usuario=="2"){
                $_SESSION['MSG'] = "Performance do tiro do atleta:".$nome_atleta." no dia "."'$data'"." incluída com sucesso." ;
                echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
                echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', '../adicionar_performance_treino/index.php?id=".$id_treino."');});</script>";
                //header("Location: ../adicionar_performance_treino/index.php?id=".$id_treino); exit;
            }
            else{
                $_SESSION['MSG'] = "Performance do tiro do dia "."'$data'"." incluída com sucesso." ;
                echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
                echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', '../performances/gerenciar_performances.php');});</script>";
                //header("Location: ../performances/gerenciar_performances.php"); exit;
            }
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
        $sql = "INSERT INTO resultados_treinos (id_treino, id_atleta, tipo, estilo, metragem,bracadas,tempo,frequencia, intensidade) 
        VALUES (".$id_treino.","."'$id_usuario'".","."'$tipo'".","."'$estilo'".","."'$metragem'".","."'$bracadas'".","."'$tempo'".","."'$frequencia'".","."'$intensidade'".")";
        if (!mysqli_query($con,$sql)){
            if ($nivel_usuario=="2"){
                $_SESSION['ALERTA'] = "Error description: " . mysqli_error($con);
                echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
                echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', '../adicionar_performance_treino/index.php?id=".$id_treino."');});</script>";
                //header("Location: ../adicionar_performance_treino/index.php?id=".$id_treino); exit;
            }
            else{
                $_SESSION['ALERTA'] = "Error description: " . mysqli_error($con);
                echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
                echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', '../adicionar_performance_treino/index.php?id=".$id_treino."');});</script>";
                //header("Location: ../adicionar_performance_treino/index.php?id=".$id_treino); exit;
            }
        }
        else {
            if ($nivel_usuario=="2"){
                $_SESSION['MSG'] = "Performance do BT do atleta:".$nome_atleta." no dia ".date_format(date_create($data),"d/m/Y")." incluída com sucesso." ;
                echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
                echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', '../adicionar_performance_treino/index.php?id=".$id_treino."');});</script>";
                //header("Location: ../adicionar_performance_treino/index.php?id=".$id_treino); exit;
            }
            else{
                $_SESSION['MSG'] = "Performance do BT dia ".date_format(date_create($data),"d/m/Y")." incluída com sucesso." ;
                echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
                echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', '../treinos/index.php');});</script>";
                //header("Location: ../performances/gerenciar_performances.php"); exit;
            }
        }
    }
}

?> 