<html lang="pt-BR">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
    <link rel="stylesheet" href="../common/stylesheets/bootstrap.css">
    <link rel="stylesheet" href="../common/stylesheets/bootstrap4.css">
    <link rel="stylesheet" href="../common/stylesheets/animate.css">
    <link rel="stylesheet" href="../common/stylesheets/style.css">
    <link rel="stylesheet" href="../common/stylesheets/style1.css">
    <link rel="icon" type="image/png" href="../common/images/favicon-32x32.png" sizes="32x32" />
    <title>Wetrats - Performance</title>
</head>

<?php
 //Inicia uma sessão
  session_start();
  // Conexão com o servidor MySQL
  require_once '../db_con.php';
  // Verifica se existe ID da sessão
  if(!isset($_SESSION['ID'])){
    //Destrói a sessão por segurança
    session_destroy();
    //Redireciona para o login
    header("Location: ../index.php"); exit;
    }
  $id_usuario = $_SESSION['ID'];
  $nome_usuario = $_SESSION['NOME'];
  $apelido_usuario= $_SESSION['APELIDO'];
  $nivel_usuario = $_SESSION['NIVEL'];
?>

<body>
<div id="page">
<nav class="fh5co-nav" id="menu-list" role="navigation">
    <div id="menu"></div>
</nav>
<div id="menus"></div>
  <div class="container-fluid" style="padding-top:60px;">
    <!----Titulo--->
    <div class="row">
                  <div class="section_title_container col-6">
                      <div class="section_title light" ><h1>Performances</h1></div>
                  </div>
                  <div class="col-4 offset-2">
                    <a href="./gerenciar_performances.php"><button class="btn-primary">Gerenciar performances</button></a>
                  </div>
    </div>
    
    <div class="row">
      <form method="post" action="index.php" class="col-auto">

            <div class="container_form_performance row form-group"> 

            <?php if ($nivel_usuario != 1){

                $sql = "SELECT id, nome, apelido FROM `usuarios` WHERE ativo=1 AND nivel!=2 ORDER BY apelido;" ;
                $resultado = mysqli_query($con, $sql);

                echo '<div class="col-2.5">       
                <label for="atleta"><b>Atleta</b></label>
                    <select class="form-control" name="atleta">';
                while ($res = mysqli_fetch_assoc($resultado)){
                    $id_atleta = $res['id'];
                    $nome_atleta = $res['nome'];
                    $apelido = $res['apelido'];
                    
                    $html = '<option value="'.$id_atleta."/".$nome_atleta.'"';
                    if($_POST['atleta'] == $id_atleta."/".$nome_atleta ) $html.= 'selected';
                    $html.= ">".$apelido.'</option>';
                    echo $html;
                    }
                echo '
                        <option value="Todos"'; if($_POST['atleta']=="Todos") echo "selected"; echo '>Todos</option>
                    </select>
                </div>';
                }
            ?>
            
            <div class="col-3">
            <div style="padding-top:5px;">
                
                <input style="position: relative;" class="form-check-input" type="radio" name="tipo" id="gridRadios1" value="Tiro" <?php if($_POST['tipo'] == 'Tiro') echo 'checked';?> >
                <label style="padding-bottom:4px;" class="form-check-label" for="gridRadios1">Tiro</label>
                
            </div>
            <div style="padding-top:5px;">
                
                <input style="position: relative;" class="form-check-input" type="radio" name="tipo" id="gridRadios2" value="BT" <?php if($_POST['tipo'] == 'BT') echo 'checked';?>>
                <label style="padding-bottom:4px;" class="form-check-label" for="gridRadios2">BT</label>
                
            </div>
            <div style="padding-top:5px;">
                
                <input style="position: relative;" class="form-check-input" type="radio" name="tipo" id="gridRadios3" value="Melhor media" <?php if($_POST['tipo'] == 'Melhor media') echo 'checked';?>>
                <label style="padding-bottom:4px;" class="form-check-label" for="gridRadios3">Melhor média</label>
                
            </div>
            </div>

            <div class="col-<?php if($nivel_usuario!='1') echo '2.5'; else echo '3'; ?>">       
                <label for="estilo"><b>Estilo</b></label>
                    <select class="form-control" name="estilo">
                        <option value="Borboleta" <?php if($_POST['estilo'] == 'Borboleta') echo 'selected';?>>Borboleta</option>
                        <option value="Costas" <?php if($_POST['estilo'] == 'Costas') echo 'selected';?> >Costas</option> 
                        <option value="Peito" <?php if($_POST['estilo'] == 'Peito') echo 'selected';?> >Peito</option>
                        <option value="Livre" <?php if($_POST['estilo'] == 'Livre') echo 'selected';?> >Livre</option>
                        <option value="Medley" <?php if($_POST['estilo'] == 'Medley') echo 'selected';?> >Medley</option>
                    </select>
            </div>

            <div class="col-<?php if($nivel_usuario!='1') echo '2'; else echo '3'; ?>">       
                <label for="metragem"><b>Metragem</b></label>
                <input class="form-control" type="number" name="metragem" <?php if(isset($_POST['metragem'])) echo 'value="'.$_POST['metragem'].'"'; ?> required>
            </div>

          <div style="padding-top:40px;" class="col-<?php if($nivel_usuario!='1') echo '3'; else echo '3'; ?>">   
            <button type="submit" class="btn btn-primary" name="finalizado" value="1">Ok!</button>
          </div>

        </div>
    </div>
  </form>
  
  <?php if (($_POST['finalizado']=="1")){ echo'
    <div class="row" style="text-align: center; padding-top:30px;">
          <div class="col-12">
                  <div class="section_title_container">
                      <div class="section_title light" ><h1>Evolução temporal</h1></div>
                  </div>
          </div>
    </div>
    
    <div id="chart_div_Tiro" style="width: 80%; height: 60%; margin:auto; margin-bottom:90px;"></div>
    <div id="chart_div_Todos" style="width: 80%; height: 60%; margin:auto; margin-bottom:90px;"></div>
    <div id="chart_div_bt" style="width: 80%; height: 60%; margin:auto; margin-bottom:90px;"></div>
    <div id="chart_div_mm" style="width: 80%; height: 60%; margin:auto; margin-bottom:90px;"></div>';
    }
    ?>
  </div>
</div>


<?php
if (($_POST['finalizado']=="1")){

    $tipo = $_POST['tipo'];
    
    if ($nivel_usuario != 1){
        $atleta= explode("/", $_POST['atleta']);
        $id_atleta = $atleta[0];
        $nome_atleta = $atleta[1];
        if($_POST['atleta']=="Todos") $tipo = "Todos";
    }
    else {
        $id_atleta = $id_usuario;
        $nome_atleta = $nome_usuario;
    }

    
    $estilo= $_POST['estilo'];
    $metragem= $_POST['metragem'];
    $prova= $metragem." ".$estilo;

    // Busca das informações referentes a performance
    if ($_POST['tipo'] == 'Tiro'){

        if ($_POST['atleta'] == "Todos"){
        
            $sql = "SELECT GROUP_CONCAT(CONCAT(usuarios.apelido ,':', resultados_treinos.tempo) SEPARATOR ',' ) AS 'tempos' , treinos.data AS 'data' 
                    FROM `resultados_treinos` 
                    INNER JOIN `treinos` ON resultados_treinos.id_treino = treinos.id 
                    INNER JOIN `usuarios` ON resultados_treinos.id_atleta = usuarios.id 
                    WHERE resultados_treinos.tipo='Tiro' AND estilo="."'".$estilo."'".' AND metragem='."'".$metragem."'"." 
                    UNION ALL 
                    SELECT GROUP_CONCAT(CONCAT(usuarios.apelido ,':', resultados_pessoais.tempo) SEPARATOR ',' ) AS 'tempos' , `data` AS 'data' 
                    FROM `resultados_pessoais` 
                    INNER JOIN `usuarios` ON resultados_pessoais.id_atleta = usuarios.id
                    WHERE estilo='".$estilo."' AND metragem=".$metragem."
                    GROUP BY `data` 
                    ORDER BY `data` ASC ;" ;

            $resultado = mysqli_query($con, $sql);

            $i=0;
            $j=0;
            $datas = array();
            $atletas = array();
            while ($res = mysqli_fetch_assoc($resultado)){
                $datas[] = $res['data'];
                $i+=1;
                $dados = explode("," , $res['tempos']); //separo os atletas
                foreach($dados as $atleta){
                    $atleta = explode(":", $atleta); //separo o tempo do apelido do atleta
                    $tempo = 0.0 ;
                    $apelido = $atleta[0];
                    if (substr_count($atleta[1] , "'")>0){
                        $minutos = explode("'",$atleta[1]);
                        $tempo += (60 * floatval($minutos[0]));
                        $resto = str_replace('"','.',$minutos[1]);
                        $tempo += floatval($resto);
                    }
                    else {
                        $resto = str_replace('"','.',$atleta[1]);
                        $tempo += floatval($resto);
                    }
                    if (!in_array($apelido,$atletas)){
                        $atletas[$j] = $apelido;
                        $j+=1;
                    }
                    $datas[$res['data']][$apelido] = $tempo ; //atribuo à data, indexada pelo apelido, o tempo do atleta

                }
            }

            $colunas = ""; 
            foreach ($atletas as $atleta){
                if (strlen($atleta)>1) $colunas .= "data.addColumn('number', '".$atleta."');";
            }
            
            $rows ="[";
            //passagem das informações pro rows
            $k=$i;
            for ($i =0 ; $i < $k ; $i++) {
                $rows .= "[new Date('".$datas[$i]."') ,"; 
                foreach($atletas as $atleta){ 
                    if (strlen($atleta)>1) {
                        if(strlen($datas[$datas[$i]][$atleta])>0) $rows .= $datas[$datas[$i]][$atleta].",";
                    
                        else $rows .= 'null ,';
                    }
                }
                $rows = substr($rows,0,-1);
                $rows .= "],";
            }
            $rows = substr($rows,0,-1);
            $rows .= "]";


        }

        else {
        $sql =  "SELECT  treinos.data AS 'data' , tempo, 'Treino' AS competicao , 'Outros' AS 'categoria' FROM resultados_treinos
                INNER JOIN `treinos` ON resultados_treinos.id_treino= treinos.id  
                WHERE resultados_treinos.tipo='Tiro' AND id_atleta=".$id_atleta." AND estilo="."'".$estilo."' AND metragem='".$metragem."' 
                UNION ALL 
                SELECT data , tempo, competicao, 'Oficial' AS 'categoria' FROM `ranking` 
                WHERE nome_atleta ='".$nome_atleta."' AND prova='".$prova."'
                UNION ALL
                SELECT data , tempo, evento AS 'competicao' , 'Outros' AS 'categoria' FROM `resultados_pessoais` 
                WHERE id_atleta=".$id_atleta ." AND estilo="."'".$estilo."' AND metragem=".$metragem." 
                ORDER BY `data` ASC ;" ;
        
        $resultado = mysqli_query($con, $sql);
        
        $i=0;
        $datas= array();
        $tempos= array();
        $eventos= array();
        $categoria= array();
        while ($res = mysqli_fetch_assoc($resultado)){
            $datas[$i] = $res['data'];
            $tempo = 0.0 ;
            $tmp=str_replace("..",'"',$res['tempo']);
            $tmp=str_replace(".","'",$tmp);
            $eventos[$i]= $res['competicao']." - ".$tmp;
            if (substr_count($tmp , "'")>0){
                $minutos = explode("'",$tmp);
                $tempo += (60 * floatval($minutos[0]));
                $resto = str_replace('"','.',$minutos[1]);
                $tempo += floatval($resto);
            }
            else {
                $resto = str_replace('"','.',$tmp);
                $tempo += floatval($resto);
            }
            $tempos[$i] = $tempo;

            if ($res['categoria'] =='Outros'){
                $categoria[$i]= '1';
            }
            else $categoria[$i]= 'null';
            
            $i+=1;
        }
    }
    }

    if ($_POST['tipo'] == 'BT'){

        if ($_POST['atleta'] == "Todos"){
        
            $sql = "SELECT GROUP_CONCAT(CONCAT(usuarios.apelido ,':', resultados_treinos.bracadas,':',resultados_treinos.tempo) SEPARATOR ',' ) AS 'bt' , treinos.data AS 'data' 
                    FROM `resultados_treinos` 
                    INNER JOIN `treinos` ON resultados_treinos.id_treino = treinos.id 
                    INNER JOIN `usuarios` ON resultados_treinos.id_atleta = usuarios.id 
                    WHERE resultados_treinos.tipo='BT' AND estilo="."'".$estilo."'".' AND metragem='."'".$metragem."'"." 
                    GROUP BY `data` 
                    ORDER BY `data` ASC ;" ;

            $resultado = mysqli_query($con, $sql);

            $i=0;
            $j=0;
            $datas = array();
            $atletas = array();
            while ($res = mysqli_fetch_assoc($resultado)){
                $datas[] = $res['data'];
                $i+=1;
                $dados = explode("," , $res['bt']); //separo os atletas
                foreach($dados as $atleta){
                    $atleta = explode(":", $atleta); //separo o tempo do apelido do atleta
                    $total = intval($atleta[1]) + intval($atleta[2]) ;
                    $apelido = $atleta[0];
                    if (!in_array($apelido,$atletas)){
                        $atletas[$j] = $apelido;
                        $j+=1;
                    }
                    $datas[$res['data']][$apelido] = $total ; //atribuo à data, indexada pelo apelido, o bt do atleta

                }
            }

            $colunas = ""; 
            foreach ($atletas as $atleta){
                if (strlen($atleta)>1) $colunas .= "data.addColumn('number', '".$atleta."');";
            }
            
            $rows ="[";
            //passagem das informações por rows
            $k=$i;
            for ($i =0 ; $i < $k ; $i++) {
                $rows .= "[new Date('".$datas[$i]."') ,"; 
                foreach($atletas as $atleta){ 
                    if (strlen($atleta)>1) {
                        if(strlen($datas[$datas[$i]][$atleta])>0) $rows .= $datas[$datas[$i]][$atleta].",";
                    
                        else $rows .= 'null ,';
                    }
                }
                $rows = substr($rows,0,-1);
                $rows .= "],";
            }
            $rows = substr($rows,0,-1);
            $rows .= "]";


        }

        else{
            $sql =  "SELECT  treinos.data AS 'data' , tempo , bracadas FROM resultados_treinos
                    INNER JOIN `treinos` ON resultados_treinos.id_treino= treinos.id  
                    WHERE resultados_treinos.tipo='BT' AND id_atleta=".$id_atleta." AND estilo='".$estilo."' AND metragem='".$metragem."' ORDER BY data ASC ;" ;
            $resultado = mysqli_query($con, $sql);
        
            $i=0;
            $datas= array();
            $tempos= array();
            $bracadas= array();
            $total= array();
            while ($res = mysqli_fetch_assoc($resultado)){
                $datas[$i] = $res['data'];
                $bracadas[$i] = $res['bracadas'];
                $tempos[$i] = $res['tempo'];
                $total[$i] = intval($res['tempo']) + intval($res['bracadas']);
                $i+=1;
            }
        }
    }

    if ($_POST['tipo'] == 'Melhor media'){

        if ($_POST['atleta'] == "Todos"){
        
            $sql = "SELECT GROUP_CONCAT(CONCAT(usuarios.apelido ,':', resultados_treinos.tempo) SEPARATOR ',' ) AS 'mm' , treinos.data AS 'data' 
                    FROM `resultados_treinos` 
                    INNER JOIN `treinos` ON resultados_treinos.id_treino = treinos.id 
                    INNER JOIN `usuarios` ON resultados_treinos.id_atleta = usuarios.id 
                    WHERE resultados_treinos.tipo='Melhor media' AND estilo="."'".$estilo."'".' AND metragem='."'".$metragem."'"." 
                    GROUP BY `data` 
                    ORDER BY `data` ASC ;" ;

            $resultado = mysqli_query($con, $sql);

            $i=0;
            $j=0;
            $datas = array();
            $atletas = array();
            while ($res = mysqli_fetch_assoc($resultado)){
                $datas[] = $res['data'];
                $i+=1;
                $dados = explode("," , $res['mm']); //separo os atletas
                foreach($dados as $atleta){
                    $atleta = explode(":", $atleta); //separo o tempo do apelido do atleta
                    $tempo = 0.0 ;
                    $tmp=str_replace("..",'"',$atleta[1]);
                    $tmp=str_replace(".","'",$tmp);
                    if (substr_count($tmp , "'")>0){
                        $minutos = explode("'",$tmp);
                        $tempo += (60 * floatval($minutos[0]));
                        $resto = str_replace('"','.',$minutos[1]);
                        $tempo += floatval($resto);
                    }
                    else {
                        $resto = str_replace('"','.',$tmp);
                        $tempo += floatval($resto);
                    }
                    $apelido = $atleta[0];
                    if (!in_array($apelido,$atletas)){
                        $atletas[$j] = $apelido;
                        $j+=1;
                    }
                    $datas[$res['data']][$apelido] = $tempo ; //atribuo à data, indexada pelo apelido, o tempo do atleta

                }
            }

            $colunas = ""; 
            foreach ($atletas as $atleta){
                if (strlen($atleta)>1) $colunas .= "data.addColumn('number', '".$atleta."');";
            }
            
            $rows ="[";
            //passagem das informações por rows
            $k=$i;
            for ($i =0 ; $i < $k ; $i++) {
                $rows .= "[new Date('".$datas[$i]."') ,"; 
                foreach($atletas as $atleta){ 
                    if (strlen($atleta)>1) {
                        if(strlen($datas[$datas[$i]][$atleta])>0) $rows .= $datas[$datas[$i]][$atleta].",";
                    
                        else $rows .= 'null ,';
                    }
                }
                $rows = substr($rows,0,-1);
                $rows .= "],";
            }
            $rows = substr($rows,0,-1);
            $rows .= "]";


        }

        else{
            $sql =  "SELECT  treinos.data AS 'data' , tempo  FROM resultados_treinos
                    INNER JOIN `treinos` ON resultados_treinos.id_treino= treinos.id  
                    WHERE resultados_treinos.tipo='Melhor media' AND id_atleta=".$id_atleta." AND estilo='".$estilo."' AND metragem='".$metragem."' ORDER BY data ASC ;" ;
            $resultado = mysqli_query($con, $sql);
        
            $i=0;
            $datas= array();
            $tempos= array();
            $total= array();
            while ($res = mysqli_fetch_assoc($resultado)){
                $datas[$i] = $res['data'];
                $tempo = 0.0 ;
                $tmp=str_replace("..",'"',$res['tempo']);
                $tmp=str_replace(".","'",$tmp);
                if (substr_count($tmp , "'")>0){
                    $minutos = explode("'",$tmp);
                    $tempo += (60 * floatval($minutos[0]));
                    $resto = str_replace('"','.',$minutos[1]);
                    $tempo += floatval($resto);
                }
                else {
                    $resto = str_replace('"','.',$tmp);
                    $tempo += floatval($resto);
                }
                $tempos[$i] = $tempo;
                $i+=1;
            }
        }
    }
}
?>
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
    
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <!---Grafico de Tiros--->
    <script type="text/javascript">
        google.load('visualization', '1', {'packages':['corechart']});
        google.setOnLoadCallback(desenhaGrafico<?php if($tipo=="Melhor media") echo 'mm'; else echo $tipo; ?>);

        function desenhaGraficoTiro() {

var data = new google.visualization.DataTable();
data.addColumn('date', 'Data');
data.addColumn('number', 'Tempos com placar eletrônico');
data.addColumn({type: 'string', role: 'tooltip'});
data.addColumn('number', 'Outros')
data.addColumn({type: 'string', role: 'tooltip'});
data.addRows(<?php echo $i ; ?>) 

<?php
//passagem das informações pro js
$k=$i;
for ($i =0 ; $i < $k ; $i++) {?>
    data.setValue(<?php echo $i; ?> , 0 , <?php echo "new Date('".$datas[$i]."')"; ?> );
    data.setValue(<?php echo $i; ?> , 1, <?php if ($categoria[$i] == 'null') echo $tempos[$i]; else echo 'null'; ?> );
    data.setValue(<?php echo $i; ?> , 2, `<?php echo $eventos[$i]; ?>` );
    data.setValue(<?php echo $i; ?> , 3, <?php if ($categoria[$i] == '1') echo $tempos[$i]; else echo 'null'; ?> );
    data.setValue(<?php echo $i; ?> , 4, `<?php echo $eventos[$i]; ?>` );
<?php } ?>

var options = {
    title: '<?php echo $metragem." ".$estilo ; ?>',
    colors: ['#ffbb00' ,'#00002e'],
    pointSize: 10,
    legend: { position: 'bottom' },
    tooltip: { shared: true },
};

document.getElementById('chart_div_bt').style.display = 'none';
document.getElementById('chart_div_Tiro').style.display = 'block';
document.getElementById('chart_div_mm').style.display = 'none';
document.getElementById('chart_div_Todos').style.display = 'none';

var chart = new google.visualization.LineChart(document.getElementById('chart_div_Tiro'));

chart.draw(data, options);
}

        function desenhaGraficoTodos() {

            var data = new google.visualization.DataTable();
            data.addColumn('date', 'Data');
            
            <?php
            if($tipo=="Todos"){
            echo $colunas.'data.addRows('.$rows.');';
            }
            ?>

            var options = {
                title: '<?php echo $metragem." ".$estilo ; ?>',
                pointSize: 10,
                legend: { position: 'bottom' },
            };

            document.getElementById('chart_div_bt').style.display = 'none';
            document.getElementById('chart_div_Tiro').style.display = 'none';
            document.getElementById('chart_div_mm').style.display = 'none';
            document.getElementById('chart_div_Todos').style.display = 'block';

            var chart = new google.visualization.LineChart(document.getElementById('chart_div_Todos'));

            chart.draw(data, options);
                
            
}

        function desenhaGraficoBT() {

            var data = new google.visualization.DataTable();
            data.addColumn('date', 'Data');
            data.addColumn('number', 'Tempo');
            data.addColumn('number', 'Braçadas');
            data.addColumn('number', 'Total');

            data.addRows(<?php echo $i ; ?>) 

            <?php
            //passagem das informações pro js
            $k=$i;
            for ($i =0 ; $i < $k ; $i++) {?>
                data.setValue(<?php echo $i; ?> , 0 , <?php echo "new Date('".$datas[$i]."')"; ?> );
                data.setValue(<?php echo $i; ?> , 1, <?php echo $tempos[$i]; ?> );
                data.setValue(<?php echo $i; ?> , 2, <?php echo $bracadas[$i]; ?> );
                data.setValue(<?php echo $i; ?> , 3, <?php echo $total[$i]; ?> );
            <?php } ?>

            var options = {
                title: "Seus BT's",
                colors: ['#ffbb00', '#00002e','red'],
                pointSize: 10,
                legend: { position: 'bottom' },
            };

            var chart = new google.visualization.LineChart(document.getElementById('chart_div_bt'));

            chart.draw(data, options);

            document.getElementById('chart_div_Tiro').style.display = 'none';
            document.getElementById('chart_div_bt').style.display = 'block';
            document.getElementById('chart_div_mm').style.display = 'none';
            document.getElementById('chart_div_Todos').style.display = 'none';
            }

            function desenhaGraficomm() {

                var data = new google.visualization.DataTable();
                data.addColumn('date', 'Data');
                data.addColumn('number', 'Tempo');

                data.addRows(<?php echo $i ; ?>) 

                <?php
                //passagem das informações pro js
                $k=$i;
                for ($i =0 ; $i < $k ; $i++) {?>
                    data.setValue(<?php echo $i; ?> , 0 , <?php echo "new Date('".$datas[$i]."')"; ?> );
                    data.setValue(<?php echo $i; ?> , 1, <?php echo $tempos[$i]; ?> );
        
                <?php } ?>

                var options = {
                    title: "Suas séries",
                    colors: ['#ffbb00'],
                    pointSize: 10,
                    legend: { position: 'bottom' },
                };

                var chart = new google.visualization.LineChart(document.getElementById('chart_div_mm'));

                chart.draw(data, options);

                document.getElementById('chart_div_Tiro').style.display = 'none';
                document.getElementById('chart_div_bt').style.display = 'none';
                document.getElementById('chart_div_mm').style.display = 'block';
                document.getElementById('chart_div_Todos').style.display = 'none';
                }
        
    </script>
    


</body>
</html>
