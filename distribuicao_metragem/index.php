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
            <div class="row" style="padding-bottom:10px; align-items:flex-end;">
                <div class="col-md-3 col-sm-6">
                    <label for="exibir"><b>Exibir:</b></label>
                    <select class="form-control" id="exibir">
                        <option value="ambos">Comparar os dois grupos</option>
                        <option value="g1">Só o Grupo 1</option>
                        <option value="g2">Só o Grupo 2</option>
                    </select>
                </div>
                <div class="col-md-3 col-sm-6">
                    <a href="./exportar.php" class="btn btn-primary">Exportar para Excel</a>
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

        // Cada grupo tem a sua cor (Grupo 1 azul, Grupo 2 laranja); o tom vai do claro (Z1) ao escuro (Z5)
        var zonas = [
            {col: 'A1', nome: 'Z1'},
            {col: 'A2', nome: 'Z2'},
            {col: 'A3', nome: 'Z3'},
            {col: 'AN', nome: 'Z4'},
            {col: 'FO', nome: 'Z5'}
        ];
        var grupos = [
            {id: 'g1', nome: 'Grupo 1', cores: ['#a6cee3', '#5aa9d6', '#2a7fbf', '#1a5a9a', '#0b2f66']},
            {id: 'g2', nome: 'Grupo 2', cores: ['#fdd49e', '#fdae61', '#f07d2e', '#c9481a', '#7f1d0d']}
        ];

        // Em cada semana, uma barra empilhada por grupo
        var datasets = [];
        grupos.forEach(function(grupo){
            zonas.forEach(function(z, i){
                datasets.push({
                    label: z.nome + ' - ' + grupo.nome,
                    stack: grupo.id,
                    backgroundColor: grupo.cores[i],
                    borderColor: '#ffffff',
                    borderWidth: 1,
                    data: dados[grupo.id][z.col]
                });
            });
        });

        var grafico = new Chart(document.getElementById('myChart_comparacao'), {
            type: 'bar',
            data: {labels: labels, datasets: datasets},
            options: {
                responsive: true,
                title: {
                    display: true,
                    text: ['Distribuição das Metragens por Zona - Semana a Semana',
                           'Azul = Grupo 1 (barra da esquerda)  |  Laranja = Grupo 2 (barra da direita)  |  tom mais escuro = zona mais intensa']
                },
                tooltips: {
                    callbacks: {
                        label: function(item, data){
                            return data.datasets[item.datasetIndex].label + ': ' + item.yLabel + ' m';
                        }
                    }
                },
                scales: {
                    xAxes: [{stacked: true, categoryPercentage: 0.9, barPercentage: 0.95}],
                    yAxes: [{stacked: true, scaleLabel: {display: true, labelString: 'Metragem (m)'}}]
                }
            }
        });

        // Escolha de exibição: comparar os dois grupos ou ver só um deles
        document.getElementById('exibir').addEventListener('change', function(){
            var modo = this.value;
            grafico.data.datasets.forEach(function(d, i){
                grafico.getDatasetMeta(i).hidden = (modo === 'g1' && d.stack === 'g2') || (modo === 'g2' && d.stack === 'g1');
            });
            grafico.update();
        });

    </script>
   


</body>

</html>