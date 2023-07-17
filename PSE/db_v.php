<?php
    session_start();

    date_default_timezone_set('America/Sao_Paulo');
    $hoje=date("Y-m-d");

    $link = mysqli_connect("srv976.hstgr.io", "u418844475_wtr", "Wetrats2019", "u418844475_wtr");
    //$sql = "SELECT id FROM treinos WHERE data=(SELECT DATE_ADD("."'".$hoje."'".", INTERVAL 1 DAY))";
    $sql = "SELECT id FROM treinos WHERE data='".$hoje."'";
    $id_treino = mysqli_fetch_assoc(mysqli_query($link, $sql));

    $sql2 = "SELECT resp_s, ses, resp_d, descs FROM pse WHERE id_treino=".$id_treino['id'];

    $res = mysqli_fetch_assoc(mysqli_query($link, $sql2));

    $ses = $_POST['ses'];

    $ses_n = (($res['ses'] * $res['resp_s']) + $ses) / ($res['resp_s'] + 1);
    $resp_s_n = $res['resp_s'] + 1;

    if($_POST['descs'] != ''){
        $descs = $_POST['descs'];
        $descs_n = (($res['descs'] * $res['resp_d']) + $descs) / ($res['resp_d'] + 1);
        $resp_d_n = $res['resp_d'] + 1;
    } else {
        $descs_n = $res['descs'];
        $resp_d_n = $res['resp_d'];
    }

    $ratio = $ses_n / $descs_n;

    $sql3 = "UPDATE pse SET resp_s=$resp_s_n, ses=$ses_n, resp_d=$resp_d_n, descs=$descs_n, ratio=$ratio WHERE id_treino=".$id_treino['id'];
    mysqli_query($link, $sql3);

    $_SESSION['MSG'] = "PSE Respondida com Sucesso!";
    header('Location: ../perfil/');

?>