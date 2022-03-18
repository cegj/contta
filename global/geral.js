function initScrollToTarget(){

    const internalLinks = document.querySelectorAll('a[href^="#"]');

    function scrollToTarget(event){
        event.preventDefault();
        const href = event.currentTarget.getAttribute('href');
        const target = document.querySelector(href);

        target.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        })
    }

    internalLinks.forEach((link) => {
        link.addEventListener('click', scrollToTarget);    
    });
}

initScrollToTarget();

function mostrarOcultar(btn, box) {
    btn.classList.toggle('botao-sair');
    box.classList.toggle('show');
    box.classList.toggle('hide');
    box.addEventListener('animationend', function() {
      if (box.classList.contains('hide')) {
        box.style.display = "none";
      } else {
        box.style.display = "block";
      }
    });

  }

  btnRegistrarTransacao = document.getElementById('opcao-registrar-transacao')
  boxRegistrarTransacao = document.getElementById('caixa-registrar-modal')

  btnRegistrarTransacao.addEventListener('click', function() {
    mostrarOcultar(this, boxRegistrarTransacao)
  })

  btnAlterarMes = document.getElementById('opcao-selecionar-mes-ano')
  boxAlterarMes = document.getElementById('container-seletor-mes-ano')

  btnAlterarMes.addEventListener('click', function() {
    mostrarOcultar(this, boxAlterarMes)
  })


function checkIdTransacaoNaUrl(){
    let url = window.location.search    
    console.log(url.includes('id_transacao'))
    return url.includes('id_transacao')
}

if (checkIdTransacaoNaUrl()){
    mostrarOcultar(btnRegistrarTransacao, boxRegistrarTransacao)
}

