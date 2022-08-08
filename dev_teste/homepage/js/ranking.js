function show(prova){
    var x = document.getElementsByClassName("tabela");
    var i;
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
      }
    document.getElementById(prova).style.display = "block";
}