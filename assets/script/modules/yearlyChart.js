import ApexCharts from '/plugin/apexcharts-bundle/dist/apexcharts.esm.js';

export default class YearlyChart {
    constructor(targetSelector, accountSelectSelector, catSelectSelector, cleanBtnSelector) {
        this.target = document.querySelector(targetSelector);
        this.accountSelect = document.querySelector(accountSelectSelector);
        this.catSelect = document.querySelector(catSelectSelector);
        this.cleanBtn = document.querySelector(cleanBtnSelector);

        var options = {
            chart: {
                height: 350,
                type: 'line',
            },
            dataLabels: {
                enabled: false
            },
            series: [],
            noData: {
                text: 'Carregando...'
            },
            stroke: {
                width: 3
            }
        }

        this.chart = new ApexCharts(this.target, options);
        this.chart.render();
    }

    async categoryChart(category) {
        let data = await fetch(`/app/data/get_data.php?d=balances&category=${category}`);
        data = await data.json();

        const chartData = {
            months: [],
            incomes: [],
            expenses: []
        }

        data.forEach((d) => {
            chartData.months.push(d.month);
            chartData.incomes.push(d.incomes);
            chartData.expenses.push(-d.expenses);
        })

        this.updateChart(chartData);
    }

    async accountChart(account) {
        let data = await fetch(`/app/data/get_data.php?d=balances&account=${account}`);
        data = await data.json();

        const chartData = {
            months: [],
            incomes: [],
            expenses: []
        }

        data.forEach((d) => {
            chartData.months.push(d.month);
            chartData.incomes.push(d.incomes);
            chartData.expenses.push(-d.expenses);
        })

        this.updateChart(chartData);
    }

    async mainChart() {
        let data = await fetch(`/app/data/get_data.php?d=balances`);
        data = await data.json();

        const chartData = {
            months: [],
            incomes: [],
            expenses: []
        }

        data.forEach((d) => {
            chartData.months.push(d.month);
            chartData.incomes.push(d.incomes);
            chartData.expenses.push(-d.expenses);
        })

        this.updateChart(chartData);
    }

    addOptionEvents() {

        this.accountSelect.addEventListener('change', (e) => {
            this.catSelect.selectedIndex = 0;

            if (e.target.value === "false") {
                this.mainChart();
            } else {
                this.accountChart(e.target.value);
            }

        })

        this.catSelect.addEventListener('change', (e) => {
            this.accountSelect.selectedIndex = 0;

            if (e.target.value === "false") {
                this.mainChart();
            } else {
                this.categoryChart(e.target.value);
            }

        })

        this.cleanBtn.addEventListener('click', (e) => {
            e.preventDefault();
            this.accountSelect.selectedIndex = 0;
            this.catSelect.selectedIndex = 0;
            this.mainChart();
        })
    }

    async loadCategories() {
        let response = await fetch("/app/data/get_data.php?d=categories");
        let categories = await response.json();
        this.categories = categories;

        categories.forEach((mainCat) => {
            const option = document.createElement('option');
            option.value = mainCat.nome_cat + `&mainCat=true`;
            option.innerText = '--- ' + mainCat.nome_cat;
            this.catSelect.appendChild(option);

            mainCat.secondaries.forEach((secCat) => {
                const option = document.createElement('option');
                option.classList.add('secCatSelect');
                option.value = secCat.id_cat;
                option.innerText = secCat.nome_cat;
                this.catSelect.appendChild(option);
            })
        })
    }

    async loadAccounts() {
        let response = await fetch("/app/data/get_data.php?d=accounts");
        let accounts = await response.json();
        this.accounts = accounts;

        accounts.forEach((account) => {
            const option = document.createElement('option')
            option.value = account.id_con;
            option.innerText = account.conta;
            this.accountSelect.appendChild(option);
        })
    }

    updateChart(chartData) {
        this.chart.updateSeries([{
            name: 'Receitas',
            data: chartData.incomes,
            color: '#3e7f26'
        },
        {
            name: 'Despesas',
            data: chartData.expenses,
            color: '#ad2f1b'
        }
        ])
    }

    init() {
        this.addOptionEvents = this.addOptionEvents.bind(this);
        this.loadAccounts();
        this.loadCategories();
        this.addOptionEvents();
        this.mainChart();
    }
}

