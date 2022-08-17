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

  if (strlen($_GET['id'])>0)$id_devedor = $_GET['id'];
  else $id_devedor = $_SESSION['ID'];
  if (($nivel_usuario != "3") and ($id_usuario != $id_devedor)){
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
            <div class="section_title light" ><h1>Financeiro</h1></div>
        </div>
        <?php if ($nivel_usuario == "3") echo '
        <div class="col-4 offset-1">
            <a href="../criacao_divida/index.php"><button class="btn-primary">Lançar dívidas</button></a>
        </div>'; ?>
    </div>
    <?php 
    if ($nivel_usuario == "3"){ // mostra o relatorio geral
    echo '<div class="col-12">
    <div class="row">
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
            <tbody>'; 
    $nomes = array();
    $tabela="";
    $soma = 0;
    $vermelho = ' style="background-color:rgb(256,0,0); color:rgb(0,0,0);"';
    // Conexão com o servidor MySQL
    $con = mysqli_connect("auth-db213.hstgr.io", "u418844475_wtr", "wetrats2019", "u418844475_wtr");
    
    // calculo do total q cada um deve
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
        $nomes[$id] = $nome;
        $tabela .='
        <tr>
            <td><a href="./detalhes.php?id='.$id.'"'.'>'.$nome.'</a></td>
            <td'; if($total>200) $tabela .= $vermelho; $tabela .= '>R$'.number_format($total,2).'</td>
        </tr>';
    }

    //relacao dos q estao com suas dividas quitadas
    $sql2 = "SELECT id , nome , '0' AS 'total' FROM `usuarios` 
    WHERE id NOT IN ( SELECT id_devedor FROM `financeiro` WHERE status = 'NP') AND id!=31 
    GROUP BY `nome` ORDER BY `nome` ASC";
    $resultado = mysqli_query($con, $sql2);
    while($row = mysqli_fetch_assoc($resultado)){
        $id = $row['id'];
        $nome = $row['nome'];
        $nomes[$id] = $nome;
        $total = $row['total'];
        $tabela .='
        <tr>
            <td><a href="./detalhes.php?id='.$id.'"'.'>'.$nome.'</a></td>
            <td'; if($total>200) $tabela .= $vermelho; $tabela .= '>R$'.number_format($total,2).'</td>
        </tr>';
    }

    echo $tabela;
    
    echo '        </tbody>
        </table>
        <hr>
        <h2>TOTAL: R$'.number_format($soma,2).'</h2>
    </div>';
    }
    
    //segunda tabela(nao pagos)
    
    // Conexão com o servidor MySQL
    $con = mysqli_connect("auth-db213.hstgr.io", "u418844475_wtr", "wetrats2019", "u418844475_wtr");
    $a=0;
    $tabela2 = "";
    $soma2 = 0;
    $sql2 = "SELECT financeiro.id AS 'id' , valor , descricao , data_criacao, usuarios.nome AS 'nome' 
    FROM `financeiro` INNER JOIN `usuarios` ON financeiro.id_devedor = usuarios.id  
    WHERE status='NP' AND id_devedor=".$id_devedor.'
    ORDER BY data_criacao DESC ;' ;
    $resultado = mysqli_query($con, $sql2);
    while ($row = mysqli_fetch_assoc($resultado)){
        $id_divida = $row['id'];
        $nome = $row['nome'];
        $valor = $row['valor'];
        $descricao = $row['descricao'];
        $data = date_create($row['data_criacao']);
        $soma2 += $valor ;
        $tabela2 .='
        <tr>
            <td>'.date_format($data,"d/m/Y").'</td>
            <td>'.$descricao.'</td>
            <td>R$'.number_format($valor,2).'</td>';
            if ($nivel_usuario == "3") $tabela2 .= '
            <td><a href="./descer_divida.php?id='.$id_divida.'&id_devedor='.$_GET['id'].'"><img src="../common/images/seta_baixo.png"  height="16" width="15"></a>
            <button id="'.$a.'" class="treino" onclick="exibe(this.id)"
                
                value="<div>
                            <div class=row><h1>Nome:'.$nome.' </h1></div>
                            <div class=row><h2>Data:'.date_format($data,"d/m/Y").'</h2></div>
                            <div class=row><h2>Descrição:'.$descricao.'</h2></div>
                            <div class=row><h2>Valor:'.number_format($valor,2).'</h2></div>
                        </div>
                <div><a class=btn-danger href=./deletar.php?id='.$id_divida.'&id_devedor='.$_GET['id'].'>Deletar</a></div>"
                
                href="#"><img src="../common/images/deletar.png"  height="16" width="15"></button></td>
        </tr>';
        $a += 1;
    }

    //terceira tabela(pagos)
    $b=100000;
    $tabela3 = "";
    $sql3 = "SELECT financeiro.id AS 'id' , valor , descricao , data_criacao, atualizacao, usuarios.nome AS 'nome' 
    FROM `financeiro` INNER JOIN `usuarios` ON financeiro.id_devedor = usuarios.id  
    WHERE status='P' AND id_devedor=".$id_devedor.'
    ORDER BY data_criacao DESC ;' ;
    $resultado = mysqli_query($con, $sql3);
    while ($row = mysqli_fetch_assoc($resultado)){
        $id_divida = $row['id'];
        $nome = $row['nome'];
        $valor = $row['valor'];
        $descricao = $row['descricao'];
        $data = date_create($row['data_criacao']);
        $atualizacao = date_create($row['atualizacao']);
        $tabela3 .='
        <tr>
            <td>'.date_format($data,"d/m/Y").'</td>
            <td>'.date_format($atualizacao,"d/m/Y H:m:s").'</td>
            <td>'.$descricao.'</td>
            <td>R$'.number_format($valor,2).'</td>';
            if ($nivel_usuario == "3") $tabela3 .= '
            <td>
            <a href="./subir_divida.php?id='.$id_divida.'&id_devedor='.$_GET['id'].'"><img src="../common/images/seta_baixo.png" height="16" width="15" style="transform:rotate(180deg);"></a>
            <button id="'.$b.'" class="treino" onclick="exibe(this.id)"
                
            value="<div>
                        <div class=row><h1>Nome:'.$nome.' </h1></div>
                        <div class=row><h2>Data:'.date_format($data,"d/m/Y").'</h2></div>
                        <div class=row><h2>Descrição:'.$descricao.'</h2></div>
                        <div class=row><h2>Valor:'.number_format($valor,2).'</h2></div>
                    </div>
            <div><a class=btn-danger href=./deletar.php?id='.$id_divida.'&id_devedor='.$_GET['id'].'>Deletar</a></div>"
            
            href="#"><img src="../common/images/deletar.png"  height="16" width="15"></button></td>
    </tr>';
    $b += 1;

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
                <h3>'.$nomes[$_GET['id']].'</h3>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <h2>TOTAL: R$'.number_format($soma2,2).'</h2>
              </div>
            </div>
            ';
            if ($nivel_usuario == "3") echo '
            <div class="row">
              <div class="col">
                <a href="./zerar.php?id='.$_GET['id'].'"><button class="btn-primary">Zerar</button></a>
              </div>
            </div>
            ';
            //if ($id_usuario == $id_devedor){ //pagamento via pagSeguro
            
            //if($soma2>100) $soma2=$soma2*1.05;
            
            //echo '
            //    <script>
            //        function enviaPagseguro(){
            //        $.post("pagseguro.php?valor='.$soma2.'","",function(data){
            //        $("#code").val(data);
            //        $("#comprar").submit();
            //        })
            //        }
            //    </script>

            //<div class="row" style="padding-top:5px;">
            //  <div class="col">
            //    <button class="btn-primary" onclick="enviaPagseguro()">Pagar</button>

            //        <form id="comprar" action="https://pagseguro.uol.com.br/v2/checkout/payment.html" method="post" onsubmit="PagSeguroLightbox(this); return false;">

            //        <input type="hidden" name="code" id="code" value="" /></form>
            //  </div>
            //</div>
            //<div class="row">
            //    <div class="col">
            //        <p>*acréscimo de taxa de 5% para valores maiores que R$100</p>
            //    </div>
            //</div>';
            //        }
            ?>
        </div>
        
        <div class="col-9">    
            <h3>Dívidas Pendentes</h3>
            <hr>
            <table class="tabela_financeiro_geral1">
                <thead>
                <tr>
                    <th>Data</th>
                    <th>Descrição</th>
                    <th>Valor</th>
                    <th></th>
                </thead>
                </tr>
                <tbody>
                <?php
                echo $tabela2;
                ?>
                </tbody>
            </table>

            <h3 style="padding-top:30px;">Dívidas Pagas</h3>
            <hr>
            <table class="tabela_financeiro_geral2">
                <thead>
                <tr>
                    <th>Data</th>
                    <th>Data de pagamento</th>
                    <th>Descrição</th>
                    <th>Valor</th>
                    <th></th>
                </thead>
                </tr>
                <tbody>
                <?php
                echo $tabela3;
                ?>
                </tbody>
            </table>
        </div>
    <?php  if ($nivel_usuario == "3") echo ' 
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
<script type="text/javascript"
src="https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js">
</script>
</body>
</html>
