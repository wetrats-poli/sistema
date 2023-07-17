<?php
session_start();
// Conexão com o servidor MySQL
$con = mysqli_connect("srv976.hstgr.io", "u418844475_wtr", "Wetrats2019", "u418844475_wtr");
    
// pega algumas informacoes ja do usuario
$sql="SELECT nome, email, celular FROM `usuarios` WHERE id=".$_SESSION['ID'];
$resultado = mysqli_query($con,$sql);
$usuario = mysqli_fetch_assoc($resultado);

$data['token'] ='c6ad32ee-b692-425e-867d-cb76a3208c5ac8ab4ec54680b630993ad58c92578930e445-aab7-4e22-9b89-4116a034340f';
$data['email'] = 'anapisani.freitas@gmail.com';
$data['currency'] = 'BRL';
$data['itemId1'] = '1';
$data['itemQuantity1'] = '1';
$data['itemDescription1'] = 'Caixinha Wetrats';
$data['itemAmount1'] = "'".number_format($_GET['valor'],2)."'";
$data['senderName'] = $usuario['nome'];
if(strlen($usuario['email']>5)){
    $data['senderEmail'] = $usuario['email'];
}
$celular=str_replace("(","",$usuario['celular']);
$celular=str_replace(")","",$celular);
$celular=str_replace(" ","",$celular);
$celular=str_replace("-","",$celular);
$celular=str_replace("+","",$celular);
if (substr($celular,0,2)=="55") $celular=substr($celular,0,2);
$ddd=substr($celular,0,2);
$numero=substr($celular,2);
$data['senderAreaCode'] = $ddd;
$data['senderPhone']= $numero;
//$data['senderCanEditPhone'] = "true";

$data['shippingAddressRequired'] = "false" ;

//$data['paymentMethodGroup1'] = "BOLETO" ;
//$data['paymentMethodConfigKey1_1'] = "DISCOUNT_PERCENT" ;
//$data['paymentMethodConfigValue1_1'] = 3.38 ;


$url = 'https://ws.pagseguro.uol.com.br/v2/checkout';

$data = http_build_query($data);

$curl = curl_init($url);

curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
$xml= curl_exec($curl);

curl_close($curl);

$xml= simplexml_load_string($xml);
if(count($xml -> error) > 0){
    $return = 'Dados Inválidos '.$xml ->error-> message;
    echo $return;
    exit;
    }
if($xml == 'Unauthorized'){
    $return = 'Não Autorizado';
    echo $return;
    exit;
    }


echo $xml -> code;


?>