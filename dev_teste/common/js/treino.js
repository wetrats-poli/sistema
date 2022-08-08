function exibe(id){
    console.log(id);
    console.log(document.getElementById(id).value);
    document.getElementById('divDescricao').innerHTML = document.getElementById(id).value;
    document.querySelector('.bg-modal').style.display = 'flex';
}; //mostra o modal 


document.querySelector('.close').addEventListener('click',
function(e){
    e.preventDefault();
    document.querySelector('.bg-modal').style.display = 'none';
});