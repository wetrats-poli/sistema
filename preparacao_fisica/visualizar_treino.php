<html lang="pt-BR">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="../common/stylesheets/bootstrap.css">
    <link rel="stylesheet" href="../common/stylesheets/bootstrap4.css">
    <link rel="stylesheet" href="../common/stylesheets/animate.css">
    <link rel="stylesheet" href="../common/stylesheets/style.css">
    <link rel="stylesheet" href="../common/stylesheets/style1.css">
    <link rel="icon" type="image/png" href="../common/images/favicon-32x32.png" sizes="32x32" />
    <title>Wetrats - Preparação Física</title>
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
    $nivel_usuario = $_SESSION['NIVEL'];
    $id_treino = $_GET['id_treino'];

    $con = mysqli_connect("srv976.hstgr.io", "u418844475_wtr", "Wetrats2019", "u418844475_wtr");
    $sql0 = "SELECT * FROM treinos_academia WHERE id=".$id_treino.";";
    $query_treino=mysqli_query($con, $sql0);
    $treino = mysqli_fetch_assoc($query_treino);
    $n=$treino['n_exercicios'];

?>


<body>
    <div class="bg-modal">
        <div class="modal-contents" style="margin-top:30px;">
            <div class="col">
                <div class="close"><a href="#">+</a></div>
                <div id="divDescricao"></div>
            </div>
        </div>
    </div>

    <div id="page">
        <nav class="fh5co-nav" id="menu-list" role="navigation">
            <div id="menu"></div>
        </nav>
        <div id="menus"></div>

        <div class="container-fluid" style="padding-top:60px;">
            <?php
            if (isset($_SESSION['MSG'])){
                echo '<div class="alert alert-success" role="alert">'.$_SESSION['MSG'].'</div>';
                unset($_SESSION['MSG']);

            if (isset($_SESSION['ALERTA'])){
                    echo '<div class="alert alert-danger" role="alert">'.$_SESSION['ALERTA'].'</div>';
                    unset($_SESSION['ALERTA']);
            }
            }
        ?>

        </div>
        <div class="col">
            <div class="container_form" style="width:auto">
                <div class="row form-group">
                    <h2><?php echo " ".$treino['nome']." (".$treino['tipo'].")";?></h2>
                    <?php 
                    if ($nivel_usuario == 2){
                        echo '
                            <div style="padding:0px; padding-left:10px;">
                                <button class=btn style="background-color:#FFB000;padding:0;padding-top:3px; padding-bottom:3px;width:26px" id=treino onclick="exibe(this.id)" value="
                                <form method=post action=\'./edita_treino.php?id='.$id_treino.'\'>

                                <div class=\'row form-group\'>
                                    <label for=\'Nome\' style=\'width:23%\'>Nome:</label>
                                    <input style=\'width:60%\' class=\'form-control\' type=\'text\' name=\'nome\' value=\''.$treino['nome'].'\' required></td>
                                </div>

                                <div class=\'row form-group\'>
                                    <label for=\'Grupo\' style=\'width:23%\'>Grupo:</label>
                                    <input style=\'width:60%\' class=\'form-control\' type=\'text\' name=\'grupo\' value=\''.$treino['grupo'].'\' required></td>
                                </div>

                                <div class=\'row form-group\'>
                                    <label for=\'Tipo\' style=\'width:23%\'>Tipo:</label>
                                    <input style=\'width:60%\' class=\'form-control\' type=\'text\' name=\'tipo\' value=\''.$treino['tipo'].'\' required></td>
                                </div>

                                
                                    <input style=\'width:8%\' class=\'form-control\' type=\'hidden\' name=\'n_exercicios\' value=\''.$treino['n_exercicios'].'\' required></td>
            

                                <div class=\'row form-group\'>
                                    <label for=\'Periodo\' style=\'width:23%\'>Periodo:</label>
                                    <input style=\'width:60%\' class=\'form-control\' type=\'text\' name=\'periodo\' value=\''.$treino['periodo'].'\' required></td>
                                </div>

                                <div class=\'row form-group\'>
                                    <label for=\'Etapa\' style=\'width:23%\'>Etapa:</label>
                                    <input style=\'width:60%\' class=\'form-control\' type=\'text\' name=\'etapa\' value=\''.$treino['etapa'].'\' required></td>
                                </div>

                                <div class=\'row form-group\'>
                                    <label for=\'Data_inicio\' style=\'width:23%\'>Data de início:</label>
                                    <input style=\'width:60%\' class=\'form-control\' type=\'date\' name=\'data_inicio\' value=\''.$treino['data_inicio'].'\' required></td>
                                </div>

                                <div class=\'row form-group\'>
                                    <label for=\'Data_termino\' style=\'width:23%\'>Data de término:</label>
                                    <input style=\'width:60%\' class=\'form-control\' type=\'date\' name=\'data_termino\' value=\''.$treino['data_termino'].'\' required></td>
                                </div>

                                <div class=\'row form-group\'>
                                    <label for=\'Legenda\' style=\'width:23%\'>Legenda:</label>
                                    <input style=\'width:60%\' class=\'form-control\' type=\'text\' name=\'legenda\' value=\''.$treino['legenda'].'\'></td>
                                </div>

                                <div class=\'row form-group\'>
                                    <button type=\'submit\' class=\'btn btn-primary\'>Editar</button>
                                </div>

                                </form>">
                                <img src="../common/images/edit.png" height=20px color="white">
                                </button></div><br>';
                    }
                    ?>

                </div>
                <hr>

                <div class="row">
                    <div class="col-4">
                        <div class="row form-group">
                            <b>Grupo:</b><?php echo $treino['grupo'];?>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="row form-group">
                            <b>Período:</b><?php echo $treino['periodo'];?>
                        </div>
                    </div>

                    <div class="col-4">
                        <div class="row form-group">
                            <b>Etapa:</b><?php echo $treino['etapa'];?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-4">
                        <div class="row form-group">
                            <b>Início:</b><?php echo date_format(date_create($treino['data_inicio']),"d/m/Y");?>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="row form-group">
                            <b>Término:</b><?php echo date_format(date_create($treino['data_termino']),"d/m/Y");?>
                        </div>
                    </div>
                    <?php
                    if($nivel_usuario != 2){
                    echo '<div class="col-4"><button type="button" id="init_treino" class="btn btn-primary" onclick="window.location.href=\'executar_treino.php?id_treino='.$id_treino.'\'">Iniciar Treino</button></div>';
                }
                else{
                    $ordem=$n+1;
                    echo '<div class="col-4">
                    <button type="button" id="add_exercicio" class="btn-primary" onclick="exibe(this.id)" value="
                        <form method=\'post\' action=\'./add_exercicio.php\'>
                        <input type=\'hidden\' name=\'id_treino\' value='.$id_treino.'>
                        <input type=\'hidden\' name=\'ordem\' value='.$ordem.'>
                                    <div class=\'row form-group\'>
                                        <label for=\'Nome\' style=\'width:17%\'>Exercicio:</label>
                                        <input style=\'width:60%\' class=\'form-control\' type=\'text\' name=\'exercicio\'  required></td>
                                    </div>

                                    <div class=\'row form-group\'>
                                        <label for=\'Nº Séries\' style=\'width:17%\'>Nº de Séries:</label>
                                        <input style=\'width:8%\' class=\'form-control\' type=\'number\' name=\'n_series\'  required></td>
                                    </div>

                                    <div class=\'row form-group\'>
                                        <label for=\'Intensidade\' style=\'width:17%\'>Intensidade:</label>
                                        <input style=\'width:60%\' class=\'form-control\' type=\'text\' name=\'intensidade\' required></td>
                                    </div>

                                    <div class=\'row form-group\'>
                                        <label for=\'Repetições\' style=\'width:17%\'>Repetições:</label>
                                        <input style=\'width:60%\' class=\'form-control\' type=\'text\' name=\'repeticoes\'  required></td>
                                    </div>

                                    <div class=\'row form-group\'>
                                        <label for=\'Intervalo\' style=\'width:17%\'>Intervalo:</label>
                                        <input style=\'width:60%\' class=\'form-control\' type=\'text\' name=\'intervalo\' required></td>
                                    </div>
                        <button class=\'btn btn-primary\' type=\'submit\'>Adicionar</button>
                        </form>"
                    >Adicionar Exercício</button>
                    </div>';
                }
                ?>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="container_form">
                <?php if($nivel_usuario!=2) echo '<form method="post" action="./enviar_treino.php?id_treino='.$id_treino.'">';?>
                <?php
                $cargas=array();
                $sql_cargas="SELECT cargas_academia.1,cargas_academia.2,cargas_academia.3,cargas_academia.4,cargas_academia.5,cargas_academia.6,cargas_academia.7,cargas_academia.8 
                            FROM cargas_academia INNER JOIN series_academia ON cargas_academia.id_serie= series_academia.id 
                            WHERE series_academia.id_treino=".$id_treino." AND cargas_academia.id_atleta=".$id_usuario."  
                            ORDER BY cargas_academia.id DESC;";
                $query_cargas=mysqli_query($con, $sql_cargas);
                while($carga = mysqli_fetch_array($query_cargas)){
                    
                    $aux=array();
                    foreach($carga as $c){
                        $aux[]=$c;
                    }
                    $cargas[]=$aux;
                }


                $sql = "SELECT * FROM series_academia WHERE id_treino =".$id_treino." ORDER BY ordem ASC;";
                $query= mysqli_query($con, $sql);
                if(mysqli_num_rows($query)>0){
                    $i=1;
                    while($exercicio = mysqli_fetch_assoc($query)){
                        $repeticoes= explode("/", $exercicio['repeticoes']);
                        $intervalos= explode("/", $exercicio['intervalo']);
                        $intensidades= explode("/", $exercicio['intensidade']);

                        echo "
                                <div style='background-color:#242b56;border-style: solid; border-width:0px 0px 1px 0px; border-color:white;'>
                                    <h3 style='color:#FFB000; padding:5px;margin:0; text-transform:uppercase'><strong>".$exercicio['exercicio']."</strong></h3>
                                </div>
                                <div class='row' style='margin:0; margin-bottom:5px;'>
                                    <div class='col-1' style='vertical-align: middle;align-items: center;background-color:#242b56;margin:0;padding:0;text-align:center;line-height: 30px;'>
                                        <span style='fontsize:48px; color: white'>".$i."</span>";
                        
                        if($exercicio['link']!=null){
                            echo '<br>
                                <a class=btn style="background-color:#FFB000;padding:0;padding-top:3px; padding-bottom:3px;width:26px" href="'.$exercicio['link'].'" target="_blank">
                                <img src="../common/images/video_icon.png" height=15px width=15px color=white">
                                </a>';
                        }
                        if($nivel_usuario==2) {
                            echo '<br>';
                            
                            if($exercicio['ordem']>1){
                                echo '<a href="./edita_serie.php?ordem=1&id_treino='.$id_treino.'&posicao='.$exercicio['ordem'].'&id='.$exercicio['id'].'"><button><img src="../common/images/seta_baixo.png" height=15px width=15px color=white style="transform: rotate(180deg);"></button></a>';
                            }
                            if($exercicio['ordem']<mysqli_num_rows($query)){
                                echo '<a href="./edita_serie.php?ordem=0&id_treino='.$id_treino.'&posicao='.$exercicio['ordem'].'&id='.$exercicio['id'].'"><button><img src="../common/images/seta_baixo.png" height=15px width=15px color=white></button></a>';
                            }
                            if($exercicio['ordem']==mysqli_num_rows($query)+1){
                                echo '<a href="./edita_serie.php?ordem=0&id_treino='.$id_treino.'&posicao='.$exercicio['ordem'].'&id='.$exercicio['id'].'"><button><img src="../common/images/seta_baixo.png" height=15px width=15px color=white></button></a>';
                            }  
                                echo '<br>
                                <div style="padding:3px">
                                    <button class=btn style="background-color:#FFB000;padding:0;padding-top:3px; padding-bottom:3px;width:26px" id='.$i.' onclick="exibe(this.id)" value="
                                    <form method=post action=\'./edita_serie.php?id='.$exercicio['id'].'&id_treino='.$id_treino.'\'>

                                    <div class=\'row form-group\'>
                                        <label for=\'Nome\' style=\'width:17%\'>Exercicio:</label>
                                        <input style=\'width:60%\' class=\'form-control\' type=\'text\' name=\'exercicio\' value=\''.$exercicio['exercicio'].'\' required></td>
                                    </div>

                                    <div class=\'row form-group\'>
                                        <label for=\'Nº Séries\' style=\'width:17%\'>Nº de Séries:</label>
                                        <input style=\'width:8%\' class=\'form-control\' type=\'number\' name=\'n_series\' value=\''.$exercicio['n_series'].'\' required></td>
                                    </div>

                                    <div class=\'row form-group\'>
                                        <label for=\'Intensidade\' style=\'width:17%\'>Intensidade:</label>
                                        <input style=\'width:60%\' class=\'form-control\' type=\'text\' name=\'intensidade\' value=\''.$exercicio['intensidade'].'\' required></td>
                                    </div>

                                    <div class=\'row form-group\'>
                                        <label for=\'Repetições\' style=\'width:17%\'>Repetições:</label>
                                        <input style=\'width:60%\' class=\'form-control\' type=\'text\' name=\'repeticoes\' value=\''.$exercicio['repeticoes'].'\' required></td>
                                    </div>

                                    <div class=\'row form-group\'>
                                        <label for=\'Intervalo\' style=\'width:17%\'>Intervalo:</label>
                                        <input style=\'width:60%\' class=\'form-control\' type=\'text\' name=\'intervalo\' value=\''.$exercicio['intervalo'].'\' required></td>
                                    </div>

                                    <div class=\'row form-group\'>
                                        <label for=\'link\' style=\'width:17%\'>Link:</label>
                                        <input style=\'width:60%\' class=\'form-control\' type=\'text\' name=\'link\' value=\''.$exercicio['link'].'\'></td>
                                    </div>

                                    <div class=\'row form-group\'>
                                        <button type=\'submit\' class=\'btn btn-primary\'>Editar</button>
                                    </div>

                                    </form>">
                                    <img src="../common/images/edit.png" height=20px color="white">
                                    </button>
                                </div><br>';
                            
                        }
                        
                        echo "
                                    </div>
                                    <div class='col-11' style='margin:0; padding:0;'>
                                    ";
                        
                        $tabela='
                                    <table class="table" style="background: white; color:black;margin-bottom:0">
                                    <tbody>
                                    <tr>';
                        $tabela.="      <td><b>Série</b></td>";
                        $n_serie = 1;
                        while($n_serie<=$exercicio['n_series']){
                            $tabela.="<td>".$n_serie."</td>";
                            $n_serie+=1;
                        }
                        $tabela.="  </tr>
                                    <tr>
                                        <td><b>Intensidade</b></td>";
                                    foreach($intensidades as $intensidade){
                                        $tabela.="<td>".$intensidade."</td>";
                                    }
                                    
                        $tabela.="  </tr>
                                    <tr>
                                        <td><b>Repetições</b></td>";
                                    foreach($repeticoes as $reps){
                                        $tabela.="<td>".$reps."</td>";
                                    }
                        $tabela.="  </tr>
                                    <tr>
                                        <td><b>Intervalo(seg)</b></td>";
                                    foreach($intervalos as $intervalo){
                                        $tabela.="<td>".$intervalo."</td>";
                                    }
                        if($nivel_usuario!=2){
                            $tabela.="</tr><tr><td><b>Cargas(Kg)</b></td>";
                            $n=1;
                            while($n<=$exercicio['n_series']){
                                $cargas[$treino['n_exercicios']-$i][$n]=str_replace(" ","+",$cargas[$treino['n_exercicios']-$i][$n]);
                                // $tabela.="<td><input class='form-control' type='text' name=".$exercicio['id']."_".$n." placeholder="."(".$cargas[$i-1][$n-1].")"."></td>";
                                $tabela.="<td>".$cargas[$treino['n_exercicios']-$i][$n]."</td>"; //ordem dos exercicios vem de tras pra frente
                                $n+=1;
                            }
                        }
                        $tabela.="</tr></tbody></table>";
                        echo $tabela;
                        // $segundos=intval($intervalo)%60;
                        // $minutos=intval($intervalo/60);
                        // $timer= "00:0".$minutos.":".$segundos;
                        // echo '<iframe width="250" height="125" src="https://relogioonline.com.br/embed/temporizador/#countdown='.$timer.'&theme=0&enabled=0&ampm=0&sound=happy" frameborder="0" allowfullscreen></iframe>';
                        echo "</div></div>";
                        $i++;
                    }
                    echo '<p>'.$treino['legenda'].'</p>';
                }
                
                
                ?>


               
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