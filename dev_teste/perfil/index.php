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
    
    // Conexão com o servidor MySQL
    require_once '../db_con.php';

    // Busca das informações referentes ao usuário
    $sql =  "SELECT id, nome, sexo, apelido, aniversario, email, senha, celular, RG, NUSP, endereco, foto, nivel, ativo FROM usuarios WHERE id = '$id_usuario' ";
    $perfil = mysqli_query($con, $sql);
    
    while ($p = mysqli_fetch_array($perfil)){
        $nome = $p['nome'];
        $sexo = $p['sexo'];
        $apelido = $p['apelido'];
        $aniversario= $p['aniversario'];
        $date = date_create($aniversario);
        $email = $p['email'];
        $senha = $p['senha'];
        $celular = $p['celular'];
        $celular=str_replace("(","",$celular);
        $celular=str_replace(")","",$celular);
        $celular=str_replace(" ","",$celular);
        $celular=str_replace("-","",$celular);
        $celular=str_replace("+","",$celular);
        $ddd=substr($celular,0,2);
        $numero=substr($celular,2);
        $RG= $p['RG'];
        $NUSP = $p['NUSP'];
        $endereco = $p['endereco'];
        $nivel = $p['nivel'];
        $id = $p['id'];
        $foto = $p['foto'];
        $ativo = $p['ativo'];
        

    }
    if($nivel_usuario != "2"){
        $sql1 =  "SELECT (SELECT COUNT(*) FROM `presencas` WHERE `id_atleta`=$id_usuario AND id_treino>=573) AS npresenca , 
                  (SELECT COUNT(DISTINCT id_treino) FROM presencas WHERE id_treino>=573) AS 'ntreinos' ;" ;
        $resultado = mysqli_query($con,$sql1);
        $res= mysqli_fetch_assoc($resultado);
        if ($res['ntreinos']>0){
        $presenca= intval($res['npresenca']) / intval($res['ntreinos']) * 100;
        }
        else $presenca = 0;
    }
?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
    <link rel="stylesheet" href="../common/stylesheets/bootstrap.css">
    <link rel="stylesheet" href="../common/stylesheets/bootstrap4.css">
    <link rel="stylesheet" href="../common/stylesheets/animate.css">
    <link rel="stylesheet" href="../common/stylesheets/style.css">
    <link rel="stylesheet" href="../common/stylesheets/style1.css">
    <link rel="icon" type="image/png" href="../common/images/favicon-32x32.png" sizes="32x32" />
    <title>Wetrats - Perfil</title>

    <script src="../common/js/jquery.min.js"></script>
    <script src="../common/js/jquery.easing.1.3.js"></script>
    <script src="../common/js/contagem.js"></script>
</head>

<body>
<!-----Modal para visualização de treino digitado------->
<div class="bg-modal">
	<div class="modal-contents" style="margin-top:30px;">
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
   

<div style="padding-top:60px;">
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

        if ($nivel_usuario==3) echo '
        <div class="row" style="margin-left:30px;">
            <button type="button" class="btn-primary" onclick='."'".'window.location.href="../equipe/"'."'".'>Gerenciamento da equipe</button>
            <!--button type="button" class="btn-primary" onclick='."'".'window.location.href="../gerenciar_projeto/"'."'".' style="margin-left:60px;">Projeto IUSP</button-->
        </div>';

        if ($nivel_usuario==2) echo '
        <div class="row" style="margin-left:30px;">
            <button type="button" class="btn-primary" onclick='."'".'window.location.href="../pontuacaox/"'."'".' style="margin-left:60px;">Pontuação X</button>
            <button type="button" class="btn-primary" onclick="window.location.href=\'../caracteristicas/\'" style="margin-left:60px;">Características</button>
            <button type="button" class="btn-primary" onclick="window.location.href=\'../PSE/visualizar.php\'" style="margin-left:60px;">PSE</button>
            <button type="button" class="btn-primary" onclick="window.location.href=\'../preparacao_fisica/gerenciar_grupos.php\'" style="margin-left:60px;">Preparação Física</button>
        </div>';


        
//exibição do treino do dia
date_default_timezone_set('America/Sao_Paulo');
$hoje=date("Y-m-d");
//if(date('G')>=19 or date('G')==0) {
//     $sql= "SELECT nome_foto , treino FROM `treinos` WHERE data=(SELECT DATE_ADD("."'".$hoje."'".", INTERVAL 1 DAY));" ;
//     $sql17 = "SELECT nome_foto , treino FROM `treinos_17` WHERE data=(SELECT DATE_ADD("."'".$hoje."'".", INTERVAL 1 DAY));" ;

//}
//else{
$sql= "SELECT nome_foto , treino , total FROM `treinos` WHERE data="."'".$hoje."'".";" ;
//$sql17= "SELECT nome_foto , treino , total FROM `treinos_17` WHERE data="."'".$hoje."'".";" ;
//} 
$resultado = mysqli_query($con,$sql);
$treino = mysqli_fetch_assoc($resultado);
$foto_treino = $treino['nome_foto'];
$descricao = $treino['treino'];
$total = $treino['total'];

//$resultado17 = mysqli_query($con,$sql17);
//$treino17 = mysqli_fetch_assoc($resultado17);
//$foto_treino17 = $treino17['nome_foto'];
//$descricao17 = $treino17['treino'];
//$total17 = $treino17['total'];


//if(date('G')>=19 or date('G')==0){ //das 19 as 23:59 mostra o treino de amanha
//Caso voltar para o modelo anterior de mostrar o treino do dia seguinte após às 19h, mudar os h1 para 'treino de amanhã'
if(strlen($foto_treino)>0) echo'
<div class="row">        
    <div class="col" style="padding-left:30px;">
    <div class="row">
        <div class="section_title_container  treino">
            <div class="section_title light" ><h1>Treino de hoje:</h1></div>
        </div>
        <a href="../common/uploads/treinos/'.$foto_treino.'"'.'><img src="../common/images/visualizar.png" height=42px width=42px></a>
        <!--a href="../common/uploads/treinos/'.$foto_treino17.'"'.'><img src="../common/images/visualizar.png" height=42px width=42px></a-->
        <button class="treino btn btn-primary" type="button" onclick="window.location.href = \'../PSE\'">PSE</button>
    </div>
    </div>
    </div>';

if(strlen($descricao)>0) echo'
    <div class="row" style="margin-top:30px;">
        <div class="col" style="padding-left:30px;">
            <div class="row">
            <div class="section_title_container treino ">
                <div class="section_title light" ><h1>Treino de hoje:</h1></div>
            </div>
            <div><button style="color:white;margin-left:5px;top:0;" id="1" class="treino btn btn-primary" onclick="exibe(this.id)" value="Treino do dia: '.date("d/m/Y", strtotime("+0 day")).'<br>'.$descricao.'<br> TOTAL: '.$total.'" type="button" href="#">Treino</button></div>
            <!--div><button style="color:white;margin-left:5px;top:0;" id="2" class="treino btn btn-primary" onclick="exibe(this.id)" value="Treino do dia: '.date("d/m/Y", strtotime("+1 day")).'<br>'.$descricao17.'<br> TOTAL: '.$total17.'" type="button" href="#">17</button></div-->
            <button class="treino btn btn-primary" type="button" onclick="window.location.href = \'../PSE\'">PSE</button>
            </div>
        </div>
    </div>';
//}
// else {//restante do dia mostra o treino do dia
//     if(strlen($foto_treino)>0) echo'
//     <div class="row">
//         <div class="col" style="padding-left:30px;">
//         <div class="row">
//             <div class="section_title_container  treino">
//                 <div class="section_title light" ><h1>Treino de hoje:</h1></div>
//             </div>
//             <a href="../common/uploads/treinos/'.$foto_treino.'"'.'><img src="../common/images/visualizar.png" height=42px width=42px></a>
//             <button class="treino btn btn-primary" type="button" onclick="window.location.href = \'../PSE\'">PSE</button>
//         </div>
//         </div>
//         </div>';
    
//     if(strlen($descricao)>0) echo'
//         <div class="row" style="margin-top:30px;">
//             <div class="col" style="padding-left:30px;">
//             <div class="row">
//                 <div class="section_title_container treino">
//                     <div class="section_title light" ><h1>Treino de hoje:</h1></div>
//                 </div>
//                 <div><button style="color:white;margin-left:5px;top:0;" id="'.$i.'" class="treino btn btn-primary" onclick="exibe(this.id)" value="Treino do dia: '.date("d/m/Y").'<br>'.$descricao.'<br> TOTAL:'.$total.'" type="button" href="#">Visualizar</button>
//                 <button class="treino btn btn-primary" type="button" onclick="window.location.href = \'../PSE\'">PSE</button>
//                 </div>
//             </div>
//             </div>';
//}
//treinos de academia
        //if($nivel_usuario!=2){
        //    echo "<div class='col' style='margin-left: 20px; display: flex;'>";
        //    $sql="SELECT nome FROM grupos_preparacao WHERE id_atleta=".$id_usuario;
        //    $query=mysqli_query($con,$sql);
        //    $grupo = mysqli_fetch_assoc($query);
        //   echo '
        //        <div class="row">
        //            <div class="section_title_container prep">
        //               <div class="section_title light" ><h1 style="left: -10px; position: relative;">'.$grupo['nome'].':</h1></div>
        //            </div>';
        //    $sql_acad = 'SELECT id,tipo FROM treinos_academia WHERE grupo="'.$grupo['nome'].'"AND status=1;';
        //    $query_acad= mysqli_query($con,$sql_acad);

        //    while($treino_acad= mysqli_fetch_assoc($query_acad)){
            
        //        echo '<a href="../preparacao_fisica/visualizar_treino.php?id_treino='.$treino_acad['id'].'" style="margin-left:10px;margin-right:10px;"><div class="btn btn-primary">'.$treino_acad['tipo'].'</div></a>
        //        ';
        //    }
        //    echo '
        //    </div>

        //    <button class="treino btn btn-primary" type="button" onclick="window.location.href = \'../preparacao_fisica/monitoramento.php\'" style="margin-left: 5px;">Questionários</button>
        //    <button class="treino btn btn-primary" type="button" onclick="window.location.href = \'../cargas/\'" style="margin-left: 5px;">Cargas</button></div>';

        //    echo '</div>';   
        //}
        
        echo '
        <div class="row">
        <div class="grid">
            <div class="container_perfil padi">
            <div class="row">
                <div class="col-3">';
                    if (strlen($foto)>3) {
                        echo'
                    <div class="row" style="padding-left:10px; padding-bottom:5px;">
                        <img src=../common/uploads/fotosdeperfil/'.$foto.' style="position:absolute;background-color: #fff; border: 1px solid; border-radius: 0.25rem;" width="70%" height="60%">
                    </div>';
                    }
                    echo'
                    <div class="row" style="padding-left:10px;position:absolute;top:62%;">
                        <button type="button" class="btn btn-primary" onclick="window.location.href=\'../edicao_usuario/\'">Editar Perfil</button>
                    </div>';
                    if($_SESSION['NIVEL'] != 2){
                        echo '<div class="row" style="padding-left:10px;position:absolute;top:80%;">
                        <button type="button" class="btn btn-primary" onclick="window.location.href=\'../caracteristicas/visualizar.php?id_atleta='.$_SESSION["ID"].'\'">Visualizar Características</button>
                        </div>';
                    }
                    echo '<div class="row" style="padding-left:10px;position:absolute;top:98%;">
                        <button type="button" class="btn btn-primary" onclick="window.location.href=\'../perfil/alterar_senha.php\'">Alterar Senha</button>
                    </div>
                </div>

                <div class="col-9">
                    <div class="row" style="text-align: center;">
                        <h2>INFORMAÇÕES PRINCIPAIS</h2>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <b>Nome completo</b><p>'.$nome.'</p>
                        </div>
                        <div class="col-6">
                            <b>Data de nascimento</b><p>'.date_format($date,"d/m/Y").'</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <b>E-mail</b><p>'.$email.'</p>
                        </div>
                        <div class="col-6">
                            <b>Celular</b><p>'.$ddd.$numero.'</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <b>RG</b><p>'.$RG.'</p>
                        </div>
                        <div class="col-6">
                            <b>NUSP</b><p>'.$NUSP.'</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <b>Endereço</b><p>'.$endereco.'</p>
                        </div>
                        <div class="col-6">
                            <b>Presença no Semestre</b>
                            <div class="progress" style="height:20px; width:70%;">  
                                <div class="progress-bar '; 
                        if($presenca>=80 and $presenca<100) echo'bg-success'; if($presenca<80 and $presenca>=60) echo'bg-warning'; if($presenca<60) echo 'bg-danger'; 
                        echo '" style="width:'.$presenca.'%; height:20px" >'.number_format($presenca,2).'%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            </div>
                
        ';
            //busca da proxima competicao no banco de dados
            $sql="SELECT evento, nprovas,ordem_provas, data FROM competicoes WHERE data>=CURDATE() ORDER BY data ASC LIMIT 1";
            $res=mysqli_query($con,$sql);
            if($res) $competicao=mysqli_fetch_assoc($res);
            if($competicao){
                $sql="SELECT * FROM "."`".$competicao['evento']."`"." WHERE atleta_id=".$id_usuario; // busca das informacoes refrentes a inscricao na competicao
                $resultado=mysqli_query($con,$sql);
                if($resultado){
                    $inscricao=mysqli_fetch_assoc($resultado);
                    $ordem_provas=explode(" ",$competicao['ordem_provas']);
                    $inscricoes="";
                    foreach($ordem_provas as $prova){ //percorre a inscricao e verifica as provas com tempo de balizamento
                        if(strlen($inscricao[$prova])>1) $inscricoes.= '<b>'.str_replace("_"," ",$prova).": </b>".$inscricao[$prova].'<br>';
                    }
                }
            }
            echo '
            <div class="container_presenca_perfil padi">
                <div class="col" style="line-height:20px;"> 
                    <h1 style="margin-bottom:10px;">Próxima Competição</h1>'; 
                    if($competicao) {
                        $data = date_format(date_create($competicao['data']),"d/m");
                        echo'<a style="color:rgb(36, 43, 86)" href="../inscricao_competicao/index.php?competicao='.$competicao['evento'].'"><h2 style="color:rgb(36, 43, 86); margin:0;">'.$competicao['evento'].' - '.$data.' </h2></a><hr style="margin:3px;" >';
                        if(strlen($inscricoes)>1) echo $inscricoes;
                        else echo '<strong style="color:rgb(161, 12, 42)">Você ainda não se inscreveu!</strong>';
                    }
                    else echo 'Não há próximas competições previstas no calendário.';
                    echo '
                 </div>
            </div>';

            $divida_total=0;
            $tabela = "<tr>";
            $sql2= "SELECT valor, descricao, data_criacao FROM `financeiro` WHERE `id_devedor`=".$id_usuario." AND status='NP' ORDER BY data_criacao DESC;";
            $resultado=mysqli_query($con,$sql2);
            $k=0;
            while($res = mysqli_fetch_assoc($resultado)){
                $valor = $res['valor'];
                $divida_total += $valor;
                $date = date_create($res['data_criacao']);
                $descricao = $res['descricao'];
                if($k<4)    $tabela .= '<td>'.date_format($date,"d/m/Y").'</td><td>'.$descricao.'</td><td>R$'.number_format($valor,2).'</td></tr>';                     
                $k+=1;
            };
            echo '
            <div class="container_dividas_perfil padi"> 
                    <h1 style="margin:0;">Dívida: R$'.number_format($divida_total,2).'</h1>
                    
                <hr style="margin:3px;">
                <table class="tabela_dividas_perfil">
                    <tbody>'.$tabela.'</tbody>
                </table>
            </div>';    
            

            echo '<div class="container_contagem padi">
                <h1>Contagem Regressiva</h1>
                    <table style="width: 0%;height: 50%;overflow: auto;margin: auto;position: relative;top: 0;left: 0;bottom: 0;right: 0;">';
            $sql3 = "SELECT `data`, `descricao` FROM `contagem` WHERE `data` > SYSDATE() ORDER BY `data` LIMIT 1;";
            $res = mysqli_query($con, $sql3);
            $hoje = new DateTime();
            $hoje -> setTime(0, 0, 0);
            while($vet = mysqli_fetch_array($res)){
                $data = $vet[0];
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
                }
                //echo'<table><tr><td class="cont_txt"><strong>INTERUSP</strong></td><td class="contagem" id="contagem'.$ano.$mes.$dia.'"><script>contagem('.$ano.', '.$mes.', '.$dia.')</script></td></tr></table></div>';    
                echo'<tr><td class="cont_txt"><strong>'.$vet[1].'</strong></td></tr><tr><td class="contagem" id="contagem'.$ano.$mes.$dia.'"><script>contagem('.$ano.', '.$mes.', '.$dia.')</script></td></tr><tr class="space"><td class="space"></td><td class="space"></td></tr>';    
            }
            echo'</table></div>';
        ?>
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