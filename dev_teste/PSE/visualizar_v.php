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
            <div class="row">
                <canvas id="myChart_ses" height="14%" width="90%"></canvas>
            </div>
            <div class="row">
                <canvas id="myChart_des" height="14%" width="90%"></canvas>
            </div>
            <div class="row">
                <canvas id="myChart_rat" height="14%" width="90%"></canvas>
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

    <?php

    $link = mysqli_connect("auth-db213.hstgr.io", "u418844475_wtr", "Wetrats2019", "u418844475_wtr");
    $sql = "SELECT ses, descs, ratio FROM pse WHERE id_treino > 98";
    $res = mysqli_query($link, $sql);

    $sql2 = "SELECT data FROM treinos WHERE id > 98";
    $res2 = mysqli_query($link, $sql2);

    ?>
    <script>
        var ctx_ses = document.getElementById('myChart_ses');
        var ctx_des = document.getElementById('myChart_des');
        var ctx_rat = document.getElementById('myChart_rat');

        var myChart1 = new Chart(ctx_ses, {
            type: 'bar',
            data: {
                labels: <?php $flag=1; echo '['; while($row = mysqli_fetch_assoc($res2)){if($flag==1) {echo '"'.date("d/m", strtotime($row['data'])).'"'; $flag=0;} else {echo ',"'.date("d/m", strtotime($row['data'])).'"';}} echo ']';  ?>,
                datasets: [{
                    type: 'line',
                    label: 'PSE Sessão',
                    data: <?php $flag=1; echo '['; while($row = mysqli_fetch_assoc($res)){if($flag==1) {echo $row['ses']; $flag=0;} else {echo ','.$row['ses'];}} echo ']';  ?>,
                    borderColor: 'rgba(0, 0, 0, 1)',
                    borderWidth: 2,
                    fill: false
                },
                {
                    type: 'bar',
                    label: 'PSE Sessão',
                    data: <?php $res=mysqli_query($link, $sql); $flag=1; echo '['; while($row = mysqli_fetch_assoc($res)){if($flag==1) {echo $row['ses']; $flag=0;} else {echo ','.$row['ses'];}} echo ']';  ?>,
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

        var myChart2 = new Chart(ctx_des, {
            type: 'bar',
            data: {
                labels: <?php $res2=mysqli_query($link, $sql2); $flag=1; echo '['; while($row = mysqli_fetch_assoc($res2)){if($flag==1) {echo '"'.date("d/m", strtotime($row['data'])).'"'; $flag=0;} else {echo ',"'.date("d/m", strtotime($row['data'])).'"';}} echo ']';  ?>,
                datasets: [{
                    type: 'line',
                    label: 'PSE do Descanso',
                    data: <?php $res=mysqli_query($link, $sql); $flag=1; echo '['; while($row = mysqli_fetch_assoc($res)){if($flag==1) {echo $row['descs']; $flag=0;} else {echo ','.$row['descs'];}} echo ']';  ?>,
                    borderColor: 'rgba(0, 0, 0, 1)',
                    borderWidth: 2,
                    fill: false
                },
                {
                    type: 'bar',
                    label: 'PSE do Descanso',
                    data: <?php $res=mysqli_query($link, $sql); $flag=1; echo '['; while($row = mysqli_fetch_assoc($res)){if($flag==1) {echo $row['descs']; $flag=0;} else {echo ','.$row['descs'];}} echo ']';  ?>,
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

        var myChart3 = new Chart(ctx_rat, {
            type: 'bar',
            data: {
                labels: <?php $res2=mysqli_query($link, $sql2); $flag=1; echo '['; while($row = mysqli_fetch_assoc($res2)){if($flag==1) {echo '"'.date("d/m", strtotime($row['data'])).'"'; $flag=0;} else {echo ',"'.date("d/m", strtotime($row['data'])).'"';}} echo ']';  ?>,
                datasets: [{
                    type: 'line',
                    label: 'PSE Ratio',
                    data: <?php $res=mysqli_query($link, $sql); $flag=1; echo '['; while($row = mysqli_fetch_assoc($res)){if($flag==1) {echo $row['ratio']; $flag=0;} else {echo ','.$row['ratio'];}} echo ']';  ?>,
                    borderColor: 'rgba(0, 0, 0, 1)',
                    borderWidth: 2,
                    fill: false
                },
                {
                    type: 'bar',
                    label: 'PSE Ratio',
                    data: <?php $res=mysqli_query($link, $sql); $flag=1; echo '['; while($row = mysqli_fetch_assoc($res)){if($flag==1) {echo $row['ratio']; $flag=0;} else {echo ','.$row['ratio'];}} echo ']';  ?>,
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
        });

        

    </script>


</body>

</html>