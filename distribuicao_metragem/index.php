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
            <?php
            require_once '../treinos/grupos.php';
            // Grupo exibido: 1 (padrão), 2 ou "ambos" para comparar
            $grupo_sel = isset($_GET['grupo']) ? $_GET['grupo'] : '1';
            if ($grupo_sel == '2') $grupos = array(2);
            elseif ($grupo_sel == 'ambos') $grupos = array(1, 2);
            else $grupos = array(1);
            ?>
            <div class="row" style="padding-bottom:15px;">
                <form method="get" class="col-4">
                    <label for="grupo"><b>Grupo:</b></label>
                    <select class="form-control" name="grupo" id="grupo" onchange="this.form.submit()">
                        <option value="1" <?php if ($grupo_sel != '2' && $grupo_sel != 'ambos') echo 'selected'; ?>>Grupo 1</option>
                        <option value="2" <?php if ($grupo_sel == '2') echo 'selected'; ?>>Grupo 2</option>
                        <option value="ambos" <?php if ($grupo_sel == 'ambos') echo 'selected'; ?>>Comparar os dois</option>
                    </select>
                </form>
            </div>
            <?php foreach ($grupos as $g) { ?>
            <div class="row">
                <div class="col-6">
                    <canvas id="myChart_dia_<?php echo $g ?>" height="80%" width="100%"></canvas>
                </div>
                <div class="col-6">
                    <canvas id="myChart_sem_<?php echo $g ?>" height="80%" width="100%"></canvas>
                </div>
            </div>
            <?php } ?>
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
            date_default_timezone_set('America/Sao_Paulo');
            $hoje=date("Y-m-d");
            $semana_atual = acha_semana($hoje);
            
            require_once '../db_con.php';

            // Soma das metragens por zona em cada semana, para o Grupo 1 (tabela treinos) ou o Grupo 2 (treinos_grupo2)
            function zonas_por_semana($con, $semana_atual, $grupo){
                $zonas = array('A1' => array(), 'A2' => array(), 'A3' => array(), 'AN' => array());
                for($sem = 1; $sem <= $semana_atual; $sem++){
                    if ($grupo == 2) {
                        $sql = "SELECT SUM(g.A1), SUM(g.A2), SUM(g.A3), SUM(g.AN) FROM treinos_grupo2 g INNER JOIN treinos t ON t.id = g.id_treino WHERE t.semana=$sem";
                    } else {
                        $sql = "SELECT SUM(A1), SUM(A2), SUM(A3), SUM(AN) FROM treinos WHERE semana=$sem";
                    }
                    $res = consulta_segura($con, $sql);
                    $r = $res ? mysqli_fetch_array($res) : array(0, 0, 0, 0);
                    $zonas['A1'][] = (int)$r[0];
                    $zonas['A2'][] = (int)$r[1];
                    $zonas['A3'][] = (int)$r[2];
                    $zonas['AN'][] = (int)$r[3];
                }
                return $zonas;
            }
        ?>

        // Monta os dois gráficos (separado e acumulado) de um grupo
        function montaGraficos(grupo, labels, A1, A2, A3, An){
            // cada gráfico precisa do seu próprio conjunto de dados (o Chart.js altera o objeto)
            var criaDatasets = function(){
                return [
                    {label: 'Z1', backgroundColor: '#00aaff', data: A1.slice()},
                    {label: 'Z2', backgroundColor: '#47d618', data: A2.slice()},
                    {label: 'Z3', backgroundColor: '#ffd70d', data: A3.slice()},
                    {label: 'An1/2', backgroundColor: '#e75f00', data: An.slice()}
                ];
            };

            new Chart(document.getElementById('myChart_dia_' + grupo), {
                type: 'bar',
                data: {labels: labels, datasets: criaDatasets()},
                options: {
                    title: {
                        display: true,
                        text: 'Distribuição das Metragens - Separado - Grupo ' + grupo
                    },
                    responsive: true,
                }
            });

            new Chart(document.getElementById('myChart_sem_' + grupo), {
                type: 'bar',
                data: {labels: labels, datasets: criaDatasets()},
                options: {
                    title: {
                        display: true,
                        text: 'Distribuição das Metragens - Acumulado - Grupo ' + grupo
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: false
                    },
                    responsive: true,
                    scales: {
                        xAxes: [{
                            stacked: true
                        }],
                        yAxes: [{
                            stacked: true
                        }]
                    }
                }
            });
        }

        <?php
            foreach ($grupos as $g) {
                $z = zonas_por_semana($con, $semana_atual, $g);
                $labels = array();
                for ($i = 1; $i <= sizeof($z['A1']); $i++) $labels[] = 'S'.$i;
                echo "montaGraficos($g, ".json_encode($labels).", ".json_encode($z['A1']).", ".json_encode($z['A2']).", ".json_encode($z['A3']).", ".json_encode($z['AN']).");".PHP_EOL;
            }
        ?>

    </script>
   


</body>

</html>