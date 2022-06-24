import ApexCharts from '/plugin/apexcharts-bundle/dist/apexcharts.esm.js';

export default class CategoriesChart {
    constructor(targetSelector) {
      this.target = document.querySelector(targetSelector);
      var options = {
        series: [],
        labels: [],
        chart: {
        type: 'donut',
        height: 300,
      },
      noData: {
        text: 'Carregando...'
      },
      responsive: [{
        breakpoint: 640,
        options: {
          chart: {
            height: 400
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
                if (d.category !== 'Receitas' || d.category !== 'Categorias-padrão'){
                  chartData.category.push(d.category);
                  chartData.balance.push((d.ofmonth.balance === 0) ? 0 : -(d.ofmonth.balance));  
                }
            })
        })

        this.updateChart(chartData);
    }

    updateChart(chartData) {
      this.chart.updateOptions({
            series: chartData.balance,
            labels: chartData.category
      })
      this.chart.render();
    }

    init() {
        this.mainChart();
    }
}

