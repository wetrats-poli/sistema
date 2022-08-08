document.addEventListener("DOMContentLoaded", function(event) {
    var exercicios = document.getElementsByClassName('serie');
    console.log(exercicios);
    Array.prototype.forEach.call(exercicios ,function(serie){
        var atual = parseFloat(serie.getAttribute('value'));
        var exercicio = serie.getAttribute('exercicio'); 
        var n = parseFloat(serie.id);
        if(document.getElementById(n+1)!=null){
            var anterior = parseFloat(document.getElementById(n+1).getAttribute('value'));
            console.log(anterior+"/"+atual);
            if(document.getElementById(n+1).getAttribute('exercicio')==exercicio){
                if(anterior<atual){
                    serie.style.backgroundColor='green';
                }
                if(anterior>atual){
                    serie.style.backgroundColor='red';
                    console.log(anterior+"/"+atual);
                }
            }
        }        
    });
  });