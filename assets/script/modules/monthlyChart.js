import ApexCharts from '/plugin/apexcharts-bundle/dist/apexcharts.esm.js';

export default class MonthlyChart {
    constructor(targetSelector, accountSelectSelector, catSelectSelector, cleanBtnSelector) {
        this.target = document.querySelector(targetSelector);
        // this.currentMonth = this.setCurrentMonth();
        this.categories = this.getCategories();
        this.accounts = this.getAccounts();
        // this.accountSelect = document.querySelector(accountSelectSelector);
        // this.catSelect = document.querySelector(catSelectSelector);
        // this.cleanBtn = document.querySelector(cleanBtnSelector);

        var options = {
            series: [44, 55, 41, 17, 15],
            chart: {
            type: 'donut',
            height: 300,
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
        this.mainChart()
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
        return await response.json();
    }

    async getAccounts(){
        let response = await fetch(`/app/data/get_data.php?d=accounts`);
        return await response.json();
    }

    async mainChart() {
        // categories["categories"].forEach(async (cat) => {
        //     let response = await fetch(`/app/data/get_data.php?d=balances&category=${cat.nome_cat}&mainCat=true&month=current`)
        //     const data = await response.json();

        //     console.log(data)

        // })

        // let data = await fetch(`/app/data/get_data.php?d=balances`);
        // data = await data.json();

        // const chartData = {
        //     months: [],
        //     incomes: [],
        //     expenses: []
        // }
        // for (let i = 1; i <= 12; i++) {
        //     chartData.months.push(i);
        //     chartData.incomes.push(data[i].incomes);
        //     chartData.expenses.push(-data[i].expenses);
        // }

        // this.updateChart();
    }

    // updateChart() {
    //     this.chart.updateSeries([{
    //         name: 'Receitas',
    //         data: [5, 20, 35, 40],
    //         color: '#3e7f26'
    //     }])
    // }

    init() {
        // this.addOptionEvents = this.addOptionEvents.bind(this);
        // this.loadAccounts();
        // this.loadCategories();
        // this.addOptionEvents();
        this.mainChart();
    }
}

