<?php
    require_once '../db_con.php';
    function contEquipe(){
        $sql = "SELECT `descricao`, `data` FROM `contagem` WHERE `equipe` = 1 AND `data` > SYSDATE();";
        $res = mysqli_query($con, $sql);
        echo '<tbody>'; 
        while($vet = mysqli_fetch_array($res)){
            $data = $vet[1];
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

            echo '<tr class="cont_equipe"><td class="cont_txt">'.$vet[0].'</td><td class="contagem" id="contagem'.$ano.$mes.$dia.'"><script>contagem('.$ano.', '.$mes.', '.$dia.')</script></td></tr><tr class="space"><td class="space"></td><td class="space"></td></tr>';
        }
        echo '</tbody>';
    }

    function contIndiv($id){
        $sql = "SELECT `descricao`, `data` FROM `contagem` WHERE  `data` > SYSDATE() AND `id_usuario`=".$id;
        $res = mysqli_query($con, $sql); 
        echo '<tbody>';
        while($vet = mysqli_fetch_array($res)){
            $data = $vet[1];
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

            echo '<tr class="cont_indiv"><td class="cont_txt">'.$vet[0].'</td><td class="contagem" id="contagem'.$ano.$mes.$dia.'"><script>contagem('.$ano.', '.$mes.', '.$dia.')</script></td></tr><tr class="space"><td class="space"></td><td class="space"></td></tr>';
        }
        echo '</tbody>';
    }    
?>