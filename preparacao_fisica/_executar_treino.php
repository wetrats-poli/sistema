<html lang="pt-BR">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="../common/stylesheets/bootstrap.css">
    <link rel="stylesheet" href="../common/stylesheets/bootstrap4.css">
    <link rel="stylesheet" href="../common/stylesheets/animate.css">
    <link rel="stylesheet" href="../common/stylesheets/style.css">
    <link rel="stylesheet" href="../common/stylesheets/style1.css">
    <link rel="icon" type="image/png" href="../common/images/favicon-32x32.png" sizes="32x32" />

    <script src="../common/js/jquery.min.js"></script>
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

    $con = mysqli_connect("auth-db213.hostinger.com.br", "u418844475_wtr", "wetrats2019", "u418844475_wtr");
    $sql0 = "SELECT * FROM treinos_academia WHERE id=".$id_treino.";";
    $query_treino=mysqli_query($con, $sql0);
    $treino = mysqli_fetch_assoc($query_treino);

?>


<body>
<style>
input:not(:placeholder-shown) {
  background: #ABEBC6 ;
}

input:placeholder-shown {
  background: #F5B7B1;
}
</style>
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
                    <h2>TREINO <?php echo " ".$treino['tipo'];?></h2>                
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
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="container_form">
                <!-- <?php if($nivel_usuario!=2) echo '<form method="post" action="./enviar_treino.php?id_treino='.$id_treino.'">';?> -->
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

                        if($i > 1){echo "<div style='display: none;' id='ex_".$i."'>";}
                        else {echo "<div id='ex_".$i."'>";}
                        echo "<div style='background-color:#242b56;border-style: solid; border-width:0px 0px 1px 0px; border-color:white;'>
                                <h3 style='color:#FFB000; padding:5px;margin:0; text-transform:uppercase'><strong>".$exercicio['exercicio']."</strong></h3></div>
                                <div class='row' style='margin:0; margin-bottom:5px;'>
                                <div class='col-1' style='vertical-align: middle;align-items: center;background-color:#242b56;margin:0;padding:0;text-align:center;line-height: 30px;'>
                                <span style='fontsize:48px; color: white'>".$i."</span>";
                        
                        if($exercicio['link']!=null){
                            echo '<br>
                                <a class=btn style="background-color:#FFB000;padding:0;padding-top:3px; padding-bottom:3px;width:26px" href="'.$exercicio['link'].'" target="_blank">
                                <img src="../common/images/video_icon.png" height=15px width=15px color=white">
                                </a>';
                        }                        
                        echo "</div><div class='col-11' style='margin:0; padding:0;'>";
                        
                        $tabela='<table class="table" style="background: white; color:black;margin-bottom:0"><tbody><tr>';
                        $tabela.="<td><b>Série</b></td>";
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
                        
                        $tabela.="</tr><tr><td><b>Cargas(Kg)</b></td>";
                        $n=1;
                        while($n<=$exercicio['n_series']){
                            $cargas[$treino['n_exercicios']-$i][$n]=str_replace(" ","+",$cargas[$treino['n_exercicios']-$i][$n]);
                            
                            $tabela.="<td><input class='form-control' type='text' name='".$exercicio['id']."_".$n."' id='".$exercicio['id']."_".$n."' placeholder="."(".$cargas[$treino['n_exercicios']-$i][$n].")"." required></td>";
                        
                            
                            
                            $n+=1;
                        }
                        
                        $tabela.="</tr></tbody></table>";
                        echo $tabela;
                        // $segundos=intval($intervalo)%60;
                        // $minutos=intval($intervalo/60);
                        // $timer= "00:0".$minutos.":".$segundos;
                        // echo '<iframe width="250" height="125" src="https://relogioonline.com.br/embed/temporizador/#countdown='.$timer.'&theme=0&enabled=0&ampm=0&sound=happy" frameborder="0" allowfullscreen></iframe>';
                        echo "</div></div>";
                        
                        if($i<mysqli_num_rows($query)){echo '<button type="button" name="add_carga" id="prx_ex_'.$i.'" class="btn btn-primary" onclick="document.getElementById(\'ex_'.$i.'\').style.display=\'none\'; document.getElementById(\'ex_'. ($i+1) .'\').style.display=\'block\';">Próximo Exercício</button>';}
                        else{echo '<button type="button" name="add_carga" id="prx_ex_'.$i.'" class="btn btn-primary" onclick="document.getElementById(\'ex_'.$i.'\').style.display = \'none\'; document.getElementById(\'pse\').style.display=\'block\';">Finalizar Treino</button>';}
                        
                        echo '<p>'.$treino['legenda'].'</p>';
                        echo"</div>";
                            


                        $script= '<script>
                            $(\'button[id=prx_ex_'.$i.']\').click(function(){
                                function CriaRequest() {
                                    try{
                                        request = new XMLHttpRequest();        
                                    }catch (IEAtual){
                                        
                                        try{
                                            request = new ActiveXObject("Msxml2.XMLHTTP");       
                                        }catch(IEAntigo){
                                        
                                            try{
                                                request = new ActiveXObject("Microsoft.XMLHTTP");          
                                            }catch(falha){
                                                request = false;
                                            }
                                        }
                                    }
                                    
                                    if (!request) 
                                        alert("Seu Navegador não suporta Ajax!");
                                    else
                                        return request;
                                }

                                var xmlr = CriaRequest();
                                var resposta = document.getElementById(\'request\');
                                xmlr.open("GET", "request.php?id_serie=';
                                $script.=$exercicio['id'];
                                for($j = 1; $j<=$exercicio['n_series']; $j++){
                                    $script .= '&c'.$j.'="+document.getElementById(\''.$exercicio['id'].'_'.$j.'\').value+"';
                                }
                                $script.='", true);

                                xmlr.onreadystatechange = function(){
                                    if(xmlr.readyState == 4){
                                        if(xmlr.status == 200){
                                            resposta.innerHTML = xmlr.responseText;
                                        }
                                    }
                                };
                                xmlr.send(null);
                            });

                        </script>';
                        echo $script;

                        $i++;
                    }
                }
                echo '<div id="pse" style="display: none">';
                    echo '<form class="form-group" id="form_carac" method="post" action="db_treino.php">
                            <div class="row"><label for="ses">De 0(muito fácil) até 10(extremamente exaustivo), qual foi sua percepção de esforço no treino de hoje?</label><input type="number" min=0 max=10
                                    class="form-control" style="width:30%; margin-bottom:5px; margin-left: 18px;" name="ses" id="ses" required></div>
                            <button class="btn btn-primary" type="submit">Enviar</button>
                        </form>';
                echo '</div>'; 
                
                ?>
            </div>
        </div>
    </div>

    <div id="request"></div>
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