<html lang="pt-BR">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
    <link rel="stylesheet" href="../common/stylesheets/bootstrap.css">
    <link rel="stylesheet" href="../common/stylesheets/bootstrap4.css">
    <link rel="stylesheet" href="../common/stylesheets/animate.css">
    <link rel="stylesheet" href="../common/stylesheets/style.css">
    <link rel="stylesheet" href="../common/stylesheets/style1.css">
</head>

<?php
 //Inicia uma sessão
  session_start();
  $id_usuario = $_SESSION['ID'];
  $nivel_usuario = $_SESSION['NIVEL'];
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
                <h1>Gerenciar Performances</h1>
            </div>
            <div class="col-md-3 col-md-offset-3  col-sm-4">
                <a href="./adicionar_performance.php"><button class="btn-primary">Adicionar performance</button></a>
            </div>
        </div>
    </div>

    <div class="col-12" style="margin-left:30px;">
            
    <form method="post" action="gerenciar_performances.php" class="col-9">

                <div class="container_form_performance row form-group">
                    <?php if($nivel_usuario=="2") {
                        echo '
                    <div class="col-2">
                        <label for="nome"><b>Nome:</b></label>
                        <input class="form-control" name="nome" value="'; if(isset($_POST['nome'])) echo $_POST['nome']; echo '">
                    </div>';
                    }
                    ?>

                    <div class="col-3">
                        <label for="estilo"><b>Estilo:</b>
                        <select name="estilo" class="form-control">
                            <option value=" "> </option>
                            <option value="Borboleta"<?php if($_POST['estilo']=="Borboleta") echo "selected";?>>Borboleta</option>
                            <option value="Costas"<?php if($_POST['estilo']=="Costas") echo "selected";?>>Costas</option>
                            <option value="Peito"<?php if($_POST['estilo']=="Peito") echo "selected";?>>Peito</option>
                            <option value="Livre"<?php if($_POST['estilo']=="Livre") echo "selected";?>>Livre</option>
                            <option value="Medley"<?php if($_POST['estilo']=="Medley") echo "selected";?>>Medley</option>
                        </select>
                    </div>

                    <div class="col-2">
                        <label for="metragem"><b>Metragem:</b></label>
                        <input class="form-control" name="metragem" value="<?php if(isset($_POST['metragem'])) echo $_POST['metragem']; ?>">
                    </div>

                    <div class="col-3">
                        <label for="data"><b>Data:</b></label>
                        <input class="form-control" type="date" name="data" value="<?php if(isset($_POST['data'])) echo $_POST['data']; ?>">
                    </div>

                    <div style="padding-top:40px;" class="col-2">   
                        <button type="submit" class="btn btn-primary" name="filtrar" value="1">Filtrar</button>
                    </div>

                    



                </div>
                </form>


                <!--------Tabs de navegação--------->
                <ul class="nav nav-tabs" id="myTab">
                    <li class="nav-item"> 
                        <a class="nav-link" id="Tiro" href=# onclick="show(this.id + '_tab' )">Tiros</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="BT" href=# onclick="show(this.id + '_tab' )" >BT's</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="Melhormedia" href=# onclick="show(this.id + '_tab' )" >Melhor média</a>
                    </li>
                </ul>

                <!---Tiros---->
                <div class="tabela" style="margin-top:10px;" id="Tiro_tab" role="tabpanel" >
                    <table class="tabela_performances">
                        <thead>
                        <tr>
                            <?php if($nivel_usuario == "2") echo '<th>Atleta</th>';?>
                            <th>Data</th>
                            <th>Prova</th>
                            <th>Tempo</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        
                        <tbody>
                
                        <?php 
                        // Conexão com o servidor MySQL
                        $con = mysqli_connect("auth-db213.hstgr.io", "u418844475_wtr", "wetrats2019", "u418844475_wtr");

                        if($nivel_usuario !="2"){
                        //busca das informacoes referentes a tabela de tiros
                        $sql = "SELECT  resultados_treinos.id AS 'id', treinos.data AS 'data' , tempo, estilo, metragem, 'treinos' AS 'link' FROM `resultados_treinos`
                        INNER JOIN `treinos` ON resultados_treinos.id_treino= treinos.id  
                        WHERE resultados_treinos.tipo='Tiro' AND id_atleta=".$id_usuario;
                        
                        //aplicacao dos filtros
                        if(isset($_POST['filtrar'])){
        
                            if(strlen($_POST['nome'])>1) $sql.=" AND usuarios.nome LIKE '%".$_POST['nome']."%'" ;
                            
                            if(strlen($_POST['estilo'])>1) $sql.=" AND estilo="."'".$_POST['estilo']."'";
                            
                            if(strlen($_POST['metragem'])>1) $sql.=" AND metragem="."'".$_POST['metragem']."'";
                            
                            if(strlen($_POST['data'])>1) $sql.=" AND treinos.data="."'".$_POST['data']."'";

                        }

                        $sql.= "
                        UNION ALL
                        SELECT id AS 'id', data , tempo, estilo , metragem, 'pessoais' AS 'link' FROM `resultados_pessoais`
                        WHERE id_atleta=".$id_usuario;

                        //aplicacao dos filtros
                        if(isset($_POST['filtrar'])){
                            
                            if(strlen($_POST['estilo'])>1) $sql.=" AND estilo="."'".$_POST['estilo']."'";
                            
                            if(strlen($_POST['metragem'])>1) $sql.=" AND metragem="."'".$_POST['metragem']."'";
                            
                            if(strlen($_POST['data'])>1) $sql.=" AND treinos.data="."'".$_POST['data']."'";

                        }
                        $sql.= " ORDER BY `data` DESC;";
                        }
                    
                        else {
                        //busca das informacoes referentes a tabela de tiros
                        $sql = "SELECT  usuarios.nome AS 'nome' , resultados_treinos.id AS 'id', treinos.data AS 'data' , tempo, estilo, metragem, 'treinos' AS 'link' FROM `resultados_treinos`
                        INNER JOIN `treinos` ON resultados_treinos.id_treino = treinos.id
                        INNER JOIN `usuarios` ON resultados_treinos.id_atleta = usuarios.id  
                        WHERE resultados_treinos.tipo='Tiro'";

                        //aplicacao dos filtros
                        if(isset($_POST['filtrar'])){
        
                            if(strlen($_POST['nome'])>1) $sql.=" AND usuarios.nome LIKE '%".$_POST['nome']."%'" ;
                            
                            if(strlen($_POST['estilo'])>1) $sql.=" AND estilo="."'".$_POST['estilo']."'";
                            
                            if(strlen($_POST['metragem'])>1) $sql.=" AND metragem="."'".$_POST['metragem']."'";
                            
                            if(strlen($_POST['data'])>1) $sql.=" AND treinos.data="."'".$_POST['data']."'";

                        }
                        $sql .=
                        "UNION ALL
                        SELECT usuarios.nome AS 'nome' , resultados_pessoais.id AS 'id', data , tempo, estilo , metragem, 'pessoais' AS 'link' FROM `resultados_pessoais`
                        INNER JOIN `usuarios` ON resultados_pessoais.id_atleta = usuarios.id
                        ";

                        //aplicacao dos filtros
                        if(isset($_POST['filtrar'])){
                            $where = "WHERE ";
                            if(strlen($_POST['nome'])>1) $where.=" usuarios.nome LIKE '%".$_POST['nome']."%'" ;
                            
                            if(strlen($_POST['estilo'])>1){
                                if(strlen($where)>6) $where.=" AND estilo="."'".$_POST['estilo']."'";
                                else $where.="estilo="."'".$_POST['estilo']."'";
                            }
                            
                            if(strlen($_POST['metragem'])>1){
                                if(strlen($where)>6) $where.=" AND metragem="."'".$_POST['metragem']."'";
                                else $where.="metragem="."'".$_POST['metragem']."'";
                            }
                            if(strlen($_POST['data'])>1){
                                if(strlen($where)>6) $where.=" AND data="."'".$_POST['data']."'";
                                else $where.="data="."'".$_POST['data']."'";
                            }
                        if(strlen($where)>6) $sql.= $where;

                        }
                        $sql.= " ORDER BY `data` DESC;";
                        }
                        $resultado= mysqli_query($con,$sql);
                        $n=1;
                        while($res = mysqli_fetch_assoc($resultado)){
                            $id = $res['id'];
                            $nome = $res['nome'];
                            $date = date_create($res['data']);
                            $data = date_format($date , "d/m/Y");
                            $prova = $res['metragem']." ".$res['estilo'];
                            $tempo = $res['tempo'];
                            $link="";
                            if ($res['link']=="treinos"){
                                $link="_treino";
                            }

                            $n+=1;

                            echo '<tr>';
                            if ($nivel_usuario == "2") {echo '<td>'.$nome.'</td>';}
                            echo'
                            <td>'.$data.'</td>
                            <td>'.$prova.'</td>
                            <td>'.$tempo.'</td>
                            <td class="text-center"><a style="color: #ffffff;" href="./editar_performance'.$link.'.php?id='.$id.'"> Editar </a> 
                            
                            <div><button id="'.$n.'" class="treino btn-danger" onclick="exibe_modal(this.id)"
                            value="<div><h1>Deletar performance do dia:'.$data.' ? <h1></div>
                            <div><a class=btn-danger href=./deletar_performance.php?id='.$id.'&data='.$data.'&link='.$res['link'].'>Deletar</a></div>" 
                            
                            href="#" type="button">Deletar</button></div></td>
                            </tr>';                       
                        }
                        ?>
                        </tbody>
                    </table>
                </div>

                <!---BT---->
                <div class="tabela" style="display:none; margin-top:10px;" id="BT_tab" role="tabpanel" >
                    <table class="tabela_performances">
                        <thead>
                        <tr>
                            <?php if($nivel_usuario == "2") echo '<th>Atleta</th>';?>
                            <th>Data</th>
                            <th>Prova</th>
                            <th>Braçadas</th>
                            <th>Tempo</th>
                            <th>Freq. Cardíaca</th>
                            <th>Intensidade</th>
                            <th>Ações</th>

                        </tr>
                        </thead>
                        
                        <tbody>
                
                        <?php 
                        // Conexão com o servidor MySQL
                        $con = mysqli_connect("auth-db213.hstgr.io", "u418844475_wtr", "wetrats2019", "u418844475_wtr");

                        if($nivel_usuario !="2"){
                            //busca das informacoes referentes a tabela de BTs
                            $sql = "SELECT  resultados_treinos.id, treinos.data AS 'data' , tempo, estilo, metragem , bracadas, frequencia, intensidade FROM `resultados_treinos`
                            INNER JOIN `treinos` ON resultados_treinos.id_treino= treinos.id  
                            WHERE resultados_treinos.tipo='BT' AND id_atleta=".$id_usuario ;

                            //aplicacao dos filtros
                            if(isset($_POST['filtrar'])){
        
                                
                                if(strlen($_POST['estilo'])>1) $sql.=" AND estilo="."'".$_POST['estilo']."'";
                                
                                if(strlen($_POST['metragem'])>1) $sql.=" AND metragem="."'".$_POST['metragem']."'";
                                
                                if(strlen($_POST['data'])>1) $sql.=" AND treinos.data="."'".$_POST['data']."'";

                            }
                            $sql .= " ORDER BY `data` DESC;";
                            }
                        
                        else {
                            //busca das informacoes referentes a tabela de BTS
                            $sql = "SELECT  usuarios.nome AS 'nome' , resultados_treinos.id, treinos.data AS 'data' , tempo, estilo, metragem , bracadas, frequencia, intensidade FROM `resultados_treinos`
                            INNER JOIN `treinos` ON resultados_treinos.id_treino = treinos.id
                            INNER JOIN `usuarios` ON resultados_treinos.id_atleta = usuarios.id  
                            WHERE resultados_treinos.tipo='BT'";

                            //aplicacao dos filtros
                            if(isset($_POST['filtrar'])){
        
                                if(strlen($_POST['nome'])>1) $sql.=" AND usuarios.nome LIKE '%".$_POST['nome']."%'" ;
                                
                                if(strlen($_POST['estilo'])>1) $sql.=" AND estilo="."'".$_POST['estilo']."'";
                                
                                if(strlen($_POST['metragem'])>1) $sql.=" AND metragem="."'".$_POST['metragem']."'";
                                
                                if(strlen($_POST['data'])>1) $sql.=" AND treinos.data="."'".$_POST['data']."'";

                            }
                            $sql .= " ORDER BY `data` DESC;";
                            }

                        $resultado= mysqli_query($con,$sql);
                        $b=10000;
                        while($res = mysqli_fetch_assoc($resultado)){
                            $id = $res['id'];
                            $nome = $res['nome'];
                            $date = date_create($res['data']);
                            $data = date_format($date , "d/m/Y");
                            $prova = $res['metragem']." ".$res['estilo'];
                            $tempo = $res['tempo'];
                            $bracadas = $res['bracadas'];
                            $frequencia = $res['frequencia'];
                            $intensidade = $res['intensidade'];

                            echo '<tr>';
                            if ($nivel_usuario == "2") {echo '<td>'.$nome.'</td>';}
                            echo'
                            <td>'.$data.'</td>
                            <td>'.$prova.'</td>
                            <td>'.$bracadas.'</td>
                            <td>'.$tempo.'</td>
                            <td>'.$frequencia.'</td>
                            <td>'.$intensidade.'</td>
                            <td class="text-center"><a style="color: #ffffff;" href="./editar_performance_treino.php?id='.$id.'"> Editar </a> 
                            
                            <div><button id="'.$b.'" class="treino btn-danger" onclick="exibe_modal(this.id)"
                            value="<div><h1>Deletar performance do dia:'.$data.' ? <h1></div>
                            <div><a  class=btn-danger href=./deletar_performance.php?id='.$id.'&data='.$data.'&link=treinos>Deletar</a></div>" 
                            
                            href="#" type="button">Deletar</button></div></td>
                            </tr>
                            '; 
                            $b += 1;                      
                        }
                        ?>
                        </tbody>
                    </table>
                </div>

                <!---Melhor media---->
                <div class="tabela" style="display:none;margin-top:10px;" id="Melhormedia_tab" role="tabpanel" >
                    <table class="tabela_performances">
                        <thead>
                        <tr>
                            <?php if($nivel_usuario == "2") echo '<th>Atleta</th>';?>
                            <th>Data</th>
                            <th>Prova</th>
                            <th>Tempo</th>
                            <th>Intensidade</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        
                        <tbody>
                
                        <?php 
                        // Conexão com o servidor MySQL
                        $con = mysqli_connect("auth-db213.hstgr.io", "u418844475_wtr", "wetrats2019", "u418844475_wtr");

                        if($nivel_usuario !="2"){
                        //busca das informacoes referentes a tabela de Melhor media
                        $sql = "SELECT  resultados_treinos.id AS 'id', treinos.data AS 'data' , tempo, estilo, metragem, intensidade, 'treinos' AS 'link' FROM `resultados_treinos`
                        INNER JOIN `treinos` ON resultados_treinos.id_treino= treinos.id  
                        WHERE resultados_treinos.tipo='Melhor media' AND id_atleta=".$id_usuario;
                        
                        //aplicacao dos filtros
                        if(isset($_POST['filtrar'])){
                            
                            if(strlen($_POST['estilo'])>1) $sql.=" AND estilo="."'".$_POST['estilo']."'";
                            
                            if(strlen($_POST['metragem'])>1) $sql.=" AND metragem="."'".$_POST['metragem']."'";
                            
                            if(strlen($_POST['data'])>1) $sql.=" AND treinos.data="."'".$_POST['data']."'";

                        }
                    
                        $sql.= " ORDER BY `data` DESC;";
                        }
                    
                        else {
                        //busca das informacoes referentes a tabela de Melhor media
                        $sql = "SELECT  usuarios.nome AS 'nome' , resultados_treinos.id AS 'id', treinos.data AS 'data' , tempo, estilo, metragem, intensidade, 'treinos' AS 'link' FROM `resultados_treinos`
                        INNER JOIN `treinos` ON resultados_treinos.id_treino = treinos.id
                        INNER JOIN `usuarios` ON resultados_treinos.id_atleta = usuarios.id  
                        WHERE resultados_treinos.tipo='Melhor media'";

                        //aplicacao dos filtros
                        if(isset($_POST['filtrar'])){
        
                            if(strlen($_POST['nome'])>1) $sql.=" AND usuarios.nome LIKE '%".$_POST['nome']."%'" ;
                            
                            if(strlen($_POST['estilo'])>1) $sql.=" AND estilo="."'".$_POST['estilo']."'";
                            
                            if(strlen($_POST['metragem'])>1) $sql.=" AND metragem="."'".$_POST['metragem']."'";
                            
                            if(strlen($_POST['data'])>1) $sql.=" AND treinos.data="."'".$_POST['data']."'";

                        }
                        
                        $sql.= " ORDER BY `data` DESC;";
                        }
                        $resultado= mysqli_query($con,$sql);
                        $n=1;
                        while($res = mysqli_fetch_assoc($resultado)){
                            $id = $res['id'];
                            $nome = $res['nome'];
                            $date = date_create($res['data']);
                            $data = date_format($date , "d/m/Y");
                            $prova = $res['metragem']." ".$res['estilo'];
                            $tempo = $res['tempo'];
                            $intensidade = $res['intensidade'];
                            $link="";
                            if ($res['link']=="treinos"){
                                $link="_treino";
                            }

                            $n+=1;

                            echo '<tr>';
                            if ($nivel_usuario == "2") {echo '<td>'.$nome.'</td>';}
                            echo'
                            <td>'.$data.'</td>
                            <td>'.$prova.'</td>
                            <td>'.$tempo.'</td>
                            <td>'.$intensidade.'</td>
                            <td class="text-center"><a style="color: #ffffff;" href="./editar_performance'.$link.'.php?id='.$id.'"> Editar </a> 
                            
                            <div><button id="'.$n.'" class="treino btn-danger" onclick="exibe_modal(this.id)"
                            value="<div><h1>Deletar performance do dia:'.$data.' ? <h1></div>
                            <div><a class=btn-danger href=./deletar_performance.php?id='.$id.'&data='.$data.'&link='.$res['link'].'>Deletar</a></div>" 
                            
                            href="#" type="button">Deletar</button></div></td>
                            </tr>';                       
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

