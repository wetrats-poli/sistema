function exibe1(id){
    var id_ = id.trim();
    document.getElementById('modal1').style.display = 'flex';
    var href =  document.getElementById('blz_btn').href;
    var param = "&rg=false&nusp=false&email=false&tel=false&aniv=false";
    document.getElementById('blz_btn').href = href+id_+param;
}; //mostra o modal 

document.getElementById('cls').addEventListener('click',
function(e){
    e.preventDefault();
    document.getElementById('modal1').style.display = 'none';
    document.getElementById('blz_btn').href = "./balizamento.php?id=";
    apagaDados();
});

function apagaDados(){
    var vet = document.getElementsByName('dados');
    for (var i=0; i<vet.length; i++){
        if (vet[i].checked == true){
            vet[i].checked = false;
        }
    }
}