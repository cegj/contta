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

  const btnRegistrarTransacao = document.getElementById('opcao-registrar-transacao')
  const boxRegistrarTransacao = document.getElementById('caixa-registrar-modal')

  btnRegistrarTransacao.addEventListener('click', function() {
    mostrarOcultar(this, boxRegistrarTransacao)
  })

  const btnAlterarMes = document.getElementById('opcao-selecionar-mes-ano')
  const boxAlterarMes = document.getElementById('container-seletor-mes-ano')

  btnAlterarMes.addEventListener('click', function() {
    mostrarOcultar(this, boxAlterarMes)
  })


function checkIdTransacaoNaUrl(){
    let url = window.location.search    
    return url.includes('id_transacao')
}

if (checkIdTransacaoNaUrl()){
    mostrarOcultar(btnRegistrarTransacao, boxRegistrarTransacao)
}

function handleFixarFormTransacao() {
  btnFixarFormTransacao.classList.toggle('clicado');
  if (localStorage.getItem('fixarFormTransacao') == 'false') {
    localStorage.setItem('fixarFormTransacao', 'true')
  } else {
    localStorage.setItem('fixarFormTransacao', 'false')
  }
}

const btnFixarFormTransacao = document.getElementById('btn-fixar-form-transacao');

btnFixarFormTransacao.addEventListener('click', handleFixarFormTransacao);

function checkFormTransacaoFixado() {
  if (localStorage.getItem('fixarFormTransacao') == 'true') {
    if (!boxRegistrarTransacao.classList.contains('show')) {
      mostrarOcultar(btnRegistrarTransacao, boxRegistrarTransacao);
      btnFixarFormTransacao.classList.add('clicado');
    }
  }
};

checkFormTransacaoFixado();

const btnFixarValor = document.querySelectorAll('.checkbox-fixar');

const inputsFormRegistrar = document.querySelectorAll('#form-transacao input');

const selectsFormRegistrar = document.querySelectorAll('#form-transacao select');

const campoTipo = document.getElementById('tipo');
const campoData = document.getElementById('data');
const campoValor = document.getElementById('valor');
const campoDescricao = document.getElementById('descricao');
const campoConta = document.getElementById('conta');
const campoContaDestino = document.getElementById('contadestino');
const campoCategoria = document.getElementById('categoria');
const campoParcelas = document.getElementById('parcelas');
const btnRegistrarTransacaoForm = document.getElementById('botao-registrar-transacao');

function checkSetBtnStorage(btn){
  if (sessionStorage.getItem(btn.id) == 'true'){
    document.getElementById(btn.id).classList.add('setted')
  } else {
    document.getElementById(btn.id).classList.remove('setted')
  }};

btnFixarValor.forEach(function(btn){
  btn.addEventListener('click', () => {
    if (sessionStorage.getItem(btn.id) == 'true'){
      sessionStorage.setItem(btn.id, 'false');
      checkSetBtnStorage(btn);     
    } else {
      sessionStorage.setItem(btn.id, 'true');
      checkSetBtnStorage(btn);
    }});
    checkSetBtnStorage(btn);
  });

inputsFormRegistrar.forEach(function(input){
  input.addEventListener('change', function(){
      sessionStorage.setItem(input.id, input.value);
    })
  });

  selectsFormRegistrar.forEach(function(select){
    select.addEventListener('change', function(){
      if(select.nextSibling.innerText){
        sessionStorage.setItem(select.id, select.nextSibling.innerText);
        console.log(select.nextSibling.innerText)
      } else {
        sessionStorage.setItem(select.id, select.value);
        console.log(select.value)
      }
    })
  })

botoesAcaoPrincipal = document.querySelectorAll('.botao-acao-principal');

botoesAcaoPrincipal.forEach(function(btn){
  btn.addEventListener('click', function(){
    afundarBotaoClick(btn);
  })
})

btnFixarValor.forEach(function(btnFixar){
  if (sessionStorage.getItem(btnFixar.id) === 'true'){
    switch (btnFixar.id){
      case 'fixar-tipo':
        campoTipo.value = sessionStorage.getItem('tipo');
        break;
      case 'fixar-data':
        campoData.value = sessionStorage.getItem('data');
        break;
      case 'fixar-valor':
        campoValor.value = sessionStorage.getItem('valor');
        break;
      case 'fixar-descricao':
        campoDescricao.value = sessionStorage.getItem('descricao');
        break;
      case 'fixar-conta':
        campoConta.value = sessionStorage.getItem('conta');
        break;
      case 'fixar-contadestino':
        campoContaDestino.nextSibling.value = sessionStorage.getItem('contadestino');
        break;
      case 'fixar-categoria':
        campoCategoria.nextSibling.value = sessionStorage.getItem('categoria');
        break;
      case 'fixar-parcelas':
        campoParcelas.value = sessionStorage.getItem('parcelas');
        break;
    }}});

  function limparSelecao(elementArray){
    elementArray.forEach(function(element){
      sessionStorage.setItem(element.id, 'false');
      checkSetBtnStorage(element);
    })
  }

  const btnLimparSelecao = document.getElementById('btn-limpar-form-transacao');

  btnLimparSelecao.addEventListener('click', function(){
    limparSelecao(btnFixarValor);
    afundarBotaoClick(btnLimparSelecao);
  });

  function afundarBotaoClick(botao){
    botao.classList.add('clicado');
    setTimeout(function(){botao.classList.remove('clicado')}, 100);
  }