function show(tabela){
    var x = document.getElementsByClassName("tabela");
    var i;
    for (i = 0; i < x.length; i++) {
        x[i].style.display = "none";
      }
    document.getElementById(tabela).style.display = "block";

}

function exibe_modal(id){
    document.getElementById('divDescricao').innerHTML = document.getElementById(id).value;
    document.querySelector('.bg-modal').style.display = 'flex';
}; //mostra o modal 


document.querySelector('.close').addEventListener('click',
function(e){
    e.preventDefault();
    document.querySelector('.bg-modal').style.display = 'none';
});