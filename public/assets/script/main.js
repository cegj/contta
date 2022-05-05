import Page from './page.js';
import balanceBox from './balanceBox.js';
import ContextOpenClose from './contextOpenClose.js';
import MonthSelector from './monthSelector.js';



//Fetch and load page

const actualPage = window.location.pathname.split('/').pop().replace(".html", "");

const page = new Page(actualPage, 'body');

await page.load();

//Set color of balance boxes according to the value

const monthBalance = new balanceBox('#saldo-mes', '#valor-mes');

monthBalance.setColor();

const acumulatedBalance = new balanceBox('#saldo-acumulado', '#valor-acumulado');

acumulatedBalance.setColor();

const generalBalance = new balanceBox('#saldo-geral', '#valor-geral');

generalBalance.setColor();

//Set monthSelector as open-close box

const monthSelector = new MonthSelector('#opcao-selecionar-mes-ano','#container-seletor-mes-ano', "#for-mes-ano", "#seletor-mes", "#seletor-campo-mes", ".botao-seletor-mes");

monthSelector.initMonthSelector();

//Set transactionForm as open-close box

const transactionForm = new ContextOpenClose('#opcao-registrar-transacao','#caixa-registrar-modal');

transactionForm.initContextOpenClose();