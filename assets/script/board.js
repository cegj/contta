import Money from "./modules/money.js"

export default function runBoardScript() {
    const lastTransactionValue = new Money(document.querySelector('#lastTransactionValue'), { setColor: true, localeCurrency: true })
}