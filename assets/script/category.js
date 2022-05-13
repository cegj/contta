import Form from './modules/form.js';

export default function runCategoryScript(){
    if (document.location.search.includes('configurar=true')){
        const formCategory = new Form('#form-category', {s: 'Categoria cadastrada ou alterada com sucesso!', e: 'Ocorreu um erro. Tente novamente!'});
        formCategory.initForm();
    }
}