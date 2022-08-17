<html lang="pt-BR">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
    <link rel="stylesheet" href="../common/stylesheets/bootstrap.css">
    <link rel="stylesheet" href="../common/stylesheets/bootstrap4.css">
    <link rel="stylesheet" href="../common/stylesheets/animate.css">
    <link rel="stylesheet" href="../common/stylesheets/style.css">
    <link rel="stylesheet" href="../common/stylesheets/style1.css">
    <link rel="icon" type="image/png" href="../common/images/favicon-32x32.png" sizes="32x32" />
    <title>Wetrats - Ranking</title>
</head>

<?php
 //Inicia uma sessão
  session_start();
  // Verifica se existe ID da sessão
  if(!isset($_SESSION['ID'])){
    //Destrói a sessão por segurança
    session_destroy();
    //Redireciona para o login
    header("Location: ../index.php"); exit;
    }
  $id_usuario = $_SESSION['ID'];
  $nivel_usuario = $_SESSION['NIVEL'];
  if ($nivel_usuario != '3'){
      session_destroy();
      session_start();
      $_SESSION['ALERTA'] = "Área restrita! Acesso negado. ";
      header("Location: ../index.php"); exit;
  }
?>  
<body>
<!-----Modal------>
<div class="bg-modal">
	    <div class="modal-contents">
            <div class="close" >
                <a href="#">+</a>
            </div>
            <div class="col">
                <div id ="divDescricao"></div>    
            </div>
        </div>
    </div>
<div id="page">
<nav class="fh5co-nav" id="menu-list" role="navigation">
    <div id="menu"></div>
</nav>
<div id="menus"></div>
  <div class="container-fluid" style="padding-top:60px;">
  
    <div class="row">
        <?php
            session_start();
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
    </div>         

    <!----Titulo--->
    <div class="row">
            <div class="section_title light col-6">
                <h1>Gerenciamento Ranking</h1>
            </div>
            <div class="col-md-3 col-md-offset-3  col-sm-4">
                <a href="../adicionar_resultado_oficial/index.php"><button class="btn-primary">Adicionar Resultado Oficial</button></a>
            </div>
        </div>
    </div>

    <div class="col-12" style="margin-left:30px;">

    <form method="post" action="gerenciar_ranking.php" class="col-10">

            <div class="container_form_performance row form-group">
            
            <div class="col-2">
            <b>Sexo:</b><br>
                <input type="radio" id="sexo_1" name="sexo" value="M" <?php if($_POST['sexo']=="M") echo "checked" ?>><label for="sexo_1"> Masculino</label><br>
                <input type="radio" id="sexo_2" name="sexo" value="F" <?php if($_POST['sexo']=="F") echo "checked" ?>><label for="sexo_2"> Feminino</label><br>
            </div>
        

                <div class="col-2">
                    <label for="nome"><b>Nome:</b></label>
                    <input class="form-control" name="nome" value="<?php if(isset($_POST['nome'])) echo $_POST['nome']; ?>">
                </div>

                <div class="col-3">
                    <label for="prova"><b>Prova:</b>
                    <select name="prova" class="form-control">
                        <option value=" "> </option>
                        <option value="50 Borboleta"<?php if($_POST['prova']=="50 Borboleta") echo "selected";?>>50 Borboleta</option>
                        <option value="50 Costas"<?php if($_POST['prova']=="50 Costas") echo "selected";?>>50 Costas</option>
                        <option value="50 Peito"<?php if($_POST['prova']=="50 Peito") echo "selected";?>>50 Peito</option>
                        <option value="50 Livre"<?php if($_POST['prova']=="50 Livre") echo "selected";?>>50 Livre</option>
                        <option value="100 Medley"<?php if($_POST['prova']=="100 Medley") echo "selected";?>>100 Medley</option>
                    </select>
                </div>

                <div class="col-3">
                    <label for="competicao"><b>Competição:</b></label>
                    <input class="form-control" name="competicao" value="<?php if(isset($_POST['competicao'])) echo $_POST['competicao']; ?>">
                </div>

                <div style="padding-top:40px;" class="col-2">   
                    <button type="submit" class="btn btn-primary" name="filtrar" value="1">Filtrar</button>
                </div>

        </div>
  </form>

                <div class="tabela">
                    <table class="tabela_performances">
                        <thead>
                        <tr>
                            <th>Atleta</th>
                            <th>Prova</th>
                            <th>Competição</th>
                            <th>Data</th>
                            <th>Tempo</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        
                        <tbody>
                
                        <?php 
                        // Conexão com o servidor MySQL
                        $con = mysqli_connect("auth-db213.hstgr.io", "u418844475_wtr", "wetrats2019", "u418844475_wtr");

                        //busca das informacoes referentes a tabela de tiros
                        $sql = "SELECT  id,nome_atleta, sexo, prova, competicao, data, tempo FROM `ranking` ";

                        //aplicacao dos filtros
                        if(isset($_POST['filtrar'])){
                            $where = "WHERE sexo='".$_POST['sexo']."'";
                            if(strlen($_POST['nome'])>1) $where.="AND nome_atleta LIKE '%".$_POST['nome']."%'";
                            if(strlen($_POST['prova'])>1){
                                if(strlen($where)>6) $where.=" AND prova= "."'".$_POST['prova']."'";
                                else $where.="prova= "."'".$_POST['prova']."'";
                            }
                            if(strlen($_POST['competicao'])>1){
                                if(strlen($where)>6) $where.=" AND competicao LIKE '%".$_POST['competicao']."%'";
                                else $where.="competicao LIKE '%".$_POST['competicao']."%'";
                            }
                        if(strlen($where)>6) $sql.= $where;
                        }

                        $resultado= mysqli_query($con,$sql);
                        $n=1;
                        while($res = mysqli_fetch_assoc($resultado)){
                            $id = $res['id'];
                            $nome_atleta = $res['nome_atleta'];
                            $nome = str_replace(" ","_",$nome_atleta);
                            $nome = str_replace('"' , '-' , $nome); //procedimento pra permitir a inclusao de aspas duplas
                            $nome = str_replace("'" , "-" , $nome); // e simples no texto
                            $date = $res['data'];
                            $data=date_format(date_create($date),"d/m/Y");
                            $prova = $res['prova'];
                            $competicao = $res['competicao'];
                            $tempo = $res['tempo'];
                            $tmp = str_replace('"' , '.' , $tempo); //procedimento pra permitir a inclusao de aspas duplas
                            $tmp = str_replace("'" , ".." , $tmp); // e simples no tempo

                            echo '<tr>';
                            echo'
                            <td>'.$nome_atleta.'</td>
                            <td>'.$prova.'</td>
                            <td>'.$competicao.'</td>
                            <td>'.$data.'</td>
                            <td>'.$tempo.'</td>
                            <td class="text-center"><a style="color: #ffffff;" href="./editar_performance.php?id='.$id.'"> Editar </a> 
                            
                            <div><button id="'.$n.'" class="treino btn-danger" onclick="exibe_modal(this.id)"
                            value="<div><h1>Deletar performance?</h1> Atleta:'.$nome.'<br> Prova:'.$prova.'<br>Tempo:'.$tmp.'<br>Evento:'.$competicao.' '.$data.'</div>
                            <div><a class=btn-danger href=./deletar_performance.php?id='.$id.'&atleta='.$nome.'>Deletar</a></div>" 
                            
                            href="#" type="button">Deletar</button></div></td>
                            </tr>';   
                            $n+=1;                    
                        }
                        
                        ?>
                        </tbody>
                    </table>
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
<!------Modal e tabelas--------->
<script src="../common/js/performances.js"></script>
</body>
</html>

