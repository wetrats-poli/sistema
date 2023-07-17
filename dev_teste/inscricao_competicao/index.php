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
  $nome_usuario= $_SESSION['NOME'];
  $nivel_usuario = $_SESSION['NIVEL'];
  $sexo_usuario = $_SESSION['SEXO'];
  //grava o nome da competicao passada por URL para não perder essa informacao
  if(strlen($_GET['competicao'])>1)
  $_SESSION['competicao']=$_GET['competicao'];
  
  $atletas=array();
  $n=0;
  // Conexão com o servidor MySQL
  $con = mysqli_connect("auth-db213.hstgr.io", "u418844475_wtr", "Wetrats2019", "u418844475_wtr");

  //busca das informacoes referentes a competicao
  $sql = "SELECT * FROM `competicoes` WHERE evento="."'".$_SESSION['competicao']."'".";" ;
  $resultado = mysqli_query($con,$sql);
  while($row = mysqli_fetch_assoc($resultado)){
          $data = $row['data'];
          $data2 = date_create($data);
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
    $inscritos=array();
    $sql = "SELECT * FROM "."`".$_SESSION['competicao']."`"." ;" ;
    $resultado = mysqli_query($con,$sql);
    while($row = mysqli_fetch_array($resultado)){
          $atletas[$n] = $row;
          $inscritos[]= $row['nome_atleta'];
          $n += 1;
      }

?>  


<body>
<!-----Modal para visualização de da descricao------->
<div class="bg-modal" style="background-color: rgba(0, 0, 0, 0.9);">
	<div class="modal-contents" style="background-color:rgba(255, 255, 255)">
        <div class="col">
        <div class="close" ><a href="#">+</a></div>
            <div id ="divDescricao"></div>    
        </div>
    </div>
  </div>
<div id="page">
  <nav class="fh5co-nav" id="menu-list" role="navigation">
      <div id="menu"></div>
  </nav>
  <div id="menus"></div>

  <div class="container-fluid" style="padding-top:60px;" >
      <form method="post" action="index.php" class="col-12">

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
        <div class="section_title light">
            <h1>Inscrição <?php echo $_SESSION['competicao']; ?></h1>
        </div>
        <p style="color:#000000;">Preencha o tempo de balizamento nas provas em que deseja se inscrever.</p>
        <hr>
            
        <?php
            if ($valor != '0'){
                if ($tipo_inscricao == 0) $tipo = ' Individual' ;
                else $tipo = ' por prova' ;
            echo '
        <div class="container informacoes_inscricao">
        <div class="row form-group style="padding-top:5px;">        
            <div class=col-md-6>
                  <h2><b>Informações principais</b></h2>
                  <hr>
            
                  <div class="row">
                    <div class= col-md-6>
                        <b>Data:</b>'.date_format($data2, "d/m/Y").'</div>
                    <div class= col-md-6>    
                        <b>Local:</b>'.$local.'</div>
                  </div>
                  <div class= "form-group">
                    <div><button id="1" class="treino" onclick="exibe(this.id)" 
                    value="<h1>'.$_SESSION['competicao'].'</h1><br><p class=text-justify>'.$descricao.'</p>" 
                    type="button" href="#">Descrição</button></div>
                  </div>        
            </div>
             '; 
            
                  echo '
            <div class=col-md-6>
                <h2><b>Valores da inscrição</b></h2>
                <hr>
                <div class="row">
                <div class= col-md-6>
                    <b>Tipo de inscrição:</b>'.$tipo.'</div>';
                if($valor > 0){
                    echo '<div class= col-md-6>    
                    <b>Valor:</b>R$'.$valor.'</div>';
                }
                echo '</div>
            </div>
        </div>
        </div> ';
            }
        else {
            echo '
        <div class="container informacoes_inscricao">
        <div class="row form-group" style="padding-top:5px;">        
            <div class=col-md-12>
                  <h2><b>Informações principais</b></h2>
                  <hr>
            
                  <div class="row">
                    <div class= col-lg-6> 
                        <b>Data:</b>'.$data.'</div>
                    <div class= col-lg-6>    
                        <b>Local:</b>'.$local.'</div>
                  </div>
                  <div class= col-md-12>
                    <div><button id="1" class="treino" onclick="exibe(this.id)" 
                    value="<h1>'.$_SESSION['competicao'].'</h1><br><p class=text-justify>'.$descricao.'</p>" 
                    type="button" href="#">Descrição</button></div>
                    </div>  
                  </div>        
            </div>
            </div> ';


        }
        echo '
        <div class="row" style="margin-top:20px;">
            <div class="col-3 offset-9">
                <button id="2" class="treino btn-primary" onclick="exibe(this.id)" 
                value="
                <h1>Remover inscrição?</h1><br>
                <p>Isso removerá você de todas as provas em que estiver inscrito.</p><br>
                <a href='."'".'./remover_inscricao.php?competicao='.$_SESSION['competicao'].'&atleta_id='.$_SESSION['ID']."'".'><button type=button class=btn-danger>Remover</button></a>"
                type="button" href="#">Remover inscrição</button>
            </div>
                
        </div>';
        if ($nivel_usuario=="3"){
            $html='<div class="row">
                    <div class="col-auto">
                    <div class="container_form">
                        <div class="row form-group">
                            <label>Atleta:</label>
                            <select name="atleta">';
            $sql="SELECT id,nome, sexo FROM `usuarios` WHERE ativo=1 and id!=31 ORDER BY nome ;";
            $resultado = mysqli_query($con,$sql);
            while($row=mysqli_fetch_assoc($resultado)){
                $html.='<option value="'.$row['id']."_".$row['nome'].'_'.$row['sexo'].'"';
                if ($_POST['atleta']== $row['id']."_".$row['nome'].'_'.$row['sexo']) $html .= 'selected';
                $html.= '>'.$row['nome']; 
                if(!in_array($row['nome'],$inscritos)) $html.='-NÃO INSCRITO'; 
                $html.='</option>';
            }
            $html.='        </select>
                        </div>
                      </div>
                    </div>
                  </div>';
            echo $html;
        }
        $i=0;
        foreach ($ordem_provas as $prova){
            echo '<div class="prova"><h1 style="color: rgba(255,187,0);">'.$provas[$i].'</h1></div> 
            <div class="row form-group"> 
            <div class="container tabela_inscricao"><h2>Feminino</h2>
            <table style="width:80%; margin-left:10px;"> 
                ';
            foreach($atletas as $atleta){
                if ($atleta['sexo']=="F"){
                    if ($atleta[$prova]){
                        echo '<tr>
                                <td>'.$atleta['nome_atleta'].'</td>
                                <td>'.$atleta[$prova];
                                if(($atleta['nome_atleta'] == $_SESSION['NOME']) or ($nivel_usuario=="3")){
                                    echo '<a style="color: rgb(255,0,0);" href="./remover_prova.php?competicao='.$_SESSION['competicao'].'&prova='.$prova.'&atleta_id='.$atleta['atleta_id'].'"> X </a>';
                                }
                                echo '</td>
                                <tr>';
                    }
                }
            }

            echo '</div>
            </table></div>
                  <div class="container tabela_inscricao"><h2>Masculino</h2>  
                  <table style="width:80%; margin-left:10px;">  
                    ';
            foreach($atletas as $atleta){
                if ($atleta['sexo']=="M"){
                    if ($atleta[$prova]){
                        echo '<tr>
                                <td>'.$atleta['nome_atleta'].'</td>
                                <td>'.$atleta[$prova];
                                if(($atleta['nome_atleta'] == $_SESSION['NOME']) or ($nivel_usuario=="3")){
                                    echo '<a style="color: rgb(255,0,0);" href="./remover_prova.php?competicao='.$_SESSION['competicao'].'&prova='.$prova.'&atleta_id='.$atleta['atleta_id'].'"> X </a>';
                                }
                                echo '</td> 
                                <tr>';
                    }
                }
            }
            echo'</table>
                </div>
              </div>
              
            <div class="row form-group">
                <div class="col-6 col-push-3">
                    <label for='.$prova.'><b>Tempo de balizamento:</b></label>
                    <input class="form-control" type=text name='.$prova.'>
                </div> 
            </div>';    
            $i+=1;    
        }?>
        <div>
        <hr>
        <div class="row">
          <div class="form-group col-3 offset-4">
            <button type="submit" class="btn btn-primary" name="finalizado" value="1">Enviar</button> 
          </div>
          </form>
          <div class="form-group col-3">
            <button class="btn btn-primary" onclick="location.href='../competicoes/index.php'" type="button">Cancelar</button>
          </div>
        </div>

      </div>
    </form>
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

<?php
if (($_POST['finalizado']=="0")){
    echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
    echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', '../competicoes/');});</script>";
    //header("Location: ../competicoes/index.php");exit;
}
if (($_POST['finalizado']=="1")){
    if($nivel_usuario=="3"){
        $atleta=explode("_",$_POST['atleta']);
        $id_usuario = $atleta[0];
        $nome_usuario = $atleta[1];
        $sexo_usuario = $atleta[2];
    }

    // Conexão com o servidor MySQL
    $con = mysqli_connect("auth-db213.hstgr.io", "u418844475_wtr", "Wetrats2019", "u418844475_wtr");

     // Busca do id do treino ao qual será incluída a presença
    $sql =  "SELECT atleta_id FROM "."`".$_SESSION['competicao']."`"." WHERE atleta_id = '$id_usuario' ";
    $resultado = mysqli_query($con, $sql);
    if (mysqli_num_rows($resultado)>0) { // se o atleta ja tiver inscrito
        $sql= "UPDATE "."`".$_SESSION['competicao']."` SET ";
        foreach($ordem_provas as $prova){
            if (strlen($_POST[$prova])>1){
                $tempo = str_replace('"' , '\\"' , $_POST[$prova]); //procedimento pra permitir a inclusao de aspas duplas
                $tempo = str_replace("'" , "\\'" , $tempo); // e simples no texto
                $sql.="`".$prova."` = '".$tempo."' ,";  
            }
        }
        $sql = substr($sql,0,-1);
        $sql.= " WHERE atleta_id = '$id_usuario' ";
    }
    else { //caso o atleta ainda nao esteja inscrito
        $tempos = array();
        $sql= "INSERT INTO "."`".$_SESSION['competicao']."` (atleta_id, nome_atleta, sexo, ";
        foreach($ordem_provas as $prova){
            if (strlen($_POST[$prova])>1){
                $tempo = str_replace('"' , '\\"' , $_POST[$prova]); //procedimento pra permitir a inclusao de aspas duplas
                $tempo = str_replace("'" , "\\'" , $tempo); // e simples no texto
                $sql.="`".$prova."` ," ; // inserção das provas no sql
                $tempos[] = $tempo;  
            }
        }
        $sql = substr($sql,0,-1);
        $sql .= ") VALUES (".$id_usuario." ,'$nome_usuario' , '$sexo_usuario' ,"; //inserçao do atleta no sql
        foreach($tempos as $tempo){
            $sql .= "'".$tempo."' ,"; //inserção dos tempos no sql
        }
        $sql = substr($sql,0,-1);
        $sql.= ")";

    } 
    
    if (!mysqli_query($con,$sql)){
        $_SESSION['ALERTA'] .= "Error description: ".mysqli_error($con).$sql;
        echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
        echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './index.php?competicao=".$_SESSION['competicao']."');});</script>";
        //header("Location: ./index.php?competicao=".$_SESSION['competicao']);exit; 
    }
    else{ 
    $_SESSION['MSG'] ="A inscrição foi incluída com sucesso. Por favor, confira.";
    echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
    echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', './index.php?competicao=".$_SESSION['competicao']."');});</script>";
    //header("Location: ./index.php?competicao=".$_SESSION['competicao']);exit;
    } 
}
?>