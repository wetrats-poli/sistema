<html lang="pt-BR">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
    <link rel="stylesheet" href="../common/stylesheets/bootstrap.css">
    <link rel="stylesheet" href="../common/stylesheets/bootstrap4.css">
    <link rel="stylesheet" href="../common/stylesheets/animate.css">
    <link rel="stylesheet" href="../common/stylesheets/style.css">
    <link rel="stylesheet" href="../common/stylesheets/style1.css">
</head>

<?php
 //Inicia uma sessão
  session_start();
  $id_usuario = $_SESSION['ID'];
  $apelido_usuario= $_SESSION['APELIDO'];
  $nivel_usuario = $_SESSION['NIVEL'];
?>

<body>
<div id="page">
<nav class="fh5co-nav" id="menu-list" role="navigation">
    <div id="menu"></div>
</nav>
<div id="menus"></div>
  <div class="container-fluid" style="padding-top:60px;">

    <div class="row">
        <?php
            session_start();
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
    </div>         

    <!----Titulo--->

        <div class="row">
            <div class="section_title light col-6">
                <h1>Adicionar Performance</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-8">
                <p>Preencha o formulário para adicionar uma performance pessoal às suas estatísticas</p>
                <hr>
            </div>   
        </div>

        <form method="post" action="adicionar_performance.php" class="col-12">
        
        <div class="container_form">
        <div class="row form-group">
            <div class="col-md-6">        
                <label for="evento"><b>Evento:</b></label>
                <select class="form-control"  name="evento">
                    <option value=" "> </option>
                <?php

                // Conexão com o servidor MySQL
                $con = mysqli_connect("auth-db213.hstgr.io", "u418844475_wtr", "wetrats2019", "u418844475_wtr");

                //busca pelos nomes das competicoes cadastrados no sistema e ativas
                $sql = "SELECT evento, data FROM competicoes ORDER BY data DESC ";
                $resultado = mysqli_query($con,$sql);
                while($row = mysqli_fetch_assoc($resultado)){
                    $evento = $row['evento'] ;
                    $data = $row['data'];
                    $html = '<option value ="'.$evento.'_'.$data.'"';
                    if (isset($_POST['evento'])){
                      if ($_POST['evento']== $evento.'_'.$data){
                        $html.= " selected";
                      }
                    }
                    $html .='>'.$evento.'</option>' ;
                    echo $html ;
                }

                ?>
                </select>
                <input class="form-control" name="nome_evento" placeholder="Ou digite..." value="<?php if (isset($_POST['nome_evento'])) echo $_POST['nome_evento']; ?>">
            </div>

            <div class="col col-md-6">
                <label for="data"><b>Data:</b></label>
                <input class="form-control" type="date" placeholder="Insira a data APENAS se o evento/competição foi digitado manualmente..." name="data" value="<?php if (isset($_POST['data'])) echo $_POST['data']; ?>" >
            </div>
        </div>
        </div>

        <!-- formulario para inserçao das provas -->
        <div class="container_form" style="margin-top:30px;">
            
                <h1>Provas</h1>
                <p>Digite o número de provas a serem inseridas e clique em "Ok!" para adicionar os campos.</p>
    
                <div class="row form-group">
                    <div class="col-md-3">
                        <label for="nprovas"><b>Número de provas:</b></label>
                        <input class="form-control" type="number" placeholder="Nº de provas..." name="nprovas" value="<?php if(isset($_POST['nprovas'])) echo $_POST['nprovas']; ?>"required>
                    </div>

                    <div class="col-md-2" style="margin-top:3em;">
                        <button type="submit" class="btn btn-primary" name="ok" value = "ok">Ok!</button>
                    </div>
                </div>
                <?php 
                if (isset($_POST['ok'])){
                   $nprovas=$_POST['nprovas'];
                    $i = 1;
                    while ($i<= $nprovas){
                        echo 
                        '
                        <div class="row form-group">
                          <div class="col-3">       
                              <label for="estilo"'.$i.'><b>Prova '.$i.':</b></label>
                              <select class="form-control" name="estilo'.$i.'">
                                  <option value="Borboleta" >Borboleta</option>
                                  <option value="Costas" >Costas</option> 
                                  <option value="Peito" >Peito</option>
                                  <option value="Livre" >Livre</option>
                                  <option value="Medley" >Medley</option>
                              </select>
                          </div>
                          <div class="col-3">
                            <label for="metragem'.$i.'"><b>Metragem:</b></label>
                            <input class="form-control" name="metragem'.$i.'">
                          </div>
                          <div class="col-3">
                            <label for="tempo'.$i.'"><b>Tempo:</b></label>
                            <input class="form-control" name="tempo'.$i.'">
                          </div>
                        </div>' ;
                        $i +=1 ;
                    }
                }
                ?>
            </div>
        </div>

        
        <div class="row">
          <div class="form-group col-md-2 col-md-push-3">
          <a href="./gerenciar_performances.php"><button type="button" class="btn btn-primary">Cancelar</button></a>
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
    
    $id_atleta = $id_usuario;

    $evento = $_POST['evento'];
    if (strlen($evento)>1){
        $string= explode("_",$evento);
        $evento=$string[0];
        $data=$string[1];
    }
    else{
        $evento=$_POST['nome_evento'];
        $data= $_POST['data'];
    }

    //preparação do sql e da mensagem de sucesso
    $mensagem= "O resultado" ;
    $sql = "INSERT INTO `resultados_pessoais` (id_atleta, evento, data , estilo, metragem, tempo) VALUES "; 
    $nprovas=$_POST['nprovas'];
    $i=1;
    while($i<= $nprovas){
      $estilo_i = "estilo".$i;
      $estilo = $_POST[$estilo_i];
      $metragem_i = "metragem".$i;
      $metragem = $_POST[$metragem_i];
      $tempo_i = "tempo".$i;
      $tempo = str_replace('"' , '\\"' , $_POST[$tempo_i]); //procedimento pra permitir a inclusao de aspas duplas
      $tempo = str_replace("'" , "\\'" , $tempo); // e simples no tempo
      $sql.= "("."'$id_atleta'".","."'$evento'".","."'$data'".","."'$estilo'".","."'$metragem'".","."'$tempo'".") ,";
      if($i==1) $mensagem .= " na prova:".$metragem." ".$estilo." com o tempo de:".str_replace("\\" ,"" ,  $tempo)."; \n";
      else $mensagem .= " e na prova:".$metragem." ".$estilo." com o tempo de:".str_replace("\\" ,"" ,  $tempo)."; \n";
      $i += 1;
    }

    $sql = substr($sql, 0, -1);
    $sql .= ";" ;

    $date=date_create($data);
    $mensagem .= " em ".date_format($date,"d/m/y")." foi incluído com sucesso.";

    // Conexão com o servidor MySQL
    $con = mysqli_connect("auth-db213.hstgr.io", "u418844475_wtr", "wetrats2019", "u418844475_wtr");
    
    // Grava as informações no banco de dados
    if (!mysqli_query($con,$sql)){
        echo("Error description: " . mysqli_error($con));
        echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
        echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './adicionar_performances.php');});</script>";
        //header("Location: ./adicionar_performances.php"); exit;
    }
    else { 
        $_SESSION['MSG'] = $mensagem ;
        echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
        echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './gerenciar_performances.php');});</script>";
        //header("Location: ./gerenciar_performances.php"); exit;
    }
}
?>

    
