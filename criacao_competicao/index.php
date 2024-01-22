<html lang="pt-BR">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
    <link rel="stylesheet" href="../common/stylesheets/bootstrap.css">
    <link rel="stylesheet" href="../common/stylesheets/bootstrap4.css">
    <link rel="stylesheet" href="../common/stylesheets/animate.css">
    <link rel="stylesheet" href="../common/stylesheets/style.css">
    <link rel="stylesheet" href="../common/stylesheets/style1.css">
    <link rel="icon" type="image/png" href="../common/images/favicon-32x32.png" sizes="32x32" />
    <title>Wetrats - Competições</title>
</head>
<body>
    <div id="page">
      <nav class="fh5co-nav" id="menu-list" role="navigation">
          <div id="menu"></div>
      </nav>
      <div id="menus"></div>

      <div class="container-fluid" style="padding-top:60px;">
        <div class="row">
          <form method="post" action="index.php" class="col-md-12">

          <?php
      
      session_start();
    
        // Verifica se existe ID da sessão
        if(!isset($_SESSION['ID'])){

        //Destrói a sessão por segurança
        session_destroy();

        //Redireciona para o login
        header("Location: ../index.php"); exit;
        }

      //Mensagem de alerta
      if (isset($_SESSION['ALERTA'])){
        echo '<div class="alert alert-danger" role="alert">'.$_SESSION['ALERTA'].'</div>';
        unset($_SESSION['ALERTA']);
      }
      //Mensagens de sucesso
      if (isset($_SESSION['MSG'])){
        echo '<div class="alert alert-success" role="alert">'.$_SESSION['MSG'].'</div>';
        unset($_SESSION['MSG']);
      }
    ?>
            
            <h1>Nova Competição</h1>
            <p>Preencha os campos abaixo para criar uma nova competição para ser adicionada ao calendário.</p>
            <hr>
 
          <div class="container_form">
            <div class="row form-group">
                <div class="col-md-6">       
                    <label for="evento"><b>Nome do Evento:</b></label>
                    <input class="form-control" type="text" placeholder="Digite o nome do evento..." name="evento" value = "<?php if(isset($_POST['evento'])) echo $_POST['evento']; ?>" required>
                </div>
            </div>

            <div class="row form-group">
                <div class="col-md-6">        
                    <label for="data"><b>Data:</b></label>
                    <input class="form-control" type="date" name="data" value = "<?php if(isset($_POST['data'])) echo $_POST['data']; ?>" ><br>
                </div>
    
                <div class="col-md-6">   
                    <label for="local"><b>Local:</b></label>
                    <input class="form-control" type="text" placeholder="Digite o lugar onde será realizada..." name="local" value = "<?php if(isset($_POST['local'])) echo $_POST['local']; ?>" >
                </div>
            </div>

            <div class="row form-group">
                <div class="col-md-3">
                    <label for="valor"><b>Valor:</b></label>
                    <input class="form-control" type="number" placeholder="Digite o valor da inscrição..." name="valor" value = "<?php if(isset($_POST['valor'])) echo $_POST['valor']; ?>" >
                </div>
            
                <label for="tipo_inscricao"><b>Inscrição:</b></label>
                    <div class="col-md-2" style="margin-top:4em;">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input class="custom-control-input" type="radio" name="tipo_inscricao" id="n1" value="1" <?php if(isset($_POST['tipo_inscricao']) and ($_POST['tipo_inscricao']==1) ) echo "checked"; ?> > 
                            <label for="n1" class="custom-control-label" style="padding-left:10px;">Por prova</label> 
                        </div>
                    </div>
                    <div class="col-md-2" style="margin-top:4em;">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input class="custom-control-input" type="radio" name="tipo_inscricao" id="n2" value="0" <?php if(isset($_POST['tipo_inscricao']) and ($_POST['tipo_inscricao']==0) ) echo "checked"; ?>> 
                            <label for="n2" class="custom-control-label" style="padding-left:10px;">Individual</label> 
                        </div>
                    </div>
                </div>
            
            
            <div class="row form-group">
                <div class="col-md-6">
                        <label for="descricao"><b>Informações Adicionais:</b></label>
                        <textarea class="form-control" type="text" rows="5" placeholder="Digite uma descrição, programa de provas, valores..." name="descricao"><?php if(isset($_POST['descricao'])) echo $_POST['descricao']; ?></textarea>
                </div>
            </div>
        </div>

            
        <!-- formulario para inserçao das provas -->
        <div class="container_form" style="padding-top:30px; padding-bottom:30px;">
            
                <h1>Programa de Provas</h1>
                <p>Digite o número de provas do programa e clique em "Ok!" para adicionar os campos.</p>
                <hr>
                <div class="row form-group">
                    <div class="col-auto">
                        <label for="nprovas"><b>Número de Provas no Programa:</b></label>
                    </div>
                    <div class="col-3">
                        <input class="form-control" type="number" placeholder="Nº de provas..." name="nprovas" value="<?php if(isset($_POST['nprovas'])) echo $_POST['nprovas']; ?>">
                    </div>

                    <div class="col-2">
                        <button type="submit" class="btn btn-primary" name="ok" value = "ok">Ok!</button>
                    </div>
                </div>
                <?php 
                if (isset($_POST['ok'])){
                    echo '<div class="row form-group">';
                   $nprovas=$_POST['nprovas'];
                    $i = 1;
                    while ($i<= $nprovas){
                        echo 
                        '<div class="col-3">       
                            <label for=prova'.$i.'><b>Prova '.$i.':</b></label>
                            <select class="form-control" name="prova'.$i.'">
                                <option value="50_Borboleta" >50m Borboleta</option>
                                <option value="50_Costas" >50m Costas</option> 
                                <option value="50_Peito" >50m Peito</option>
                                <option value="50_Livre" >50m Livre</option>
                                <option value="100_Medley" >100m Medley</option>
                                <option value="100_Borboleta" >100m Borboleta</option>
                                <option value="100_Costas" >100m Costas</option> 
                                <option value="100_Peito" >100m Peito</option>
                                <option value="100_Livre" >100m Livre</option>
                                <option value="200_Medley" >200m Medley</option>
                                <option value="200_Borboleta" >200m Borboleta</option>
                                <option value="200_Costas" >200m Costas</option> 
                                <option value="200_Peito" >200m Peito</option>
                                <option value="200_Livre" >200m Livre</option>
                                <option value="400_Medley" >400m Medley</option>
                                <option value="400_Livre" >400m Livre</option>
                                <option value="800_Livre" >800m Livre</option>
                                <option value="Rev_4x50_Livre" >Rev 4x50 Livre</option>
                                <option value="Rev_4x50_Medley" >Rev 4x50 Medley</option>
                            </select>
                        </div>' ;
                        $i +=1 ;
                    }
                    echo '</div>';
                }
                ?>
        </div>
    
            <div class="row form-group">
                    <div class="form-group col-2 offset-8">
                        <a href="../competicoes/index.php"><button type="button" class="btn btn-primary">Cancelar</button></a>
                    </div>
                    <div class="form-group col-2">
                        <button type="submit" class="btn btn-primary" name="finalizado" value="finalizado">Criar</button>
                    </div>
                </div>
            </div>
        
    </form>
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
<?php 
if (isset($_POST['finalizado'])){
    $evento = $_POST['evento'];
    $data = $_POST['data'];
    $local = $_POST['local'];
    $valor = $_POST['valor'];
    $tipo_inscricao = $_POST['tipo_inscricao'];
    $descricao = $_POST['descricao'];
    $nprovas = $_POST['nprovas']; 
    $erro = False;
    $i = 1;
    $ordem_provas = '' ;
    $sql = 'CREATE TABLE '."`$evento`".' (atleta_id int(6) PRIMARY KEY, nome_atleta varchar(100),sexo varchar(2) ';
    while($i<= $nprovas){
        $prova_i = "prova".$i;
        $prova = str_replace(" ", "_", $_POST[$prova_i]);
        $ordem_provas .= $prova.' ' ;
        $sql .= ", ".$prova." varchar(50)" ;
        $i += 1;
    }
    $sql .= ");" ;
    echo $sql;
    require_once '../db_con.php';
    if ($nprovas>0){
        if (!mysqli_query($con,$sql)){
            $_SESSION['ALERTA'] .= "Error description: " . mysqli_error($con);
            $erro = True;
            echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
            echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './');});</script>";
            //header("Location: ./index.php"); exit;
        }
        else{
            $sql2 = "INSERT INTO competicoes (evento, data, local, valor, tipo_inscricao, nprovas, ordem_provas, ativo, descricao) VALUES ("."'$evento'".","."'$data'".", "."'$local'".", "."'$valor'".", "."'$tipo_inscricao'".", "."'$nprovas'".", "."'$ordem_provas'".", '1', "."'$descricao'".");" ;
            if (!mysqli_query($con,$sql2)){
                $_SESSION['ALERTA'] .= "Erro: ".mysqli_error($con);
                $erro = True;
                echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
                echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './');});</script>";
                //header("Location: ./index.php"); exit;
            }
            if ($erro == False){
                $_SESSION['MSG'] = "Competição: "."$evento"." criada com sucesso!";
                echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
                echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', '../competicoes/');});</script>";
                //header("Location: ../competicoes/index.php"); exit;
            }
    }
}
}

?>
