import Form from './modules/form.js';

export default function runAccountScript(){
    if (document.location.search.includes('configurar=true')){
        const formAccount = new Form('#form-account', {s: 'Conta cadastrada ou alterada com sucesso!', e: 'Ocorreu um erro. Tente novamente!'});
        formAccount.initForm();
    }
}