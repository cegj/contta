import ApexCharts from '/plugin/apexcharts-bundle/dist/apexcharts.esm.js';

export default class MonthlyChart {
    constructor(targetSelector, accountSelectSelector, catSelectSelector, cleanBtnSelector) {
        this.target = document.querySelector(targetSelector);
        this.accountSelect = document.querySelector(accountSelectSelector);
        this.catSelect = document.querySelector(catSelectSelector);
        this.cleanBtn = document.querySelector(cleanBtnSelector);

        var options = {
            chart: {
                height: 350,
                type: 'area',
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
        let data = await fetch(`/app/data/get_data.php?d=balances&category=${category}&day=all&month=current`);
        data = await data.json();

        const chartData = {
            days: [],
            balances: []
        }

        data.forEach((d) => {
            chartData.days.push(d.day);
            chartData.balances.push(d.ofmonth.balance);
        })

        this.updateChart(chartData);
    }

    async accountChart(account) {
        let data = await fetch(`/app/data/get_data.php?d=balances&account=${account}&day=all&month=current`);
        data = await data.json();

        const chartData = {
            days: [],
            balances: []
        }

        data.forEach((d) => {
            chartData.days.push(d.day);
            chartData.balances.push(d.ofall.balance);
        })

        this.updateChart(chartData);
    }

    async mainChart() {
        let data = await fetch(`/app/data/get_data.php?d=balances&day=all&month=current`);
        data = await data.json();

        const chartData = {
            days: [],
            balances: []
        }

        data.forEach((d) => {
            chartData.days.push(d.day);
            chartData.balances.push(d.ofall.balance);
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
            name: 'Saldo',
            data: chartData.balances,
            color: '#828282'
        },
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

