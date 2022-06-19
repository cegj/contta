import Money from "./money.js";

export default class BalanceBox {
    constructor(box, value) {
        this.box = document.querySelector(box);
        this.value = document.querySelector(value);
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

    init() {
        this.setColor();
        this.localeCurrency();
    }
}