<html lang="pt-BR">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
    <link rel="stylesheet" href="../common/stylesheets/bootstrap.css">
    <link rel="stylesheet" href="../common/stylesheets/bootstrap4.css">
    <link rel="stylesheet" href="../common/stylesheets/animate.css">
    <link rel="stylesheet" href="../common/stylesheets/style.css">
    <link rel="stylesheet" href="../common/stylesheets/style1.css">
    <link rel="icon" type="image/png" href="../common/images/favicon-32x32.png" sizes="32x32" />
    <title>Wetrats - Projeto IUSP</title>
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
if($_SESSION['NIVEL'] != '3' and $_SESSION['NIVEL'] != '2' ){
    $_SESSION['ALERTA'] = "Acesso negado!";
    header("Location: ../perfil/"); exit;
}

  $id_usuario = $_SESSION['ID'];
  $nome_usuario = $_SESSION['NOME'];
  $apelido_usuario= $_SESSION['APELIDO'];
  $nivel_usuario = $_SESSION['NIVEL'];

  if (strlen($_GET['id'])>0)$id_atleta = $_GET['id'];
  else $id_atleta = $_SESSION['ID'];
  if (($nivel_usuario != "3" and $nivel_usuario != "2" ) and ($id_usuario != $id_atleta)){
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
            <div class="section_title light" ><h1>PROJETO IUSP</h1></div>
        </div>
        <?php if ($nivel_usuario == "3" or $nivel_usuario=="2") echo '
        <div class="col-4 offset-1">
            <a href="./adicionar_pontos.php"><button class="btn-primary">Adicionar pontos</button></a>
        </div>'; ?>
    </div>
    <?php 
    if ($nivel_usuario == "3" or $nivel_usuario == "2"){ // mostra o relatorio geral
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
    // Conexão com o servidor MySQL
    $con = mysqli_connect("srv976.hstgr.io", "u418844475_wtr", "Wetrats2019", "u418844475_wtr");
    
    // calculo do total de pontos
    $sql="SELECT usuarios.nome AS 'nome', usuarios.apelido AS 'apelido', usuarios.id AS 'id' , SUM(
        (SELECT COUNT(*) FROM presencas WHERE presencas.id_atleta=usuarios.id) + 
        (COALESCE((SELECT SUM(CASE WHEN tipo='A' THEN 1 WHEN tipo='C' THEN 2 ELSE 0.5 END) FROM projetoiusp WHERE projetoiusp.id_atleta=usuarios.id),0))) AS 'total'   
        FROM `usuarios` 
        WHERE usuarios.ativo=1
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
    // Conexão com o servidor MySQL
    $con = mysqli_connect("srv976.hstgr.io", "u418844475_wtr", "Wetrats2019", "u418844475_wtr");
    $tabela2 = "";
    $soma2 = 0;
    $sql2 = "SELECT id , data , tipo FROM `projetoiusp` 
    WHERE id_atleta=".$id_atleta.'
    ORDER BY data DESC ;' ;
    $resultado = mysqli_query($con, $sql2);
    while ($row = mysqli_fetch_assoc($resultado)){
        $id_ponto = $row['id'];
        $tipo = $row['tipo'];
        if($tipo=="A") $tp="Academia";
        else if($tipo =="C") $tp = "Competição";
        else $tp = "Extra";
        $data = date_create($row['data']);
        if($tipo=="A") $soma2 +=1;
        else if($tipo=="E") $soma2 +=0.5;
        else if($tipo == "C") $soma2 +=2;
        $tabela2 .='
        <tr>
            <td>'.date_format($data,"d/m/Y").'</td>
            <td>'.$tp.'</td>';
            if ($nivel_usuario == "3" or $nivel_usuario=="2") $tabela2 .= '
            <td><a class=btn-danger href="./deletar_ponto.php?id='.$id_ponto.'&id_atleta='.$_GET['id'].'">Deletar</a></td>
        </tr>';

    }

    ?>
    <div class="container_financeiro_geral col-8">
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
      <div class="row">
        <div class="col-3" style="line-height:2;">

            <h2>Relatório Individual</h2>
            <hr>
            <?php echo '
            <div class="row">
              <div class="col">    
                <h3>'.$nomes[$id_atleta].'</h3>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <h2>TOTAL:'.$soma2.'</h2>
              </div>
            </div>';
            ?>
        </div>
        
        <div class="col-9">    
            <h3>Pontos obtidos</h3>
            <hr>
            <table class="tabela_financeiro_geral1">
                <thead>
                <tr>
                    <th>Data</th>
                    <th>Descrição</th>
                    <th></th>
                </thead>
                </tr>
                <tbody>
                <?php
                echo $tabela2;
                ?>
                </tbody>
            </table>

        </div>
    <?php  if ($nivel_usuario == "3" or $nivel_usuario=="2") echo ' 
      </div>
      </div>'; ?>
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