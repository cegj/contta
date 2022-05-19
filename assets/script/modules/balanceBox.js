export default class BalanceBox {
    constructor(box, value) {
        this.box = document.querySelector(box);
        this.value = document.querySelector(value);
    }

    setColor(){
        if (parseFloat(this.value.innerText) >= 0) {
            this.box.classList.add("positivo");
        } else if (parseFloat(this.value.innerText) < 0) {
            this.box.classList.add("negativo");
        }
    }
}