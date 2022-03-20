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
  const boxFormRegistrarTransacao = document.getElementById('caixa-registrar-modal');
  const campoTipo = document.getElementById('tipo');
  const campoData = document.getElementById('data');
  const campoValor = document.getElementById('valor');
  const campoDescricao = document.getElementById('descricao');
  const campoConta = choiceConta;
  const campoContaDestino = choiceContaDestino;
  const labelContaDestino = document.querySelector('label[for=contadestino]');
  const campoCategoria = choiceCategoria;
  const labelCategoria = document.querySelector('label[for=categoria]');
  if (!!document.getElementById('parcelas')){
    var campoParcelas = document.getElementById('parcelas');
    var labelParcelas = document.querySelector('label[for=parcelas]');
  }
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
      if(select.id === 'conta'){
        value = choiceConta.getValue().value
      } else if (select.id === 'contadestino'){
        value = choiceContaDestino.getValue().value
      } else if (select.id === 'categoria'){
        value = choiceCategoria.getValue().value
      } else {
        value = select.value;
      }

      sessionStorage.setItem(select.id, value);
    })
  })

botoesAcaoPrincipal = document.querySelectorAll('.botao-acao-principal');

botoesAcaoPrincipal.forEach(function(btn){
  btn.addEventListener('click', function(){
    afundarBotaoClick(btn);
  })
})

if (!checkIdTransacaoNaUrl()){
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
          campoConta.setChoiceByValue(sessionStorage.getItem('conta'));
          break;
        case 'fixar-contadestino':
          campoContaDestino.setChoiceByValue(sessionStorage.getItem('contadestino'));
          break;
        case 'fixar-categoria':
          campoCategoria.setChoiceByValue(sessionStorage.getItem('categoria'));
          break;
        case 'fixar-parcelas':
          if (!!campoParcelas){
          campoParcelas.value = sessionStorage.getItem('parcelas');
          break;
          }
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
}

function ajustesFormTipoTransacao(value) {

  if (value == "T") {
    campoCategoria.disable();
    labelCategoria.style.opacity = "0.3";
    campoContaDestino.enable();
    labelContaDestino.style.opacity = "unset";
    if (!!campoParcelas){
    campoParcelas.disabled = true;
    labelParcelas.style.opacity = "0.3";
    campoParcelas.style.cursor = "not-allowed";
    campoParcelas.style.opacity = "0.3";
    }
  }
    else if (value == "D" || value == "R") {
    campoCategoria.enable();
    labelCategoria.style.opacity = "unset";
    campoContaDestino.disable();
    labelContaDestino.style.opacity = "0.3";
    if (!!campoParcelas){
    campoParcelas.disabled = false;
    labelParcelas.style.opacity = "unset";
    campoParcelas.style.cursor = "auto";
    campoParcelas.style.opacity = "unset";
    }
  }

  if (value == "T") {
    campoValor.style.backgroundColor = "#264b7f";
    campoValor.style.borderColor = "#2b5794";
    boxFormRegistrarTransacao.style.borderTop = "3px solid #264b7f";
  } else if (value == "D") {
    campoValor.style.backgroundColor = "#ad2f1b";
    campoValor.style.borderColor = "#ad2f1b";
    boxFormRegistrarTransacao.style.borderTop = "3px solid #ad2f1b";
  } else if (value == "R") {
    campoValor.style.backgroundColor = "#3e7f26";
    campoValor.style.borderColor = "#3e7f26";
    boxFormRegistrarTransacao.style.borderTop = "3px solid #3e7f26";
  }

};

campoTipo.addEventListener('change', function() {
  ajustesFormTipoTransacao(this.value)
});

ajustesFormTipoTransacao(campoTipo.value);