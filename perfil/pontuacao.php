<html lang="pt-BR">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
    <link rel="stylesheet" href="../common/stylesheets/bootstrap.css">
    <link rel="stylesheet" href="../common/stylesheets/bootstrap4.css">
    <link rel="stylesheet" href="../common/stylesheets/animate.css">
    <link rel="stylesheet" href="../common/stylesheets/style.css">
    <link rel="stylesheet" href="../common/stylesheets/style1.css">
    <link rel="icon" type="image/png" href="../common/images/favicon-32x32.png" sizes="32x32" />
    <title>Projeto InterUSP</title>
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

  // Conexão com o servidor MySQL
  require_once '../db_con.php';

  //busca da pontuação dos lideres
  $sql="SELECT usuarios.nome AS 'nome', usuarios.apelido AS 'apelido', usuarios.id AS 'id' , usuarios.foto AS 'foto', SUM(
    (SELECT COUNT(*) FROM presencas WHERE presencas.id_atleta=usuarios.id) + 
    (COALESCE((SELECT SUM(CASE WHEN tipo='A' THEN 1 WHEN tipo='C' THEN 2 ELSE 0.5 END) FROM projetoiusp WHERE projetoiusp.id_atleta=usuarios.id),0))) AS 'total'   
    FROM `usuarios` 
    WHERE usuarios.ativo=1 AND usuarios.sexo='F'
    GROUP BY `nome`
    ORDER BY `total` DESC 
    LIMIT 3";

  $lideresfem=array();
  $query=mysqli_query($con,$sql);
  $k=1;
  while($row=mysqli_fetch_assoc($query)){
      $lideresfem[$k]['id']=$row['id'];
      $lideresfem[$k]['nome']=$row['nome'];
      $lideresfem[$k]['apelido']=$row['apelido'];
      $lideresfem[$k]['foto']=$row['foto'];
      $lideresfem[$k]['total']=$row['total'];
      $k+=1;
  }

  $sql="SELECT usuarios.nome AS 'nome', usuarios.apelido AS 'apelido', usuarios.id AS 'id' , usuarios.foto AS 'foto', SUM(
    (SELECT COUNT(*) FROM presencas WHERE presencas.id_atleta=usuarios.id) + 
    (COALESCE((SELECT SUM(CASE WHEN tipo='A' THEN 1 WHEN tipo='C' THEN 2 ELSE 0.5 END) FROM projetoiusp WHERE projetoiusp.id_atleta=usuarios.id),0))) AS 'total'   
    FROM `usuarios` 
    WHERE usuarios.ativo=1 AND usuarios.sexo='M'
    GROUP BY `nome`
    ORDER BY `total` DESC 
    LIMIT 3";

  $lideresmasc=array();
  $query=mysqli_query($con,$sql);
  $k=1;
  while($row=mysqli_fetch_assoc($query)){
      $lideresmasc[$k]['id']=$row['id'];
      $lideresmasc[$k]['nome']=$row['nome'];
      $lideresmasc[$k]['apelido']=$row['apelido'];
      $lideresmasc[$k]['foto']=$row['foto'];
      $lideresmasc[$k]['total']=$row['total'];
      $k+=1;
  }

  //busca da pontuação do usuario
  $sql="SELECT SUM((SELECT COUNT(*) FROM presencas WHERE presencas.id_atleta=".$id_usuario.") + 
    (COALESCE((SELECT SUM(CASE WHEN tipo='A' THEN 1 WHEN tipo='C' THEN 2 ELSE 0.5 END) FROM projetoiusp WHERE projetoiusp.id_atleta=".$id_usuario."),0))) AS 'total' "; 
  $query=mysqli_query($con,$sql);
  $row=mysqli_fetch_assoc($query);
  $pontuacao=$row['total'];
  
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
            <div class="section_title light" ><h1>Projeto InterUSP</h1></div>
        </div>
    </div>

    <div class="fundo">
    <div class="prova">
        <h1 style="color: rgba(255,255,255);font-weight:bold;">Projeto InterUSP</h1>
    </div> 
    <div class="row form-group"> 
        <div class="container_projeto">
          <div class="col">
          <h2 style="color:#000;font-size:40px;font-weight:bold;">FEMININO</h2>
          </div>
          <div style='position:relative;left:-25%;top:15%;'>
              <?php echo "<div>
                            <img src='../common/uploads/fotosdeperfil/".$lideresfem[2]['foto']."' height=80 width=60>
                          </div>
                          <div style='font-weight:bold;'>".$lideresfem[2]['apelido']." - ".$lideresfem[2]['total']."</div>";?>
            </div>
            <div style='position:relative;left:1%;top:-36%;'>
              <?php echo "<div>
                            <img src='../common/uploads/fotosdeperfil/".$lideresfem[1]['foto']."' height=80 width=60>
                          </div>
                          <div style='font-weight:bold;'>".$lideresfem[1]['apelido']." - ".$lideresfem[1]['total']."</div>";?>
            </div>
            <div style='position:relative;left:30%;top:-58%;'>
              <?php echo "<div>
                            <img src='../common/uploads/fotosdeperfil/".$lideresfem[3]['foto']."' height=80 width=60>
                          </div>
                          <div style='font-weight:bold;'>".$lideresfem[3]['apelido']." - ".$lideresfem[3]['total']."</div>";?>
            </div>
            <div style='position:relative;left:0%;z-index=-1;top:-70%;'><img src="../common/images/Podium.png" width=80% height=40%></div>
          </div>

          <div class="container_projeto">
          <div class="col">
          <h2 style="color:#000;font-size:40px;font-weight:bold;">MASCULINO</h2>
          </div>
          <div style='position:relative;left:-25%;top:15%;'>
              <?php echo "<div>
                            <img src='../common/uploads/fotosdeperfil/".$lideresmasc[2]['foto']."' height=80 width=60>
                          </div>
                          <div style='font-weight:bold;'>".$lideresmasc[2]['apelido']." - ".$lideresmasc[2]['total']."</div>";?>
            </div>
            <div style='position:relative;left:1%;top:-36%;'>
              <?php echo "<div>
                            <img src='../common/uploads/fotosdeperfil/".$lideresmasc[1]['foto']."' height=80 width=60>
                          </div>
                          <div style='font-weight:bold;'>".$lideresmasc[1]['apelido']." - ".$lideresmasc[1]['total']."</div>";?>
            </div>
            <div style='position:relative;left:30%;top:-58%;'>
              <?php echo "<div><img src='../common/uploads/fotosdeperfil/".$lideresmasc[3]['foto']."' height=80 width=60>
                          </div>
                          <div style='font-weight:bold;'>".$lideresmasc[3]['apelido']." - ".$lideresmasc[3]['total']."</div>";?>
            </div>
            <div style='position:relative;left:0%;z-index=-1;top:-70%;'><img src="../common/images/Podium.png" width=80% height=40%></div>
          </div>
      </div>
      </div>


        <div class="row" style="margin:15px;">
            <div style="color:white;font-weight:bold;"><?php echo date('G')."Sua pontuação atual: ".$pontuacao ;?></div>
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
