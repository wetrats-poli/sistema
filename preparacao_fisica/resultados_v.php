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
    
    if($_SESSION['NIVEL'] != 2){
        header("Location: ../perfil/");
    }

?>


<body>
    <div id="page" style='overflow-x:auto;'>
        <nav class="fh5co-nav" id="menu-list" role="navigation">
            <div id="menu"></div>
        </nav>
        <div id="menus"></div>

        <div class="container-fluid" style="padding-top:60px;">
        <?php
            if (isset($_SESSION['MSG'])){
                echo '<div class="alert alert-success" role="alert">'.$_SESSION['MSG'].'</div>';
                unset($_SESSION['MSG']);
            }
            if (isset($_SESSION['ALERTA'])){
                echo '<div class="alert alert-danger" role="alert">'.$_SESSION['ALERTA'].'</div>';
                unset($_SESSION['ALERTA']);
              }
        ?>
            <div class="section_title_container">
                <div class="section_title light">
                    <div class="row">
                        <div class="col-4">
                            <h1>Resultados</h1>
                        </div>
                        <div class="col-8">
                            <?php
                                include 'prog_semanas.php';
                                include './monotonia.php';
                                date_default_timezone_set('America/Sao_Paulo');
                                $hoje=date("Y-m-d");
                                if(isset($_GET['semana'])){                             
                                    $semana_atual = $_GET['semana'];
                                } else {
                                    $semana_atual = acha_semana($hoje);
                                }

                                $link = mysqli_connect("auth-db213.hstgr.io", "u418844475_wtr", "wetrats2019", "u418844475_wtr");
                                $sql4 = "SELECT DISTINCT semana FROM monitoramentos_academia ORDER BY semana ASC";
                                $semanas = mysqli_query($link, $sql4);

                                echo '<select class="form-control" nome="semana" id="semana" style="width: 25%;">';
                                while($semana = mysqli_fetch_assoc($semanas)){
                                    if($semana['semana'] == $semana_atual){
                                        echo '<option value='.$semana['semana'].' selected>Semana '.$semana['semana'].'</option>';
                                    } else {
                                        echo '<option value='.$semana['semana'].'>Semana '.$semana['semana'].'</option>';
                                    }
                                }
                                echo '</select>';

                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <div class="col-12">
                <?php
                    echo '<table class="tabela_prep" style="width:100%;">';
                    $link = mysqli_connect("auth-db213.hstgr.io", "u418844475_wtr", "wetrats2019", "u418844475_wtr");
                    $sql = "SELECT DISTINCT nome FROM grupos_preparacao";
                    $grupos = mysqli_query($link, $sql);
                    $todos_ids = array();
                    $n=0;

                    while($grupo = mysqli_fetch_assoc($grupos)){
                        echo '<tr class="tabela_prep"><th class="tabela_prep" style="text-align: center; font-size: 30px">'.$grupo['nome'].'</th></tr>'; 
                        $sql2 = 'SELECT id_atleta FROM grupos_preparacao WHERE nome="'.$grupo['nome'].'"';
                        $ids = mysqli_query($link, $sql2);
                        while($id = mysqli_fetch_assoc($ids)){
                            $sql3 = "SELECT nome FROM usuarios WHERE id=".$id['id_atleta'];
                            $nome = mysqli_fetch_assoc(mysqli_query($link, $sql3));
                            echo '<tr class="tabela_prep"><td class="tabela_prep"><h3 style="color:white; font-size:24px; text-align:center">'.$nome['nome'].'</h3>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="row" style="margin-right: 0px; background-color: white;" id="div_'.$id['id_atleta'].'q">
                                            <canvas height="200px" id="myChart_'.$id['id_atleta'].'q"></canvas>
                                            </div>
                                            <div class="row" style="margin-right: 0px; background-color: white;" id="div_'.$id['id_atleta'].'cia">
                                            <canvas height="200px" id="myChart_'.$id['id_atleta'].'cia"></canvas>
                                            </div>
                                            <div class="row" style="margin-right: 0px; background-color: white;" id="div_'.$id['id_atleta'].'cif">
                                            <canvas height="200px" id="myChart_'.$id['id_atleta'].'cif"></canvas>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="row" style="margin-left: 0px; background-color: white;" id="div_'.$id['id_atleta'].'qs">
                                            <canvas height="200px" id="myChart_'.$id['id_atleta'].'qs"></canvas>
                                            </div>
                                            <div class="row" style="margin-left: 0px; background-color: white;" id="div_'.$id['id_atleta'].'cias">
                                            <canvas height="200px" id="myChart_'.$id['id_atleta'].'cias"></canvas>
                                            </div>
                                            <div class="row" style="margin-left: 0px; background-color: white;" id="div_'.$id['id_atleta'].'cifs">
                                            <canvas height="200px" id="myChart_'.$id['id_atleta'].'cifs"></canvas>
                                            </div>
                                        </div>
                                    </div>';
                            
                            // Conexão com o servidor MySQL

    $exercicios = array();
    $datas=array();
    $header="<th style='background-color: #242b56;color:#FFB000;text-tranform:uppercase;'>
    <strong></strong></th>";
    $sql21 = 'SELECT usuarios.nome , series_academia.exercicio, series_academia.repeticoes, treinos_academia.etapa,treinos_academia.periodo,
    CONCAT(cargas_academia.1,"&",cargas_academia.2,"&",cargas_academia.3,"&",cargas_academia.4,"&",cargas_academia.5,"&",cargas_academia.6,"&",cargas_academia.7,"&",cargas_academia.8) AS "cargas", 
    cargas_academia.data 
    FROM `cargas_academia` 
    INNER JOIN series_academia ON cargas_academia.id_serie = series_academia.id 
    INNER JOIN treinos_academia ON series_academia.id_treino = treinos_academia.id 
    INNER JOIN usuarios ON usuarios.id = cargas_academia.id_atleta 
    WHERE cargas_academia.id_atleta= '.$id['id_atleta'].'
    ORDER BY cargas_academia.data DESC;';

    $resultado = mysqli_query($link, $sql21);
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
    }
    
    $linhas="";     
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
                                       
                            
             echo'   
                    <div class="row">
                        <div class="col" style="overflow-x:scroll;overflow-y:hidden;margin-top:30px;">    
                            <table class="table">
                                <thead>'.$header.'</thead>
                                <tbody>'.$linhas.'</tbody>
                            </table>
                        </div>
                    </div>';

            //MONOTONIA                            
            echo '<div class="row"><table class="table" style="margin-top: 25px; margin-left: 15px; width: 35%">
                    <tr class="linha_exercicio">
                        <td style="background-color: #242b56; color: #FFB000; text-transform: uppercase; overflow: hidden; height: 40px; font-size: 14px;">Monotonia</td>
                        <td style="background-color: #FFF; color: #FFB000; text-transform: uppercase; overflow: hidden; height: 40px; font-size: 14px; text-align: center;">'.monotonia($id['id_atleta'], $semana_atual).'</td>
                    </tr>
                    <tr class="linha_exercicio">
                        <td style="background-color: #242b56; color: #FFB000; text-transform: uppercase; overflow: hidden; height: 40px; font-size: 14px;">CIT Aguda:Crônica</td>';
                    $cit = ci_ag_cr($id['id_atleta'], $semana_atual);
                    if(!$cit){
                        echo '<td style="background-color: red; color: #FFF; text-transform: uppercase; overflow: hidden; height: 40px; font-size: 14px; text-align: center;">Dados Insuficientes</td>';
                    } else {
                        if($cit <= 0.8 || $cit >=  1.2){
                            echo '<td style="background-color: red; color: #FFF; text-transform: uppercase; overflow: hidden; height: 40px; font-size: 14px; text-align: center;">'.$cit.'</td>';
                        } else {
                            echo '<td style="background-color: green; color: #FFF; text-transform: uppercase; overflow: hidden; height: 40px; font-size: 14px; text-align: center;">'.$cit.'</td>';
                        }
                    }
               echo'</tr>
                 </table></div>';
                echo '</td></tr>';
            $todos_ids[] = $id['id_atleta'];
            }
        }
    echo '</table>';
               
                     
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
    <script src="../common/js/Chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    
       
    <script>
        $('#semana').change(function(){
            window.location.href = 'resultados.php?semana='+$('#semana').val();
        })
    
    </script>
    <script>
        Chart.defaults.global.plugins.datalabels.anchor = 'end';
        Chart.defaults.global.plugins.datalabels.align = 'end';

        <?php
            foreach ($todos_ids as $_id) {
                // recuperação e bem estar
                //diário
                $sql_seg = "SELECT tqr, fdg, qls, dmg, etr, hmr FROM monitoramentos_academia WHERE dia_semana=1 AND semana=$semana_atual AND id_atleta=$_id";
                $sql_ter = "SELECT tqr, fdg, qls, dmg, etr, hmr FROM monitoramentos_academia WHERE dia_semana=2 AND semana=$semana_atual AND id_atleta=$_id";
                $sql_qua = "SELECT tqr, fdg, qls, dmg, etr, hmr FROM monitoramentos_academia WHERE dia_semana=3 AND semana=$semana_atual AND id_atleta=$_id";
                $sql_qui = "SELECT tqr, fdg, qls, dmg, etr, hmr FROM monitoramentos_academia WHERE dia_semana=4 AND semana=$semana_atual AND id_atleta=$_id";
                $sql_sex = "SELECT tqr, fdg, qls, dmg, etr, hmr FROM monitoramentos_academia WHERE dia_semana=5 AND semana=$semana_atual AND id_atleta=$_id";
                $sql_sab = "SELECT tqr, fdg, qls, dmg, etr, hmr FROM monitoramentos_academia WHERE dia_semana=6 AND semana=$semana_atual AND id_atleta=$_id";
                $sql_dom = "SELECT tqr, fdg, qls, dmg, etr, hmr FROM monitoramentos_academia WHERE dia_semana=7 AND semana=$semana_atual AND id_atleta=$_id";
                
                $seg = mysqli_fetch_assoc(mysqli_query($link, $sql_seg));
                $ter = mysqli_fetch_assoc(mysqli_query($link, $sql_ter));
                $qua = mysqli_fetch_assoc(mysqli_query($link, $sql_qua));
                $qui = mysqli_fetch_assoc(mysqli_query($link, $sql_qui));
                $sex = mysqli_fetch_assoc(mysqli_query($link, $sql_sex));
                $sab = mysqli_fetch_assoc(mysqli_query($link, $sql_sab));
                $dom = mysqli_fetch_assoc(mysqli_query($link, $sql_dom));

                //semanal

                $tqr = array();
                $fdg = array();
                $qls = array();
                $dmg = array();
                $etr = array();
                $hmr = array();
                for($sem = 1; $sem <= $semana_atual; $sem++){
                    $sem_tqr = "SELECT ROUND(AVG(tqr)) FROM monitoramentos_academia WHERE semana=$sem AND id_atleta=$_id"; 
                    $sem_fdg = "SELECT ROUND(AVG(fdg)) FROM monitoramentos_academia WHERE semana=$sem AND id_atleta=$_id";
                    $sem_qls = "SELECT ROUND(AVG(qls)) FROM monitoramentos_academia WHERE semana=$sem AND id_atleta=$_id";
                    $sem_dmg = "SELECT ROUND(AVG(dmg)) FROM monitoramentos_academia WHERE semana=$sem AND id_atleta=$_id";
                    $sem_etr = "SELECT ROUND(AVG(etr)) FROM monitoramentos_academia WHERE semana=$sem AND id_atleta=$_id";
                    $sem_hmr = "SELECT ROUND(AVG(hmr)) FROM monitoramentos_academia WHERE semana=$sem AND id_atleta=$_id";

                    $tqr_q = mysqli_fetch_array(mysqli_query($link, $sem_tqr));
                    $fdg_q = mysqli_fetch_array(mysqli_query($link, $sem_fdg));
                    $qls_q = mysqli_fetch_array(mysqli_query($link, $sem_qls));
                    $dmg_q = mysqli_fetch_array(mysqli_query($link, $sem_dmg));
                    $etr_q = mysqli_fetch_array(mysqli_query($link, $sem_etr));
                    $hmr_q = mysqli_fetch_array(mysqli_query($link, $sem_hmr));

                    $tqr[] = $tqr_q[0];
                    $fdg[] = $fdg_q[0];
                    $qls[] = $qls_q[0];
                    $dmg[] = $dmg_q[0];
                    $etr[] = $etr_q[0];
                    $hmr[] = $hmr_q[0];
                }   

                //carga interna - água
                //diário
                $met_1 = "SELECT total FROM treinos WHERE dia_semana=1 AND semana=$semana_atual";
                $met_2 = "SELECT total FROM treinos WHERE dia_semana=2 AND semana=$semana_atual";
                $met_3 = "SELECT total FROM treinos WHERE dia_semana=3 AND semana=$semana_atual";
                $met_4 = "SELECT total FROM treinos WHERE dia_semana=4 AND semana=$semana_atual";
                $met_5 = "SELECT total FROM treinos WHERE dia_semana=5 AND semana=$semana_atual";
                $met_6 = "SELECT total FROM treinos WHERE dia_semana=6 AND semana=$semana_atual";
                $met_7 = "SELECT total FROM treinos WHERE dia_semana=7 AND semana=$semana_atual";

                $met_1_q = mysqli_fetch_assoc(mysqli_query($link, $met_1));
                $met_2_q = mysqli_fetch_assoc(mysqli_query($link, $met_2));
                $met_3_q = mysqli_fetch_assoc(mysqli_query($link, $met_3));
                $met_4_q = mysqli_fetch_assoc(mysqli_query($link, $met_4));
                $met_5_q = mysqli_fetch_assoc(mysqli_query($link, $met_5));
                $met_6_q = mysqli_fetch_assoc(mysqli_query($link, $met_6));
                $met_7_q = mysqli_fetch_assoc(mysqli_query($link, $met_7));

                $pse_1 = "SELECT ses FROM pse_nova WHERE dia_semana=1 AND semana=$semana_atual AND id_atleta=$_id";
                $pse_2 = "SELECT ses FROM pse_nova WHERE dia_semana=2 AND semana=$semana_atual AND id_atleta=$_id";
                $pse_3 = "SELECT ses FROM pse_nova WHERE dia_semana=3 AND semana=$semana_atual AND id_atleta=$_id";
                $pse_4 = "SELECT ses FROM pse_nova WHERE dia_semana=4 AND semana=$semana_atual AND id_atleta=$_id";
                $pse_5 = "SELECT ses FROM pse_nova WHERE dia_semana=5 AND semana=$semana_atual AND id_atleta=$_id";
                $pse_6 = "SELECT ses FROM pse_nova WHERE dia_semana=6 AND semana=$semana_atual AND id_atleta=$_id";
                $pse_7 = "SELECT ses FROM pse_nova WHERE dia_semana=7 AND semana=$semana_atual AND id_atleta=$_id";

                $pse_1_q = mysqli_fetch_assoc(mysqli_query($link, $pse_1));
                $pse_2_q = mysqli_fetch_assoc(mysqli_query($link, $pse_2));
                $pse_3_q = mysqli_fetch_assoc(mysqli_query($link, $pse_3));
                $pse_4_q = mysqli_fetch_assoc(mysqli_query($link, $pse_4));
                $pse_5_q = mysqli_fetch_assoc(mysqli_query($link, $pse_5));
                $pse_6_q = mysqli_fetch_assoc(mysqli_query($link, $pse_6));
                $pse_7_q = mysqli_fetch_assoc(mysqli_query($link, $pse_7));

                $cia_1 = $met_1_q['total'] * $pse_1_q['ses'];
                $cia_2 = $met_2_q['total'] * $pse_2_q['ses'];
                $cia_3 = $met_3_q['total'] * $pse_3_q['ses'];
                $cia_4 = $met_4_q['total'] * $pse_4_q['ses'];
                $cia_5 = $met_5_q['total'] * $pse_5_q['ses'];
                $cia_6 = $met_6_q['total'] * $pse_6_q['ses'];
                $cia_7 = $met_7_q['total'] * $pse_7_q['ses'];              
                
                //semanal
                $cia_s = array();
                for($sem = 1; $sem <= $semana_atual; $sem++){
                    $pse_s = "SELECT ROUND(AVG(ses)) FROM pse_nova WHERE semana=$sem AND id_atleta=$_id";
                    $dur_s = "SELECT ROUND(AVG(total)) FROM treinos WHERE semana=$sem";

                    $pse_q = mysqli_fetch_array(mysqli_query($link, $pse_s));
                    $dur_q = mysqli_fetch_array(mysqli_query($link, $dur_s));

                    $cia_s[] = $pse_q[0] * $dur_q[0];
                }

                //carga interna - físico
                //diário
                $cif_1 = "SELECT carga_interna FROM pse_academia WHERE dia_semana=1 AND semana=$semana_atual AND id_atleta=$_id";
                $cif_2 = "SELECT carga_interna FROM pse_academia WHERE dia_semana=2 AND semana=$semana_atual AND id_atleta=$_id";
                $cif_3 = "SELECT carga_interna FROM pse_academia WHERE dia_semana=3 AND semana=$semana_atual AND id_atleta=$_id";
                $cif_4 = "SELECT carga_interna FROM pse_academia WHERE dia_semana=4 AND semana=$semana_atual AND id_atleta=$_id";
                $cif_5 = "SELECT carga_interna FROM pse_academia WHERE dia_semana=5 AND semana=$semana_atual AND id_atleta=$_id";
                $cif_6 = "SELECT carga_interna FROM pse_academia WHERE dia_semana=6 AND semana=$semana_atual AND id_atleta=$_id";
                $cif_7 = "SELECT carga_interna FROM pse_academia WHERE dia_semana=7 AND semana=$semana_atual AND id_atleta=$_id";

                $cif_1_q = mysqli_fetch_assoc(mysqli_query($link, $cif_1));
                $cif_2_q = mysqli_fetch_assoc(mysqli_query($link, $cif_2));
                $cif_3_q = mysqli_fetch_assoc(mysqli_query($link, $cif_3));
                $cif_4_q = mysqli_fetch_assoc(mysqli_query($link, $cif_4));
                $cif_5_q = mysqli_fetch_assoc(mysqli_query($link, $cif_5));
                $cif_6_q = mysqli_fetch_assoc(mysqli_query($link, $cif_6));
                $cif_7_q = mysqli_fetch_assoc(mysqli_query($link, $cif_7));

                //semanal
                $cif_s = array();
                for($sem = 1; $sem <= $semana_atual; $sem++){
                    $cif_sem = "SELECT ROUND(AVG(carga_interna)) FROM pse_academia WHERE semana=$sem AND id_atleta=$_id";

                    $cif_q = mysqli_fetch_array(mysqli_query($link, $cif_sem));

                    $cif_s[] = $cif_q[0];
                }
                $monitoramentos_semanas = array();
                for($i=0; $i<sizeof($tqr); $i++){
                    $aux = array();

                    $aux[] = $tqr[$i];
                    $aux[] = $fdg[$i];
                    $aux[] = $qls[$i];
                    $aux[] = $dmg[$i];
                    $aux[] = $etr[$i];
                    $aux[] = $hmr[$i];

                    $monitoramentos_semanas[] = $aux;
                }
        
                //contrução gráficos
                //diário
                //questionário
                echo "var ctx_".$_id."q = document.getElementById('myChart_".$_id."q');";

                echo "var myChart".$_id."q = new Chart(ctx_".$_id."q, {
                    type: 'bar',
                    data: {
                        labels: ['TQR', 'Fadiga', 'Qualidade do Sono', 'Dor Muscular Geral', 'Nível de Estresse', 'Humor'],
                        datasets: [{
                            label: ['Segunda'],
                            backgroundColor: 'rgba(255, 187, 0, 0.3)',
                            borderColor: 'rgba(255, 187, 0, 1)',
                            borderWidth: 1,
                            data:[". $seg['tqr'].",".$seg['fdg'].",".$seg['qls'].",".$seg['dmg'].",".$seg['etr'].",".$seg['hmr']."]
                        },
                        {
                            label: ['Terça'],
                            backgroundColor: 'rgba(0, 0, 46, 0.6)',
                            borderColor: 'rgba(0, 0, 46, 1)',
                            borderWidth: 1,
                            data:[". $ter['tqr'].",".$ter['fdg'].",".$ter['qls'].",".$ter['dmg'].",".$ter['etr'].",".$ter['hmr']."]
                        },
                        {
                            label: ['Quarta'],
                            backgroundColor: 'rgba(255, 187, 0, 0.3)',
                            borderColor: 'rgba(255, 187, 0, 1)',
                            borderWidth: 1,
                            data:[". $qua['tqr'].",".$qua['fdg'].",".$qua['qls'].",".$qua['dmg'].",".$qua['etr'].",".$qua['hmr']."]
                        },
                        {
                            label: ['Quinta'],
                            backgroundColor: 'rgba(0, 0, 46, 0.6)',
                            borderColor: 'rgba(0, 0, 46, 1)',
                            borderWidth: 1,
                            data:[". $qui['tqr'].",".$qui['fdg'].",".$qui['qls'].",".$qui['dmg'].",".$qui['etr'].",".$qui['hmr']."]
                        },
                        {
                            label: ['Sexta'],
                            backgroundColor: 'rgba(255, 187, 0, 0.3)',
                            borderColor: 'rgba(255, 187, 0, 1)',
                            borderWidth: 1,
                            data:[". $sex['tqr'].",".$sex['fdg'].",".$sex['qls'].",".$sex['dmg'].",".$sex['etr'].",".$sex['hmr']."]
                        },
                        {
                            label: ['Sábado'],
                            backgroundColor: 'rgba(0, 0, 46, 0.6)',
                            borderColor: 'rgba(0, 0, 46, 1)',
                            borderWidth: 1,
                            data:[". $sab['tqr'].",".$sab['fdg'].",".$sab['qls'].",".$sab['dmg'].",".$sab['etr'].",".$sab['hmr']."]
                        },
                        {
                            label: ['Domingo'],
                            backgroundColor: 'rgba(255, 187, 0, 0.3)',
                            borderColor: 'rgba(255, 187, 0, 1)',
                            borderWidth: 1,
                            data:[". $dom['tqr'].",".$dom['fdg'].",".$dom['qls'].",".$dom['dmg'].",".$dom['etr'].",".$dom['hmr']."]
                        }]
                    
                    },
                    options: {
                        scales:{
                            yAxes: [{
                                display: false,
                                ticks:{
                                    max: 20,
                                    min: 0
                                }
                            }]
                        },
                        legend: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: 'Recuperação e Bem Estar Diários',
                            fontSize: 15
                        },
                        gridLines: {
                            offsetGridLines: false,
                            display: false
                        }
                    }
                });";

                //CIA
                echo "var ctx_".$_id."cia = document.getElementById('myChart_".$_id."cia');";

                echo "var myChart".$_id."cia = new Chart(ctx_".$_id."cia, {
                    type: 'bar',
                    data: {
                        labels: ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'],
                        datasets: [{
                            type: 'bar',
                            label: 'Carga Interna - Água',
                            data: [".$cia_1.",".$cia_2.",".$cia_3.",".$cia_4.",".$cia_5.",".$cia_6.",".$cia_7."],
                            backgroundColor: 'rgba(0, 0, 46, 0.6)',
                            borderColor: 'rgba(0, 0, 46, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        legend: {
                            display: false
                        },
                        scales:{
                            yAxes: [{
                                ticks: {
                                    min:0
                                }
                            }]
                        },
                        layout: {
                            padding: {
                                left: 0,
                                right: 40,
                                top: 20,
                                bottom: 10
                            }
                        },
                        title: {
                            display: true,
                            text: 'Carga Interna - Água',
                        }
                    }
                });";

                //CIF
                echo "var ctx_".$_id."cif = document.getElementById('myChart_".$_id."cif');";

                echo "var myChart".$_id."cif = new Chart(ctx_".$_id."cif, {
                    type: 'bar',
                    data: {
                        labels: ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'],
                        datasets: [{
                            type: 'bar',
                            label: 'Carga Interna - Físico',
                            data: [".$cif_1_q['carga_interna'].",".$cif_2_q['carga_interna'].",".$cif_3_q['carga_interna'].",".$cif_4_q['carga_interna'].",".$cif_5_q['carga_interna'].",".$cif_6_q['carga_interna'].",".$cif_7_q['carga_interna']."],
                            backgroundColor: 'rgba(255, 187, 0, 0.3)',
                            borderColor: 'rgba(255, 187, 0, 1)',
                            pointBackgroundColor: 'rgba(255, 187, 0, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        legend: {
                            display: false
                        },
                        scales:{
                            yAxes: [{
                                ticks: {
                                    min:0
                                }
                            }],
                            xAxes: [{
                                barPercentage: 1.0,
                                categoryPercentage: 1.0
                            }]
                        },
                        layout: {
                            padding: {
                                left: 0,
                                right: 40,
                                top: 20,
                                bottom: 10
                            }
                        },
                        title: {
                            display: true,
                            text: 'Carga Interna - Físico',
                        }
                    }
                });";

                //semanal
                //questionário
                echo "var ctx_".$_id."qs = document.getElementById('myChart_".$_id."qs');";

                echo "var myChart".$_id."qs = new Chart(ctx_".$_id."qs, {
                    type: 'bar',
                    data: {
                        labels: ['TQR', 'Fadiga', 'Qualidade do Sono', 'Dor Muscular Geral', 'Nível de Estresse', 'Humor'],
                        datasets: [";
                            $count = 1;
                            foreach($monitoramentos_semanas as $dados){
                                if($count & 1){
                                    echo "{label: ['S".$count."'],
                                    backgroundColor: 'rgba(255, 187, 0, 0.3)',
                                    borderColor: 'rgba(255, 187, 0, 1)',
                                    borderWidth: 1,
                                    data:[".implode($dados, ',')."]},";
                                } else {
                                    echo "{label: ['S".$count."'],
                                    backgroundColor: 'rgba(0, 0, 46, 0.6)',
                                    borderColor: 'rgba(0, 0, 46, 1)',
                                    borderWidth: 1,
                                    data:[".implode($dados, ',')."]},";
                                }
                                $count++;
                            }
                        echo "]
                    
                    },
                    options: {
                        scales:{
                            yAxes: [{
                                display: false,
                                ticks:{
                                    max: 20,
                                    min: 0
                                }
                            }]
                        },
                        legend: {
                            display: false
                        },
                        title: {
                            display: true,
                            text: 'Recuperação e Bem Estar Diários',
                            fontSize: 15
                        },
                        gridLines: {
                            offsetGridLines: false,
                            display: false
                        }
                    }
                });";

                //CIA
                $semana_max = acha_semana($hoje);
                echo "var ctx_".$_id."cias = document.getElementById('myChart_".$_id."cias');";

                echo "var myChart".$_id."cias = new Chart(ctx_".$_id."cias, {
                    type: 'bar',
                    data: {
                        labels: ['S1'"; for($i=2; $i<sizeof($cia_s); $i++){echo ",'S".$i."'";} echo "],
                        datasets: [{
                            type: 'bar',
                            label: 'Carga Interna - Água',
                            data: [".implode($cia_s, ',')."],
                            backgroundColor: 'rgba(0, 0, 46, 0.6)',
                            borderColor: 'rgba(0, 0, 46, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        legend: {
                            display: false
                        },
                        scales:{
                            yAxes: [{
                                ticks: {
                                    min:0
                                }
                            }]
                        },
                        layout: {
                            padding: {
                                left: 0,
                                right: 40,
                                top: 20,
                                bottom: 10
                            }
                        },
                        title: {
                            display: true,
                            text: 'Carga Interna - Água',
                        }
                    }
                });";

                //CIF
                echo "var ctx_".$_id."cifs = document.getElementById('myChart_".$_id."cifs');";

                echo "var myChart".$_id."cifs = new Chart(ctx_".$_id."cifs, {
                    type: 'bar',
                    data: {
                        labels: ['S1'"; for($i=2; $i<$semana_max; $i++){echo ",'S".$i."'";} echo "],
                        datasets: [{
                            type: 'bar',
                            label: 'Carga Interna - Físico',
                            data: [".implode($cif_s, ',')."],
                            backgroundColor: 'rgba(255, 187, 0, 0.3)',
                            borderColor: 'rgba(255, 187, 0, 1)',
                            pointBackgroundColor: 'rgba(255, 187, 0, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        legend: {
                            display: false
                        },
                        scales:{
                            yAxes: [{
                                ticks: {
                                    min:0
                                }
                            }],
                            xAxes: [{
                                barPercentage: 1.0,
                                categoryPercentage: 1.0
                            }]
                        },
                        layout: {
                            padding: {
                                left: 0,
                                right: 40,
                                top: 20,
                                bottom: 10
                            }
                        },
                        title: {
                            display: true,
                            text: 'Carga Interna - Físico',
                        }
                    }
                });";   

            }
        ?>
    </script>
    <script src="../cargas/cargas.js"></script>
    
</body>

</html>