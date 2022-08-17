<?php
    function desvio_padrao($data){
        $size = count($data);

        $var = 0.0;
        $avg = array_sum($data) / $size;
        
        foreach($data as $i){
            $var += pow(($i - $avg), 2);
        }

        return sqrt($var / $size);
    }

    function soma($arr1, $arr2){
        $soma = Array();

        if(count($arr1) == count($arr2)){
            for($i = 0; $i < count($arr1); $i++){
                $soma[] = $arr1[$i] + $arr2[$i];
            }
            return $soma;
        } else {
            return -1;
        }
    }

    function avg4($arr1, $arr2, $arr3, $arr4){
        return ((array_sum($arr1) + array_sum($arr2) + array_sum($arr3) + array_sum($arr4)) / 4);
    }

    function carga_interna_agua($id_atleta, $semana_atual){
        $link = mysqli_connect("p:auth-db213.hstgr.io", "u418844475_wtr", "wetrats2019", "u418844475_wtr");
        
        $sql_1_a = mysqli_fetch_array(mysqli_query($link, "SELECT pse_nova.ses , duracao_agua.duracao 
                                                           FROM pse_nova
                                                           INNER JOIN duracao_agua ON (pse_nova.id_atleta = duracao_agua.id_atleta)
                                                           WHERE pse_nova.id_atleta=$id_atleta AND pse_nova.dia_semana=1 AND pse_nova.semana=$semana_atual
                                                           AND duracao_agua.dia_semana=1 AND duracao_agua.semana=$semana_atual"));
        $sql_2_a = mysqli_fetch_array(mysqli_query($link, "SELECT pse_nova.ses , duracao_agua.duracao 
                                                           FROM pse_nova
                                                           INNER JOIN duracao_agua ON (pse_nova.id_atleta = duracao_agua.id_atleta)
                                                           WHERE pse_nova.id_atleta=$id_atleta AND pse_nova.dia_semana=2 AND pse_nova.semana=$semana_atual
                                                           AND duracao_agua.dia_semana=2 AND duracao_agua.semana=$semana_atual"));
        $sql_3_a = mysqli_fetch_array(mysqli_query($link, "SELECT pse_nova.ses , duracao_agua.duracao 
                                                           FROM pse_nova
                                                           INNER JOIN duracao_agua ON (pse_nova.id_atleta = duracao_agua.id_atleta)
                                                           WHERE pse_nova.id_atleta=$id_atleta AND pse_nova.dia_semana=3 AND pse_nova.semana=$semana_atual
                                                           AND duracao_agua.dia_semana=3 AND duracao_agua.semana=$semana_atual"));
        $sql_4_a = mysqli_fetch_array(mysqli_query($link, "SELECT pse_nova.ses , duracao_agua.duracao 
                                                           FROM pse_nova
                                                           INNER JOIN duracao_agua ON (pse_nova.id_atleta = duracao_agua.id_atleta)
                                                           WHERE pse_nova.id_atleta=$id_atleta AND pse_nova.dia_semana=4 AND pse_nova.semana=$semana_atual
                                                           AND duracao_agua.dia_semana=4 AND duracao_agua.semana=$semana_atual"));
        $sql_5_a = mysqli_fetch_array(mysqli_query($link, "SELECT pse_nova.ses , duracao_agua.duracao 
                                                           FROM pse_nova
                                                           INNER JOIN duracao_agua ON (pse_nova.id_atleta = duracao_agua.id_atleta)
                                                           WHERE pse_nova.id_atleta=$id_atleta AND pse_nova.dia_semana=5 AND pse_nova.semana=$semana_atual
                                                           AND duracao_agua.dia_semana=5 AND duracao_agua.semana=$semana_atual"));
        $sql_6_a = mysqli_fetch_array(mysqli_query($link, "SELECT pse_nova.ses , duracao_agua.duracao 
                                                           FROM pse_nova
                                                           INNER JOIN duracao_agua ON (pse_nova.id_atleta = duracao_agua.id_atleta)
                                                           WHERE pse_nova.id_atleta=$id_atleta AND pse_nova.dia_semana=6 AND pse_nova.semana=$semana_atual
                                                           AND duracao_agua.dia_semana=6 AND duracao_agua.semana=$semana_atual"));
        $sql_7_a = mysqli_fetch_array(mysqli_query($link, "SELECT pse_nova.ses , duracao_agua.duracao 
                                                           FROM pse_nova
                                                           INNER JOIN duracao_agua ON (pse_nova.id_atleta = duracao_agua.id_atleta)
                                                           WHERE pse_nova.id_atleta=$id_atleta AND pse_nova.dia_semana=7 AND pse_nova.semana=$semana_atual
                                                           AND duracao_agua.dia_semana=7 AND duracao_agua.semana=$semana_atual"));
                    
        $cia = Array();

        if($sql_1_a[0] == null || $sql_1_a[1] == null){
            $cia[] = 0;
        } else {
            $cia[] = $sql_1_a[0] * $sql_1_a[1];
        }

        if($sql_2_a[0] == null || $sql_2_a[1] == null){
            $cia[] = 0;
        } else {
            $cia[] = $sql_2_a[0] * $sql_2_a[1];
        }

        if($sql_3_a[0] == null || $sql_3_a[1] == null){
            $cia[] = 0;
        } else {
            $cia[] = $sql_3_a[0] * $sql_3_a[1];
        }

        if($sql_4_a[0] == null || $sql_4_a[1] == null){
            $cia[] = 0;
        } else {
            $cia[] = $sql_4_a[0] * $sql_4_a[1];
        }

        if($sql_5_a[0] == null || $sql_5_a[1] == null){
            $cia[] = 0;
        } else {
            $cia[] = $sql_5_a[0] * $sql_5_a[1];
        }

        if($sql_6_a[0] == null || $sql_6_a[1] == null){
            $cia[] = 0;
        } else {
            $cia[] = $sql_6_a[0] * $sql_6_a[1];
        }

        if($sql_7_a[0] == null || $sql_7_a[1] == null){
            $cia[] = 0;
        } else {
            $cia[] = $sql_7_a[0] * $sql_7_a[1];
        }

        return $cia;
    }

    function carga_interna_fisico($id_atleta, $semana_atual){
        $link = mysqli_connect("p:auth-db213.hstgr.io", "u418844475_wtr", "wetrats2019", "u418844475_wtr");

        $sql_1_f = mysqli_fetch_array(mysqli_query($link, "SELECT carga_interna FROM pse_academia WHERE id_atleta=$id_atleta AND dia_semana=1 AND semana=$semana_atual"));
        $sql_2_f = mysqli_fetch_array(mysqli_query($link, "SELECT carga_interna FROM pse_academia WHERE id_atleta=$id_atleta AND dia_semana=2 AND semana=$semana_atual"));
        $sql_3_f = mysqli_fetch_array(mysqli_query($link, "SELECT carga_interna FROM pse_academia WHERE id_atleta=$id_atleta AND dia_semana=3 AND semana=$semana_atual"));
        $sql_4_f = mysqli_fetch_array(mysqli_query($link, "SELECT carga_interna FROM pse_academia WHERE id_atleta=$id_atleta AND dia_semana=4 AND semana=$semana_atual"));
        $sql_5_f = mysqli_fetch_array(mysqli_query($link, "SELECT carga_interna FROM pse_academia WHERE id_atleta=$id_atleta AND dia_semana=5 AND semana=$semana_atual"));
        $sql_6_f = mysqli_fetch_array(mysqli_query($link, "SELECT carga_interna FROM pse_academia WHERE id_atleta=$id_atleta AND dia_semana=6 AND semana=$semana_atual"));
        $sql_7_f = mysqli_fetch_array(mysqli_query($link, "SELECT carga_interna FROM pse_academia WHERE id_atleta=$id_atleta AND dia_semana=7 AND semana=$semana_atual"));


        $cif = Array();

        if($sql_1_f[0] == null || $sql_1_f[1] == null){
            $cif[] = 0;
        } else {
            $cif[] = $sql_1_f[0] * $sql_1_f[1];
        }

        if($sql_2_f[0] == null || $sql_2_f[1] == null){
            $cif[] = 0;
        } else {
            $cif[] = $sql_2_f[0] * $sql_2_f[1];
        }

        if($sql_3_f[0] == null || $sql_3_f[1] == null){
            $cif[] = 0;
        } else {
            $cif[] = $sql_3_f[0] * $sql_3_f[1];
        }

        if($sql_4_f[0] == null || $sql_4_f[1] == null){
            $cif[] = 0;
        } else {
            $cif[] = $sql_4_f[0] * $sql_4_f[1];
        }

        if($sql_5_f[0] == null || $sql_5_f[1] == null){
            $cif[] = 0;
        } else {
            $cif[] = $sql_5_f[0] * $sql_5_f[1];
        }

        if($sql_6_f[0] == null || $sql_6_f[1] == null){
            $cif[] = 0;
        } else {
            $cif[] = $sql_6fa[0] * $sql_6_f[1];
        }

        if($sql_7_f[0] == null || $sql_7_f[1] == null){
            $cif[] = 0;
        } else {
            $cif[] = $sql_7_f[0] * $sql_7_f[1];
        }

        return $cif;
    }

    function monotonia($id_atleta, $semana_atual){
        $ci = soma(carga_interna_agua($id_atleta, $semana_atual), carga_interna_fisico($id_atleta, $semana_atual));
        $media = array_sum($ci) / count($ci);
        $dp = desvio_padrao($ci);
        return number_format((float)($media / $dp), 2);
    }

    function ci_ag_cr($id_atleta, $semana_atual){
        if($semana_atual < 4){
            return false;
        } else {
            $ci1 = soma(carga_interna_agua($id_atleta, $semana_atual), carga_interna_fisico($id_atleta, $semana_atual));
            $ci2 = soma(carga_interna_agua($id_atleta, $semana_atual-1), carga_interna_fisico($id_atleta, $semana_atual-1));
            $ci3 = soma(carga_interna_agua($id_atleta, $semana_atual-2), carga_interna_fisico($id_atleta, $semana_atual-2));
            $ci4 = soma(carga_interna_agua($id_atleta, $semana_atual-3), carga_interna_fisico($id_atleta, $semana_atual-3));
    
            $soma = avg4($ci1, $ci2, $ci3, $ci4);
            return number_format((float)(array_sum($ci4) / $soma), 2);
        }
    }

?>