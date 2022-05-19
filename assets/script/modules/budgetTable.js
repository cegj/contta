export default class BudgetTable{
    constructor(tableSelector){
        this.table = document.querySelector(tableSelector);
        this.rows = this.table.querySelectorAll('tr');
        this.cells = this.table.querySelectorAll('td');
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

    bindEvents(){

    }

    initBudgetTable(){
        this.calculateCatResult();
    }
}