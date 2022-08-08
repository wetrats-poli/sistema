$(function(){
    var mesAtual = document.getElementById('idMes').value;
    var anoAtual = document.getElementById('idAno').value;
    $('#mes_'+mesAtual+'ano_'+anoAtual).show();

    function hideShow(mes, ano){
        $('.mes').hide();
        $('#mes_'+mes+'ano_'+ano).show();
    };

    $('#pro').on('click', function(e){
        e.preventDefault();
        document.getElementById('a'+mesAtual.toString()).selected = false;
        mesAtual++;
        if(mesAtual > 12){
            document.getElementById('a'+anoAtual.toString()).selected = false;
            mesAtual = 1;
            anoAtual++;
            document.getElementById('a'+anoAtual.toString()).selected = true;
        }
        hideShow(mesAtual, anoAtual);
        document.getElementById('a'+mesAtual.toString()).selected = true;

        document.getElementById('ret').style.display = 'inline';
        document.getElementById('pro').style.display = 'inline';
        if((mesAtual == 1) && (anoAtual == 2018)){
            console.log('true');
            document.getElementById('ret').style.display = 'none';
        }
        if((mesAtual == 12) && (anoAtual == 2020)){
            document.getElementById('pro').style.display = 'none';
        }

        return false;
    });

    $('#ret').on('click', function(e){
        e.preventDefault();
        document.getElementById('a'+mesAtual.toString()).selected = false;
        mesAtual--;
        if(mesAtual < 1){
            document.getElementById('a'+anoAtual.toString()).selected = false;
            mesAtual = 12;
            anoAtual--;
            document.getElementById('a'+anoAtual.toString()).selected = true;
        }
        hideShow(mesAtual, anoAtual);
        document.getElementById('a'+mesAtual.toString()).selected = true;

        document.getElementById('ret').style.display = 'inline';
        document.getElementById('pro').style.display = 'inline';
        if((mesAtual == 1) && (anoAtual == 2018)){
            console.log('true');
            document.getElementById('ret').style.display = 'none';
        }
        if((mesAtual == 12) && (anoAtual == 2020)){
            document.getElementById('pro').style.display = 'none';
        }

        return false;
    });

    $('#idMes').on('change', function(e){
        e.preventDefault();
        mesAtual = $('#idMes').val();
        hideShow(mesAtual, anoAtual);
    });

    $('#idAno').on('change', function(e){
        e.preventDefault();
        anoAtual = $('#idAno').val();
        hideShow(mesAtual, anoAtual);
    });

});