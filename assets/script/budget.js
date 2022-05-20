import BudgetTable from "./modules/budgetTable.js";

export default function runBudgetScript(){
    
  const budget = new BudgetTable('.table-container', "#container-alteracao-orcamento");

  budget.initBudgetTable();

}