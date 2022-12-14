<?php
    function acha_semana($date){
        $semanas = array();
        $start = new DateTime('2022-01-16');
        for($i=1; $i<=30; $i++){
            $fim = clone $start;
            $fim = $fim->modify('+7days');
            $periodo = new DatePeriod($start, new DateInterval('P1D'), $fim);

            $semanas[$i] = $periodo;
            $start = $fim;
        }

        foreach($semanas as $key=>$per){
            $temp = $per->getStartDate();
            $temp2 = $per->getEndDate();
            if($date >= $temp->format('Y-m-d') && $date < $temp2->format('Y-m-d')){
                $ans = $key;
            }
        }
        return $ans; 
    }
?>