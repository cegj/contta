import Form from "./form.js";

export default class BudgetTable{
    constructor(tableContainerSelector, editContainerSelector){
        this.tableContainer = document.querySelector(tableContainerSelector);
        this.table = document.querySelector('table');
        this.rows = this.table.querySelectorAll('tr');
        this.cells = this.table.querySelectorAll('td');
        this.editContainer = document.querySelector(editContainerSelector);
        this.editForm = this.editContainer.querySelector('form');

    }

    hideUnselectedMonthsOnMobile(){
        if (screen.width < 640) {

            this.table.querySelectorAll('[data-type="month-title"]').forEach((e) => {
                e.style.display = "none";
            })

            const prevExecTitleCells = this.table.querySelectorAll('[data-prev-exec-month]');
            for (let i = 2; i < prevExecTitleCells.length; i++){
                prevExecTitleCells[i].style.display = "none";
            }

            //Hide cells witch not match month selected
            this.table.querySelectorAll('[data-selected="false"').forEach((e) => {
                e.style.display = "none";
            })
        }     
    }   

    setSelectAsFirst(){
        const referenceTd = this.table.querySelector('[data-selected="true"]');

        //It sums fixed column width using first row as reference
        let fixedColumnsWidth = 0;
        this.rows[0].querySelectorAll('[data-fixed-column]').forEach((column) => {
            fixedColumnsWidth += column.offsetWidth;
        })

        this.tableContainer.scrollTo(referenceTd.offsetLeft - fixedColumnsWidth, 0);
    }

    getPtMonthName(monthNumber){

        const months = ['janeiro', 'fevereiro', 'março', 'abril', 'maio', 'junho', 'julho', 'agosto', 'setembro', 'outubro', 'novembro', 'dezembro'];

        return months[monthNumber-1];

    }

    closeEdit(){
        this.editContainer.style.display = "none";
    }

    openEdit(event){
        const catNameSpan = this.editForm.querySelector('#nome-cat-label');
        const monthNameSpan = this.editForm.querySelector('#mes-label');
        const monthName = this.getPtMonthName(+(event.target.dataset.month.replace(/\d{4}_(\d+)/g, '$1')));

        event.target.style.backgroundColor = "lightgray";
        catNameSpan.innerText = event.target.dataset.catName;
        this.editForm['campo-categoria'].value = event.target.dataset.catId;
        this.editForm['campo-mes'].value = event.target.dataset.month;
        this.editForm['campo-valor'].value = event.target.innerText;
        this.editContainer.style.display = "block";

        this.editContainer.querySelector('#botao-copiar').addEventListener('click', () => {
            this.editForm['campo-valor'].value = event.target.nextSibling.innerText;
        });
        this.editContainer.querySelector('#botao-cancelar').addEventListener('click', this.closeEdit);

        const form = new Form('#' + this.editForm.id, {s: 'Valor alterado com sucesso', e: 'Não foi possível alterar o valor, tente novamente'});

        form.initForm();
    }

    localeCurrency(customSelector, customStyle, customLanguage, customCurrency){
        const elements = customSelector ? document.querySelectorAll(customSelector) : this.cells;
        const language = customLanguage ? customLanguage : 'pt-BR';
        const currency = customCurrency ? customCurrency : 'BRL';
        const style = customStyle ? customStyle : 'decimal';
        
        elements.forEach((e) => {
            if (!!+e.innerText){
                const number = +e.innerText;
                e.innerText = number.toLocaleString(language, { style: style, minimumFractionDigits: 2, maximumFractionDigits: 2, currency: currency});
            }
        })
    }

    calculateCatResult(){
        this.rows.forEach((row) => {
            let planValue;
            let execValue;                
            const resultCell = row.querySelector('[data-type="cat-result"]');
            const selectedCells = row.querySelectorAll('[data-selected="true"]');

            selectedCells.forEach((cell) => {
                    if (cell.dataset.type === "plan") planValue = +cell.innerText;
                    if (cell.dataset.type === "exec") execValue = +cell.innerText;
            }            
            )

            if (resultCell !== null){
                resultCell.innerText = (execValue - planValue).toFixed(2); 
            }
        })
    }

    addEvents(){
        this.table.querySelectorAll('[data-type="plan"]').forEach((planCell) => {
            planCell.addEventListener('dblclick', this.openEdit);
        })
    }

    bindEvents(){
        this.openEdit = this.openEdit.bind(this);
        this.closeEdit = this.closeEdit.bind(this);
    }

    initBudgetTable(){
        this.bindEvents();
        this.addEvents();
        this.calculateCatResult();
        this.localeCurrency();
        this.setSelectAsFirst();
        this.hideUnselectedMonthsOnMobile();
    }
}