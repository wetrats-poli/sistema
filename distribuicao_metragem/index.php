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
    <title>Wetrats - Treino</title>
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
                            <h1>Distribuição Metragem</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <canvas id="myChart_comparacao" width="100" height="38"></canvas>
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
            include '../preparacao_fisica/prog_semanas.php';
            require_once '../treinos/grupos.php';
            date_default_timezone_set('America/Sao_Paulo');
            $hoje=date("Y-m-d");
            $semana_atual = acha_semana($hoje);
            
            require_once '../db_con.php';

            // Soma das metragens por zona em cada semana, para o Grupo 1 (tabela treinos) ou o Grupo 2 (treinos_grupo2).
            // Z1=A1, Z2=A2, Z3=A3, Z4=AN, Z5=FO
            function zonas_por_semana($con, $semana_atual, $grupo){
                $zonas = array('A1' => array(), 'A2' => array(), 'A3' => array(), 'AN' => array(), 'FO' => array());
                for($sem = 1; $sem <= $semana_atual; $sem++){
                    if ($grupo == 2) {
                        $sql = "SELECT SUM(g.A1), SUM(g.A2), SUM(g.A3), SUM(g.AN), SUM(g.FO) FROM treinos_grupo2 g INNER JOIN treinos t ON t.id = g.id_treino WHERE t.semana=$sem";
                    } else {
                        $sql = "SELECT SUM(A1), SUM(A2), SUM(A3), SUM(AN), SUM(FO) FROM treinos WHERE semana=$sem";
                    }
                    $res = consulta_segura($con, $sql);
                    $r = $res ? mysqli_fetch_array($res) : array(0, 0, 0, 0, 0);
                    $zonas['A1'][] = (int)$r[0];
                    $zonas['A2'][] = (int)$r[1];
                    $zonas['A3'][] = (int)$r[2];
                    $zonas['AN'][] = (int)$r[3];
                    $zonas['FO'][] = (int)$r[4];
                }
                return $zonas;
            }

            $grupo1 = zonas_por_semana($con, $semana_atual, 1);
            $grupo2 = zonas_por_semana($con, $semana_atual, 2);
            $labels = array();
            for ($i = 1; $i <= $semana_atual; $i++) $labels[] = 'S'.$i;
        ?>

        var labels = <?php echo json_encode($labels); ?>;
        var dados = {
            g1: <?php echo json_encode($grupo1); ?>,
            g2: <?php echo json_encode($grupo2); ?>
        };

        // zonas: coluna do banco, nome exibido e cor (RGB)
        var zonas = [
            {col: 'A1', nome: 'Z1', cor: [0, 170, 255]},
            {col: 'A2', nome: 'Z2', cor: [71, 214, 24]},
            {col: 'A3', nome: 'Z3', cor: [255, 215, 13]},
            {col: 'AN', nome: 'Z4', cor: [231, 95, 0]},
            {col: 'FO', nome: 'Z5', cor: [155, 48, 217]}
        ];

        // Em cada semana, uma barra empilhada por grupo: Grupo 1 (cores fortes) e Grupo 2 (cores claras)
        var datasets = [];
        [{id: 'g1', nome: 'Grupo 1', alfa: 1}, {id: 'g2', nome: 'Grupo 2', alfa: 0.5}].forEach(function(grupo){
            zonas.forEach(function(z){
                datasets.push({
                    label: z.nome + ' - ' + grupo.nome,
                    zona: z.nome,
                    stack: grupo.id,
                    backgroundColor: 'rgba(' + z.cor.join(',') + ',' + grupo.alfa + ')',
                    borderColor: 'rgb(' + z.cor.join(',') + ')',
                    borderWidth: 1,
                    data: dados[grupo.id][z.col]
                });
            });
        });

        new Chart(document.getElementById('myChart_comparacao'), {
            type: 'bar',
            data: {labels: labels, datasets: datasets},
            options: {
                responsive: true,
                title: {
                    display: true,
                    text: ['Distribuição das Metragens por Zona - Semana a Semana',
                           'Em cada semana: barra da esquerda = Grupo 1 (cores fortes), barra da direita = Grupo 2 (cores claras)']
                },
                legend: {
                    labels: {
                        // uma entrada por zona (vale para os dois grupos)
                        filter: function(item, data){ return data.datasets[item.datasetIndex].stack === 'g1'; },
                        generateLabels: function(chart){
                            return zonas.map(function(z, i){
                                return {text: z.nome, fillStyle: 'rgb(' + z.cor.join(',') + ')', strokeStyle: 'rgb(' + z.cor.join(',') + ')',
                                        hidden: chart.getDatasetMeta(i).hidden === true, datasetIndex: i};
                            });
                        }
                    },
                    // clicar numa zona esconde/mostra a zona nos dois grupos
                    onClick: function(e, item){
                        var chart = this.chart;
                        var esconder = chart.getDatasetMeta(item.datasetIndex).hidden !== true;
                        chart.data.datasets.forEach(function(d, i){
                            if (d.zona === zonas[item.datasetIndex].nome) chart.getDatasetMeta(i).hidden = esconder;
                        });
                        chart.update();
                    }
                },
                tooltips: {
                    callbacks: {
                        label: function(item, data){
                            return data.datasets[item.datasetIndex].label + ': ' + item.yLabel + ' m';
                        }
                    }
                },
                scales: {
                    xAxes: [{stacked: true}],
                    yAxes: [{stacked: true, scaleLabel: {display: true, labelString: 'Metragem (m)'}}]
                }
            }
        });

    </script>
   


</body>

</html>