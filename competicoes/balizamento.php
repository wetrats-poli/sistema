<?php
    ob_start();
    $comp = $_GET['nome'];
        
    require_once '../db_con.php';
    $sql = "SELECT * FROM `$comp` ORDER BY sexo ASC, nome_atleta";
    $res = mysqli_query($con, $sql);

    $output = '<table><tr><th>Nome</th>';
    $var = '';
    if($_GET['rg']){
        $var .= ', RG';
        $output .= '<th>RG</th>';
    }
    if($_GET['nusp']){
        $var .= ', NUSP';
        $output .= '<th>NUSP</th>';
    }
    if($_GET['email']){
        $var .= ', email';
        $output .= '<th>E-Mail</th>';
    }
    if($_GET['tel']){
        $var .= ', celular';
        $output .= '<th>Telefone</th>';
    }
    if($_GET['aniv']){
        $var .= ', aniversario';
        $output .= '<th>Data de Nascimento</th>';
    }
    $z=0;
    while($fieldinfo = mysqli_fetch_field($res)){
        if($z>=3){
            $output .= '<th>'.str_replace("_", " ", $fieldinfo->name).'</th>';
        }
        $z++;
    }
    $output .= '</tr>';

    while($vet = mysqli_fetch_row($res)){
        $id = $vet[0];
        $output .= '<tr>';
        $nsql = 'SELECT nome'.$var.' FROM usuarios WHERE id='.$id;
        $nres = mysqli_query($con, $nsql);
        while($nvet = mysqli_fetch_row($nres)){
            for($i=0; $i<mysqli_num_fields($nres); $i++){
                $output .= '<td>'.$nvet[$i].'</td>';
            }
        }
        for($j=3; $j<mysqli_num_fields($res); $j++){
            $output .= '<td>'.$vet[$j].'</td>';
        }
        $output .= '</tr>';
    }
    $output .= '</table>';
    echo($output);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="Balizamento'.$comp.'.xls";');
    ob_end_flush();
?>
