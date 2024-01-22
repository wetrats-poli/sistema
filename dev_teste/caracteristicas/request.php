<?php
    if(isset($_GET['id'])){
        $id = $_GET['id'];

        require_once '../db_con.php';
        $sql = "SELECT forc, vel, res_ae, res_ana, tg, ee, est1, cb1, pr1, br1, tr1, qd1, co1, sa1, vr1, ch1, est2, cb2, pr2, br2, tr2, qd2, co2, sa2, vr2, ch2 FROM caracteristicas2020 WHERE id_atleta=$id AND tipo=2";
        $resultado = mysqli_query($con, $sql);

        $res = mysqli_fetch_assoc($resultado);

        
        $return = "$('#for').attr('value', ".$res['forc'].").change(); ";
        $return .= "$('#vel').attr('value', ".$res['vel'].").change(); ";
        $return .= "$('#res_ae').attr('value', ".$res['res_ae'].").change(); ";
        $return .= "$('#res_ana').attr('value', ".$res['res_ana'].").change(); ";
        $return .= "$('#tg').attr('value', ".$res['tg'].").change(); ";
        $return .= "$('#ee').attr('value', ".$res['ee'].").change(); ";
        
        if($res['est1'] == 'Livre'){
            $return .= "$('#lv1').attr('selected', 'selected').change(); ";
        } else if($res['est1'] == 'Costas'){
            $return .= "$('#co1').attr('selected', 'selected').change(); ";
        } else if($res['est1'] == 'Borboleta'){
            $return .= "$('#bo1').attr('selected', 'selected').change(); ";
        } else if($res['est1'] == 'Peito'){
            $return .= "$('#pe1').attr('selected', 'selected').change(); ";
        }
        

        $return .= "$('#cb1').attr('value', ".$res['cb1'].").change(); ";
        $return .= "$('#pr1').attr('value', ".$res['pr1'].").change(); ";
        $return .= "$('#br1').attr('value', ".$res['br1'].").change(); ";
        $return .= "$('#tr1').attr('value', ".$res['tr1'].").change(); ";
        $return .= "$('#qd1').attr('value', ".$res['qd1'].").change(); ";
        $return .= "$('#co1').attr('value', ".$res['co1'].").change(); ";
        $return .= "$('#sa1').attr('value', ".$res['sa1'].").change(); ";
        $return .= "$('#vr1').attr('value', ".$res['vr1'].").change(); ";
        $return .= "$('#ch1').attr('value', ".$res['ch1'].").change(); ";
        
        if($res['est2'] == 'none'){
            $return .= "$('#nd2').attr('selected', 'selected').change(); ";
        } else if($res['est2'] == 'Livre'){
            $return .= "$('#lv2').attr('selected', 'selected').change(); ";
        } else if($res['est2'] == 'Costas'){
            $return .= "$('#co2').attr('selected', 'selected').change(); ";
        } else if($res['est2'] == 'Borboleta'){
            $return .= "$('#bo2').attr('selected', 'selected').change(); ";
        } else if($res['est2'] == 'Peito'){
            $return .= "$('#pe2').attr('selected', 'selected').change(); ";
        }

        if($res['est2'] == 'none'){
            $return .= "$('#cb2').attr('value', 0).change(); ";
            $return .= "$('#pr2').attr('value', 0).change(); ";
            $return .= "$('#br2').attr('value', 0).change(); ";
            $return .= "$('#tr2').attr('value', 0).change(); ";
            $return .= "$('#qd2').attr('value', 0).change(); ";
            $return .= "$('#co2').attr('value', 0).change(); ";
            $return .= "$('#sa2').attr('value', 0).change(); ";
            $return .= "$('#vr2').attr('value', 0).change(); ";
            $return .= "$('#ch2').attr('value', 0).change(); ";
        } else {
            $return .= "$('#cb2').attr('value', ".$res['cb2'].").change(); ";
            $return .= "$('#pr2').attr('value', ".$res['pr2'].").change(); ";
            $return .= "$('#br2').attr('value', ".$res['br2'].").change(); ";
            $return .= "$('#tr2').attr('value', ".$res['tr2'].").change(); ";
            $return .= "$('#qd2').attr('value', ".$res['qd2'].").change(); ";
            $return .= "$('#co2').attr('value', ".$res['co2'].").change(); ";
            $return .= "$('#sa2').attr('value', ".$res['sa2'].").change(); ";
            $return .= "$('#vr2').attr('value', ".$res['vr2'].").change(); ";
            $return .= "$('#ch2').attr('value', ".$res['ch2'].").change(); ";
        }

        echo $return;
    }

?>