<html lang="pt-BR">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="../common/stylesheets/bootstrap.css">
    <link rel="stylesheet" href="../common/stylesheets/bootstrap4.css">
    <link rel="stylesheet" href="../common/stylesheets/animate.css">
    <link rel="stylesheet" href="../common/stylesheets/style.css">
    <link rel="stylesheet" href="../common/stylesheets/style1.css">
    <link rel="stylesheet" href="../common/stylesheets/Chart.css">
    <link rel="icon" type="image/png" href="../common/images/favicon-32x32.png" sizes="32x32" />
    <title>Wetrats - Características</title>
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

?>
<?php
    $id = (int)$_GET["id_atleta"];

    $link = mysqli_connect("srv976.hstgr.io", "u418844475_wtr", "Wetrats2019", "u418844475_wtr");

    $sql1 = "SELECT forc, vel, res_ae, res_ana, tg, ee, est1, cb1, pr1, br1, tr1, qd1, co1, sa1, vr1, ch1, est2, cb2, pr2, br2, tr2, qd2, co2, sa2, vr2, ch2 FROM caracteristicas2020 WHERE id_atleta=$id AND tipo=1";
    $sql2 = "SELECT forc, vel, res_ae, res_ana, tg, ee, est1, cb1, pr1, br1, tr1, qd1, co1, sa1, vr1, ch1, est2, cb2, pr2, br2, tr2, qd2, co2, sa2, vr2, ch2 FROM caracteristicas2020 WHERE id_atleta=$id AND tipo=2";
    $resultado = mysqli_query($link, $sql1);
    $resp = mysqli_fetch_array($resultado);

    $resultado2 = mysqli_query($link, $sql2);
    $resp2 = mysqli_fetch_array($resultado2);

    $for_1 = $resp["forc"];
    $vel_1 = $resp["vel"];
    $res_ae_1 = $resp["res_ae"];
    $res_ana_1 = $resp["res_ana"];
    $tg_1 = $resp["tg"];
    $ee_1 = $resp["ee"];

    $for_2 = $resp2["forc"];
    $vel_2 = $resp2["vel"];
    $res_ae_2 = $resp2["res_ae"];
    $res_ana_2 = $resp2["res_ana"];
    $tg_2 = $resp2["tg"];
    $ee_2 = $resp2["ee"];

    
    $est1_1 = $resp["est1"];
    $cb1_1 = $resp["cb1"];
    $pr1_1 = $resp["pr1"];
    $br1_1 = $resp["br1"];
    $tr1_1 = $resp["tr1"];
    $qd1_1 = $resp["qd1"];
    $co1_1 = $resp["co1"];
    $sa1_1 = $resp["sa1"];
    $vr1_1 = $resp["vr1"];
    $ch1_1 = $resp["ch1"];

    $est1_2 = $resp2["est1"];
    $cb1_2 = $resp2["cb1"];
    $pr1_2 = $resp2["pr1"];
    $br1_2 = $resp2["br1"];
    $tr1_2 = $resp2["tr1"];
    $qd1_2 = $resp2["qd1"];
    $co1_2 = $resp2["co1"];
    $sa1_2 = $resp2["sa1"];
    $vr1_2 = $resp2["vr1"];
    $ch1_2 = $resp2["ch1"];

    $est2_1 = $resp["est2"];
    
    $flag2 = 0;
    if($est2_1 != "none"){
        $flag2 = 1;
        $cb2_1 = $resp["cb2"];
        $pr2_1 = $resp["pr2"];
        $br2_1 = $resp["br2"];
        $tr2_1 = $resp["tr2"];
        $qd2_1 = $resp["qd2"];
        $co2_1 = $resp["co2"];
        $sa2_1 = $resp["sa2"];
        $vr2_1 = $resp["vr2"];
        $ch2_1 = $resp["ch2"];

        $cb2_2 = $resp2["cb2"];
        $pr2_2 = $resp2["pr2"];
        $br2_2 = $resp2["br2"];
        $tr2_2 = $resp2["tr2"];
        $qd2_2 = $resp2["qd2"];
        $co2_2 = $resp2["co2"];
        $sa2_2 = $resp2["sa2"];
        $vr2_2 = $resp2["vr2"];
        $ch2_2 = $resp2["ch2"];

    }

?>

<body>
    <div id="page">
        <nav class="fh5co-nav" id="menu-list" role="navigation">
            <div id="menu"></div>
        </nav>
        <div id="menus"></div>

        <div class="container-fluid" style="padding-top:60px;">
            <div class="row">
                <div class="col-3" style="display: inline-block;">
                    <form class="form-group" style="margin-left: 10px;">
                        <h4>Selecione qual gráfico deseja visualizar</h4>
                        <div class="row"><input type="radio" id="grl" name="opc" class="form-control" style="height: 15px; width: 30px; display: inline-block;" onclick="document.getElementById('myChart_grl').style.display='block'; document.getElementById('myChart_esp1').style.display='none'; document.getElementById('myChart_esp2').style.display='none';"><label for="grl">Geral</label></div>
                        <div class="row"><input type="radio" id="esp1" name="opc" class="form-control" style="height: 15px; width: 30px; display: inline-block;" onclick="document.getElementById('myChart_grl').style.display='none'; document.getElementById('myChart_esp1').style.display='block'; document.getElementById('myChart_esp2').style.display='none';"><label for="esp1">Estilo 1 - <?php echo $est1_1; ?></label></div>
                        <?php
                            if($flag2){
                                echo '<div class="row"><input type="radio" id="esp2" name="opc" class="form-control" style="height: 15px; width: 30px; display: inline-block;" onclick="document.getElementById(\'myChart_grl\').style.display=\'none\'; document.getElementById(\'myChart_esp1\').style.display=\'none\'; document.getElementById(\'myChart_esp2\').style.display=\'block\';"><label for="esp2">Estilo 2 - '. $est2_1.'</label></div>';
                            }
                            
                            if($_SESSION['NIVEL'] == 2){
                            echo '<div class="row" style="margin-left: 100px;"><button class="btn btn-primary"><a style="color: white;" href="/caracteristicas/">Voltar</a></button></div>';
                            }

                            if($_SESSION['NIVEL'] == 1 || $_SESSION['NIVEL'] == 3){
                                echo '<div class="row" style="margin-left: 100px;"><button class="btn btn-primary"><a style="color: white;" href="/caracteristicas/">Editar</a></button></div>';
                            }
                        ?>
                    </form>
                </div>
                <div class="col-9" width="400px" height="400px">
                    <canvas id="myChart_grl" style="display: none;"></canvas>
                    <canvas id="myChart_esp1" style="display: none;"></canvas>
                    <canvas id="myChart_esp2" style="display: none;"></canvas>
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
    <script src="../common/js/Chart.js"></script>
    <script src="../common/js/Chart.bundle.js"></script>
    <script>
        $("#menu").load("../common/menu/menu.html #menu_");
        $("#menus").load("../common/menu/menu.html #side_menu");
    </script>

    <script>
        var ctx_grl = document.getElementById('myChart_grl');
        var ctx_esp1 = document.getElementById('myChart_esp1');

        var myChart1 = new Chart(ctx_grl, {
            type: 'radar',
            data: {
                labels: ['Força', 'Velocidade', 'Resistência Aeróbia', 'Resistência Anaeróbia', 'Técnica Geral', 'Equilíbrio Emocional'],
                datasets: [{
                    label: 'Avaliação do Lucas',
                    data: <?php echo '['. $for_2 .','. $vel_2 .','. $res_ae_2 .','. $res_ana_2 .','. $tg_2 .','. $ee_2. ']'; ?>,
                    backgroundColor: 'rgba(0, 0, 46, 0.3)',
                    borderColor: 'rgba(0, 0, 46, 1)',
                    pointBackgroundColor: 'rgba(0, 0, 46, 1)',
                    borderWidth: 1,
                    fill: true
                },
                {
                    label: 'Avaliação Pessoal',
                    data: <?php echo '['. $for_1 .','. $vel_1 .','. $res_ae_1 .','. $res_ana_1 .','. $tg_1 .','. $ee_1. ']'; ?>,
                    backgroundColor: 'rgba(255, 187, 0, 0.3)',
                    borderColor: 'rgba(255, 187, 0, 1)',
                    pointBackgroundColor: 'rgba(255, 187, 0, 1)',
                    borderWidth: 1,
                    fill: true
                }]
            },
            options: {
                legend: {
                    position: 'right',
                    labels: {
                        boxWidth: 50,
                        fontSize: 20
                    }
                },
                scale: {
                    ticks: {
                        beginAtZero: true,
                        max: 10
                    }
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
                    text: 'Parâmetros Gerais',
                }
            }
        });

        var myChart2 = new Chart(ctx_esp1, {
            type: 'radar',
            data: {
                labels: ['Cabeça', 'Perna', 'Braço', 'Tronco', 'Quadril', 'Coordenação Geral', 'Saída', 'Virada', 'Chegada'],
                datasets: [{
                    label: 'Avaliação do Lucas',
                    data: <?php echo '[' .$cb1_2. ',' .$pr1_2. ',' .$br1_2. ',' .$tr1_2. ',' .$qd1_2. ',' .$co1_2. ',' .$sa1_2. ',' .$vr1_2. ',' .$ch1_2. ']'; ?>,
                    backgroundColor: 'rgba(0, 0, 46, 0.3)',
                    borderColor: 'rgba(0, 0, 46, 1)',
                    pointBackgroundColor: 'rgba(0, 0, 46, 1)',
                    borderWidth: 1,
                    fill: true
                },
                {
                    label: 'Avaliação Pessoal',
                    data: <?php echo '[' .$cb1_1. ',' .$pr1_1. ',' .$br1_1. ',' .$tr1_1. ',' .$qd1_1. ',' .$co1_1. ',' .$sa1_1. ',' .$vr1_1. ',' .$ch1_1. ']'; ?>,
                    backgroundColor: 'rgba(255, 187, 0, 0.3)',
                    borderColor: 'rgba(255, 187, 0, 1)',
                    pointBackgroundColor: 'rgba(255, 187, 0, 1)',
                    borderWidth: 1,
                    fill: true
                }]
            },
            options: {
                legend: {
                    position: 'right',
                    labels: {
                        boxWidth: 50,
                        fontSize: 20
                    }
                },
                scale: {
                    ticks: {
                        beginAtZero: true,
                        max: 10
                    }
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
                    text: <?php echo "'Parâmetros Estilo Específico - ". $est1_1."'"; ?>,
                }
            }
        });

        <?php
            if($flag2){
                echo "
                var ctx_esp2 = document.getElementById('myChart_esp2');
                
                var myChart3 = new Chart(ctx_esp2, {
                    type: 'radar',
                    data: {
                        labels: ['Cabeça', 'Perna', 'Braço', 'Tronco', 'Quadril', 'Coordenação Geral', 'Saída', 'Virada', 'Chegada'],
                        datasets: [{
                            label: 'Avaliação do Lucas',
                            data: [" .$cb2_2. "," .$pr2_2. "," .$br2_2. "," .$tr2_2. "," .$qd2_2. "," .$co2_2. "," .$sa2_2. "," .$vr2_2. "," .$ch2_2. "],
                            backgroundColor: 'rgba(0, 0, 46, 0.3)',
                            borderColor: 'rgba(0, 0, 46, 1)',
                            pointBackgroundColor: 'rgba(0, 0, 46, 1)',
                            borderWidth: 1,
                            fill: true
                        },
                        {
                            label: 'Avaliação Pessoal',
                            data: [" .$cb2_1. "," .$pr2_1. "," .$br2_1. "," .$tr2_1. "," .$qd2_1. "," .$co2_1. "," .$sa2_1. "," .$vr2_1. "," .$ch2_1. "],
                            backgroundColor: 'rgba(255, 187, 0, 0.3)',
                            borderColor: 'rgba(255, 187, 0, 1)',
                            pointBackgroundColor: 'rgba(255, 187, 0, 1)',
                            borderWidth: 1,
                            fill: true
                        }]
                    },
                    options: {
                        legend: {
                            position: 'right',
                            labels: {
                                boxWidth: 50,
                                fontSize: 20
                            }
                        },
                        scale: {
                            ticks: {
                                beginAtZero: true,
                                max: 10
                            }
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
                            text: 'Parâmetros Estilo Específico - ". $est2_1 ."',
                        }
                    }
                });";
            }
        ?>

    </script>


</body>

</html>