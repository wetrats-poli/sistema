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

    // Conexão com o servidor MySQL
    require_once '../db_con.php';
    
    if ($nivel_usuario != "2"){
    $sql1 =  "SELECT (SELECT COUNT(*) FROM `presencas` WHERE `id_atleta`=$id_usuario AND id_treino>=238) AS npresenca , 
              (SELECT COUNT(DISTINCT id_treino) FROM presencas WHERE id_treino>=238) AS 'ntreinos' ;" ;
    $resultado = mysqli_query($con,$sql1);
    $res= mysqli_fetch_assoc($resultado);
    if ($res>0){
    $presenca= intval($res['npresenca']) / intval($res['ntreinos']) * 100;
    }
    else $presenca = 0;
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
    <title>Wetrats - Treinos</title>
</head>

<body style="background-color:rgba(255, 187, 0, 0.8)">
<!-----Modal para visualização de treino digitado------->
<div class="bg-modal">
	<div class="modal-contents">
        <div class="col">
        <div class="close" ><a href="#">+</a></div>
            <div id ="divDescricao"></div>    
        </div>
    </div>
</div>

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
          
          <div class="row">
        <!----Titulo--->
          <div class="col-6">
                  <div class="section_title_container">
                        <div class="section_title light" >
                            <div class="row"><h1>Histórico de treinos</h1>
                                <?php
                                    if($_SESSION['NIVEL'] == 2){ echo "<button type=\"button\" class=\"btn-primary\" onclick=\"window.location.href='../distribuicao_metragem'\" style=\"margin-left:60px; margin-bottom: 15px\">Distribuição Metragem</button>";}
                                ?>
                            </div>
                        </div>
                  </div>
          </div>

          <?php if($nivel_usuario != "2"){
                    echo '<div class="container_ranking" style="width:30%; margin-top:5px;">
                        <div class="col"> 
                            <h2>Sua presença:       </h2>
                            <div class="progress" style="height:20px; width:100%;">  
                                <div class="progress-bar '; 
                                if($presenca>=80 and $presenca<100) echo'bg-success'; if($presenca<80 and $presenca>=60) echo'bg-warning'; if($presenca<60) echo 'bg-danger'; 
                                echo '" style="width:'.$presenca.'%; height:20px" >'.number_format($presenca,2).'%
                                </div>
                            </div>
                         </div>
                         </div>';} 
            ?>
            </div>

    <div class="row">
        <!----Tabela------>
        <div class="col-6 custyle"> 
        <!--<h2 style="color: #fff; font-size:40px;"> HORÁRIO DAS 11</h2>-->
        <?php 
            $ano_atual = date("Y");
            if($_GET['ano'] != null){
                $ano = $_GET['ano'];
            }
            else{
                $ano = $ano_atual;
            }
            $ano = intval($ano);
            echo "<select name='ano' id='ano' onchange='window.location=\"https://www.wetrats.com.br/treinos/?ano=\"+this.value.toString()'>";
            for($i=$ano_atual; $i>=2019; $i--){
                if($i==2021) {
                    continue;
                }
                elseif($i==$ano){
                    echo "<option value=".$i." selected>".$i."</option>";
                }
                else {
                    echo "<option value=".$i.">".$i."</option>";
                }
            }
            echo "</select>";
        ?>
            <table class="tabela_treinos">
            <thead>
                <?php if($nivel_usuario !='1') echo '<a href="../criacao_treino/" class="btn btn-primary btn-xs pull-right">Adicionar treino</a>';
                if($nivel_usuario !='1') echo '<a href="./presencas.php" class="btn btn-primary btn-xs pull-right">Lista de presença</a>'; ?>
                <tr>
                    <th>Data</th>
                    <th>Treino</th>
                    <th>Série</th>
                    <?php if($nivel_usuario !='1') echo '<th class="text-center">Presença</th>'; ?>
                    <?php if($nivel_usuario !='1') echo '<th class="text-center">Ações</th>'; ?>
                </tr>
            </thead>


<?php

// Busca dos treinos
$sql =  "SELECT id, data, nome_foto, treino, serie_controle, tipo, total FROM treinos WHERE YEAR(data)=".$ano." ORDER BY data DESC ";

$treinos = mysqli_query($con, $sql);
$i=0;
$b=1000;
$c=10000;
while ($treino = mysqli_fetch_array($treinos)){
    $id = $treino['id'];
    $data = $treino['data'];
    $nome_foto = $treino['nome_foto'];
    $descricao = $treino['treino'];
    $descricao = str_replace('"' , ' `` ' , $descricao); //procedimento pra permitir a inclusao de aspas duplas
    $serie = $treino['serie_controle'];
    $tipo =$treino['tipo'];
    $date=date_create($data);
    $metragem = $treino['total'];
    $sql2 =  "SELECT `id_atleta`, `apelido` FROM `presencas` INNER JOIN `usuarios` ON `id_atleta` = `id` WHERE `id_treino` = $id ORDER BY apelido;" ;
    $presencas = mysqli_query($con,$sql2);
    $lista = "<div class='col'><div class='row' style='display:block; text-align: justify;text-align-last:center;'>LISTA DE PRESENÇA DO DIA: ".date_format($date,"d/m/Y")."</div>";
    $contador=0;
    $total=0;
    while ($presenca = mysqli_fetch_array($presencas)) {
        if ($contador==0) $lista.="<div class='row' style='display:block; text-align: justify;text-align-last:center;'>";
        $lista .= $presenca['apelido']; 
        $lista.='<a class=btn-danger style=padding-left:3px href=./remover_presenca.php?atleta='.$presenca['id_atleta'].'&treino='.$id.'>x</a>';
        $contador+=1;
        if ($contador==5) {
            $lista.="</div>";
            $contador=0;
        }
        $total+=1;
    }
    if ($contador!=5) $lista.="</div>";
    $lista.="</div>";  

    //preenchimento da tabela por linha
    
    echo   '<tr>
                <td>';if($nivel_usuario!="1") echo '<a href="../incluir_presenca/index.php?id='.$id.'&data='.$data.'">'; echo date_format($date,"d/m/Y"); if($nivel_usuario!="1") echo'</a>'; echo '</td> <td>'; //insere a data do treino com link para adicionar presença
                
    //caso o treino seja enviado por foto
    if (strlen($nome_foto)>3) echo'<a href="../common/uploads/treinos/'.$nome_foto.'"><u>Visualizar</u></a> <a href="../common/uploads/treinos/'.$nome_foto.'" download="treino'.date_format($date,"d/m/Y").'"><u>Baixar</u></a></td>';
    
    //caso o treino seja digitado
    else {
        echo '<div><button style="color:#000000;" id="'.$i.'" class="treino" onclick="exibe(this.id)" value="Treino do dia: '.date_format($date,"d/m/Y").'<br>'.$descricao.'<br>TOTAL: '.$metragem.'" type="button" href="#">Visualizar</button></div></td>';
        $i+=1;
    }
    
     //mostra a serie com link para adicionar performance
    echo   '<td><a href="../adicionar_performance_treino/index.php?id='.$id.'">'.$serie.'</a></td>';
    
    
    if($nivel_usuario !='1') { // mostra a lista de presenca
        echo ' <td class="text-center"><div><button style="color:#000000;" id="'.$b.'" class="treino"
                onclick="exibe(this.id)" value="'.$lista.'" href="#" type="button">'.$total.'</button></div></td>'; 
                $b+=1;
    }
    if($nivel_usuario !='1'){ echo ' <td class="text-center"><div><button id="'.$c.'" class="treino btn-danger" onclick="exibe(this.id)"
                
                value="<div><h1>Deletar treino do dia:'.date_format($date,"d/m/Y").' ? <h1></div>
                <div><a class=btn-danger href=./deletar.php?id='.$id.'&data='.date_format($date,"d/m/Y").'>Deletar</a></div>" 
                
                href="#" type="button">Deletar</button></div>
                
                <div><a class=btn href="./editar_treino.php?id='.$id.'"`>Editar</a></div></td> ' ; 
                $c+=1;
    }  
    echo '</tr>'; //opcao do tecnico de deletar  
    }
?>

            </table>
          </div>
          <!--<div class="col-6">
            
            <h2 style="color: #000; text-transform: uppercase">Treinos das 17h no final da página</h2>
          </div>-->
    </div>      
    <!--<div class="row">-->
        <!----Tabela 17------>
        <!--<div class="col-5 custyle"> 
            <h2 style="margin-top: 60px; color: #fff; font-size:40px;"> HORÁRIO DAS 17</h2>
            <!--?php if($_SESSION['NIVEL']!=1) echo ' 
                <div style="height:54px"></div>'; //Da um espaçamento
            ?>
            <table class="tabela_treinos">
            <thead>
        
        <tr>
            <th>Data</th>
            <th>Treino</th>
            <th>Série</th>
            <!--?php if($nivel_usuario !='1') echo '<th class="text-center">Presença</th>'; ?>
            <!--?php if($nivel_usuario !='1') echo '<th class="text-center">Ações</th>'; ?>
        </tr>
    </thead>


<!--?php

// Busca dos treinos
$sql =  "SELECT id, data, nome_foto, treino, serie_controle, tipo, total FROM treinos_17 ORDER BY data DESC ";
$treinos = mysqli_query($con, $sql);
$i=2000;
$b=20000;
$c=200000;
while ($treino = mysqli_fetch_array($treinos)){
    $id = $treino['id'];
    $data = $treino['data'];
    $nome_foto = $treino['nome_foto'];
    $descricao = $treino['treino'];
    $descricao = str_replace('"' , ' `` ' , $descricao); //procedimento pra permitir a inclusao de aspas duplas
    $serie = $treino['serie_controle'];
    $tipo =$treino['tipo'];
    $date=date_create($data);
    $metragem = $treino['total'];
    $sql2 =  "SELECT `id_atleta`, `apelido` FROM `presencas` INNER JOIN `usuarios` ON `id_atleta` = `id` WHERE `id_treino` = $id ORDER BY apelido;" ;
    $presencas = mysqli_query($con,$sql2);
    $lista = "<div class='col'><div class='row' style='display:block; text-align: justify;text-align-last:center;'>LISTA DE PRESENÇA DO DIA: ".date_format($date,"d/m/Y")."</div>";
    $contador=0;
    $total=0;
    while ($presenca = mysqli_fetch_array($presencas)) {
        if ($contador==0) $lista.="<div class='row' style='display:block; text-align: justify;text-align-last:center;'>";
        $lista .= $presenca['apelido']; 
        $lista.='<a class=btn-danger style=padding-left:3px href=./remover_presenca.php?atleta='."   ".$presenca['id_atleta'].'&treino='.$id.'>x</a>';
        $contador+=1;
        if ($contador==5) {
            $lista.="</div>";
            $contador=0;
        }
        $total+=1;
    }
    if ($contador!=5) $lista.="</div>";
    $lista.="</div>";  

    //preenchimento da tabela por linha
    
    echo   '<tr>
                <td>';if($nivel_usuario!="1") echo '<a href="../incluir_presenca/index.php?id='.$id.'&data='.$data.'">'; echo date_format($date,"d/m/Y"); if($nivel_usuario!="1") echo'</a>'; echo '</td> <td>'; //insere a data do treino com link para adicionar presença
                
    //caso o treino seja enviado por foto
    if (strlen($nome_foto)>3) echo'<a href="../common/uploads/treinos/'.$nome_foto.'"><u>Visualizar</u></a> <a href="../common/uploads/treinos/'.$nome_foto.'" download="treino'.date_format($date,"d/m/Y").'"><u>Baixar</u></a></td>';
    
    //caso o treino seja digitado
    else {
        echo '<div><button style="color:#000000;" id="'.$i.'" class="treino" onclick="exibe(this.id)" value="Treino do dia: '.date_format($date,"d/m/Y").'<br>'.$descricao.'<br>TOTAL: '.$metragem.'" type="button" href="#">Visualizar</button></div></td>';
        $i+=1;
    }
    
     //mostra a serie com link para adicionar performance
    echo   '<td><a href="../adicionar_performance_treino/index.php?id='.$id.'">'.$serie.'</a></td>';
    
    
    if($nivel_usuario !='1') { // mostra a lista de presenca
        echo ' <td class="text-center"><div><button style="color:#000000;" id="'.$b.'" class="treino"
                onclick="exibe(this.id)" value="'.$lista.'" href="#" type="button">'.$total.'</button></div></td>'; 
                $b+=1;
    }
    if($nivel_usuario !='1'){ echo ' <td class="text-center"><div><button id="'.$c.'" class="treino btn-danger" onclick="exibe(this.id)"
                
                value="<div><h1>Deletar treino do dia:'.date_format($date,"d/m/Y").' ? <h1></div>
                <div><a class=btn-danger href=./deletar.php?id='.$id.'&data='.date_format($date,"d/m/Y").'>Deletar</a></div>" 
                
                href="#" type="button">Deletar</button></div>
                
                <div><a class=btn href="./editar_treino.php?id='.$id.'"`>Editar</a></div></td> ' ; 
                $c+=1;
    }  
    echo '</tr>'; //opcao do tecnico de deletar  
    }
?>

            </table>
          </div>
        </div>-->



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