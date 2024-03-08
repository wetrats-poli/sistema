<html lang="pt-BR">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="../common/stylesheets/bootstrap.css">
    <link rel="stylesheet" href="../common/stylesheets/bootstrap4.css">
    <link rel="stylesheet" href="../common/stylesheets/animate.css">
    <link rel="stylesheet" href="../common/stylesheets/style.css">
    <link rel="stylesheet" href="../common/stylesheets/style1.css">
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
                        <div class="col-6">
                            <h1>Percepção Subjetiva de Esforço</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-9">
                <div class="cont_carac caracteristicas">
                    <div class="row">
                        <div class="col-12">
                            <h3>Percepção Subjetiva de Esforço - PSE</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <h4>PSE da Sessão</h4>
                            <h5>Escala de 0 a 10. O valor deve representar o treino como <strong>um todo.</strong> Deve ser respondido com um intervalo de 30 minutos após o término do treino:</h5>
                            <ul>
                                <li>
                                    <h5><strong>0: </strong>Muito pouco intenso. Próximo a sensação de descanso ativo;</h5>
                                </li>
                                <li>
                                    <h5><strong>10: </strong>Extremamente intenso. Não necessariamente estar em estado de fadiga logo após o término do treino signifique que o treino foi extremamente intenso. Deve ser levado em consideração a sessão de treinamento como um todo;</h5>
                                </li>
                            </ul>
                            <h4>PSE do Descanso</h4>
                            <h5>Escala de 0 a 10. O valor deve representar sua recuperação inter treinos, ou seja, desde o término do treino de água do dia anterior até o início do seguinte. Não deve ser respondido em caso de falta no dia anterior. A recuperação compõe o complexo entre descanso e todas as outras atividades realizadas fora o treino de água:</h5>
                            <ul>
                                <li>
                                    <h5><strong>0: </strong>Descanso muito ruim. A sensação de casaço é igual ao do início do final do último treino (início do período de descanso);</h5>
                                </li>
                                <li>
                                    <h5><strong>10: </strong>Totalmente descansado;</h5>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="cont_carac formu" style="margin-left: -25px;">
                    <form class="form-group" id="form_carac" method="post" action="db.php">
                        
                        <h4>PSE</h4>
                        <div class="row">
                            <label for="data_treino">Data</label>
                            <input class="form-control" style="width:15.5rem; margin-bottom:7px; margin-left:1rem;" type="date" placeholder="Insira a data..." name="data_treino" id="data_treino" required>
                        </div>
                        <div class="row">
                            <label for="ses">PSE da Sessão</label>
                            <input type="number" min=0 max=10 class="form-control" style="width:30%; margin-bottom:5px; margin-left: 18px;" name="ses" id="ses" required>
                        </div>

                        <div class="row">
                            <label for="descs">PSE do Descanso</label>
                            <input type="number" min=0 max=10 class="form-control" style="width:30%; margin-bottom:7px;" name="descs" id="descs">
                        </div>
                        <button class="btn btn-primary" type="submit">Enviar</button>
                    </form>
                </div>
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
    <script>
        $("#menu").load("../common/menu/menu.html #menu_");
        $("#menus").load("../common/menu/menu.html #side_menu");
        document.getElementById('data_treino').valueAsDate = new Date();
    </script>
</body>

</html>