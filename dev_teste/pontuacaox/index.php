<html lang="pt-BR">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
    <link rel="stylesheet" href="../common/stylesheets/bootstrap.css">
    <link rel="stylesheet" href="../common/stylesheets/bootstrap4.css">
    <link rel="stylesheet" href="../common/stylesheets/animate.css">
    <link rel="stylesheet" href="../common/stylesheets/style.css">
    <link rel="stylesheet" href="../common/stylesheets/style1.css">
    <link rel="icon" type="image/png" href="../common/images/favicon-32x32.png" sizes="32x32" />
    <title>Wetrats - Pontuação X</title>
</head>

<?php
 session_start();
 // Conexão com o servidor MySQL
 require_once '../db_con.php';
    
 // Verifica se existe ID da sessão
 if(!isset($_SESSION['ID'])){

  //Destrói a sessão por segurança
  session_destroy();

  //Redireciona para o login
  header("Location: ../index.php"); exit;
}
if($_SESSION['NIVEL'] != '2'){
    $_SESSION['ALERTA'] = "Acesso negado!";
    header("Location: ../perfil/"); exit;
}

  $id_usuario = $_SESSION['ID'];
  $nome_usuario = $_SESSION['NOME'];
  $apelido_usuario= $_SESSION['APELIDO'];
  $nivel_usuario = $_SESSION['NIVEL'];

  if (strlen($_GET['id'])>0)$id_atleta = $_GET['id'];
  else $id_atleta = $_SESSION['ID'];
  if ($nivel_usuario != "2" ){
    $_SESSION['ALERTA'] = "Acesso negado!";
    header("Location: ../index.php"); exit;
  }
?>

<body>
<div id="page">

<nav class="fh5co-nav" id="menu-list" role="navigation">
    <div id="menu"></div>
</nav>
<div id="menus"></div>
  <!-----Modal para mensagem de confirmação------->
  <div class="bg-modal">
        <div class="modal-contents">

            <div class="close" ><a href="#">+</a></div>
            <div class="col">
                <div id ="divDescricao"></div>    
            </div>
        </div>
    </div>
  <div class="container-fluid" style="padding-top:60px;">
    <!----Titulo--->
    <div class="row">
        <div class="section_title_container col-6">
            <div class="section_title light" ><h1>PONTUAÇÃO X</h1></div>
        </div>
    </div>
    <?php 
    if ($nivel_usuario == "2"){ // mostra o relatorio geral
    echo '<div class="col-12">
    <div class="row">
    <div class="container_financeiro_geral col-4">
        <h2>Relação de atletas</h2>
        <hr>

        <table class="tabela_financeiro_geral">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Pontos</th>
            </thead>
            </tr>
            <tbody>'; 
    $nomes = array();
    $tabela="";
        
    // calculo do total de pontos
    $sql="SELECT usuarios.nome AS 'nome', usuarios.apelido AS 'apelido', usuarios.id AS 'id' , 
          SUM( /*(SELECT COUNT(*) FROM presencas WHERE presencas.id_atleta=usuarios.id AND presencas.id_treino>94) +*/
            (COALESCE((SELECT SUM(IF(execucao=1,1,0)+IF(ced_aquec=1,1,0)+IF(ced_princ=1,1.5,0)+IF(comportamento=1,1.5,0) +IF(justificativa=1,1,0) +IF(outro_horario=1,1.5,0)+IF(feedback=1,2,0) +IF(negativo=1,-5,0)) 
              FROM pontuacaoX WHERE pontuacaoX.id_atleta=usuarios.id AND pontuacaoX.id_treino>185),0))) 
          AS 'total' FROM `usuarios` WHERE usuarios.ativo=1 
          GROUP BY `nome` 
          ORDER BY `total` DESC";
    
    $resultado = mysqli_query($con, $sql);
    while($row = mysqli_fetch_assoc($resultado)){
        $id = $row['id'];
        $nome = $row['nome'];
        $apelido = $row['apelido'];
        $total = $row['total'];
        $nomes[$id] = $nome;
        $tabela .='
        <tr>
            <td><a href="./index.php?id='.$id.'"'.'>'.$apelido.'</a></td>
            <td'; 
        $tabela .= '>'.$total.'</td>
        </tr>';
    }

    echo $tabela;
    
    echo '        </tbody>
        </table>
        </div>';    
    
}
    $tabela2 = "";
    $soma2 = 0;
    $sql2 = "SELECT (SELECT COUNT(*) FROM `pontuacaoX` WHERE id_atleta=".$id_atleta." AND execucao=1) AS 'execucao' , 
            (SELECT COUNT(*) FROM `pontuacaoX` WHERE id_atleta=".$id_atleta." AND comportamento=1) AS 'comportamento' ,
            (SELECT COUNT(*)   FROM `pontuacaoX` WHERE id_atleta=".$id_atleta." AND ced_aquec=1) AS 'ced_aquec',
            (SELECT COUNT(*)   FROM `pontuacaoX` WHERE id_atleta=".$id_atleta." AND ced_princ=1) AS 'ced_princ',
            (SELECT COUNT(*)   FROM `pontuacaoX` WHERE id_atleta=".$id_atleta." AND justificativa=1) AS 'justificativa',
            (SELECT COUNT(*)   FROM `pontuacaoX` WHERE id_atleta=".$id_atleta." AND outro_horario=1) AS 'outro_horario',
            (SELECT COUNT(*)   FROM `pontuacaoX` WHERE id_atleta=".$id_atleta." AND feedback=1) AS 'feedback',
            (SELECT COUNT(*) FROM `presencas` WHERE id_atleta=".$id_atleta." AND id_treino>186) AS 'presenca' ;";
    $resultado = mysqli_query($con, $sql2);
    while ($row = mysqli_fetch_assoc($resultado)){
        $execucao = 0;
        $comportamento = 0;
        $ced_aquec = 0;
        $ced_princ = 0;
        $feedback = 0;

        if(intval($row['presenca'])>0){
            $execucao = intval($row['execucao'])/intval($row['presenca'])* 100;
            $comportamento = intval($row['comportamento'])/intval($row['presenca'])* 100;
            $ced_aquec = intval($row['ced_aquec'])/intval($row['presenca'])* 100;
            $ced_princ = intval($row['ced_princ'])/intval($row['presenca'])* 100;
            $feedback = intval($row['feedback'])/intval($row['presenca'])* 100;
        }

        $tabela2 .='
        <tr>
        <td><div>EXECUÇÃO TOTAL</td>
            <td><div class="progress" style="height:20px; width:200px; margin-left:5px;">  
            <div class="progress-bar '; 
            if($execucao>=80 and $execucao<100)$tabela2.='bg-success'; if($execucao<80 and $execucao>=60)$tabela2.='bg-warning'; if($execucao<60)$tabela2.= 'bg-danger'; 
           $tabela2.= '" style="width:'.$execucao.'%; height:20px" >'.number_format($execucao,2).'%
            </div>
            </div></td>
        </tr>

        <tr>
        <td><div>COMPORTAMENTO</td>
            <td><div class="progress" style="height:20px; width:200px; margin-left:5px;">  
            <div class="progress-bar '; 
            if($comportamento>=80 and $comportamento<100)$tabela2.='bg-success'; if($comportamento<80 and $comportamento>=60)$tabela2.='bg-warning'; if($comportamento<60)$tabela2.= 'bg-danger'; 
           $tabela2.= '" style="width:'.$comportamento.'%; height:20px" >'.number_format($comportamento,2).'%
            </div>
            </div></td>
        </tr>

        <tr>
        <td><div>C&D AQUECIMENTO</td>
            <td><div class="progress" style="height:20px; width:200px; margin-left:5px;">  
            <div class="progress-bar '; 
            if($ced_aquec>=80 and $ced_aquec<100)$tabela2.='bg-success'; if($ced_aquec<80 and $ced_aquec>=60)$tabela2.='bg-warning'; if($ced_aquec<60)$tabela2.= 'bg-danger'; 
           $tabela2.= '" style="width:'.$ced_aquec.'%; height:20px" >'.number_format($ced_aquec,2).'%
            </div>
            </div></td>
        </tr>

        <tr>
        <td><div>C&D PRINCIPAL</td>
            <td><div class="progress" style="height:20px; width:200px; margin-left:5px;">  
            <div class="progress-bar '; 
            if($ced_princ>=80 and $ced_princ<100)$tabela2.='bg-success'; if($ced_princ<80 and $ced_princ>=60)$tabela2.='bg-warning'; if($ced_princ<60)$tabela2.= 'bg-danger'; 
           $tabela2.= '" style="width:'.$ced_princ.'%; height:20px" >'.number_format($ced_princ,2).'%
            </div>
            </div></td>
        </tr>

        <tr>
        <td><div>FEEDBACK</td>
            <td><div class="progress" style="height:20px; width:200px; margin-left:5px;">  
            <div class="progress-bar '; 
            if($feedback>=80 and $feedback<100)$tabela2.='bg-success'; if($feedback<80 and $feedback>=60)$tabela2.='bg-warning'; if($feedback<60)$tabela2.= 'bg-danger'; 
           $tabela2.= '" style="width:'.$feedback.'%; height:20px" >'.number_format($feedback,2).'%
            </div>
            </div></td>
        </tr>
        
        <tr>
        <td>JUSTIFICATIVAS</td><td>'.$row['justificativa'].'</td>
        </tr>
        <tr>
        <td> TREINOU EM OUTRO HORÁRIO</td><td>'.$row['outro_horario'].'</td>
        </tr>';
        

    }

    ?>
    <div class="container_financeiro_geral col-7">
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
    <div class="col-12" style="line-height:2;">

            <h2>Relatório Individual</h2>
            <hr>
            <?php echo '
            <div class="row">
              <div class="col">    
                <h3>'.$nomes[$id_atleta].'</h3>
              </div>
            </div>';
            ?>
        
        <div class="col">    
            <table class="table">
                <thead>
                    <th></th>
                    <th></th>
                </thead>
                <tbody>
                    <?php
                    echo $tabela2;
                    ?>
                </tbody>
            </table>
        </div>
      </div>
      </div>
    </div>
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
<!------Modal de visualização--------->
<script src="../common/js/treino.js"></script>
</body>
</html>