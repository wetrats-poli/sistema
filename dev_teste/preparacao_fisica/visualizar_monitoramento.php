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

?>

<body>
    <div id="page">
        <nav class="fh5co-nav" id="menu-list" role="navigation">
            <div id="menu"></div>
        </nav>
        <div id="menus"></div>

        <div class="container-fluid" style="padding-top:60px;">
            <div class="row">
                <canvas id="myChart_sem" height="14%" width="90%"></canvas>
            </div>
            <!-- <div class="row">
                <canvas id="myChart_acc" height="14%" width="90%"></canvas>
            </div> -->
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
    <!-- <script src="../common/js/Chart.bundle.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script>
        $("#menu").load("../common/menu/menu.html #menu_");
        $("#menus").load("../common/menu/menu.html #side_menu");
    </script>

    <?php

    $link = mysqli_connect("auth-db213.hstgr.io", "u418844475_wtr", "wetrats2019", "u418844475_wtr");
    $sql1 = "SELECT tqr, fdg, qls, dmg, etr, hmr  FROM monitoramentos_academia WHERE semana=0 and dia_semana=1";
    $sql2 = "SELECT tqr, fdg, qls, dmg, etr, hmr  FROM monitoramentos_academia WHERE semana=0 and dia_semana=2";
    $sql3 = "SELECT tqr, fdg, qls, dmg, etr, hmr  FROM monitoramentos_academia WHERE semana=0 and dia_semana=3";
    $sql4 = "SELECT tqr, fdg, qls, dmg, etr, hmr  FROM monitoramentos_academia WHERE semana=0 and dia_semana=4";
    $sql5 = "SELECT tqr, fdg, qls, dmg, etr, hmr  FROM monitoramentos_academia WHERE semana=0 and dia_semana=5";
    $sql6 = "SELECT tqr, fdg, qls, dmg, etr, hmr  FROM monitoramentos_academia WHERE semana=0 and dia_semana=6";
    $sql7 = "SELECT tqr, fdg, qls, dmg, etr, hmr  FROM monitoramentos_academia WHERE semana=0 and dia_semana=7";
    
    $seg = mysqli_fetch_assoc(mysqli_query($link, $sql1));
    $ter = mysqli_fetch_assoc(mysqli_query($link, $sql2));
    $qua = mysqli_fetch_assoc(mysqli_query($link, $sql3));
    $qui = mysqli_fetch_assoc(mysqli_query($link, $sql4));
    $sex = mysqli_fetch_assoc(mysqli_query($link, $sql5));
    $sab = mysqli_fetch_assoc(mysqli_query($link, $sql6));
    $dom = mysqli_fetch_assoc(mysqli_query($link, $sql7));

    ?>
    <script>
        Chart.defaults.global.plugins.datalabels.anchor = 'end';
        Chart.defaults.global.plugins.datalabels.align = 'end';

        var ctx_sem = document.getElementById('myChart_sem');
       
        var myChart1 = new Chart(ctx_sem, {
            type: 'bar',
            data: {
                labels: ['TQR', 'Fadiga', 'Qualidade do Sono', 'Dor Muscular Geral', 'Nível de Estresse', 'Humor'],
                datasets: [{
                    label: ['Segunda'],
                    backgroundColor: 'rgba(255, 187, 0, 0.3)',
                    borderColor: 'rgba(255, 187, 0, 1)',
                    borderWidth: 1,
                    data:[<?php echo $seg['tqr'].','.$seg['fdg'].','.$seg['qls'].','.$seg['dmg'].','.$seg['etr'].','.$seg['hmr'] ?>]
                },
                {
                    label: ['Terça'],
                    backgroundColor: 'rgba(0, 0, 46, 0.6)',
                    borderColor: 'rgba(0, 0, 46, 1)',
                    borderWidth: 1,
                    data:[<?php echo $ter['tqr'].','.$ter['fdg'].','.$ter['qls'].','.$ter['dmg'].','.$ter['etr'].','.$ter['hmr'] ?>]
                },
                {
                    label: ['Quarta'],
                    backgroundColor: 'rgba(255, 187, 0, 0.3)',
                    borderColor: 'rgba(255, 187, 0, 1)',
                    borderWidth: 1,
                    data:[<?php echo $qua['tqr'].','.$qua['fdg'].','.$qua['qls'].','.$qua['dmg'].','.$qua['etr'].','.$qua['hmr'] ?>]
                },
                {
                    label: ['Quinta'],
                    backgroundColor: 'rgba(0, 0, 46, 0.6)',
                    borderColor: 'rgba(0, 0, 46, 1)',
                    borderWidth: 1,
                    data:[<?php echo $qui['tqr'].','.$qui['fdg'].','.$qui['qls'].','.$qui['dmg'].','.$qui['etr'].','.$qui['hmr'] ?>]
                },
                {
                    label: ['Sexta'],
                    backgroundColor: 'rgba(255, 187, 0, 0.3)',
                    borderColor: 'rgba(255, 187, 0, 1)',
                    borderWidth: 1,
                    data:[<?php echo $sex['tqr'].','.$sex['fdg'].','.$sex['qls'].','.$sex['dmg'].','.$sex['etr'].','.$sex['hmr'] ?>]
                },
                {
                    label: ['Sábado'],
                    backgroundColor: 'rgba(0, 0, 46, 0.6)',
                    borderColor: 'rgba(0, 0, 46, 1)',
                    borderWidth: 1,
                    data:[<?php echo $sab['tqr'].','.$sab['fdg'].','.$sab['qls'].','.$sab['dmg'].','.$sab['etr'].','.$sab['hmr'] ?>]
                },
                {
                    label: ['Domingo'],
                    backgroundColor: 'rgba(255, 187, 0, 0.3)',
                    borderColor: 'rgba(255, 187, 0, 1)',
                    borderWidth: 1,
                    data:[<?php echo $dom['tqr'].','.$dom['fdg'].','.$dom['qls'].','.$dom['dmg'].','.$dom['etr'].','.$dom['hmr'] ?>]
                }]
            
            },
            options: {
                scales:{
                    yAxes: [{
                        display: false,
                        ticks:{
                            max: 20
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
        });

        

        

    </script>


</body>

</html>