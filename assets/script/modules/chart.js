import ApexCharts from '/plugin/apexcharts-bundle/dist/apexcharts.esm.js';

export default class Chart {
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

        for (let i = 1; i <= 12; i++) {
            chartData.months.push(i);
            chartData.incomes.push(data[i].incomes);
            chartData.expenses.push(-data[i].expenses);
        }

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

        for (let i = 1; i <= 12; i++) {
            chartData.months.push(i);
            chartData.incomes.push(data[i].incomes);
            chartData.expenses.push(-data[i].expenses);
        }

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
        for (let i = 1; i <= 12; i++) {
            chartData.months.push(i);
            chartData.incomes.push(data[i].incomes);
            chartData.expenses.push(-data[i].expenses);
        }

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
        let data = await fetch("/app/data/get_data.php?d=categories");
        data = await data.json();

        for (let cat of data['categories']) {
            const option = document.createElement('option');
            option.value = cat.nome_cat + `&mainCat=true`;
            option.innerText = '--- ' + cat.nome_cat;
            this.catSelect.appendChild(option);

            for (let secCat of cat.sec) {
                const option = document.createElement('option');
                option.classList.add('secCatSelect');
                option.value = secCat.id_cat;
                option.innerText = secCat.nome_cat;
                this.catSelect.appendChild(option);
            }
        }
    }

    async loadAccounts() {
        let data = await fetch("/app/data/get_data.php?d=accounts");
        data = await data.json();

        this.accounts = data['accounts'];

        for (let account of data['accounts']) {
            const option = document.createElement('option')
            option.value = account.id_con;
            option.innerText = account.conta;
            this.accountSelect.appendChild(option);
        }

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

