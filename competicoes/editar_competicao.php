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
          <form method="post" action="editar_competicao.php?id=<?php echo $_GET['id']; ?>" class="col-12">

          <?php
      
      session_start();
    
        // Verifica se existe ID da sessão
        if(!isset($_SESSION['ID'])){

        //Destrói a sessão por segurança
        session_destroy();

        //Redireciona para o login
        header("Location: ../index.php"); exit;
        }

        // Conexão com o servidor MySQL
        $con = mysqli_connect("auth-db213.hstgr.io", "u418844475_wtr", "wetrats2019", "u418844475_wtr");

        //busca das informacoes referentes a competicao
        $sql = "SELECT * FROM `competicoes` WHERE id=".$_GET['id'].";" ;
        $resultado = mysqli_query($con,$sql);
        while($row = mysqli_fetch_assoc($resultado)){
                $evento = $row['evento'];
                $_SESSION['evento'] = $evento;
                $data = $row['data'];
                $local = $row['local'];
                $valor = $row['valor'];
                $tipo_inscricao = $row['tipo_inscricao'];
                $descricao = $row['descricao'];
                $nprovas = $row['nprovas'];
                //tratamento do texto que compõe a ordem das provas para obter estas em forma de lista
                $ordem_provas = $row['ordem_provas'];
                //$ordem_provas conterá os nomes das colunas da tabela 
                $ordem_provas = substr($ordem_provas, 0 ,-1);
                $ordem_provas=explode(" " , $ordem_provas);
                //$provas será uma lista que conterá os nomes das provas sem o underline
                $provas = array();
                $i=0;
                foreach($ordem_provas as $prova){
                    $provas[$i] =str_replace("_"," ",$prova); 
                    $i += 1;
                    }
            }
        echo '<div class="row">';
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
      echo '</div>';
    ?>
            
            <h1>Edição de Competição</h1>
            <p>Preencha os campos abaixo para editar a competição:<?php echo '<b>'.$evento.'</b>'; ?></p>
            <hr>
 
        <div class="container_form">
            <div class="row form-group">
                <div class="col-6">       
                    <label for="evento"><b>Nome do Evento:</b></label>
                    <input class="form-control" type="text" placeholder="Digite o nome do evento..." name="evento" value = "<?php if(isset($evento)) echo $evento; ?>" required>
                </div>
            </div>
                
            <div class="row form-group">
                <div class="col-6">        
                    <label for="data"><b>Data:</b></label>
                    <input class="form-control" type="date" name="data" value = "<?php if(isset($data)) echo $data; ?>" ><br>
                </div>
        
                <div class="col-6">   
                    <label for="local"><b>Local:</b></label>
                    <input class="form-control" type="text" placeholder="Digite o lugar onde será realizada..." name="local" value = "<?php if(isset($local)) echo $local; ?>" >
                </div>
            </div>

            <div class="row form-group">
                <div class="col-3">
                    <label for="valor"><b>Valor:</b></label>
                    <input class="form-control" type="number" placeholder="Digite o valor da inscrição..." name="valor" value = "<?php if(isset($valor)) echo $valor; ?>" >
                </div>
            
                <label for="tipo_inscricao"><b>Inscrição:</b></label>
                    <div class="col-2" style="margin-top:4em;">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input class="custom-control-input" type="radio" name="tipo_inscricao" id="n1" value="1" <?php if(isset($tipo_inscricao) and ($tipo_inscricao==1) ) echo "checked"; ?> > 
                            <label for="n1" class="custom-control-label" style="padding-left:10px;">Por prova</label> 
                        </div>
                    </div>
                    <div class="col-2" style="margin-top:4em;">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input class="custom-control-input" type="radio" name="tipo_inscricao" id="n2" value="0" <?php if(isset($tipo_inscricao) and ($tipo_inscricao==0) ) echo "checked"; ?>> 
                            <label for="n2" class="custom-control-label" style="padding-left:10px;">Individual</label> 
                        </div>
                    </div>
                </div>
            
            <div class="row form-group">
                <div class="col-6">
                        <label for="descricao"><b>Informações Adicionais:</b></label>
                        <textarea class="form-control" type="text" rows="5" placeholder="Digite uma descrição, programa de provas, valores..." name="descricao"><?php if(isset($descricao)) echo $descricao; ?></textarea>
                </div>
            </div>
        </div>

            
        <!-- formulario para inserçao das provas -->
        <div class="container_form">    
            <div class="row form-group">
                <h1>Programa de Provas</h1>
            </div>
            <div class="row form-group">
                <p>Digite o número de provas do programa e clique em "Ok!" para adicionar os campos.</p>
                <hr>
            </div>
                
                <div class="row form-group">
                    <div class="col-auto">
                        <label for="nprovas"><b>Número de Provas no Programa:</b></label>
                    </div>
                    <div class="col-1">    
                        <input class="form-control" type="number" placeholder="Nº de provas..." name="nprovas" value="<?php if(isset($_POST['ok'])) $nprovas=$_POST['nprovas']; if(isset($nprovas)) echo $nprovas; ?>"required>
                    </div>
                    <div class="col-2">
                        <button type="submit" class="btn btn-primary" name="ok" value = "ok">Ok!</button>
                    </div>
                </div>
                <?php 
                   echo '<div class="row form-group">';
                
                    $i = 0;
                    $b=1;
                    while ($i< $nprovas){
                        echo 
                    '
                        <div class="col-3">       
                            <label for=prova'.$i.'><b>Prova '.$b.':</b></label>
                            <select class="form-control" name="prova'.$i.'">
                                <option value="50_Borboleta" ';if($ordem_provas[$i]=="50_Borboleta") echo 'selected'; echo '>50m Borboleta</option>
                                <option value="50_Costas" ';if($ordem_provas[$i]=="50_Costas") echo 'selected'; echo ' >50m Costas</option> 
                                <option value="50_Peito" ';if($ordem_provas[$i]=="50_Peito") echo 'selected'; echo ' >50m Peito</option>
                                <option value="50_Livre" ';if($ordem_provas[$i]=="50_Livre") echo 'selected'; echo ' >50m Livre</option>
                                <option value="100_Medley" ';if($ordem_provas[$i]=="100_Medley") echo 'selected'; echo ' >100m Medley</option>
                                <option value="100_Borboleta" ';if($ordem_provas[$i]=="100_Borboleta") echo 'selected'; echo '>100m Borboleta</option>
                                <option value="100_Costas" ';if($ordem_provas[$i]=="100_Costas") echo 'selected'; echo ' >100m Costas</option> 
                                <option value="100_Peito" ';if($ordem_provas[$i]=="100_Peito") echo 'selected'; echo ' >100m Peito</option>
                                <option value="100_Livre" ';if($ordem_provas[$i]=="100_Livre") echo 'selected'; echo ' >100m Livre</option>
                                <option value="200_Medley" ';if($ordem_provas[$i]=="200_Medley") echo 'selected'; echo ' >200m Medley</option>
                                <option value="200_Borboleta" ';if($ordem_provas[$i]=="200_Borboleta") echo 'selected'; echo '>200m Borboleta</option>
                                <option value="200_Costas" ';if($ordem_provas[$i]=="200_Costas") echo 'selected'; echo ' >200m Costas</option> 
                                <option value="200_Peito" ';if($ordem_provas[$i]=="200_Peito") echo 'selected'; echo ' >200m Peito</option>
                                <option value="200_Livre" ';if($ordem_provas[$i]=="200_Livre") echo 'selected'; echo ' >200m Livre</option>
                                <option value="400_Medley" ';if($ordem_provas[$i]=="400_Medley") echo 'selected'; echo ' >400m Medley</option>
                                <option value="400_Livre" ';if($ordem_provas[$i]=="400_Livre") echo 'selected'; echo ' >400m Livre</option>
                                <option value="800_Livre" ';if($ordem_provas[$i]=="800_Livre") echo 'selected'; echo ' >800m Livre</option>
                                <option value="Rev_4x50_Livre" ';if($ordem_provas[$i]=="Rev_4x50_Livre") echo 'selected'; echo '  >Rev 4x50 Livre</option>
                                <option value="Rev_4x50_Medley"';if($ordem_provas[$i]=="Rev_4x50_Medley") echo 'selected'; echo '  >Rev 4x50 Medley</option>
                            </select>
                        </div>' ;
                        $i +=1 ;
                        $b+=1;
                    }
                    
                ?>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="form-group col-2 offset-3" style="padding-top:30px;">
                        <a href="../competicoes/index.php"><button type="button" class="btn btn-primary">Cancelar</button></a>
                    </div>
                    <div class="form-group col-2 offset-1" style="padding-top:30px;">
                        <button type="submit" class="btn btn-primary" name="finalizado" value="finalizado">Editar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
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
<?php 
if (isset($_POST['finalizado'])){

    $mensagem="Competição:<b>".$evento."</b> ";
    $m= False;
    
    $con = mysqli_connect("auth-db213.hstgr.io", "u418844475_wtr", "wetrats2019", "u418844475_wtr");
    //mudança de nome da competicao
    if ($_SESSION['evento'] != $_POST['evento']){
        $sql = "ALTER TABLE "."`".$_SESSION['evento']."`"." RENAME TO "."`".$_POST['evento']."` ;";
        if (!mysqli_query($con,$sql)){
                $_SESSION['ALERTA'] .= "Error description: " . mysqli_error($con).$sql;
                $erro = True;
                echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
                echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './editar_competicao.php?id=".$_GET['id']."');});</script>";
                //header("Location: ./editar_competicao.php?id=".$_GET['id']); exit;
        }
        $mensagem .= "renomeada para :<b>".$_POST['evento']."</b>;" ;
        $m = True;
    }
    
    $evento = $_POST['evento'];
    $data = $_POST['data'];
    $local = $_POST['local'];
    $valor = $_POST['valor'];
    $tipo_inscricao = $_POST['tipo_inscricao'];
    $descricao = $_POST['descricao'];
    $nprovas = $_POST['nprovas']; 
    $erro = False;
    
    //verificacao da necessidade de incluir colunas na tabela de provas
    $i = 0;
    $nova_lista_provas= array();
    $nova_ordem_provas = '' ;
    $altera_coluna = False;
    $sql_colunas = "ALTER TABLE "."`".$evento."`"; 
    while($i< $nprovas){
        $prova_i = "prova".$i;
        $prova = str_replace(" ", "_", $_POST[$prova_i]);
        if (!in_array($prova,$ordem_provas)){
            $sql_colunas .= " ADD COLUMN ".$prova." varchar(50) ," ;
            $altera_colunas = True;
        }
        $nova_ordem_provas .= $prova.' ' ;
        $nova_lista_provas[] = $prova; 
        $i += 1;
    }

    foreach($ordem_provas as $prova){
        if(!in_array($prova,$nova_lista_provas)){
            $sql_colunas .= " DROP `".$prova."` ,";
            $altera_colunas = True;
        }
    }
    
    if ($altera_colunas == True){
        $sql_colunas = substr($sql_colunas,0,-1);
        $sql_colunas .= ";" ;
        if (!mysqli_query($con,$sql_colunas)){
            $_SESSION['ALERTA'] .= "Error description: " . mysqli_error($con).$sql_colunas;
            $erro = True;
            echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
            echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './editar_competicao.php?id=".$_GET['id']."');});</script>";
            //header("Location: ./editar_competicao.php?id=".$_GET['id']); exit;
        }
        $mensagem .=" teve seu programa de provas alterado para:<br>";
        foreach($nova_lista_provas as $prova){
            $mensagem .= str_replace("_"," ",$prova)."<br>";
            $m = True;
        }
    }

    $sql2 = "UPDATE competicoes 
            SET evento="."'$evento'".", data="."'$data'".", local="."'$local'".", valor="."'$valor'".", tipo_inscricao="."'$tipo_inscricao'".", nprovas="."'$nprovas'".", ordem_provas="."'$nova_ordem_provas'"." , descricao='".$descricao."'
            WHERE id=".$_GET['id'].";" ;
    if (!mysqli_query($con,$sql2)){
        $_SESSION['ALERTA'] .= "Erro: " . mysqli_error($con);
        $erro = True;
        echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
        echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './editar_competicao.php?id=".$_GET['id']."');});</script>";
        //header("Location: ./editar_competicao.php?id=".$_GET['id']); exit;
    }
    if ($erro == False){
        if (!$m) $mensagem.= "atualizada";
        $_SESSION['MSG'] = $mensagem."com sucesso!";
        echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
        echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', '../competicoes/');});</script>";
        //header("Location: ../competicoes/index.php"); exit;
    }

}

?>