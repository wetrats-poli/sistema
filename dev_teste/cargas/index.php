<html lang="pt-BR">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
    <link rel="stylesheet" href="../common/stylesheets/bootstrap.css">
    <link rel="stylesheet" href="../common/stylesheets/bootstrap4.css">
    <link rel="stylesheet" href="../common/stylesheets/animate.css">
    <link rel="stylesheet" href="../common/stylesheets/style.css">
    <link rel="stylesheet" href="../common/stylesheets/style1.css">
    <link rel="icon" type="image/png" href="../common/images/favicon-32x32.png" sizes="32x32" />
    <title>Wetrats - Preparação Física - Cargas</title>
</head>

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
  $nome_usuario = $_SESSION['NOME'];
  $apelido_usuario= $_SESSION['APELIDO'];
  $nivel_usuario = $_SESSION['NIVEL'];

  if (strlen($_GET['id'])>0)$id_atleta = $_GET['id'];
  else $id_atleta = $_SESSION['ID'];

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
        <div class="section_title_container col-9">
            <div class="section_title light" ><h1>PREPARAÇÃO FÍSICA - CARGAS</h1></div>
        </div>
    </div>
    <?php 
    if ($nivel_usuario == "2"){ // mostra o relatorio geral
    echo '<div class="col-12">
    <div class="row">
    <div class="container_financeiro_geral col-2">
        <h2>Relação de atletas</h2>
        <hr>

        <table class="tabela_financeiro_geral">
            <thead>
            <tr>
                <th>Atleta</th>
            </thead>
            </tr>
            <tbody>'; 
    $nomes = array();
    $tabela="";
    // Conexão com o servidor MySQL
    $con = mysqli_connect("auth-db213.hostinger.com.br", "u418844475_wtr", "wetrats2019", "u418844475_wtr");
    
    // calculo do total de pontos
    $sql="SELECT grupos_preparacao.nome AS 'grupo',usuarios.nome AS 'nome' , usuarios.id AS 'id'
          FROM `grupos_preparacao` 
          JOIN usuarios ON grupos_preparacao.id_atleta = usuarios.id 
          ORDER by 'grupo' ASC,'nome' ASC";
    
    $resultado = mysqli_query($con, $sql);
    while($row = mysqli_fetch_assoc($resultado)){
        $id = $row['id'];
        $nome = $row['nome'];
        $grupo = $row['grupo'];
        $nomes[$id] = $nome;
        $tabela .='
        <tr>
            <td><a href="./index.php?id='.$id.'"'.' style="font-size:12;">'.$nome.'</a></td>
        </tr>';
    }

    echo $tabela;
    
    echo '        </tbody>
        </table>
        </div>';    
    
}
    // Conexão com o servidor MySQL
    $con = mysqli_connect("auth-db213.hostinger.com.br", "u418844475_wtr", "wetrats2019", "u418844475_wtr");
    $exercicios = array();
    $datas=array();
    $header="<th style='background-color: #242b56;color:#FFB000;text-tranform:uppercase;'>
    <strong></strong></th>";
    $sql2 = 'SELECT usuarios.nome , series_academia.exercicio, series_academia.repeticoes, treinos_academia.etapa,treinos_academia.periodo,
    CONCAT(cargas_academia.1,"&",cargas_academia.2,"&",cargas_academia.3,"&",cargas_academia.4,"&",cargas_academia.5,"&",cargas_academia.6,"&",cargas_academia.7,"&",cargas_academia.8) AS "cargas", 
    cargas_academia.data 
    FROM `cargas_academia` 
    INNER JOIN series_academia ON cargas_academia.id_serie = series_academia.id 
    INNER JOIN treinos_academia ON series_academia.id_treino = treinos_academia.id 
    INNER JOIN usuarios ON usuarios.id = cargas_academia.id_atleta 
    WHERE cargas_academia.id_atleta= '.$id_atleta.'
    ORDER BY cargas_academia.data DESC;';

    $resultado = mysqli_query($con, $sql2);
    while ($row = mysqli_fetch_assoc($resultado)){
        $nome_atleta = $row['nome'];
        $exercicio = $row['exercicio'];
        $reps_str=explode("/",$row['repeticoes']);
        $cargas_str= explode("&",$row['cargas']);
        $etapa=$row['etapa'];
        $periodo=$row['periodo'];
        
        //tratamento das cargas e reps
        $cargas=array();
        $reps=array();
        $i=0;
        foreach($reps_str as $r){
            $cargas[]=floatval($cargas_str[$i]);
            $reps[]=floatval($r);
            $i+=1;
        }



        //adição dos dados em um Map contendo os dados de cada exercicio
        $data = explode(" ",$row['data'])[0];
        $data_f= explode("-",$data)[2]."/".explode("-",$data)[1];
        if (array_key_exists($exercicio,$exercicios)){
            $exercicios[$exercicio][]=[$cargas,$reps,$data_f,$etapa,$periodo,str_replace("//","",implode("/",$cargas_str))];
        }else{
            $exercicios[$exercicio]=[];
            $exercicios[$exercicio][]=[$cargas,$reps,$data_f,$etapa,$periodo,str_replace("//","",implode("/",$cargas_str))];
        }

        //HEADER
        if(!array_key_exists($data_f,$datas)){
            $datas[$data_f]=$etapa;
            $header.="<th style='background-color: #242b56;color:#FFB000;text-tranform:uppercase;font-size:12px;'>
            <strong>".$data_f."</strong><div>(".$etapa.")</div>
        </th>";        
        }
    
    $linhas="";
    $n=0;     
    foreach($exercicios as $exercicio => $series){
        $linha = "
        <tr style='background-color:white;color:black;' class='linha_exercicio'>
        <td style='background-color: #242b56;color:#FFB000;text-transform:uppercase;overflow: hidden;
        height: 40px;";

        if(strlen($exercicio)<30) $linha.="white-space: nowrap;"; $linha.="font-size:14px;'>
            <strong>".$exercicio."</strong>
        </td>";
        foreach($datas as $dt=> $etp){
            $flag=false;
            foreach($series as $serie){ 
                if($serie[2]==$dt){
                    $flag=true;
                    $linha .= "<td class='tooltip2 serie' exercicio='".$exercicio."' value=".floatval(max($serie[0]))." id=".$n." style='font-size:14px;'>
                            <span class='tooltip2text'>
                                <div><strong>".$serie[4]."</strong></div>
                                <div>Cargas:".$serie[5]."</div>
                                <div>Reps:".implode("/",$serie[1])."</div>
                            </span>".
                            max($serie[0])."(".min($serie[1]).")
                            </td>";
                    $n+=1;
                }

            }
        if(!$flag) $linha.="<td></td>";
        }
        $linhas.= $linha."</tr>";
    }
            
    }

    ?>
    <div class="container_financeiro_geral col-10">
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
        
        <div class="col" style="overflow-x:scroll;overflow-y:hidden;">    
            <table class="table">
                <thead>
                    <?php echo $header;?>
                </thead>
                <tbody>
                    <?php
                    echo $linhas;
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

<!--Indicador de cores das cargas-->
<script src="cargas.js"></script>
</body>
</html>