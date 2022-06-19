import Money from "./modules/money.js";
import Chart from "./modules/chart.js";

export default function runBoardScript() {
    const lastTransactionValue = new Money(document.querySelector('#lastTransactionValue'), { setColor: true, localeCurrency: true })

    const chart = new Chart('#chart', '#accountSelect', '#catSelect', '#cleanChartBtn');
    chart.init();
}