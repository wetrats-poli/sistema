<html lang="pt-BR">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
    <link rel="stylesheet" href="../common/stylesheets/bootstrap.css">
    <link rel="stylesheet" href="../common/stylesheets/bootstrap4.css">
    <link rel="stylesheet" href="../common/stylesheets/animate.css">
    <link rel="stylesheet" href="../common/stylesheets/style.css">
    <link rel="stylesheet" href="../common/stylesheets/style1.css">
    <link rel="icon" type="image/png" href="../common/images/favicon-32x32.png" sizes="32x32" />
    <title>Wetrats - Prep.Física: Adicionar exercícios</title>
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
$id_treino = $_GET['id_treino'];

require_once '../db_con.php';
$sql0 = "SELECT * FROM treinos_academia WHERE id=".$id_treino.";";
$query_treino=mysqli_query($con, $sql0);
$treino = mysqli_fetch_assoc($query_treino);


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
      <form method="post" <?php echo ' action="adicionar_exercicios.php?id_treino='.$id_treino.'"'; ?> class="col-12">

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

        <h1>ADICIONAR EXERCÍCIOS</h1>
        <hr>
        <div class="row form-group">
        <div class="col-3">
          <div class="container_form">
        
            <h2><?php echo " ".$treino['nome']." (".$treino['tipo'].")";?></h2>
            <hr>

                   
              <div class="row form-group">
                <b>Grupo:</b><?php echo $treino['grupo'];?>
              </div>

                <div class="row form-group">
                    <b>Período:</b><?php echo $treino['periodo'];?> 
                </div>
                    
                <div class="row form-group">
                    <b>Etapa:</b><?php echo $treino['etapa'];?> 
                </div>
                
                <div class="row form-group">
                    <b>Início:</b><?php echo date_format(date_create($treino['data_inicio']),"d/m/Y");?> 
                </div>

                <div class="row form-group">
                    <b>Término:</b><?php echo date_format(date_create($treino['data_termino']),"d/m/Y");?> 
                </div>
          </div>
        </div>

        <div class="col-9">
         <div class="container_form">
        
        
        <p><b>Nº de exercícios:</b><?php echo $treino['n_exercicios'];?></p>
        

        <table class="table table-head table-hover">
                <thead>
                    <th style="width:5%">#</th>
                    <th>EXERCÍCIO</th>
                    <th style="width:8%">SÉRIES</th>
                    <th>INTENSIDADE</th>
                    <th>REPETIÇÕES</th>
                    <th>INTERVALO</th>
                </thead>
                <tbody>
        <?php
         
        $i=1;
        while($i<=$treino['n_exercicios']){
            echo "
            <tr>
            <td>".$i."</td>
            <td><input class='form-control' type='text' name='exercicio".$i."_nome' required></td>
            <td><input class='form-control' type='text' name='exercicio".$i."_series' required></td>
            <td><input class='form-control' type='text' name='exercicio".$i."_intensidade' required></td>
            <td><input class='form-control' type='text' name='exercicio".$i."_repeticoes' required></td>
            <td><input class='form-control' type='text' name='exercicio".$i."_intervalo' required></td>
            </tr>";

            $i++;
        }
        ?>
                </tbody>
            </table>
        
            <p>**Separar as <strong>INTENSIDADES</strong>,<strong>REPETIÇÕES</strong> e <strong>INTERVALOS</strong> de cada série por '/'</p>

          <label for="legenda"><b>Legenda:</b></label>  
          <div class="row form-group">
            <div class="col-6">
                
                <textarea class="form-control" type="text" rows="3"  name="legenda" required></textarea>
            </div>
            <div class="col-3"></div>
            
                
            <div class="form-group col-3">
                <button type="submit" class="btn btn-primary">Finalizar</button>
            </div>
            <br>
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
if ($_POST){
    
  //conexao e envio de informaçoes ao banco de dados
  $sql = "INSERT INTO series_academia (id_treino,ordem,exercicio,n_series,repeticoes,intensidade, intervalo) 
          VALUES ";
 $i=1;
 while($i<=$treino['n_exercicios']){
    $sql.="(".$id_treino.",".$i.",'".$_POST['exercicio'.$i.'_nome']."'
    ,".$_POST['exercicio'.$i.'_series'].",'".$_POST['exercicio'.$i.'_repeticoes']."','"
    .$_POST['exercicio'.$i.'_intensidade']."','".$_POST['exercicio'.$i.'_intervalo']."'),";
    $i++;
}
 $sql = substr($sql,0,-1);
 $sql.=";";

  if (!mysqli_query($con,$sql)){
    $_SESSION['ALERTA']= mysqli_error($con.$sql);
    $_SESSION['ALERTA'].="Contate o DM." ;
    echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
    echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', '../perfil/');});</script>";
    
  }
  else {
    $sql = 'UPDATE treinos_academia SET legenda="'.$_POST['legenda'].'" WHERE id='.$id_treino.';';
    mysqli_query($con,$sql);  
      $_SESSION['MSG'] = "Exercícios adicionados com sucesso." ;
      echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
      echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './visualizar_treino.php?id_treino=".$id_treino.");});</script>";
    
  }
}

?>