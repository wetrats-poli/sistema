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
    <title>Wetrats - Competições</title>
    <script src="../common/js/jquery.min.js"></script>
</head>

<body>
<!-----Modal------->
<div class="bg-modal">
    <div class="modal-contents">
        <div class="close" ><a href="#">+</a></div>
        <div class="col">
            <div id ="divDescricao"></div>    
        </div>
    </div>
</div>

<div class="bg-modal" id="modal1">
    <div class="modal-contents">
        <div class="close" id='cls'><a href="#" id='cls1'>+</a></div>
        <div class="col">
            <div id ="divDescricao1">
            <div><h1>Selecione as informações necessárias para o balizamento:<h1></div>
                <form>
                    <label for="rg"><input type="checkbox" id="rg" name="dados" value="rg">RG</label>
                    <label for="nusp"><input type="checkbox" id="nusp" name="dados" value="nusp">NUSP</label>
                    <label for="email"><input type="checkbox" id="email" name="dados" value="email">E-Mail</label>
                    <label for="tel"><input type="checkbox" id="tel" name="dados" value="tel">Telefone</label>
                    <label for="aniv"><input type="checkbox" id="aniv" name="dados" value="aniv">Data de Nascimento</label>
                    <script>
                    $("input[id='rg']").on('click', function(){
                        if ($("input[id='rg']").prop("checked")){
                            var href = $("#blz_btn").attr("href");
                            href = href.replace("&rg=false", "&rg=true");
                            $("#blz_btn").attr("href", href);
                        } else {
                            var href = $("#blz_btn").attr("href");
                            href = href.replace("&rg=true", "&rg=false");
                            $("#blz_btn").attr("href", href);
                        }
                    });
                    $("input[id='nusp']").on('click', function(){
                        if ($("input[id='nusp']").prop("checked")){
                            var href = $("#blz_btn").attr("href");
                            href = href.replace("&nusp=false", "&nusp=true");
                            $("#blz_btn").attr("href", href);
                        } else {
                            var href = $("#blz_btn").attr("href");
                            href = href.replace("&nusp=true", "&nusp=false");
                            $("#blz_btn").attr("href", href);
                        }
                    });
                    $("input[id='email']").on('click', function(){
                        if ($("input[id='email']").prop("checked")){
                            var href = $("#blz_btn").attr("href");
                            href = href.replace("&email=false", "&email=true");
                            $("#blz_btn").attr("href", href);
                        } else {
                            var href = $("#blz_btn").attr("href");
                            href = href.replace("&email=true", "&email=false");
                            $("#blz_btn").attr("href", href);
                        }
                    });
                    $("input[id='tel']").on('click', function(){
                        if ($("input[id='tel']").prop("checked")){
                            var href = $("#blz_btn").attr("href");
                            href = href.replace("&tel=false", "&tel=true");
                            $("#blz_btn").attr("href", href);
                        } else {
                            var href = $("#blz_btn").attr("href");
                            href = href.replace("&tel=true", "&tel=false");
                            $("#blz_btn").attr("href", href);
                        }
                    });
                    $("input[id='aniv']").on('click', function(){
                        if ($("input[id='aniv']").prop("checked")){
                            var href = $("#blz_btn").attr("href");
                            href = href.replace("&aniv=false", "&aniv=true");
                            $("#blz_btn").attr("href", href);
                        } else {
                            var href = $("#blz_btn").attr("href");
                            href = href.replace("&aniv=true", "&aniv=false");
                            $("#blz_btn").attr("href", href);
                        }
                    });
                    </script>
                </form>
                <div><a id="blz_btn" class="btn-primary" href="./balizamento.php?nome=" onclick="setTimeout(function(){document.getElementById('cls1').click();}, 1000);">Concluir Balizamento</a></div>
            </div>    
        </div>
    </div>
</div>


<div id="page">

<nav class="fh5co-nav" id="menu-list" role="navigation">
    <div id="menu"></div>
</nav>
<div id="menus"></div>
   

<div class="super_container" style="padding-top:60px;">
    
                                    
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
      <div class="container">

          <div class="row">
            <div class="col-12">
              <!-- Inscrições abertas -->
                <div class="row">
                    <div class="section_title_container col-12">
                      <div class="section_title light" ><h1>Inscrições abertas</h1></div>
                    </div>
                  <?php
        if ($nivel_usuario == "3"){
            echo    '<div class="col-auto align-self-end">
                        <a href="../criacao_competicao/"><button type="button" class="btn btn-primary">Incluir competição</button></a>
                     </div>';
        }
        ?>
                </div>
                <div class="custom_list_a">
                    <ul>

<?php

// Conexão com o servidor MySQL
require_once '../db_con.php';

// Busca das informações referentes ao usuário
$sql =  "SELECT id, evento, data, local FROM competicoes WHERE ativo = '1' ORDER BY data ";
$competicoes = mysqli_query($con, $sql);
$n=0;

while ($competicao = mysqli_fetch_array($competicoes)){
    $id=$competicao['id'];  
    $evento = $competicao['evento'];
    $data = $competicao['data'];
    $local = $competicao['local'];
    $date=date_create($data);

    echo '<div class="row form-group">
        <li class="d-flex flex-row align-items-center justify-content-start col_wdth">
                <div class="custom_list_title_container">
                    <div class="custom_list_title"><a href="../inscricao_competicao/?competicao='.$evento.'">'.$evento.'</a></div>
                    <div class="custom_list_date">'.date_format($date,"d/m/Y").' - '.$local.'</div> 
                </div>
                <div style="margin-left:50px;" class="custom_list_link ml-auto"><a href="../inscricao_competicao/?competicao='.$evento.'"><button type="button" class="btn btn-primary">'; if($nivel_usuario=="1") echo 'Inscreva-se'; else echo 'Inscrições'; echo'</button></a></div>
          </li>' ;
    if ($nivel_usuario=="3") {
        $evento_url=str_replace(" ","+",$evento);
        echo '  <div class="w-100 d-none d-md-block"></div>
                <div><a href="./fechar_inscricao.php?id='.$id.'"><button type="button" class="btn-primary">Fechar Inscrição</button></a></div>
                <div><button id="'.$n.'" class="treino btn-primary" onclick="exibe(this.id)"
    
                value="<div><h1>Deletar competição: '.$evento.' ? <h1></div>
                <div><a class=btn-danger href=./deletar_competicao.php?id='.$id.'&evento='.$evento_url.'>Deletar</a></div>" 
                
                href="#" type="button">Deletar</button></div>
                
                <div><a href="./editar_competicao.php?id='.$id.'"`><button class="btn-primary">Editar</button></a></div> 

                <div><button id=" '.$evento.'" class="treino btn-primary" onclick="exibe1(this.id)" href="#" type="button">Balizamento</button></div>

              ' ; 
        $n+=1;
}
 echo'</div>';
}
?>

            </ul>
        </div>


        <!-- Resultados -->
        <div class="row">
                <div class="section_title_container">
                    <div class="col-12"><div class="section_title light" style="margin-top:50px"><h1>Histórico de competições</h1></div>
                </div></div>

        <?php 
        if ($nivel_usuario == "3"){
        echo '
                <div style="padding-top:30px; padding-left:50px;">
                    <a href="./upload_resultado.php"><button type="button" class="btn btn-primary">Adicionar resultado</button></a>
                </div>' ;
                  }
        ?>
        </div>

                  <div class="custom_list_a">
                      <ul> 
<?php
// Busca das informações referentes ao usuário
$sql =  "SELECT id, evento, data, local, resultado FROM competicoes WHERE ativo = '0' ORDER BY data DESC ";
$competicoes = mysqli_query($con, $sql);

while ($competicao = mysqli_fetch_array($competicoes)){
    $id=$competicao['id'];
    $evento = $competicao['evento'];
    $data = $competicao['data'];
    $local = $competicao['local'];
    $resultado = $competicao['resultado'];
    $date=date_create($data);
    
    echo '<div class="row" style="margin-top:5px;">
    <li class="d-flex flex-row align-items-center justify-content-start col_wdth">
                <div class="custom_list_title_container">
                    <div class="custom_list_title"><a href="./index.php">'.$evento.'</a></div>
                    <div class="custom_list_date">'.date_format($date,"d/m/Y").' - '.$local.'</div>
                </div>';
                if(strlen($resultado)>3){
                echo '<div class="custom_list_link ml-auto"><button type="button" class="btn btn-primary" onclick="window.location.href='."'../common/uploads/resultados/".$resultado."'".'"'.' download="'.$resultado.'">Resultado</button></div>';}
                if (($nivel_usuario=="3") && (strtotime($data) > time()) ) echo '<div class="custom_list_link ml-auto"><a href="./abrir_inscricao.php?id='.$id.'"><button type="button" class="btn btn-primary">Abrir Inscrição</button></a></div>';
        echo '</li>' ;
        if (($nivel_usuario=="3") && (strtotime($data) > time()) ) echo '<div><a href="./cobrar_competicao.php?id='.$id.'"><button type="button" class="btn-primary">Cobrar Inscrição</button></a></div>'; 
        echo '</div>';
    }

?>                         
                
                      
            </ul>
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
<script src="../common/js/balizamento.js"></script>
</body>
</html> 