<html lang="pt-BR">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
    <link rel="stylesheet" href="../common/stylesheets/bootstrap.css">
    <link rel="stylesheet" href="../common/stylesheets/bootstrap4.css">
    <link rel="stylesheet" href="../common/stylesheets/animate.css">
    <link rel="stylesheet" href="../common/stylesheets/style.css">
    <link rel="stylesheet" href="../common/stylesheets/style1.css">
    <link rel="icon" type="image/png" href="../common/images/favicon-32x32.png" sizes="32x32" />
    <title>Wetrats - Financeiro</title>
</head>

<?php
 //Inicia uma sessão
  session_start();
  $id_usuario = $_SESSION['ID'];
  $nome_usuario = $_SESSION['NOME'];
  $apelido_usuario= $_SESSION['APELIDO'];
  $nivel_usuario = $_SESSION['NIVEL'];

  if ($nivel_usuario != "3"){
    $_SESSION['ALERTA'] = "Acesso negado!";
    header("Location: ../perfil/"); exit;
  }
?>

<body>
<div id="page">
<nav class="fh5co-nav" id="menu-list" role="navigation">
    <div id="menu"></div>
</nav>
<div id="menus"></div>
  <div class="container-fluid" style="padding-top:60px;">
    <!----Titulo--->
    <div class="row">
        <div class="section_title_container col-6">
            <div class="section_title light" ><h1>Financeiro</h1></div>
        </div>
        <div class="col-4 offset-1">
            <a href="../criacao_divida/index.php"><button class="btn-primary">Lançar dívidas</button></a>
        </div>
    </div>

    <div class="container_financeiro_geral col-4">
        <h2>Situação Geral</h2>
        <hr>

        <table class="tabela_financeiro_geral">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Dívida</th>
            </thead>
            </tr>
            <tbody>

    <?php 

    $tabela="";
    $soma = 0;
    $vermelho = ' style="background-color:rgb(256,0,0); color:rgb(0,0,0);"';
    // Conexão com o servidor MySQL
    $con = mysqli_connect("auth-db213.hostinger.com.br", "u418844475_wtr", "wetrats2019", "u418844475_wtr");
    
    $sql="SELECT id_devedor , usuarios.nome AS 'nome' , SUM(valor) AS 'total' FROM `financeiro`
    INNER JOIN `usuarios` ON financeiro.id_devedor = usuarios.id
    WHERE status = 'NP' 
    GROUP BY `nome` 
    ORDER BY `nome` ASC ;" ;
    
    $resultado = mysqli_query($con, $sql);
    while($row = mysqli_fetch_assoc($resultado)){
        $id = $row['id_devedor'];
        $nome = $row['nome'];
        $total = $row['total'];
        $soma += $total ;
        $tabela .='
        <tr>
            <td><a href="./detalhes.php?id='.$id.'"'.'>'.$nome.'</a></td>
            <td'; if($total>200) $tabela .= $vermelho; $tabela .= '>R$'.number_format($total,2).'</td>
        </tr>';
    }

    $sql2 = "SELECT id , nome , '0' AS 'total' FROM `usuarios` 
    WHERE id NOT IN ( SELECT id_devedor FROM `financeiro` WHERE status = 'NP') AND id!=31
    GROUP BY `nome` ORDER BY `nome` ASC";
    $resultado = mysqli_query($con, $sql2);
    while($row = mysqli_fetch_assoc($resultado)){
        $id = $row['id'];
        $nome = $row['nome'];
        $total = $row['total'];
        $tabela .='
        <tr>
            <td><a href="./detalhes.php?id='.$id.'"'.'>'.$nome.'</a></td>
            <td'; if($total>200) $tabela .= $vermelho; $tabela .= '>R$'.number_format($total,2).'</td>
        </tr>';
    }
    echo $tabela;
    ?>
            </tbody>
        </table>
        <hr>
        <h2>TOTAL: R$<?php echo number_format($soma,2); ?></h2>
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
</body>
</html>





