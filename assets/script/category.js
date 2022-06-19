import Form from './modules/form.js';
import Money from './modules/money.js';

export default function runCategoryScript() {
  if (document.location.search.includes('configurar=true')) {
    const formCategory = new Form('#form-category', { s: 'Categoria cadastrada ou alterada com sucesso!', e: 'Ocorreu um erro. Tente novamente!' });
    formCategory.initForm();

    // REFACTOR NEEDED!!!
    if (!!document.getElementById('apagar')) {

      const checkboxApagar = document.getElementById('apagar');
      const alertaApagar = document.getElementById('alerta-apagar');

      checkboxApagar.addEventListener('change', function () {
        if (checkboxApagar.checked) {
          alertaApagar.style.background = "#ffd0d0";
          alertaApagar.style.border = "3px solid #a40a0a";
          alertaApagar.style.boxShadow = "#a40a0a 3px 3px";


        } else {
          alertaApagar.style.background = "";
          alertaApagar.style.border = "";
          alertaApagar.style.boxShadow = "";
        }
      })
    }
  }

  document.querySelectorAll('.td-cat-principal').forEach((mainCatNameCell) => {
    const mainCatResult = new Money(mainCatNameCell.nextSibling, { setColor: true, localeCurrency: true })
  })

  document.querySelectorAll('.td-cat-secundaria').forEach((secCatNameCell) => {
    const mainCatResult = new Money(secCatNameCell.nextSibling, { setColor: true, localeCurrency: true })
  })
}