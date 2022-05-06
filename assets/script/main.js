import Page from './page.js';
import balanceBox from './balanceBox.js';
import MonthSelector from './monthSelector.js';
import ContextOpenClose from './contextOpenClose.js';
import TransactionFormDealer from './transactionForm.js';
import ShowHide from './showHide.js';
import { params } from './params.js';

let actualPage = params.p;

if (!actualPage){
    actualPage = 'index';
}

const page = new Page(actualPage, 'body');

await page.load();

//Choices.js plugin to searchable select inputs

export const choiceConta = new Choices('#conta', {
    searchPlaceholderValue: "Digite para buscar um conta"
    });
export const choiceContaDestino = new Choices('#contadestino', {
    searchPlaceholderValue: "Digite para buscar conta"
    });
export const choiceCategoria = new Choices('#categoria', {
    searchPlaceholderValue: "Digite para buscar um categoria"
    });
    
//VMasker plugin to mask monetary numbers at imput fields
    
VMasker(document.querySelector("#valor")).maskMoney({
    precision: 2,
    separator: ',',
    delimiter: '.',
    unit: 'R$',
    });

//Set color of balance boxes according to the value

const monthBalance = new balanceBox('#saldo-mes', '#valor-mes');

monthBalance.setColor();

const acumulatedBalance = new balanceBox('#saldo-acumulado', '#valor-acumulado');

acumulatedBalance.setColor();

const generalBalance = new balanceBox('#saldo-geral', '#valor-geral');

generalBalance.setColor();

//Set monthSelector as open-close box

const monthSelector = new MonthSelector('#opcao-selecionar-mes-ano','#container-seletor-mes-ano', "#for-mes-ano", "#seletor-campo-mes", ".botao-seletor-mes");

monthSelector.initMonthSelector();

//Set transactionForm as open-close box

const transactionForm = new ContextOpenClose('#opcao-registrar-transacao','#caixa-registrar-modal');

transactionForm.initContextOpenClose();

TransactionFormDealer(transactionForm, choiceConta, choiceContaDestino, choiceCategoria);

const showHideMoneyBtn = new ShowHide('#opcao-exibir-ocultar', '.money');

showHideMoneyBtn.initShowHide();