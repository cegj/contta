export default function TransactionFormDealer(transactionForm, choiceConta, choiceContaDestino, choiceCategoria){

  const btnRegistrarTransacao = document.getElementById('opcao-registrar-transacao');
  const boxRegistrarTransacao = document.getElementById('caixa-registrar-modal');

  function afundarBotaoClick(botao){
    botao.classList.add('clicado');
    setTimeout(function(){botao.classList.remove('clicado')}, 100);
  }

  function checkIdTransacaoNaUrl(){
    let url = window.location.search    
    return url.includes('id_transacao')
}

if (checkIdTransacaoNaUrl()){
    transactionForm.openClose('#'+btnRegistrarTransacao.id, '#'+boxRegistrarTransacao.id)
}

function handleFixarFormTransacao() {
  btnFixarFormTransacao.classList.toggle('clicado');
  if (localStorage.getItem('fixarFormTransacao') == 'false') {
    localStorage.setItem('fixarFormTransacao', 'true')
  } else {
    localStorage.setItem('fixarFormTransacao', 'false')
  }
}

const btnFixarFormTransacao = document.getElementById('btn-fixar-form-transaction');

btnFixarFormTransacao.addEventListener('click', handleFixarFormTransacao);

function checkFormTransacaoFixado() {
  if (localStorage.getItem('fixarFormTransacao') == 'true') {
    if (!boxRegistrarTransacao.classList.contains('show')) {
      transactionForm.openClose("#"+btnRegistrarTransacao.id, "#"+boxRegistrarTransacao.id);
      btnFixarFormTransacao.classList.add('clicado');
    }
  }
};

checkFormTransacaoFixado();

const btnFixarValor = document.querySelectorAll('.checkbox-fixar');
const inputsFormRegistrar = document.querySelectorAll('#form-transaction input');
const selectsFormRegistrar = document.querySelectorAll('#form-transaction select');
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

  let value;

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

const botoesAcaoPrincipal = document.querySelectorAll('.botao-acao-principal');

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

    const btnLimparSelecao = document.getElementById('btn-limpar-form-transaction');

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
    campoTipo.style.color = "white";
    campoTipo.style.backgroundColor = "var(--cor-transferencia)";
    campoTipo.style.borderColor = "var(--cor-transferencia)";
    campoValor.style.backgroundColor = "var(--cor-transferencia)";
    campoValor.style.borderColor = "var(--cor-transferencia)";
    boxFormRegistrarTransacao.style.borderTop = "3px solid var(--cor-transferencia)";
  } else if (value == "D") {
    campoTipo.style.color = "white";
    campoTipo.style.backgroundColor = "var(--cor-despesa)";
    campoTipo.style.borderColor = "var(--cor-despesa)";
    campoValor.style.backgroundColor = "var(--cor-despesa)";
    campoValor.style.borderColor = "var(--cor-despesa)";
    boxFormRegistrarTransacao.style.borderTop = "3px solid var(--cor-despesa)";
  } else if (value == "R") {
    campoTipo.style.color = "white";
    campoTipo.style.backgroundColor = "var(--cor-receita)";
    campoTipo.style.borderColor = "var(--cor-receita)";
    campoValor.style.backgroundColor = "var(--cor-receita)";
    campoValor.style.borderColor = "var(--cor-receita)";
    boxFormRegistrarTransacao.style.borderTop = "3px solid var(--cor-receita)";
  }

};

campoTipo.addEventListener('change', function() {
  ajustesFormTipoTransacao(this.value)
});

ajustesFormTipoTransacao(campoTipo.value);
}