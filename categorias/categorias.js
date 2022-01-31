botaoVerOcultar = document.getElementsByClassName('botao-ver-ocultar');
tabelaCategoriasCadastradas = document.getElementById('tabela-categorias-cadastradas');
checkboxApagar = document.getElementById('apagar');
alertaApagar = document.getElementById('alerta-apagar');

// tabelaCategoriasCadastradas.style.display = "none";

botaoVerOcultar[0].addEventListener('click',function(){mostrarOcultar(tabelaCategoriasCadastradas)})

checkboxApagar.addEventListener('change', function(){
  if (checkboxApagar.checked){
    alertaApagar.style.background = "#ffd0d0";  
    alertaApagar.style.border = "3px solid #a40a0a";
    alertaApagar.style.boxShadow = "#a40a0a 3px 3px";    
 
  
  } else {
    alertaApagar.style.background = "";
    alertaApagar.style.border = "";
    alertaApagar.style.boxShadow = "";    
  }
})