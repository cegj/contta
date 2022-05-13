import Page from './page.js';
import balanceBox from './balanceBox.js';
import MonthSelector from './monthSelector.js';
import ContextOpenClose from './contextOpenClose.js';
import TransactionFormDealer from './transactionForm.js';
import ShowHide from './showHide.js';
import Link from './link.js';
import Form from './form.js';

export default async function runMainScript(){

    //Choices.js plugin to searchable select inputs

    let choiceConta = new Choices('#conta', {
        searchPlaceholderValue: "Digite para buscar um conta",
        allowHTML: true
        });
    let choiceContaDestino = new Choices('#contadestino', {
        searchPlaceholderValue: "Digite para buscar conta",
        allowHTML: true
        });
    let choiceCategoria = new Choices('#categoria', {
        searchPlaceholderValue: "Digite para buscar um categoria",
        allowHTML: true
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

    const monthSelector = new MonthSelector('#container-seletor-mes-ano', "#month-selector", '#opcao-selecionar-mes-ano', ".botao-seletor-mes");

    monthSelector.initMonthSelector();

    //Set transactionForm as open-close box

    const transactionForm = new ContextOpenClose('#opcao-registrar-transacao','#caixa-registrar-modal');

    transactionForm.initContextOpenClose();

    TransactionFormDealer(transactionForm, choiceConta, choiceContaDestino, choiceCategoria);

    const showHideMoneyBtn = new ShowHide('#opcao-exibir-ocultar', '.money');

    showHideMoneyBtn.initShowHide();

    const Links = new Link();

    Links.initLink();

    const formTransaction = new Form('#form-transaction', {s: 'A transação foi registrada com sucesso!', e: 'Ocorreu um erro ao registrar a transação. Tente novamente!'});

    formTransaction.initForm();
}

//Initial page load

const page = new Page();

await page.load(window.location.search, '#main-content');