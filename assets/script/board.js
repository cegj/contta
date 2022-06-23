import Money from "./modules/money.js";
import YearlyChart from "./modules/yearlyChart.js";
import MonthlyChart from "./modules/monthlyChart.js";

export default function runBoardScript() {
    const lastTransactionValue = new Money(document.querySelector('#lastTransactionValue'), { setColor: true, localeCurrency: true })

    const yearlyChart = new YearlyChart('#yearlyChart', '#accountSelect', '#catSelect', '#cleanChartBtn');
    yearlyChart.init();

    const monthlyChart = new MonthlyChart('#monthlyChart', '#accountSelect', '#catSelect', '#cleanChartBtn');
    monthlyChart.init();
}