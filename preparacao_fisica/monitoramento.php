<html lang="pt-BR">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="../common/stylesheets/bootstrap.css">
    <link rel="stylesheet" href="../common/stylesheets/bootstrap4.css">
    <link rel="stylesheet" href="../common/stylesheets/animate.css">
    <link rel="stylesheet" href="../common/stylesheets/style.css">
    <link rel="stylesheet" href="../common/stylesheets/style1.css">
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
            <div class="section_title_container">
                <div class="section_title light">
                    <div class="row">
                        <div class="col-6">
                            <h1>Monitoramento Psicométrico</h1>
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
                            <h3>Qualidade Total de Recuperação (TQR)</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <img style="width: 40%; margin-bottom: 10px;" src='../common/images/tqr.png'/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <img style="width: 80%" src='../common/images/wbq.png'/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="cont_carac formu" style="margin-left: -25px;">
                    <form class="form-group" id="form_carac" method="post" action="db_monitoramento.php">
                        
                        <h4>Respostas</h4>
                        <h3 style="color: rgba(0, 0, 0, 0.4); margin-left: 20px;">Escala de 6 a 20</h3>
                        <div class="row" style="margin-bottom: -20px;"><label for="tqr">TQR</label><input type="number" min=6 max=20 class="form-control" style="width:30%;     position: absolute; right: 35px;" name="tqr" id="tqr" required></div>
                        <br>
                        <h3 style="color: rgba(0, 0, 0, 0.4); margin-left: 20px;">Escala de 1 a 5</h3>
                        <div class="row" style="margin-bottom: 10px;"><label for="fdg">Fadiga</label><input type="number" min=1 max=5 class="form-control" style="width:30%; position: absolute; right: 35px;" name="fdg" id="fdg" required></div>
                        <div class="row" style="margin-bottom: 10px;"><label for="qls">Qualidade do Sono</label><input type="number" min=1 max=5 class="form-control" style="width:30%; position: absolute; right: 35px;" name="qls" id="qls" required></div>
                        <div class="row" style="margin-bottom: 10px;"><label for="dmg">Dor Muscular Geral</label><input type="number" min=1 max=5 class="form-control" style="width:30%; position: absolute; right: 35px;" name="dmg" id="dmg" required></div>
                        <div class="row" style="margin-bottom: 10px;"><label for="etr">Estresse</label><input type="number" min=1 max=5 class="form-control" style="width:30%; position: absolute; right: 35px;" name="etr" id="etr" required></div>
                        <div class="row" style="margin-bottom: 10px;"><label for="hmr">Humor</label><input type="number" min=1 max=5 class="form-control" style="width:30%; position: absolute; right: 35px;" name="hmr" id="hmr" required></div>


                        <button class="btn btn-primary" style="margin-top: 10px;" type="submit">Enviar</button>
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
    </script>
</body>

</html>