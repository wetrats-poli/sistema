<?php
    include 'eventos.php';
    session_start();
    
    // Verifica se existe ID da sessão
    if(!isset($_SESSION['ID'])){
    
        //Destrói a sessão por segurança
        session_destroy();

        //Redireciona para o login
        header("Location: ../index.php"); exit;
    }
    

    function diasMeses(){
        //cria um array com a quantidade de dias no mês
        $retorno = array();

        for($i =1; $i <= 12; $i++){
            $retorno[$i] = cal_days_in_month(CAL_GREGORIAN, $i, date('Y'));
        }

        return $retorno;
    }

    function montaCalendario(){
        $ano = date('Y');
        $mes = date('n');

        $daysWeek = array(
            1 => 'Sun',
            2 => 'Mon',
            3 => 'Tue',
            4 => 'Wed',
            5 => 'Thu',
            6 => 'Fri',
            7 => 'Sat'
        );

        $diasSemana = array(
            'Domingo',
            'Segunda',
            'Terça',
            'Quarta',
            'Quinta',
            'Sexta',
            'Sábado'
        );

        $arrayMes = array(
           1 => 'Janeiro',
           2 => 'Fevereiro',
           3 => 'Março',
           4 => 'Abril',
           5 => 'Maio',
           6 => 'Junho',
           7 => 'Julho',
           8 => 'Agosto',
           9 => 'Setembro',
           10 => 'Outubro',
           11 => 'Novembro',
           12 => 'Dezembro' 
        );

        $diasMeses = diasMeses();

        echo '<div class="form-group">';      
        echo '<div class="row" style="top: 92px; left:70px; position:absolute;" >';
        echo '<select class="form-control form-control-sm sel mod" style="margin:0 3 0 3px;" id="idMes">';
        foreach ($arrayMes as $num => $nome) {   
            if($num == $mes){
                echo '<option value="'.$num.'" id="a'.$num.'" selected>'.$nome.'</option>';
            } else{
                echo '<option value="'.$num.'" id="a'.$num.'">'.$nome.'</option>';
            }
        }
        echo '</select></div><div class="row" style="top: 92px; left:190px; position:absolute;"><select class="form-control form-control-sm sel mod" id="idAno" style="margin:0 3 0 3px;">'; 
        $arrayAno = array();
        $ind = 1;       
        for($i = 2018; $i <= ($ano+1); $i++){
            if($i == $ano){    
                echo '<option value="'.$i.'" id="a'.$i.'" selected>'.$i.'</option>';
            }else{
                echo '<option value="'.$i.'" id="a'.$i.'">'.$i.'</option>';
            }  
            $arrayAno[$ind] = $i;
            $ind++;
        }                        
        echo '</select>';
        echo '</div>';   
        echo '</div>';
    
        $arrayTreinos = montaTreinos();
        $arrayComp = montaComp();
        $arrayEvento = montaEventos();
        $arrayEventosPessoais = montaEventosPessoais($_SESSION['ID']);
        
        $link = mysqli_connect("auth-db213.hstgr.io", "u418844475_wtr", "wetrats2019", "u418844475_wtr");
        $sql = "SELECT `data` FROM `competicoes` WHERE ativo = '1'";
        $res = mysqli_query($link, $sql);
        $arrayCompAb = array();
        $ii = 0;
        while($vet = mysqli_fetch_array($res)){
            $arrayCompAb[$i] = $vet[0];
            $ii++;
        }
        
        echo '<div style="position:absolute; width:60px; height:36.4px; top:73px; right:70px;"><a href="" id="ret">&laquo;</a><a href="" id="pro">&raquo;</a></div>'; //botões para mudar de mês
        echo '<table border="0" width="100%">';
  
        foreach ($arrayAno as $key => $auxAno) {
            $arrayRetorno = array();
            for($i = 1; $i <= 12; $i++){
                $arrayRetorno[$i] = array(); //cada ano, possui vetores que representam os meses
                for($n = 1; $n <= $diasMeses[$i]; $n++){
                    $dayMonth = gregoriantojd($i, $n, $auxAno);
                    $weekMonth = substr(jddayofweek($dayMonth, 1),0 ,3);
                    if($weekMonth == 'Mun') $weekMonth = 'Mon';
                    $arrayRetorno[$i][$n] = $weekMonth; //dentro dos meses, é armazenado os dias da semana
                }
            }                                                                                              
            foreach($arrayMes as $num => $mes){
                echo '<tbody id="mes_' .$num.'ano_'.$auxAno.'" class="mes">'; //cada mês é representado por um table body
                echo '<tr class="mes_title" style="height:50px;"><td colspan="7"><b>' .$mes.' '.$auxAno.'</b></td></tr>'; //insere o nome do mês      
                echo '<tr class="dias_title">';
                foreach ($diasSemana as $i => $day) {
                    echo '<td><strong>' .$day. '</strong></td>'; //insere os dias da semana
                }        
                echo '</tr><tr>';                                                  
                $y = 0;   
                foreach($arrayRetorno[$num] as $numero => $dia) {
                    $y++;
                    if($numero == 1){
                        $qtd = array_search($dia, $daysWeek); //verifica qual dia da semana corresponde ao primeiro dia do mês
                        for($k = 1; $k < $qtd; $k++){ //pula a quantidade de dias correpondente ao dia da semana
                            echo '<td class="dias"></td>';
                            $y++;
                        }
                    }
                    $data = date_create(strval($auxAno).'-'.strval($num).'-'.strval($numero));                   
                    if(array_key_exists(date_format($data, "Y-m-d"), $arrayTreinos)){
                        echo '<td valign="top" class="dias"><button'; if($arrayTreinos[date_format($data, "Y-m-d")][1]>0) echo' style="color:Green;"';  echo' class="link" id="'.date_format($data, "Y-m-d").'" class="treino" onclick="exibe(this.id)" value="Treino do dia: '.date_format($data,"d/m/Y").'<br>'.$arrayTreinos[date_format($data, "Y-m-d")][0].'">' .$numero. '</button>';
                    }else{
                        echo '<td valign="top" class="dias">' .$numero;//insere o número do dia na tabela 
                    }
                    if (array_key_exists(date_format($data, "Y-m-d"), $arrayComp[0])) {
                        if(in_array($arrayComp[0][date_format($data, "Y-m-d")], $arrayComp[1])){
                            echo '<div class="evento comp"><a href="../common/uploads/resultados/'.$arrayComp[0][date_format($data, "Y-m-d")].'.pdf" target="_blank">'.$arrayComp[0][date_format($data, "Y-m-d")].'</a></div>';
                        }else if(in_array(date_format($data, "Y-m-d"), $arrayCompAb)){
                            echo '<div class="evento comp"><a href="../inscricao_competicao/?competicao='.$arrayComp[0][date_format($data, "Y-m-d")].'" target="_blank">'.$arrayComp[0][date_format($data, "Y-m-d")].'</a></div>';
                        }else{
                            echo '<div class="evento comp"><p>'.$arrayComp[0][date_format($data, "Y-m-d")].'</p></div>';
                        }
                    }
                    if(array_key_exists(date_format($data, "Y-m-d"), $arrayEvento)){
                        echo '<div class="evento ';
                        $arrayAux = array_keys($arrayEvento[date_format($data, "Y-m-d")]);
                        if($arrayAux[0] == 1){
                            echo 'reuniao"><p>'.$arrayEvento[date_format($data, "Y-m-d")][1].'</p></div>';
                        } else if ($arrayAux[0] == 2) {
                            echo 'social"><p>'.$arrayEvento[date_format($data, "Y-m-d")][2].'</p></div>';
                        }
                    }
                    if(array_key_exists(date_format($data, "Y-m-d"), $arrayEventosPessoais)){
                        echo '<div class="evnt_pessoal"><p>'.$arrayEventosPessoais[date_format($data, "Y-m-d")].'</p></div>';
                    }


                    echo '</td>';

                    if($y == 7){        
                        $y = 0;
                        echo '</tr><tr>';
                    }
                }
                echo '</tr></tbody>';
            }
        }
        echo '</table>'; 
    }
?>