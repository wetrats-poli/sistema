function contagem(ano, mes, dia){
    var hoje = new Date();
    var evento = new Date(ano, mes-1, dia); // Ano, Mês, Dia. O mês é contado como 0 em janeiro e 11 em dezembro
    var dias = Math.ceil((evento-hoje)/86400000);    //Quantos dias faltam

    if (dias > 0 && dias != 1){
        document.getElementById("contagem"+ano+mes+dia).innerHTML = ("<p><strong>" + dias + " Dias</strong></p>");
    } else if(dias == 1){
        document.getElementById("contagem"+ano+mes+dia).innerHTML = ("<p><strong>" + dias + " Dia</strong></p>");
    } else{
        document.getElementById("contagem"+ano+mes+dia).innerHTML = ("<p><strong>Hoje!</strong></p>");
    }
}

function hideShow(){
    document.getElementById('tbl').style.display='none'; 
    document.getElementById('contbtn').style.display='none'; 
    document.getElementById('cont_form').style.display='block';
}
