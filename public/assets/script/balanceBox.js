export default class balanceBox {
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

// caixaSaldoMes = document.getElementById("saldo-mes");
// caixaSaldoAcumulado = document.getElementById("saldo-acumulado");
// caixaSaldoGeral = document.getElementById("saldo-geral");
// valorMes = document.getElementById("valor-mes");
// valorAcumulado = document.getElementById("valor-acumulado");
// valorGeral = document.getElementById("valor-geral");

// if (parseFloat(valorMes.innerText) >= 0) {
//     caixaSaldoMes.classList.add("positivo");
// } else if (parseFloat(valorMes.innerText) < 0) {
//     caixaSaldoMes.classList.add("negativo");
// }

// if (parseFloat(valorAcumulado.innerText) >= 0) {
//     caixaSaldoAcumulado.classList.add("positivo");
// } else if (parseFloat(valorAcumulado.innerText) < 0) {
//     caixaSaldoAcumulado.classList.add("negativo");
// }

// if (parseFloat(valorGeral.innerText) >= 0) {
//     caixaSaldoGeral.classList.add("positivo");
// } else if (parseFloat(valorGeral.innerText) < 0) {
//     caixaSaldoGeral.classList.add("negativo");
// }