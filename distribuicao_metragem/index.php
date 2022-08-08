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
                <div class="col-6">                   
                    <canvas id="myChart_dia" height="80%" width="100%"></canvas>
                </div>
                <div class="col-6">                   
                    <canvas id="myChart_sem" height="80%" width="100%"></canvas>
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
            date_default_timezone_set('America/Sao_Paulo');
            $hoje=date("Y-m-d");
            $semana_atual = acha_semana($hoje);
            
            $link = mysqli_connect("auth-db213.hostinger.com.br", "u418844475_wtr", "wetrats2019", "u418844475_wtr");

            $A1 = array();
            $A2 = array();
            $A3 = array();
            $An = array();
            
            for($sem = 1; $sem <= $semana_atual; $sem++){
                $sql_1 = "SELECT SUM(A1) FROM treinos WHERE semana=$sem";
                $sql_2 = "SELECT SUM(A2) FROM treinos WHERE semana=$sem";
                $sql_3 = "SELECT SUM(A3) FROM treinos WHERE semana=$sem";
                $sql_n = "SELECT SUM(AN) FROM treinos WHERE semana=$sem";

                $res1 = mysqli_fetch_array(mysqli_query($link, $sql_1));
                $res2 = mysqli_fetch_array(mysqli_query($link, $sql_2));
                $res3 = mysqli_fetch_array(mysqli_query($link, $sql_3));
                $resn = mysqli_fetch_array(mysqli_query($link, $sql_n));

                $A1[] = (int)$res1[0];
                $A2[] = (int)$res2[0];
                $A3[] = (int)$res3[0];
                $An[] = (int)$resn[0];
                
            }
        ?>
        var ctx_dia = document.getElementById('myChart_dia');
        var ctx_sem = document.getElementById('myChart_sem');

        var myChart_dia = new Chart(ctx_dia, {
            type: 'bar',
            data: {
                labels: <?php echo "['S1'"; for($i=2; $i<=sizeof($A1); $i++){echo ",'S".$i."'";} echo ']'; ?>,
                datasets: [{
                    label: 'A1',
                    backgroundColor: '#00aaff',
                    data: <?php echo '['.implode($A1, ',').']'; ?>
                },{
                    label: 'A2',
                    backgroundColor: '#47d618',
                    data: <?php echo '['.implode($A2, ',').']'; ?>
                },{
                    label: 'A3',
                    backgroundColor: '#ffd70d',
                    data: <?php echo '['.implode($A3, ',').']'; ?>
                },{
                    label: 'An1/2',
                    backgroundColor: '#e75f00',
                    data: <?php echo '['.implode($An, ',').']'; ?>
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Distribuição das Metragens - Separado'
                },
                responsive: true,
            }    
        });

        var myChart_sem = new Chart(ctx_sem, {
            type: 'bar',
            data: {
                labels: <?php echo "['S1'"; for($i=2; $i<=sizeof($A1); $i++){echo ",'S".$i."'";} echo ']'; ?>,
                datasets: [{
                    label: 'A1',
                    backgroundColor: '#00aaff',
                    data: <?php echo '['.implode($A1, ',').']'; ?>
                },{
                    label: 'A2',
                    backgroundColor: '#47d618',
                    data: <?php echo '['.implode($A2, ',').']'; ?>
                },{
                    label: 'A3',
                    backgroundColor: '#ffd70d',
                    data: <?php echo '['.implode($A3, ',').']'; ?>
                },{
                    label: 'An1/2',
                    backgroundColor: '#e75f00',
                    data: <?php echo '['.implode($An, ',').']'; ?>
                }]
            },
            options: {
                title: {
                    display: true,
                    text: 'Distribuição das Metragens - Acumulado'
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

    </script>
   


</body>

</html>