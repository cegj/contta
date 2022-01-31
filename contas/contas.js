botaoVerOcultar = document.getElementsByClassName('botao-ver-ocultar');
tabelaContasCadastradas = document.getElementById('tabela-contas-cadastradas');
radioApagar = document.getElementsByClassName('apagar');
alertaApagar = document.getElementById('alerta-apagar');
botaoLimparSelecao = document.getElementById('limpar-selecao');

tabelaContasCadastradas.style.display = "none";

botaoVerOcultar[0].addEventListener('click',function(){mostrarOcultar(tabelaContasCadastradas)})

  radioApagar[0].addEventListener('change', function(){
    if (radioApagar[0].checked){
      alertaApagar.style.background = "#ffd0d0";  
      alertaApagar.style.border = "3px solid #a40a0a";
      alertaApagar.style.boxShadow = "#a40a0a 3px 3px";   
      botaoLimparSelecao.style.display = "inline-block";     
    } else {
      alertaApagar.style.background = "";
      alertaApagar.style.border = "";
      alertaApagar.style.boxShadow = "";  
      botaoLimparSelecao.style.display = "none";  
    }
  })

  radioApagar[1].addEventListener('change', function(){
    if (radioApagar[1].checked){
      alertaApagar.style.background = "#ffd0d0";  
      alertaApagar.style.border = "3px solid #a40a0a";
      alertaApagar.style.boxShadow = "#a40a0a 3px 3px";
      botaoLimparSelecao.style.display = "inline-block";    
  
    } else {
      alertaApagar.style.background = "";
      alertaApagar.style.border = "";
      alertaApagar.style.boxShadow = ""; 
      botaoLimparSelecao.style.display = "none";   
    }
  })

  botaoLimparSelecao.addEventListener('click', function(){
    radioApagar[0].checked = false;
    radioApagar[1].checked = false;
    alertaApagar.style.background = "";
    alertaApagar.style.border = "";
    alertaApagar.style.boxShadow = "";  
    botaoLimparSelecao.style.display = "none";  
  })