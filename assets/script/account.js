import Form from './modules/form.js';
import Money from './modules/money.js';

export default function runAccountScript() {
    if (document.location.search.includes('configurar=true')) {
        const formAccount = new Form('#form-account', { s: 'Conta cadastrada ou alterada com sucesso!', e: 'Ocorreu um erro. Tente novamente!' });
        formAccount.initForm();
    }


    document.querySelectorAll('.td-conta').forEach((accountCell) => {
        if (!!+accountCell.innerText || +accountCell.innerText === 0) {
            console.log(accountCell)
            const accountBalance = new Money(accountCell, { setColor: true, localeCurrency: true })
        }
    })
}