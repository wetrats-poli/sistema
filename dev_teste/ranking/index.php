<?php
    session_start();
    
    // Verifica se existe ID da sessão
    if(!isset($_SESSION['ID'])){
    
        //Destrói a sessão por segurança
        session_destroy();

        //Redireciona para o login
        header("Location: ../index.php"); exit;
        }
    
    //Inicia uma sessão
    session_start();
    $id_usuario = $_SESSION['ID'];
    $nivel_usuario = $_SESSION['NIVEL'];
    

?>

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

<body>
<div id="page">
<nav class="fh5co-nav" id="menu-list" role="navigation">
    <div id="menu"></div>
</nav>
<div id="menus"></div>
   

<div class="container_fluid" style="padding-top:60px;">
    <div class="col-12">
    
                                    
<?php
    
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

            <div class="col-6">
                <div class="section_title_container">
                    <div class="section_title light" ><h1>TOP 10 WETRATS</h1></div>
                    <?php
            if ($nivel_usuario==3){
                echo '
                        <a href="./gerenciar_ranking.php"><button class="btn btn-primary">Gerenciar Ranking</button></a>
                    ';
            }
            ?>
                </div>
            </div>
            
                
            <div class="col-12">
                <!--------Tabs de navegação--------->
                <ul class="nav nav-tabs" id="myTab" style="justify-content: space-between;">
                    <li class="nav-item active" id=10> 
                        <a class="nav-link" id="borbo" href=# onclick="show(this.id + '_tab' )">50 Borboleta</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="costas" href=# onclick="show(this.id + '_tab' )" >50 Costas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="peito" href=# onclick="show(this.id + '_tab' )">50 Peito</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="livre" href=# onclick="show(this.id + '_tab' )">50 Livre</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="medley" href=# onclick="show(this.id + '_tab' )">100 Medley</a>
                    </li> 
                </ul>
            
                     
                    <!-----50 Borbo---->
                    <div class="tabela" style="display:block;" id="borbo_tab" role="tabpanel" aria-labelledby="borbo">
                    <?php
                         echo '<div class="prova"><h1 style="color: rgba(255,187,0);">50 Borboleta</h1></div> 
                         <div class="row form-group"> 
                            <div class="container container_ranking">
                            <h2>Feminino</h2>
                            <table class="tabela_ranking">
                            <thead>
                                <th>#</th>
                                <th>Atleta</th>
                                <th>Tempo</th>
                                <th>Competição</th>
                                <th>Ano</th>
                            </thead>
                            <tr> 
                             ';
                         // Conexão com o servidor MySQL
                        $con = mysqli_connect("srv976.hstgr.io", "u418844475_wtr", "Wetrats2019", "u418844475_wtr");

                        //busca das informacoes referentes a tabela do feminino
                        $sql = "SELECT `nome_atleta`, `competicao` , `data`, `tempo` FROM `ranking` 
                        WHERE (`prova`='50 Borboleta' AND `sexo`='F') ORDER BY `tempo` ASC LIMIT 80" ;
                       $resultado = mysqli_query($con,$sql);
                       $i=1;
                       $nomes_atletas = array();
                        
                       while(($row = mysqli_fetch_array($resultado)) && ($i <= 10)){
                           if(!in_array($row['nome_atleta'],$nomes_atletas)){
                               $temp = str_replace(".", "'", $row['tempo']);
                               $temp = str_replace("..", "\"", $temp);
                               $data = date_create($row['data']);                                     
                               echo '<tr>
                               <td>'.$i.'</td> 
                               <td>'.$row['nome_atleta'].'</td>
                               <td>'.$temp.'</td>
                               <td>'.$row['competicao'].'</td>
                               <td>'.date_format($data,"Y").'</td>
                               ';
                               $i +=1;
                               $nomes_atletas[] = $row['nome_atleta'];
                          }
                          
                       }
                        echo '</tr>
                            </table class="tabela_ranking">
                          </div>';
             
                         echo '
                               
                         <div class="container container_ranking"><h2>Masculino</h2>
                            <table class="tabela_ranking" style="background-color:#fffff">
                            <thead>
                                <th>#</th>
                                <th>Atleta</th>
                                <th>Tempo</th>
                                <th>Competição</th>
                                <th>Ano</th>
                                
                            </thead>
                            <tr> 
                             ';

                        //busca das informacoes referentes a tabela do masculino
                        $sql = "SELECT `nome_atleta`, `competicao` , `data`, `tempo` FROM `ranking` 
                        WHERE (`prova`='50 Borboleta' AND `sexo`='M') ORDER BY `tempo` ASC LIMIT 80" ;
                       $resultado = mysqli_query($con,$sql);
                       $i=1;
                       $nomes_atletas = array();
                        
                       while(($row = mysqli_fetch_array($resultado)) && ($i <= 10)){
                           if(!in_array($row['nome_atleta'],$nomes_atletas)){
                               $temp = str_replace(".", "'", $row['tempo']);
                               $temp = str_replace("..", "\"", $temp);
                               $data = date_create($row['data']);                                     
                               echo '<tr>
                               <td>'.$i.'</td> 
                               <td>'.$row['nome_atleta'].'</td>
                               <td>'.$temp.'</td>
                               <td>'.$row['competicao'].'</td>
                               <td>'.date_format($data,"Y").'</td>
                               ';
                               $i +=1;
                               $nomes_atletas[] = $row['nome_atleta'];
                          }
                          
                       }
                        echo '</tr>
                            </table class="tabela_ranking">
                         </div>
                        </div>';
                        ?>
                        
                    </div> 
                    
                    <!-----50 Costas---->
                    <div class="tabela" style="display:none;" id="costas_tab" role="tabpanel" aria-labelledby="costas"><?php
                         echo '<div class="prova"><h1 style="color: rgba(255,187,0);">50 Costas</h1></div> 
                         <div class="row form-group"> 
                         <div class="container container_ranking"><h2>Feminino</h2>
                         <table class="tabela_ranking">
                         <thead>
                            <th>#</th>
                            <th>Atleta</th>
                            <th>Tempo</th>
                            <th>Competição</th>
                            <th>Ano</th>
                            
                         </thead>
                         <tr> 
                             ';
                         // Conexão com o servidor MySQL
                        $con = mysqli_connect("srv976.hstgr.io", "u418844475_wtr", "Wetrats2019", "u418844475_wtr");

                        //busca das informacoes referentes a tabela do feminino
                        $sql = "SELECT `nome_atleta`, `competicao` , `data`, `tempo` FROM `ranking` 
                        WHERE (`prova`='50 Costas' AND `sexo`='F') ORDER BY `tempo` ASC LIMIT 80" ;
                       $resultado = mysqli_query($con,$sql);
                       $i=1;
                       $nomes_atletas = array();
                        
                       while(($row = mysqli_fetch_array($resultado)) && ($i <= 10)){
                           if(!in_array($row['nome_atleta'],$nomes_atletas)){
                               $temp = str_replace(".", "'", $row['tempo']);
                               $temp = str_replace("..", "\"", $temp);
                               $data = date_create($row['data']);                                     
                               echo '<tr>
                               <td>'.$i.'</td> 
                               <td>'.$row['nome_atleta'].'</td>
                               <td>'.$temp.'</td>
                               <td>'.$row['competicao'].'</td>
                               <td>'.date_format($data,"Y").'</td>
                               ';
                               $i +=1;
                               $nomes_atletas[] = $row['nome_atleta'];
                          }
                          
                       }
                        echo '</tr>
                            </table class="tabela_ranking">
                           </div>
            
                               
                         <div class="container container_ranking"><h2>Masculino</h2>
                            <table class="tabela_ranking" style="background-color:#fffff">
                            <thead>
                                <th>#</th>
                                <th>Atleta</th>
                                <th>Tempo</th>
                                <th>Competição</th>
                                <th>Ano</th>     
                            </thead>
                            <tr> 
                             ';

                        //busca das informacoes referentes a tabela do masculino
                        $sql = "SELECT `nome_atleta`, `competicao` , `data`, `tempo` FROM `ranking` 
                        WHERE (`prova`='50 Costas' AND `sexo`='M') ORDER BY `tempo` ASC LIMIT 80" ;
                       $resultado = mysqli_query($con,$sql);
                       $i=1;
                       $nomes_atletas = array();
                        
                       while(($row = mysqli_fetch_array($resultado)) && ($i <= 10)){
                           if(!in_array($row['nome_atleta'],$nomes_atletas)){
                               $temp = str_replace(".", "'", $row['tempo']);
                               $temp = str_replace("..", "\"", $temp);
                               $data = date_create($row['data']);                                     
                               echo '<tr>
                               <td>'.$i.'</td> 
                               <td>'.$row['nome_atleta'].'</td>
                               <td>'.$temp.'</td>
                               <td>'.$row['competicao'].'</td>
                               <td>'.date_format($data,"Y").'</td>
                               ';
                               $i +=1;
                               $nomes_atletas[] = $row['nome_atleta'];
                          }
                          
                       }
                        echo '</tr>
                            </table class="tabela_ranking">
                          </div>
                        </div>';
                        ?></div>
                    
                    <!-----50 Peito----->
                    <div class="tabela" style="display:none;" id="peito_tab" role="tabpanel" aria-labelledby="peito">
                    <?php
                         echo '<div class="prova"><h1 style="color: rgba(255,187,0);">50 Peito</h1></div> 
                         <div class="row form-group"> 
                            <div class="container container_ranking"><h2>Feminino</h2>
                                <table class="tabela_ranking">
                                <thead>
                                    <th>#</th>
                                    <th>Atleta</th>
                                    <th>Tempo</th>
                                    <th>Competição</th>
                                    <th>Ano</th>
                                </thead>
                                <tr> 
                             ';
                         // Conexão com o servidor MySQL
                        $con = mysqli_connect("srv976.hstgr.io", "u418844475_wtr", "Wetrats2019", "u418844475_wtr");

                        //busca das informacoes referentes a tabela do feminino
                        $sql = "SELECT `nome_atleta`, `competicao` , `data`, `tempo` FROM `ranking` 
                        WHERE (`prova`='50 Peito' AND `sexo`='F') ORDER BY `tempo` ASC LIMIT 80" ;
                       $resultado = mysqli_query($con,$sql);
                       $i=1;
                       $nomes_atletas = array();
                        
                       while(($row = mysqli_fetch_array($resultado)) && ($i <= 10)){
                           if(!in_array($row['nome_atleta'],$nomes_atletas)){
                               $temp = str_replace(".", "'", $row['tempo']);
                               $temp = str_replace("..", "\"", $temp);
                               $data = date_create($row['data']);                                     
                               echo '<tr>
                               <td>'.$i.'</td> 
                               <td>'.$row['nome_atleta'].'</td>
                               <td>'.$temp.'</td>
                               <td>'.$row['competicao'].'</td>
                               <td>'.date_format($data,"Y").'</td>
                               ';
                               $i +=1;
                               $nomes_atletas[] = $row['nome_atleta'];
                          }
                          
                       }
                        echo '
                            </table class="tabela_ranking">
                           </div>
                            
                           
                         <div class="container container_ranking"><h2>Masculino</h2>
                         <table class="tabela_ranking" style="background-color:#fffff">
                            <thead>
                                <th>#</th>
                                <th>Atleta</th>
                                <th>Tempo</th>
                                <th>Competição</th>
                                <th>Ano</th>
                                
                            </thead>
                         <tr> 
                             ';

                        //busca das informacoes referentes a tabela do masculino
                        $sql = "SELECT `nome_atleta`, `competicao` , `data`, `tempo` FROM `ranking` 
                        WHERE (`prova`='50 Peito' AND `sexo`='M') ORDER BY `tempo` ASC LIMIT 80" ;
                       $resultado = mysqli_query($con,$sql);
                       $i=1;
                       $nomes_atletas = array();
                        
                       while(($row = mysqli_fetch_array($resultado)) && ($i <= 10)){
                           if(!in_array($row['nome_atleta'],$nomes_atletas)){
                               $temp = str_replace(".", "'", $row['tempo']);
                               $temp = str_replace("..", "\"", $temp);
                               $data = date_create($row['data']);                                     
                               echo '<tr>
                               <td>'.$i.'</td> 
                               <td>'.$row['nome_atleta'].'</td>
                               <td>'.$temp.'</td>
                               <td>'.$row['competicao'].'</td>
                               <td>'.date_format($data,"Y").'</td>
                               ';
                               $i +=1;
                               $nomes_atletas[] = $row['nome_atleta'];
                          }
                          
                       }
                        echo '
                            </table class="tabela_ranking">
                          </div>
                        </div>';
                        ?>
                    </div>
                    
                    <!------50 Livre-------->
                    <div class="tabela" style="display:none;" id="livre_tab" role="tabpanel" aria-labelledby="livre">
                    <?php
                         echo '<div class="prova"><h1 style="color: rgba(255,187,0);">50 Livre</h1></div> 
                         <div class="row form-group"> 
                         <div class="container container_ranking"><h2>Feminino</h2>
                         <table class="tabela_ranking">
                         <thead>
                            <th>#</th>
                            <th>Atleta</th>
                            <th>Tempo</th>
                            <th>Competição</th>
                            <th>Ano</th>
                            
                         </thead>
                         <tr> 
                             ';
                         // Conexão com o servidor MySQL
                        $con = mysqli_connect("srv976.hstgr.io", "u418844475_wtr", "Wetrats2019", "u418844475_wtr");

                        //busca das informacoes referentes a tabela do feminino
                        $sql = "SELECT `nome_atleta`, `competicao` , `data`, `tempo` FROM `ranking` 
                        WHERE (`prova`='50 Livre' AND `sexo`='F') ORDER BY `tempo` ASC LIMIT 80" ;
                       $resultado = mysqli_query($con,$sql);
                       $i=1;
                       $nomes_atletas = array();
                        
                       while(($row = mysqli_fetch_array($resultado)) && ($i <= 10)){
                           if(!in_array($row['nome_atleta'],$nomes_atletas)){
                               $temp = str_replace(".", "'", $row['tempo']);
                               $temp = str_replace("..", "\"", $temp);
                               $data = date_create($row['data']);                                     
                               echo '<tr>
                               <td>'.$i.'</td> 
                               <td>'.$row['nome_atleta'].'</td>
                               <td>'.$temp.'</td>
                               <td>'.$row['competicao'].'</td>
                               <td>'.date_format($data,"Y").'</td>
                               ';
                               $i +=1;
                               $nomes_atletas[] = $row['nome_atleta'];
                          }
                          
                       }
                        echo '
                            </table class="tabela_ranking">
                           </div>
            
                         <div class="container container_ranking"><h2>Masculino</h2>
                         <table class="tabela_ranking">
                            <thead>
                                <th>#</th>
                                <th>Atleta</th>
                                <th>Tempo</th>
                                <th>Competição</th>
                                <th>Ano</th>
                                
                            </thead>
                         <tr> 
                             ';

                       //busca das informacoes referentes a tabela do masculino
                       $sql = "SELECT `nome_atleta`, `competicao` , `data`, `tempo` FROM `ranking` 
                       WHERE (`prova`='50 Livre' AND `sexo`='M') ORDER BY `tempo` ASC LIMIT 80" ;
                      $resultado = mysqli_query($con,$sql);
                      $i=1;
                      $nomes_atletas = array();
                       
                      while(($row = mysqli_fetch_array($resultado)) && ($i <= 10)){
                          if(!in_array($row['nome_atleta'],$nomes_atletas)){
                              $temp = str_replace(".", "'", $row['tempo']);
                              $temp = str_replace("..", "\"", $temp);
                              $data = date_create($row['data']);                                     
                              echo '<tr>
                              <td>'.$i.'</td> 
                              <td>'.$row['nome_atleta'].'</td>
                              <td>'.$temp.'</td>
                              <td>'.$row['competicao'].'</td>
                              <td>'.date_format($data,"Y").'</td>
                              ';
                              $i +=1;
                              $nomes_atletas[] = $row['nome_atleta'];
                         }
                         
                      }
                        echo '
                            </table class="tabela_ranking">
                           </div>
                          </div>';
                        ?>
                    </div>
                    <div class="tabela" style="display:none;" id="medley_tab" role="tabpanel" aria-labelledby="medley">
                    <?php
                         echo '<div class="prova"><h1 style="color: rgba(255,187,0);">100 Medley</h1></div> 
                         <div class="row form-group"> 
                         <div class="container container_ranking"><h2>Feminino</h2>
                            <table class="tabela_ranking">
                                <thead>
                                    <th>#</th>
                                    <th>Atleta</th>
                                    <th>Tempo</th>
                                    <th>Competição</th>
                                    <th>Ano</th>
                                    
                                </thead>
                            <tr> 
                             ';
                         // Conexão com o servidor MySQL
                        $con = mysqli_connect("srv976.hstgr.io", "u418844475_wtr", "Wetrats2019", "u418844475_wtr");

                        //busca das informacoes referentes a tabela do feminino
                        $sql = "SELECT `nome_atleta`, `competicao` , `data`, `tempo` FROM `ranking` 
                        WHERE (`prova`='100 Medley' AND `sexo`='F') ORDER BY `tempo` ASC LIMIT 80" ;
                       $resultado = mysqli_query($con,$sql);
                       $i=1;
                       $nomes_atletas = array();
                        
                       while(($row = mysqli_fetch_array($resultado)) && ($i <= 10)){
                           if(!in_array($row['nome_atleta'],$nomes_atletas)){
                               $temp = str_replace(".", "'", $row['tempo']);
                               $temp = str_replace("..", "\"", $temp);
                               $data = date_create($row['data']);                                     
                               echo '<tr>
                               <td>'.$i.'</td> 
                               <td>'.$row['nome_atleta'].'</td>
                               <td>'.$temp.'</td>
                               <td>'.$row['competicao'].'</td>
                               <td>'.date_format($data,"Y").'</td>
                               ';
                               $i +=1;
                               $nomes_atletas[] = $row['nome_atleta'];
                          }
                          
                       }
                        echo '
                            </table class="tabela_ranking">
                           </div>
                               
                         <div class="container container_ranking"><h2>Masculino</h2>
                         <table class="tabela_ranking" style="background-color:#fffff">
                         <thead>
                            <th>#</th>
                            <th>Atleta</th>
                            <th>Tempo</th>
                            <th>Competição</th>
                            <th>Ano</th>
                            
                         </thead>
                         <tr> 
                             ';

                        //busca das informacoes referentes a tabela do masculino
                        $sql = "SELECT `nome_atleta`, `competicao` , `data`, `tempo` FROM `ranking` 
                        WHERE (`prova`='100 Medley' AND `sexo`='M') ORDER BY `tempo` ASC LIMIT 80" ;
                       $resultado = mysqli_query($con,$sql);
                       $i=1;
                       $nomes_atletas = array();
                        
                       while(($row = mysqli_fetch_array($resultado)) && ($i <= 10)){
                           if(!in_array($row['nome_atleta'],$nomes_atletas)){
                               $temp = str_replace(".", "'", $row['tempo']);
                               $temp = str_replace("..", "\"", $temp);
                               $data = date_create($row['data']);                                     
                               echo '<tr>
                               <td>'.$i.'</td> 
                               <td>'.$row['nome_atleta'].'</td>
                               <td>'.$temp.'</td>
                               <td>'.$row['competicao'].'</td>
                               <td>'.date_format($data,"Y").'</td>
                               ';
                               $i +=1;
                               $nomes_atletas[] = $row['nome_atleta'];
                          }
                          
                       }
                        echo '
                            </table class="tabela_ranking">
                          </div>
                         </div>';
                        ?>
            </div>
            <div class="row"><p>Contabilizados apenas tempos registrados com placar eletrônico</p></div>
        </div>
    </div>
</div>
<script src="../common/js/ranking1.js"></script>
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