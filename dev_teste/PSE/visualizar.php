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
    <title>Wetrats - PSE</title>
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

<body>
    <div id="page">
        <nav class="fh5co-nav" id="menu-list" role="navigation">
            <div id="menu"></div>
        </nav>
        <div id="menus"></div>

        <div class="container-fluid" style="padding-top:60px;">
            <div class="section_title_container">
                <div class="section_title light">
                    <div class="row">
                        <div class="col-4">
                            <h1>PSE</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <?php
                        echo '<table style="margin-left: 40px; width:95%" class="tabela_prep">';
                        require_once '../db_con.php';
                        
                        $sql = 'SELECT id, apelido FROM usuarios WHERE nivel != 2 AND ativo != 0 ORDER BY apelido ASC ';
                        $ids = mysqli_query($con, $sql);
                        while($id = mysqli_fetch_assoc($ids)){
                            echo '<tr class="tabela_prep"><td class="tabela_prep"><h3 style="color:white; font-size:24px; text-align:center">'.$id['apelido'].'</h3>
                                    <div class="row" style="margin-right: 0px;">
                                        <canvas id="myChart_ses_'.$id['id'].'" height="14%" width="90%"></canvas>
                                    </div>
                                    <div class="row" style="margin-right: 0px;">
                                        <canvas id="myChart_des_'.$id['id'].'" height="14%" width="90%"></canvas>
                                    </div>
                                    <div class="row" style="margin-right: 0px;">
                                        <canvas id="myChart_rat_'.$id['id'].'" height="14%" width="90%"></canvas>
                                    </div>
                                    </td></tr>';
                        }
                        
                        echo '</table>';
                
                    ?>
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
    <?php
        date_default_timezone_set('America/Sao_Paulo');
        $hoje=date("Y-m-d");

        $sql2 = "
            SELECT 
                td.id_atleta AS ATLETA,
                GROUP_CONCAT(CAST(DATE_FORMAT(td.data_treino, '%d/%m') AS CHAR) ORDER BY td.data_treino) AS DATAS,
                GROUP_CONCAT(COALESCE(pse.ses, 0) ORDER BY td.data_treino) AS PSE_SES,
                GROUP_CONCAT(COALESCE(pse.descs, 0) ORDER BY td.data_treino) AS PSE_DESCS,
                GROUP_CONCAT(COALESCE(ROUND(pse.ratio, 2), 0) ORDER BY td.data_treino) AS PSE_RATIO,
                COUNT(1) AS TOTAL_DIAS
            FROM (
                SELECT 
                    t.data AS data_treino,
                    t.id as id_treino,
                    u.id as id_atleta
                FROM treinos t
                CROSS JOIN usuarios u
                WHERE t.id >= 573
                AND t.data <= '".$hoje."'
                AND u.nivel != 2
                AND u.ativo != 0
            ) AS td
            LEFT JOIN pse_2024 pse
                ON td.id_treino = pse.id_treino
                AND td.id_atleta = pse.id_atleta
            GROUP BY 1
            ORDER BY 1;
        ";
        $res2 = mysqli_query($con, $sql2);
        
        while($pse_row = mysqli_fetch_assoc($res2)){ 
            $datas = "" ;
            foreach(explode(',', $pse_row['DATAS']) as $i=>$data){ 
                $datas .= "'".$data."'";
                if($i < $pse_row['TOTAL_DIAS']) {
                    $datas .= ",";
                }
            }
            
            echo "
            var ctx_ses".$pse_row['ATLETA']." = document.getElementById('myChart_ses_".$pse_row['ATLETA']."');
            var ctx_des".$pse_row['ATLETA']." = document.getElementById('myChart_des_".$pse_row['ATLETA']."');
            var ctx_rat".$pse_row['ATLETA']." = document.getElementById('myChart_rat_".$pse_row['ATLETA']."');

            var myChart_ses".$pse_row['ATLETA']." = new Chart(ctx_ses".$pse_row['ATLETA'].", {
                type: 'bar',
                data: {
                    labels: [".$datas."],
                    datasets: [{
                        type: 'line',
                        label: 'PSE Sessão',
                        data: [".$pse_row['PSE_SES']."],
                        borderColor: 'rgba(0, 0, 0, 1)',
                        borderWidth: 2,
                        fill: false
                    },
                    {
                        type: 'bar',
                        label: 'PSE Sessão',
                        data: [".$pse_row['PSE_SES']."],
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
                                min: 0,
                                max: 10
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
                        text: 'PSE da Sessão',
                    }
                }
            });

            var myChart_des".$pse_row['ATLETA']." = new Chart(ctx_des".$pse_row['ATLETA'].", {
                type: 'bar',
                data: {
                    labels: [".$datas."],
                    datasets: [{
                        type: 'line',
                        label: 'PSE do Descanso',
                        data: [".$pse_row['PSE_DESCS']."],
                        borderColor: 'rgba(0, 0, 0, 1)',
                        borderWidth: 2,
                        fill: false
                    },
                    {
                        type: 'bar',
                        label: 'PSE do Descanso',
                        data: [".$pse_row['PSE_DESCS']."],
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
                                min: 0,
                                max: 10
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
                        text: 'PSE do Descanso',
                    }
                }
            });

            var myChart_rat".$pse_row['ATLETA']." = new Chart(ctx_rat".$pse_row['ATLETA'].", {
                type: 'bar',
                data: {
                    labels: [".$datas."],
                    datasets: [{
                        type: 'line',
                        label: 'PSE Ratio',
                        data: [".$pse_row['PSE_RATIO']."],
                        borderColor: 'rgba(0, 0, 0, 1)',
                        borderWidth: 2,
                        fill: false
                    },
                    {
                        type: 'bar',
                        label: 'PSE Ratio',
                        data: [".$pse_row['PSE_RATIO']."],
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
                        xAxes: [{
                            barPercentage: 1.0,
                            categoryPercentage: 1.0
                        }],
                        yAxes: [{
                            min:0
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
                        text: 'Razão da PSE da Sessão sobre a PSE do Descanso',
                    }
                }
            });";
        }
    ?>
    </script>
</body>
</html>