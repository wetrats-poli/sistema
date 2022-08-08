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

    if ($nivel_usuario == "1"){
        $_SESSION['ALERTA']= "Área restrita!";
        header("Location: ../perfil/index.php"); exit;
    }
    $meses= ["1" => "Janeiro","2" => "Fevereiro","3" => "Março","4" => "Abril","5" => "Maio","6" => "Junho",
    "7" => "Julho","8" => "Agosto","9" => "Setembro","10" => "Outubro","11" => "Novembro","12" => "Dezembro",];

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
    <title>Wetrats - Presença</title>
</head>

<body style="background-color:rgba(255, 187, 0, 0.8)">
<div id="page">
<nav class="fh5co-nav" id="menu-list" role="navigation">
    <div id="menu"></div>
</nav>
<div id="menus"></div>   
                                
      <div class="container-fluid" style="padding-top:60px;">
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
        ?>    
        </div>        
        
        <!----Titulo--->
          <div class="row">
            <div class="col-6">
                  <div class="section_title_container">
                      <div class="section_title light" ><h1>Presença por atleta</h1></div>
                  </div>
            </div>
          </div>

        <div class="row">
        <div class="col-8">
          <table class="tabela_presenca">
            <thead>
                <tr>
                <th>Atleta</th>
                <th style="text-align:center;">Total</th>
                <th style="text-align:center;">Mês<?php if(isset($_POST['mes']))echo "(".$meses[$_POST['mes']].")"; else  echo "(".$meses[date('n')].")";?></th>
                </tr>
            </th>

          <?php 
                // Conexão com o servidor MySQL
                $con = mysqli_connect("auth-db213.hostinger.com.br", "u418844475_wtr", "wetrats2019", "u418844475_wtr");

                // Contagem do número de treinos
                $sql1="SELECT (SELECT COUNT(DISTINCT id_treino) FROM presencas WHERE id_treino>=238) AS 'ntreinos'  , 
                (SELECT COUNT(DISTINCT id_treino) FROM presencas INNER JOIN treinos ON treinos.id=presencas.id_treino
                WHERE MONTH(treinos.data)="; if(isset($_POST['mes'])) $sql1.=$_POST['mes']; else $sql1.=date('n');
                $sql1.=" AND YEAR(data)=".date('Y').") AS 'ntreinos_mes' " ;
                $resultado = mysqli_query($con, $sql1);
                $res = mysqli_fetch_assoc($resultado);
        
                

                // Contagem da presença por atleta
                $sql2= "SELECT usuarios.nome, id_atleta, COUNT(CASE WHEN id_treino>=238 THEN 1 ELSE NULL END) AS 'presenca_total', COUNT(CASE WHEN MONTH(treinos.data)=";
                if(isset($_POST['mes'])) $sql2.=$_POST['mes']; else $sql2.=date('n');
                $sql2.= " AND YEAR(treinos.data)=".date('Y')." THEN 1 ELSE NULL END) AS 'presenca_mensal' 
                FROM `presencas` 
                INNER JOIN `usuarios` ON presencas.id_atleta = usuarios.id 
                INNER JOIN `treinos` ON presencas.id_treino = treinos.id 
                WHERE usuarios.ativo=1 
                GROUP BY usuarios.nome  
                ORDER BY COUNT(*) DESC  ;" ;

                $resultado = mysqli_query($con, $sql2);
                
                while($row= mysqli_fetch_assoc($resultado)){
                    $presenca = $row['presenca_total'];
                    $presenca_mensal = $row['presenca_mensal'];
                    if ($presenca>0){
                        $presenca = intval($presenca) / intval($res['ntreinos']) * 100;
                        }
                    else $presenca = 0;
                    
                    if ($presenca_mensal>0){
                        $presenca_mensal = intval($presenca_mensal) / intval($res['ntreinos_mes']) * 100;
                        }
                    else $presenca_mensal = 0;
                    
                        
                    echo ' <tr>
                            <td>'.$row['nome'].'</td> 
                            <td><div class="progress" style="height:20px; width:200px; margin-left:5px;">  
                                <div class="progress-bar '; 
                                if($presenca>=80 and $presenca<100) echo'bg-success'; if($presenca<80 and $presenca>=60) echo'bg-warning'; if($presenca<60) echo 'bg-danger'; 
                                echo '" style="width:'.$presenca.'%; height:20px" >'.number_format($presenca,2).'%
                                </div>
                            </div></td>
                            <td><div class="progress" style="height:20px; width:200px;">  
                                <div class="progress-bar '; 
                                if($presenca_mensal>=80 and $presenca_mensal<100) echo'bg-success'; if($presenca_mensal<80 and $presenca_mensal>=60) echo'bg-warning'; if($presenca_mensal<60) echo 'bg-danger'; 
                                echo '" style="width:'.$presenca_mensal.'%; height:20px" >'.number_format($presenca_mensal,2).'%
                                </div>
                            </div></td>
                         </tr>';
                } 
            ?>
            </table>
            </div>

            <div class="col-4">
              <div class="container_form">
                <form action="presencas.php" method="post">

                <div class="row form-group">
                    <div class="col-8">
                    <label>Mês:</label>
                    <select name="mes">
                        <option value="1" <?if($_POST['mes']=="1") echo 'selected';?>>Janeiro</option>
                        <option value="2" <?if($_POST['mes']=="2") echo 'selected';?>>Fevereiro</option>
                        <option value="3" <?if($_POST['mes']=="3") echo 'selected';?>>Março</option>
                        <option value="4" <?if($_POST['mes']=="4") echo 'selected';?>>Abril</option>
                        <option value="5" <?if($_POST['mes']=="5") echo 'selected';?>>Maio</option>
                        <option value="6" <?if($_POST['mes']=="6") echo 'selected';?>>Junho</option>
                        <option value="7" <?if($_POST['mes']=="7") echo 'selected';?>>Julho</option>
                        <option value="8" <?if($_POST['mes']=="8") echo 'selected';?>>Agosto</option>
                        <option value="9" <?if($_POST['mes']=="9") echo 'selected';?>>Setembro</option>
                        <option value="10" <?if($_POST['mes']=="10") echo 'selected';?>>Outubro</option>
                        <option value="11" <?if($_POST['mes']=="11") echo 'selected';?>>Novembro</option>
                        <option value="12" <?if($_POST['mes']=="12") echo 'selected';?>>Dezembro</option>
                    </select>
                    </div>

                    <div class="col-4"><button class="btn btn-primary" type="submit">Filtrar</button></div>
                </div>
                </form>
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
</body>
</html>