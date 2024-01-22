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
  require_once '../db_con.php';
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

  if(strlen($_GET['id'])>0){
    $id = $_GET['id'];
    $form = "editar_performance.php?id=".$id;

    $sql= "SELECT id_atleta, evento, data, estilo, metragem, tempo 
           FROM `resultados_pessoais`
           WHERE id=".$id ;
    
    $resultado = mysqli_query($con,$sql);
    if ($resultado){
        while ($row = mysqli_fetch_assoc($resultado)){
            $evento = $row['evento'];
            $data = $row['data'];
            $id_atleta = $row['id_atleta'];
            $estilo = $row['estilo'];
            $metragem = $row['metragem'];
            $tempo = $row['tempo'];
        }
    }
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
                <h1>Editar Performance</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-8">
                <p>Altere o dados que desejar para editar sua performance individual</p>
                <hr>
            </div>   
        </div>

        <form method="post" action="editar_performance.php?id=<?php echo $_GET['id']; ?>" class="col-12">
        
        <div class="container_form">     
        <div class="row form-group">
            <div class="col-md-6">        
                <label for="evento"><b>Evento:</b></label>
                <select class="form-control"  name="evento">
                    <option value=" "> </option>
                
                <?php
                //busca pelos nomes das competicoes cadastrados no sistema e ativas
                $sql = "SELECT evento, data FROM competicoes ORDER BY data DESC ";
                $achou= False;
                $resultado = mysqli_query($con,$sql);
                while($row = mysqli_fetch_assoc($resultado)){
                    $competicao = $row['evento'] ;
                    $data = $row['data'];
                    $html = '<option value ="'.$competicao.'_'.$data.'"';
                    if (isset($_POST['evento'])){
                      if ($_POST['evento']== $competicao.'_'.$data){
                        $html.= " selected";
                      }
                    }
                    else {
                        if ($evento == $competicao){
                            $html .=" selected";
                            $achou = True;
                        }
                    }
                    
                    $html .='>'.$competicao.'</option>' ;
                    echo $html ;
                    }
                ?>
                </select>
                <input class="form-control" name="nome_evento" placeholder="Ou digite..." value="<?php if(!$achou) echo $evento; ?>">
            </div>

            <div class="col col-md-6">
                <label for="data"><b>Data:</b></label>
                <input class="form-control" type="date" placeholder="Insira a data APENAS se o evento/competição foi digitado manualmente..." name="data" value="<?php if (isset($data)) echo $data;  ?>" >
            </div>
        </div>

        
        <div class="row form-group">
            <div class="col-3">       
               <label for="estilo"><b>Estilo:</b></label>
                   <select class="form-control" name="estilo">
                        <option value="Borboleta" <?php if($estilo=="Borboleta") echo ' selected';?>>Borboleta</option>
                        <option value="Costas" <?php if($estilo=="Costas") echo ' selected';?> >Costas</option> 
                        <option value="Peito" <?php if($estilo=="Peito") echo ' selected';?> >Peito</option>
                        <option value="Livre" <?php if($estilo=="Livre") echo ' selected';?> >Livre</option>
                        <option value="Medley" <?php if($estilo=="Medley") echo ' selected';?> >Medley</option>
                    </select>
            </div>
            <div class="col-3">
                <label for="metragem'"><b>Metragem:</b></label>
                <input class="form-control" name="metragem" value="<?php echo $metragem;?>">
            </div>
            <div class="col-3">
               <label for="tempo"><b>Tempo:</b></label>
               <input class="form-control" name="tempo" value=<?php echo $tempo;?>>
            </div>
        </div>
      </div>
    </div>

        
        <div class="row">
          <div class="form-group col-3 offset-1">
          <a href="./gerenciar_performances.php"><button type="button" class="btn btn-primary">Cancelar</button></a>
          </div>
          <div class="form-group col-3 offset-3"> 
            <button type="submit" class="btn btn-primary" name="finalizado" value="1">Enviar</button>
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
    $("#menus").load("../common/menu/menu.html #side_menu");
</script>
</body>
</html>

<?php
if (($_POST['finalizado']=="1")){

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
      $estilo = $_POST['estilo'];
      $metragem = $_POST['metragem'];
      $tempo = str_replace('"' , '\\"' , $_POST['tempo']); //procedimento pra permitir a inclusao de aspas duplas
      $tempo = str_replace("'" , "\\'" , $tempo); // e simples no tempo

      $date=date_create($data);

    //preparação do sql e da mensagem de sucesso
    $mensagem= "O resultado na prova:".$metragem." ".$estilo." com o tempo de:".str_replace("\\" ,"" ,  $tempo)." em ".date_format($date,"d/m/y")." foi atualizado com sucesso!" ; 
    $sql = "UPDATE `resultados_pessoais` SET evento="."'".$evento."' ,"."data="."'".$data."'"." , estilo="."'".$estilo."', metragem="."'".$metragem."', tempo="."'".$tempo."'
            WHERE id=".$id." ;" ; 

    // Grava as informações no banco de dados
    if (!mysqli_query($con,$sql)){
        $_SESSION['ALERTA'] = "Error description: " . mysqli_error($con);
        echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
        echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './editar_performance.php?id=".$_GET['id']."');});</script>";
        //header("Location: ./editar_performance.php?id=".$_GET['id']); exit;
    }
    else { 
        $_SESSION['MSG'] = $mensagem ;
        echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
        echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './gerenciar_performances.php');});</script>";
        //header("Location: ./gerenciar_performances.php"); exit;
    }
}
?>

    
