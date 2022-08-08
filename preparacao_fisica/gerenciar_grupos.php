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
    
    if($_SESSION['NIVEL'] != 2){
        header("Location: ../perfil/");
    }

?>


<body>
    <div class="bg-modal">
        <div class="modal-contents" style="margin-top:30px;">
            <div class="col">
                <div class="close"><a href="#">+</a></div>
                <div id="divDescricao"></div>
            </div>
        </div>
    </div>
    <div id="page">
        <nav class="fh5co-nav" id="menu-list" role="navigation">
            <div id="menu"></div>
        </nav>
        <div id="menus"></div>

        <div class="container-fluid" style="padding-top:60px;">
        <?php
            if (isset($_SESSION['MSG'])){
                echo '<div class="alert alert-success" role="alert">'.$_SESSION['MSG'].'</div>';
                unset($_SESSION['MSG']);
            }
            if (isset($_SESSION['ALERTA'])){
                echo '<div class="alert alert-danger" role="alert">'.$_SESSION['ALERTA'].'</div>';
                unset($_SESSION['ALERTA']);
              }
        ?>
            <div class="section_title_container">
                <div class="section_title light">
                    <div class="row">
                        <div class="col-6">
                            <h1>Gerenciamento Preparação Física</h1>
                        </div>
                        <!--div class="col-3">
                            <a href="./resultados.php"><button class="btn-primary">Monitoramento Psicométrico</button></a>
                        </div>
                        <div class="col-3">
                            <a href="../cargas/"><button class="btn-primary">Cargas</button></a>
                        </div-->
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <?php
                $link = mysqli_connect("auth-db213.hostinger.com.br", "u418844475_wtr", "wetrats2019", "u418844475_wtr");
                $sql = "SELECT id_atleta FROM grupos_preparacao";
                $atletas = mysqli_fetch_assoc(mysqli_query($link, $sql));

                if($atletas != false){
                    $sql2 = 'SELECT id, nome FROM usuarios WHERE nivel!="2" AND id!="31" AND ativo=1 AND id NOT IN (SELECT id_atleta FROM grupos_preparacao) ORDER BY nome';
                } else {
                    $sql2 = "SELECT id, nome FROM usuarios WHERE nivel!='2' AND id!='31' AND ativo=1 ORDER BY nome";
                }
                
                $atletas2 = mysqli_query($link, $sql2);
            ?>
            <div class="col-4">
                <div class="cont_carac formu">
                    <form class="form-group" id="form_carac" method="post" action="db.php">

                        <h4>Criar Grupo</h4>
                        <div class="row"><label for="nome">Nome do Grupo</label><input type="text" class="form-control"
                                style="margin-left: 22px; margin-right: 17px;" name="nome" id="nome" required></div>

                        <?php
                            $i = 0;
                            while( $row = mysqli_fetch_assoc($atletas2)){    
                                echo '<div class="row"><label for="atl'.$i.'" ><input type="checkbox" style="height: 13px;" name="atl[]" id="atl'.$i.'" value='.$row['id'].'>'.$row['nome'].'</label></div>';
                                $i++;
                            }
                        ?>

                        <button class="btn btn-primary" type="submit">Enviar</button>
                    </form>
                </div>
            </div>

            <div class="col-8">
                <div class="cont_carac formu">
                    <h4>Grupos</h4>
                    <?php
                        $sql3 = 'SELECT DISTINCT nome FROM grupos_preparacao';
                        $nome = mysqli_query($link, $sql3);
                        $grupos = mysqli_query($link,$sql3);
                        $html_grupos="";
                        
                        while($nome_grupo = mysqli_fetch_assoc($grupos)){
                            $html_grupos= $html_grupos . '<option value=\''.$nome_grupo['nome'].'\'>'.$nome_grupo['nome']."</option>";
                        }

            
                        
                        
                        while($row = mysqli_fetch_assoc($nome)){
                            $sql4 = 'SELECT id_atleta FROM grupos_preparacao WHERE nome="'.$row['nome'].'"';
                            echo '
                            
                            <div style="width:90%;" class="prova"><h1 style="color: rgba(255,187,0); display: inline;text-transform:capitalize;">'.$row["nome"].'</h1><a style="color: rgba(255,187,0); display: inline; margin-left: 40px;" href="remover.php?nome='.$row['nome'].'">X</a></div>
                                <div class="row" style="margin-top:15px">
                                 <div class="col-4">    
                                    <div class="container tabela_inscricao" style="width:90%">
                                        <table>';
                                        $ids = mysqli_query($link, $sql4);
                                        while($row_g = mysqli_fetch_assoc($ids)){
                                        $sql5 = 'SELECT nome FROM usuarios WHERE id='.$row_g["id_atleta"];
                                        $nome_atl = mysqli_fetch_assoc(mysqli_query($link, $sql5));
                                        echo '<tr><td style="font-size:12px;">'.$nome_atl['nome'].'</td><td><a style="color:rgb(255, 0, 0); margin-left: 20px;" href="remover.php?id='.$row_g['id_atleta'].'">X</a></td></tr>';
                                        }
                                        echo '</table>
                                    </div>
                                 </div>
                                 <div class="col-8">
                    
                                 ';

                                 $sql6= 'SELECT id,nome,periodo,etapa, tipo,data_inicio,data_termino,status FROM treinos_academia WHERE grupo='."'".$row['nome']."'";
                                    
                                 $treinos = mysqli_query($link,$sql6);
                                 if(mysqli_num_rows($treinos)>0){
                                     $i=0;
                                     $b=10000;
                                    $d=100000;
                                     while($treino = mysqli_fetch_assoc($treinos)){
                                         if($i==0)echo '
                                         <h5 style="font-size:1.75rem">RELAÇÃO DE TREINOS:</h5>
                                        <table class="tabela_treinoacad" style="width:90%;">
                                        <thead>
                                            <th>Nome</th>
                                            <th>Período</th>
                                            <th>Etapa</th>
                                            <th>Tipo</th>
                                            <th>Data</th>
                                            <th>Status</th>
                                            <th></th>
                                        </thead>
                                        <tr>
                                        <tbody>';
                                         $i++;
                                         $b++;
                                         $d++;
                                         echo '<tr>
                                                    <td onClick='."'".'window.location="./visualizar_treino.php?id_treino='.$treino['id'].'"'."'".'>'.$treino['nome'].'</td>
                                                    <td onClick='."'".'window.location="./visualizar_treino.php?id_treino='.$treino['id'].'"'."'".'>'.$treino['periodo'].'</td>
                                                    <td onClick='."'".'window.location="./visualizar_treino.php?id_treino='.$treino['id'].'"'."'".'>'.$treino['etapa'].'</td>
                                                    <td onClick='."'".'window.location="./visualizar_treino.php?id_treino='.$treino['id'].'"'."'".' style="text-align:center;">'.$treino['tipo'].'</td>
                                                    <td onClick='."'".'window.location="./visualizar_treino.php?id_treino='.$treino['id'].'"'."'".'>'.date_format(date_create($treino['data_inicio']),"d/m")." ~ ".date_format(date_create($treino['data_termino']),"d/m").'</td>';

                                                    if($treino['status']==0) echo "
                                                    <td style='text-align:center;'><a href='./ativar.php?id=".$treino['id']."'><img src='../common/images/Red_Light_Icon.svg.png' height='15' width='15'></a></td>";
                                                    else echo "
                                                    <td style='text-align:center;'><a href='./desativar.php?id=".$treino['id']."'><img src='../common/images/Green_Light_Icon.svg.png' height='15' width='15'></a></td>";       
                                        
                                        echo '      
                                        <td style="text-align:center;"><button class="btn" style="margin:0;padding:0;" id="'.$b.'" onclick="exibe('."$b".')" value="
                                                        <form method=\'post\' action=\'./copia_treino.php\'>
                                                        
                                                        <div class=\'col-12\'>
                                                        <h2>Para qual grupo deseja copiar este treino?</h2>

            
                                                            <label for=\'grupo\' style=\'padding-left:15px\'><b>Grupo:</b></label>
                                                            <select name=\'grupo\'>
                                                             '.$html_grupos.'
                                                             </select>
                                                             <input type=\'hidden\' value='.$treino['id'].' name=\'id\'>
                                                        </div>
                                                                    
                                                        <button class=\'btn btn-primary\' type=\'submit\'>Adicionar</button>
                                                        </form>"
                                                        >
                                                        <img class="copy" style="filter:invert(1);" src="../common/images/copy.png" height=15 width=15>
                                                    </button></td>

                                                    <td><button id="'.$d.'" class="btn" style="margin:0;padding:0;"  onclick="exibe(this.id)"
                                                            value="<div class=\'col\'>
                                                                    <h2>Você tem certeza que deseja deletar este treino?</h2>
                                                                        
                                                                    </div>
                                                            <div><a class=btn-danger href=./deletar_treino.php?id='.$treino['id'].'>Deletar</a></div>"
                                                            >
                                                            <img class="copy" style="filter:invert(1);" src="../common/images/deletar.png"  height="16" width="15"></button></td>     
                                                                                                    
                                                    </tr>
                                                            ';
                                     }
                                     echo '</tbody>
                                     </table>
                                     <br>';
                                 }
                                 else echo 'Ainda não foram adicionados os treinos';


                                echo'
                                <br>
                                <a href="./criar_treino.php"><button class="btn-primary">Adicionar treino</button></a>
                                </div>
                            </div>';
                                
                            }
                                
                    ?>
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
    <!------Modal de visualização--------->
    <script src="../common/js/treino.js"></script>
</body>

</html>