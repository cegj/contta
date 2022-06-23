import ApexCharts from '/plugin/apexcharts-bundle/dist/apexcharts.esm.js';

export default class MonthlyChart {
    constructor(targetSelector, accountSelectSelector, catSelectSelector, cleanBtnSelector) {
        this.target = document.querySelector(targetSelector);
        // this.currentMonth = this.setCurrentMonth();
        // this.accountSelect = document.querySelector(accountSelectSelector);
        // this.catSelect = document.querySelector(catSelectSelector);
        // this.cleanBtn = document.querySelector(cleanBtnSelector);
    }

    // setCurrentMonth(){
    //     let currentMonth = ((new Date()).getMonth() + 1).toString();

    //     if (currentMonth.length === 1){
    //         return "0" + currentMonth;
    //     } else {
    //         return currentMonth;
    //     }
    // }

    async getCategories(){
        let response = await fetch(`/app/data/get_data.php?d=categories`);
        const categories = await response.json(); 
        return await categories
    }

    async getAccounts(){
        let response = await fetch(`/app/data/get_data.php?d=accounts`);
        return await response.json();
    }

    async mainChart() {
        const chartData = {
            category: [],
            balance: []
        }
        const categories = await this.getCategories();

        categories.forEach(async (cat) => {
            let response = await fetch(`/app/data/get_data.php?d=balances&category=${cat.nome_cat}&mainCat=true&month=current`)
            const data = await response.json();

            data.forEach((d) => {
                chartData.category.push(d.category);
                chartData.balance.push(-d.balance);
            })
        })

        this.renderChart(chartData);
    }

    renderChart(chartData) {
        var options = {
            series: chartData.balance,
            labels: chartData.category,
            chart: {
            type: 'donut',
            height: 300,
          },
          noData: {
            text: 'Carregando...'
          },
          responsive: [{
            breakpoint: 480,
            options: {
              chart: {
                width: 200
              },
              legend: {
                position: 'bottom'
              }
            }
          }]
          };

        this.chart = new ApexCharts(this.target, options);
        this.chart.render();
        }

    init() {
        // this.addOptionEvents = this.addOptionEvents.bind(this);
        // this.loadAccounts();
        // this.loadCategories();
        // this.addOptionEvents();
        this.mainChart();
    }
}

