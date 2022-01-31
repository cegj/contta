checkboxApagar = document.getElementById('apagar');
alertaApagar = document.getElementById('alerta-apagar');

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