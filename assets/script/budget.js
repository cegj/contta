import BudgetTable from "./modules/budgetTable.js";

export default function runBudgetScript(){
    
  const budget = new BudgetTable('#budget-table');

  budget.initBudgetTable();

}



// REFACTOR!!!
    // var ultimaIdEditada;
    // //ID = 28/janeiro
    // function abrirEdicao(id) {

    //   if (ultimaIdEditada != undefined) {
    //     ultimaIdEditada.classList.remove('em-edicao');
    //   }

    //   var idEmEdicao = document.getElementById(id);
    //   var idArray = id.split('/');
    //   var categoriaId = idArray[0];
    //   var categoriaNome = document.getElementById(categoriaId).innerText;
    //   var mes = idArray[1];
    //   var valorString = document.getElementById(id).innerText;
    //   var valor = valorString.replace(/\./g, "").replace(/,/g, ".");

    //   var valorExecutado = document.getElementById(id + "-executado").innerText;
    //   var campoValorExecutado = document.getElementById('campo-valor-executado');

    //   var formAlteracao = document.getElementById('form-alteracao');
    //   var campoCategoria = document.getElementById('campo-categoria');
    //   var campoMes = document.getElementById('campo-mes');
    //   var campoValor = document.getElementById('campo-valor');
    //   var botaoCancelar = document.getElementById('botao-cancelar');
    //   var containerFormAlteracao = document.getElementById('container-alteracao-orcamento');

    //   formAlteracao.setAttribute("action", "#" + id);
    //   campoCategoria.value = categoriaId;
    //   campoMes.value = mes;
    //   campoValorExecutado.value = valorExecutado;
    //   campoValor.value = valor;
    //   formAlteracao.style.display = "flex";
    //   botaoCancelar.style.display = "inline-block";

    //   document.getElementById('nome-cat-label').innerText = categoriaNome;
    //   document.getElementById('mes-label').innerText = mes;
    //   containerFormAlteracao.style.display = "block";
    //   idEmEdicao.classList.add('em-edicao');

    //   ultimaIdEditada = idEmEdicao;

    //   campoValor.focus();
    // }

    // function fecharEdicao() {
    //   var formAlteracao = document.getElementById('form-alteracao');
    //   var botaoCancelar = document.getElementById('botao-cancelar');
    //   var containerFormAlteracao = document.getElementById('container-alteracao-orcamento');

    //   containerFormAlteracao.style.display = "none";

    //   if (ultimaIdEditada != undefined) {
    //     ultimaIdEditada.classList.remove('em-edicao');
    //   }

    // }

    // function copiarValorExecutado() {
    //   var campoValor = document.getElementById('campo-valor');
    //   var valorExecutadoString = document.getElementById('campo-valor-executado').value;
    //   var valorExecutado = valorExecutadoString.replace(/\./g, "");

    //   campoValor.value = valorExecutado;

    // }

    // // REFACTOR!!!
    // // Calcular e exibir a diferença entre previsto e executado via javascript
    // function converteNumeroParaMes(num) {
    //   var mesExtenso;

    //   switch (num) {
    //     case '01':
    //       mesExtenso = 'janeiro';
    //       break;
    //     case '02':
    //       mesExtenso = 'fevereiro';
    //       break;
    //     case '03':
    //       mesExtenso = 'março';
    //       break;
    //     case '04':
    //       mesExtenso = 'abril';
    //       break;
    //     case '05':
    //       mesExtenso = 'maio';
    //       break;
    //     case '06':
    //       mesExtenso = 'junho';
    //       break;
    //     case '07':
    //       mesExtenso = 'julho';
    //       break;
    //     case '08':
    //       mesExtenso = 'agosto';
    //       break;
    //     case '09':
    //       mesExtenso = 'setembro';
    //       break;
    //     case '10':
    //       mesExtenso = 'outubro';
    //       break;
    //     case '11':
    //       mesExtenso = 'novembro';
    //       break;
    //     case '12':
    //       mesExtenso = 'dezembro';
    //       break;
    //   }

    //   return mesExtenso;
    // }

    // window.mes = document.querySelector(".mes-ano-selecionado").innerText.split('/')[0];

    // var mesSelecionado = converteNumeroParaMes(window.mes);

    // var linhasOrcamento = document.getElementsByClassName('linha');

    // var linhaOrcamento;

    // if (mes <= 6) {
    //   linhaOrcamento = 0;
    // } else {
    //   linhaOrcamento =  6;
    // }

    // for (linhaOrcamento; linhaOrcamento <= linhasOrcamento.length; linhaOrcamento++) {

    //   var nameHtml = mesSelecionado + "-" + linhaOrcamento;

    //   var valores = document.getElementsByName(nameHtml);
    //   var celulaResultado = document.getElementsByName(linhaOrcamento);

    //   if (valores[0] != undefined) {
    //     var valorPrevistoString = (valores[0].innerText).replace(/\./g, '').replace(/\,/g, '.');
    //     var valorExecutadoString = (valores[1].innerText).replace(/\./g, '').replace(/\,/g, '.');

    //     var valorPrevisto = parseFloat(valorPrevistoString).toFixed(2);
    //     var valorExecutado = parseFloat(valorExecutadoString).toFixed(2);


    //     if (valorExecutado <= 0) {
    //       var resultado = Math.abs(valorPrevisto) - Math.abs(valorExecutado);
    //     } else if (valorExecutado > 0) {
    //       var resultado = Math.abs(valorExecutado) - Math.abs(valorPrevisto);
    //     }

    //     var resultadoConvertido = Intl.NumberFormat('pt-BR', {
    //       style: 'decimal',
    //       currency: 'BRL',
    //       minimumFractionDigits: '2'
    //     }).format(resultado)

    //     celulaResultado[0].innerText = resultadoConvertido;

    //     if (resultado > 0) {
    //       celulaResultado[0].style.color = "green";
    //     } else if (resultado < 0) {
    //       celulaResultado[0].style.color = "red";
    //     } else {
    //       celulaResultado[0].style.color = "lightgray";
    //     }
    //   }

    // }

    // document.querySelector('body').addEventListener('keydown', function(event) {

    //     if (event.key === 'Escape') {
    //       fecharEdicao();
    //     }
    
    //   });    

    //   const valoresPrevistos = document.querySelectorAll('.valor-previsto');

    //   valoresPrevistos.forEach((element) => {
    //         element.addEventListener('dblclick', () => {
    //           console.log(element.id);
    //           abrirEdicao(element.id);
    //       })
    //   })