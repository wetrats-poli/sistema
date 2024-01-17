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
                        $link = mysqli_connect("srv976.hstgr.io", "u418844475_wtr", "Wetrats2019", "u418844475_wtr");
                
                        $todos_ids = array();

                        
                        $sql2 = 'SELECT id, apelido FROM usuarios WHERE nivel != 2 AND id != 31 AND ativo != 0 ORDER BY apelido ASC ';
                        $ids = mysqli_query($link, $sql2);
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
                            $todos_ids[] = $id['id'];
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
    
        include '../preparacao_fisica/prog_semanas.php';
        $semana_atual = acha_semana($hoje);

        if(date('l', strtotime($hoje)) == "Monday"){
            $dia_s = 1;
        }elseif (date('l', strtotime($hoje)) == "Tuesday") {
            $dia_s = 2;
        }elseif (date('l', strtotime($hoje)) == "Wednesday") {
            $dia_s = 3;
        }elseif (date('l', strtotime($hoje)) == "Thursday") {
            $dia_s = 4;
        }elseif (date('l', strtotime($hoje)) == "Friday") {
            $dia_s = 5;
        }elseif (date('l', strtotime($hoje)) == "Saturday") {
            $dia_s = 6;
        }elseif (date('l', strtotime($hoje)) == "Sunday") {
            $dia_s = 7;
        }

        $link = mysqli_connect("srv976.hstgr.io", "u418844475_wtr", "Wetrats2019", "u418844475_wtr");
        $sql2 = "SELECT data FROM treinos WHERE id >= 573 AND total>0";
        $res2 = mysqli_query($link, $sql2);

        foreach($todos_ids as $_id){
            $ses = array();
            $descs = array();
            $ratio = array();
            for($sem = 1; $sem <= $semana_atual; $sem++){   
                if($sem != $semana_atual){
                    for($dia = 1; $dia <= 7; $dia++){
                        $sqlt = "SELECT id FROM treinos WHERE semana=$sem AND dia_semana=$dia AND total>0 AND id >= 238 LIMIT 1";
                        if(mysqli_num_rows(mysqli_query($link, $sqlt))>0){
                            $sql = "SELECT ses, descs, ratio FROM pse_2024 WHERE id_atleta=$_id AND semana=$sem AND dia_semana=$dia";
                            $qry = mysqli_query($link, $sql);
                            if(mysqli_num_rows($qry)>0){
                                $res = mysqli_fetch_assoc($qry);

                                $ses[] = $res['ses'];
                                $descs[] = $res['descs'];
                                $ratio[] = $res['ratio'];
                            }
                            else{
                                $ses[] = 0;
                                $descs[] = 0;
                                $ratio[] = 0;
                            }
                        }
                    }
                }
                else{   
                    for($dia = 1; $dia <= $dia_s; $dia++){
                        $sqlt = "SELECT id FROM treinos WHERE semana=$sem AND dia_semana=$dia AND total>0 LIMIT 1";
                        if(mysqli_num_rows(mysqli_query($link, $sqlt))>0){
                            $sql = "SELECT ses, descs, ratio FROM pse_2024 WHERE id_atleta=$_id AND semana=$sem AND dia_semana=$dia";
                            $qry = mysqli_query($link, $sql);
                            if(mysqli_num_rows($qry)>0){
                                $res = mysqli_fetch_assoc($qry);

                                $ses[] = $res['ses'];
                                $descs[] = $res['descs'];
                                $ratio[] = $res['ratio'];
                            }
                            else{
                                $ses[] = 0;
                                $descs[] = 0;
                                $ratio[] = 0;
                            }
                        }
                    }
                }
            }
            
            echo "
            var ctx_ses".$_id." = document.getElementById('myChart_ses_".$_id."');
            var ctx_des".$_id." = document.getElementById('myChart_des_".$_id."');
            var ctx_rat".$_id." = document.getElementById('myChart_rat_".$_id."');

            var myChart_ses".$_id." = new Chart(ctx_ses".$_id.", {
                type: 'bar',
                data: {
                    labels:"; $res2 = mysqli_query($link, $sql2); $flag=1; echo '['; while($row = mysqli_fetch_assoc($res2)){if($flag==1) {echo '"'.date("d/m", strtotime($row['data'])).'"'; $flag=0;} else {echo ',"'.date("d/m", strtotime($row['data'])).'"';}} echo "],
                    datasets: [{
                        type: 'line',
                        label: 'PSE Sessão',
                        data: [".implode($ses, ',')."],
                        borderColor: 'rgba(0, 0, 0, 1)',
                        borderWidth: 2,
                        fill: false
                    },
                    {
                        type: 'bar',
                        label: 'PSE Sessão',
                        data: [".implode($ses, ',')."],
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

            var myChart_des".$_id." = new Chart(ctx_des".$_id.", {
                type: 'bar',
                data: {
                    labels:"; $res2 = mysqli_query($link, $sql2); $flag=1; echo '['; while($row = mysqli_fetch_assoc($res2)){if($flag==1) {echo '"'.date("d/m", strtotime($row['data'])).'"'; $flag=0;} else {echo ',"'.date("d/m", strtotime($row['data'])).'"';}} echo "],
                    datasets: [{
                        type: 'line',
                        label: 'PSE do Descanso',
                        data: [".implode($descs, ',')."],
                        borderColor: 'rgba(0, 0, 0, 1)',
                        borderWidth: 2,
                        fill: false
                    },
                    {
                        type: 'bar',
                        label: 'PSE do Descanso',
                        data: [".implode($descs, ',')."],
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

            var myChart_rat".$_id." = new Chart(ctx_rat".$_id.", {
                type: 'bar',
                data: {
                    labels:"; $res2 = mysqli_query($link, $sql2); $flag=1; echo '['; while($row = mysqli_fetch_assoc($res2)){if($flag==1) {echo '"'.date("d/m", strtotime($row['data'])).'"'; $flag=0;} else {echo ',"'.date("d/m", strtotime($row['data'])).'"';}} echo "],
                    datasets: [{
                        type: 'line',
                        label: 'PSE Ratio',
                        data: [".implode($ratio, ',')."],
                        borderColor: 'rgba(0, 0, 0, 1)',
                        borderWidth: 2,
                        fill: false
                    },
                    {
                        type: 'bar',
                        label: 'PSE Ratio',
                        data: [".implode($ratio, ',')."],
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