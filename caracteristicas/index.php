<html lang="pt-BR">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="../common/stylesheets/bootstrap.css">
    <link rel="stylesheet" href="../common/stylesheets/bootstrap4.css">
    <link rel="stylesheet" href="../common/stylesheets/animate.css">
    <link rel="stylesheet" href="../common/stylesheets/style.css">
    <link rel="stylesheet" href="../common/stylesheets/style1.css">
    <link rel="icon" type="image/png" href="../common/images/favicon-32x32.png" sizes="32x32" />
    <title>Wetrats - Características</title>
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
                                <h1>CARACTERÍSTICAS INDIVIDUAIS</h1>
                            </div>
                            <div class="col-6">
                                <div class="row">
                                    <?php

                                    if($_SESSION['NIVEL'] == 2){
                                        $link = mysqli_connect("auth-db213.hstgr.io", "u418844475_wtr", "wetrats2019", "u418844475_wtr");
                                        $sql = "SELECT id, nome FROM usuarios where nivel!='2' and id!='31' and ativo=1 ORDER BY nome";
                                        $resultado = mysqli_query($link, $sql);
                                        
                                        echo '<div class="col-5"><h4>Selecione o(a) atleta para editar ou visualizar as características</h4></div>';
                                        echo '<div class="col-7"><form class="form-group"><select class="form-control" id="nome" name="nome">';
                                        echo '<option value=0>--</option>';
                                        while($row = mysqli_fetch_assoc($resultado)){
                                            echo '<option value='.$row["id"].'>'.$row["nome"].'</option>';
                                        }
                                        
                                        echo '</select>';
                                        echo '<div class="col-6" style="display: inline;"><label for="ac1">Visualizar</label><input type="radio" id="ac1" name="rd_ac" class="form-control" style="height: 18px; width: 25px; display: inline-block; margin-left: 10px;" value="vis"></div>';
                                        echo '<div class="col-6" style="display: inline;"><label for="ac2">Editar</label><input type="radio" id="ac2" name="rd_ac" class="form-control" style="height: 18px; width: 25px; display: inline-block; margin-left: 10px;" value="edit"></div>';
                                        echo'</form></div>';
                                    }

                                    ?> 
                                </div>
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
                                <h3>Parâmetros</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <h4>Gerais</h4>
                                <ul>
                                    <li><h5><strong>FORÇA: </strong>Aplicação de força pelas mãos (fase de apoio e impulsão) e pés(de cima para baixo ou para trás);</h5></li>
                                    <li><h5><strong>VELOCIDADE: </strong>Quantidade de produção de giro de braço e do batimento de pernas coordenativamente com auxílio dos demais segmentos corporais, na máxima velocidade possível;</h5></li>
                                    <li><h5><strong>RESISTÊNCIA AERÓBIA: </strong>Facilidade de produção e manutenção da intensidade em séries de A1, A2 e A3;</h5></li>
                                    <li><h5><strong>RESISTÊNCIA ANAERÓBIA: </strong>Facilidade de produção e manutenção da intensidade em séries de An1;</h5></li>
                                    <li><h5><strong>TÉCNICA GERAL: </strong>Facilidade em modificar, adiquirir ou refinar novas habilidades técnicas;</h5></li>
                                    <li><h5><strong>EQUILÍBRIO EMOCIONAL: </strong>Compõe todas emoções que devem ser controladas, como ansiedade, concentração, autoconfiança, nervosismo, etc...</h5></li>
                                </ul>
                                <h4>Específicos - Estilo(s) Principal(is)</h4>
                                <ul>
                                    <li><h5><strong>CABEÇA: </strong>Posicionamento da cabeçada em relação ao corpo durante o nado;</h5></li>
                                    <li><h5><strong>PERNA: </strong>Qualidade do movimento de batimento de pernas, desde o quadril até os pés;</h5></li>
                                    <li><h5><strong>BRAÇO: </strong>Qualidade do movimento da braçada, desde o ombro até as mãos, compondo todas as fazes do movimento;</h5></li>
                                    <li><h5><strong>TRONCO: </strong>Qualidade do movimento de rotação (crawl e costas) ou amplitude (peito e borboleta) do tronco nos nados;</h5></li>
                                    <li><h5><strong>QUADRIL: </strong>Posicionamento em movimento do quadril em relação ao resto do corpo e a superfície da água;</h5></li>
                                    <li><h5><strong>COORDENAÇÃO GERAL: </strong>Complexo intersegmentar do timing de cada parte do macro movimento;</h5></li>
                                    <li><h5><strong>SAÍDA DO BLOCO: </strong>Impulsão + Movimento + Transição;</h5></li>
                                    <li><h5><strong>VIRADA: </strong>Entrada + Movimento + Transição;</h5></li>
                                    <li><h5><strong>CHEGADA: </strong>Manutenção da velocidade + distância e extensão da última braçada até a borda;</h5></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <?php
                        $link = mysqli_connect("auth-db213.hstgr.io", "u418844475_wtr", "wetrats2019", "u418844475_wtr"); 
                        $sql2 = "SELECT forc, vel, res_ae, res_ana, tg, ee, est1, cb1, pr1, br1, tr1, qd1, co1, sa1, vr1, ch1, est2, cb2, pr2, br2, tr2, qd2, co2, sa2, vr2, ch2 FROM caracteristicas2020 WHERE id_atleta=".$_SESSION['ID']." AND tipo=1";
                        $resp2 = mysqli_fetch_assoc(mysqli_query($link, $sql2));               
                    ?>
                    <div class="cont_carac formu" style="margin-left: -25px;">
                        <form class="form-group" id="form_carac" method="post" action="db.php">
                            <input type="number" style="display: none;" id="tipo" name="tipo" value="1">
                            <input type="number" style="display: none;" id="id_atleta" name="id_atleta">
                            <h4>Gerais</h4>
                            <div class="row"><label for="for">Força</label><input type="number" min=0 max=10 class="form-control" style="width:30%" name="for" id="for" value=<?php echo $resp2['forc']; ?> required></div>

                            <div class="row"><label for="vel">Velocidade</label><input type="number" min=0 max=10 class="form-control" style="width:30%" name="vel" id="vel" value=<?php echo $resp2['vel']; ?> required></div>

                            <div class="row"><label for="res_ae">Resistência Aeróbia</label><input type="number" min=0 max=10 class="form-control" style="width:30%" id="res_ae" name="res_ae" value=<?php echo $resp2['res_ae']; ?> required></div>

                            <div class="row"><label for="res_ana">Resistência Anaeróbia</label><input type="number" min=0 max=10 class="form-control" style="width:30%" id="res_ana" name="res_ana" value=<?php echo $resp2['res_ana']; ?> required></div>

                            <div class="row"><label for="tg">Técnica Geral</label><input type="number" min=0 max=10 class="form-control" style="width:30%" id="tg" name="tg" value=<?php echo $resp2['tg']; ?> required></div>

                            <div class="row"><label for="ee">Equilíbrio Emocional</label><input type="number" min=0 max=10 class="form-control" style="width:30%" id="ee" name="ee" value=<?php echo $resp2['ee']; ?> required></div>

                            <h4>Estilo(s)</h4>

                            <div class="row">
                                <div class="col-6">
                                    <div class="estilos">
                                        <label for="est1">Estilo 1</label><select class="form-control" style="width:87%; margin-left:2px;" id="est1" name="est1"><option id="lv1" value="Livre" <?php if($resp2['est1'] == 'Livre') echo 'selected'; ?>>Livre</option><option id="co1" value="Costas" <?php if($resp2['est1'] == 'Costas') echo 'selected'; ?>>Costas</option><option id="bo1" value="Borboleta" <?php if($resp2['est1'] == 'Borboleta') echo 'selected'; ?>>Borboleta</option><option id="pe1" value="Peito" <?php if($resp2['est1'] == 'Peito') echo 'selected'; ?>>Peito</option></select>
                                    </div>

                                    <div class="row"><label for="cb1">Cabeça</label><input type="number" min=0 max=10 class="form-control" style="width:30%" id="cb1" name="cb1" value=<?php echo $resp2['cb1']; ?> required></div>

                                    <div class="row"><label for="pr1">Perna</label><input type="number" min=0 max=10 class="form-control" style="width:30%" id="pr1" name="pr1" value=<?php echo $resp2['pr1']; ?> required></div>

                                    <div class="row"><label for="br1">Braço</label><input type="number" min=0 max=10 class="form-control" style="width:30%" id="br1" name="br1" value=<?php echo $resp2['br1']; ?> required></div>

                                    <div class="row"><label for="tr1">Tronco</label><input type="number" min=0 max=10 class="form-control" style="width:30%" id="tr1" name="tr1" value=<?php echo $resp2['tr1']; ?> required></div>

                                    <div class="row"><label for="qd1">Quadril</label><input type="number" min=0 max=10 class="form-control" style="width:30%" id="qd1" name="qd1" value=<?php echo $resp2['qd1']; ?> required></div>

                                    <div class="row"><label for="co1" style="font-size: 8px;">Coordenação</label><input type="number" min=0 max=10 class="form-control" style="width:30%" id="co1" name="co1" value=<?php echo $resp2['co1']; ?> required></div>

                                    <div class="row"><label for="sa1">Saída</label><input type="number" min=0 max=10 class="form-control" style="width:30%" id="sa1" name="sa1" value=<?php echo $resp2['sa1']; ?> required></div>

                                    <div class="row"><label for="vr1">Virada</label><input type="number" min=0 max=10 class="form-control" style="width:30%" id="vr1" name="vr1" value=<?php echo $resp2['vr1']; ?> required></div>

                                    <div class="row"><label for="ch1">Chegada</label><input type="number" min=0 max=10 class="form-control" style="width:30%" id="ch1" name="ch1" value=<?php echo $resp2['ch1']; ?> required></div>
                                </div>
                            
                                <div class="col-6">
                                    <div class="estilos">
                                        <label for="est2">Estilo 2</label><select class="form-control" style="width:87%; margin-left:2px;" id="est2" name="est2"><option id="nd2" value="--" required>--</option><option id="lv2" value="Livre" <?php if($resp2['est2'] == 'Livre') echo 'selected'; ?>>Livre</option><option id="co2" value="Costas" <?php if($resp2['est2'] == 'Costas') echo 'selected'; ?>>Costas</option><option id="bo2" value="Borboleta" <?php if($resp2['est2'] == 'Borboleta') echo 'selected'; ?>>Borboleta</option><option id="pe2" value="Peito" <?php if($resp2['est2'] == 'Peito') echo 'selected'; ?>>Peito</option></select>
                                    </div>

                                    <div class="row"><label for="cb2">Cabeça</label><input type="number" min=0 max=10 class="form-control" style="width:30%" id="cb2" name="cb2" value=<?php echo $resp2['cb2']; ?>></div>

                                    <div class="row"><label for="pr2">Perna</label><input type="number" min=0 max=10 class="form-control" style="width:30%" id="pr2" name="pr2" value=<?php echo $resp2['pr2']; ?>></div>

                                    <div class="row"><label for="br2">Braço</label><input type="number" min=0 max=10 class="form-control" style="width:30%" id="br2" name="br2" value=<?php echo $resp2['br2']; ?>></div>

                                    <div class="row"><label for="tr2">Tronco</label><input type="number" min=0 max=10 class="form-control" style="width:30%" id="tr2" name="tr2" value=<?php echo $resp2['tr2']; ?>></div>

                                    <div class="row"><label for="qd2">Quadril</label><input type="number" min=0 max=10 class="form-control" style="width:30%" id="qd2" name="qd2" value=<?php echo $resp2['qd2']; ?>></div>

                                    <div class="row"><label for="co2" style="font-size: 8px;">Coordenação</label><input type="number" min=0 max=10 class="form-control" style="width:30%" id="co2" name="co2" value=<?php echo $resp2['co2']; ?>></div>

                                    <div class="row"><label for="sa2">Saída</label><input type="number" min=0 max=10 class="form-control" style="width:30%" id="sa2" name="sa2" value=<?php echo $resp2['sa2']; ?>></div>

                                    <div class="row"><label for="vr2">Virada</label><input type="number" min=0 max=10 class="form-control" style="width:30%" id="vr2" name="vr2" value=<?php echo $resp2['vr2']; ?>></div>

                                    <div class="row"><label for="ch2">Chegada</label><input type="number" min=0 max=10 class="form-control" style="width:30%" id="ch2" name="ch2" value=<?php echo $resp2['ch2']; ?>></div>
                                </div>
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
    </script>
    <script>
        $('input:radio[name="rd_ac"]').change(function(){
            if($(this).is(':checked') && $(this).val() == 'vis'){
                window.location.href = 'visualizar.php?id_atleta='+$('#nome').val();
            }
            if($(this).is(':checked') && $(this).val() == 'edit'){
                $("#tipo").val(2);
                $("#id_atleta").val($('#nome').val());
            }
        });

        $('#nome').change(function(){
            function CriaRequest() {
                try{
                    request = new XMLHttpRequest();        
                }catch (IEAtual){
                    
                    try{
                        request = new ActiveXObject("Msxml2.XMLHTTP");       
                    }catch(IEAntigo){
                    
                        try{
                            request = new ActiveXObject("Microsoft.XMLHTTP");          
                        }catch(falha){
                            request = false;
                        }
                    }
                }
                
                if (!request) 
                    alert("Seu Navegador não suporta Ajax!");
                else
                    return request;
            }

            var xmlr = CriaRequest();
            var resposta = document.getElementById('request');
            xmlr.open("GET", "request.php?id="+$('#nome').val(), true);

            xmlr.onreadystatechange = function(){
                if(xmlr.readyState == 4){
                    if(xmlr.status == 200){
                        resposta.innerHTML = xmlr.responseText;
                    }
                }
            };
            xmlr.send(null);
        })
    </script>
    <script id="request"></script>
</body>

</html>