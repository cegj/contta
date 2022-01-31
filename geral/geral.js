function mostrarOcultar(elemento){

  if (elemento.style.display != "none") {
    elemento.style.display = "none"; //Esconde
  } else {
    elemento.style.display = ""; //Exibe 
  }
}

filtrar = document.getElementsByClassName('filtrar');