import BudgetTable from "./modules/budgetTable.js";

export default function runBudgetScript(){
    
  const budget = new BudgetTable('.table-container', "#container-budget-edit-form");

  budget.initBudgetTable();

}