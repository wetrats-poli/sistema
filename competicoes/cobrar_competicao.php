<?php
ob_start();

session_start();
$id_competicao=$_GET['id'];

//aquisicao das informacoes principais da competicao a qual tera suas cobranças lançadas
$con = mysqli_connect("auth-db213.hstgr.io", "u418844475_wtr", "Wetrats2019", "u418844475_wtr");
$sql= "SELECT evento, valor, tipo_inscricao, nprovas FROM `competicoes` WHERE id=".$id_competicao ;
$resultado = mysqli_query($con,$sql);
$competicao= mysqli_fetch_array($resultado);
$evento = $competicao['evento'];
$valor = $competicao['valor'];
$tipo_inscricao = $competicao['tipo_inscricao'];
$nprovas= $competicao['nprovas'];

$ids_atletas= array();
$atletas= array();
$valores= array();

//aquisicao das informacoes referentes as incricoes de cada atleta na competicao
$sql="SELECT * FROM "."`".$evento."`";
$resultado = mysqli_query($con,$sql);
while($atleta = mysqli_fetch_array($resultado)){
    $ids_atletas[]=$atleta[0];
    $atletas[]=$atleta[1];
    $flag=0;
    $divida=0;
    $i = 3;
    $n = $i+$nprovas;
    while($i<$n){
        if(strlen($atleta[$i])>0){
            $divida += intval($tipo_inscricao) * $valor;
            $flag=1;
        }
        $i += 1;
    }
    if($tipo_inscricao=="1") $valores[]=$divida;
    else $valores[] = $valor * $flag;

}

//lançamento das cobranças
$sql = "INSERT INTO financeiro (id_devedor,valor,descricao,status, data_criacao) VALUES ";
$i=0;
$data=date("Y-m-d");
foreach ($ids_atletas as $id){
    $nome_devedor = $atletas[$i];
    $divida = $valores[$i];
    if($divida > 0) $sql .= "('".$id."','".$divida."','".$evento."','NP','".$data."' )," ;
    $i+=1;
  }
  $sql = substr($sql, 0, -1);
  $sql .= ";" ;
  if (!mysqli_query($con,$sql))
  {
    $_SESSION['ALERTA'] .= "Error description: ".mysqli_error($con);
  }
  
  else {
    $_SESSION['MSG'] = "As cobranças referentes às inscrições em:".$evento." foram lançadas com sucesso.";

  //configuraçoes para o envio de emails
  //$headers  = 'MIME-Version: 1.0' . "\r\n";
  //$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
  //$headers .= 'From: contato@ecoswim.com.br' ;

  //$sql="SELECT email FROM usuarios WHERE id=".$ids_atletas[0];
  //foreach($ids_atletas)
  //envia um email para cada usuario que receber o lançamento de uma cobrança
 // foreach ($ids_cobrados as $i){
  //    $email_devedor = $emails[$i];
    //  $nome_devedor = $usuarios[$i];
      //$assunto = "Cobrança:  "."$descricao";
      //$mensagem = "Olá "."$nome_devedor"."! \n Foi adicionada uma cobrança em seu nome no valor de : "."$valor"." ; referente a:"."$descricao";
      //if(!mail($email_devedor,$assunto,$mensagem,$headers)){
        //  $_SESSION['ALERTA'] .= "Falha no envio do email para: "."$email_devedor";         
      //}
  
    //}
    //echo "<div id='meta'><meta http-equiv='refresh' content='1'></div>";
    //echo "<script>$(window).on('load', function(){ $('#meta').empty(); $(window.document.location).attr('href', '../financeiro/');});</script>";
   header("Location: ../financeiro/index.php"); exit;
    }
  ob_end_flush();
?>