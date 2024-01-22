<html lang="pt-BR">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
    <link rel="stylesheet" href="../common/stylesheets/bootstrap.css">
    <link rel="stylesheet" href="../common/stylesheets/bootstrap4.css">
    <link rel="stylesheet" href="../common/stylesheets/animate.css">
    <link rel="stylesheet" href="../common/stylesheets/style.css">
    <link rel="stylesheet" href="../common/stylesheets/style1.css">
    <link rel="icon" type="image/png" href="../common/images/favicon-32x32.png" sizes="32x32" />
    <title>Wetrats - Prep.Física: Criar treino</title>
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
      <form method="post" action="criar_treino.php" class="col-12">

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

        <h1>NOVO TREINO</h1>
        <p>Preencha os campos abaixo para criar um novo treino.</p>
        <hr>

        <div class="container_form">

        <div class="row form-group">
            <h2>INFORMAÇÕES GERAIS</h2>
        </div>

        <div class="col-12">

            <div class="row form-group">

                <div class="col-4">
                    
                        <input class="form-control" type="text" name="nome" placeholder='Nome do treino...' required>
                  
                </div>

                <div class="col-4">
            
                    <label for="grupo" style="padding-left:15px"><b>Grupo:</b></label>
                    <select name="grupo">
                        <?php
                        require_once '../db_con.php';
                        $sql0 = "SELECT DISTINCT nome FROM grupos_preparacao;";
                        $query_grupos=mysqli_query($con, $sql0);
                        while($grupo = mysqli_fetch_array($query_grupos)){
                            echo '<option value="'.$grupo[0].'">'.$grupo[0]."</option>";
                        }

                        ?>
                    </select>
                </div>
                
                <div class='col-4'>
                    <div class="row form-group">
                        <div class="col-3">
                            <label><b>Tipo:</b></label>
                        </div>

                        <div class="col-3">
                            <div class="custom-control custom-radio custom-control-inline">
                            <input class="custom-control-input" type="radio" name="tipo" id="A" value="A"> 
                            <label for="A" class="custom-control-label" style="padding-left:10px;">A</label> 
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="custom-control custom-radio custom-control-inline">
                            <input class="custom-control-input" type="radio" name="tipo" id="B" value="B" checked> 
                            <label for="B" class="custom-control-label" style="padding-left:10px;">B</label> 
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="custom-control custom-radio custom-control-inline">
                            <input class="custom-control-input" type="radio" name="tipo" id="C" value="C"> 
                            <label for="A" class="custom-control-label" style="padding-left:10px;">C</label> 
                            </div>
                        </div>
                    </div>
                </div>
                
                
            </div>

            <div class='row form-group'>
                <div class='col-4'>

                    <div class="row form-group">
                        <div class="col-9">
                            <label for="n_exercicios"><b>Nº de exercícios:</b></label>
                            <input class="form-control" type="number" name="n_exercicios" required>
                        </div>
                    </div>
                </div>


            <div class="col-8">
                <div class="row">
                    <div class="col-6">
                        <label for="perido"><b>Período:</b></label>
                        <input class="form-control" type="text" name="periodo"  required>
                    </div>
                    
                    <div class="col-6">
                        <label for="etapa"><b>Etapa:</b></label>
                        <input class="form-control" type="text" name="etapa"  required>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-6">
                        <label for="data"><b>Início:</b></label>
                        <input class="form-control" type="date" placeholder="Insira a data..." name="data_inicio"  required>
                    </div>

                    <div class="col-6">
                        <label for="data"><b>Término:</b></label>
                        <input class="form-control" type="date" placeholder="Insira a data..." name="data_termino"  required>
                    </div>
                </div>
                
              </div>
            </div>
            
            <div class="row form-group"><hr></div>
            
            <div class="row form-group">
                <div class="col-6"></div>
                <div class="form-group col-3">
                    <button href="../" class="btn btn-primary">Cancelar</button>
                </div>
                
                <div class="form-group col-3">
                    <button type="submit" class="btn btn-primary">Criar</button>
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
  //extrai as informações enviadas
  $nome= $_POST['nome'];
  $grupo = $_POST['grupo'] ;
  $tipo = $_POST['tipo'] ;
  $periodo = $_POST['periodo'] ;
  $etapa = $_POST['etapa'] ;
  $n_exercicios = $_POST['n_exercicios'] ;
  $data_inicio = $_POST['data_inicio'] ;
  $data_termino = $_POST['data_termino'] ;


  
  //conexao e envio de informaçoes ao banco de dados
  $sql = "INSERT INTO treinos_academia (nome,grupo,tipo,periodo,etapa,n_exercicios, data_inicio, data_termino) 
          VALUES ("."'$nome'".","."'$grupo'".","."'$tipo'".","."'$periodo'".","."'$etapa
                 '".","."'$n_exercicios'".",'".$data_inicio."','".$data_termino."')";
 
  if (!mysqli_query($con,$sql)){
    $_SESSION['ALERTA']= mysqli_error($con);
    $_SESSION['ALERTA'].="Contate o DM." ;
    echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
    echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './');});</script>";
    //header("Location: ./index.php"); exit;
  }
  else {
      $sql2 = "SELECT id FROM treinos_academia ORDER BY id DESC limit 1";
      $query_id=mysqli_query($con, $sql2);
      $id = mysqli_fetch_array($query_id);    
      $_SESSION['MSG'] = "Treino ".$tipo." do grupo:".$grupo." incluído com sucesso." ;
      echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
      echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './adicionar_exercicios.php?id_treino=".$id[0]."');});</script>";
      //header("Location: ../treinos/index.php"); exit;
  }
}

?>
