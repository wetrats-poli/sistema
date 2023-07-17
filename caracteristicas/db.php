<?php
    session_start();

    $tipo = $_POST["tipo"];
    if($tipo == 1){
        $id = $_SESSION['ID'];
    } elseif ($tipo == 2){
        $id = $_POST["id_atleta"];
    }

    $for = $_POST["for"];
    $vel = $_POST["vel"];
    $res_ae = $_POST["res_ae"];
    $res_ana = $_POST["res_ana"];
    $tg = $_POST["tg"];
    $ee = $_POST["ee"];

    $est1 = $_POST["est1"];
    $cb1 = $_POST["cb1"];
    $pr1 = $_POST["pr1"];
    $br1 = $_POST["br1"];
    $tr1 = $_POST["tr1"];
    $qd1 = $_POST["qd1"];
    $co1 = $_POST["co1"];
    $sa1 = $_POST["sa1"];
    $vr1 = $_POST["vr1"];
    $ch1 = $_POST["ch1"];

    $est2 = $_POST["est2"];
    if($est2 != "--"){
        $cb2 = $_POST["cb2"];
        $pr2 = $_POST["pr2"];
        $br2 = $_POST["br2"];
        $tr2 = $_POST["tr2"];
        $qd2 = $_POST["qd2"];
        $co2 = $_POST["co2"];
        $sa2 = $_POST["sa2"];
        $vr2 = $_POST["vr2"];
        $ch2 = $_POST["ch2"];
    } else {
        $est2 = "none";
        $cb2 = 0;
        $pr2 = 0;
        $br2 = 0;
        $tr2 = 0;
        $qd2 = 0;
        $co2 = 0;
        $sa2 = 0;
        $vr2 = 0;
        $ch2 = 0;
    }

    $link = mysqli_connect("srv976.hstgr.io", "u418844475_wtr", "Wetrats2019", "u418844475_wtr");
    $sql = "SELECT tipo FROM caracteristicas2020 WHERE id_atleta = $id";
    $resultado = mysqli_query($link, $sql);
    if($resultado->num_rows == 0){
        $nsql = "INSERT INTO caracteristicas2020 (id_atleta, tipo, forc, vel, res_ae, res_ana, tg, ee, est1, cb1, pr1, br1, tr1, qd1, co1, sa1, vr1, ch1, est2, cb2, pr2, br2, tr2, qd2, co2, sa2, vr2, ch2) VALUE ($id, $tipo, $for, $vel, $res_ae, $res_ana, $tg, $ee, '$est1', $cb1, $pr1, $br1, $tr1, $qd1, $co1, $sa1, $vr1, $ch1, '$est2', $cb2, $pr2, $br2, $tr2, $qd2, $co2, $sa2, $vr2, $ch2)";
        if(!mysqli_query($link, $nsql)){
            printf("Errormessage: %s\n", mysqli_error($link));
        }
    } elseif ($resultado->num_rows == 1){
        $res = $resultado->fetch_array(MYSQLI_ASSOC);
        if($res["tipo"] == $tipo){
            $nsql = "UPDATE caracteristicas2020 SET forc=$for, vel=$vel, res_ae=$res_ae, res_ana=$res_ana, tg=$tg, ee=$ee, est1='$est1', cb1=$cb1, pr1=$pr1, br1=$br1, tr1=$tr1, qd1=$qd1, co1=$co1, sa1=$sa1, vr1=$vr1, ch1=$ch1, est2='$est2', cb2=$cb2, pr2=$pr2, br2=$br2, tr2=$tr2, qd2=$qd2, co2=$co2, sa2=$sa2, vr2=$vr2, ch2=$ch2 WHERE id_atleta=$id AND tipo=$tipo";
            if(!mysqli_query($link, $nsql)){
                printf("Errormessage: %s\n", mysqli_error($link));
            }
        } else {
            $nsql = "INSERT INTO caracteristicas2020 (id_atleta, tipo, forc, vel, res_ae, res_ana, tg, ee, est1, cb1, pr1, br1, tr1, qd1, co1, sa1, vr1, ch1, est2, cb2, pr2, br2, tr2, qd2, co2, sa2, vr2, ch2) VALUE ($id, $tipo, $for, $vel, $res_ae, $res_ana, $tg, $ee, '$est1', $cb1, $pr1, $br1, $tr1, $qd1, $co1, $sa1, $vr1, $ch1, '$est2', $cb1, $pr2, $br2, $tr2, $qd2, $co2, $sa2, $vr2, $ch2)";
            if(!mysqli_query($link, $nsql)){
                printf("Errormessage: %s\n", mysqli_error($link));
            }
        }    
    } else {
        $nsql = "UPDATE caracteristicas2020 SET forc=$for, vel=$vel, res_ae=$res_ae, res_ana=$res_ana, tg=$tg, ee=$ee, est1='$est1', cb1=$cb1, pr1=$pr1, br1=$br1, tr1=$tr1, qd1=$qd1, co1=$co1, sa1=$sa1, vr1=$vr1, ch1=$ch1, est2='$est2', cb2=$cb2, pr2=$pr2, br2=$br2, tr2=$tr2, qd2=$qd2, co2=$co2, sa2=$sa2, vr2=$vr2, ch2=$ch2 WHERE id_atleta=$id AND tipo=$tipo";
        if(!mysqli_query($link, $nsql)){
            printf("Errormessage: %s\n", mysqli_error($link));
        }
    }

    header('Location: visualizar.php?id_atleta='.$id);









?>