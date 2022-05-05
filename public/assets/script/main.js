import Page from './page.js';
import balanceBox from './balanceBox.js';

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