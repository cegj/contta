import Money from "./money.js";
export default class StatementTable {
    constructor(lineBalanceCellsSelec, dailyBalanceCellsSelec, transTypeCellSelec) {
        this.lineBalanceCells = document.querySelectorAll(lineBalanceCellsSelec);
        this.dailyBalanceCells = document.querySelectorAll(dailyBalanceCellsSelec);
        this.transTypeCellSelec = document.querySelectorAll(transTypeCellSelec);

        this.init();
    }

    setLineBalance() {
        this.lineBalanceCells.forEach((lineValueCell) => {
            const statementLineResult = new Money(lineValueCell, { setColor: true, localeCurrency: true })
        });
    }

    setDailyBalance() {
        this.dailyBalanceCells.forEach((resultDayCell) => {
            const statementLineResult = new Money(resultDayCell.childNodes[1], { setColor: false, localeCurrency: true })
        })
    }

    setTransactionType() {
        this.transTypeCellSelec.forEach((transTypeCell) => {
            if (transTypeCell.innerText === "D") {
                transTypeCell.style.color = "#AD2F1B";
                transTypeCell.style.backgroundColor = "#FCEEF4";
                transTypeCell.style.borderRadius = "0 15px 15px 0";

            }
            if (transTypeCell.innerText === "R") {
                transTypeCell.style.color = "#3E7F26";
                transTypeCell.style.backgroundColor = "#e5ffe7";
                transTypeCell.style.borderRadius = "0 15px 15px 0";
            }
            if (transTypeCell.innerText === "T") {
                transTypeCell.style.color = "#264b7f";
                transTypeCell.style.backgroundColor = "#e7f1ff";
                transTypeCell.style.borderRadius = "0 15px 15px 0";
            }
        })
    }

    init() {
        this.setLineBalance();
        this.setDailyBalance();
        this.setTransactionType();
    }
}