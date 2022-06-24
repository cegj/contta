import Money from "./money.js";

export default class BalanceBox {
    constructor(box, value, type) {
        this.box = document.querySelector(box);
        this.value = document.querySelector(value);
        this.params = new URLSearchParams(window.location.search);
        this.type = type;
        this.init();
    }

    localeCurrency() {
        const money = new Money(this.value, { setColor: false, localeCurrency: true })
    }

    setColor() {
        if (parseFloat(this.value.innerText) >= 0) {
            this.box.classList.add("positivo");
        } else if (parseFloat(this.value.innerText) < 0) {
            this.box.classList.add("negativo");
        }
    }

    fetchValue(){
        fetch(`/app/data/get_data.php?d=monthYear`)
        .then(response => response.json())
        .then((monthYear) => {
            let fetchQuery = `d=balances&month=${+monthYear.month}&year=${+monthYear.year}`;

            if (this.params.get('categoria')){
                fetchQuery += `&category=${this.params.get('categoria')}`
            }

            if (this.params.get('conta')){
                fetchQuery += `&account=${this.params.get('conta')}`
            }

            fetch(`/app/data/get_data.php?${fetchQuery}`)
            .then((response) => response.json())
            .then((data) => {
                this.value.innerText = data[0][this.type].balance;
                this.value.dataset.loading = false;
                this.setColor();
                this.localeCurrency();    
            })})
       }

    init() {
        this.fetchValue();
    }
}