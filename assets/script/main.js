import Page from './modules/page.js';
import BalanceBox from './modules/balanceBox.js';
import MonthSelector from './modules/monthSelector.js';
import ContextOpenClose from './modules/contextOpenClose.js';
import TransactionFormDealer from './modules/transactionForm.js';
import ShowHide from './modules/showHide.js';
import Link from './modules/link.js';
import Form from './modules/form.js';
import runCategoryScript from './category.js';
import runAccountScript from './account.js';
import runBudgetScript from './budget.js';

export default async function runMainScript() {

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

    const monthBalance = new BalanceBox('#saldo-mes', '#valor-mes');

    monthBalance.setColor();

    const acumulatedBalance = new BalanceBox('#saldo-acumulado', '#valor-acumulado');

    acumulatedBalance.setColor();

    const generalBalance = new BalanceBox('#saldo-geral', '#valor-geral');

    generalBalance.setColor();

    //Set monthSelector as open-close box

    const monthSelector = new MonthSelector('#container-seletor-mes-ano', "#month-selector", '#opcao-selecionar-mes-ano', ".botao-seletor-mes");

    monthSelector.initMonthSelector();

    //Set transactionForm as open-close box

    const transactionForm = new ContextOpenClose('#opcao-registrar-transacao', '#caixa-registrar-modal');

    transactionForm.initContextOpenClose();

    TransactionFormDealer(transactionForm, choiceConta, choiceContaDestino, choiceCategoria);

    const showHideMoneyBtn = new ShowHide('#opcao-exibir-ocultar', '[data-showhide]');

    showHideMoneyBtn.initShowHide();

    const Links = new Link();

    Links.initLink();

    const formTransaction = new Form('#form-transaction', { s: 'A transação foi registrada ou alterada com sucesso!', e: 'Ocorreu um erro ao registrar a transação. Tente novamente!' });

    formTransaction.initForm();

    if (document.location.search.includes('p=category')) {
        runCategoryScript();
    }

    if (document.location.search.includes('p=account')) {
        runAccountScript();
    }

    if (document.location.search.includes('p=budget')) {
        runBudgetScript();
    }
}

//Initial page load

fetch('/app/function/database/there_is_no_table.php')
    .then(res => res.text())
    .then(there_is_no_table => {
        if (there_is_no_table === 'true') {
            window.location.href = '/app/setup/setup.php'
        } else {
            (async function firstload() {
                const page = new Page();
                await page.load(window.location.search, '#main-content');
                page.setBrowserPrevNext();
            })();
        }
    })