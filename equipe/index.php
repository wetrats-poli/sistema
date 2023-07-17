<?php
    session_start();
    
    // Verifica se existe ID da sessão
    if(!isset($_SESSION['ID'])){
    
        //Destrói a sessão por segurança
        session_destroy();

        //Redireciona para o login
        header("Location: ../index.php"); exit;
        }
    
    //Inicia uma sessão
    session_start();
    $id_usuario = $_SESSION['ID'];
    $nivel_usuario = $_SESSION['NIVEL'];

    if($nivel_usuario!="3"){
        $_SESSION['ALERTA']="Área Restrita!";
        header("Location:../index.php"); exit;
    }
    

?>

<html lang="pt-BR">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
    <link rel="stylesheet" href="../common/stylesheets/bootstrap.css">
    <link rel="stylesheet" href="../common/stylesheets/bootstrap4.css">
    <link rel="stylesheet" href="../common/stylesheets/animate.css">
    <link rel="stylesheet" href="../common/stylesheets/style.css">
    <link rel="stylesheet" href="../common/stylesheets/style1.css"> 
    <link rel="icon" type="image/png" href="../common/images/favicon-32x32.png" sizes="32x32" />
    <title>Wetrats - Equipe</title>
</head>

<body>
<!-----Modal------->
<div class="bg-modal">
	    <div class="modal-contents">
            <div class="close" ><a href="#">+</a></div>
            <div class="col">
                <div id ="divDescricao"></div>    
            </div>
        </div>
    </div>
<div id="page">

<nav class="fh5co-nav" id="menu-list" role="navigation">
    <div id="menu"></div>
</nav>
<div id="menus"></div>
   

<div class="super_container" style="padding-top:60px; margin-left:20px; margin-right:20px;">
    <div class="row">                                 
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


    // Conexão com o servidor MySQL
    $con = mysqli_connect("auth-db213.hstgr.io", "u418844475_wtr", "Wetrats2019", "u418844475_wtr");

    $tabelaf="";
    $totalf=0;
    // Busca das informações referentes ao usuários ativos do sexo feminino
    $sql= "SELECT * FROM `usuarios` WHERE ativo=1 AND sexo='F' ORDER BY nome";
    $resultado= mysqli_query($con, $sql);
    while($row=mysqli_fetch_assoc($resultado)){
        $date=date_create($row['aniversario']);
        $data=date_format($date,"d/m/Y");
        $tabelaf.= "<tr>
                    <td>".$row['nome']."</td>
                    <td>".$data."</td>
                    <td>".$row['RG']."</td>
                    <td>".$row['NUSP']."</td>
                    <td>".$row['celular']."</td>
                    <td>".$row['email']."</td>
                    <td>".$row['endereco']."</td>
                    <td>".
                        ($row['pagante'] == 0 ? "<a href='./ativar_pagante.php?id=".$row['id']."'><img src='../common/images/Red_Light_Icon.svg.png' height='15' width='15'></a>" : "<a href='./desativar_pagante.php?id=".$row['id']."'><img src='../common/images/Green_Light_Icon.svg.png' height='15' width='15'></a>")
                    ."</td>
                    <td><a href='./desativar.php?id=".$row['id']."'><img src='../common/images/Green_Light_Icon.svg.png' height='15' width='15'></a>
                        <a href='../edicao_usuario/index.php?id=".$row['id']."'>Editar</a></td>
                        
                   </tr>";
        $totalf += 1;
    }

    $totalm=0;
    $tabelam="";
    // Busca das informações referentes ao usuários ativos do sexo masculino
    $sql= "SELECT * FROM `usuarios` WHERE ativo=1 AND sexo='M' ORDER BY nome";
    $resultado= mysqli_query($con, $sql);
    while($row=mysqli_fetch_assoc($resultado)){
        $date=date_create($row['aniversario']);
        $data=date_format($date,"d/m/Y");
        $tabelam.= "<tr>
                    <td>".$row['nome']."</td>
                    <td>".$data."</td>
                    <td>".$row['RG']."</td>
                    <td>".$row['NUSP']."</td>
                    <td>".$row['celular']."</td>
                    <td>".$row['email']."</td>
                    <td>".$row['endereco']."</td>
                    <td>".
                        ($row['pagante'] == 0 ? "<a href='./ativar_pagante.php?id=".$row['id']."'><img src='../common/images/Red_Light_Icon.svg.png' height='15' width='15'></a>" : "<a href='./desativar_pagante.php?id=".$row['id']."'><img src='../common/images/Green_Light_Icon.svg.png' height='15' width='15'></a>")
                    ."</td>
                    <td><a href='./ativar.php?id=".$row['id']."'><img src='../common/images/Green_Light_Icon.svg.png' height='15' width='15'></a>
                        <a href='../edicao_usuario/index.php?id=".$row['id']."'>Editar</a></td>
                   </tr>";
        $totalm+=1;
    }

    $tabelai="";
    // Busca das informações referentes ao usuários inativos
    $sql= "SELECT * FROM `usuarios` WHERE ativo=0 ORDER BY nome";
    $resultado= mysqli_query($con, $sql);
    while($row=mysqli_fetch_assoc($resultado)){
        $date=date_create($row['aniversario']);
        $data=date_format($date,"d/m/Y");
        $tabelai.= "<tr>
                    <td>".$row['nome']."</td>
                    <td>".$data."</td>
                    <td>".$row['RG']."</td>
                    <td>".$row['NUSP']."</td>
                    <td>".$row['celular']."</td>
                    <td>".$row['email']."</td>
                    <td>".$row['endereco']."</td>
                    <td><a href='./ativar.php?id=".$row['id']."'><img src='../common/images/Red_Light_Icon.svg.png' height='15' width='15'></a>
                    <a href='../edicao_usuario/index.php?id=".$row['id']."'>Editar</a></td>
                   </tr>";
    }  
?>
    </div>
    
    <div class="row">
        <div class="section_title_container col-6">
            <div class="section_title light" ><h1>Gerenciamento da equipe</h1></div>
        </div>
        <div class="col-3 offset-3">
            <a href="../criacao_usuario/index.php"><button class="btn-primary">Adicionar usuário</button></a>
        </div>
    </div>
    <hr>

    <div class="col-12" style="padding-right:40px;">

        <div class="row" style="margin-top:10px;">
            <div class="col-6">
                <h2>Feminino</h2>
            </div>
            <div class="col-3 offset-3">
                <h2>TOTAL:<?php echo $totalf;?></h2>
            </div>
        </div>
    
        <table class="tabela_equipe">
            <thead>
              <tr>
                <th>Nome</th>
                <th>Data de nascimento</th>
                <th>RG</th>
                <th>NUSP</th>
                <th>Celular</th>
                <th>Email</th>
                <th>Endereço</th>
                <th>Pagante</th>
                <th>Ativo</th>
              </tr>
            </thead>
            <tbody>
                <?php echo $tabelaf;?>
            </tbody>
        </table>

        <div class="row" style="margin-top:10px;">
            <div class="col-6">
                <h2>Masculino</h2>
            </div>
            <div class="col-3 offset-3">
                <h2>TOTAL:<?php echo $totalm;?></h2>
            </div>
        </div>

    
        <table class="tabela_equipe">
            <thead>
              <tr>
                <th>Nome</th>
                <th>Data de nascimento</th>
                <th>RG</th>
                <th>NUSP</th>
                <th>Celular</th>
                <th>Email</th>
                <th>Endereço</th>
                <th>Pagante</th>
                <th>Ativo</th>
              </tr>
            </thead>
            <tbody>
                <?php echo $tabelam;?>
            </tbody>
        </table>

    <div class="row" style="margin-top:10px;">
        <h1>Usuários inativos</h1>
    </div>
    
        <table class="tabela_equipe">
            <thead>
              <tr>
                <th>Nome</th>
                <th>Data de nascimento</th>
                <th>RG</th>
                <th>NUSP</th>
                <th>Celular</th>
                <th>Email</th>
                <th>Endereço</th>
                <th>Ativo</th>
              </tr>
            </thead>
            <tbody>
                <?php echo $tabelai;?>
            </tbody>
        </table>
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