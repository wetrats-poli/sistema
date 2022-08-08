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

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="../common/stylesheets/bootstrap.css">
    <link rel="stylesheet" href="../common/stylesheets/bootstrap4.css">
    <link rel="stylesheet" href="../common/stylesheets/animate.css">
    <link rel="stylesheet" href="../common/stylesheets/style.css">
    <link rel="stylesheet" href="../common/stylesheets/style1.css">
    <link rel="stylesheet" href="../common/stylesheets/calendario.css">
    <link rel="icon" type="image/png" href="../common/images/favicon-32x32.png" sizes="32x32" />
    <title>Wetrats - Calendário</title>

    <script src="../common/js/jquery.min.js"></script>
    <script src="../common/js/jquery.easing.1.3.js"></script>
    <script src="../common/js/contagem.js"></script>
</head>

<body>
    <!-----Modal precisa ficar aqui pra acompanhar o rolamento da pagina----->
    <div class="bg-modal">
        <div class="modal-contents">
            <div class="col">
            <div class="close"><a href="./index.php">+</a></div>
                <div id="divDescricao"></div>
            </div>
        </div>
    </div>
    <div id="page">
        <nav class="fh5co-nav" id="menu-list" role="navigation">
            <div id="menu"></div>
        </nav>
        <div id="menus"></div>


        <div style="padding-top:60px;">
            <div class="calendario">
                <div id="cal">
                    <?php
                        include 'calendario.php';
                    
                        montaCalendario();
                    ?>
                </div>
            </div>
            
            <?php
                if($_POST["flag"] != "1"){
                    echo "<div class='evento_pessoal'><form id='form-evento' name='form-evento' method='post' action='#' class='form-group'>
                        <h2>ADICIONAR EVENTOS PESSOAIS</h2>
                        <label for='dia'>Escolha o Dia do Evento:</label>
                        <input type='text' id='dia' name='dia' class='form-control' placeholder='Dia' onfocus=\"(this.type='date')\" onblur=\"if(this.value==''){this.type='text'}\" required>

                        <label for='desc'>Escolha uma Descrição:</label>
                        <h4>Máximo de 15 caracteres</h4>
                        <input type='text' id='desc' name='desc' class='form-control' maxlength='15' placeholder='Descrição' required>
                        <button id='envia_evento' type='submit' class='btn btn-primary' name='flag' value='1'>Enviar</button>
                        </div></form><script>$('#envia_evento').on('click', function(){ $('#divDescricao').innerHTML='EVENTO ADIDIONADO COM SUCESSO!'; $('.bg-modal').style.display = 'flex';});</script>";
                }

                else if($_POST["flag"] == "1"){
                    $data = $_POST["dia"];
                    $desc = $_POST["desc"];
                    $id = (int)$_SESSION['ID'];
                    
                    $link = mysqli_connect("auth-db213.hostinger.com.br", "u418844475_wtr", "wetrats2019", "u418844475_wtr");
                    $sql = "INSERT INTO eventos_pessoais (id_usuario, `data`, nome) VALUES ('$id', '$data', '$desc')";
                    $res = mysqli_query($link, $sql); 

                    echo "<div class='confirma'><div class='box'><h2>EVENTO ADICIONADO COM SUCESSO!</h2></div></div>";
                    echo "<div id='meta'><meta http-equiv='refresh' content='2'></div>";
                    echo "<script>$(window).on('load', function(){ $('#meta').empty();});</script>";
                }    
            ?>
            <div class="contg">
                <h2>CONTAGEM REGRESSIVA</h2>
                <table id="tbl" class="cont_table">
                
                <?php
                    session_start();

                    $link = mysqli_connect("auth-db213.hostinger.com.br", "u418844475_wtr", "wetrats2019", "u418844475_wtr");
                    $sql = "SELECT `descricao`, `data` FROM `contagem` WHERE `equipe` = 1 OR `id_usuario` = ".$_SESSION['ID']." ORDER BY `data` ASC";
                    $res = mysqli_query($link, $sql); 
                    echo '<tbody>';
                    $hoje = new DateTime();
                    $hoje -> setTime(0, 0, 0);
                    while($vet = mysqli_fetch_array($res)){
                        $data = $vet[1];
                        $data_ = new DateTime($data);
                        $data_ -> setTime(23, 59, 59);
                        if($data_ > $hoje){
                            $ano_s = '';
                            $mes_s = '';
                            $dia_s = '';
                            for($i=0; $i < strlen($data); $i++){ 
                                if($i<=3){
                                    $ano_s .= $data[$i];
                                }
                                if($i>=5 && $i<=6){
                                    $mes_s .= $data[$i];
                                }
                                if($i>=8 && $i<=9){
                                    $dia_s .= $data[$i];
                                }
                            }
                            
                            $ano = (int)$ano_s;
                            $mes = (int)$mes_s;
                            $dia = (int)$dia_s;
                
                            echo '<tr class="cont_indiv"><td class="cont_txt">'.$vet[0].'</td><td class="contagem" id="contagem'.$ano.$mes.$dia.'"><script>contagem('.$ano.', '.$mes.', '.$dia.')</script></td></tr><tr class="space"><td class="space"></td><td class="space"></td></tr>';
                        }
                    }
                    echo '</tbody>';
                ?>
                </table>
                <a id="contbtn" class="cont_btn" onclick="hideShow();" href="#">Nova Contagem</a>

                <div id="cont_form">
                    <form class="form-group" action="#" method="post">
                        <label for="cont_data">Escolha a Dia para Contagem:</label>
                        <input type="text" id="cont_data" class="form-control" name="cont_data" placeholder='Dia' onfocus="(this.type='date')" onblur="if(this.value==''){this.type='text'}" required>

                        <label for='cont_desc'>Escolha uma Descrição:</label>
                        <h4>Máximo de 10 caracteres</h4>
                        <input type='text' id='cont_desc' name='cont_desc' class='form-control' maxlength='10' placeholder='Descrição' required>

                        <?php
                            if($_SESSION["NIVEL"] != "1"){
                                echo "<label id='ck_lbl' for='cont_ck' class='container1'>Contagem para Equipe
                                      <input type='checkbox' id='cont_ck' name='cont_rd' value='1'>
                                      <spam class='checkmark'></spam>
                                      </label>";
                            }
                        ?>


                        <button id='envia_cont' type='submit' class='btn btn-primary' name="flag1" value="1">Enviar</button>

                        <?php
                            if($_POST["flag1"] == "1"){
                                $data = $_POST["cont_data"];
                                $desc = $_POST["cont_desc"];
                                $id = (int)$_SESSION["ID"];
                                $equipe = (int)$_POST["cont_rd"];


                                $link = mysqli_connect("auth-db213.hostinger.com.br", "u418844475_wtr", "wetrats2019", "u418844475_wtr");
                                $sql = "INSERT INTO contagem (id_usuario, equipe, `data`, descricao) VALUES ('$id', $equipe, '$data', '$desc')";
                                mysqli_query($link, $sql);

                                echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
                                echo "<script>$(window).on('load', function(){ $('#meta').empty();});</script>";
                            }
                        ?>
                    </form>
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
            <script src="../common/js/calendario.js"></script>
            <script src="../common/js/treino.js"></script>
            <script src="../common/js/jquery.easing.1.3.js"></script>
            <script>
                $("#menu").load("../common/menu/menu.html #menu_");
                $("#menus").load("../common/menu/menu.html #side_menu");
            </script>
</body>

</html>