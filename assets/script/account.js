import Form from './modules/form.js';
import Money from './modules/money.js';
import StatementTable from './modules/StatementTable.js';

export default function runAccountScript() {
    if (document.location.search.includes('configurar=true')) {
        const formAccount = new Form('#form-account', { s: 'Conta cadastrada ou alterada com sucesso!', e: 'Ocorreu um erro. Tente novamente!' });
        formAccount.initForm();
    }

    if (document.location.search.includes('conta=')) {
        const statement = new StatementTable(".linha-extrato-valor", ".valor-resultado-dia-extrato", ".linha-extrato-tipo");
    }

    document.querySelectorAll('.td-conta').forEach((accountCell) => {
        if (!!+accountCell.innerText || +accountCell.innerText === 0) {
            const accountBalance = new Money(accountCell, { setColor: true, localeCurrency: true })
        }
    })
}